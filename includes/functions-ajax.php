<?php


if ( ! defined('ABSPATH')) exit;  // if direct access 


/* Wishlist Copy */
/* ===== === ===== */

function pickplugins_wl_ajax_wishlist_copy(){
	
	$wishlist_id = isset( $_POST['wishlist_id'] ) ? sanitize_text_field( $_POST['wishlist_id'] ) : "";
	
	if( empty( $wishlist_id ) || ! is_user_logged_in() ) die();
	
	$nepickplugins_wl_wishlist_ID = wp_insert_post( array(
		'post_title' 	=>  get_the_title( $wishlist_id ),
		'post_name' 	=> sanitize_title( get_the_title( $wishlist_id ) ),
		'post_type' 	=> 'wishlist',
		'post_status' 	=> 'publish',
		'author' 		=> get_current_user_id(),
	) );
	
	update_post_meta( $nepickplugins_wl_wishlist_ID, 'wishlist_status', 'public' );
	
	$wishlisted_items = pickplugins_wl_get_wishlisted_items( $wishlist_id );
	
	foreach( $wishlisted_items as $item ){
	
		pickplugins_wl_add_to_wishlist( $nepickplugins_wl_wishlist_ID, $item->post_id );
	}

    $wishlist_settings = get_option('wishlist_settings');
    $archive_page_id = isset($wishlist_settings['archives']['page_id']) ? $wishlist_settings['archives']['page_id'] : '';


	$item_url		= basename( get_permalink( $nepickplugins_wl_wishlist_ID ) );
	$item_slug		= basename( parse_url($item_url, PHP_URL_PATH) );
	
	if( ! empty( $archive_page_id ) ) $single_url = get_the_permalink( $nepickplugins_wl_wishlist_ID );
	else $single_url = $archive_page_id;
		
	echo $single_url;
	
	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_wishlist_copy', 'pickplugins_wl_ajax_wishlist_copy');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_wishlist_copy', 'pickplugins_wl_ajax_wishlist_copy');	



/* Update Wishlist Vote */
/* ===== === ===== */

function pickplugins_wl_ajax_update_vote(){
	
	$wishlist_id	= isset( $_POST['wishlist_id'] ) ? sanitize_text_field( $_POST['wishlist_id'] ) : "";
	$vote_type		= isset( $_POST['vote_type'] ) ? sanitize_text_field( $_POST['vote_type'] ) : "";
	
	if( empty( $wishlist_id ) || empty( $vote_type ) || ! is_user_logged_in() ) die();
	
	$pickplugins_wl_votes = get_post_meta( $wishlist_id, 'pickplugins_wl_votes', true );
	if( empty( $pickplugins_wl_votes ) ) $pickplugins_wl_votes = array();
	
	
	$pickplugins_wl_votes[get_current_user_id()]['action'] = $vote_type;
	update_post_meta( $wishlist_id, 'pickplugins_wl_votes', $pickplugins_wl_votes );
	
	
	$vote_count = pickplugins_wl_get_votes_count( $wishlist_id );
	
	echo json_encode($vote_count);
	
	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_update_vote', 'pickplugins_wl_ajax_update_vote');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_update_vote', 'pickplugins_wl_ajax_update_vote');	






/* Update Wishlist from Popup */
/* ===== === ===== */

