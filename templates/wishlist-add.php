<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	// $item_id;

	$default_list_id	= get_option( 'pickplugins_wl_default_wishlist_id' );
	$wishlisted_array 	= pickplugins_wl_is_wishlisted( $item_id );
	
	// echo "<pre>"; print_r( $wishlisted_array ); echo "</pre>";
	
	
?>

<div class="pickplugins_wl_wishlist_buttons" item_id="<?php echo $item_id; ?>">

	<?php if( is_user_logged_in() ) : ?>
	
	<div class="pickplugins_wl_wishlist_menu hint--top" aria-label="<?php echo apply_filters( 'pickplugins_wl_filter_wishlist_menu_icon_hint_text', __( 'Save in...', 'woo-wishlist' ) ); ?>">
	
		<span class="pickplugins_wl_wishlist_menu_icon dashicons dashicons-menu"></span>
		<ul id='pickplugins_wl_menu_items' class='pickplugins_wl_menu_items' item_id="<?php echo $item_id; ?>"></ul>
		
	</div>
		
	<?php if( $wishlisted_array ) { ?>
	
		<?php $saved_in = isset($wishlisted_array[count($wishlisted_array)-1]) ? $wishlisted_array[count($wishlisted_array)-1] : ""; ?>
		
		<?php echo apply_filters( "pickplugins_wl_filter_wishlist_save_icon_html", "<div class='pickplugins_wl_wishlist_save pickplugins_wl_wishlist_save_$item_id pickplugins_wl_saved hint--top' aria-label='Saved in ".get_the_title( $saved_in )."' wishlist_id='$saved_in'><span class='pickplugins_wl_wishlist_save_icon dashicons dashicons-heart'></span></div>", $item_id ); ?>
		
		
	<?php } else { ?>
		
		<?php $hint_text = apply_filters( "pickplugins_wl_filter_wishlist_save_icon_hint_text", __( 'Add to Favourites', 'woo-wishlist' ), $item_id ); ?>
		
		<?php echo apply_filters( "pickplugins_wl_filter_wishlist_save_icon_html", "<div class='pickplugins_wl_wishlist_save pickplugins_wl_wishlist_save_$item_id hint--top' aria-label='$hint_text' wishlist_id='$default_list_id'> <span class='pickplugins_wl_wishlist_save_icon dashicons dashicons-heart'></span></div>", $item_id ); ?>

	<?php } ?>
	
	<?php else: ?>
	
	<div class="pickplugins_wl_wishlist_save hint--top not-logged-in" aria-label="<?php echo apply_filters( 'pickplugins_wl_filter_wishlist_save_icon_not_logged_in_hint_text', __( 'Please Login', 'woo-wishlist' ) ); ?>"><span class="pickplugins_wl_wishlist_save_icon dashicons dashicons-heart"></span></div>

	<?php endif; ?>

</div>