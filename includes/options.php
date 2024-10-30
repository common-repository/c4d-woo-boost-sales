<?php

$c4d_woo_boots_sales_params = array(
  "c4d_woo_bs_default_on" => 1,
  "c4d-woo-bs-global-show-type" => "upsell&crosssell",
  "c4d-woo-bs-page-single-product" => "1",
  "c4d-woo-bs-global-mini-cart" => "1",
  "c4d-woo-bs-global-cart-page" => "1",
  "c4d-woo-bs-global-source-category" => "1",
  "c4d-woo-bs-global-source-tags" => "1",
  "c4d-woo-bs-up-title" => "You may also like…",
  "c4d-woo-bs-up-hide-title" => "0",
  "c4d-woo-bs-up-desc" => "Get discount code for next shopping",
  "c4d-woo-bs-up-limit" => "4",
  "c4d-woo-bs-up-column" => "4",
  "c4d-woo-bs-up-order" => "title",
  "c4d-woo-bs-cross-title" => "You may be interested in…",
  "c4d-woo-bs-up-cross-title" => "0",
  "c4d-woo-bs-cross-desc" => "Get discount code for next shopping",
  "c4d-woo-bs-up-hide-desc" => "0",
  "c4d-woo-bs-cross-limit" => "4",
  "c4d-woo-bs-cross-column" => "4",
  "c4d-woo-bs-cross-order" => "title",
  "c4d-woo-bs-email-process-order" => "0",
  "c4d-woo-bs-email-complete-order" => "0",
  "c4d-woo-bs-email-customer-note" => "0",
  "c4d-woo-bs-global-thankyou-page" => "0",
  "c4d-woo-bs-email-up-title" => "Customers who bought this item also bought",
  "c4d-woo-bs-email-up-hide-title" => "0",
  "c4d-woo-bs-email-up-desc" => "Get discount code for next shopping",
  "c4d-woo-bs-email-up-hide-desc" => "0",
  "c4d-woo-bs-email-cross-title" => "Customers who bought this item also interested",
  "c4d-woo-bs-email-cross-hide-title" => "0",
  "c4d-woo-bs-email-cross-desc" => "Get discount code for next shopping",
  "c4d-woo-bs-email-cross-hide-desc" => "0"
);

if (!isset($c4d_plugin_manager)) {
  $c4d_plugin_manager = $c4d_woo_boots_sales_params;
} else {
  $c4d_plugin_manager = array_merge($c4d_woo_boots_sales_params, $c4d_plugin_manager);
}