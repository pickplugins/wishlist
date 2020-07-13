<?php


if ( ! defined('ABSPATH')) exit;  // if direct access 


function wishlist_single_display($content){

    global $post;

    if ($post->post_type == 'wishlist'){

        $content = do_shortcode("[wishlist_single id='".get_the_id()."']");
        return $content;

    }else{
        return $content;
    }

}

add_filter('the_content','wishlist_single_display');


add_action('wishlist_single', 'wishlist_single_wrap');

function wishlist_single_wrap($atts){

    $wishlist_id = isset( $atts['id'] ) ? $atts['id'] : 0;
    $current_user_id 		= get_current_user_id();

    if(empty($wishlist_id)) return;

    $wishlist_status = get_post_meta( $wishlist_id, 'wishlist_status', true );
    //var_dump($wishlist_status);

    $wishlist_status = !empty( $wishlist_status ) ? $wishlist_status : "public";
    $wishlist_settings = get_option('wishlist_settings');
    $default_wishlist_id = isset($wishlist_settings['default_wishlist_id']) ? $wishlist_settings['default_wishlist_id'] : '';

    $wishlist_author_id = get_post_field( 'post_author', $wishlist_id );

    //var_dump($wishlist_status);





    $wishlist_page = isset($wishlist_settings['wishlist_page']) ? $wishlist_settings['wishlist_page'] : array();
    $pagination_per_page = isset($wishlist_page['pagination_per_page']) ? $wishlist_page['pagination_per_page'] : 10;
    $pagination_font_size = isset($wishlist_page['pagination_font_size']) ? $wishlist_page['pagination_font_size'] : '';
    $pagination_color_idle = isset($wishlist_page['pagination_color_idle']) ? $wishlist_page['pagination_color_idle'] : '';
    $pagination_color_active = isset($wishlist_page['pagination_color_active']) ? $wishlist_page['pagination_color_active'] : '';




    ?>

    <div class="single-wishlist pick woocommerce single-wishlist">

    <div class="pickplugins_wl_wishlist_single pick woocommerce single-wishlist">


        <?php

        if( ($wishlist_status == 'private') && ($wishlist_author_id != $current_user_id) && ($wishlist_id != $default_wishlist_id) ) {
            ?>
            <p class='pick_notice pick_error'><?php echo __("Sorry, You are not authorize to view this wishlist.", 'wishlist' ); ?></p>
            <?php return;
        }

        if( !is_user_logged_in() && $wishlist_status == 'private' ) {
            ?>
            <p class='pick_notice pick_error'><?php echo sprintf(__('You must <a href="%s">Logged</a> in to see Wishlists','wishlist'), wp_login_url( get_permalink() )); ?></p>
            <?php
            return;
        }

        do_action('wishlist_single_main');

        ?>

    </div>

    <?php

}












add_action('wishlist_single_main','wishlist_single_title_display');

function wishlist_single_title_display(){

    $wishlist_status = get_post_meta( get_the_id(), 'wishlist_status', true );
    if( empty( $wishlist_status ) ) $wishlist_status = "public";

    ?>
    <h4 class='wishlist-title'>
        <?php echo get_the_title( ); ?>

        <span class="wishlist_status"><?php echo pickplugins_wl_get_all_status()[$wishlist_status]; ?></span>

    </h4>
    <?php

}
add_action('wishlist_single_main','wishlist_bredcrumb_display');

