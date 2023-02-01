<?php


if (!defined('ABSPATH')) exit;  // if direct access 


function wishlist_single_display($content)
{

    global $post;

    if ($post->post_type == 'wishlist') {

        $content = do_shortcode("[wishlist_single id='" . get_the_id() . "']");
        return $content;
    } else {
        return $content;
    }
}

add_filter('the_content', 'wishlist_single_display');


add_action('wishlist_single', 'wishlist_single_wrap', 5);

function wishlist_single_wrap($atts)
{

    $wishlist_id = isset($atts['id']) ? $atts['id'] : 0;
    $current_user_id         = get_current_user_id();



    if (empty($wishlist_id)) return;

    $wishlist_status = get_post_meta($wishlist_id, 'wishlist_status', true);

    $wishlist_status = !empty($wishlist_status) ? $wishlist_status : "public";
    $wishlist_settings = get_option('wishlist_settings');
    $default_wishlist_id = isset($wishlist_settings['default_wishlist_id']) ? $wishlist_settings['default_wishlist_id'] : '';
    $default_wishlist_access = isset($wishlist_settings['default_wishlist_access']) ? $wishlist_settings['default_wishlist_access'] : 'private';

    $wishlist_author_id = get_post_field('post_author', $wishlist_id);

?>

    <div class="single-wishlist pick woocommerce">

        <?php

        if (($default_wishlist_access == 'private') &&  ($wishlist_id == $default_wishlist_id)) {


            if (!is_user_logged_in()) {

                global $wishlishtJSON;



        ?>
                <p id="loggin-error" class='pick_notice pick_error '><?php echo sprintf(__('You must be <a href="%s">Logged in</a> to see wishlists', 'wishlist'), wp_login_url(get_permalink())); ?></p>

                <div id="offline-wishlist">
                    <div class="offline-title" style="display: none;"><?php echo esc_html(__('Your offline wishlist items', 'wishlist')); ?></div>
                    <?php

                    if ($wishlishtJSON['isProUser']) :
                    ?>
                        <div class="offline-export" style="display: none;"><?php echo esc_html(__('Export', 'wishlist')); ?></div>

                    <?php
                    endif
                    ?>

                    <div class="items"></div>
                </div>
            <?php
                return;
            }
        }


        if (($wishlist_status == 'private') && ($wishlist_author_id != $current_user_id) && ($wishlist_id != $default_wishlist_id)) {
            ?>
            <p class='pick_notice pick_error'><?php echo __("Sorry, You are not authorize to view this wishlist.", 'wishlist'); ?></p>
        <?php return;
        }



        if (!is_user_logged_in() && $wishlist_status == 'private') {
        ?>
            <p class='pick_notice pick_error'><?php echo sprintf(__('You must be <a href="%s">Logged in</a> to see wishlists', 'wishlist'), wp_login_url(get_permalink())); ?></p>
        <?php
            return;
        }

        do_action('wishlist_single_main', $atts);

        ?>

    </div>

<?php

}



add_action('wishlist_single_main', 'wishlist_bredcrumb_display', 5);

