<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$wishlist_status = get_post_meta( get_the_id(), 'wishlist_status', true );
if( empty( $wishlist_status ) ) $wishlist_status = "public";

?>


<h4 class='wishlist-title'>
	<?php echo get_the_title( ); ?>
    <span class="pickplugins_wl_wishlist_status"><?php echo pickplugins_wl_get_all_status()[$wishlist_status]; ?></span>
</h4>
