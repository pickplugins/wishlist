<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


include_once( ABSPATH . 'wp-admin/includes/plugin.php' );


if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

    require_once( wishlist_plugin_dir . 'includes/3rd-party/woocommerce/functions.php');
}

//if ( is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' ) ) {
//
//    require_once( wishlist_plugin_dir . 'includes/3rd-party/easy-digital-downloads/functions.php');
//}