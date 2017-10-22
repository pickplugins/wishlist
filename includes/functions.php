<?php
/*
* @Author 		pickplugins
* Copyright: 	pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 












/* Add Wishlist section using Shortcode on Single Post Archive*/
/* ===== === ===== */

function woocommerce_template_loop_product_wishlist( $item_id = 0 ){
	
	if( $item_id == 0 ) $item_id = get_the_ID();
	
	echo do_shortcode( "[wishlist_button id=$item_id]" ).'Total wishlisted: 50';

}
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_wishlist', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_loop_product_wishlist', 10 );
add_action( 'pickplugins_wl_loop_single_item_main', 'woocommerce_template_loop_product_wishlist', 12 );



/* Update Wishlist from Popup */
/* ===== === ===== */

function pickplugins_wl_ajax_update_wishlist(){
	
	$pickplugins_wl_action	= isset( $_POST['pickplugins_wl_action'] ) ? sanitize_text_field( $_POST['pickplugins_wl_action'] ) : "";
	$wishlist_id			= isset( $_POST['wishlist_id'] ) ? sanitize_text_field( $_POST['wishlist_id'] ) : "";
	$wishlist_title			= isset( $_POST['wishlist_title'] ) ? sanitize_text_field( $_POST['wishlist_title'] ) : "";
	$wishlist_sd			= isset( $_POST['wishlist_sd'] ) ? sanitize_text_field( $_POST['wishlist_sd'] ) : "";
	$wishlist_status		= isset( $_POST['wishlist_status'] ) ? sanitize_text_field( $_POST['wishlist_status'] ) : "public";
	
	
	if( $pickplugins_wl_action === "delete" ){
		
		$pickplugins_wl_wishlist_page = get_option( 'pickplugins_wl_wishlist_page' );
		
		wp_delete_post( $wishlist_id, true );
		
		echo get_the_permalink( $pickplugins_wl_wishlist_page );
		die();
	}
	
	if( $pickplugins_wl_action === "update" ){
		
		$ret = wp_update_post ( array(
			'ID'           => $wishlist_id,
			'post_title'   => $wishlist_title,
			'post_content' => $wishlist_sd,
		) );
		
		update_post_meta( $wishlist_id, 'wishlist_status', $wishlist_status );
		
		if( $ret ) echo "updated";
		die();
	}


	echo "<li class='pickplugins_wl_menu_item pickplugins_wl_add_new'><span class='dashicons dashicons-plus'></span> ".__('Add New', 'woo-wishlist')."</li>";
	
	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_update_wishlist', 'pickplugins_wl_ajax_update_wishlist');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_update_wishlist', 'pickplugins_wl_ajax_update_wishlist');	



/* Load Menu Items on Hover */
/* ===== === ===== */

function pickplugins_wl_ajax_get_wishlist_menu_items(){
	
	$item_id 	 	= isset( $_POST['item_id'] ) ? sanitize_text_field($_POST['item_id']) : 0;
	$current_user_id 	= get_current_user_id();
	$default_list_id	= get_option( 'pickplugins_wl_default_wishlist_id' );
	$wishlisted_array 	= pickplugins_wl_is_wishlisted( $item_id );
	
	
	if( !empty( $default_list_id ) && in_array( $default_list_id, $wishlisted_array ) )
		echo "<li class='pickplugins_wl_menu_item pickplugins_wl_saved' wishlist='$default_list_id'><span class='dashicons dashicons-heart'></span> ".get_the_title($default_list_id)."</li>";
	else echo "<li class='pickplugins_wl_menu_item' wishlist='$default_list_id'><span class='dashicons dashicons-heart'></span> ".get_the_title($default_list_id)."</li>";
	
	$wishlist_array = get_posts( array(
		'post_type' => 'wishlist',
		'author' => $current_user_id,
		'post__not_in' => array( $default_list_id ),
		'posts_per_page' => 5,
	) );
		
	foreach( $wishlist_array as $list ):
			
	if( $wishlisted_array && in_array( $list->ID, $wishlisted_array ) )
		echo "<li class='pickplugins_wl_menu_item pickplugins_wl_saved' wishlist='{$list->ID}'><span class='dashicons dashicons-heart'></span> {$list->post_title}</li>";
	else echo "<li class='pickplugins_wl_menu_item' wishlist='{$list->ID}'><span class='dashicons dashicons-heart'></span> {$list->post_title}</li>";

	endforeach;

	echo "<li class='pickplugins_wl_menu_item pickplugins_wl_add_new'><span class='dashicons dashicons-plus'></span> ".__('Add New', 'woo-wishlist')."</li>";
	
	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_get_wishlist_menu_items', 'pickplugins_wl_ajax_get_wishlist_menu_items');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_get_wishlist_menu_items', 'pickplugins_wl_ajax_get_wishlist_menu_items');	