function wishlist_bredcrumb_display(){


    $wishlist_settings = get_option('wishlist_settings');

    $wishlist_page = isset($wishlist_settings['wishlist_page']) ? $wishlist_settings['wishlist_page'] : array();
    $breadcrumb_enable = isset($wishlist_page['breadcrumb_enable']) ? $wishlist_page['breadcrumb_enable'] : 'yes';
    $breadcrumb_home_text = isset($wishlist_page['breadcrumb_home_text']) ? $wishlist_page['breadcrumb_home_text'] : '';
    $breadcrumb_text_color = isset($wishlist_page['breadcrumb_text_color']) ? $wishlist_page['breadcrumb_text_color'] : '';

    $archive_page_id = isset($wishlist_settings['archives']['page_id']) ? $wishlist_settings['archives']['page_id'] : '';




    $home_text = !empty( $breadcrumb_home_text ) ? $breadcrumb_home_text : __('Home', 'wishlist');
    $home_text = apply_filters( 'wishlist_bredcrumb_home_text', $home_text );

    ?>
    <!-- Bredcrumb -->

    <?php if( $breadcrumb_enable == 'yes' ) : ?>

        <div class="wishlist-breadcrumb">
            <a class="breadcrumb-item" href="<?php echo get_bloginfo('url'); ?>"><i class="fa fa-home"></i> <?php echo $home_text; ?></a>
            <span class="breadcrumb-separator"><i class="fa fa-long-arrow-right"></i> </span>
            <a class="breadcrumb-item" href="<?php echo get_permalink($archive_page_id); ?>"><?php echo get_the_title($archive_page_id); ?></a>
            <span class="breadcrumb-separator"><i class="fa fa-long-arrow-right"></i> </span>
            <a class="breadcrumb-item" href="#"><?php echo get_the_title(); ?></a>
        </div>

        <?php echo ! empty( $breadcrumb_text_color ) ? "<style>.wishlist-breadcrumb a{ color: {$breadcrumb_text_color} !important; }</style>" : ""; ?>

    <?php endif; ?>

    <!-- Bredcrumb End -->
    <?php


}
add_action('wishlist_single_main','wishlist_content_display');

function wishlist_content_display(){

    ?>
    <div class="wishlist-description"><?php echo get_the_content();  ?></div>
    <?php
}

add_action('wishlist_single_main','wishlist_tags_display');

function wishlist_tags_display(){


    ?>
    <!-- Tags -->

    <?php $wishlist_tags = wp_get_post_terms( get_the_id(), 'wishlist_tags' ) ?>

    <?php if( ! is_wp_error( $wishlist_tags ) && !empty( $wishlist_tags ) ) :  ?>

        <div class="wishlist-tags"><?php echo __('Tags:', 'wishlist'); ?>
            <?php foreach( wp_get_post_terms( get_the_id(), 'wishlist_tags' ) as $tag ) : ?>
                <a href="#" class="wishlist-tag"><?php echo $tag->name; ?> (<?php echo $tag->count; ?>), </a>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <!-- Tags End -->
    <?php
}

add_action('wishlist_single_main','wishlist_editing_display');

function wishlist_editing_display(){

    $wishlist_settings = get_option('wishlist_settings');
    $default_wishlist_id = isset($wishlist_settings['default_wishlist_id']) ? $wishlist_settings['default_wishlist_id'] : '';


    $wishlist_id = get_the_id();
    $current_user_id 		= get_current_user_id();

    ?>
    <!-- Editing Buttons -->

    <?php if( get_post_field( 'post_author', $wishlist_id ) == $current_user_id && $default_wishlist_id != $wishlist_id ) : ?>

        <div class="wishlist_editing">
            <div class="button button_delete"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo __("Delete", 'wishlist' ); ?></div>
            <div class="button button_edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo __("Edit", 'wishlist' ); ?></div>
        </div>

    <?php elseif( is_user_logged_in() ) : ?>



    <?php endif; ?>
    <!-- Editing Buttons End -->
    <?php
}



add_action('wishlist_single_main','wishlist_delete_form_display');

function wishlist_delete_form_display(){
    $wishlist_id = get_the_id();
    ?>
    <!-- Popup Delete Screen Start -->
    <!-- ===== ***** ===== -->


    <div class="wl_popup_wrap popup_delete" wishlist_id="<?php echo $wishlist_id; ?>">
        <div class="popup_box">
            <div class='popup_delete_message'>

                <p class='del_message'><?php echo __('Please confirm to delete?'); ?></p>
            </div>


            <div class="pickplugins_wl_popup_btn popup_cancel"><i class="fa fa-times" aria-hidden="true"></i> <?php echo __("No, Cancel", 'wishlist' ); ?></div>
            <div class="pickplugins_wl_popup_btn popup_delete_confirm"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo __("Yes, Delete", 'wishlist' ); ?></div>


        </div>

    </div>
    <?php
}
add_action('wishlist_single_main','wishlist_edit_form_display');

