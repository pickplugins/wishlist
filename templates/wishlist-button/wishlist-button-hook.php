<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

	
add_action('wishlist_button', 'wishlist_button_wrap');

function wishlist_button_wrap($atts){

    $item_id 	= isset( $atts['id'] ) ? $atts['id'] : 0;
    $show_count = isset( $atts['show_count'] ) ? $atts['show_count'] : '';
    $show_menu = isset( $atts['show_menu'] ) ? $atts['show_menu'] : '';
    $icon_active = isset( $atts['icon_active'] ) ? $atts['icon_active'] : '<i class="fas fa-heart"></i>';
    $icon_inactive = isset( $atts['icon_inactive'] ) ? $atts['icon_inactive'] : '<i class="far fa-heart"></i>';
    $icon_loading = isset( $atts['icon_loading'] ) ? $atts['icon_loading'] : '<i class="fas fa-spinner fa-spin"></i>';

    $wishlist_settings = get_option('wishlist_settings');

    $style = isset($wishlist_settings['style']) ? $wishlist_settings['style'] : array();
    $font_size = isset($style['font_size']) ? $style['font_size'] : '14px';
    $color_idle = isset($style['color_idle']) ? $style['color_idle'] : '';
    $color_active = isset($style['color_active']) ? $style['color_active'] : '';

    //echo '<pre>'.var_export($icon_active, true).'</pre>';

    //var_dump($show_count);



    $default_list_id		= get_option( 'pickplugins_wl_default_wishlist_id' );
    $wishlisted_array 		= pickplugins_wl_is_wishlisted( $item_id );

    ?>
    <div class="wishlist-button-wrap" item_id="<?php echo $item_id; ?>" icon_loading="<?php echo esc_attr($icon_loading); ?>" icon_active="<?php echo esc_attr($icon_active); ?>" icon_inactive="<?php echo esc_attr($icon_inactive); ?>" >

        <?php if( is_user_logged_in() ) :

            ?>
            <?php if($show_menu == 'yes'): ?>
                <div class="wishlist_button_menu hint--top" aria-label="<?php echo apply_filters( 'wishlist_menu_label', __( 'Save in...', 'wishlist' ) ); ?>">
                    <span class="wishlist_button_menu_icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
                    <ul class='menu_items' item_id="<?php echo $item_id; ?>"></ul>
                </div>
            <?php endif; ?>
            <?php
            if( $wishlisted_array ) {

                $saved_in 	= isset($wishlisted_array[count($wishlisted_array)-1]) ? $wishlisted_array[count($wishlisted_array)-1] : "";

                echo apply_filters( "wishlist_save_html", "<div class='wishlist_save wishlist_save_$item_id wishlist_saved hint--top' aria-label='Saved in ".get_the_title( $saved_in )."' wishlist_id='$saved_in'><span class='wishlist_save_icon'>".html_entity_decode($icon_active)."</span></div>", $item_id );


            } else {

                $hint_text 	= apply_filters( "wishlist_save_label", __( 'Add to Favourites', 'wishlist' ), $item_id );

                echo apply_filters( "wishlist_save_html", "<div class='wishlist_save wishlist_save_$item_id hint--top' aria-label='$hint_text' wishlist_id='$default_list_id'> <span class='wishlist_save_icon'>".html_entity_decode($icon_active)."</span></div>", $item_id );

            }

        else: ?>

            <div class="wishlist_save hint--top not-logged-in" aria-label="<?php echo apply_filters( 'wishlist_save_login_label', __( 'Please Login', 'wishlist' ) ); ?>"><span class="wishlist_save_icon"><i class='fa fa-heart' aria-hidden='true'></i></span></div>

        <?php endif; ?>

        <?php if( $show_count == 'yes' ) : ?>
            <div class="wishlist_count hint--top not-logged-in" aria-label="Total wishlited">
			    <?php echo pickplugins_wl_get_wishlist_count( $item_id ); ?>
		    </div>
        <?php endif; ?>

    </div>

    <?php

}

add_action('wishlist_button', 'wishlist_button_style');

function wishlist_button_style($atts){

    $wishlist_settings = get_option('wishlist_settings');

    $style = isset($wishlist_settings['style']) ? $wishlist_settings['style'] : array();
    $font_size = isset($style['font_size']) ? $style['font_size'] : '14px';
    $color_idle = isset($style['color_idle']) ? $style['color_idle'] : '';
    $color_active = isset($style['color_active']) ? $style['color_active'] : '';



    ?>

    <style>
        .wishlist-button-wrap{
            font-size:<?php echo $font_size; ?> !important;
        }

        .wishlist_save{
            color:<?php echo $color_idle; ?> !important;
        }
        .wishlist_saved{
            color:<?php echo $color_active; ?> !important;
        }
    </style>
    <?php
}