function wishlist_bredcrumb_display($atts)
{

    $icons = isset($atts['icons']) ? $atts['icons'] : array();

    $separator_icon = isset($icons['separator_icon']) ? $icons['separator_icon'] : '';
    $home_icon = isset($icons['home_icon']) ? $icons['home_icon'] : '';


    $wishlist_settings = get_option('wishlist_settings');

    $wishlist_page = isset($wishlist_settings['wishlist_page']) ? $wishlist_settings['wishlist_page'] : array();
    $breadcrumb_enable = isset($wishlist_page['breadcrumb_enable']) ? $wishlist_page['breadcrumb_enable'] : 'yes';
    $breadcrumb_home_text = isset($wishlist_page['breadcrumb_home_text']) ? $wishlist_page['breadcrumb_home_text'] : '';
    $breadcrumb_text_color = isset($wishlist_page['breadcrumb_text_color']) ? $wishlist_page['breadcrumb_text_color'] : '';

    $archive_page_id = isset($wishlist_settings['archives']['page_id']) ? $wishlist_settings['archives']['page_id'] : '';


    $home_text = !empty($breadcrumb_home_text) ? $breadcrumb_home_text : __('Home', 'wishlist');
    $home_text = apply_filters('wishlist_single_bredcrumb_home_text', $home_text);

?>
    <!-- Bredcrumb -->

    <?php if ($breadcrumb_enable == 'yes') : ?>

        <div class="wishlist-breadcrumb">
            <a class="breadcrumb-item" href="<?php echo get_bloginfo('url'); ?>"><?php echo $home_icon; ?> <?php echo $home_text; ?></a>
            <!--            <span class="breadcrumb-separator">--><?php //echo $separator_icon; 
                                                                    ?>
            <!-- </span>-->
            <!--            <a class="breadcrumb-item" href="--><?php //echo get_permalink($archive_page_id); 
                                                                ?>
            <!--">--><?php //echo get_the_title($archive_page_id); 
                        ?>
            <!--</a>-->
            <span class="breadcrumb-separator"><?php echo $separator_icon; ?> </span>
            <a class="breadcrumb-item" href="#"><?php echo get_the_title(); ?></a>
        </div>

        <?php echo !empty($breadcrumb_text_color) ? "<style>.wishlist-breadcrumb a{ color: {$breadcrumb_text_color} !important; }</style>" : ""; ?>

    <?php endif; ?>

    <!-- Bredcrumb End -->
<?php


}







add_action('wishlist_single_main', 'wishlist_content_display', 10);

function wishlist_content_display()
{

?>
    <div class="wishlist-description"><?php echo wpautop(get_the_content());  ?></div>
<?php
}

add_action('wishlist_single_main', 'wishlist_single_meta', 15);

function wishlist_single_meta($atts)
{

?>
    <div class="meta">
        <?php
        do_action('wishlist_single_meta', $atts);
        ?>
    </div>
<?php

}



add_action('wishlist_single_meta', 'wishlist_single_meta_status', 5);

function wishlist_single_meta_status($atts)
{

    $icons = isset($atts['icons']) ? $atts['icons'] : array();

    $globe_icon = isset($icons['globe_icon']) ? $icons['globe_icon'] : '';
    $lock_icon = isset($icons['lock_icon']) ? $icons['lock_icon'] : '';



    $wishlist_status    = get_post_meta(get_the_ID(), 'wishlist_status', true);
    $wishlist_status = !empty($wishlist_status) ? $wishlist_status : 'public';
    $all_status = wishlist_all_status();


    //var_dump($wishlist_status);

?>
    <span class="wishlist_status meta-item hint--top" aria-label="<?php echo $all_status[$wishlist_status]['description']; ?>"><?php
                                                                                                                                if ($wishlist_status == 'public') {
                                                                                                                                ?><?php echo $globe_icon; ?> <?php

                                                                                                                                                            } elseif ($wishlist_status == 'private') {
                                                                                                                                                                ?><?php echo $lock_icon; ?> <?php
                                                                                                                                                                                        }

                                                                                                                                                                                        echo $all_status[$wishlist_status]['label'];
                                                                                                                                                                                            ?></span>

<?php

}




add_action('wishlist_single_meta', 'wishlist_single_editing', 10);

