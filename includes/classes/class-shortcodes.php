<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


class pickplugins_wl_Shortcodes {

	function __construct() {
		add_shortcode( 'wishlist_button', array( $this, 'wishlist_button_display' ) );
		add_shortcode( 'wishlist_archive', array( $this, 'wishlist_archive_display' ) );
		add_shortcode( 'wishlist_single', array( $this, 'wishlist_single_display' ) );
		add_shortcode( 'wishlist_count_by_post', array( $this, 'wishlist_count_by_post_display' ) );

	}	
	

	
	public function wishlist_single_display( $atts ) {
		
		$atts = shortcode_atts( array( 'id' => '',  ), $atts);
		
		$wishlist_id = isset( $atts['id'] ) ? $atts['id'] : 0;
		
		if( $wishlist_id == 0 ) return;

        $wishlist_settings = get_option('wishlist_settings');

        $font_aw_version = isset($wishlist_settings['general']['font_aw_version']) ? $wishlist_settings['general']['font_aw_version'] : 'v_5';


        if($font_aw_version == 'v_5'){
            $separator_icon = '<i class="fas fa-angle-double-right"></i>';
            $home_icon = '<i class="fas fa-home"></i>';
            $trash_icon = '<i class="fas fa-trash"></i>';
            $pencil_icon = '<i class="far fa-edit"></i>';
            $globe_icon = '<i class="fas fa-globe-asia"></i>';
            $lock_icon = '<i class="fas fa-lock"></i>';

            wp_enqueue_style('font-awesome-5');
        }elseif ($font_aw_version == 'v_4'){

            $separator_icon = '<i class="fa fa-angle-double-right"></i>';
            $home_icon = '<i class="fa fa-home"></i>';
            $trash_icon = '<i class="fa fa-trash"></i>';
            $pencil_icon = '<i class="fa fa-pencil-square-o"></i>';
            $globe_icon = '<i class="fa fa-globe"></i>';
            $lock_icon = '<i class="fa fa-lock"></i>';

            wp_enqueue_style('font-awesome-4');
        }

        $atts['icons'] = array(
            'separator_icon' => $separator_icon,
            'home_icon' => $home_icon,
            'trash_icon' => $trash_icon,
            'pencil_icon' => $pencil_icon,
            'globe_icon' => $globe_icon,
            'lock_icon' => $lock_icon,
        );

        ob_start();
		//include( wishlist_plugin_dir . 'templates/wishlist-single/wishlist-single.php');

        do_action('wishlist_single', $atts);

        wp_enqueue_style('single-wishlist');



        wp_enqueue_script('wishlist_single_js');

		return ob_get_clean();
	}
	
	public function wishlist_archive_display( $atts ) {
		
		$atts = shortcode_atts( array('view_type' => 'grid', 'column' => '3', ), $atts);
        $wishlist_settings = get_option('wishlist_settings');

        $font_aw_version = isset($wishlist_settings['general']['font_aw_version']) ? $wishlist_settings['general']['font_aw_version'] : 'v_5';

        if($font_aw_version == 'v_5'){
            $separator_icon = '<i class="fas fa-angle-double-right"></i>';
            $home_icon = '<i class="fas fa-home"></i>';
            $trash_icon = '<i class="fas fa-trash"></i>';
            $user_icon = '<i class="fas fa-user"></i>';
            $globe_icon = '<i class="fas fa-globe-asia"></i>';
            $lock_icon = '<i class="fas fa-lock"></i>';

            wp_enqueue_style('font-awesome-5');
        }elseif ($font_aw_version == 'v_4'){

            $separator_icon = '<i class="fa fa-angle-double-right"></i>';
            $home_icon = '<i class="fa fa-home"></i>';
            $trash_icon = '<i class="fa fa-trash"></i>';
            $user_icon = '<i class="fa fa-user"></i>';
            $globe_icon = '<i class="fa fa-globe"></i>';
            $lock_icon = '<i class="fa fa-lock"></i>';

            wp_enqueue_style('font-awesome-4');
        }


        $atts['icons'] = array(
            'user_icon' => $user_icon,
            'globe_icon' => $globe_icon,
            'lock_icon' => $lock_icon,
        );






        wp_enqueue_style('wishlist-archive');
        wp_enqueue_style('hint.css');


        ob_start();
        do_action('wishlist_archive', $atts);



		return ob_get_clean();
	}



	/*
	 * Wishlist Button
	 *
	 * */

	public function wishlist_button_display( $atts ) {
		
		$atts = shortcode_atts( array( 'id' => '', 'show_count' => '', 'show_menu' => '', 'icon_active' => '', 'icon_inactive' => '', 'icon_loading' => '', ), $atts);

		$atts = apply_filters('wishlist_button_atts', $atts);



		$item_id 	= isset( $atts['id'] ) ? $atts['id'] : 0;

        $wishlist_settings = get_option('wishlist_settings');

        $font_aw_version = isset($wishlist_settings['general']['font_aw_version']) ? $wishlist_settings['general']['font_aw_version'] : 'v_5';

		if(empty($item_id)) return;


        wp_enqueue_style('hint.css');


		ob_start();

		do_action('wishlist_button', $atts);
        wp_enqueue_style('wishlist_button_css');

        if($font_aw_version == 'v_5'){

            wp_enqueue_style('font-awesome-5');
        }elseif ($font_aw_version == 'v_4'){
            wp_enqueue_style('font-awesome-4');
        }

        wp_enqueue_script('wishlist_button_js');

		return ob_get_clean();
	}











	public function wishlist_count_by_post_display( $atts ) {

		$atts = shortcode_atts( array( 'id' => '' ), $atts);

		$item_id = isset( $atts['id'] ) ? $atts['id'] : 0;

		if( $item_id == 0 ) return 0;
		global $wpdb;
		return $wpdb->get_var("
		SELECT 	COUNT(*)
		FROM 	{$wpdb->prefix}pickplugins_wl_data
		WHERE	post_id = $item_id
	");


	}









	
} new pickplugins_wl_Shortcodes();

