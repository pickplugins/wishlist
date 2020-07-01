<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

add_action('wishlist_settings_content_general', 'wishlist_settings_content_general');

function wishlist_settings_content_general(){
    $settings_tabs_field = new settings_tabs_field();

    $wishlist_settings = get_option('wishlist_settings');

    $font_aw_version = isset($wishlist_settings['general']['font_aw_version']) ? $wishlist_settings['general']['font_aw_version'] : 'none';

    //echo '<pre>'.var_export($wishlist_settings, true).'</pre>';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('General', 'post-grid'); ?></div>
        <p class="description section-description"><?php echo __('Choose some general options.', 'post-grid'); ?></p>

        <?php

        $args = array(
            'id'		=> 'font_aw_version',
            'parent'		=> 'wishlist_settings[general]',
            'title'		=> __('Font-awesome version','post-grid'),
            'details'	=> __('Choose font awesome version you want to load.','post-grid'),
            'type'		=> 'select',
            'value'		=> $font_aw_version,
            'default'		=> '',
            'args'		=> array('v_5'=>__('Version 5+','post-grid'), 'v_4'=>__('Version 4+','post-grid'), 'none'=>__('None','post-grid')  ),
        );

        $settings_tabs_field->generate_field($args);

        ?>

    </div>

    <?php





}





add_action('wishlist_settings_content_archives', 'wishlist_settings_content_archives');