function wishlist_single_editing($atts)
{

    $icons = isset($atts['icons']) ? $atts['icons'] : array();


    $trash_icon = isset($icons['trash_icon']) ? $icons['trash_icon'] : '';
    $pencil_icon = isset($icons['pencil_icon']) ? $icons['pencil_icon'] : '';
    $check_icon = isset($icons['check_icon']) ? $icons['check_icon'] : '';


    $wishlist_settings = get_option('wishlist_settings');
    $default_wishlist_id = isset($wishlist_settings['default_wishlist_id']) ? $wishlist_settings['default_wishlist_id'] : '';
    $enable_delete = isset($wishlist_settings['wishlist_page']['enable_delete']) ? $wishlist_settings['wishlist_page']['enable_delete'] : 'yes';
    $enable_edit = isset($wishlist_settings['wishlist_page']['enable_edit']) ? $wishlist_settings['wishlist_page']['enable_edit'] : 'yes';


    $wishlist_id = get_the_id();
    $current_user_id         = get_current_user_id();



?>
    <!-- Editing Buttons -->

    <?php if (get_post_field('post_author', $wishlist_id) == $current_user_id && $default_wishlist_id != $wishlist_id) : ?>

        <div class="wishlist_editing">

            <?php if ($enable_delete == 'yes') : ?>
                <span class="button_delete meta-item hint--top" aria-label="<?php echo __('Delete this wishlist.', ''); ?>" wishlist_id="<?php echo $wishlist_id; ?>" confirmText="<?php echo esc_attr(sprintf(__('%s Confirm', 'wishlist'), $check_icon)); ?>"><?php echo sprintf(__("%s Delete", 'wishlist'), $trash_icon); ?></span>
            <?php endif; ?>
            <?php if ($enable_edit == 'yes') : ?>
                <span class="button_edit meta-item hint--top" aria-label="<?php echo __('Edit this wishlist.', ''); ?>"><?php echo sprintf(__("%s Edit", 'wishlist'), $pencil_icon); ?></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <!-- Editing Buttons End -->
<?php
}













add_action('wishlist_single_main', 'wishlist_edit_form_display', 20);

function wishlist_edit_form_display()
{

    $wishlist_settings = get_option('wishlist_settings');
    $enable_edit = isset($wishlist_settings['wishlist_page']['enable_edit']) ? $wishlist_settings['wishlist_page']['enable_edit'] : 'yes';


    if ($enable_edit != 'yes') return;



    $wishlist_id = get_the_id();
    $wishlist_status = get_post_meta($wishlist_id, 'wishlist_status', true);
    if (empty($wishlist_status)) $wishlist_status = "public";

    $wishlist_all_status = wishlist_all_status();

?>

    <!-- Popup Edit Screen Start -->
    <!-- ===== ***** ===== -->


    <div class="wl_popup_wrap popup_edit" wishlist_id="<?php echo $wishlist_id; ?>">
        <div class="popup_box">

            <h2 class="popup_title"><?php echo __('Edit', 'wishlist') . " <i>" . get_the_title($wishlist_id) . "</i>"; ?></h2>

            <p class='pick_notice'></p>

            <div class='popup_section'>
                <h5 class="section_title"><?php echo __('Title', 'wishlist'); ?></h5>
                <input type="text" class="pickplugins_wl_wishlist_title" value="<?php echo get_the_title($wishlist_id); ?>" />
            </div>

            <div class='popup_section'>
                <h5 class="section_title"><?php echo __('Short Description', 'wishlist'); ?></h5>
                <textarea type="text" class="pickplugins_wl_wishlist_sd" rows="5" cols="40"><?php echo get_the_content(); ?></textarea>
            </div>

            <div class='popup_section'>
                <h5 class="section_title"><?php echo __('Wishlist Status', 'wishlist'); ?></h5>
                <select class="wishlist_status">

                    <?php
                    if (!empty($wishlist_all_status))
                        foreach ($wishlist_all_status as $index => $status) :

                            //var_dump($index);

                            $label = isset($status['label']) ? $status['label'] : '';

                    ?>
                        <option value="<?php echo $index; ?>" <?php selected($wishlist_status, $index); ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>

            </div>



            <div class="pickplugins_wl_popup_btn popup_cancel"><i class="fa fa-times"></i> <?php echo __("Cancel", 'wishlist'); ?></div>

            <div class="pickplugins_wl_popup_btn pickplugins_wl_popup_save"><i class="fa fa-check"></i> <?php echo __("Save Changes", 'wishlist'); ?></div>

        </div>

    </div>

<?php
}

add_action('wishlist_single_main', 'wishlist_items_display', 25);

