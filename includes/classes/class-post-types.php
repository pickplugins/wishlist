<?php

/*
* @Author 		pickplugins
* Copyright: 	pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class PICKPLUGINS_WL_Post_types{
	
	public function __construct(){
		
		add_action( 'init', array( $this, 'pickplugins_wl_posttype_wishlist' ), 0 );
	}
	
	public function pickplugins_wl_posttype_wishlist(){
		
		if ( post_type_exists( "wishlist" ) )return;

		$singular  = __( 'Wishlist', 'woo-wishlist' );
		$plural    = __( 'Wishlists', 'woo-wishlist' );
	 
	 
		register_post_type( "wishlist",
			apply_filters( "register_post_type_wishlist", array(
				'labels' => array(
					'name' 					=> $plural,
					'singular_name' 		=> $singular,
					'menu_name'             => __( $singular, 'woo-wishlist' ),
					'all_items'             => sprintf( __( 'All %s', 'woo-wishlist' ), $plural ),
					'add_new' 				=> __( 'Add '.$singular, 'woo-wishlist' ),
					'add_nepickplugins_wl_item' 			=> sprintf( __( 'Add %s', 'woo-wishlist' ), $singular ),
					'edit' 					=> __( 'Edit', 'woo-wishlist' ),
					'edit_item' 			=> sprintf( __( 'Edit %s', 'woo-wishlist' ), $singular ),
					'nepickplugins_wl_item' 				=> sprintf( __( 'New %s', 'woo-wishlist' ), $singular ),
					'view' 					=> sprintf( __( 'View %s', 'woo-wishlist' ), $singular ),
					'viepickplugins_wl_item' 			=> sprintf( __( 'View %s', 'woo-wishlist' ), $singular ),
					'search_items' 			=> sprintf( __( 'Search %s', 'woo-wishlist' ), $plural ),
					'not_found' 			=> sprintf( __( 'No %s found', 'woo-wishlist' ), $plural ),
					'not_found_in_trash' 	=> sprintf( __( 'No %s found in trash', 'woo-wishlist' ), $plural ),
					'parent' 				=> sprintf( __( 'Parent %s', 'woo-wishlist' ), $singular )
				),
				'description' => sprintf( __( 'This is where you can create and manage %s.', 'woo-wishlist' ), $plural ),
				'public' 				=> true,
				'shopickplugins_wl_ui' 				=> true,
				'capability_type' 		=> 'post',
				'capabilities' => array(
					'create_posts' => 'do_not_allow',
				),
				'map_meta_cap'          => true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'hierarchical' 			=> false,
				'rewrite' 				=> true,
				'query_var' 			=> true,
				'supports' 				=> array('title','editor','author'),
				'shopickplugins_wl_in_nav_menus' 	=> false,
				'menu_icon' => 'dashicons-heart',
			) )
		); 
		
	}
		
	
} new PICKPLUGINS_WL_Post_types();