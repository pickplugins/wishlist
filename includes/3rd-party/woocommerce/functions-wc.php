<?php
/*
* @Author 		pickplugins
* Copyright: 	pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

add_filter('wishlist_settings_tabs', 'wishlist_settings_tabs_wc');

function wishlist_settings_tabs_wc($tabs){

    $current_tab = isset($_REQUEST['tab']) ? $_REQUEST['tab'] : 'general';


    $tabs[] = array(
        'id' => 'woocommerce',
        'title' => sprintf(__('%s WooCommerce','wishlist'),'<i class="fas fa-cart-plus"></i>'),
        'priority' => 15,
        'active' => ($current_tab == 'woo') ? true : false,
    );

    return $tabs;

}









