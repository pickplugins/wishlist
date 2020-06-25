<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


add_action( 'pickplugins_wl_loop_single_item', 'pickplugins_wl_loop_single_item_function', 10, 2 );

add_action( 'pickplugins_wl_loop_single_item_main', 'pickplugins_wl_loop_single_item_thumb', 5, 2 );
add_action( 'pickplugins_wl_loop_single_item_main', 'pickplugins_wl_loop_single_item_title', 10, 2 );
add_action( 'pickplugins_wl_loop_single_item_main', 'pickplugins_wl_loop_single_item_woo_add_to_cart', 15, 2 );



function pickplugins_wl_loop_single_item_woo_add_to_cart( $item_id ){
	
	if( get_post_type( $item_id ) == 'product' ) echo do_shortcode("[add_to_cart id='$item_id']");
	
	if( class_exists( 'Easy_Digital_Downloads' ) && get_post_type( $item_id ) == 'download' ) {
		
		echo edd_get_purchase_link( array( 'download_id' => $item_id ) ); 
	}
}

function pickplugins_wl_loop_single_item_title( $item_id ){
	
	$html  = "<a class='wl-title' href='".get_the_permalink( $item_id )."'>";
	$html .= get_the_title( $item_id );
	$html .= "</a>";
	
	echo apply_filters( 'pickplugins_wl_filter_loop_single_title', $html, $item_id );
}

function pickplugins_wl_loop_single_item_thumb( $item_id ){
	
	$item_thumb_url = get_the_post_thumbnail_url( $item_id );
	
	$html  = "<a class='wl-thumb' href='".get_the_permalink( $item_id )."'>";
	$html .= "<span style='background-image: url($item_thumb_url);'></span>";
	$html .= "</a>";
	
	echo apply_filters( 'pickplugins_wl_filter_loop_single_thumb', $html, $item_id );
}


function pickplugins_wl_loop_single_item_function( $item_id, $wishlist_id ){
	
	echo "<div class='wl-single-item' item_id='$item_id'>";
	do_action( 'pickplugins_wl_loop_single_item_main', $item_id, $wishlist_id );
	echo "</div>";
}
