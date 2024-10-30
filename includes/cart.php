<?php
//// INIT
add_action( 'woocommerce_init', 'c4d_woo_bs_init' );
function c4d_woo_bs_init() {
  global $c4d_plugin_manager;

  // show in single page
  if (isset($c4d_plugin_manager['c4d-woo-bs-page-single-product']) && $c4d_plugin_manager['c4d-woo-bs-page-single-product'] == 1) {
    add_action( 'woocommerce_after_single_product_summary', 'c4d_woo_bs_list_product', 99 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
  }

  // show in mini cart
  if (isset($c4d_plugin_manager['c4d-woo-bs-global-mini-cart']) && $c4d_plugin_manager['c4d-woo-bs-global-mini-cart'] == 1) {
    add_action( 'woocommerce_after_mini_cart', 'c4d_woo_bs_mini_cart', 0 );
  }

  // show in cart page
  if (isset($c4d_plugin_manager['c4d-woo-bs-global-cart-page']) && $c4d_plugin_manager['c4d-woo-bs-global-cart-page'] == 1) {
    add_action( 'woocommerce_after_cart', 'c4d_woo_bs_list_product' );
  }

  // show in thankyou page
  add_action( 'woocommerce_thankyou', 'c4d_woo_bs_thankyou_page', 10);

  // show in email: process || complete order
  add_action( 'woocommerce_email_header', 'c4d_woo_bs_email_header', 10, 2 );
  add_action( 'woocommerce_email_customer_details', 'c4d_woo_bs_email_customer_details', 10, 4 );

  //// CART PAGE
  remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');

  //// UP SELL HOOK
  add_filter( 'woocommerce_upsell_display_args', 'c4d_woo_bs_upsell_display_args' );

  /// CROSS SELL HOOK
  add_filter( 'woocommerce_cross_sells_total', 'c4d_woo_bs_cross_sells_total' );
  add_filter( 'woocommerce_cross_sells_orderby', 'c4d_woo_bs_cross_sells_orderby' );
  add_filter( 'woocommerce_cross_sells_columns', 'c4d_woo_bs_cross_sells_columns' );
}

/////// FUNCTIONS
function c4d_woo_bs_mini_cart($orderId) {
  echo '<div class="c4d_woo_bs_mini_cart">';
  c4d_woo_bs_list_product($orderId);
  echo '</div>';
}

function c4d_woo_bs_replace_title_for_page_email() {
  global $c4d_plugin_manager;
  $c4d_plugin_manager['c4d-woo-bs-cross-title'] = $c4d_plugin_manager['c4d-woo-bs-email-cross-title'];
  $c4d_plugin_manager['c4d-woo-bs-cross-hide-title'] = $c4d_plugin_manager['c4d-woo-bs-email-cross-hide-title'];

  $c4d_plugin_manager['c4d-woo-bs-cross-desc'] = $c4d_plugin_manager['c4d-woo-bs-email-cross-desc'];
  $c4d_plugin_manager['c4d-woo-bs-cross-hide-desc'] = $c4d_plugin_manager['c4d-woo-bs-email-cross-hide-desc'];

  $c4d_plugin_manager['c4d-woo-bs-up-title'] = $c4d_plugin_manager['c4d-woo-bs-email-up-title'];
  $c4d_plugin_manager['c4d-woo-bs-up-hide-title'] = $c4d_plugin_manager['c4d-woo-bs-email-up-hide-title'];

  $c4d_plugin_manager['c4d-woo-bs-up-desc'] = $c4d_plugin_manager['c4d-woo-bs-email-up-desc'];
  $c4d_plugin_manager['c4d-woo-bs-up-hide-desc'] = $c4d_plugin_manager['c4d-woo-bs-email-up-hide-desc'];
}

function c4d_woo_bs_thankyou_page($orderId) {
  global $c4d_plugin_manager;
  if (isset($c4d_plugin_manager['c4d-woo-bs-global-thankyou-page']) && $c4d_plugin_manager['c4d-woo-bs-global-thankyou-page'] == 1) {
    c4d_woo_bs_replace_title_for_page_email();
    c4d_woo_bs_list_product($orderId);
  }
}

function c4d_woo_bs_email_header($email_heading, $email) {
  if (c4d_woo_bs_is_email_pages($email)){
    $file = dirname(plugin_dir_path( __FILE__) ) . '/assets/default.css';
    if (file_exists($file)) {
      $css = file_get_contents($file);
      if ($css) {
        echo '<style class="c4d-woo-bs">'.$css.'</style>';
      }
    }
  }
}

function c4d_woo_bs_is_email_pages($email) {
  $pages = array(
    'WC_Email_Customer_Completed_Order',
    'WC_Email_Customer_Processing_Order',
    'WC_Email_Customer_Note',
  );
  if (in_array(get_class($email), $pages)) {
    return true;
  }
  return false;
}

function c4d_woo_bs_email_customer_details($order, $sent_to_admin, $plain_text, $email) {
  if (c4d_woo_bs_is_email_pages($email)) {
    // replace title/desc for email page
    c4d_woo_bs_replace_title_for_page_email();

    echo '<div class="c4d_woo_bs_email_wrap">';
    c4d_woo_bs_list_product($order->get_id());
    echo '</div>';
  }
}

function c4d_woo_bs_cross_sells_total($params) {
  global $c4d_plugin_manager;
  if (isset($c4d_plugin_manager['c4d-woo-bs-cross-limit'])) {
    return $c4d_plugin_manager['c4d-woo-bs-cross-limit'];
  }
  return $params;
}

function c4d_woo_bs_cross_sells_orderby($params) {
  global $c4d_plugin_manager;
  if (isset($c4d_plugin_manager['c4d-woo-bs-cross-order'])) {
    return $c4d_plugin_manager['c4d-woo-bs-cross-order'];
  }
  return $params;
}

function c4d_woo_bs_cross_sells_columns($params) {
  global $c4d_plugin_manager;
  if (isset($c4d_plugin_manager['c4d-woo-bs-cross-column'])) {
    return $c4d_plugin_manager['c4d-woo-bs-cross-column'];
  }
  return $params;
}

function c4d_woo_bs_upsell_display_args($params) {
  global $c4d_plugin_manager;
  if (isset($c4d_plugin_manager['c4d-woo-bs-up-limit'])) {
    $params['posts_per_page'] = $c4d_plugin_manager['c4d-woo-bs-up-limit'];
  }
  if (isset($c4d_plugin_manager['c4d-woo-bs-up-column'])) {
    $params['columns'] = $c4d_plugin_manager['c4d-woo-bs-up-column'];
  }
  if (isset($c4d_plugin_manager['c4d-woo-bs-up-order'])) {
    $params['orderby'] = $c4d_plugin_manager['c4d-woo-bs-up-order'];
  }
  return $params;
}

function c4d_woo_bs_list_product($orderId = false) {
  global $c4d_plugin_manager;
  $c4d_plugin_manager['c4d_woo_bs_category_tag_one_time'] = false;
  $type = isset($c4d_plugin_manager['c4d-woo-bs-global-show-type']) ? $c4d_plugin_manager['c4d-woo-bs-global-show-type'] : 0;

  if ($type == 0) {
    echo '<div class="c4d_woo_bs_wrap">';
    if (in_array($type, array('crosssell', 'upsell&crosssell'))) {
      $products = c4d_woo_bs_cross_get_srouces($orderId);
      c4d_woo_bs_get_cross_sell($products);
    }

    // if product is not set the up/cross sell, plugin will get the product in same category,
    // so it will be duplicate so only display one time.
    if ($c4d_plugin_manager['c4d_woo_bs_category_tag_one_time'] == false) {
      if (in_array($type, array('upsell', 'upsell&crosssell'))) {
        $products = c4d_woo_bs_up_get_srouces($orderId);
        c4d_woo_bs_get_up_sell_from_cart($products);
      }
    }

    echo '</div>';
  }
}

function c4d_woo_bs_get_product_from_order($orderId, $type = 'upsell'){
  $order = wc_get_order($orderId);
  $items = $order->get_items();
  $ids = array();

  foreach ($items as $key => $item) {
    if ($type == 'upsell') {
      $ids = array_merge( $item->get_product()->get_upsell_ids(), $ids );
    } else {
      $ids = array_merge( $item->get_product()->get_cross_sell_ids(), $ids );
    }
  }
  return $ids;
}

function c4d_woo_bs_get_product_from_category($orderId = null, $type = 'upsell'){
  global $c4d_plugin_manager, $product;
  $products = array();
  $category_ids = array();
  $category_slugs = array();
  $excludes = array();

  if (is_product()) {
    $pid = method_exists('get_parent_id', $product) ? $product->get_parent_id() : 0;
    $pid = $pid ? $pid : $product->get_id();
    $data = c4d_woo_bs_get_data($pid, 'category');
    
    if (isset($data[$type]) && $data[$type] !== '') {
      $category_slugs = array_merge(array_map('trim', explode(',', $data[$type])), $category_slugs);
    }
    if (count($category_slugs) < 1) {
      $category_ids = array_merge($product->get_category_ids(), $category_ids);
      $excludes[] = $product->get_id();
    }
  } else if (!WC()->cart->is_empty()) {
    foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
      if ( $values['quantity'] > 0 ) {
        // check category of products first
        $pid = method_exists('get_parent_id', $values['data']) ? $values['data']->get_parent_id() : 0;
        $pid = $pid ? $pid : $values['data']->get_id();
        
        // get up/cross sell for category/tag in product
        $data = c4d_woo_bs_get_data($pid, 'category');
        if (isset($data[$type]) && $data[$type] !== '') {
          $category_slugs = array_merge(array_map('trim', explode(',', $data[$type])), $category_slugs);
        }

        // if product is not set category/tag for up/cross sell, then check the product's categories
        if (count($category_slugs) < 1) {
          // get product has sampe product's category for cross/up sell
          $product = wc_get_product($pid);
          $category_ids = array_merge($product->get_category_ids(), $category_ids);
          $excludes[] = $product->get_id();
        }
      }
    }
  } else {
    $order = wc_get_order($orderId);
    if ($order) {
      $items = $order->get_items();
      $ids = array();

      foreach ($items as $key => $item) {
        $product = $item->get_product();
        if ($product) {
          $pid = $product->get_parent_id();
          $pid = $pid ? $pid : $product->get_id();
          $data = c4d_woo_bs_get_data($pid, 'category');
          if (isset($data[$type]) && $data[$type] !== '') {
            $category_slugs = array_merge(array_map('trim', explode(',', $data[$type])), $category_slugs);
          }
          if (count($category_slugs) < 1) {
            $category_ids = array_merge($product->get_category_ids(), $category_ids);
            $excludes[] = $product->get_id();
          }
        }
      }
    }
  }
  
  // get up/cross sell for category/tag when create category/tag
  if (count($category_ids) > 0) {
    $c4d_plugin_manager['c4d_woo_bs_category_tag_one_time'] = true;
    foreach($category_ids as $id) {
      $category_is_set = get_term_meta( $id, $type, true );
      if ($category_is_set) {
        $category_slugs = array_merge(array_map('trim', explode(',', $category_is_set)), $category_slugs);
        $c4d_plugin_manager['c4d_woo_bs_category_tag_one_time'] = false;
      }
    }
  }
  
  $args = array(
    'exclude'               => $excludes,
    'post_type'             => 'product',
    'post_status'           => 'publish',
    'ignore_sticky_posts'   => 1,
    'posts_per_page'        => $type == 'upsell' ?  $c4d_plugin_manager['c4d-woo-bs-up-limit'] : $c4d_plugin_manager['c4d-woo-bs-cross-limit'],
  );

  if (count($category_slugs) > 0) {
    $args['category'] = $category_slugs;
  } else if (count($category_ids) > 0) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'product_cat',
        'field' => 'id',
        'terms' => $category_ids,
        'operator' => 'IN',
      )
    );
  }

  if (count($category_slugs) > 0 || count($category_ids) > 0 ) {
    $products = wc_get_products($args);
  }

  return $products;
}

