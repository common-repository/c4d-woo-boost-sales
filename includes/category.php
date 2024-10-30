<?php
add_action( 'product_cat_add_form_fields', 'c4d_woo_bs_add_category_fields' );
add_action( 'product_cat_edit_form_fields', 'c4d_woo_bs_edit_category_fields', 10 );

add_action( 'product_tag_add_form_fields', 'c4d_woo_bs_add_category_fields' );
add_action( 'product_tag_edit_form_fields', 'c4d_woo_bs_edit_category_fields', 10 );

add_action( 'created_term', 'c4d_woo_bs_save_category_fields', 10, 3 );
add_action( 'edit_term', 'c4d_woo_bs_save_category_fields', 10, 3 );


function c4d_woo_bs_save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
  $pages = array('product_cat', 'product_tag');
  if ( isset( $_POST['upsell'] ) && in_array($taxonomy, $pages)) {
    update_term_meta( $term_id, 'upsell', sanitize_text_field($_POST['upsell'])  );
  }

  if ( isset( $_POST['crosssell'] ) && in_array($taxonomy, $pages)) {
    update_term_meta( $term_id, 'crosssell', sanitize_text_field($_POST['crosssell'])  );
  }
}

function c4d_woo_bs_add_category_fields() {
  if ($_GET['taxonomy'] == 'product_tag') {
    $upsell_text = __( 'Insert tags to get products when product of this tag show the upsell products. Separate by comma.', 'c4d-woo-bs' );
    $cross_text = __('Insert tags to get products when product of this tag show the cross-sell products. Separate by comma.', 'c4d-woo-bs');
  } else {
    $upsell_text = __( 'Insert categories to get products when product of this category show the upsell products. Separate by comma.', 'c4d-woo-bs' );
    $cross_text = __('Insert categories to get products when product of this category show the cross-sell products. Separate by comma.', 'c4d-woo-bs');
  }

  ?>
  <div class="form-field">
    <label for="display_type"><?php esc_html_e( 'Upsell', 'c4d-woo-bs' ); ?></label>
    <input name="upsell" type="text" value="">
    <p><?php echo $upsell_text ?></p>
  </div>
  <div class="form-field">
    <label for="display_type"><?php esc_html_e( 'Cross-Sell', 'c4d-woo-bs' ); ?></label>
    <input name="crosssell" type="text" value="">
    <p><?php echo $cross_text ?></p>
  </div>
  <div class="clear"></div>
  <?php
}

function c4d_woo_bs_edit_category_fields( $term ) {
  if ($_GET['taxonomy'] == 'product_tag') {
    $upsell_text = __( 'Insert tags to get products when product of this tag show the upsell products. Separate by comma.', 'c4d-woo-bs' );
    $cross_text = __('Insert tags to get products when product of this tag show the cross-sell products. Separate by comma.', 'c4d-woo-bs');
  } else {
    $upsell_text = __( 'Insert categories to get products when product of this category show the upsell products. Separate by comma.', 'c4d-woo-bs' );
    $cross_text = __('Insert categories to get products when product of this category show the cross-sell products. Separate by comma.', 'c4d-woo-bs');
  }
  $upsell = get_term_meta( $term->term_id, 'upsell', true );
  $crosssell = get_term_meta( $term->term_id, 'crosssell', true );
  ?>
  <tr class="form-field ">
    <th scope="row" valign="top"><label><?php esc_html_e( 'Upsell', 'c4d-woo-bs' ); ?></label></th>
    <td>
      <input name="upsell" type="text" value="<?php echo esc_attr($upsell); ?>">
      <p><?php echo $upsell_text ?></p>
    </td>
  </tr>
  <tr class="form-field ">
    <th scope="row" valign="top"><label><?php esc_html_e( 'Cross-Sell', 'c4d-woo-bs' ); ?></label></th>
    <td>
      <input name="crosssell" type="text" value="<?php echo esc_attr($crosssell); ?>">
    <p><?php echo $cross_text ?></p>
    </td>
  </tr>
    <?php
}