<?php
if (!defined('ABSPATH')) exit;  // if direct access 


add_action('my_wishlist', 'my_wishlist_wrap');

function my_wishlist_wrap($atts)
{

    $view_type = isset($atts['view_type']) ? $atts['view_type'] : 'grid';


    $args = array();
    $args['view_type'] = $view_type;
    $args['atts'] = $atts;




?>

    <div class="my-wishlist pick">
        <?php
        if (is_user_logged_in()) {
            do_action('my_wishlist_user_logged', $args);
        } else {
            do_action('my_wishlist_user_not_logged', $args);
        }
        ?>

    </div>
    <?php

}

add_action('my_wishlist_user_logged', 'my_wishlist_user_logged');

function my_wishlist_user_logged($args)
{

    //$view_type = $args['view_type'];
    $view_type = isset($atts['view_type']) ? $atts['view_type'] : 'grid';

    $wishlist_settings = get_option('wishlist_settings');
    $default_wishlist_id = isset($wishlist_settings['default_wishlist_id']) ? $wishlist_settings['default_wishlist_id'] : '';
    $posts_per_page = isset($wishlist_settings['my_wishlist']['posts_per_page']) ? $wishlist_settings['my_wishlist']['posts_per_page'] : '10';

    $current_user_id = get_current_user_id();


    if (get_query_var('paged')) {
        $paged = get_query_var('paged');
    } elseif (get_query_var('page')) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }



    $wishlist_query = new WP_Query(array(
        'post_type'     => 'wishlist',
        'post_status'     => array('publish'),
        'author'         => $current_user_id,
        'post__not_in'     => array($default_wishlist_id),
        'posts_per_page' => $posts_per_page,
        'paged'         => $paged,
    ));





    if ($wishlist_query->have_posts()) :


        do_action('my_wishlist_before_loop', $args, $wishlist_query);

    ?>
        <div class="items <?php echo $view_type; ?>">
            <?php
            //do_action('my_wishlist_loop_top', $args);

            if ($paged == 1) :
                if (!empty($default_wishlist_id)) {
                    echo pickplugins_wl_get_single_wishlist_html($default_wishlist_id, $args);
                }
            endif;


            while ($wishlist_query->have_posts()) : $wishlist_query->the_post();

                $args['wishlist_id'] = get_the_ID();

            ?>
                <div class='item'>
                    <?php
                    do_action('my_wishlist_loop', $args);
                    ?>
                </div>
            <?php


            //echo pickplugins_wl_get_single_wishlist_html( get_the_ID() );

            endwhile;


            ?>
        </div>
    <?php
        do_action('my_wishlist_after_loop', $args, $wishlist_query);



        wp_reset_query();

    else :

    ?>
        <div class="items <?php echo $view_type; ?>">
            <?php
            if (!empty($default_wishlist_id)) {
                echo pickplugins_wl_get_single_wishlist_html($default_wishlist_id, $args);
            }
            ?>
        </div>
    <?php





    endif;






    ?>

<?php

}



add_action('my_wishlist_after_loop', 'my_wishlist_after_loop', 10, 2);

function my_wishlist_after_loop($args, $wishlist_query)
{

    if (get_query_var('paged')) {
        $paged = get_query_var('paged');
    } elseif (get_query_var('page')) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }

    $big = 999999999;
    $paginate_links = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, $paged),
        'total' =>  $wishlist_query->max_num_pages,
    ));

?>
    <div class='paginate'>
        <?php
        echo $paginate_links;
        ?>
    </div>
<?php

}





add_action('my_wishlist_loop', 'my_wishlist_loop');

