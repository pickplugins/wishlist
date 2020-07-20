<?php
/*
Plugin Name: License Manager - Woocommerce
Plugin URI: http://pickplugins.com
Description: Awesome Question and Answer.
Version: 1.0.28
Text Domain: question-answer
Author: pickplugins
Author URI: http://pickplugins.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class LicenseManagerWoocommerce{
	
	public function __construct(){
	

        /* Add custom menu item and endpoint to WooCommerce My-Account page */
        add_action( 'init',array( $this, '_myaccount_endpoints' ) );
        add_filter( 'query_vars', array( $this, '_myaccount_query_vars' ), 0 );
        add_action( 'after_switch_theme', array( $this, '_myaccount_flush' ) );
        add_filter( 'query_vars', array( $this, '_myaccount_query_vars' ), 0 );
        add_filter( 'woocommerce_account_menu_items', array( $this, '_myaccount_menu_items' ), 10 );
        add_action( 'woocommerce_account_license-keys_endpoint', array( $this, '_myaccount_endpoint_content' ) );

    }
	
	

	
	
	
	


    function _myaccount_endpoints() {
        add_rewrite_endpoint( 'license-keys', EP_ROOT | EP_PAGES );
    }


    function _myaccount_query_vars( $vars ) {
        $vars[] = 'license-keys';

        return $vars;
    }



    function _myaccount_flush() {
        flush_rewrite_rules();
    }

    function _myaccount_menu_items( $items ) {

        $logout = $items['customer-logout'];
        unset( $items['customer-logout'] );

        $items['license-keys'] = __( 'License keys', 'woocommerce' );

        $items['customer-logout'] = $logout;

        return $items;
    }



    function _myaccount_endpoint_content() {

        echo do_shortcode('[license_manager_license_list]');
        ?>
        <?php

    }







} 

new LicenseManagerWoocommerce();















