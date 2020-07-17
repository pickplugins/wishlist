<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

add_action('wishlist_settings_content_general', 'wishlist_settings_content_general');

function wishlist_settings_content_general(){
    $settings_tabs_field = new settings_tabs_field();

    $wishlist_settings = get_option('wishlist_settings');

    //delete_option('wishlist_settings');

    $font_aw_version = isset($wishlist_settings['general']['font_aw_version']) ? $wishlist_settings['general']['font_aw_version'] : 'none';
    $post_types_display = isset($wishlist_settings['post_types_display']) ? $wishlist_settings['post_types_display'] : array();
    $default_wishlist_id = isset($wishlist_settings['default_wishlist_id']) ? $wishlist_settings['default_wishlist_id'] : '';

    //echo '<pre>'.var_export($wishlist_settings, true).'</pre>';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('General', 'post-grid'); ?></div>
        <p class="description section-description"><?php echo __('Choose some general options.', 'post-grid'); ?></p>

        <?php






        ob_start();


        ?>
        <div class="templates_editor expandable">
            <?php

            //$post_types = apply_filters('wishlist_posttypes', array('post'=>'Post', 'page' => 'Page'));
            $post_types = wishlist_posttypes_array();


            if(!empty($post_types))
                foreach($post_types as $post_type => $post_name){



                    $content_position = isset($post_types_display[$post_type]['content_position']) ? $post_types_display[$post_type]['content_position'] : 'none';
                    $enable = isset($post_types_display[$post_type]['enable']) ? $post_types_display[$post_type]['enable'] : 'no';
                    $description = isset($post_types_display[$post_type]['description']) ? $post_types_display[$post_type]['description'] : '';
                    $excerpt_position = isset($post_types_display[$post_type]['excerpt_position']) ? $post_types_display[$post_type]['excerpt_position'] : 'none';
                    $icon_active = isset($post_types_display[$post_type]['icon_active']) ? $post_types_display[$post_type]['icon_active'] : '';
                    $icon_inactive = isset($post_types_display[$post_type]['icon_inactive']) ? $post_types_display[$post_type]['icon_inactive'] : '';
                    $icon_loading = isset($post_types_display[$post_type]['icon_loading']) ? $post_types_display[$post_type]['icon_loading'] : '';


                    $show_count = isset($post_types_display[$post_type]['show_count']) ? $post_types_display[$post_type]['show_count'] : '';
                    $show_menu = isset($post_types_display[$post_type]['show_menu']) ? $post_types_display[$post_type]['show_menu'] : '';



                    //echo '<pre>'.var_export($enable).'</pre>';

                    ?>
                    <div class="item template <?php //echo $post_type; ?>">
                        <div class="header">
                        <span title="<?php echo __('Click to expand', 'job-board-manager'); ?>" class="expand ">
                            <i class="fa fa-expand"></i>
                            <i class="fa fa-compress"></i>
                        </span>

                            <?php
                            if($enable =='yes'):
                                ?>
                                <span title="<?php echo __('Enable', 'job-board-manager'); ?>" class="is-enable ">
                            <i class="fa fa-check-square"></i>
                            </span>
                            <?php
                            else:
                                ?>
                                <span title="<?php echo __('Disabled', 'job-board-manager'); ?>" class="is-enable ">
                            <i class="fa fa-times-circle"></i>
                            </span>
                            <?php
                            endif;
                            ?>


                            <?php echo $post_name; ?>
                        </div>
                        <input type="hidden" name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][name]" value="<?php echo $post_type; ?>" />
                        <div class="options">
                            <div class="description"><?php echo $description; ?></div><br/><br/>


                            <div class="setting-field">
                                <div class="field-lable"><?php echo __('Enable?', 'job-board-manager'); ?></div>
                                <div class="field-input">
                                    <select name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][enable]" >
                                        <option <?php echo selected($enable,'yes'); ?> value="yes" ><?php echo __('Yes', 'job-board-manager'); ?></option>
                                        <option <?php echo selected($enable,'no'); ?>  value="no" ><?php echo __('No', 'job-board-manager'); ?></option>
                                    </select>
                                    <p class="description"><?php echo __('Enable or disable this email notification.', 'job-board-manager'); ?></p>
                                </div>
                            </div>


                            <div class="setting-field">
                                <div class="field-lable"><?php echo __('Content position?', 'job-board-manager'); ?></div>
                                <div class="field-input">
                                    <select name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][content_position]">
                                        <option <?php echo selected($content_position,'none'); ?>  value="none" ><?php echo __('None', 'job-board-manager'); ?></option>
                                        <option <?php echo selected($content_position,'before'); ?> value="before" ><?php echo __('Before', 'job-board-manager'); ?></option>
                                        <option <?php echo selected($content_position,'after'); ?>  value="after" ><?php echo __('After', 'job-board-manager'); ?></option>

                                    </select>
                                    <p class="description"><?php echo __('Choose wishlist position on content.', 'job-board-manager'); ?></p>
                                </div>
                            </div>


                            <div class="setting-field">
                                <div class="field-lable"><?php echo __('Excerpt position?', 'job-board-manager'); ?></div>
                                <div class="field-input">
                                    <select name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][excerpt_position]">
                                        <option <?php echo selected($excerpt_position,'none'); ?>  value="none" ><?php echo __('None', 'job-board-manager'); ?></option>
                                        <option <?php echo selected($excerpt_position,'before'); ?> value="before" ><?php echo __('Before', 'job-board-manager'); ?></option>
                                        <option <?php echo selected($excerpt_position,'after'); ?>  value="after" ><?php echo __('After', 'job-board-manager'); ?></option>

                                    </select>
                                    <p class="description"><?php echo __('Choose wishlist position on excerpt.', 'job-board-manager'); ?></p>
                                </div>
                            </div>

                            <div class="setting-field">
                                <div class="field-lable"><?php echo __('Active Icon', 'job-board-manager'); ?></div>
                                <div class="field-input">
                                    <input type="text" name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][icon_active]" value="<?php echo esc_attr($icon_active); ?>"/>

                                    <p class="description"><?php echo __('Custom icon for wishlist for this post type, you can use custom HTML or font awesome icon HTML ex: <code>&lt;i class="fas fa-heart">&lt;/i></code>.', 'job-board-manager'); ?></p>
                                </div>
                            </div>


                            <div class="setting-field">
                                <div class="field-lable"><?php echo __('Inactive icon', 'job-board-manager'); ?></div>
                                <div class="field-input">
                                    <input type="text" name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][icon_inactive]" value="<?php echo esc_attr($icon_inactive); ?>"/>

                                    <p class="description"><?php echo __('Custom icon for wishlist for this post type, you can use custom HTML or font awesome icon HTML ex: <code>&lt;i class="far fa-heart">&lt;/i></code>.', 'job-board-manager'); ?></p>
                                </div>
                            </div>

                            <div class="setting-field">
                                <div class="field-lable"><?php echo __('Loading icon', 'job-board-manager'); ?></div>
                                <div class="field-input">
                                    <input type="text" name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][icon_loading]" value="<?php echo esc_attr($icon_loading); ?>"/>

                                    <p class="description"><?php echo __('Custom icon for wishlist for this post type, you can use custom HTML or font awesome icon HTML ex: <code>&lt;i class="fas fa-spinner">&lt;/i></code>.', 'job-board-manager'); ?></p>
                                </div>
                            </div>



                            <div class="setting-field">
                                <div class="field-lable"><?php echo __('Show count?', 'job-board-manager'); ?></div>
                                <div class="field-input">
                                    <select name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][show_count]" >
                                        <option <?php echo selected($show_count,'yes'); ?> value="yes" ><?php echo __('Yes', 'job-board-manager'); ?></option>
                                        <option <?php echo selected($show_count,'no'); ?>  value="no" ><?php echo __('No', 'job-board-manager'); ?></option>
                                    </select>
                                    <p class="description"><?php echo __('Enable or disable this email notification.', 'job-board-manager'); ?></p>
                                </div>
                            </div>
                            <div class="setting-field">
                                <div class="field-lable"><?php echo __('Show menu?', 'job-board-manager'); ?></div>
                                <div class="field-input">
                                    <select name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][show_menu]" >
                                        <option <?php echo selected($show_menu,'yes'); ?> value="yes" ><?php echo __('Yes', 'job-board-manager'); ?></option>
                                        <option <?php echo selected($show_menu,'no'); ?>  value="no" ><?php echo __('No', 'job-board-manager'); ?></option>
                                    </select>
                                    <p class="description"><?php echo __('Enable or disable this email notification.', 'job-board-manager'); ?></p>
                                </div>
                            </div>

                        </div>

                    </div>
                    <?php

                }


            ?>


        </div>
        <?php


        $html = ob_get_clean();




        $args = array(
            'id'		=> 'job_bm_email_templates',
            //'parent'		=> '',
            'title'		=> __('Post types display','job-board-manager'),
            'details'	=> __('Display automatically wishlist under following post types content and excerpt.','job-board-manager'),
            'type'		=> 'custom_html',
            //'multiple'		=> true,
            'html'		=> $html,
        );

        $settings_tabs_field->generate_field($args);















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


        $args = array(
            'id'		=> 'default_wishlist_id',
            'parent'		=> 'wishlist_settings',
            'title'		=> __('default wishlist id','post-grid'),
            'details'	=> __('Set custom number of wislists per page.','post-grid'),
            'type'		=> 'text',
            'value'		=> $default_wishlist_id,
            'default'		=> '',
            'placeholder' => __('3','wishlist'),

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

    $archive_page_id = isset($wishlist_settings['archives']['page_id']) ? $wishlist_settings['archives']['page_id'] : '';

    $pagination_per_page = isset($wishlist_settings['archives']['pagination_per_page']) ? $wishlist_settings['archives']['pagination_per_page'] : '10';
    $pagination_font_size = isset($wishlist_settings['archives']['pagination_font_size']) ? $wishlist_settings['archives']['pagination_font_size'] : '';
    $pagination_color_idle = isset($wishlist_settings['archives']['pagination_color_idle']) ? $wishlist_settings['archives']['pagination_color_idle'] : '';
    $pagination_color_active = isset($wishlist_settings['archives']['pagination_color_active']) ? $wishlist_settings['archives']['pagination_color_active'] : '';

    $pagination_color = isset($wishlist_settings['archives']['pagination_color']) ? $wishlist_settings['archives']['pagination_color'] : '';

    //echo '<pre>'.var_export($wishlist_settings, true).'</pre>';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Archives', 'post-grid'); ?></div>
        <p class="description section-description"><?php echo __('Choose wishlist archives options.', 'post-grid'); ?></p>

        <?php

        $args = array(
            'id'		=> 'page_id',
            'parent'		=> 'wishlist_settings[archives]',
            'title'		=> __('Wishlist archive page','post-grid'),
            'details'	=> __('Users will able to view their wishlist\'s Use shortcode <code>[wishlist_archive]</code> on that page.','post-grid'),
            'type'		=> 'select',
            'value'		=> $archive_page_id,
            'default'		=> '',
            'args'		=> pickplugins_wl_get_wishlist_pages(),
        );

        $settings_tabs_field->generate_field($args);

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
            'title'		=> __('Background color - Normal','post-grid'),
            'details'	=> __('Choose custom color for pagination idle stat.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $pagination_color_idle,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'pagination_color_active',
            'parent'		=> 'wishlist_settings[archives]',
            'title'		=> __('Background color - Active','post-grid'),
            'details'	=> __('Choose custom background color for pagination on active stat.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $pagination_color_active,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'pagination_color',
            'parent'		=> 'wishlist_settings[archives]',
            'title'		=> __('Text color','post-grid'),
            'details'	=> __('Choose custom text color for pagination.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $pagination_color,
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


    $pagination_per_page = isset($wishlist_settings['wishlist_page']['pagination_per_page']) ? $wishlist_settings['wishlist_page']['pagination_per_page'] : '10';
    //echo '<pre>'.var_export($wishlist_settings, true).'</pre>';
    $pagination_font_size = isset($wishlist_settings['wishlist_page']['pagination_font_size']) ? $wishlist_settings['wishlist_page']['pagination_font_size'] : '';
    $pagination_color_idle = isset($wishlist_settings['wishlist_page']['pagination_color_idle']) ? $wishlist_settings['wishlist_page']['pagination_color_idle'] : '';
    $pagination_color_active = isset($wishlist_settings['wishlist_page']['pagination_color_active']) ? $wishlist_settings['wishlist_page']['pagination_color_active'] : '';
    $pagination_color = isset($wishlist_settings['wishlist_page']['pagination_color']) ? $wishlist_settings['wishlist_page']['pagination_color'] : '';



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

        $args = array(
            'id'		=> 'pagination_color',
            'parent'		=> 'wishlist_settings[wishlist_page]',
            'title'		=> __('Text color','post-grid'),
            'details'	=> __('Choose custom text color for pagination.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $pagination_color,
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

            <p><?php echo __('Shortcode for php file', 'related-post'); ?></p>
            <textarea onclick="this.select()">&#60;?php echo do_shortcode( '&#91;wishlist_button show_count="yes" show_menu="yes" icon_active="" icon_inactive="" icon_loading="" &#93;' ); ?&#62;</textarea>
            <p class="description" ><?php echo __('Shortcode inside loop by dynamic post id you can use anywhere inside loop on .php files.', 'related-post'); ?></p>

            <p><?php echo __('Short-code for content', 'related-post'); ?></p>
            <textarea onclick="this.select()">[wishlist_button id="123" show_count="yes" show_menu="yes" icon_active="" icon_inactive="" icon_loading=""]</textarea>

            <p class="description"><?php echo __('Short-code inside content for fixed post id you can use anywhere inside content.', 'related-post'); ?></p>
            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'shortcodes',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Shortcodes','related-post'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);

            ob_start();
            ?>

            <p><?php echo __('Ask question for free on our forum and get quick reply from our expert team members.', 'post-grid'); ?></p>
            <a class="button" target="_blank" href="https://www.pickplugins.com/create-support-ticket/"><?php echo __('Create support ticket', 'post-grid'); ?></a>

            <p><?php echo __('Read our documentation before asking your question.', 'post-grid'); ?></p>
            <a class="button" target="_blank" href="https://www.pickplugins.com/documentation/wishlist/"><?php echo __('Documentation', 'post-grid'); ?></a>

            <p><?php echo __('Watch video tutorials.', 'post-grid'); ?></p>
            <a class="button" target="_blank" href="https://www.youtube.com/playlist?list=PL0QP7T2SN94ZGK1xL5QtEDHlR6Flk9iDH"><i class="fab fa-youtube"></i> <?php echo __('All tutorials', 'post-grid'); ?></a>





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

            <a target="_blank" href="https://wordpress.org/support/plugin/wishlist/reviews/#new-post" class="button"><i class="fab fa-wordpress"></i> Write a review</a>


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
            <a class="button" href="https://www.pickplugins.com/item/woocommerce-wishlist/?ref=dashobard"><?php echo __('Buy premium', 'post-grid'); ?></a>
            <a class="button" href="http://www.pickplugins.com/demo/wishlist/?ref=dashobard"><?php echo __('See all demo', 'post-grid'); ?></a>

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
                    <td class="col-features"><?php echo __('Any post type support','post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Ready WooCommerce','post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Unlimited wishlist by any user','post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Public or private wishlist','post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('User can edit wishlist','post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('User can delete wishlist','post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Default wishlist id','post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>


                <tr>
                    <td class="col-features"><?php echo __('Wishlist archive page','post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Breadcrumb on wishlist page','post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>




                <tr>
                    <td class="col-features"><?php echo __('Wishlist view count','post-grid'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Wishlist thumb up & down vote','post-grid'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Social share on wishlist','post-grid'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Copy to duplicate others user wishlist','post-grid'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Total wishlisted count by post id','post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Search wishlist','post-grid'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>


                <tr>
                    <td class="col-features"><?php echo __('Wishlist button font size','post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Wishlist button custom color','post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <th class="col-features"><?php echo __('Features','post-grid'); ?></th>
                    <th class="col-free"><?php echo __('Free','post-grid'); ?></th>
                    <th class="col-pro"><?php echo __('Premium','post-grid'); ?></th>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Buy now','post-grid'); ?></td>
                    <td> </td>
                    <td><a class="button" href="https://www.pickplugins.com/item/woocommerce-wishlist/?ref=dashobard"><?php echo __('Buy premium', 'post-grid'); ?></a></td>
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