function c4d_woo_bs_get_product_from_tags($orderId = null, $type = 'upsell'){
  global $c4d_plugin_manager, $product;
  $products = array();
  $tag_ids = array();
  $tag_slugs = array();
  $excludes = array();

  if (is_product()) {
    $pid = method_exists('get_parent_id', $product) ? $product->get_parent_id() : 0;
    $pid = $pid ? $pid : $product->get_id();
    $data = c4d_woo_bs_get_data($pid, 'tags');
    
    if (isset($data[$type]) && $data[$type] !== '') {
      $tag_slugs = array_merge(array_map('trim', explode(',', $data[$type])), $tag_slugs);
    }

    if (count($tag_slugs) < 1) {
      $product = wc_get_product($pid);
      if ($product) {
        $tag_ids = array_merge($product->get_tag_ids(), $tag_ids);
        $excludes[] = $product->get_id();
      }
    }
  }  else if (!WC()->cart->is_empty()) {
    foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
      if ( $values['quantity'] > 0 ) {
        $pid = method_exists('get_parent_id', $values['data']) ? $values['data']->get_parent_id() : 0;
        $pid = $pid ? $pid : $values['data']->get_id();
        $data = c4d_woo_bs_get_data($pid, 'tags');

        if (isset($data[$type]) && $data[$type] !== '') {
          $tag_slugs = array_merge(array_map('trim', explode(',', $data[$type])), $tag_slugs);
        }

        if (count($tag_slugs) < 1) {
          $product = wc_get_product($pid);
          if ($product) {
            $tag_ids = array_merge($product->get_tag_ids(), $tag_ids);
            $excludes[] = $product->get_id();
          }
        }
      }
    }
  } else {
    $order = wc_get_order($orderId);
    if ($order) {
      $items = $order->get_items();
      $ids = array();

      foreach ($items as $key => $item) {
        $product = $item->get_product();
        if ($product) {
          $pid = $product->get_parent_id();
          $pid = $pid ? $pid : $product->get_id();
          $data = c4d_woo_bs_get_data($pid, 'tags');

          if (isset($data[$type]) && $data[$type] !== '') {
            $tag_slugs = array_merge(array_map('trim', explode(',', $data[$type])), $tag_slugs);
          }

          if (count($tag_slugs) < 1) {
            $tag_ids = array_merge($product->get_tag_ids(), $tag_ids);
            $excludes[] = $product->get_id();
          }
        }
      }
    }
  }

  // get up/cross sell for category/tag when create tag
  if (count($tag_ids) > 0) {
    $c4d_plugin_manager['c4d_woo_bs_category_tag_one_time'] = true;
    foreach($tag_ids as $id) {
      $tag_is_set = get_term_meta( $id, $type, true );
      if ($tag_is_set) {
        $tag_slugs = array_merge(array_map('trim', explode(',', $tag_is_set)), $tag_slugs);
        $c4d_plugin_manager['c4d_woo_bs_category_tag_one_time'] = false;
      }
    }
  }

  $args = array(
    'exclude'               => $excludes,
    'post_type'             => 'product',
    'post_status'           => 'publish',
    'ignore_sticky_posts'   => 1,
    'posts_per_page'        => $type == 'upsell' ?  $c4d_plugin_manager['c4d-woo-bs-up-limit'] : $c4d_plugin_manager['c4d-woo-bs-cross-limit'],
  );

  if (count($tag_slugs) > 0) {
    $args['tag'] = $tag_slugs;
  } else if (count($tag_ids) > 0) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'product_tag',
        'field' => 'id',
        'terms' => $tag_ids,
        'operator' => 'IN',
      )
    );
  }

  if (count($tag_slugs) > 0 || count($tag_ids)) {
    $products = wc_get_products($args);
  }

  return $products;
}

