<?php


if ( ! defined('ABSPATH')) exit;  // if direct access 

add_filter('wishlist_settings_tabs', 'wishlist_settings_tabs_edd');

function wishlist_settings_tabs_edd($tabs){

    $current_tab = isset($_REQUEST['tab']) ? sanitize_text_field($_REQUEST['tab']) : 'general';


    $tabs[] = array(
        'id' => 'edd',
        'title' => sprintf(__('%s EDD','wishlist'),'<i class="fas fa-cart-plus"></i>'),
        'priority' => 15,
        'active' => ($current_tab == 'edd') ? true : false,
    );

    return $tabs;

}






add_action('wishlist_settings_content_edd', 'wishlist_settings_content_edd');

function wishlist_settings_content_edd(){
    $settings_tabs_field = new settings_tabs_field();

    $wishlist_settings = get_option('wishlist_settings');

    $on_shop = isset($wishlist_settings['woocommerce']['on_shop']) ? $wishlist_settings['woocommerce']['on_shop'] : 'none';
    $on_shop_position = isset($wishlist_settings['woocommerce']['on_shop_position']) ? $wishlist_settings['woocommerce']['on_shop_position'] : 'before_addtocart';

    $on_product = isset($wishlist_settings['woocommerce']['on_product']) ? $wishlist_settings['woocommerce']['on_product'] : 'none';
    $on_product_position = isset($wishlist_settings['woocommerce']['on_product_position']) ? $wishlist_settings['woocommerce']['on_product_position'] : 'title';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('WooCommerce Settings', 'wishlist'); ?></div>
        <p class="description section-description"><?php echo __('Choose WooCommerce settings.', 'wishlist'); ?></p>

        <?php

        $args = array(
            'id'		=> 'on_shop',
            'parent'		=> 'wishlist_settings[woocommerce]',
            'title'		=> __('Display on shop page','wishlist'),
            'details'	=> __('Display wishlist button on WooCommerce shop page automatically.','wishlist'),
            'type'		=> 'select',
            'value'		=> $on_shop,
            'default'		=> '',
            'args'		=> array('yes'=>'Yes','no'=>'No'),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'on_shop_position',
            'parent'		=> 'wishlist_settings[woocommerce]',
            'title'		=> __('Position on shop page','wishlist'),
            'details'	=> __('Display wishlist button position on shop page.','wishlist'),
            'type'		=> 'select',
            'value'		=> $on_shop_position,
            'default'		=> '',
            'args'		=> array(
                'before_addtocart' 	=> __('Before Add to Cart', 'wishlist'),
                'after_addtocart'	=> __('After Add to Cart', 'wishlist'),
            ),
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'on_product',
            'parent'		=> 'wishlist_settings[woocommerce]',
            'title'		=> __('Display on product page','wishlist'),
            'details'	=> __('Display wishlist button on WooCommerce product page automatically.','wishlist'),
            'type'		=> 'select',
            'value'		=> $on_shop,
            'default'		=> '',
            'args'		=> array('yes'=>'Yes','no'=>'No'),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'on_product_position',
            'parent'		=> 'wishlist_settings[woocommerce]',
            'title'		=> __('Position on product page','wishlist'),
            'details'	=> __('Display wishlist button position on product page.','wishlist'),
            'type'		=> 'select',
            'value'		=> $on_product_position,
            'default'		=> '',
            'args'		=> array(
                'title' 		=> __('Title', 'wishlist'),
                'ratings'		=> __('Ratings', 'wishlist'),
                'price'			=> __('Price', 'wishlist'),
                'excerpt'		=> __('Excerpt', 'wishlist'),
                'meta'			=> __('Meta', 'wishlist'),
                'sharing'		=> __('Sharing', 'wishlist'),
                'add_to_cart'	=> __('Add to Cart', 'wishlist'),
            ),
        );

        $settings_tabs_field->generate_field($args);









        ?>

    </div>

    <?php





}




