<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$wishlist_id = get_the_id();
$current_user_id 		= get_current_user_id();
$pickplugins_wl_default_wishlist_id = get_option( 'pickplugins_wl_default_wishlist_id' );

?>

<!-- Editing Buttons -->

<?php if( get_post_field( 'post_author', $wishlist_id ) == $current_user_id && $pickplugins_wl_default_wishlist_id != $wishlist_id ) : ?>
    <div class="pickplugins_wl_editing">
        <div class="button pickplugins_wl_button_delete"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo __("Delete", 'wishlist' ); ?></div>
        <div class="button pickplugins_wl_button_edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo __("Edit", 'wishlist' ); ?></div>
    </div>

<?php elseif( is_user_logged_in() ) : ?>



<?php endif; ?>
<!-- Editing Buttons End -->