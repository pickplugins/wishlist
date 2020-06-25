<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	// $item_id - int; $show_count - string

	$button_color_normal	= get_option( 'pickplugins_wl_button_color_normal' );
	$button_color_active	= get_option( 'pickplugins_wl_button_color_active' );
	$button_font_size		= get_option( 'pickplugins_wl_button_font_size' );
	$default_list_id		= get_option( 'pickplugins_wl_default_wishlist_id' );
	$wishlisted_array 		= pickplugins_wl_is_wishlisted( $item_id );
	
	// echo "<pre>"; print_r( $wishlisted_array ); echo "</pre>";
?>

<div class="pickplugins_wl_wishlist_buttons" style="font-size:<?php echo $button_font_size; ?>px" item_id="<?php echo $item_id; ?>">

	<?php if( is_user_logged_in() ) : ?>
	
	<div class="pickplugins_wl_wishlist_menu hint--top" aria-label="<?php echo apply_filters( 'pickplugins_wl_filter_wishlist_menu_icon_hint_text', __( 'Save in...', 'wishlist' ) ); ?>">
	
		<span class="pickplugins_wl_wishlist_menu_icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
		<ul id='pickplugins_wl_menu_items' class='pickplugins_wl_menu_items' item_id="<?php echo $item_id; ?>"></ul>
		
	</div>
		
	<?php 
	if( $wishlisted_array ) { 
	
		$styles 	= "color:$button_color_active;";
		$saved_in 	= isset($wishlisted_array[count($wishlisted_array)-1]) ? $wishlisted_array[count($wishlisted_array)-1] : "";
		
		echo apply_filters( "pickplugins_wl_filter_wishlist_save_icon_html", "<div style='$styles' class='pickplugins_wl_wishlist_save pickplugins_wl_wishlist_save_$item_id pickplugins_wl_saved hint--top' aria-label='Saved in ".get_the_title( $saved_in )."' wishlist_id='$saved_in'><span class='pickplugins_wl_wishlist_save_icon'><i class='fa fa-heart' aria-hidden='true'></i></span></div>", $item_id );
		
		
	} else { 
		
		$styles 	= "color:$button_color_normal;";
		$hint_text 	= apply_filters( "pickplugins_wl_filter_wishlist_save_icon_hint_text", __( 'Add to Favourites', 'wishlist' ), $item_id );
		
		echo apply_filters( "pickplugins_wl_filter_wishlist_save_icon_html", "<div style='$styles' class='pickplugins_wl_wishlist_save pickplugins_wl_wishlist_save_$item_id hint--top' aria-label='$hint_text' wishlist_id='$default_list_id'> <span class='pickplugins_wl_wishlist_save_icon'><i class='fa fa-heart' aria-hidden='true'></i></span></div>", $item_id );

	}
	
	else: ?>
	
	<div class="pickplugins_wl_wishlist_save hint--top not-logged-in" aria-label="<?php echo apply_filters( 'pickplugins_wl_filter_wishlist_save_icon_not_logged_in_hint_text', __( 'Please Login', 'wishlist' ) ); ?>"><span class="pickplugins_wl_wishlist_save_icon"><i class='fa fa-heart' aria-hidden='true'></i></span></div>

	<?php endif; ?>
	
	<?php if( $show_count == 'yes' ) : ?> 
		<span class="pickplugins_wl_item_count hint--top not-logged-in" aria-label="Total wishlited">
			<?php echo pickplugins_wl_get_wishlist_count( $item_id ); ?>
		</span> 
	<?php endif; ?>
	
</div>




	
	
	

