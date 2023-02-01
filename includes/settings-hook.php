<?php
if (!defined('ABSPATH')) exit;  // if direct access

add_action('wishlist_settings_content_general', 'wishlist_settings_content_general');

function wishlist_settings_content_general()
{
    $settings_tabs_field = new settings_tabs_field();

    $wishlist_settings = get_option('wishlist_settings');
    $wishlist_plugin_info = get_option('wishlist_plugin_info');

    //delete_option('wishlist_settings');

    $font_aw_version = isset($wishlist_settings['general']['font_aw_version']) ? $wishlist_settings['general']['font_aw_version'] : 'v_5';
    $post_types_display = isset($wishlist_settings['post_types_display']) ? $wishlist_settings['post_types_display'] : array();
    $default_wishlist_id = isset($wishlist_settings['default_wishlist_id']) ? $wishlist_settings['default_wishlist_id'] : '';
    $default_wishlist_access = isset($wishlist_settings['default_wishlist_access']) ? $wishlist_settings['default_wishlist_access'] : 'private';


    $wishlist_slug = isset($wishlist_settings['wishlist_slug']) ? $wishlist_settings['wishlist_slug'] : 'wishlist';
    $taxonomy_display = isset($wishlist_settings['taxonomy_display']) ? $wishlist_settings['taxonomy_display'] : array();


    $sticky_posts = get_option('sticky_posts');
    $sticky_posts = !empty($sticky_posts) ? $sticky_posts : [];

    if (!in_array($default_wishlist_id, $sticky_posts)) :
        $sticky_posts[] = $default_wishlist_id;
        update_option('sticky_posts', $sticky_posts);
    endif;


    //echo '<pre>'.var_export($wishlist_plugin_info, true).'</pre>';

?>
    <div class="section">
        <div class="section-title"><?php echo __('General', 'wishlist'); ?></div>
        <p class="description section-description"><?php echo __('Choose some general options.', 'wishlist'); ?></p>

        <?php






        ob_start();


        ?>
        <div class="templates_editor expandable">
            <?php

            //$post_types = apply_filters('wishlist_posttypes', array('post'=>'Post', 'page' => 'Page'));
            $post_types = wishlist_posttypes_array();


            if (!empty($post_types))
                foreach ($post_types as $post_type => $post_name) {



                    $content_position = isset($post_types_display[$post_type]['content_position']) ? $post_types_display[$post_type]['content_position'] : 'before';
                    $enable = isset($post_types_display[$post_type]['enable']) ? $post_types_display[$post_type]['enable'] : 'no';
                    $description = isset($post_types_display[$post_type]['description']) ? $post_types_display[$post_type]['description'] : '';
                    $excerpt_position = isset($post_types_display[$post_type]['excerpt_position']) ? $post_types_display[$post_type]['excerpt_position'] : 'before';
                    $icon_active = isset($post_types_display[$post_type]['icon_active']) ? $post_types_display[$post_type]['icon_active'] : '<i class="fas fa-heart"></i>';
                    $icon_inactive = isset($post_types_display[$post_type]['icon_inactive']) ? $post_types_display[$post_type]['icon_inactive'] : '<i class="far fa-heart"></i>';
                    $icon_loading = isset($post_types_display[$post_type]['icon_loading']) ? $post_types_display[$post_type]['icon_loading'] : '<i class="fas fa-spinner fa-spin"></i>';
                    $icon_menu = isset($post_types_display[$post_type]['icon_menu']) ? $post_types_display[$post_type]['icon_menu'] : '<i class="fas fa-bars"></i>';



                    $show_count = isset($post_types_display[$post_type]['show_count']) ? $post_types_display[$post_type]['show_count'] : 'yes';
                    $show_menu = isset($post_types_display[$post_type]['show_menu']) ? $post_types_display[$post_type]['show_menu'] : 'yes';



                    //echo '<pre>'.var_export($enable).'</pre>';

            ?>
                <div class="item template <?php //echo $post_type; 
                                            ?>">
                    <div class="header">
                        <span title="<?php echo __('Click to expand', 'wishlist'); ?>" class="expand ">
                            <i class="fa fa-expand"></i>
                            <i class="fa fa-compress"></i>
                        </span>

                        <?php
                        if ($enable == 'yes') :
                        ?>
                            <span title="<?php echo __('Enable', 'wishlist'); ?>" class="is-enable ">
                                <i class="fa fa-check-square"></i>
                            </span>
                        <?php
                        else :
                        ?>
                            <span title="<?php echo __('Disabled', 'wishlist'); ?>" class="is-enable ">
                                <i class="fa fa-times-circle"></i>
                            </span>
                        <?php
                        endif;
                        ?>


                        <?php echo $post_name; ?>
                    </div>
                    <input type="hidden" name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][name]" value="<?php echo $post_type; ?>" />
                    <div class="options">
                        <div class="description"><?php echo $description; ?></div><br /><br />


                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Enable?', 'wishlist'); ?></div>
                            <div class="field-input">
                                <select name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][enable]">
                                    <option <?php echo selected($enable, 'yes'); ?> value="yes"><?php echo __('Yes', 'wishlist'); ?></option>
                                    <option <?php echo selected($enable, 'no'); ?> value="no"><?php echo __('No', 'wishlist'); ?></option>
                                </select>
                                <p class="description"><?php echo __('Enable or disable this email notification.', 'wishlist'); ?></p>
                            </div>
                        </div>


                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Content position?', 'wishlist'); ?></div>
                            <div class="field-input">
                                <select name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][content_position]">
                                    <option <?php echo selected($content_position, 'none'); ?> value="none"><?php echo __('None', 'wishlist'); ?></option>
                                    <option <?php echo selected($content_position, 'before'); ?> value="before"><?php echo __('Before', 'wishlist'); ?></option>
                                    <option <?php echo selected($content_position, 'after'); ?> value="after"><?php echo __('After', 'wishlist'); ?></option>

                                </select>
                                <p class="description"><?php echo __('Choose wishlist position on content.', 'wishlist'); ?></p>
                            </div>
                        </div>


                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Excerpt position?', 'wishlist'); ?></div>
                            <div class="field-input">
                                <select name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][excerpt_position]">
                                    <option <?php echo selected($excerpt_position, 'none'); ?> value="none"><?php echo __('None', 'wishlist'); ?></option>
                                    <option <?php echo selected($excerpt_position, 'before'); ?> value="before"><?php echo __('Before', 'wishlist'); ?></option>
                                    <option <?php echo selected($excerpt_position, 'after'); ?> value="after"><?php echo __('After', 'wishlist'); ?></option>

                                </select>
                                <p class="description"><?php echo __('Choose wishlist position on excerpt.', 'wishlist'); ?></p>
                            </div>
                        </div>

                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Active Icon', 'wishlist'); ?></div>
                            <div class="field-input">
                                <input type="text" name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][icon_active]" value="<?php echo esc_attr($icon_active); ?>" />

                                <p class="description"><?php echo __('Custom icon for wishlist for this post type, you can use custom HTML or font awesome icon HTML ex: <code>&lt;i class="fas fa-heart">&lt;/i></code>.', 'wishlist'); ?></p>
                            </div>
                        </div>


                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Inactive icon', 'wishlist'); ?></div>
                            <div class="field-input">
                                <input type="text" name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][icon_inactive]" value="<?php echo esc_attr($icon_inactive); ?>" />

                                <p class="description"><?php echo __('Custom icon for wishlist for this post type, you can use custom HTML or font awesome icon HTML ex: <code>&lt;i class="far fa-heart">&lt;/i></code>.', 'wishlist'); ?></p>
                            </div>
                        </div>

                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Loading icon', 'wishlist'); ?></div>
                            <div class="field-input">
                                <input type="text" name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][icon_loading]" value="<?php echo esc_attr($icon_loading); ?>" />

                                <p class="description"><?php echo __('Custom icon for wishlist for this post type, you can use custom HTML or font awesome icon HTML ex: <code>&lt;i class="fas fa-spinner fa-spin">&lt;/i></code>.', 'wishlist'); ?></p>
                            </div>
                        </div>

                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Menu icon', 'wishlist'); ?></div>
                            <div class="field-input">
                                <input type="text" name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][icon_menu]" value="<?php echo esc_attr($icon_menu); ?>" />

                                <p class="description"><?php echo __('Custom icon for wishlist menu toggle button for this post type, you can use custom HTML or font awesome icon HTML ex: <code>&lt;i class="fas fa-spinner fa-spin">&lt;/i></code>.', 'wishlist'); ?></p>
                            </div>
                        </div>



                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Show count?', 'wishlist'); ?></div>
                            <div class="field-input">
                                <select name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][show_count]">
                                    <option <?php echo selected($show_count, 'yes'); ?> value="yes"><?php echo __('Yes', 'wishlist'); ?></option>
                                    <option <?php echo selected($show_count, 'no'); ?> value="no"><?php echo __('No', 'wishlist'); ?></option>
                                </select>
                                <p class="description"><?php echo __('Enable or disable this email notification.', 'wishlist'); ?></p>
                            </div>
                        </div>
                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Show menu?', 'wishlist'); ?></div>
                            <div class="field-input">
                                <select name="wishlist_settings[post_types_display][<?php echo $post_type; ?>][show_menu]">
                                    <option <?php echo selected($show_menu, 'yes'); ?> value="yes"><?php echo __('Yes', 'wishlist'); ?></option>
                                    <option <?php echo selected($show_menu, 'no'); ?> value="no"><?php echo __('No', 'wishlist'); ?></option>
                                </select>
                                <p class="description"><?php echo __('Enable or disable this email notification.', 'wishlist'); ?></p>
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
            'id'        => 'post_types',
            //'parent'		=> '',
            'title'        => __('Post types display', 'wishlist'),
            'details'    => __('Display automatically wishlist under following post types content and excerpt.', 'wishlist'),
            'type'        => 'custom_html',
            //'multiple'		=> true,
            'html'        => $html,
        );

        $settings_tabs_field->generate_field($args);






        ob_start();


        ?>
        <div class="templates_editor expandable">
            <?php

            //$post_types = apply_filters('wishlist_posttypes', array('post'=>'Post', 'page' => 'Page'));

            $taxonomies = wishlist_get_taxonomies();

            //echo '<pre>'.var_export($taxonomies, true).'</pre>';

            if (!empty($taxonomies))
                foreach ($taxonomies as $post_type => $post_name) {



                    $title_position = isset($taxonomy_display[$post_type]['title_position']) ? $taxonomy_display[$post_type]['title_position'] : 'before';
                    $enable = isset($taxonomy_display[$post_type]['enable']) ? $taxonomy_display[$post_type]['enable'] : 'no';
                    $description = isset($taxonomy_display[$post_type]['description']) ? $taxonomy_display[$post_type]['description'] : '';
                    $desc_position = isset($taxonomy_display[$post_type]['desc_position']) ? $taxonomy_display[$post_type]['desc_position'] : 'none';
                    $icon_active = isset($taxonomy_display[$post_type]['icon_active']) ? $taxonomy_display[$post_type]['icon_active'] : '<i class="fas fa-heart"></i>';
                    $icon_inactive = isset($taxonomy_display[$post_type]['icon_inactive']) ? $taxonomy_display[$post_type]['icon_inactive'] : '<i class="far fa-heart"></i>';
                    $icon_loading = isset($taxonomy_display[$post_type]['icon_loading']) ? $taxonomy_display[$post_type]['icon_loading'] : '<i class="fas fa-spinner fa-spin"></i>';
                    $icon_menu = isset($taxonomy_display[$post_type]['icon_menu']) ? $taxonomy_display[$post_type]['icon_menu'] : '<i class="fas fa-bars"></i>';


                    $show_count = isset($taxonomy_display[$post_type]['show_count']) ? $taxonomy_display[$post_type]['show_count'] : 'yes';
                    $show_menu = isset($taxonomy_display[$post_type]['show_menu']) ? $taxonomy_display[$post_type]['show_menu'] : 'yes';



                    //echo '<pre>'.var_export($enable).'</pre>';

            ?>
                <div class="item template <?php //echo $post_type; 
                                            ?>">
                    <div class="header">
                        <span title="<?php echo __('Click to expand', 'wishlist'); ?>" class="expand ">
                            <i class="fa fa-expand"></i>
                            <i class="fa fa-compress"></i>
                        </span>

                        <?php
                        if ($enable == 'yes') :
                        ?>
                            <span title="<?php echo __('Enable', 'wishlist'); ?>" class="is-enable ">
                                <i class="fa fa-check-square"></i>
                            </span>
                        <?php
                        else :
                        ?>
                            <span title="<?php echo __('Disabled', 'wishlist'); ?>" class="is-enable ">
                                <i class="fa fa-times-circle"></i>
                            </span>
                        <?php
                        endif;
                        ?>


                        <?php echo $post_name; ?>
                    </div>
                    <input type="hidden" name="wishlist_settings[taxonomy_display][<?php echo $post_type; ?>][name]" value="<?php echo $post_type; ?>" />
                    <div class="options">
                        <div class="description"><?php echo $description; ?></div><br /><br />


                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Enable?', 'wishlist'); ?></div>
                            <div class="field-input">
                                <select name="wishlist_settings[taxonomy_display][<?php echo $post_type; ?>][enable]">
                                    <option <?php echo selected($enable, 'yes'); ?> value="yes"><?php echo __('Yes', 'wishlist'); ?></option>
                                    <option <?php echo selected($enable, 'no'); ?> value="no"><?php echo __('No', 'wishlist'); ?></option>
                                </select>
                                <p class="description"><?php echo __('Enable or disable this email notification.', 'wishlist'); ?></p>
                            </div>
                        </div>


                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Term title position?', 'wishlist'); ?></div>
                            <div class="field-input">
                                <select name="wishlist_settings[taxonomy_display][<?php echo $post_type; ?>][title_position]">
                                    <option <?php echo selected($title_position, 'none'); ?> value="none"><?php echo __('None', 'wishlist'); ?></option>
                                    <option <?php echo selected($title_position, 'before'); ?> value="before"><?php echo __('Before', 'wishlist'); ?></option>
                                    <option <?php echo selected($title_position, 'after'); ?> value="after"><?php echo __('After', 'wishlist'); ?></option>

                                </select>
                                <p class="description"><?php echo __('Choose wishlist position on content.', 'wishlist'); ?></p>
                            </div>
                        </div>


                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Term Description position?', 'wishlist'); ?></div>
                            <div class="field-input">
                                <select name="wishlist_settings[taxonomy_display][<?php echo $post_type; ?>][desc_position]">
                                    <option <?php echo selected($desc_position, 'none'); ?> value="none"><?php echo __('None', 'wishlist'); ?></option>
                                    <option <?php echo selected($desc_position, 'before'); ?> value="before"><?php echo __('Before', 'wishlist'); ?></option>
                                    <option <?php echo selected($desc_position, 'after'); ?> value="after"><?php echo __('After', 'wishlist'); ?></option>

                                </select>
                                <p class="description"><?php echo __('Choose wishlist position on excerpt.', 'wishlist'); ?></p>
                            </div>
                        </div>

                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Active Icon', 'wishlist'); ?></div>
                            <div class="field-input">
                                <input type="text" name="wishlist_settings[taxonomy_display][<?php echo $post_type; ?>][icon_active]" value="<?php echo esc_attr($icon_active); ?>" />

                                <p class="description"><?php echo __('Custom icon for wishlist for this post type, you can use custom HTML or font awesome icon HTML ex: <code>&lt;i class="fas fa-heart">&lt;/i></code>.', 'wishlist'); ?></p>
                            </div>
                        </div>


                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Inactive icon', 'wishlist'); ?></div>
                            <div class="field-input">
                                <input type="text" name="wishlist_settings[taxonomy_display][<?php echo $post_type; ?>][icon_inactive]" value="<?php echo esc_attr($icon_inactive); ?>" />

                                <p class="description"><?php echo __('Custom icon for wishlist for this post type, you can use custom HTML or font awesome icon HTML ex: <code>&lt;i class="far fa-heart">&lt;/i></code>.', 'wishlist'); ?></p>
                            </div>
                        </div>

                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Loading icon', 'wishlist'); ?></div>
                            <div class="field-input">
                                <input type="text" name="wishlist_settings[taxonomy_display][<?php echo $post_type; ?>][icon_loading]" value="<?php echo esc_attr($icon_loading); ?>" />

                                <p class="description"><?php echo __('Custom icon for wishlist for this post type, you can use custom HTML or font awesome icon HTML ex: <code>&lt;i class="fas fa-spinner fa-spin">&lt;/i></code>.', 'wishlist'); ?></p>
                            </div>
                        </div>


                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Menu icon', 'wishlist'); ?></div>
                            <div class="field-input">
                                <input type="text" name="wishlist_settings[taxonomy_display][<?php echo $post_type; ?>][icon_menu]" value="<?php echo esc_attr($icon_menu); ?>" />

                                <p class="description"><?php echo __('Custom icon for wishlist menu toggle for this post type, you can use custom HTML or font awesome icon HTML ex: <code>&lt;i class="fas fa-spinner fa-spin">&lt;/i></code>.', 'wishlist'); ?></p>
                            </div>
                        </div>




                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Show count?', 'wishlist'); ?></div>
                            <div class="field-input">
                                <select name="wishlist_settings[taxonomy_display][<?php echo $post_type; ?>][show_count]">
                                    <option <?php echo selected($show_count, 'yes'); ?> value="yes"><?php echo __('Yes', 'wishlist'); ?></option>
                                    <option <?php echo selected($show_count, 'no'); ?> value="no"><?php echo __('No', 'wishlist'); ?></option>
                                </select>
                                <p class="description"><?php echo __('Enable or disable this email notification.', 'wishlist'); ?></p>
                            </div>
                        </div>
                        <div class="setting-field">
                            <div class="field-lable"><?php echo __('Show menu?', 'wishlist'); ?></div>
                            <div class="field-input">
                                <select name="wishlist_settings[taxonomy_display][<?php echo $post_type; ?>][show_menu]">
                                    <option <?php echo selected($show_menu, 'yes'); ?> value="yes"><?php echo __('Yes', 'wishlist'); ?></option>
                                    <option <?php echo selected($show_menu, 'no'); ?> value="no"><?php echo __('No', 'wishlist'); ?></option>
                                </select>
                                <p class="description"><?php echo __('Enable or disable this email notification.', 'wishlist'); ?></p>
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
            'id'        => 'taxonomies',
            //'parent'		=> '',
            'title'        => __('Taxonomies & terms display', 'wishlist'),
            'details'    => __('Display automatically wishlist under following taxonomies & terms title and descriptions.', 'wishlist'),
            'type'        => 'custom_html',
            //'multiple'		=> true,
            'html'        => $html,
        );

        $settings_tabs_field->generate_field($args);











        $args = array(
            'id'        => 'font_aw_version',
            'parent'        => 'wishlist_settings[general]',
            'title'        => __('Font-awesome version', 'wishlist'),
            'details'    => __('Choose font awesome version you want to load.', 'wishlist'),
            'type'        => 'select',
            'value'        => $font_aw_version,
            'default'        => 'v_5',
            'args'        => array('v_5' => __('Version 5+', 'wishlist'), 'v_4' => __('Version 4+', 'wishlist'), 'none' => __('None', 'wishlist')),
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'default_wishlist_id',
            'parent'        => 'wishlist_settings',
            'title'        => __('Default wishlist id', 'wishlist'),
            'details'    => __('Set default wishlist id.', 'wishlist'),
            'type'        => 'text',
            'value'        => $default_wishlist_id,
            'default'        => '',
            'placeholder' => __('123', 'wishlist'),

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'default_wishlist_access',
            'parent'        => 'wishlist_settings',
            'title'        => __('Default wishlist access', 'wishlist'),
            'details'    => __('Set default wishlist access to public or private.', 'wishlist'),
            'type'        => 'select',
            'value'        => $default_wishlist_access,
            'default'        => 'private',
            'args'        => array('public' => __('Public', 'wishlist'), 'private' => __('Private', 'wishlist'),),
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'wishlist_slug',
            'parent'        => 'wishlist_settings',
            'title'        => __('Wishlist slug', 'wishlist'),
            'details'    => __('Set wishlist slug', 'wishlist'),
            'type'        => 'text',
            'value'        => $wishlist_slug,
            'default'        => '',
            'placeholder' => __('wishlist', 'wishlist'),

        );

        $settings_tabs_field->generate_field($args);


        ?>

    </div>

