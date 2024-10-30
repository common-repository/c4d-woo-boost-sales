<?php
add_action( 'wp_enqueue_scripts', 'c4d_woo_bs_load_scripts_site');
add_action( 'admin_enqueue_scripts', 'c4d_woo_bs_load_scripts_admin');
add_action( 'c4d-plugin-manager-section', 'c4d_woo_bs_section_options', 1000);
add_filter( 'plugin_row_meta', 'c4d_woo_bs_plugin_row_meta', 10, 2 );
add_action( 'plugins_loaded', 'c4d_woo_bs_load_textdomain' );

function c4d_woo_bs_load_textdomain() {
  load_plugin_textdomain( 'c4d-woo-bs', false, dirname(dirname(plugin_basename( __FILE__ ))) . '/languages' );
}

function c4d_woo_bs_plugin_row_meta( $links, $file ) {
  if ('c4d-woo-boost-sales/c4d-woo-boost-sales.php' == $file){
    $new_links = array(
      'options' => '<a target="blank" href="admin.php?page=c4d-plugin-manager">Settings</a>',
      'doc' => '<a target="blank" href="http://coffee4dev.com/docs/document-c4d-woo-boost-sales/">Docs</a>',
      'demo' => '<a target="blank" href="http://demo.coffee4dev.com/product/variation-swatches/">Demo</a>',
      'pro' => '<a target="blank" href="http://coffee4dev.com/woocommerce-boost-sales/">Premium Version</a>'
    );
    if (!defined('C4DPMANAGER_PLUGIN_URI')) {
      $new_links['options'] = '<a target="blank" href="https://wordpress.org/plugins/c4d-plugin-manager/">Settings</a>';
    }
    $links = array_merge( $links, $new_links );
  }

  return $links;
}

function c4d_woo_bs_load_scripts_site() {
  wp_enqueue_script( 'c4d-woo-bs-site-js', C4DWOOBS_PLUGIN_URI . '/assets/default.js', array( 'jquery' ), false, true );
  wp_enqueue_style( 'c4d-woo-bs-site-style', C4DWOOBS_PLUGIN_URI.'/assets/default.css' );
}

function c4d_woo_bs_load_scripts_admin($hook) {
  if (in_array($hook, array('post.php', 'toplevel_page_c4d-plugin-manager'))) {
    wp_enqueue_script( 'c4d-woo-bs-admin-js', C4DWOOBS_PLUGIN_URI . '/assets/admin.js' );
    wp_enqueue_style( 'c4d-woo-bs-admin-style', C4DWOOBS_PLUGIN_URI.'/assets/admin.css' );
  }
}