function my_wishlist_loop($args)
{

    $atts = isset($args['atts']) ? $args['atts'] : array();

    $icons = isset($atts['icons']) ? $atts['icons'] : array();

    $globe_icon = isset($icons['globe_icon']) ? $icons['globe_icon'] : '';
    $lock_icon = isset($icons['lock_icon']) ? $icons['lock_icon'] : '';
    $user_icon = isset($icons['user_icon']) ? $icons['user_icon'] : '';


    $wishlist_id = isset($args['wishlist_id']) ? $args['wishlist_id'] : '';
    $column = isset($atts['column']) ? $atts['column'] : '3';
    $view_type = isset($atts['view_type']) ? $atts['view_type'] : 'grid';


    $wishlist_url = get_permalink($wishlist_id);
    $html = "";
    $wishlisted_items     = pickplugins_wl_get_wishlisted_items($wishlist_id);

    $total_items        = count($wishlisted_items);
    $item_url             = basename(get_permalink($wishlist_id));
    $item_slug             = basename(parse_url($item_url, PHP_URL_PATH));
    $first_item         = reset($wishlisted_items);
    $bg_image_url        = isset($first_item->post_id) ? get_the_post_thumbnail_url($first_item->post_id) : "";

    $wishlist_status    = get_post_meta(get_the_ID(), 'wishlist_status', true);
    $status_hint_text    = $wishlist_status == 'private' ? __('Private List', 'wishlist') : __('Public List', 'wishlist');


?>

    <a href='<?php echo $wishlist_url; ?>' class='item_inside'>
        <?php

        if ($total_items > 0) {
        ?>
            <span class='item_img' style='background-image:url(<?php echo $bg_image_url; ?>);'></span>
        <?php
        } else {
        ?>
            <span class='item_img'><i class='fa fa-heart' aria-hidden='true'></i></span>
        <?php
        }

        echo sprintf("<h3>%s</h3>", get_the_title($wishlist_id));
        ?>
        <div class="meta-items">

            <span><?php echo sprintf(__('Total: %s', 'wishlist'), $total_items); ?></span>
            <span class='hint--top' aria-label='<?php echo $status_hint_text ?>'>
                <?php

                if ($wishlist_status == 'public') {
                    echo $globe_icon;
                } elseif ($wishlist_status == 'private') {

                    echo $lock_icon;
                }


                ?>
            </span>
            <span class='createdby hint--top' aria-label='<?php echo __('Created by', 'wishlist'); ?>'> <?php echo $user_icon; ?> <?php echo get_the_author_meta('display_name') ?></span>
            <?php

            ?>
        </div>
    </a>

<?php


}















add_action('my_wishlist_user_not_logged', 'my_wishlist_user_not_logged');

function my_wishlist_user_not_logged($args)
{

?>
    <p class='notice error'>
        <?php echo sprintf(__('You must be <a href="%s">Logged in</a> to see wishlists', 'wishlist'), wp_login_url(get_permalink())); ?>
    </p>

<?php

}


add_action('my_wishlist_loop', 'my_wishlist_script');

function my_wishlist_script($args)
{

    $wishlist_id = isset($args['wishlist_id']) ? $args['wishlist_id'] : '';
    $column = isset($atts['column']) ? $atts['column'] : '3';
    $view_type = isset($atts['view_type']) ? $atts['view_type'] : 'grid';

    $wishlist_settings = get_option('wishlist_settings');

    $pagination_font_size = isset($wishlist_settings['my_wishlist']['pagination_font_size']) ? $wishlist_settings['my_wishlist']['pagination_font_size'] : '';
    $pagination_color_idle = isset($wishlist_settings['my_wishlist']['pagination_color_idle']) ? $wishlist_settings['my_wishlist']['pagination_color_idle'] : '';
    $pagination_color_active = isset($wishlist_settings['my_wishlist']['pagination_color_active']) ? $wishlist_settings['my_wishlist']['pagination_color_active'] : '';

    $pagination_color = isset($wishlist_settings['my_wishlist']['pagination_color']) ? $wishlist_settings['my_wishlist']['pagination_color'] : '';


?>

    <style type="text/css">
        .my-wishlist .paginate .page-numbers {
            background: <?php echo $pagination_color_idle; ?> !important;
            color: <?php echo $pagination_color; ?> !important;
            font-size: <?php echo $pagination_font_size; ?> !important;
        }

        .my-wishlist .paginate .current,
        .my-wishlist .paginate .page-numbers:hover {
            background: <?php echo $pagination_color_active; ?> !important;
        }
    </style>
<?php

}