function pickplugins_wl_ajax_add_remove_item_on_wishlist(){
	
	$pickplugins_wl_action 		= isset( $_POST['pickplugins_wl_action'] ) ? sanitize_text_field($_POST['pickplugins_wl_action']) : "";
	$item_id 	= isset( $_POST['item_id'] ) ? sanitize_text_field($_POST['item_id']) : "";
	$wishlist_id 	= isset( $_POST['wishlist_id'] ) ? sanitize_text_field($_POST['wishlist_id']) : "";
	
	if( empty( $pickplugins_wl_action ) || empty( $item_id ) || ! is_user_logged_in() ) die();
	
	if( empty( $wishlist_id ) ) $wishlist_id = get_option( 'pickplugins_wl_default_wishlist_id' );
	
	if( $pickplugins_wl_action == "remove_from_wishlist" ){
		
		echo pickplugins_wl_remove_from_wishlist( $wishlist_id, $item_id ) ? "removed" : "not";
		die();
	}
	
	if( $pickplugins_wl_action == "add_in_wishlist" ){
		
		echo pickplugins_wl_add_to_wishlist( $wishlist_id, $item_id ) ? "added" : "";
		die();
	}
	
	
	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_add_remove_item_on_wishlist', 'pickplugins_wl_ajax_add_remove_item_on_wishlist');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_add_remove_item_on_wishlist', 'pickplugins_wl_ajax_add_remove_item_on_wishlist');


function pickplugins_wl_ajax_create_save_wishlist(){
	
	$wishlist_name 	= isset( $_POST['wishlist_name'] ) ? sanitize_text_field($_POST['wishlist_name']) : "";
	$item_id 	= isset( $_POST['item_id'] ) ? sanitize_text_field($_POST['item_id']) : "";
	
	if( is_user_logged_in() ){
		
		$nepickplugins_wl_wishlist_ID = wp_insert_post( array(
			'post_title' 	=> $wishlist_name,
			'post_type' 	=> 'wishlist',
			'post_status' 	=> 'publish',
			'author' 		=> get_current_user_id(),
		) );


		pickplugins_wl_add_to_wishlist( $nepickplugins_wl_wishlist_ID, $item_id );

	}
	
	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_create_save_wishlist', 'pickplugins_wl_ajax_create_save_wishlist');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_create_save_wishlist', 'pickplugins_wl_ajax_create_save_wishlist');	


function pickplugins_wl_wishlist_buttons_html(){

	echo "
	<div class='pickplugins_wl_quick_add_wishlist_container'>
		<div class='pickplugins_wl_quick_add_wishlist'>

			<h2 class='pickplugins_wl_quick_add_title'>".__('Name your new wishlist', 'woo-wishlist' )."</h2><br>
			
			<input type='text' class='wishlist_name' placeholder='".__( 'Wishlist Name', 'woo-wishlist' )."'>
			<input type='hidden' class='item_id' value=''><br>
		
			<div class='pickplugins_wl_button pickplugins_wl_button_cancel'>".__( 'Cancel', 'woo-wishlist' )."</div>
			<div class='pickplugins_wl_button pickplugins_wl_button_save'>".__( 'Create Wishlist and Save', 'woo-wishlist' )."</div><br>
	
		</div>
	</div>";
	
}
add_action( 'wp_footer', 'pickplugins_wl_wishlist_buttons_html' );










