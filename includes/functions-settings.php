<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


$pickplugins_wl_settings_options = array(

	'page_nav' => __( 'Options', 'wishlist' ),
	'page_settings' => array(
		
		'pick_section_options'	=> array(
			'title' 			=> 	__('Options','wishlist'),
			'description' 		=> __('Some basic options here.','wishlist'),
			'options' => array(
				array(
					'id'		=> 'pickplugins_wl_wishlist_page',
					'title'		=> __('Wishlist page','wishlist'),
					'details'	=> __('Users will able to view their wishlists','wishlist')." Use shortcode <code>[wishlist_archive]</code> on that page",
					'type'		=> 'select',
					'args'		=> pickplugins_wl_get_wishlist_pages(),
				),
				array(
					'id'		=> 'pickplugins_wl_enable_wc_shop',
					'title'		=> __('Display on shop page','wishlist'),
					'details'	=> __('Display wishlist button on WooCommerce shop page automatically.','wishlist'),
					'type'		=> 'select',
					'args'		=> array('yes'=>'Yes','no'=>'No'),
				),

				array(
					'id'		=> 'pickplugins_wl_wc_shop_on',
					'title'		=> __('Display shop page on','wishlist'),
					'details'	=> __('Display wishlist button on shop page ','wishlist'),
					'type'		=> 'select',
					'args'		=> array(
						'before_addtocart' 	=> __('Before Add to Cart', 'wishlist'),
						'after_addtocart'	=> __('After Add to Cart', 'wishlist'),
					),
				),
				array(
					'id'		=> 'pickplugins_wl_enable_wc_product',
					'title'		=> __('Display on product page','wishlist'),
					'details'	=> __('Display wishlist button on WooCommerce product page automatically.','wishlist'),
					'type'		=> 'select',
					'args'		=> array('yes'=>'Yes','no'=>'No'),
				),

				array(
					'id'		=> 'pickplugins_wl_wc_product_under',
					'title'		=> __('Display on product page under','wishlist'),
					'details'	=> __('Display wishlist button on product page under following element.','wishlist'),
					'type'		=> 'select',
					'args'		=> array(
						'title' 		=> __('Title', 'wishlist'),
						'ratings'		=> __('Ratings', 'wishlist'),
						'price'			=> __('Price', 'wishlist'),
						'excerpt'		=> __('Excerpt', 'wishlist'),
						'meta'			=> __('Meta', 'wishlist'),
						'sharing'		=> __('Sharing', 'wishlist'),
						'add_to_cart'	=> __('Add to Cart', 'wishlist'),
					),
				),




			)
		),



		'pick_section_breadcrumb' => array(
			'title' 			=> 	__('Breadcrumb','wishlist'),
			'description' 		=> __('Wishlist single page breadcrumb options.','wishlist'),
			'options' => array(
				array(
					'id'		=> 'pickplugins_wl_breadcrumb_enable',
					'title'		=> __('Display breadcrumb','wishlist'),
					'details'	=> __('Display breadcrumb on wishlist single page.','wishlist'),
					'type'		=> 'select',
					'args'		=> array('yes'=>'Yes','no'=>'No'),
				),
				array(
					'id'		=> 'pickplugins_wl_breadcrumb_home_text',
					'title'		=> __('Custom text for "Home"','wishlist'),
					'details'	=> __('You can change default text for "Home" on breadcrumb.','wishlist'),
					'type'		=> 'text',
					'placeholder' => __('Home','wishlist'),
				),

				array(
					'id'		=> 'pickplugins_wl_breadcrumb_text_color',
					'title'		=> __('Breadcrumb text color','wishlist'),
					'details'	=> __('Please choose a color for breadcrumb text.','wishlist'),
					'type'		=> 'colorpicker',

				),


			)
		),



		'pick_section_pagination' => array(
			'title' 			=> 	__('Pagination','wishlist'),
			'description' 		=> __('Update your pagination settings','wishlist'),
			'options' => array(
				array(
					'id'		=> 'pickplugins_wl_list_per_page',
					'title'		=> __('Wishlist per page','wishlist'),
					'details'	=> __('How many wishlists will show per page?','wishlist'),
					'type'		=> 'number',
					'placeholder' => __('10','wishlist'),
				),
				array(
					'id'		=> 'pickplugins_wl_list_items_per_page',
					'title'		=> __('Wishlist items per page','wishlist'),
					'details'	=> __('How many items (post, products) will show per page?','wishlist'),
					'type'		=> 'number',
					'placeholder' => __('10','wishlist'),
				),
			)
		),


		'pick_section_tags' => array(
			'title' 			=> 	__('Wishlist Tags','wishlist'),
			'description' 		=> __('Update wishlist tags options','wishlist'),
			'options' => array(
				array(
					'id'		=> 'pickplugins_wl_enable_tags',
					'title'		=> __('Enable tags for Wishlist','woo-wishlist'),
					'details'	=> __('If you want to enable tagging on wishlist.','woo-wishlist'),
					'type'		=> 'select',
					'args'		=> array('yes'=>'Yes','no'=>'No'),
				),
				array(
					'id'		=> 'pickplugins_wl_tags_display',
					'title'		=> __('Display tags on wishlist page','woo-wishlist'),
					'details'	=> __('Please choose if you want to dispaly tags on wishlist page.','woo-wishlist'),
					'type'		=> 'select',
					'args'		=> array('yes'=>'Yes','no'=>'No'),
				),
			)
		),



	),
	
);