<?php





}





add_action('wishlist_settings_content_archives', 'wishlist_settings_content_archives');

function wishlist_settings_content_archives()
{
    $settings_tabs_field = new settings_tabs_field();

    $wishlist_settings = get_option('wishlist_settings');

    $archive_page_id = isset($wishlist_settings['archives']['page_id']) ? $wishlist_settings['archives']['page_id'] : '';

    $pagination_per_page = isset($wishlist_settings['archives']['pagination_per_page']) ? $wishlist_settings['archives']['pagination_per_page'] : '10';
    $pagination_font_size = isset($wishlist_settings['archives']['pagination_font_size']) ? $wishlist_settings['archives']['pagination_font_size'] : '16px';
    $pagination_color_idle = isset($wishlist_settings['archives']['pagination_color_idle']) ? $wishlist_settings['archives']['pagination_color_idle'] : '#226ad6';
    $pagination_color_active = isset($wishlist_settings['archives']['pagination_color_active']) ? $wishlist_settings['archives']['pagination_color_active'] : '#6b8fef';

    $pagination_color = isset($wishlist_settings['archives']['pagination_color']) ? $wishlist_settings['archives']['pagination_color'] : '';

    //echo '<pre>'.var_export($wishlist_settings, true).'</pre>';

?>
    <div class="section">
        <div class="section-title"><?php echo __('Archives', 'wishlist'); ?></div>
        <p class="description section-description"><?php echo __('Choose wishlist archives options.', 'wishlist'); ?></p>

        <?php

        $args = array(
            'id'        => 'page_id',
            'parent'        => 'wishlist_settings[archives]',
            'title'        => __('Wishlist archive page', 'wishlist'),
            'details'    => __('Users will able to view their wishlist\'s Use shortcode <code>[wishlist_archive]</code> on that page.', 'wishlist'),
            'type'        => 'select',
            'value'        => $archive_page_id,
            'default'        => '',
            'args'        => pickplugins_wl_get_wishlist_pages(),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'pagination_per_page',
            'parent'        => 'wishlist_settings[archives]',
            'title'        => __('Item per page', 'wishlist'),
            'details'    => __('Set custom number of wislists per page.', 'wishlist'),
            'type'        => 'text',
            'value'        => $pagination_per_page,
            'default'        => '',
            'placeholder' => __('10', 'wishlist'),

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'pagination_font_size',
            'parent'        => 'wishlist_settings[archives]',
            'title'        => __('Pagination font size', 'wishlist'),
            'details'    => __('Set pagination font size.', 'wishlist'),
            'type'        => 'text',
            'value'        => $pagination_font_size,
            'default'        => '12px',
            'placeholder'        => '12px',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'pagination_color_idle',
            'parent'        => 'wishlist_settings[archives]',
            'title'        => __('Background color - Normal', 'wishlist'),
            'details'    => __('Choose custom color for pagination idle stat.', 'wishlist'),
            'type'        => 'colorpicker',
            'value'        => $pagination_color_idle,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'pagination_color_active',
            'parent'        => 'wishlist_settings[archives]',
            'title'        => __('Background color - Active', 'wishlist'),
            'details'    => __('Choose custom background color for pagination on active stat.', 'wishlist'),
            'type'        => 'colorpicker',
            'value'        => $pagination_color_active,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'pagination_color',
            'parent'        => 'wishlist_settings[archives]',
            'title'        => __('Text color', 'wishlist'),
            'details'    => __('Choose custom text color for pagination.', 'wishlist'),
            'type'        => 'colorpicker',
            'value'        => $pagination_color,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        ?>

    </div>

<?php





}





add_action('wishlist_settings_content_my_wishlist', 'wishlist_settings_content_my_wishlist');

function wishlist_settings_content_my_wishlist()
{
    $settings_tabs_field = new settings_tabs_field();

    $wishlist_settings = get_option('wishlist_settings');

    $my_wishlist_page_id = isset($wishlist_settings['my_wishlist']['page_id']) ? $wishlist_settings['my_wishlist']['page_id'] : '';

    $posts_per_page = isset($wishlist_settings['my_wishlist']['posts_per_page']) ? $wishlist_settings['my_wishlist']['posts_per_page'] : '10';
    $pagination_font_size = isset($wishlist_settings['my_wishlist']['pagination_font_size']) ? $wishlist_settings['my_wishlist']['pagination_font_size'] : '16px';
    $pagination_color_idle = isset($wishlist_settings['my_wishlist']['pagination_color_idle']) ? $wishlist_settings['my_wishlist']['pagination_color_idle'] : '#226ad6';
    $pagination_color_active = isset($wishlist_settings['my_wishlist']['pagination_color_active']) ? $wishlist_settings['my_wishlist']['pagination_color_active'] : '#6b8fef';

    $pagination_color = isset($wishlist_settings['my_wishlist']['pagination_color']) ? $wishlist_settings['my_wishlist']['pagination_color'] : '';

    //echo '<pre>'.var_export($wishlist_settings, true).'</pre>';

?>
    <div class="section">
        <div class="section-title"><?php echo __('My wishlist\'s', 'wishlist'); ?></div>
        <p class="description section-description"><?php echo __('Choose My wishlist options.', 'wishlist'); ?></p>

        <?php

        $args = array(
            'id'        => 'page_id',
            'parent'        => 'wishlist_settings[my_wishlist]',
            'title'        => __('My wishlist page', 'wishlist'),
            'details'    => __('Users will able to view their wishlist\'s, use shortcode <code>[my_wishlist]</code> on that page.', 'wishlist'),
            'type'        => 'select',
            'value'        => $my_wishlist_page_id,
            'default'        => '',
            'args'        => pickplugins_wl_get_wishlist_pages(),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'posts_per_page',
            'parent'        => 'wishlist_settings[my_wishlist]',
            'title'        => __('Item per page', 'wishlist'),
            'details'    => __('Set custom number of item per page.', 'wishlist'),
            'type'        => 'text',
            'value'        => $posts_per_page,
            'default'        => '',
            'placeholder' => __('10', 'wishlist'),

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'pagination_font_size',
            'parent'        => 'wishlist_settings[my_wishlist]',
            'title'        => __('Pagination font size', 'wishlist'),
            'details'    => __('Set pagination font size.', 'wishlist'),
            'type'        => 'text',
            'value'        => $pagination_font_size,
            'default'        => '12px',
            'placeholder'        => '12px',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'pagination_color_idle',
            'parent'        => 'wishlist_settings[my_wishlist]',
            'title'        => __('Background color - Normal', 'wishlist'),
            'details'    => __('Choose custom color for pagination idle stat.', 'wishlist'),
            'type'        => 'colorpicker',
            'value'        => $pagination_color_idle,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'pagination_color_active',
            'parent'        => 'wishlist_settings[my_wishlist]',
            'title'        => __('Background color - Active', 'wishlist'),
            'details'    => __('Choose custom background color for pagination on active stat.', 'wishlist'),
            'type'        => 'colorpicker',
            'value'        => $pagination_color_active,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'pagination_color',
            'parent'        => 'wishlist_settings[my_wishlist]',
            'title'        => __('Text color', 'wishlist'),
            'details'    => __('Choose custom text color for pagination.', 'wishlist'),
            'type'        => 'colorpicker',
            'value'        => $pagination_color,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        ?>

    </div>

<?php





}



add_action('wishlist_settings_content_wishlist_page', 'wishlist_settings_content_wishlist_page');

function wishlist_settings_content_wishlist_page()
{
    $settings_tabs_field = new settings_tabs_field();

    $wishlist_settings = get_option('wishlist_settings');

    $breadcrumb_enable = isset($wishlist_settings['wishlist_page']['breadcrumb_enable']) ? $wishlist_settings['wishlist_page']['breadcrumb_enable'] : 'yes';
    $breadcrumb_home_text = isset($wishlist_settings['wishlist_page']['breadcrumb_home_text']) ? $wishlist_settings['wishlist_page']['breadcrumb_home_text'] : '';
    $breadcrumb_text_color = isset($wishlist_settings['wishlist_page']['breadcrumb_text_color']) ? $wishlist_settings['wishlist_page']['breadcrumb_text_color'] : 'yes';


    $pagination_per_page = isset($wishlist_settings['wishlist_page']['pagination_per_page']) ? $wishlist_settings['wishlist_page']['pagination_per_page'] : '10';
    //echo '<pre>'.var_export($wishlist_settings, true).'</pre>';
    $pagination_font_size = isset($wishlist_settings['wishlist_page']['pagination_font_size']) ? $wishlist_settings['wishlist_page']['pagination_font_size'] : '16px';
    $pagination_color_idle = isset($wishlist_settings['wishlist_page']['pagination_color_idle']) ? $wishlist_settings['wishlist_page']['pagination_color_idle'] : '#226ad6';
    $pagination_color_active = isset($wishlist_settings['wishlist_page']['pagination_color_active']) ? $wishlist_settings['wishlist_page']['pagination_color_active'] : '#6b8fef';
    $pagination_color = isset($wishlist_settings['wishlist_page']['pagination_color']) ? $wishlist_settings['wishlist_page']['pagination_color'] : '';



?>
    <div class="section">
        <div class="section-title"><?php echo __('Breadcrumb', 'wishlist'); ?></div>
        <p class="description section-description"><?php echo __('Choose some general options.', 'wishlist'); ?></p>

        <?php

        $args = array(
            'id'        => 'breadcrumb_enable',
            'parent'        => 'wishlist_settings[wishlist_page]',
            'title'        => __('Display breadcrumb', 'wishlist'),
            'details'    => __('Display breadcrumb on wishlist single page.', 'wishlist'),
            'type'        => 'select',
            'value'        => $breadcrumb_enable,
            'default'        => '',
            'args'        => array('yes' => 'Yes', 'no' => 'No'),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'breadcrumb_home_text',
            'parent'        => 'wishlist_settings[wishlist_page]',
            'title'        => __('Custom text for "Home"', 'wishlist'),
            'details'    => __('You can change default text for "Home" on breadcrumb.', 'wishlist'),
            'type'        => 'text',
            'value'        => $breadcrumb_home_text,
            'default'        => '',
            'placeholder' => __('Home', 'wishlist'),

        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'breadcrumb_text_color',
            'parent'        => 'wishlist_settings[wishlist_page]',
            'title'        => __('Breadcrumb text color', 'wishlist'),
            'details'    => __('Choose custom color for breadcrumb.', 'wishlist'),
            'type'        => 'colorpicker',
            'value'        => $breadcrumb_text_color,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);

        ?>

    </div>
    <div class="section">
        <div class="section-title"><?php echo __('Pagination', 'wishlist'); ?></div>
        <p class="description section-description"><?php echo __('Choose some pagination options.', 'wishlist'); ?></p>

        <?php
        $args = array(
            'id'        => 'pagination_per_page',
            'parent'        => 'wishlist_settings[wishlist_page]',
            'title'        => __('Item per page', 'wishlist'),
            'details'    => __('Set custom number of item/post per page.', 'wishlist'),
            'type'        => 'text',
            'value'        => $pagination_per_page,
            'default'        => '',
            'placeholder' => __('10', 'wishlist'),

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'pagination_font_size',
            'parent'        => 'wishlist_settings[wishlist_page]',
            'title'        => __('Wishlist button font size', 'wishlist'),
            'details'    => __('Set wishlist button font size.', 'wishlist'),
            'type'        => 'text',
            'value'        => $pagination_font_size,
            'default'        => '12px',
            'placeholder'        => '12px',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'pagination_color_idle',
            'parent'        => 'wishlist_settings[wishlist_page]',
            'title'        => __('Pagination color - Normal', 'wishlist'),
            'details'    => __('Choose custom color for pagination idle stat.', 'wishlist'),
            'type'        => 'colorpicker',
            'value'        => $pagination_color_idle,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'pagination_color_active',
            'parent'        => 'wishlist_settings[wishlist_page]',
            'title'        => __('Pagination color - Active', 'wishlist'),
            'details'    => __('Choose custom color for pagination on active stat.', 'wishlist'),
            'type'        => 'colorpicker',
            'value'        => $pagination_color_active,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'pagination_color',
            'parent'        => 'wishlist_settings[wishlist_page]',
            'title'        => __('Text color', 'wishlist'),
            'details'    => __('Choose custom text color for pagination.', 'wishlist'),
            'type'        => 'colorpicker',
            'value'        => $pagination_color,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        ?>

    </div>

<?php





}











add_action('wishlist_settings_content_style', 'wishlist_settings_content_style');

function wishlist_settings_content_style()
{
    $settings_tabs_field = new settings_tabs_field();

    $wishlist_settings = get_option('wishlist_settings');

    $font_size = isset($wishlist_settings['style']['font_size']) ? $wishlist_settings['style']['font_size'] : '18px';
    $color_active = isset($wishlist_settings['style']['color_active']) ? $wishlist_settings['style']['color_active'] : '#e54c34';
    $color_idle = isset($wishlist_settings['style']['color_idle']) ? $wishlist_settings['style']['color_idle'] : '#848484';

    $icon_active = isset($wishlist_settings['style']['icon_active']) ? $wishlist_settings['style']['icon_active'] : '<i class="fas fa-heart"></i>';
    $icon_inactive = isset($wishlist_settings['style']['icon_inactive']) ? $wishlist_settings['style']['icon_inactive'] : '<i class="far fa-heart"></i>';
    $icon_loading = isset($wishlist_settings['style']['icon_loading']) ? $wishlist_settings['style']['icon_loading'] : '<i class="fas fa-spinner fa-spin"></i>';
    $icon_menu = isset($wishlist_settings['style']['icon_menu']) ? $wishlist_settings['style']['icon_menu'] : '<i class="fas fa-bars"></i>';

    //echo '<pre>'.var_export($wishlist_settings, true).'</pre>';

?>
    <div class="section">
        <div class="section-title"><?php echo __('General', 'wishlist'); ?></div>
        <p class="description section-description"><?php echo __('Choose some general options.', 'wishlist'); ?></p>

        <?php


        $args = array(
            'id'        => 'icon_active',
            'parent'        => 'wishlist_settings[style]',
            'title'        => __('Active Icon', 'wishlist'),
            'details'    => __('Set custom active icon. ex: <code>&lt;i class="fas fa-heart">&lt;/i></code>', 'wishlist'),
            'type'        => 'text',
            'value'        => $icon_active,
            'default'        => '',
            'placeholder' => '',

        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'icon_inactive',
            'parent'        => 'wishlist_settings[style]',
            'title'        => __('Inactive icon', 'wishlist'),
            'details'    => __('Set custom inactive icon. ex: <code>&lt;i class="far fa-heart">&lt;/i></code>', 'wishlist'),
            'type'        => 'text',
            'value'        => $icon_inactive,
            'default'        => '',
            'placeholder' => '',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'icon_loading',
            'parent'        => 'wishlist_settings[style]',
            'title'        => __('Loading icon', 'wishlist'),
            'details'    => __('Set custom loading icon. ex: <code>&lt;i class="fas fa-spinner fa-spin">&lt;/i></code>', 'wishlist'),
            'type'        => 'text',
            'value'        => $icon_loading,
            'default'        => '',
            'placeholder' => '',

        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'        => 'icon_menu',
            'parent'        => 'wishlist_settings[style]',
            'title'        => __('Menu icon', 'wishlist'),
            'details'    => __('Set custom menu toggle icon. ex: <code>&lt;i class="fas fa-spinner fa-spin">&lt;/i></code>', 'wishlist'),
            'type'        => 'text',
            'value'        => $icon_menu,
            'default'        => '',
            'placeholder' => '',

        );

        $settings_tabs_field->generate_field($args);






        $args = array(
            'id'        => 'font_size',
            'parent'        => 'wishlist_settings[style]',
            'title'        => __('Wishlist button font size', 'wishlist'),
            'details'    => __('Set wishlist button font size.', 'wishlist'),
            'type'        => 'text',
            'value'        => $font_size,
            'default'        => '12px',
            'placeholder'        => '12px',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'color_idle',
            'parent'        => 'wishlist_settings[style]',
            'title'        => __('Wishlist button color - Normal', 'wishlist'),
            'details'    => __('Choose custom color for wishlist button idle stat.', 'wishlist'),
            'type'        => 'colorpicker',
            'value'        => $color_idle,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'color_active',
            'parent'        => 'wishlist_settings[style]',
            'title'        => __('Wishlist button color - Active', 'wishlist'),
            'details'    => __('Choose custom color for wishlist button on active stat.', 'wishlist'),
            'type'        => 'colorpicker',
            'value'        => $color_active,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        ?>

    </div>

    <?php





}
















add_action('wishlist_settings_content_help_support', 'wishlist_settings_content_help_support');

if (!function_exists('wishlist_settings_content_help_support')) {
    function wishlist_settings_content_help_support($tab)
    {

        $settings_tabs_field = new settings_tabs_field();


    ?>
        <div class="section">
            <div class="section-title"><?php echo __('Get support', 'wishlist'); ?></div>
            <p class="description section-description"><?php echo __('Use following to get help and support from our expert team.', 'wishlist'); ?></p>

            <?php


            ob_start();
            ?>

            <p><?php echo __('Shortcode for php file', 'related-post'); ?></p>
            <textarea onclick="this.select()">&#60;?php echo do_shortcode( '&#91;wishlist_button id="123" obj_type="post" show_count="yes" show_menu="yes" icon_active="" icon_inactive="" icon_loading="" &#93;' ); ?&#62;</textarea>
            <p class="description"><?php echo __('Shortcode inside loop by dynamic post id you can use anywhere inside loop on .php files.', 'related-post'); ?></p>

            <p><?php echo __('Short-code for content', 'related-post'); ?></p>
            <textarea onclick="this.select()">[wishlist_button id="123" obj_type="post" show_count="yes" show_menu="yes" icon_active="" icon_inactive="" icon_loading=""]</textarea>

            <h3>Parameters:</h3>
            <ul>
                <li><code>id</code>: integer or url</li>
                <li><code>obj_type</code>: post, term, author, url</li>
                <li><code>show_count</code>: yes , no</li>
                <li><code>show_menu</code>: yes , no</li>
                <li><code>icon_active</code>: string(html) - Font awesome icons html</li>
                <li><code>icon_inactive</code>: string(html) - Font awesome icons html</li>
                <li><code>icon_loading</code>: string(html) - Font awesome icons html</li>
                <li><code>icon_menu</code>: string(html) - Font awesome icons html</li>

            </ul>


            <p class="description"><?php echo __('Short-code inside content for fixed post id you can use anywhere inside content.', 'related-post'); ?></p>
            <?php

            $html = ob_get_clean();

            $args = array(
                'id'        => 'shortcodes',
                'parent'        => 'related_post_settings',
                'title'        => __('Shortcodes', 'related-post'),
                'details'    => '',
                'type'        => 'custom_html',
                'html'        => $html,

            );

            $settings_tabs_field->generate_field($args);

            ob_start();
            ?>

            <p><?php echo __('Ask question for free on our forum and get quick reply from our expert team members.', 'wishlist'); ?></p>
            <a class="button" target="_blank" href="https://www.pickplugins.com/create-support-ticket/"><?php echo __('Create support ticket', 'post-grid'); ?></a>

            <p><?php echo __('Read our documentation before asking your question.', 'post-grid'); ?></p>
            <a class="button" target="_blank" href="https://www.pickplugins.com/documentation/wishlist/"><?php echo __('Documentation', 'post-grid'); ?></a>

            <p><?php echo __('Watch video tutorials.', 'post-grid'); ?></p>
            <a class="button" target="_blank" href="https://www.youtube.com/playlist?list=PL0QP7T2SN94ZGK1xL5QtEDHlR6Flk9iDH"><i class="fab fa-youtube"></i> <?php echo __('All tutorials', 'post-grid'); ?></a>





            <?php

            $html = ob_get_clean();

            $args = array(
                'id'        => 'get_support',
                //'parent'		=> '',
                'title'        => __('Ask question', 'post-grid'),
                'details'    => '',
                'type'        => 'custom_html',
                'html'        => $html,

            );

            $settings_tabs_field->generate_field($args);


            ob_start();
            ?>

            <p class="">We wish your 2 minutes to write your feedback about the <b>Post Grid</b> plugin. give us <span style="color: #ffae19"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>

            <a target="_blank" href="https://wordpress.org/support/plugin/wishlist/reviews/#new-post" class="button"><i class="fab fa-wordpress"></i> Write a review</a>


            <?php

            $html = ob_get_clean();

            $args = array(
                'id'        => 'reviews',
                //'parent'		=> '',
                'title'        => __('Submit reviews', 'post-grid'),
                'details'    => '',
                'type'        => 'custom_html',
                'html'        => $html,

            );

            $settings_tabs_field->generate_field($args);



            ?>


        </div>
    <?php


    }
}






add_action('wishlist_settings_content_buy_pro', 'wishlist_settings_content_buy_pro');

if (!function_exists('wishlist_settings_content_buy_pro')) {
    function wishlist_settings_content_buy_pro($tab)
    {

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
            <a class="button" href="https://www.pickplugins.com/demo/wishlist/?ref=dashobard"><?php echo __('See all demo', 'post-grid'); ?></a>

            <h2><?php echo __('See the differences', 'post-grid'); ?></h2>

            <table class="pro-features">
                <thead>
                    <tr>
                        <th class="col-features"><?php echo __('Features', 'post-grid'); ?></th>
                        <th class="col-free"><?php echo __('Free', 'post-grid'); ?></th>
                        <th class="col-pro"><?php echo __('Premium', 'post-grid'); ?></th>
                    </tr>
                </thead>


                <tr>
                    <td class="col-features"><?php echo __('Any post type support', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Category, tags, custom taxonomy support', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Date, month, year pages support', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Author pages support', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Home, search, 404 pages support', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Custom link support', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>



                <tr>
                    <td class="col-features"><?php echo __('Ready WooCommerce', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Unlimited wishlist by any user', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Public or private wishlist', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('User can edit wishlist', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('User can delete wishlist', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Default wishlist id', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>


                <tr>
                    <td class="col-features"><?php echo __('Wishlist archive page', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Breadcrumb on wishlist page', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>




                <tr>
                    <td class="col-features"><?php echo __('Wishlist view count', 'post-grid'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Wishlist thumb up & down vote', 'post-grid'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Social share on wishlist', 'post-grid'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Copy to duplicate others user wishlist', 'post-grid'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Auto Sync offiline wishlists', 'post-grid'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>



                <tr>
                    <td class="col-features"><?php echo __('Total wishlisted count by post id', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Search wishlist', 'post-grid'); ?> </td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>


                <tr>
                    <td class="col-features"><?php echo __('Wishlist button font size', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Wishlist button custom color', 'post-grid'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <th class="col-features"><?php echo __('Features', 'post-grid'); ?></th>
                    <th class="col-free"><?php echo __('Free', 'post-grid'); ?></th>
                    <th class="col-pro"><?php echo __('Premium', 'post-grid'); ?></th>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Buy now', 'post-grid'); ?></td>
                    <td> </td>
                    <td><a class="button" href="https://www.pickplugins.com/item/woocommerce-wishlist/?ref=dashobard"><?php echo __('Buy premium', 'post-grid'); ?></a></td>
                </tr>

            </table>



            <?php

            $html = ob_get_clean();

            $args = array(
                'id'        => 'get_pro',
                'title'        => __('Get pro version', 'post-grid'),
                'details'    => '',
                'type'        => 'custom_html',
                'html'        => $html,

            );

            $settings_tabs_field->generate_field($args);


            ?>


        </div>

        <style type="text/css">
            .pro-features {
                margin: 30px 0;
                border-collapse: collapse;
                border: 1px solid #ddd;
            }

            .pro-features th {
                width: 120px;
                background: #ddd;
                padding: 10px;
            }

            .pro-features tr {}

            .pro-features td {
                border-bottom: 1px solid #ddd;
                padding: 10px 10px;
                text-align: center;
            }

            .pro-features .col-features {
                width: 230px;
                text-align: left;
            }

            .pro-features .col-free {}

            .pro-features .col-pro {}

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

function wishlist_settings_save()
{

    $wishlist_settings = isset($_POST['wishlist_settings']) ?  wishlist_recursive_sanitize_arr($_POST['wishlist_settings']) : array();
    update_option('wishlist_settings', $wishlist_settings);
}
