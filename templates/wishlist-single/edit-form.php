<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$wishlist_id = get_the_id();
$wishlist_status = get_post_meta( $wishlist_id, 'wishlist_status', true );
if( empty( $wishlist_status ) ) $wishlist_status = "public";

$pickplugins_wl_wishlist_tags = array();
foreach( wp_get_post_terms( $wishlist_id, 'wishlist_tags' ) as $term ) $pickplugins_wl_wishlist_tags[] = $term->name;


?>




<!-- Popup Edit Screen Start -->
<!-- ===== ***** ===== -->

<div class="pickplugins_wl_popup_container pickplugins_wl_popup_edit" wishlist_id="<?php echo $wishlist_id; ?>">
    <div class="pickplugins_wl_popup_box">

        <h2 class="pickplugins_wl_popup_title"><?php echo __('Edit', 'wishlist')." <i>". get_the_title( $wishlist_id )."</i>"; ?></h2>

        <p class='pick_notice'></p>

        <div class='pickplugins_wl_popup_section'>
            <h5 class="pickplugins_wl_popup_section_title"><?php echo __('Title', 'wishlist'); ?></h5>
            <input type="text" class="pickplugins_wl_wishlist_title" value="<?php echo get_the_title( $wishlist_id ); ?>" />
        </div>

        <div class='pickplugins_wl_popup_section'>
            <h5 class="pickplugins_wl_popup_section_title"><?php echo __('Short Description', 'wishlist'); ?></h5>
            <textarea type="text" class="pickplugins_wl_wishlist_sd" rows="5" cols="40"><?php echo get_the_content(); ?></textarea>
        </div>

        <div class='pickplugins_wl_popup_section'>
            <h5 class="pickplugins_wl_popup_section_title"><?php echo __('Wishlist Status', 'wishlist'); ?></h5>
            <select class="pickplugins_wl_wishlist_status">
				<?php foreach( pickplugins_wl_get_all_status() as $status => $label ) : ?>
                    <option value="<?php echo $status; ?>" <?php selected( $wishlist_status, $status ); ?>><?php echo $label; ?></option>
				<?php endforeach; ?>
            </select>

        </div>

		<?php if( get_option( 'pickplugins_wl_enable_tags' ) != 'no' ) : ?>
            <div class='pickplugins_wl_popup_section'>
                <h5 class="pickplugins_wl_popup_section_title"><?php echo __('Tags - Comma separated', 'wishlist'); ?></h5>
                <input type="text" class="pickplugins_wl_wishlist_tags" value="<?php echo implode( ",",$pickplugins_wl_wishlist_tags); ?>" />
            </div>
		<?php endif; ?>

        <div class="pickplugins_wl_popup_btn pickplugins_wl_popup_cancel"><i class="fa fa-times" aria-hidden="true"></i> <?php echo __("Cancel", 'wishlist' ); ?></div>
        <div class="pickplugins_wl_popup_btn pickplugins_wl_popup_save"><i class="fa fa-check" aria-hidden="true"></i> <?php echo __("Save Changes", 'wishlist' ); ?></div>

    </div>

</div>