function c4d_woo_bs_cross_get_srouces($orderId) {
  global $c4d_plugin_manager, $product;
  $ids = array();
  $products = array();
  
  // product setting , up sell, cross sell,
  if (is_product()) {
    $ids = array_merge( $product->get_cross_sell_ids(), $ids );
  } else if (!WC()->cart->is_empty()) {
    $ids = WC()->cart->get_cross_sells();
  } else {
    $ids = c4d_woo_bs_get_product_from_order($orderId, 'crosssell');
  }

  if (count($ids) > 0) {
    $products = array_filter( array_map( 'wc_get_product', $ids ), 'wc_products_array_filter_visible' );
  }

  if (count($ids) < 1) {
    $products = c4d_woo_bs_get_product_from_category_tags($orderId, 'crosssell');
  }

  return $products;
}

function c4d_woo_bs_get_cross_sell($products = array()) {
  global $c4d_plugin_manager;

  if (count($products) > 0) {
    $title = isset($c4d_plugin_manager['c4d-woo-bs-cross-title']) && $c4d_plugin_manager['c4d-woo-bs-cross-title'] != '' ?  $c4d_plugin_manager['c4d-woo-bs-cross-title'] : esc_html__('Cross Sell', 'c4d-woo-bs');
    if (isset($c4d_plugin_manager['c4d-woo-bs-cross-hide-title']) && $c4d_plugin_manager['c4d-woo-bs-cross-hide-title'] == 1) {
      $title = '';
    }
    $desc = isset($c4d_plugin_manager['c4d-woo-bs-cross-desc']) ?  $c4d_plugin_manager['c4d-woo-bs-cross-desc'] : '';
    if (isset($c4d_plugin_manager['c4d-woo-bs-cross-hide-desc']) && $c4d_plugin_manager['c4d-woo-bs-cross-hide-desc'] == 1) {
      $desc = '';
    }

    echo '<div class="c4d_woo_bs_cross_sell">';
    if ($title) {
      echo '<h3 class="block_title">'.$title.'</h3>';
    }
    if ($desc) {
      echo '<div class="block_desc">'.$desc.'</div>';
    }

    // Get visible cross sells then sort them at random.

    $limit = 4; $columns = 4; $orderby = 'rand'; $order = 'desc';

    wc_set_loop_prop( 'name', 'cross-sells' );
    wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_cross_sells_columns', $columns ) );

    // Handle orderby and limit results.
    $orderby     = apply_filters( 'woocommerce_cross_sells_orderby', $orderby );
    $order       = apply_filters( 'woocommerce_cross_sells_order', $order );
    $products    = wc_products_array_orderby( $products, $orderby, $order );
    $limit       = apply_filters( 'woocommerce_cross_sells_total', $limit );
    $products    = $limit > 0 ? array_slice( $products, 0, $limit ) : $products;

    wc_get_template(
      'cart/cross-sells.php',
      array(
        'cross_sells'    => $products,

        // Not used now, but used in previous version of up-sells.php.
        'posts_per_page' => $limit,
        'orderby'        => $orderby,
        'columns'        => $columns,
      )
    );

    echo '</div>';
  }
}