$pickplugins_wl_settings_style = array(

	'page_nav' => __( 'Style', 'woo-wishlist' ),
	'page_settings' => array(

		'pick_section_button_style'	=> array(
			'title' 			=> 	__('Wishlist button style','woo-wishlist'),
			'description' 		=> __('Change the colors of heart icon.','woo-wishlist'),
			'options' => array(
				array(
					'id'		=> 'pickplugins_wl_button_font_size',
					'title'		=> __('Wishlist button font size','woo-wishlist'),
					'details'	=> __('This font size will apply on both menu icon and wishlist button','woo-wishlist'),
					'type'		=> 'number',
				),
				array(
					'id'		=> 'pickplugins_wl_button_color_normal',
					'title'		=> __('Wishlist button color - Normal','woo-wishlist'),
					'details'	=> __('When the item is not listed to any wishlist','woo-wishlist'),
					'type'		=> 'colorpicker',
				),
				array(
					'id'		=> 'pickplugins_wl_button_color_active',
					'title'		=> __('Wishlist button color - Acive','woo-wishlist'),
					'details'	=> __('When the item is listed to any wishlist','woo-wishlist'),
					'type'		=> 'colorpicker',
				),
			)
		),

	),

);





$pickplugins_wl_settings_help = array(

	'page_nav' => __( 'Help', 'woo-wishlist' ),
	'page_settings' => array(

		'pick_section_options'	=> array(
			'title' 			=> 	__('Help & support','woo-wishlist'),
			'description' 		=> __('Here is all about help and support.','woo-wishlist'),
			'options' => array(
				array(
					'id'		=> 'pickplugins_wl_wishlist_contact',
					'title'		=> __('Contact for support','woo-wishlist'),
					'details'	=> __('Please contact us for support, <a href="https://www.pickplugins.com/support/">https://www.pickplugins.com/support/</a>','woo-wishlist'),
					'type'		=> 'custom',
					//'args'		=> pickplugins_wl_get_wishlist_pages(),
				),
			)
		),

	),

);




$args = array(
	'add_in_menu' => true, 															// true, false
	'menu_type' => 'submenu', 														// main, submenu
	'menu_title' => __( 'Settings', 'woo-wishlist' ), 								// Menu Title
	'page_title' => __( 'Settings', 'woo-wishlist' ), 								// Page Title
	'menu_page_title' => __( 'WooCommerce Wishlist - Settings', 'woo-wishlist' ),	// Menu Page Title
	'capability' => "manage_options",												// Capability
	'menu_slug' => "ww-settings",													// Menu Slug
	'parent_slug' => "edit.php?post_type=wishlist",									// Parent Slug for submenu
	'pages' => array(
		'pickplugins_wl_settings_options' => $pickplugins_wl_settings_options,
		'pickplugins_wl_settings_style' => $pickplugins_wl_settings_style,
		'pickplugins_wl_settings_help' => $pickplugins_wl_settings_help,
	),
);
		
$Pick_settings = new Pick_settings( $args );
		

		
function pickplugins_wl_get_wishlist_pages(){
	
	$pages_array = array( '' => __( 'Select Page', 'woo-wishlist' ) );
	
	foreach( get_pages() as $page ):
		$pages_array[ $page->ID ] = $page->post_title;
	endforeach;
	
	return $pages_array;
}

function pickplugins_wl_get_share_platforms(){
	
	$platforms = array();
	foreach( pickplugins_wl_get_social_platforms() as $key => $platform ) $platforms[ $key ] = $platform['title'];
	return $platforms;
}