function pickplugins_wl_ajax_update_wishlist(){
	
	$pickplugins_wl_action	= isset( $_POST['pickplugins_wl_action'] ) ? sanitize_text_field( $_POST['pickplugins_wl_action'] ) : "";
	$wishlist_id			= isset( $_POST['wishlist_id'] ) ? sanitize_text_field( $_POST['wishlist_id'] ) : "";
	$wishlist_title			= isset( $_POST['wishlist_title'] ) ? sanitize_text_field( $_POST['wishlist_title'] ) : "";
	$wishlist_sd			= isset( $_POST['wishlist_sd'] ) ? sanitize_text_field( $_POST['wishlist_sd'] ) : "";
	$wishlist_status		= isset( $_POST['wishlist_status'] ) ? sanitize_text_field( $_POST['wishlist_status'] ) : "public";

    $wishlist_settings = get_option('wishlist_settings');
    $archive_page_id = isset($wishlist_settings['archives']['page_id']) ? $wishlist_settings['archives']['page_id'] : '';

    $wishlist_post_data = get_post($wishlist_id);
    $wishlist_author_id = $wishlist_post_data->post_author;

    $current_user_id = get_current_user_id();


    if($wishlist_author_id != $current_user_id){
        return;
        die();
    }
	
	if( $pickplugins_wl_action === "delete" ){

		wp_delete_post( $wishlist_id, true );
		
		echo get_the_permalink( $archive_page_id );
		die();
	}
	
	if( $pickplugins_wl_action === "update" ){

		
		$ret = wp_update_post ( array(
			'ID'           	=> $wishlist_id,
			'post_title'   	=> $wishlist_title,
			'post_name'		=> sanitize_title( $wishlist_title ),
			'post_content' 	=> $wishlist_sd,
		) );
		
		update_post_meta( $wishlist_id, 'wishlist_status', $wishlist_status );
		
		$item_url		= basename( get_permalink( $wishlist_id ) );
		$item_slug		= basename( parse_url($item_url, PHP_URL_PATH) );
	
		//if( ! empty( $wishlist_page ) ) $single_url = get_the_permalink( $wishlist_page ) . "?list=$item_slug";

		//else $single_url = get_the_permalink( $wishlist_id );

		$single_url = get_the_permalink( $wishlist_id );
		
		echo $single_url;
		
		die();
	}


	echo "<li class='menu_item add_new'><i class='fa fa-plus'></i> ".__('Add New', 'wishlist')."</li>";
    ?>
    <li class='menu_item create'>
        <div class='wishlist-create-wrap'>
            <div class='wishlist-create'>

                <h2 class='wishlist-create-title'><?php echo __('Create your wishlist', 'wishlist' ); ?></h2>


                <input type='text' class='wishlist_name' placeholder='<?php echo __( 'Wishlist Name', 'wishlist' ); ?>'>
                <input type='hidden' class='item_id' value=''>


                <div class='wl-button wishlist-create-cancel'><?php echo __( 'Cancel', 'wishlist' ); ?></div>
                <div class='wl-button wishlist-create-save'><?php echo __( 'Create Wishlist', 'wishlist' ); ?></div>

            </div>
        </div>
    </li>
    <?php

	
	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_update_wishlist', 'pickplugins_wl_ajax_update_wishlist');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_update_wishlist', 'pickplugins_wl_ajax_update_wishlist');	


/* Load Menu Items on Hover */
/* ===== === ===== */

function pickplugins_wl_ajax_get_wishlist_menu_items(){

    $wishlist_settings = get_option('wishlist_settings');

    $default_wishlist_id = isset($wishlist_settings['default_wishlist_id']) ? $wishlist_settings['default_wishlist_id'] : '';

	$item_id 	 		= isset( $_POST['item_id'] ) ? sanitize_text_field($_POST['item_id']) : 0;
	$current_user_id 	= get_current_user_id();
	$wishlisted_array 	= pickplugins_wl_is_wishlisted( $item_id );
	
	$total_items 		= " (". count( pickplugins_wl_get_wishlisted_items( $default_wishlist_id, -1, 1, true ) ) .")";
	
	if( !empty( $default_wishlist_id ) && in_array( $default_wishlist_id, $wishlisted_array ) )
		echo "<li class='menu_item wishlist_saved' wishlist='$default_wishlist_id'><i class='fa fa-heart' aria-hidden='true'></i> ".get_the_title($default_wishlist_id)." $total_items</li>";
	else echo "<li class='menu_item' wishlist='$default_wishlist_id'><i class='fa fa-heart' aria-hidden='true'></i> ".get_the_title($default_wishlist_id)." $total_items</li>";
	
	$wishlist_array = get_posts( array(
		'post_type' => 'wishlist',
		'author' => $current_user_id,
		'post__not_in' => array( $default_wishlist_id ),
		'posts_per_page' => -1,
	) );
		
	foreach( $wishlist_array as $list ):
	
	$total_items = " (". count( pickplugins_wl_get_wishlisted_items( $list->ID, -1, 1, true ) ) .")";
	
	if( $wishlisted_array && in_array( $list->ID, $wishlisted_array ) )
		echo "<li class='menu_item wishlist_saved' wishlist='{$list->ID}'><i class='fa fa-heart' aria-hidden='true'></i> {$list->post_title} $total_items</li>";
	else echo "<li class='menu_item' wishlist='{$list->ID}'><i class='fa fa-heart' aria-hidden='true'></i> {$list->post_title} $total_items</li>";

	endforeach;

	echo "<li class='menu_item add_new'><i class='fa fa-plus'></i> ".__('Add New', 'wishlist')."</li>";
    ?>
    <li class='menu_item create'>
        <div class='wishlist-create-wrap'>
            <div class='wishlist-create'>

                <input type='text' class='wishlist_name' placeholder='<?php echo __( 'Wishlist Name', 'wishlist' ); ?>'>
                <input type='hidden' class='item_id' value=''>


                <div class='wl-button wishlist-create-cancel'><?php echo __( 'Cancel', 'wishlist' ); ?></div>
                <div class='wl-button wishlist-create-save'><?php echo __( 'Create Wishlist', 'wishlist' ); ?></div>

            </div>
        </div>
    </li>
    <?php


	
	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_get_wishlist_menu_items', 'pickplugins_wl_ajax_get_wishlist_menu_items');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_get_wishlist_menu_items', 'pickplugins_wl_ajax_get_wishlist_menu_items');	