function wishlist_items_display()
{

    flush_rewrite_rules(true);



    $wishlist_id = get_the_id();

    $pickplugins_wl_list_items_per_page = get_option('pickplugins_wl_list_items_per_page');
    if (empty($pickplugins_wl_list_items_per_page)) $pickplugins_wl_list_items_per_page = 10;

    $pickplugins_wl_list_items_per_page = 3;



    if (get_query_var('paged')) {
        $paged = get_query_var('paged');
    } elseif (get_query_var('page')) {
        $paged = get_query_var('page');
    } elseif (get_query_var('pagi')) {
        $paged = get_query_var('pagi');
    } else {
        $paged = 1;
    }


    //var_dump($paged);
    //var_dump(get_query_var('pagi'));



?>

    <!-- Items Query -->

    <?php
    $wishlisted_items     = pickplugins_wl_get_wishlisted_items($wishlist_id, $pickplugins_wl_list_items_per_page, $paged);
    $total_items        = count(pickplugins_wl_get_wishlisted_items($wishlist_id));

    ?>


    <?php if ($wishlisted_items && $total_items > 0) : ?>

        <p class='pick_notice pick_success'><?php echo sprintf(__("%s Item showing out of %s Items", 'wishlist'), "<strong>" . count($wishlisted_items) . "</strong>", "<strong>$total_items</strong>"); ?></p>

        <?php do_action('wishlist_single_before_loop', $wishlist_id); ?>

        <div class="wishlist-items">

            <?php

            foreach ($wishlisted_items as $item) {

                //echo '<pre>'.var_export($item, true).'</pre>';
                $item->obj_type = !empty($item->obj_type) ? $item->obj_type : 'post';



                do_action('wishlist_single_loop', $item, $wishlist_id);
            }

            ?>

        </div>

        <?php do_action('wishlist_single_after_loop', $wishlist_id); ?>

        <?php $big = 999999999;
        $paginate = array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, $paged),
            'total' => (int)ceil($total_items / $pickplugins_wl_list_items_per_page)
        );
        ?>
        <div class="paginate"> <?php echo paginate_links($paginate); ?> </div>

    <?php else : ?>

        <p class='pick_notice pick_warning'><?php echo __('Sorry, No items found !', 'wishlist'); ?></p>

    <?php endif; ?>

    <!-- End of Items Query -->
<?php
}


add_action('wishlist_single_loop', 'wishlist_single_loop_start', 5, 2);

function wishlist_single_loop_start($item, $wishlist_id)
{

    $item_id = isset($item->post_id) ? $item->post_id : '';

?>
    <div class='wl-single-item wl-single-item-<?php echo $item_id; ?>' item_id='<?php echo $item_id; ?>'>
    <?php

}






add_action('wishlist_single_loop', 'wishlist_single_loop_thumb', 10, 2);



function wishlist_single_loop_thumb($item, $wishlist_id)
{

    $item_id = isset($item->post_id) ? $item->post_id : '';
    $obj_type = isset($item->obj_type) ? $item->obj_type : '';

    //if($obj_type != 'post') return;



    //if( empty($item_thumb_url)) return;

    if ($obj_type == 'post') {
        $item_link = get_the_permalink($item_id);
        $item_thumb_url = get_the_post_thumbnail_url($item_id);
    } elseif ($obj_type == 'term') {
        $term = get_term($item_id);

        //echo '<pre>'.var_export($term, true).'</pre>';


        $item_link = get_term_link($term->term_id);
        $item_thumb_url = '';
    } elseif ($obj_type == 'author') {
        $item_link = get_author_posts_url($item_id);
        $item_thumb_url = get_avatar_url($item_id, array('size' => 200));
    } elseif ($obj_type == 'url') {
        $item_title = 'Custom Link';
        $item_link = wishlist_get_url_by_id($item_id);

        //echo '<pre>'.var_export($item_link, true).'</pre>';


        //$item_link = get_bloginfo('url');
        //$item_link
        //echo '<pre>'.var_export($item_link, true).'</pre>';


    }

    ?>
        <a class='wl-thumb' href='<?php echo esc_url_raw($item_link); ?>'>
            <span style='background-image: url("<?php echo $item_thumb_url; ?>");'></span>
        </a>
    <?php

}