function wishlist_edit_form_display(){

        $wishlist_settings = get_option('wishlist_settings');

        $tags_enable = isset($wishlist_settings['wishlist_page']['tags_enable']) ? $wishlist_settings['wishlist_page']['tags_enable'] : '';




    $wishlist_id = get_the_id();
    $wishlist_status = get_post_meta( $wishlist_id, 'wishlist_status', true );
    if( empty( $wishlist_status ) ) $wishlist_status = "public";

    $pickplugins_wl_wishlist_tags = array();
    $wishlist_tags = wp_get_post_terms( $wishlist_id, 'wishlist_tags' );

    foreach($wishlist_tags  as $term ){
        $pickplugins_wl_wishlist_tags[] = isset($term->name) ? $term->name : '';
    }


    ?>

    <!-- Popup Edit Screen Start -->
    <!-- ===== ***** ===== -->


    <div class="wl_popup_wrap popup_edit" wishlist_id="<?php echo $wishlist_id; ?>">
        <div class="popup_box">

            <h2 class="popup_title"><?php echo __('Edit', 'wishlist')." <i>". get_the_title( $wishlist_id )."</i>"; ?></h2>

            <p class='pick_notice'></p>

            <div class='popup_section'>
                <h5 class="section_title"><?php echo __('Title', 'wishlist'); ?></h5>
                <input type="text" class="pickplugins_wl_wishlist_title" value="<?php echo get_the_title( $wishlist_id ); ?>" />
            </div>

            <div class='popup_section'>
                <h5 class="section_title"><?php echo __('Short Description', 'wishlist'); ?></h5>
                <textarea type="text" class="pickplugins_wl_wishlist_sd" rows="5" cols="40"><?php echo get_the_content(); ?></textarea>
            </div>

            <div class='popup_section'>
                <h5 class="section_title"><?php echo __('Wishlist Status', 'wishlist'); ?></h5>
                <select class="wishlist_status">

                    <?php foreach( pickplugins_wl_get_all_status() as $status => $label ) : ?>
                        <option value="<?php echo $status; ?>" <?php selected( $wishlist_status, $status ); ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>

            </div>

            <?php if( $tags_enable != 'no' ) : ?>

                <div class='popup_section'>
                    <h5 class="section_title"><?php echo __('Tags - Comma separated', 'wishlist'); ?></h5>

                    <input type="text" class="pickplugins_wl_wishlist_tags" value="<?php echo implode( ",",$pickplugins_wl_wishlist_tags); ?>" />
                </div>
            <?php endif; ?>

            <div class="pickplugins_wl_popup_btn popup_cancel"><i class="fa fa-times" aria-hidden="true"></i> <?php echo __("Cancel", 'wishlist' ); ?></div>

            <div class="pickplugins_wl_popup_btn pickplugins_wl_popup_save"><i class="fa fa-check" aria-hidden="true"></i> <?php echo __("Save Changes", 'wishlist' ); ?></div>

        </div>

    </div>

    <?php
}

add_action('wishlist_single_main','wishlist_items_display');

function wishlist_items_display(){
    $wishlist_id = get_the_id();

    $pickplugins_wl_list_items_per_page = get_option( 'pickplugins_wl_list_items_per_page' );
    if( empty( $pickplugins_wl_list_items_per_page ) ) $pickplugins_wl_list_items_per_page = 10;

    if ( get_query_var('paged') ) { $paged = get_query_var('paged');}
    elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
    else { $paged = 1; }


    ?>

    <!-- Items Query -->

    <?php
    $wishlisted_items 	= pickplugins_wl_get_wishlisted_items( $wishlist_id, $pickplugins_wl_list_items_per_page, $paged );
    $total_items		= count( pickplugins_wl_get_wishlisted_items( $wishlist_id ) );

    ?>


    <?php if ( $wishlisted_items && $total_items > 0  ) : ?>

        <p class='pick_notice pick_success'><?php echo sprintf( __("%s Item showing out of %s Items", 'wishlist' ), "<strong>".count($wishlisted_items)."</strong>", "<strong>$total_items</strong>" ); ?></p>

        <?php do_action( 'pickplugins_wl_before_loop_wishlist_items', $wishlist_id ); ?>

        <div class="wishlist-items">

            <?php foreach( $wishlisted_items as $item ) : do_action( 'pickplugins_wl_loop_single_item', $item->post_id, $wishlist_id ); endforeach; ?>

        </div>

        <?php do_action( 'pickplugins_wl_after_loop_wishlist_items', $wishlist_id ); ?>

        <?php $big = 999999999;
        $paginate = array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, $paged ),
            'total' => (int)ceil($total_items / $pickplugins_wl_list_items_per_page)
        );
        ?>
        <div class="paginate"> <?php echo paginate_links($paginate); ?> </div>

    <?php else : ?>

        <p class='pick_notice pick_warning'><?php echo __( 'Sorry, No items found !', 'wishlist' ); ?></p>

    <?php endif; ?>

    <!-- End of Items Query -->
    <?php
}

