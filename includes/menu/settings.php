<?php	
if ( ! defined('ABSPATH')) exit;  // if direct access


$current_tab = isset($_REQUEST['tab']) ? sanitize_text_field($_REQUEST['tab']) : 'general';

$wishlist_settings_tab = array();

$wishlist_settings_tab[] = array(
    'id' => 'general',
    'title' => sprintf(__('%s General','wishlist'),'<i class="fas fa-cogs"></i>'),
    'priority' => 5,
    'active' => ($current_tab == 'general') ? true : false,
);


$wishlist_settings_tab[] = array(
    'id' => 'archives',
    'title' => sprintf(__('%s Archives','wishlist'),'<i class="far fa-list-alt"></i>'),
    'priority' => 10,
    'active' => ($current_tab == 'archives') ? true : false,
);

$wishlist_settings_tab[] = array(
    'id' => 'my_wishlist',
    'title' => sprintf(__('%s My wishlist\'s','wishlist'),'<i class="fas fa-clipboard-list"></i>'),
    'priority' => 15,
    'active' => ($current_tab == 'my_wishlist') ? true : false,
);

$wishlist_settings_tab[] = array(
    'id' => 'wishlist_page',
    'title' => sprintf(__('%s Wishlist page','wishlist'),'<i class="far fa-heart"></i>'),
    'priority' => 20,
    'active' => ($current_tab == 'wishlist_page') ? true : false,
);



$wishlist_settings_tab[] = array(
    'id' => 'style',
    'title' => sprintf(__('%s Button Style','wishlist'),'<i class="fas fa-palette"></i>'),
    'priority' => 25,
    'active' => ($current_tab == 'woo') ? true : false,
);



$wishlist_settings_tab[] = array(
    'id' => 'help_support',
    'title' => sprintf(__('%s Help & support','wishlist'),'<i class="far fa-question-circle"></i>'),
    'priority' => 90,
    'active' => ($current_tab == 'help_support') ? true : false,
);



$wishlist_settings_tab[] = array(
    'id' => 'buy_pro',
    'title' => sprintf(__('%s Buy Pro','wishlist'),'<i class="fas fa-hands-helping"></i>'),
    'priority' => 95,
    'active' => ($current_tab == 'buy_pro') ? true : false,
);







$wishlist_settings_tab = apply_filters('wishlist_settings_tabs', $wishlist_settings_tab);

$tabs_sorted = array();

if(!empty($wishlist_settings_tab))
foreach ($wishlist_settings_tab as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
array_multisort($tabs_sorted, SORT_ASC, $wishlist_settings_tab);

//delete_option('wishlist_settings');

$wishlist_settings = get_option('wishlist_settings');


//var_dump($wishlist_settings);

?>
<div class="wrap">
	<div id="icon-tools" class="icon32"><br></div><h2><?php echo sprintf(__('%s Settings', 'wishlist'), wishlist_plugin_name)?></h2>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', esc_url_raw($_SERVER['REQUEST_URI'])); ?>">
	        <input type="hidden" name="wishlist_hidden" value="Y">
            <input type="hidden" name="tab" value="<?php echo $current_tab; ?>">
            <?php
            if(!empty($_POST['wishlist_hidden'])){
                $nonce = sanitize_text_field($_POST['_wpnonce']);
                if(wp_verify_nonce( $nonce, 'wishlist_nonce' ) && $_POST['wishlist_hidden'] == 'Y') {
                    do_action('wishlist_settings_save');
                    ?>
                    <div class="updated notice  is-dismissible"><p><strong><?php _e('Changes Saved.', 'wishlist' ); ?></strong></p></div>
                    <?php
                }
            }
            ?>
            <div class="settings-tabs-loading" style="">Loading...</div>
            <div class="settings-tabs vertical has-right-panel" style="display: none">
                <div class="settings-tabs-right-panel">
                    <?php
                    if(!empty($wishlist_settings_tab))
                    foreach ($wishlist_settings_tab as $tab) {
                        $id = $tab['id'];
                        $active = $tab['active'];
                        ?>
                        <div class="right-panel-content <?php if($active) echo 'active';?> right-panel-content-<?php echo $id; ?>">
                            <?php
                            do_action('wishlist_settings_tabs_right_panel_'.$id);
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <ul class="tab-navs">
                    <?php
                    if(!empty($wishlist_settings_tab))
                    foreach ($wishlist_settings_tab as $tab){
                        $id = $tab['id'];
                        $title = $tab['title'];
                        $active = $tab['active'];
                        $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                        $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                        $is_pro = isset($tab['is_pro']) ? $tab['is_pro'] : false;
                        $pro_text = isset($tab['pro_text']) ? $tab['pro_text'] : '';
                        ?>
                        <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden';?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>">
                            <?php echo $title; ?>
                            <?php
                            if($is_pro):
                                ?><span class="pro-feature"><?php echo $pro_text; ?></span> <?php
                            endif;
                            ?>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
                if(!empty($wishlist_settings_tab))
                foreach ($wishlist_settings_tab as $tab){
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];
                    ?>
                    <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                        <?php
                        do_action('wishlist_settings_content_'.$id, $tab);
                        ?>
                    </div>
                    <?php
                }
                ?>
                <div class="clear clearfix"></div>
                <p class="submit">
                    <?php wp_nonce_field( 'wishlist_nonce' ); ?>
                    <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes','wishlist' ); ?>" />
                </p>
            </div>
		</form>
</div>