<?php



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
			
			echo $total_items;
		}
		
	}
	
			
	public function add_display_post_states( $post_states, $post ){

        $wishlist_settings = get_option('wishlist_settings');
        $archive_page_id = isset($wishlist_settings['archives']['page_id']) ? $wishlist_settings['archives']['page_id'] : '';


		if ( $archive_page_id == $post->ID ) {
			
			$post_states['wishlist_page'] = __( 'Wishlist page', 'wishlist' );
		}
		
		return $post_states;		
	}
	
	public function wishlist_row_actions( $actions ) {

        $wishlist_settings = get_option('wishlist_settings');
        $default_wishlist_id = isset($wishlist_settings['default_wishlist_id']) ? $wishlist_settings['default_wishlist_id'] : '';



		if( get_post_type() === 'wishlist' && $default_wishlist_id == get_the_ID() ) {
			unset( $actions['trash'] );
			unset( $actions['delete'] );
		}

		

		
		return $actions;
	}
	
	public function remove_user_cap( $allcaps, $cap, $args ) {

        $wishlist_settings = get_option('wishlist_settings');
        $default_wishlist_id = isset($wishlist_settings['default_wishlist_id']) ? $wishlist_settings['default_wishlist_id'] : '';


        if( ! isset( $args[2] ) ) return $allcaps;
		if( $default_wishlist_id == $args[2] ) {
		
			$allcaps['delete_others_posts'] = false;
			$allcaps['delete_posts'] = false;
			$allcaps['delete_published_posts'] = false;
			return $allcaps;
		}
		return $allcaps;
	}
	
	
} new Wishlist_Column();