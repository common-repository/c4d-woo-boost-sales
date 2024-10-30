<?php
/*
Plugin Name: C4D Woo Boost Sales
Plugin URI: http://coffee4dev.com/woocomerce-boost-sales-upsells-cross-sells/
Description: Increase revenue with cross-sells, up-sells in WooCommerce.
Author: Coffee4dev.com
Author URI: http://coffee4dev.com/
Text Domain: c4d-woo-bs
Version: 1.0.8
*/
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
if ( !in_array( 
  'woocommerce/woocommerce.php', 
   get_option( 'active_plugins' ) 
)  ) return;
define('C4DWOOBS_PLUGIN_URI', plugins_url('', __FILE__));
include_once (dirname(__FILE__). '/includes/options.php');
include_once (dirname(__FILE__). '/includes/default.php');
include_once (dirname(__FILE__). '/includes/cart.php');
include_once (dirname(__FILE__). '/includes/product-options.php');
include_once (dirname(__FILE__). '/includes/category.php');

