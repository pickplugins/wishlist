<?php


if (!defined('ABSPATH')) exit;  // if direct access 

add_filter('wishlist_settings_tabs', 'wishlist_settings_tabs_wc');

function wishlist_settings_tabs_wc($tabs)
{

    $current_tab = isset($_REQUEST['tab']) ? sanitize_text_field($_REQUEST['tab']) : 'general';


    $tabs[] = array(
        'id' => 'woocommerce',
        'title' => sprintf(__('%s WooCommerce', 'wishlist'), '<i class="fas fa-cart-plus"></i>'),
        'priority' => 15,
        'active' => ($current_tab == 'woo') ? true : false,
    );

    return $tabs;
}






add_action('wishlist_settings_content_woocommerce', 'wishlist_settings_content_woocommerce');

function wishlist_settings_content_woocommerce()
{
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
            'id'        => 'on_shop',
            'parent'        => 'wishlist_settings[woocommerce]',
            'title'        => __('Display on shop page', 'wishlist'),
            'details'    => __('Display wishlist button on WooCommerce shop page automatically.', 'wishlist'),
            'type'        => 'select',
            'value'        => $on_shop,
            'default'        => '',
            'args'        => array('yes' => 'Yes', 'no' => 'No'),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'on_shop_position',
            'parent'        => 'wishlist_settings[woocommerce]',
            'title'        => __('Position on shop page', 'wishlist'),
            'details'    => __('Display wishlist button position on shop page.', 'wishlist'),
            'type'        => 'select',
            'value'        => $on_shop_position,
            'default'        => '',
            'args'        => array(
                'before_addtocart'     => __('Before Add to Cart', 'wishlist'),
                'after_addtocart'    => __('After Add to Cart', 'wishlist'),
            ),
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'        => 'on_product',
            'parent'        => 'wishlist_settings[woocommerce]',
            'title'        => __('Display on product page', 'wishlist'),
            'details'    => __('Display wishlist button on WooCommerce product page automatically.', 'wishlist'),
            'type'        => 'select',
            'value'        => $on_shop,
            'default'        => '',
            'args'        => array('yes' => 'Yes', 'no' => 'No'),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'on_product_position',
            'parent'        => 'wishlist_settings[woocommerce]',
            'title'        => __('Position on product page', 'wishlist'),
            'details'    => __('Display wishlist button position on product page.', 'wishlist'),
            'type'        => 'select',
            'value'        => $on_product_position,
            'default'        => '',
            'args'        => array(
                'title'         => __('Title', 'wishlist'),
                'ratings'        => __('Ratings', 'wishlist'),
                'price'            => __('Price', 'wishlist'),
                'excerpt'        => __('Excerpt', 'wishlist'),
                'meta'            => __('Meta', 'wishlist'),
                'sharing'        => __('Sharing', 'wishlist'),
                'add_to_cart'    => __('Add to Cart', 'wishlist'),
            ),
        );

        $settings_tabs_field->generate_field($args);









        ?>

    </div>

<?php





}






/* Add Wishlist section using Shortcode on Single Post Archive*/
/* ===== === ===== */

function woocommerce_template_loop_product_wishlist($item_id = 0)
{

    $item_id = ($item_id != 0) ? get_the_ID() : 0;


    echo do_shortcode("[wishlist_button obj_type='post' id='$item_id' show_count='yes' show_menu='yes' ]");
}


function pickplugins_wl_show_wishlist_section()
{

    /* Shop page settings */
    /* ===== === ===== */

    $wishlist_settings = get_option('wishlist_settings');

    $woocommerce = isset($wishlist_settings['woocommerce']) ? $wishlist_settings['woocommerce'] : array();
    $on_shop = isset($woocommerce['on_shop']) ? $woocommerce['on_shop'] : 'yes';
    $on_shop_position = isset($woocommerce['on_shop_position']) ? $woocommerce['on_shop_position'] : 'after_addtocart';

    $on_product = isset($woocommerce['on_product']) ? $woocommerce['on_product'] : 'yes';
    $on_product_position = isset($woocommerce['on_product_position']) ? $woocommerce['on_product_position'] : 'title';


    if ($on_shop != "no") :

        if ($on_shop_position == 'before_addtocart') $priority = 5;
        else $priority = 15;

        add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_wishlist', $priority);

    endif;

    /* Product single page settings */
    /* ===== === ===== */

    if ($on_product != "no") :


        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 12);

        if ($on_product_position == 'title') $priority = 6;
        elseif ($on_product_position == 'ratings') $priority = 10;
        elseif ($on_product_position == 'price') $priority = 15;
        elseif ($on_product_position == 'excerpt') $priority = 20;
        elseif ($on_product_position == 'meta') $priority = 40;
        elseif ($on_product_position == 'add_to_cart') $priority = 30;
        elseif ($on_product_position == 'sharing') $priority = 50;
        else $priority = 15;

        add_action('woocommerce_single_product_summary', 'woocommerce_template_loop_product_wishlist', $priority);

    endif;

    add_action('wishlist_single_loop_main', 'woocommerce_template_loop_product_wishlist', 12);
}
add_action('init', 'pickplugins_wl_show_wishlist_section');















/* Add custom menu item and endpoint to WooCommerce My-Account page */
add_action('init', 'wishlist_myaccount_endpoints');
add_filter('query_vars', 'wishlist_myaccount_query_vars', 0);
add_action('after_switch_theme', 'wishlist_myaccount_flush');
add_filter('woocommerce_account_menu_items', 'wishlist_myaccount_menu_items', 10);
add_action('woocommerce_account_my_wishlist_endpoint', 'wishlist_myaccount_endpoint_content');






function wishlist_myaccount_endpoints()
{
    add_rewrite_endpoint('my_wishlist', EP_ROOT | EP_PAGES);
}


function wishlist_myaccount_query_vars($vars)
{
    $vars[] = 'my_wishlist';

    return $vars;
}



function wishlist_myaccount_flush()
{
    flush_rewrite_rules();
}

function wishlist_myaccount_menu_items($items)
{

    $logout = $items['customer-logout'];
    unset($items['customer-logout']);

    $items['my_wishlist'] = __('My Wishlist', 'wishlist');

    $items['customer-logout'] = $logout;

    return $items;
}



function wishlist_myaccount_endpoint_content()
{

    echo do_shortcode('[my_wishlist]');
?>
<?php

}