add_action('wishlist_single_loop', 'wishlist_single_loop_title', 15, 2);

function wishlist_single_loop_title($item, $wishlist_id)
{

    $item_id = isset($item->post_id) ? $item->post_id : '';
    $obj_type = isset($item->obj_type) ? $item->obj_type : '';

    if ($obj_type == 'post') {
        $item_title =  get_the_title($item_id);
        $item_link = get_the_permalink($item_id);
    } elseif ($obj_type == 'term') {
        $term = get_term($item_id);
        $item_title = $term->name;
        $item_link = get_term_link($term->term_id);
    } elseif ($obj_type == 'author') {
        $item_title = get_the_author_meta('display_name', $item_id);
        $item_link = get_author_posts_url($item_id);
    } elseif ($obj_type == 'url') {
        $item_title = 'Custom Link';
        $item_link = wishlist_get_url_by_id($item_id);
    }


    ?>
        <a class='wl-title' href='<?php echo esc_url_raw($item_link); ?>'>
            <?php

            echo $item_title;

            ?>
        </a>

    <?php

}


add_action('wishlist_single_loop', 'wishlist_single_loop_cart', 20, 2);

function wishlist_single_loop_cart($item, $wishlist_id)
{

    $item_id = isset($item->post_id) ? $item->post_id : '';
    $obj_type = isset($item->obj_type) ? $item->obj_type : '';

    if ($obj_type != 'post') return;

    if (get_post_type($item_id) == 'product') echo do_shortcode("[add_to_cart id='$item_id']");

    if (class_exists('Easy_Digital_Downloads') && get_post_type($item_id) == 'download') {

        echo edd_get_purchase_link(array('download_id' => $item_id));
    }
}

add_action('wishlist_single_loop', 'wishlist_single_loop_remove', 20, 2);

function wishlist_single_loop_remove($item, $wishlist_id)
{

    $item_id = isset($item->post_id) ? $item->post_id : '';

    ?>
        <div wishlist_id="<?php echo esc_attr($wishlist_id); ?>" item_id="<?php echo esc_attr($item_id); ?>" class="remove"><?php echo __('Remove', 'wishlist'); ?></div>
    <?php

}



add_action('wishlist_single_loop', 'wishlist_single_loop_end', 99, 2);

function wishlist_single_loop_end($item_id, $wishlist_id)
{

    ?>
    </div>
<?php

}



add_action('wishlist_single', 'wishlist_single_main_script', 10);

function wishlist_single_main_script($args)
{

    $wishlist_settings = get_option('wishlist_settings');

    $pagination_font_size = isset($wishlist_settings['wishlist_page']['pagination_font_size']) ? $wishlist_settings['wishlist_page']['pagination_font_size'] : '';
    $pagination_color_idle = isset($wishlist_settings['wishlist_page']['pagination_color_idle']) ? $wishlist_settings['wishlist_page']['pagination_color_idle'] : '';
    $pagination_color_active = isset($wishlist_settings['wishlist_page']['pagination_color_active']) ? $wishlist_settings['wishlist_page']['pagination_color_active'] : '';

    $pagination_color = isset($wishlist_settings['wishlist_page']['pagination_color']) ? $wishlist_settings['wishlist_page']['pagination_color'] : '';


?>
    <style type="text/css">
        .single-wishlist .paginate .page-numbers {
            background: <?php echo $pagination_color_idle; ?> !important;
            color: <?php echo $pagination_color; ?> !important;
            font-size: <?php echo $pagination_font_size; ?> !important;
        }

        .single-wishlist .paginate .current,
        .single-wishlist .paginate .page-numbers:hover {
            background: <?php echo $pagination_color_active; ?> !important;
        }
    </style>
<?php
}