function c4d_woo_bs_get_product_from_category_tags($orderId, $type = 'upsell') {
  global $c4d_plugin_manager;
  $products = array();
  // if product does not set crosssell/upsell, then get from tags
  if (isset($c4d_plugin_manager['c4d-woo-bs-global-source-tags']) && isset($c4d_plugin_manager['c4d-woo-bs-global-source-tags']) == 1) {
    $ptags = c4d_woo_bs_get_product_from_tags($orderId, $type);
    if (count($ptags) > 0) {
      return $ptags;
    }
  }

  // if product does not set crosssell/upsell, then get from category
  if (isset($c4d_plugin_manager['c4d-woo-bs-global-source-category']) && isset($c4d_plugin_manager['c4d-woo-bs-global-source-category']) == 1) {
    $pcategory = c4d_woo_bs_get_product_from_category($orderId, $type);
    if (count($pcategory) > 0) {
      return $pcategory;
    }
  }

  return $products;
}

function c4d_woo_bs_up_get_srouces($orderId) {
  global $c4d_plugin_manager, $product;
  $ids = array();
  $products = array();
  $cart = WC()->cart;
  
  if (is_product()) {
    $ids = array_merge( $product->get_upsell_ids(), $ids );
  } else if ( !$cart->is_empty() ) {
    $in_cart     = array();
    foreach ( $cart->get_cart() as $cart_item_key => $values ) {
      if ( $values['quantity'] > 0 ) {
        $ids = array_merge( $values['data']->get_upsell_ids(), $ids );
        $in_cart[]   = $values['product_id'];
      }
    }
    $ids = array_diff( $ids, $in_cart );
  } else {
    $ids = c4d_woo_bs_get_product_from_order($orderId, 'upsell');
  }

  if (count($ids) > 0) {
    $products = array_filter( array_map( 'wc_get_product', $ids ), 'wc_products_array_filter_visible' );
  }

  if (count($ids) < 1) {
    $products = c4d_woo_bs_get_product_from_category_tags($orderId, 'upsell');
  }

  return $products;
}