function pickplugins_wl_ajax_add_remove_item_on_wishlist(){
    $response = array();

	$pickplugins_wl_action = isset( $_POST['pickplugins_wl_action'] ) ? sanitize_text_field($_POST['pickplugins_wl_action']) : "";
	$item_id = isset( $_POST['item_id'] ) ? sanitize_text_field($_POST['item_id']) : "";
	$wishlist_id = isset( $_POST['wishlist_id'] ) ? sanitize_text_field($_POST['wishlist_id']) : "";
	
	if( empty( $pickplugins_wl_action ) || empty( $item_id ) || ! is_user_logged_in() ) die();
	
	if( empty( $wishlist_id ) ) $wishlist_id = get_option( 'pickplugins_wl_default_wishlist_id' );
	
	if( $pickplugins_wl_action == "remove_from_wishlist" ){
		
		//echo pickplugins_wl_remove_from_wishlist( $wishlist_id, $item_id ) ? "removed" : "not";
        pickplugins_wl_remove_from_wishlist( $wishlist_id, $item_id );

        $response['status'] = 'removed';
		//die();
	}
	
	if( $pickplugins_wl_action == "add_in_wishlist" ){
		
		//echo pickplugins_wl_add_to_wishlist( $wishlist_id, $item_id ) ? "added" : "";
        pickplugins_wl_add_to_wishlist( $wishlist_id, $item_id );

        $response['status'] = 'added';
		//die();
	}

    $response['count'] = do_shortcode("[wishlist_count_by_post id='".$item_id."']");

    echo json_encode( $response );

	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_add_remove_item_on_wishlist', 'pickplugins_wl_ajax_add_remove_item_on_wishlist');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_add_remove_item_on_wishlist', 'pickplugins_wl_ajax_add_remove_item_on_wishlist');


function pickplugins_wl_ajax_create_save_wishlist(){

    $responses = array();

	$wishlist_name 	= isset( $_POST['wishlist_name'] ) ? sanitize_text_field($_POST['wishlist_name']) : "";
	$item_id 	= isset( $_POST['item_id'] ) ? sanitize_text_field($_POST['item_id']) : "";
	
	if( is_user_logged_in() ){
		
		$wishlist_ID = wp_insert_post( array(
			'post_title' 	=> $wishlist_name,
			'post_type' 	=> 'wishlist',
			'post_status' 	=> 'publish',
			'author' 		=> get_current_user_id(),
		) );

		update_post_meta( $wishlist_ID, 'wishlist_status', 'public' );
		pickplugins_wl_add_to_wishlist( $wishlist_ID, $item_id );

        $responses['wishlist_id'] = $wishlist_ID;

	}



	echo json_encode($responses);
	
	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_create_save_wishlist', 'pickplugins_wl_ajax_create_save_wishlist');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_create_save_wishlist', 'pickplugins_wl_ajax_create_save_wishlist');	
