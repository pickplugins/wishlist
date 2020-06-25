<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$wishlist_id = get_the_id();

?>


<!-- Popup Delete Screen Start -->
<!-- ===== ***** ===== -->

<div class="pickplugins_wl_popup_container pickplugins_wl_popup_delete" wishlist_id="<?php echo $wishlist_id; ?>">
    <div class="pickplugins_wl_popup_box">
        <div class='pickplugins_wl_popup_delete_message'>

            <p class='del_message'><?php echo __('Please confirm to delete?'); ?></p>
        </div>

        <div class="pickplugins_wl_popup_btn pickplugins_wl_popup_cancel"><i class="fa fa-times" aria-hidden="true"></i> <?php echo __("No, Cancel", 'wishlist' ); ?></div>
        <div class="pickplugins_wl_popup_btn pickplugins_wl_popup_delete_confirm"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo __("Yes, Delete", 'wishlist' ); ?></div>

    </div>

</div>