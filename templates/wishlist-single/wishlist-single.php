<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


	
$current_user_id 		= get_current_user_id();
$pickplugins_wl_list_items_per_page = get_option( 'pickplugins_wl_list_items_per_page' );
$pickplugins_wl_default_wishlist_id = get_option( 'pickplugins_wl_default_wishlist_id' );
$pickplugins_wl_wishlist_page = get_option( 'pickplugins_wl_wishlist_page' );

if( empty( $pickplugins_wl_list_items_per_page ) ) $pickplugins_wl_list_items_per_page = 10;

if( $pickplugins_wl_default_wishlist_id == $wishlist_id ) {
	
	$items_to_default 		= get_post_meta( $pickplugins_wl_default_wishlist_id, 'pickplugins_wl_wishlisted_items_to_default', true );
	$pickplugins_wl_wishlisted_items 	= isset( $items_to_default[$current_user_id] ) ? $items_to_default[$current_user_id] : array();
}
else {
	$pickplugins_wl_wishlisted_items 	= get_post_meta( $wishlist_id, 'pickplugins_wl_wishlisted_items', true );
}

$wishlist_status = get_post_meta( $wishlist_id, 'wishlist_status', true );
if( empty( $wishlist_status ) ) $wishlist_status = "public";


$pickplugins_wl_wishlist_tags = array();
foreach( wp_get_post_terms( $wishlist_id, 'wishlist_tags' ) as $term ) $pickplugins_wl_wishlist_tags[] = $term->name;


?>

<script>jQuery(document).ready(function($) { $("body").trigger("pickplugins_wl_set_views", [<?php echo $wishlist_id; ?>]); }) </script>


<div class="pickplugins_wl_wishlist_single pick woocommerce single-wishlist">


    <!-- User Permission Check -->

	<?php if( $wishlist_status == 'private' && get_post_field( 'post_author', $wishlist_id ) != $current_user_id && $wishlist_id != $pickplugins_wl_default_wishlist_id ) { ?>
    <p class='pick_notice pick_error'><?php echo __("Sorry, You are not authorize to view this wishlist.", 'wishlist' ); ?></p>
</div>
<?php return; }  ?>

<!-- User Permission Check End -->



<!-- User login Check -->

<?php if( ! is_user_logged_in() && $wishlist_status == 'private' ) { ?>
    <p class='pick_notice pick_error'><?php echo sprintf(__('You must <a href="%s">Logged</a> in to see Wishlists','wishlist'), wp_login_url( get_permalink() )); ?></p> </div>
	<?php return; } ?>


<!-- User login Check End -->

    <?php

    /*
     * Main content for single wishlist
     * */

    do_action('wishlist_single_main');
    ?>
	
	


	
	
	
</div>











