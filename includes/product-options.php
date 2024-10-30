<?php
add_action( 'woocommerce_product_options_related', 'c4d_woo_bs_product_options_related' );
add_action ('woocommerce_admin_process_product_object' , 'c4d_woo_bs_save_data' );

function c4d_woo_bs_product_options_related() {
  global $post, $product_object;
  $datas = c4d_woo_bs_get_data( $product_object->get_id());
  ?>

  <div class="options_group">
    <p class="form-field">
      <label ><?php esc_html_e( 'Upsells From Tags', 'c4d-woo-bs' ); ?></label>
      <input name="c4d_woo_bs[tags][upsell]" value="<?php echo esc_attr(isset($datas['tags']) ? $datas['tags']['upsell'] : ''); ?>" type="text" />
      <?php echo wc_help_tip( __( 'Insert tags which you recommend instead of the current tags of this product. Separate by comma.', 'c4d-woo-bs' ) ); // WPCS: XSS ok. ?>
    </p>

    <p class="form-field hide_if_grouped hide_if_external">
      <label ><?php esc_html_e( 'Cross-sells From Tags', 'c4d-woo-bs' ); ?></label>
      <input name="c4d_woo_bs[tags][crosssell]" value="<?php echo esc_attr(isset($datas['tags']) ? $datas['tags']['crosssell'] : ''); ?>" type="text" />
      <?php echo wc_help_tip( __( 'Insert tags which you recommend instead of the current tags of this product. Separate by comma.', 'c4d-woo-bs' ) ); // WPCS: XSS ok. ?>
    </p>
  </div>

  <div class="options_group">
    <p class="form-field">
      <label ><?php esc_html_e( 'Upsells From Category', 'c4d-woo-bs' ); ?></label>
      <input name="c4d_woo_bs[category][upsell]" value="<?php echo esc_attr(isset($datas['category']) ? $datas['category']['upsell'] : ''); ?>" type="text" />
      <?php echo wc_help_tip( __( 'Insert categories which you recommend instead of the current product\'s category to get upsell product. Separate by comma.', 'c4d-woo-bs' ) ); // WPCS: XSS ok. ?>
    </p>

    <p class="form-field hide_if_grouped hide_if_external">
      <label ><?php esc_html_e( 'Cross-sells From Category', 'c4d-woo-bs' ); ?></label>
      <input name="c4d_woo_bs[category][crosssell]" value="<?php echo esc_attr(isset($datas['category']) ? $datas['category']['crosssell'] : ''); ?>" type="text" />
      <?php echo wc_help_tip( __( 'Insert categories which you recommend instead of the current category of this product. Separate by comma.', 'c4d-woo-bs' ) ); // WPCS: XSS ok. ?>
    </p>
  </div>

  <?php
}

function c4d_woo_bs_save_data($product) {
  if (isset($_POST['c4d_woo_bs'])) {
    $datas = array(
      'category' => array('upsell' => '', 'crosssell' => ''),
      'tags' => array('upsell' => '', 'crosssell' => ''),
    );

    $datas['category']['upsell'] = sanitize_text_field($_POST['c4d_woo_bs']['category']['upsell']);
    $datas['category']['crosssell'] = sanitize_text_field($_POST['c4d_woo_bs']['category']['upsell']);
    $datas['tags']['upsell'] = sanitize_text_field($_POST['c4d_woo_bs']['tags']['upsell']);
    $datas['tags']['crosssell'] = sanitize_text_field($_POST['c4d_woo_bs']['tags']['crosssell']);

    update_post_meta( $product->get_id(), 'c4d_woo_bs', $datas );
  }
}

function c4d_woo_bs_get_data($pid, $name = '', $default = '') {
  $value = get_post_meta( $pid, 'c4d_woo_bs', true );
  if ($value) {
    if (isset($value[$name])) {
      return $value[$name];
    }
    return $value;
  }
  return $default;
}

?>
