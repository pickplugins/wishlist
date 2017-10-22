<?php
/*
Plugin Name: WooCommerce Wishlist
Plugin URI: https://www.pickplugins.com/product/wishlist/
Description: Add wish-list feature to your WooCommerce product or any post types.
Version: 1.0.2
Text Domain: woo-wishlist
Author: pickplugins
Author URI: http://pickplugins.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class PickpluginsWishList{
	
	public function __construct(){
	
		$this->define_constants();
		$this->declare_classes();
		
		$this->loading_script();
		$this->loading_functions();
		
		register_activation_hook( __FILE__, array( $this, 'activation' ) );
		// add_action( 'plugins_loaded', array( $this, 'load_textdomain' ));
	}
	
	public function activation() {

		$pickplugins_wl_default_wishlist_id = get_option( 'pickplugins_wl_default_wishlist_id' );
		
		if( empty( $pickplugins_wl_default_wishlist_id ) ) :
			
			$nepickplugins_wl_wishlist_ID = wp_insert_post( array(
				'post_title' 	=> __('Products I Love', 'woo-wishlist'),
				'slug' 			=> 'products-i-love',
				'post_type' 	=> 'wishlist',
				'post_status' 	=> 'publish',
			) );
			
			update_option( 'pickplugins_wl_default_wishlist_id', $nepickplugins_wl_wishlist_ID );
			
		endif;
		
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		
		$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}pickplugins_wl_data (
			
			id int(100) NOT NULL AUTO_INCREMENT,
			wishlist_id int(100) NOT NULL,
			post_id int(100) NOT NULL,
			user_id int(100) NOT NULL,
			datetime DATETIME NOT NULL,
			
			UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	
	public function load_textdomain() {

		load_plugin_textdomain( 'woo-wishlist', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' ); 
	}
	
	public function loading_functions() {
		
		// Templates Functions
		require_once( PICKPLUGINS_WISHLIST_PLUGIN_DIR . 'templates/wishlist-loop-single/wishlist-loop-single-functions.php');
		
		require_once( PICKPLUGINS_WISHLIST_PLUGIN_DIR . 'includes/functions.php');
		require_once( PICKPLUGINS_WISHLIST_PLUGIN_DIR . 'includes/functions-settings.php');
	}
	
	public function loading_script() {
	
		add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
		add_action( 'wp_enqueue_scripts', array( $this, 'pickplugins_wl_front_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'pickplugins_wl_admin_scripts' ) );
	}
	
	public function declare_classes() {
		
		require_once( PICKPLUGINS_WISHLIST_PLUGIN_DIR . 'includes/classes/class-pick-settings.php');	

		require_once( PICKPLUGINS_WISHLIST_PLUGIN_DIR . 'includes/classes/class-post-types.php');	
		require_once( PICKPLUGINS_WISHLIST_PLUGIN_DIR . 'includes/classes/class-shortcodes.php');	
	}
	
	public function define_constants() {

		$this->define('PICKPLUGINS_WISHLIST_PLUGIN_URL', plugins_url('/', __FILE__)  );
		$this->define('PICKPLUGINS_WISHLIST_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	}
	
	private function define( $name, $value ) {
		if( $name && $value )
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}		
		
	public function pickplugins_wl_front_scripts(){
		
		wp_enqueue_script('jquery');
		wp_enqueue_style('dashicons');

		wp_enqueue_script('pickplugins_wl_front_js', plugins_url( '/assets/front/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script( 'pickplugins_wl_front_js', 'pickplugins_wl_ajax', array( 'pickplugins_wl_ajaxurl' => admin_url( 'admin-ajax.php')));

		wp_enqueue_style('single-wishlist', PICKPLUGINS_WISHLIST_PLUGIN_URL.'assets/front/css/single-wishlist.css');

		wp_enqueue_style('pickplugins_wl_style', PICKPLUGINS_WISHLIST_PLUGIN_URL.'assets/front/css/style.css');
		wp_enqueue_style('font-awesome.min.css', PICKPLUGINS_WISHLIST_PLUGIN_URL.'assets/front/css/font-awesome.min.css');

	}

	public function pickplugins_wl_admin_scripts(){
		
		wp_enqueue_script('jquery');

		wp_enqueue_script('pickplugins_wl_admin_js', plugins_url( '/assets/admin/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script( 'pickplugins_wl_admin_js', 'pickplugins_wl_ajax', array( 'pickplugins_wl_ajaxurl' => admin_url( 'admin-ajax.php')));

        wp_enqueue_style('pickplugins_wl_admin_style', PICKPLUGINS_WISHLIST_PLUGIN_URL.'assets/admin/css/style.css');
	}
	
} new PickpluginsWishList();