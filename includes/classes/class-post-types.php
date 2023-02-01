<?php



if (!defined('ABSPATH')) exit;  // if direct access 

class PICKPLUGINS_WL_Post_types
{

	public function __construct()
	{

		add_action('init', array($this, 'posttype_wishlist'), 0);
	}

	public function posttype_wishlist()
	{

		$wishlist_settings = get_option('wishlist_settings');


		$wishlist_settings = get_option('wishlist_settings');
		$wishlist_slug = !empty($wishlist_settings['wishlist_slug']) ? $wishlist_settings['wishlist_slug'] : 'wishlist';
		// if ( post_type_exists( "wishlist" ) ) return;

		$singular  = __('Wishlist', 'wishlist');
		$plural    = __('Wishlists', 'wishlist');




		register_post_type(
			"wishlist",
			apply_filters("register_post_type_wishlist", array(
				'labels' => array(
					'name' 					=> $plural,
					'singular_name' 		=> $singular,
					'menu_name'             => $singular,
					'all_items'             => sprintf(__('All %s', 'wishlist'), $plural),
					'add_new' 				=> sprintf(__('Add %s', 'wishlist'), $singular),
					'add_nepickplugins_wl_item' 			=> sprintf(__('Add %s', 'wishlist'), $singular),
					'edit' 					=> __('Edit', 'wishlist'),
					'edit_item' 			=> sprintf(__('Edit %s', 'wishlist'), $singular),
					'nepickplugins_wl_item' 				=> sprintf(__('New %s', 'wishlist'), $singular),
					'view' 					=> sprintf(__('View %s', 'wishlist'), $singular),
					'viepickplugins_wl_item' 			=> sprintf(__('View %s', 'wishlist'), $singular),
					'search_items' 			=> sprintf(__('Search %s', 'wishlist'), $plural),
					'not_found' 			=> sprintf(__('No %s found', 'wishlist'), $plural),
					'not_found_in_trash' 	=> sprintf(__('No %s found in trash', 'wishlist'), $plural),
					'parent' 				=> sprintf(__('Parent %s', 'wishlist'), $singular)
				),
				'description' => sprintf(__('This is where you can create and manage %s.', 'wishlist'), $plural),
				'public' 				=> true,
				'capability_type' 		=> 'post',
				'capabilities' => array(
					'create_posts' => 'do_not_allow',
				),
				'map_meta_cap'          => true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'hierarchical' 			=> false,
				//'rewrite' 				=> true,
				'rewrite' 				=> array('slug' => $wishlist_slug),
				//'rewrite' => $rewrite,

				'query_var' 			=> true,
				'supports' 				=> array('title', 'editor', 'author','custom-fields'),
				'shopickplugins_wl_in_nav_menus' 	=> false,
				'menu_icon' => 'dashicons-heart',
			))
		);
	}
}
new PICKPLUGINS_WL_Post_types();