/* Custom Functions */
/* ===== *** ===== */
function pickplugins_wl_add_to_wishlist( $wishlist_id = 0, $item_id = 0 ){
	
	if( $wishlist_id == 0 || $item_id == 0 || get_current_user_id() == 0 ) return false;
	
	if( in_array( $wishlist_id, pickplugins_wl_is_wishlisted( $item_id ) ) ) return false;
	
	global $wpdb;
	
	return $wpdb->insert( $wpdb->prefix . 'pickplugins_wl_data',  
		array( 
			'wishlist_id' => $wishlist_id, 
			'post_id' => $item_id,
			'user_id' => get_current_user_id(),
			'datetime' => current_time('mysql'),
		)
	);
}


function pickplugins_wl_remove_from_wishlist( $wishlist_id = 0, $item_id = 0 ){
	
	if( $wishlist_id == 0 || $item_id == 0 || get_current_user_id() == 0 ) return false;
	
	global $wpdb;
	
	return $wpdb->delete( $wpdb->prefix . 'pickplugins_wl_data', 
		array( 
			'wishlist_id' => $wishlist_id,
			'post_id' => $item_id,
			'user_id' => get_current_user_id(),
		) 
	);
}

function pickplugins_wl_is_wishlisted( $item_id = 0 ){
	
	$current_user_id = get_current_user_id();
	if( $item_id == 0 || $current_user_id == 0 ) return false;
	
	global $wpdb;
	
	$results = $wpdb->get_results("
		SELECT 	wishlist_id
		FROM 	{$wpdb->prefix}pickplugins_wl_data
		WHERE	post_id = $item_id AND user_id = $current_user_id
	");
	
	$wishlist_array = array();
	foreach( $results as $result ) array_push( $wishlist_array, $result->wishlist_id );
	
	
	return $wishlist_array;
	// echo "<pre>"; print_r( $wishlist_array ); echo "</pre>";
}



function pickplugins_wl_get_wishlisted_items( $wishlist_id = 0, $item_per_page = -1, $paged = 1 ){
	
	$current_user_id = get_current_user_id();
	if( $wishlist_id == 0 ) return false;
	
	$wishlist_status = get_post_meta( $wishlist_id, 'wishlist_status', true );
	if( empty( $wishlist_status ) ) $wishlist_status = "public";

	if( is_user_logged_in() ){

		if( get_option('pickplugins_wl_default_wishlist_id') == $wishlist_id ) {
			$query_append = "AND user_id = $current_user_id";
		}
		else {
			$query_append = $wishlist_status == 'private' ? "AND user_id = $current_user_id" : "";
		}
	}
	else {
		$query_append = "";
	}

	// && get_option('pickplugins_wl_default_wishlist_id') == $wishlist_id ) { $query_append = ;}

		
	global $wpdb;
	
	if( $item_per_page != -1 ) {
		
		$OFFSET = ($paged - 1) * $item_per_page;
		$results = $wpdb->get_results("
			SELECT 	*
			FROM 	{$wpdb->prefix}pickplugins_wl_data
			WHERE	wishlist_id = $wishlist_id  $query_append
			GROUP BY post_id
			ORDER BY id DESC LIMIT $item_per_page OFFSET $OFFSET
		");
		
		return $results;
	}

	$results = $wpdb->get_results("
		SELECT 	*
		FROM 	{$wpdb->prefix}pickplugins_wl_data
		WHERE	wishlist_id = $wishlist_id $query_append
		GROUP BY post_id
	");

	return $results;
	// echo "<pre>"; print_r( $results ); echo "</pre>";
}



function pickplugins_wl_get_wishlist_count( $item_id = 0 ){
	
	if( $item_id == 0 ) return 0;
	global $wpdb;
	return $wpdb->get_var("
		SELECT 	COUNT(*)
		FROM 	{$wpdb->prefix}pickplugins_wl_data
		WHERE	post_id = $item_id
	");
}


function pickplugins_wl_get_all_status(){

	return apply_filters( 'pickplugins_wl_filters_all_status', array(
		'public' => __('Public - Show to everyone', 'woo-wishlist'),
		'private' => __('Private - Show only to you', 'woo-wishlist'),
	) );
}