function c4d_woo_bs_get_up_sell_from_cart($products = array()) {
  global $c4d_plugin_manager;

  if (count($products) > 0 ){
    $title = isset($c4d_plugin_manager['c4d-woo-bs-up-title']) && $c4d_plugin_manager['c4d-woo-bs-up-title'] != '' ?  $c4d_plugin_manager['c4d-woo-bs-up-title'] : esc_html__('Up Sell', 'c4d-woo-bs');
    if (isset($c4d_plugin_manager['c4d-woo-bs-up-hide-title']) && $c4d_plugin_manager['c4d-woo-bs-up-hide-title'] == 1) {
      $title = '';
    }
    $desc = isset($c4d_plugin_manager['c4d-woo-bs-up-desc']) && $c4d_plugin_manager['c4d-woo-bs-up-desc'] != '' ?  $c4d_plugin_manager['c4d-woo-bs-up-desc'] : '';

    if (isset($c4d_plugin_manager['c4d-woo-bs-up-hide-desc']) && $c4d_plugin_manager['c4d-woo-bs-up-hide-desc'] == 1) {
      $desc = '';
    }

    echo '<div class="c4d_woo_bs_up_sell">';
    if ($title) {
      echo '<h3 class="block_title">'.$title.'</h3>';
    }
    if ($desc) {
      echo '<div class="block_desc">'.$desc.'</div>';
    }

    // default params
    $limit = '-1'; $columns = 4; $orderby = 'rand'; $order = 'desc';

    // Handle the legacy filter which controlled posts per page etc.
    $args = apply_filters(
        'woocommerce_upsell_display_args',
        array(
            'posts_per_page' => $limit,
            'orderby'        => $orderby,
            'columns'        => $columns,
        )
    );

    wc_set_loop_prop( 'name', 'up-sells' );
    wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_upsells_columns', isset( $args['columns'] ) ? $args['columns'] : $columns ) );

    $orderby = apply_filters( 'woocommerce_upsells_orderby', isset( $args['orderby'] ) ? $args['orderby'] : $orderby );
    $limit   = apply_filters( 'woocommerce_upsells_total', isset( $args['posts_per_page'] ) ? $args['posts_per_page'] : $limit );

    // Get visible upsells then sort them, then limit result set.
    $products = wc_products_array_orderby( $products, $orderby, $order );
    $products = $limit > 0 ? array_slice( $products, 0, $limit ) : $products;

    wc_get_template(
        'single-product/up-sells.php',
        array(
            'upsells'        => $products,

            // Not used now, but used in previous version of up-sells.php.
            'posts_per_page' => $limit,
            'orderby'        => $orderby,
            'columns'        => $columns,
        )
    );

    echo '</div>';
  }
}
