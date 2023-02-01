<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

class class_wishlist_settings{

	public function __construct(){
		
		add_action('admin_menu', array( $this, 'wishlist_menu_init' ));
		
		}


    public function wishlist_menu_init() {


        add_submenu_page('edit.php?post_type=wishlist', __('Settings', 'wishlist'), __('Settings', 'wishlist'), 'manage_options', 'wishlist-settings', array( $this, 'settings' ));



    }

	public function settings(){
		include(wishlist_plugin_dir.'includes/menu/settings.php');
	}


	
}
	
new class_wishlist_settings();


