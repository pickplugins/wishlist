<?php


if ( ! defined('ABSPATH')) exit;  // if direct access 

function wishlist_settings_migrate(){

    $wishlist_settings = get_option('wishlist_settings');





    if(empty($wishlist_settings)){

        $pickplugins_wl_wishlist_page = get_option('pickplugins_wl_wishlist_page');
        $pickplugins_wl_enable_wc_shop = get_option('pickplugins_wl_enable_wc_shop');
        $pickplugins_wl_wc_shop_on = get_option('pickplugins_wl_wc_shop_on');
        $pickplugins_wl_enable_wc_product = get_option('pickplugins_wl_enable_wc_product');
        $pickplugins_wl_wc_product_under = get_option('pickplugins_wl_wc_product_under');
        $pickplugins_wl_breadcrumb_enable = get_option('pickplugins_wl_breadcrumb_enable');
        $pickplugins_wl_breadcrumb_home_text = get_option('pickplugins_wl_breadcrumb_home_text');
        $pickplugins_wl_breadcrumb_text_color = get_option('pickplugins_wl_breadcrumb_text_color');
        $pickplugins_wl_list_per_page = get_option('pickplugins_wl_list_per_page');
        $pickplugins_wl_list_items_per_page = get_option('pickplugins_wl_list_items_per_page');

        $pickplugins_wl_button_font_size = get_option('pickplugins_wl_button_font_size');
        $pickplugins_wl_button_color_normal = get_option('pickplugins_wl_button_color_normal');
        $pickplugins_wl_button_color_active = get_option('pickplugins_wl_button_color_active');
        $wishlist_heart_icon_html = get_option('wishlist_heart_icon_html');
        $wishlist_heart_loading_icon_html = get_option('wishlist_heart_loading_icon_html');

        $pickplugins_wl_views_display = get_option('pickplugins_wl_views_display');
        $pickplugins_wl_vote_enable = get_option('pickplugins_wl_vote_enable');
        $pickplugins_wl_share_enable = get_option('pickplugins_wl_share_enable');
        $pickplugins_wl_social_platforms = get_option('pickplugins_wl_social_platforms');


        $pickplugins_wl_default_wishlist_id = get_option('pickplugins_wl_default_wishlist_id');



        $wishlist_settings['general']['font_aw_version'] = 'v_5';
        $wishlist_settings['post_types_display'] = array();

        $wishlist_settings['archives']['page_id'] = $pickplugins_wl_wishlist_page;
        $wishlist_settings['archives']['pagination_per_page'] = $pickplugins_wl_list_per_page;
        $wishlist_settings['archives']['pagination_font_size'] = '';
        $wishlist_settings['archives']['pagination_color_idle'] = '';
        $wishlist_settings['archives']['pagination_color_active'] = '';

        $wishlist_settings['wishlist_page']['breadcrumb_enable'] = $pickplugins_wl_breadcrumb_enable;
        $wishlist_settings['wishlist_page']['breadcrumb_home_text'] = $pickplugins_wl_breadcrumb_home_text;
        $wishlist_settings['wishlist_page']['breadcrumb_text_color'] = $pickplugins_wl_breadcrumb_text_color;


        $wishlist_settings['wishlist_page']['pagination_per_page'] = $pickplugins_wl_list_items_per_page;
        $wishlist_settings['wishlist_page']['pagination_font_size'] = '';
        $wishlist_settings['wishlist_page']['pagination_color_idle'] = '';
        $wishlist_settings['wishlist_page']['pagination_color_active'] = '';

        $wishlist_settings['style']['font_size'] = $pickplugins_wl_button_font_size.'px';
        $wishlist_settings['style']['color_active']= $pickplugins_wl_button_color_normal;
        $wishlist_settings['style']['color_idle']= $pickplugins_wl_button_color_active;
        $wishlist_settings['style']['icon_active']= $wishlist_heart_icon_html;
        $wishlist_settings['style']['icon_inactive']= $wishlist_heart_icon_html;
        $wishlist_settings['style']['icon_loading']= $wishlist_heart_loading_icon_html;



        $wishlist_settings['woocommerce']['on_shop']= $pickplugins_wl_enable_wc_shop;
        $wishlist_settings['woocommerce']['on_shop_position'] = $pickplugins_wl_wc_shop_on;
        $wishlist_settings['woocommerce']['on_product'] = $pickplugins_wl_enable_wc_product;
        $wishlist_settings['woocommerce']['on_product_position'] = $pickplugins_wl_wc_product_under;



        update_option('wishlist_settings',$wishlist_settings);




    }

}