function c4d_woo_bs_section_options(){
  $opt_name = 'c4d_plugin_manager';


  Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Boost Sales', 'c4d-woo-bs' ),
    'desc'             => '',
    'customizer_width' => '400px',
    'icon'             => 'el el-home',
  ));

  Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Global', 'c4d-woo-bs' ),
    'id'               => 'section-c4d-woo-bs-global',
    'desc'             => '',
    'customizer_width' => '400px',
    'icon'             => '',
    'subsection'       => true,
    'fields'           => array(
      array(
       'id' => 'c4d-woo-bs-global-section-display',
       'type' => 'section',
       'title' => __('Display', 'c4d-woo-vs'),
       'indent' => true
      ),
        array(
          'id'       => 'c4d-woo-bs-global-show-type',
          'type'     => 'button_set',
          'title'    => esc_html__('Show Up Sell & Cross Sell', 'c4d-woo-bs'),
          'options' => array(
            '0' => esc_html__('No', 'c4d-woo-bs'),
            'upsell' => esc_html__('Up Sell Only', 'c4d-woo-bs'),
            'crosssell' => esc_html__('Cross Sell Only', 'c4d-woo-bs'),
            'upsell&crosssell' => esc_html__('Up Sell & Cross Sell', 'c4d-woo-bs')
           ),
          'default' => 'upsell'
        ),
        array(
          'id'       => 'c4d-woo-bs-global-mini-cart',
          'type'     => 'button_set',
          'title'    => esc_html__('Show in Mini Cart', 'c4d-woo-bs'),
          'options' => array(
            '1' => esc_html__('Yes', 'c4d-woo-bs'),
            '0' => esc_html__('No', 'c4d-woo-bs')
           ),
          'default' => '1'
        ),
        array(
          'id'       => 'c4d-woo-bs-global-cart-page',
          'type'     => 'button_set',
          'title'    => esc_html__('Show in Cart Page', 'c4d-woo-bs'),
          'options' => array(
            '1' => esc_html__('Yes', 'c4d-woo-bs'),
            '0' => esc_html__('No', 'c4d-woo-bs')
           ),
          'default' => '1'
        ),
      array(
       'id' => 'c4d-woo-bs-global-section-source',
       'type' => 'section',
       'title' => __('Sources', 'c4d-woo-vs'),
       'indent' => true
      ),
        array(
          'id'       => 'c4d-woo-bs-global-source-category',
          'type'     => 'button_set',
          'title'    => esc_html__('Get From Category', 'c4d-woo-bs'),
          'subtitle' => esc_html__('Auto get products in sample category for up/cross sell', 'c4d-woo-bs'),
          'options' => array(
            '1' => esc_html__('Yes', 'c4d-woo-bs'),
            '0' => esc_html__('No', 'c4d-woo-bs')
           ),
          'default' => '0'
        ),
        array(
          'id'       => 'c4d-woo-bs-global-source-tags',
          'type'     => 'button_set',
          'title'    => esc_html__('Get From Tags', 'c4d-woo-bs'),
          'subtitle' => esc_html__('Auto get products in sample tags for up/cross sell', 'c4d-woo-bs'),
          'options' => array(
            '1' => esc_html__('Yes', 'c4d-woo-bs'),
            '0' => esc_html__('No', 'c4d-woo-bs')
           ),
          'default' => '0'
        ),
    )
  ));

  Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Up Sell', 'c4d-woo-bs' ),
    'id'               => 'section-c4d-woo-bs-up-sell',
    'desc'             => '',
    'customizer_width' => '400px',
    'icon'             => '',
    'subsection'       => true,
    'fields'           => array(
      array(
        'id'       => 'c4d-woo-bs-up-title',
        'type'     => 'text',
        'title'    => esc_html__('Title', 'c4d-woo-bs'),
        'default' => 'You may also like&hellip;',
      ),
      array(
        'id'       => 'c4d-woo-bs-up-hide-title',
        'type'     => 'button_set',
        'title'    => esc_html__('Hide Title', 'c4d-woo-bs'),
        'options' => array(
          '1' => esc_html__('Yes', 'c4d-woo-bs'),
          '0' => esc_html__('No', 'c4d-woo-bs')
         ),
        'default' => '0'
      ),
      array(
        'id'       => 'c4d-woo-bs-up-desc',
        'type'     => 'textarea',
        'title'    => esc_html__('Description', 'c4d-woo-bs'),
        'default' => 'Get discount code for next shopping',
      ),
      array(
        'id'       => 'c4d-woo-bs-up-hide-desc',
        'type'     => 'button_set',
        'title'    => esc_html__('Hide Description', 'c4d-woo-bs'),
        'options' => array(
          '1' => esc_html__('Yes', 'c4d-woo-bs'),
          '0' => esc_html__('No', 'c4d-woo-bs')
         ),
        'default' => '0'
      ),
      array(
        'id'       => 'c4d-woo-bs-up-limit',
        'type'     => 'text',
        'title'    => esc_html__('Number', 'c4d-woo-bs'),
        'validate' => 'number',
        'default' => 4
      ),
      array(
        'id'       => 'c4d-woo-bs-up-column',
        'type'     => 'text',
        'title'    => esc_html__('Column', 'c4d-woo-bs'),
        'validate' => 'number',
        'default' => 4
      ),
      array(
        'id'       => 'c4d-woo-bs-up-order',
        'type'     => 'button_set',
        'title'    => esc_html__('Orderby', 'c4d-woo-bs'),
        'options' => array(
          'date' => esc_html__('Date', 'c4d-woo-bs'),
          'id' => esc_html__('Id', 'c4d-woo-bs'),
          'rand' => esc_html__('Random', 'c4d-woo-bs'),
          'title' => esc_html__('Title', 'c4d-woo-bs'),
          'price' => esc_html__('Price', 'c4d-woo-bs')
         ),
        'default' => 'rand'
      )
    )
  ));

  Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Cross Sell', 'c4d-woo-bs' ),
    'id'               => 'section-c4d-woo-bs-cross-sell',
    'desc'             => '',
    'customizer_width' => '400px',
    'icon'             => '',
    'subsection'       => true,
    'fields'           => array(
      array(
        'id'       => 'c4d-woo-bs-cross-title',
        'type'     => 'text',
        'title'    => esc_html__('Title', 'c4d-woo-bs'),
        'default' => 'You may be interested in&hellip;',
      ),
      array(
        'id'       => 'c4d-woo-bs-up-cross-title',
        'type'     => 'button_set',
        'title'    => esc_html__('Hide Title', 'c4d-woo-bs'),
        'options' => array(
          '1' => esc_html__('Yes', 'c4d-woo-bs'),
          '0' => esc_html__('No', 'c4d-woo-bs')
         ),
        'default' => '0'
      ),
      array(
        'id'       => 'c4d-woo-bs-cross-desc',
        'type'     => 'textarea',
        'title'    => esc_html__('Description', 'c4d-woo-bs'),
        'default' => 'Get discount code for next shopping',
      ),
      array(
        'id'       => 'c4d-woo-bs-cross-hide-desc',
        'type'     => 'button_set',
        'title'    => esc_html__('Hide Description', 'c4d-woo-bs'),
        'options' => array(
          '1' => esc_html__('Yes', 'c4d-woo-bs'),
          '0' => esc_html__('No', 'c4d-woo-bs')
         ),
        'default' => '0'
      ),
      array(
        'id'       => 'c4d-woo-bs-cross-limit',
        'type'     => 'text',
        'title'    => esc_html__('Number', 'c4d-woo-bs'),
        'validate' => 'number',
        'default' => 4
      ),
      array(
        'id'       => 'c4d-woo-bs-cross-column',
        'type'     => 'text',
        'title'    => esc_html__('Column', 'c4d-woo-bs'),
        'validate' => 'number',
        'default' => 4
      ),
      array(
        'id'       => 'c4d-woo-bs-cross-order',
        'type'     => 'button_set',
        'title'    => esc_html__('Orderby', 'c4d-woo-bs'),
        'options' => array(
          'date' => esc_html__('Date', 'c4d-woo-bs'),
          'id' => esc_html__('Id', 'c4d-woo-bs'),
          'rand' => esc_html__('Random', 'c4d-woo-bs'),
          'title' => esc_html__('Title', 'c4d-woo-bs'),
          'price' => esc_html__('Price', 'c4d-woo-bs')
         ),
        'default' => 'rand'
      )
    )
  ));

  Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Pages', 'c4d-woo-bs' ),
    'id'               => 'section-c4d-woo-bs-email',
    'desc'             => '',
    'customizer_width' => '400px',
    'icon'             => '',
    'subsection'       => true,
    'fields'           => array(
      array(
       'id' => 'c4d-woo-bs-email-section-pages',
       'type' => 'section',
       'title' => __('Show In Pages', 'c4d-woo-vs'),
       'indent' => true
      ),
        array(
          'id'       => 'c4d-woo-bs-page-single-product',
          'type'     => 'button_set',
          'title'    => esc_html__('Single Product', 'c4d-woo-bs'),
          'options' => array(
            '1' => esc_html__('Yes', 'c4d-woo-bs'),
            '0' => esc_html__('No', 'c4d-woo-bs')
           ),
          'default' => '1'
        ),
        array(
          'id'       => 'c4d-woo-bs-email-process-order',
          'type'     => 'button_set',
          'title'    => esc_html__('Email: Process Order', 'c4d-woo-bs'),
          'options' => array(
            '1' => esc_html__('Yes', 'c4d-woo-bs'),
            '0' => esc_html__('No', 'c4d-woo-bs')
           ),
          'default' => '0'
        ),
        array(
          'id'       => 'c4d-woo-bs-email-complete-order',
          'type'     => 'button_set',
          'title'    => esc_html__('Email: Complete Order', 'c4d-woo-bs'),
          'options' => array(
            '1' => esc_html__('Yes', 'c4d-woo-bs'),
            '0' => esc_html__('No', 'c4d-woo-bs')
           ),
          'default' => '0'
        ),
        array(
          'id'       => 'c4d-woo-bs-email-customer-note',
          'type'     => 'button_set',
          'title'    => esc_html__('Email: Customer Note', 'c4d-woo-bs'),
          'options' => array(
            '1' => esc_html__('Yes', 'c4d-woo-bs'),
            '0' => esc_html__('No', 'c4d-woo-bs')
           ),
          'default' => '0'
        ),
        array(
          'id'       => 'c4d-woo-bs-global-thankyou-page',
          'type'     => 'button_set',
          'title'    => esc_html__('Thankyou Page', 'c4d-woo-bs'),
          'options' => array(
            '1' => esc_html__('Yes', 'c4d-woo-bs'),
            '0' => esc_html__('No', 'c4d-woo-bs')
           ),
          'default' => '0'
        ),
      array(
       'id' => 'c4d-woo-bs-email-section-up',
       'type' => 'section',
       'title' => __('Up Sell', 'c4d-woo-vs'),
       'indent' => true
      ),
        array(
          'id'       => 'c4d-woo-bs-email-up-title',
          'type'     => 'text',
          'title'    => esc_html__('Title', 'c4d-woo-bs'),
          'default' => 'Customers who bought this item also bought',
        ),
        array(
          'id'       => 'c4d-woo-bs-email-up-hide-title',
          'type'     => 'button_set',
          'title'    => esc_html__('Hide Title', 'c4d-woo-bs'),
          'options' => array(
            '1' => esc_html__('Yes', 'c4d-woo-bs'),
            '0' => esc_html__('No', 'c4d-woo-bs')
           ),
          'default' => '0'
        ),
        array(
          'id'       => 'c4d-woo-bs-email-up-desc',
          'type'     => 'textarea',
          'title'    => esc_html__('Description', 'c4d-woo-bs'),
          'default' => 'Get discount code for next shopping',
        ),
        array(
          'id'       => 'c4d-woo-bs-email-up-hide-desc',
          'type'     => 'button_set',
          'title'    => esc_html__('Hide Description', 'c4d-woo-bs'),
          'options' => array(
            '1' => esc_html__('Yes', 'c4d-woo-bs'),
            '0' => esc_html__('No', 'c4d-woo-bs')
           ),
          'default' => '0'
        ),
      array(
       'id' => 'c4d-woo-bs-email-section-cross',
       'type' => 'section',
       'title' => __('Cross Sell', 'c4d-woo-vs'),
       'indent' => true
      ),
        array(
          'id'       => 'c4d-woo-bs-email-cross-title',
          'type'     => 'text',
          'title'    => esc_html__('Title', 'c4d-woo-bs'),
          'default' => 'Customers who bought this item also interested in',
        ),
        array(
          'id'       => 'c4d-woo-bs-email-cross-hide-title',
          'type'     => 'button_set',
          'title'    => esc_html__('Hide Title', 'c4d-woo-bs'),
          'options' => array(
            '1' => esc_html__('Yes', 'c4d-woo-bs'),
            '0' => esc_html__('No', 'c4d-woo-bs')
           ),
          'default' => '0'
        ),
        array(
          'id'       => 'c4d-woo-bs-email-cross-desc',
          'type'     => 'textarea',
          'title'    => esc_html__('Description', 'c4d-woo-bs'),
          'default' => 'Get discount code for next shopping',
        ),
        array(
          'id'       => 'c4d-woo-bs-email-cross-hide-desc',
          'type'     => 'button_set',
          'title'    => esc_html__('Hide Description', 'c4d-woo-bs'),
          'options' => array(
            '1' => esc_html__('Yes', 'c4d-woo-bs'),
            '0' => esc_html__('No', 'c4d-woo-bs')
           ),
          'default' => '0'
        ),
    )
  ));
}
