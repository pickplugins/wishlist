<?php

/*
* @Author 		pickplugins
* Copyright: 	pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class Wishlist_Column{
	
	public function __construct(){
		
		add_filter( 'display_post_states', array( $this, 'add_display_post_states' ), 10, 2 );
		
		add_action( 'manage_wishlist_posts_columns', array( $this, 'add_new_columns' ), 16, 1 );
		add_action( 'manage_wishlist_posts_custom_column', array( $this, 'new_columns_content' ), 10, 2 );
		
		add_action( 'post_row_actions', array( $this, 'wishlist_row_actions' ), 10, 1 );
		add_action( 'user_has_cap', array( $this, 'remove_user_cap' ), 10, 3 );
	}
	
	public function add_new_columns( $columns ){
		
		$new_column = array(
			'wishlist-item-count' => esc_html__( 'Total Items', 'wishlist' ),
		);
		
		array_splice( $columns, 2, 0, $new_column );
		return $columns;
	}
	
	public function new_columns_content( $column, $post_id ){
		
	
		if( 'wishlist-item-count' == $column ) {
			
			$all_items 		= pickplugins_wl_get_wishlisted_items( $post_id );
			$total_items 	= count( $all_items );
			
			echo sprintf( "<center><i><strong>%d</strong> <span>%s</span></i></center>", $total_items, __('Items on this List', 'wishlist') );
		}
		
	}
	
			
	public function add_display_post_states( $post_states, $post ){
		
		if ( get_option( 'pickplugins_wl_wishlist_page' ) == $post->ID ) {
			
			$post_states['wishlist_page'] = __( 'Wishlist page', 'wishlist' );
		}
		
		return $post_states;		
	}
	
	public function wishlist_row_actions( $actions ) {
		
		if( get_post_type() === 'wishlist' && get_option( 'pickplugins_wl_default_wishlist_id' ) == get_the_ID() ) {
			unset( $actions['trash'] );
			unset( $actions['delete'] );
		}

		
	/*
	 *
	 *
	$wishlist_page 	= get_option( 'pickplugins_wl_wishlist_page' );
	$item_url		= basename( get_permalink() );
	$item_slug		= basename( parse_url($item_url, PHP_URL_PATH) );

	if( ! empty( $wishlist_page ) ) $single_url = get_the_permalink( $wishlist_page ) . "?list=$item_slug";
	else $single_url = get_home_url();

	$actions['view'] = sprintf( "<a href='%s' rel='bookmark' aria-label='%s'>%s</a>", $single_url, get_the_title(), __('View', 'wishlist') );
	 *
	 * */
		
		return $actions;
	}
	
	public function remove_user_cap( $allcaps, $cap, $args ) {
		
		if( ! isset( $args[2] ) ) return $allcaps;
		if( get_option( 'pickplugins_wl_default_wishlist_id' ) == $args[2] ) {
		
			$allcaps['delete_others_posts'] = false;
			$allcaps['delete_posts'] = false;
			$allcaps['delete_published_posts'] = false;
			return $allcaps;
		}
		return $allcaps;
	}
	
	
} new Wishlist_Column();