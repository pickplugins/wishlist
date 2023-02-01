<?php
if ( ! defined('ABSPATH')) exit;  // if direct access



add_action('wishlist_metabox_content_options', 'wishlist_metabox_content_options');

if(!function_exists('wishlist_metabox_content_options')) {
    function wishlist_metabox_content_options($post_id){

        $settings_tabs_field = new settings_tabs_field();


			$wishlist_status		= get_post_meta( $post_id, 'wishlist_status', true);


        ?>
        <div class="section">
            <div class="section-title">Wishlist Options</div>
            <p class="description section-description">Set some basic wishlist options.</p>


            <?php





            $args = array(
                'id'		=> 'wishlist_status',
                // 'parent'		=> 'wishlist_options[query]',
                'title'		=> __('Is private','wishlist'),
                'details'	=> __('Set wishlist visiblity status.','wishlist'),
                'type'		=> 'text',
                'value'		=> $wishlist_status,
                'args'		=> array(
                    'public'=>__('Public','wishlist'),
                    'private'=>__('Private','wishlist'),
                ),
            );

            $settings_tabs_field->generate_field($args);








            ?>

        </div>

        <?php






    }
}









add_action('wishlist_metabox_save','wishlist_metabox_save');

function wishlist_metabox_save($post_id){




    $wishlist_status = isset($_POST['wishlist_status']) ? sanitize_text_field($_POST['wishlist_status']) : '';
    

update_post_meta($post_id, 'wishlist_status', $wishlist_status);

}

