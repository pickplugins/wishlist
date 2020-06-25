<?php
/*
Plugin Name: Wishlist
Plugin URI: https://www.pickplugins.com/item/woocommerce-wishlist/?ref=wordpress.org
Description: Add wish-list feature to your WooCommerce product or any post types.
Version: 1.0.5
WC requires at least: 3.0.0
WC tested up to: 4.0
Text Domain: wishlist
Author: PickPlugins
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
		
		register_activation_hook( __FILE__, array( $this, '_activation' ) );
        add_action( 'plugins_loaded', array( $this, '_textdomain' ));
	}

    public function _textdomain() {


        $locale = apply_filters( 'plugin_locale', get_locale(), 'wishlist' );
        load_textdomain('wishlist', WP_LANG_DIR .'/wishlist/wishlist-'. $locale .'.mo' );

        load_plugin_textdomain( 'wishlist', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
    }


	public function _activation() {

		$pickplugins_wl_default_wishlist_id = get_option( 'pickplugins_wl_default_wishlist_id' );
		
		if( empty( $pickplugins_wl_default_wishlist_id ) ) :
			
			$nepickplugins_wl_wishlist_ID = wp_insert_post( array(
				'post_title' 	=> __('Products I Love', 'wishlist'),
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
	

	
	public function loading_functions() {
		
		// Templates Functions
		require_once( wishlist_plugin_dir . 'templates/wishlist-loop-single/wishlist-loop-single-functions.php');
		
		require_once( wishlist_plugin_dir . 'includes/functions.php');
		require_once( wishlist_plugin_dir . 'includes/functions-ajax.php');
		require_once( wishlist_plugin_dir . 'includes/functions-settings.php');
        require_once( wishlist_plugin_dir . 'includes/settings-hook.php');

		require_once( wishlist_plugin_dir . 'templates/wishlist-single/wishlist-single-hooks.php');

	}
	
	public function loading_script() {
	
		add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
		add_action( 'wp_enqueue_scripts', array( $this, '_front_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, '_admin_scripts' ) );
	}
	
	public function declare_classes() {
		
		require_once( wishlist_plugin_dir . 'includes/classes/class-pick-settings.php');

		require_once( wishlist_plugin_dir . 'includes/classes/class-post-types.php');
		require_once( wishlist_plugin_dir . 'includes/classes/class-shortcodes.php');
		require_once( wishlist_plugin_dir . 'includes/classes/class-column-wishlist.php');
        require_once( wishlist_plugin_dir . 'includes/classes/class-settings-tabs.php');
        require_once( wishlist_plugin_dir . 'includes/classes/class-settings.php');


    }
	
	public function define_constants() {

		$this->define('wishlist_plugin_url', plugins_url('/', __FILE__)  );
		$this->define('wishlist_plugin_dir', plugin_dir_path( __FILE__ ) );
        $this->define('wishlist_plugin_name', 'Wishlist' );

	}
	
	private function define( $name, $value ) {
		if( $name && $value )
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}		
		
	public function _front_scripts(){
		
		wp_enqueue_script('jquery');
		wp_enqueue_style('dashicons');

		wp_enqueue_script('pickplugins_wl_front_js', plugins_url( '/assets/front/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script( 'pickplugins_wl_front_js', 'pickplugins_wl_ajax', array( 'pickplugins_wl_ajaxurl' => admin_url( 'admin-ajax.php')));

		wp_enqueue_style('single-wishlist', wishlist_plugin_url.'assets/front/css/single-wishlist.css');

		wp_enqueue_style('pickplugins_wl_style', wishlist_plugin_url.'assets/front/css/style.css');
		wp_enqueue_style('font-awesome.min.css', wishlist_plugin_url.'assets/front/css/font-awesome.min.css');

	}

	public function _admin_scripts(){

        $screen = get_current_screen();


        wp_enqueue_script('jquery');

        wp_register_style('font-awesome-4', wishlist_plugin_url.'assets/global/css/font-awesome-4.css');
        wp_register_style('font-awesome-5', wishlist_plugin_url.'assets/global/css/font-awesome-5.css');

        wp_register_style('settings-tabs', wishlist_plugin_url.'assets/settings-tabs/settings-tabs.css');
        wp_register_script('settings-tabs', wishlist_plugin_url.'assets/settings-tabs/settings-tabs.js'  , array( 'jquery' ));



		wp_enqueue_script('pickplugins_wl_admin_js', plugins_url( '/assets/admin/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script( 'pickplugins_wl_admin_js', 'pickplugins_wl_ajax', array( 'pickplugins_wl_ajaxurl' => admin_url( 'admin-ajax.php')));

        wp_enqueue_style('pickplugins_wl_admin_style', wishlist_plugin_url.'assets/admin/css/style.css');


        //var_dump($screen);


        if ($screen->id == 'wishlist_page_settings'){

//            wp_enqueue_style('select2');
//            wp_enqueue_script('select2');

            $settings_tabs_field = new settings_tabs_field();
            $settings_tabs_field->admin_scripts();

        }



	}
	
} new PickpluginsWishList();