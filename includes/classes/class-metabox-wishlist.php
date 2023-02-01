<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

class class_wishlist_metabox{
	
	public function __construct(){

		//meta box action for "wishlist"
		add_action('add_meta_boxes', array($this, 'wishlist_post_meta_wishlist'));
		add_action('save_post', array($this, 'meta_boxes_wishlist_save'), 99);



		}


	public function wishlist_post_meta_wishlist($post_type){

            add_meta_box('metabox-wishlist',__('Wishlist Options', 'woocommerce-products-slider'), array($this, 'meta_box_wishlist_data'), 'wishlist', 'normal', 'high');


		}



	public function meta_box_wishlist_data($post) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field('wishlist_nonce_check', 'wishlist_nonce_check_value');
 
        // Use get_post_meta to retrieve an existing value from the database.
       // $wishlist_data = get_post_meta($post -> ID, 'wishlist_data', true);

        $post_id = $post->ID;



        $settings_tabs_field = new settings_tabs_field();

        $wishlist_options = get_post_meta($post_id,'wishlist_options', true);
        $current_tab = isset($wishlist_options['current_tab']) ? $wishlist_options['current_tab'] : 'options';


        $wishlist_settings_tab = array();

        $wishlist_settings_tabs[] = array(
            'id' => 'options',
            'title' => sprintf(__('%s options','woocommerce-products-slider'),'<i class="fas fa-laptop-code"></i>'),
            'priority' => 1,
            'active' => ($current_tab == 'options') ? true : false,
        );


        $wishlist_settings_tabs = apply_filters('wishlist_metabox_navs', $wishlist_settings_tabs);

        $tabs_sorted = array();

        if(!empty($wishlist_settings_tabs))
        foreach ($wishlist_settings_tabs as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
        array_multisort($tabs_sorted, SORT_ASC, $wishlist_settings_tabs);



        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style('wp-color-picker');

        wp_enqueue_style( 'jquery-ui');
        wp_enqueue_style( 'font-awesome-5' );
        wp_enqueue_style( 'settings-tabs' );
        wp_enqueue_script( 'settings-tabs' );


		?>
        <script>
            jQuery(document).ready(function($){
                $(document).on('click', '.settings-tabs input[name="wishlist_options[slider_for]"]', function(){
                    var val = $(this).val();

                    console.log( val );

                    $('.settings-tabs .tab-navs li').each(function( index ) {
                        data_visible = $( this ).attr('data_visible');

                        if(typeof data_visible != 'undefined'){
                            //console.log('undefined '+ data_visible );

                            n = data_visible.indexOf(val);
                            if(n<0){
                                $( this ).hide();
                            }else{
                                $( this ).show();
                            }
                        }else{
                            console.log('Not matched: '+ data_visible );


                        }
                    });


                })
            })


        </script>

        <div class="settings-tabs vertical">
           
            

            <ul class="tab-navs">
                <?php
                foreach ($wishlist_settings_tabs as $tab){
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];
                    $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                    $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                    ?>
                    <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden';?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>"><?php echo $title; ?></li>
                    <?php
                }
                ?>
            </ul>
            <?php
            foreach ($wishlist_settings_tabs as $tab){
                $id = $tab['id'];
                $title = $tab['title'];
                $active = $tab['active'];
                ?>

                <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                    <?php
                    do_action('wishlist_metabox_content_'.$id, $post_id);
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="clear clearfix"></div>

        <?php


   		}




	public function meta_boxes_wishlist_save($post_id){

        /*
         * We need to verify this came from the our screen and with
         * proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if (!isset($_POST['wishlist_nonce_check_value']))
            return $post_id;

        $nonce = sanitize_text_field($_POST['wishlist_nonce_check_value']);

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'wishlist_nonce_check'))
            return $post_id;

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {

            if (!current_user_can('edit_page', $post_id))
                return $post_id;

        } else {

            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        /* OK, its safe for us to save the data now. */

        do_action('wishlist_metabox_save', $post_id);


					
		}
	
	}


new class_wishlist_metabox();