function wishlist_settings_content_archives(){
    $settings_tabs_field = new settings_tabs_field();

    $wishlist_settings = get_option('wishlist_settings');

    $pagination_per_page = isset($wishlist_settings['archives']['pagination_per_page']) ? $wishlist_settings['archives']['pagination_per_page'] : '10';
    $pagination_font_size = isset($wishlist_settings['archives']['pagination_font_size']) ? $wishlist_settings['archives']['pagination_font_size'] : '';
    $pagination_color_idle = isset($wishlist_settings['archives']['pagination_color_idle']) ? $wishlist_settings['archives']['pagination_color_idle'] : '';
    $pagination_color_active = isset($wishlist_settings['archives']['pagination_color_active']) ? $wishlist_settings['archives']['pagination_color_active'] : '';


    //echo '<pre>'.var_export($wishlist_settings, true).'</pre>';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Archives', 'post-grid'); ?></div>
        <p class="description section-description"><?php echo __('Choose wishlist archives options.', 'post-grid'); ?></p>

        <?php


        $args = array(
            'id'		=> 'pagination_per_page',
            'parent'		=> 'wishlist_settings[archives]',
            'title'		=> __('Item per page','post-grid'),
            'details'	=> __('Set custom number of wislists per page.','post-grid'),
            'type'		=> 'text',
            'value'		=> $pagination_per_page,
            'default'		=> '',
            'placeholder' => __('10','wishlist'),

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'pagination_font_size',
            'parent'		=> 'wishlist_settings[archives]',
            'title'		=> __('Pagination font size','post-grid'),
            'details'	=> __('Set pagination font size.','post-grid'),
            'type'		=> 'text',
            'value'		=> $pagination_font_size,
            'default'		=> '12px',
            'placeholder'		=> '12px',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'pagination_color_idle',
            'parent'		=> 'wishlist_settings[archives]',
            'title'		=> __('Pagination color - Normal','post-grid'),
            'details'	=> __('Choose custom color for pagination idle stat.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $pagination_color_idle,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'pagination_color_active',
            'parent'		=> 'wishlist_settings[archives]',
            'title'		=> __('Pagination color - Active','post-grid'),
            'details'	=> __('Choose custom color for pagination on active stat.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $pagination_color_active,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);


        ?>

    </div>

    <?php





}






add_action('wishlist_settings_content_wishlist_page', 'wishlist_settings_content_wishlist_page');

function wishlist_settings_content_wishlist_page(){
    $settings_tabs_field = new settings_tabs_field();

    $wishlist_settings = get_option('wishlist_settings');

    $breadcrumb_enable = isset($wishlist_settings['wishlist_page']['breadcrumb_enable']) ? $wishlist_settings['wishlist_page']['breadcrumb_enable'] : 'yes';
    $breadcrumb_home_text = isset($wishlist_settings['wishlist_page']['breadcrumb_home_text']) ? $wishlist_settings['wishlist_page']['breadcrumb_home_text'] : '';
    $breadcrumb_text_color = isset($wishlist_settings['wishlist_page']['breadcrumb_text_color']) ? $wishlist_settings['wishlist_page']['breadcrumb_text_color'] : 'yes';

    $tags_enable = isset($wishlist_settings['wishlist_page']['tags_enable']) ? $wishlist_settings['wishlist_page']['tags_enable'] : 'yes';
    $tags_display = isset($wishlist_settings['wishlist_page']['tags_display']) ? $wishlist_settings['wishlist_page']['tags_display'] : 'yes';

    $pagination_per_page = isset($wishlist_settings['wishlist_page']['pagination_per_page']) ? $wishlist_settings['wishlist_page']['pagination_per_page'] : '10';
    //echo '<pre>'.var_export($wishlist_settings, true).'</pre>';
    $pagination_font_size = isset($wishlist_settings['wishlist_page']['pagination_font_size']) ? $wishlist_settings['wishlist_page']['pagination_font_size'] : '';
    $pagination_color_idle = isset($wishlist_settings['wishlist_page']['pagination_color_idle']) ? $wishlist_settings['wishlist_page']['pagination_color_idle'] : '';
    $pagination_color_active = isset($wishlist_settings['wishlist_page']['pagination_color_active']) ? $wishlist_settings['wishlist_page']['pagination_color_active'] : '';



    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Breadcrumb', 'post-grid'); ?></div>
        <p class="description section-description"><?php echo __('Choose some general options.', 'post-grid'); ?></p>

        <?php

        $args = array(
            'id'		=> 'breadcrumb_enable',
            'parent'		=> 'wishlist_settings[wishlist_page]',
            'title'		=> __('Display breadcrumb','post-grid'),
            'details'	=> __('Display breadcrumb on wishlist single page.','post-grid'),
            'type'		=> 'select',
            'value'		=> $breadcrumb_enable,
            'default'		=> '',
            'args'		=> array('yes'=>'Yes','no'=>'No'),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'breadcrumb_home_text',
            'parent'		=> 'wishlist_settings[wishlist_page]',
            'title'		=> __('Custom text for "Home"','post-grid'),
            'details'	=> __('You can change default text for "Home" on breadcrumb.','post-grid'),
            'type'		=> 'text',
            'value'		=> $breadcrumb_home_text,
            'default'		=> '',
            'placeholder' => __('Home','wishlist'),

        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'breadcrumb_text_color',
            'parent'		=> 'wishlist_settings[wishlist_page]',
            'title'		=> __('Breadcrumb text color','post-grid'),
            'details'	=> __('Choose custom color for breadcrumb.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $breadcrumb_text_color,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);

        ?>

    </div>
    <div class="section">
        <div class="section-title"><?php echo __('Tags', 'post-grid'); ?></div>
        <p class="description section-description"><?php echo __('Choose some tags options.', 'post-grid'); ?></p>

        <?php
        $args = array(
            'id'		=> 'tags_enable',
            'parent'		=> 'wishlist_settings[wishlist_page]',
            'title'		=> __('Enable tags for Wishlist','post-grid'),
            'details'	=> __('If you want to enable tagging on wishlist.','post-grid'),
            'type'		=> 'select',
            'value'		=> $tags_enable,
            'default'		=> '',
            'args'		=> array('yes'=>'Yes','no'=>'No'),
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'tags_display',
            'parent'		=> 'wishlist_settings[wishlist_page]',
            'title'		=> __('Display tags on wishlist page','post-grid'),
            'details'	=> __('choose if you want to display tags on wishlist page.','post-grid'),
            'type'		=> 'select',
            'value'		=> $tags_display,
            'default'		=> '',
            'args'		=> array('yes'=>'Yes','no'=>'No'),
        );

        $settings_tabs_field->generate_field($args);

    ?>

    </div>
    <div class="section">
        <div class="section-title"><?php echo __('Pagination', 'post-grid'); ?></div>
        <p class="description section-description"><?php echo __('Choose some pagination options.', 'post-grid'); ?></p>

        <?php
        $args = array(
            'id'		=> 'pagination_per_page',
            'parent'		=> 'wishlist_settings[wishlist_page]',
            'title'		=> __('Item per page','post-grid'),
            'details'	=> __('Set custom number of item/post per page.','post-grid'),
            'type'		=> 'text',
            'value'		=> $pagination_per_page,
            'default'		=> '',
            'placeholder' => __('10','wishlist'),

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'pagination_font_size',
            'parent'		=> 'wishlist_settings[wishlist_page]',
            'title'		=> __('Wishlist button font size','post-grid'),
            'details'	=> __('Set wishlist button font size.','post-grid'),
            'type'		=> 'text',
            'value'		=> $pagination_font_size,
            'default'		=> '12px',
            'placeholder'		=> '12px',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'pagination_color_idle',
            'parent'		=> 'wishlist_settings[wishlist_page]',
            'title'		=> __('Pagination color - Normal','post-grid'),
            'details'	=> __('Choose custom color for pagination idle stat.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $pagination_color_idle,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'pagination_color_active',
            'parent'		=> 'wishlist_settings[wishlist_page]',
            'title'		=> __('Pagination color - Active','post-grid'),
            'details'	=> __('Choose custom color for pagination on active stat.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $pagination_color_active,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);


        ?>

    </div>

    <?php





}











add_action('wishlist_settings_content_style', 'wishlist_settings_content_style');

function wishlist_settings_content_style(){
    $settings_tabs_field = new settings_tabs_field();

    $wishlist_settings = get_option('wishlist_settings');

    $font_size = isset($wishlist_settings['style']['font_size']) ? $wishlist_settings['style']['font_size'] : '';
    $color_active = isset($wishlist_settings['style']['color_active']) ? $wishlist_settings['style']['color_active'] : '';
    $color_idle = isset($wishlist_settings['style']['color_idle']) ? $wishlist_settings['style']['color_idle'] : '';


    //echo '<pre>'.var_export($wishlist_settings, true).'</pre>';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('General', 'post-grid'); ?></div>
        <p class="description section-description"><?php echo __('Choose some general options.', 'post-grid'); ?></p>

        <?php

        $args = array(
            'id'		=> 'font_size',
            'parent'		=> 'wishlist_settings[style]',
            'title'		=> __('Wishlist button font size','post-grid'),
            'details'	=> __('Set wishlist button font size.','post-grid'),
            'type'		=> 'text',
            'value'		=> $font_size,
            'default'		=> '12px',
            'placeholder'		=> '12px',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'color_idle',
            'parent'		=> 'wishlist_settings[style]',
            'title'		=> __('Wishlist button color - Normal','post-grid'),
            'details'	=> __('Choose custom color for wishlist button idle stat.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $color_idle,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'color_active',
            'parent'		=> 'wishlist_settings[style]',
            'title'		=> __('Wishlist button color - Active','post-grid'),
            'details'	=> __('Choose custom color for wishlist button on active stat.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $color_active,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);


        ?>

    </div>

    <?php





}




add_action('wishlist_settings_content_woocommerce', 'wishlist_settings_content_woocommerce');

function wishlist_settings_content_woocommerce(){
    $settings_tabs_field = new settings_tabs_field();

    $wishlist_settings = get_option('wishlist_settings');

    $on_shop = isset($wishlist_settings['woocommerce']['on_shop']) ? $wishlist_settings['woocommerce']['on_shop'] : 'none';
    $on_shop_position = isset($wishlist_settings['woocommerce']['on_shop_position']) ? $wishlist_settings['woocommerce']['on_shop_position'] : 'before_addtocart';

    $on_product = isset($wishlist_settings['woocommerce']['on_product']) ? $wishlist_settings['woocommerce']['on_product'] : 'none';
    $on_product_position = isset($wishlist_settings['woocommerce']['on_product_position']) ? $wishlist_settings['woocommerce']['on_product_position'] : 'title';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('WooCommerce Settings', 'post-grid'); ?></div>
        <p class="description section-description"><?php echo __('Choose WooCommerce settings.', 'post-grid'); ?></p>

        <?php

        $args = array(
            'id'		=> 'on_shop',
            'parent'		=> 'wishlist_settings[woocommerce]',
            'title'		=> __('Display on shop page','post-grid'),
            'details'	=> __('Display wishlist button on WooCommerce shop page automatically.','post-grid'),
            'type'		=> 'select',
            'value'		=> $on_shop,
            'default'		=> '',
            'args'		=> array('yes'=>'Yes','no'=>'No'),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'on_shop_position',
            'parent'		=> 'wishlist_settings[woocommerce]',
            'title'		=> __('Position on shop page','post-grid'),
            'details'	=> __('Display wishlist button position on shop page.','post-grid'),
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
            'title'		=> __('Display on product page','post-grid'),
            'details'	=> __('Display wishlist button on WooCommerce product page automatically.','post-grid'),
            'type'		=> 'select',
            'value'		=> $on_shop,
            'default'		=> '',
            'args'		=> array('yes'=>'Yes','no'=>'No'),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'on_product_position',
            'parent'		=> 'wishlist_settings[woocommerce]',
            'title'		=> __('Position on product page','post-grid'),
            'details'	=> __('Display wishlist button position on product page.','post-grid'),
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














add_action('wishlist_settings_content_help_support', 'wishlist_settings_content_help_support');

if(!function_exists('wishlist_settings_content_help_support')) {
    function wishlist_settings_content_help_support($tab){

        $settings_tabs_field = new settings_tabs_field();


        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Get support', 'post-grid'); ?></div>
            <p class="description section-description"><?php echo __('Use following to get help and support from our expert team.', 'post-grid'); ?></p>

            <?php

            ob_start();
            ?>

            <p><?php echo __('Ask question for free on our forum and get quick reply from our expert team members.', 'post-grid'); ?></p>
            <a class="button" href="https://www.pickplugins.com/create-support-ticket/"><?php echo __('Create support ticket', 'post-grid'); ?></a>

            <p><?php echo __('Read our documentation before asking your question.', 'post-grid'); ?></p>
            <a class="button" href="https://www.pickplugins.com/documentation/post-grid/"><?php echo __('Documentation', 'post-grid'); ?></a>

            <p><?php echo __('Watch video tutorials.', 'post-grid'); ?></p>
            <a class="button" href="https://www.youtube.com/playlist?list=PL0QP7T2SN94Yut5Y0MSVg1wqmqWz0UYpt"><i class="fab fa-youtube"></i> <?php echo __('All tutorials', 'post-grid'); ?></a>

            <ul>
                <li><i class="far fa-dot-circle"></i> <a href="https://youtu.be/YVtsIbEb9zs">Latest Version 2.0.46 Overview</a></li>

            </ul>



            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'get_support',
                //'parent'		=> '',
                'title'		=> __('Ask question','post-grid'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);


            ob_start();
            ?>

            <p class="">We wish your 2 minutes to write your feedback about the <b>Post Grid</b> plugin. give us <span style="color: #ffae19"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>

            <a target="_blank" href="https://wordpress.org/support/plugin/post-grid/reviews/#new-post" class="button"><i class="fab fa-wordpress"></i> Write a review</a>


            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'reviews',
                //'parent'		=> '',
                'title'		=> __('Submit reviews','post-grid'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);



            ?>


        </div>
        <?php


    }
}






add_action('wishlist_settings_content_buy_pro', 'wishlist_settings_content_buy_pro');

if(!function_exists('wishlist_settings_content_buy_pro')) {
    function wishlist_settings_content_buy_pro($tab){

        $settings_tabs_field = new settings_tabs_field();


        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Get Premium', 'post-grid'); ?></div>
            <p class="description section-description"><?php echo __('Thanks for using our plugin, if you looking for some advance feature please buy premium version.', 'post-grid'); ?></p>

            <?php


            ob_start();
            ?>

            <p><?php echo __('If you love our plugin and want more feature please consider to buy pro version.', 'post-grid'); ?></p>
            <a class="button" href="https://www.pickplugins.com/item/post-grid-create-awesome-grid-from-any-post-type-for-wordpress/?ref=dashobard"><?php echo __('Buy premium', 'post-grid'); ?></a>
            <a class="button" href="http://www.pickplugins.com/demo/post-grid/?ref=dashobard"><?php echo __('See all demo', 'post-grid'); ?></a>

            <h2><?php echo __('See the differences','post-grid'); ?></h2>

            <table class="pro-features">
                <thead>
                <tr>
                    <th class="col-features"><?php echo __('Features','post-grid'); ?></th>
                    <th class="col-free"><?php echo __('Free','post-grid'); ?></th>
                    <th class="col-pro"><?php echo __('Premium','post-grid'); ?></th>
                </tr>
                </thead>

                <tr>
                    <td colspan="3" class="col-features">
                        <h3><?php echo __('Post Query','post-grid'); ?></h3>
                    </td>
                </tr>


                <tr>
                    <th class="col-features"><?php echo __('Features','post-grid'); ?></th>
                    <th class="col-free"><?php echo __('Free','post-grid'); ?></th>
                    <th class="col-pro"><?php echo __('Premium','post-grid'); ?></th>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Buy now','post-grid'); ?></td>
                    <td> </td>
                    <td><a class="button" href="https://www.pickplugins.com/item/post-grid-create-awesome-grid-from-any-post-type-for-wordpress/?ref=dashobard"><?php echo __('Buy premium', 'post-grid'); ?></a></td>
                </tr>

            </table>



            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'get_pro',
                'title'		=> __('Get pro version','post-grid'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);


            ?>


        </div>

        <style type="text/css">
            .pro-features{
                margin: 30px 0;
                border-collapse: collapse;
                border: 1px solid #ddd;
            }
            .pro-features th{
                width: 120px;
                background: #ddd;
                padding: 10px;
            }
            .pro-features tr{
            }
            .pro-features td{
                border-bottom: 1px solid #ddd;
                padding: 10px 10px;
                text-align: center;
            }
            .pro-features .col-features{
                width: 230px;
                text-align: left;
            }

            .pro-features .col-free{
            }
            .pro-features .col-pro{
            }

            .pro-features i.fas.fa-check {
                color: #139e3e;
                font-size: 16px;
            }
            .pro-features i.fas.fa-times {
                color: #f00;
                font-size: 17px;
            }
        </style>
        <?php


    }
}









add_action('wishlist_settings_save', 'wishlist_settings_save');

function wishlist_settings_save(){

    $wishlist_settings = isset($_POST['wishlist_settings']) ?  stripslashes_deep($_POST['wishlist_settings']) : array();
    update_option('wishlist_settings', $wishlist_settings);
}
