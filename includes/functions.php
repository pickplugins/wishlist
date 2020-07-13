<?php


if ( ! defined('ABSPATH')) exit;  // if direct access 



add_action('the_content', 'wishlist_display_on_content');

function wishlist_display_on_content($content){

    $wishlist_settings = get_option('wishlist_settings');

    $post_types_display = isset($wishlist_settings['post_types_display']) ? $wishlist_settings['post_types_display'] : array();

    global $post;
    $posttype = isset($post->post_type) ? $post->post_type : '';
    $enable = isset($post_types_display[$posttype]['enable']) ? $post_types_display[$posttype]['enable'] : 'no';

    if($enable == 'yes'){

        $content_position = isset($post_types_display[$posttype]['content_position']) ? $post_types_display[$posttype]['content_position'] : 'none';
        $show_count = isset($post_types_display[$posttype]['show_count']) ? $post_types_display[$posttype]['show_count'] : 'yes';
        $show_menu = isset($post_types_display[$posttype]['show_menu']) ? $post_types_display[$posttype]['show_menu'] : 'yes';
        $html = '';

        if($content_position == 'before'){

            $html .= do_shortcode('[wishlist_button id="'.get_the_id().'"]');
            $html .= $content;

        }elseif ($content_position == 'after'){

            $html .= $content;
            $html .= do_shortcode('[wishlist_button id="'.get_the_id().'"]');

        }else{

            $html .= $content;

        }

        return $html;

    }else{
        return $content;
    }

    //var_dump($post_types_display);

}




add_action('the_excerpt', 'wishlist_display_on_excerpt');

function wishlist_display_on_excerpt($excerpt){

    $wishlist_settings = get_option('wishlist_settings');

    $post_types_display = isset($wishlist_settings['post_types_display']) ? $wishlist_settings['post_types_display'] : array();

    global $post;
    $posttype = isset($post->post_type) ? $post->post_type : '';
    $enable = isset($post_types_display[$posttype]['enable']) ? $post_types_display[$posttype]['enable'] : 'no';

    if($enable == 'yes'){

        $excerpt_position = isset($post_types_display[$posttype]['excerpt_position']) ? $post_types_display[$posttype]['excerpt_position'] : 'none';
        $show_count = isset($post_types_display[$posttype]['show_count']) ? $post_types_display[$posttype]['show_count'] : 'yes';
        $show_menu = isset($post_types_display[$posttype]['show_menu']) ? $post_types_display[$posttype]['show_menu'] : 'yes';
        $html = '';

        if($excerpt_position == 'before'){

            $html .= do_shortcode('[wishlist_button id="'.get_the_id().'" show_menu="'.$show_menu.'" show_count="'.$show_count.'"]');
            $html .= $excerpt;

        }elseif ($excerpt_position == 'after'){

            $html .= $excerpt;
            $html .= do_shortcode('[wishlist_button id="'.get_the_id().'" show_menu="'.$show_menu.'" show_count="'.$show_count.'"]');

        }else{

            $html .= $excerpt;

        }

        return $html;

    }else{
        return $excerpt;
    }

    //var_dump($post_types_display);

}
















// EDD Integration Start //
function pickplugins_wl_edd_download_after_price_function(){
	
	$item_id = get_the_ID();
	echo do_shortcode( "[wishlist_button id=$item_id]" );
}
add_action( 'edd_download_after_content', 'pickplugins_wl_edd_download_after_price_function' );

// EDD Integration End //

function pickplugins_wl_before_delete_wishlist_function( $wishlist_id ){
	
	global $wpdb;
	
	$ret = $wpdb->delete( $wpdb->prefix."pickplugins_wl_data", array( 'wishlist_id' => $wishlist_id ) );
}
add_action( 'delete_post', 'pickplugins_wl_before_delete_wishlist_function', 10, 1 );


function pickplugins_wl_get_social_platforms(){
	
	return apply_filters( 'pickplugins_wl_filter_social_platforms', array(
	
		'facebook' => array( 
			'title' => 'Facebook',
			'url' 	=> 'http://www.facebook.com/sharer.php?u=',
		),
		'google-plus' => array( 
			'title' => 'Google Plus',
			'url' 	=> 'https://plus.google.com/share?url=',
		),
		'twitter' => array( 
			'title' => 'Twiter',
			'url' 	=> 'https://twitter.com/intent/tweet/?url=',
		),
		'pinterest' => array( 
			'title' => 'Pinterest',
			'url' 	=> 'https://www.pinterest.com/pin/create/button/?url=',
		),
		'linkedin' => array( 
			'title' => 'Linkedin',
			'url' 	=> 'https://www.linkedin.com/shareArticle?mini=true&url=',
		),
		'reddit' => array( 
			'title' => 'Reddit',
			'url' 	=> 'http://www.reddit.com/submit/?url=',
		)
	) );
}

// 01723 31 38 99


/* Add Wishlist section using Shortcode on Single Post Archive*/
/* ===== === ===== */

function woocommerce_template_loop_product_wishlist( $item_id = 0 ){
	
	if( $item_id == 0 ) $item_id = get_the_ID();
	echo do_shortcode( "[wishlist_button id=$item_id show_count=yes]" );
}


function pickplugins_wl_show_wishlist_section(){
	
	/* Shop page settings */
	/* ===== === ===== */

    $wishlist_settings = get_option('wishlist_settings');

    $woocommerce = isset($wishlist_settings['woocommerce']) ? $wishlist_settings['woocommerce'] : array();
    $on_shop = isset($woocommerce['on_shop']) ? $woocommerce['on_shop'] : 'yes';
    $on_shop_position = isset($woocommerce['on_shop_position']) ? $woocommerce['on_shop_position'] : 'after_addtocart';

    $on_product = isset($woocommerce['on_product']) ? $woocommerce['on_product'] : 'yes';
    $on_product_position = isset($woocommerce['on_product_position']) ? $woocommerce['on_product_position'] : 'title';


	if( $on_shop != "no" ):
		
		if( $on_shop_position == 'before_addtocart' ) $priority = 5;
		else $priority = 15;	
		
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_wishlist', $priority );
		
	endif;
	
	/* Product single page settings */
	/* ===== === ===== */
	
	if( $on_product != "no" ):
			
		
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 12 );

		if( $on_product_position == 'title' ) $priority = 6;
		elseif( $on_product_position == 'ratings' ) $priority = 10;
		elseif( $on_product_position == 'price' ) $priority = 15;
		elseif( $on_product_position == 'excerpt' ) $priority = 20;
		elseif( $on_product_position == 'meta' ) $priority = 40;
		elseif( $on_product_position == 'add_to_cart' ) $priority = 30;
		elseif( $on_product_position == 'sharing' ) $priority = 50;
		else $priority = 15;	
		
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_loop_product_wishlist', $priority );
		
	endif;
	
	add_action( 'pickplugins_wl_loop_single_item_main', 'woocommerce_template_loop_product_wishlist', 12 );

}
add_action( 'init', 'pickplugins_wl_show_wishlist_section' );


function pickplugins_wl_wishlist_buttons_html(){


    ?>
    <div class='wishlist-create-wrap'>
        <div class='wishlist-create'>

            <h2 class='wishlist-create-title'><?php echo __('Create your wishlist', 'wishlist' ); ?></h2>

            <div>
                <input type='text' class='wishlist_name' placeholder='<?php echo __( 'Wishlist Name', 'wishlist' ); ?>'>
                <input type='hidden' class='item_id' value=''>
            </div>

            <div class='wl-button wishlist-create-cancel'><?php echo __( 'Cancel', 'wishlist' ); ?></div>
            <div class='wl-button wishlist-create-save'><?php echo __( 'Create Wishlist', 'wishlist' ); ?></div>

        </div>
    </div>
    <?php
	
}
//add_action( 'wp_footer', 'pickplugins_wl_wishlist_buttons_html' );





/* Custom Functions */
/* ===== *** ===== */
function pickplugins_wl_add_to_wishlist( $wishlist_id = 0, $item_id = 0 ){
	
	if( $wishlist_id == 0 || $item_id == 0 || get_current_user_id() == 0 ) return false;
	
	if( in_array( $wishlist_id, pickplugins_wl_is_wishlisted( $item_id ) ) ) return false;
	
	global $wpdb;
	
	return $wpdb->insert( $wpdb->prefix . 'pickplugins_wl_data',  
		array( 
			'wishlist_id' => $wishlist_id, 
			'post_id' => $item_id,
			'user_id' => get_current_user_id(),
			'datetime' => current_time('mysql'),
		)
	);
}


function pickplugins_wl_remove_from_wishlist( $wishlist_id = 0, $item_id = 0 ){
	
	if( $wishlist_id == 0 || $item_id == 0 || get_current_user_id() == 0 ) return false;
	
	global $wpdb;
	
	return $wpdb->delete( $wpdb->prefix . 'pickplugins_wl_data', 
		array( 
			'wishlist_id' => $wishlist_id,
			'post_id' => $item_id,
			'user_id' => get_current_user_id(),
		) 
	);
}

function pickplugins_wl_is_wishlisted( $item_id = 0 ){
	
	$current_user_id = get_current_user_id();
	if( $item_id == 0 || $current_user_id == 0 ) return false;
	
	global $wpdb;
	
	$results = $wpdb->get_results("
		SELECT 	wishlist_id
		FROM 	{$wpdb->prefix}pickplugins_wl_data
		WHERE	post_id = $item_id AND user_id = $current_user_id
	");
	
	$wishlist_array = array();
	foreach( $results as $result ) array_push( $wishlist_array, $result->wishlist_id );
	
	
	return $wishlist_array;
	// echo "<pre>"; print_r( $wishlist_array ); echo "</pre>";
}

function pickplugins_wl_get_wishlisted_items( $wishlist_id = 0, $item_per_page = -1, $paged = 1, $show_all_users = false ){
	
	$current_user_id = get_current_user_id();
	if( $wishlist_id == 0 ) return false;
	
	$wishlist_status = get_post_meta( $wishlist_id, 'wishlist_status', true );
	if( empty( $wishlist_status ) ) $wishlist_status = "public";

	if( is_user_logged_in() ){

		if( get_option('pickplugins_wl_default_wishlist_id') == $wishlist_id ) {
			$query_append = "AND user_id = $current_user_id";
		}
		else {
			$query_append = $wishlist_status == 'private' ? "AND user_id = $current_user_id" : "";
		}
	}
	else {
		$query_append = "";
	}
	
	if( $show_all_users ) $query_append = "";
		
	global $wpdb;
	
	if( $item_per_page != -1 ) {
		
		$OFFSET 	= ($paged - 1) * $item_per_page;
		$query		= "SELECT * FROM {$wpdb->prefix}pickplugins_wl_data WHERE wishlist_id = $wishlist_id $query_append GROUP BY post_id ORDER BY id DESC LIMIT $item_per_page OFFSET $OFFSET";
		$results 	= $wpdb->get_results( $query );
		
		return $results;
	}

	$results = $wpdb->get_results("
		SELECT 	*
		FROM 	{$wpdb->prefix}pickplugins_wl_data
		WHERE	wishlist_id = $wishlist_id $query_append
		GROUP BY post_id
	");

	return $results;
	// echo "<pre>"; print_r( $results ); echo "</pre>";
}

function pickplugins_wl_get_wishlist_count( $item_id = 0 ){
	
	if( $item_id == 0 ) return 0;
	global $wpdb;
	return $wpdb->get_var("
		SELECT 	COUNT(*)
		FROM 	{$wpdb->prefix}pickplugins_wl_data
		WHERE	post_id = $item_id
	");
}

function pickplugins_wl_get_all_status(){

	return apply_filters( 'pickplugins_wl_filters_all_status', array(
		'public' => __('Public - Show to everyone', 'wishlist'),
		'private' => __('Private - Show only to you', 'wishlist'),
	) );
}


function pickplugins_wl_get_views( $wishlist_id = 0 ){
	
	if( $wishlist_id == 0 ) return;
	
	$pickplugins_wl_views = get_post_meta( $wishlist_id, 'pickplugins_wl_views', true );
	if( empty( $pickplugins_wl_views ) ) $pickplugins_wl_views = 0;
	
	return $pickplugins_wl_views;
}

function pickplugins_wl_get_votes_count( $wishlist_id = 0 ){
	
	
	$vote_count = array( 'vote_up' => 0, 'vote_down' => 0 );
	
	if( $wishlist_id == 0 ) return $vote_count;

	$pickplugins_wl_votes = get_post_meta( $wishlist_id, 'pickplugins_wl_votes', true );
	if( empty( $pickplugins_wl_votes ) ) $pickplugins_wl_votes = array();
	
	foreach( $pickplugins_wl_votes as $user_id => $vote ):
	
		if( isset( $vote['action'] ) && $vote['action'] == 'vote_up' ) $vote_count['vote_up'] += 1;
		if( isset( $vote['action'] ) && $vote['action'] == 'vote_down' ) $vote_count['vote_down'] += 1;
	
	endforeach;
	
	return $vote_count;
}

function pickplugins_wl_get_single_wishlist_html( $wishlist_id = 0 ){


	$wishlist_url = get_permalink( $wishlist_id );

	if( $wishlist_id == 0 ) return "";
	
	$html = "";

    $wishlist_settings = get_option('wishlist_settings');
    $archive_page_id = isset($wishlist_settings['archives']['page_id']) ? $wishlist_settings['archives']['page_id'] : '';
    $default_wishlist_id = isset($wishlist_settings['default_wishlist_id']) ? $wishlist_settings['default_wishlist_id'] : '';



	$wishlist_page_url 	= ! empty( $archive_page_id ) ? get_the_permalink( $archive_page_id ) : get_home_url();
	
	$wishlisted_items 	= pickplugins_wl_get_wishlisted_items( $wishlist_id );
	$total_items		= count( $wishlisted_items );
	$item_url 			= basename( get_permalink( $wishlist_id ) );	
	$item_slug 			= basename( parse_url($item_url, PHP_URL_PATH) );
	$first_item 		= reset( $wishlisted_items );	
	$bg_image_url		= isset( $first_item->post_id ) ? get_the_post_thumbnail_url( $first_item->post_id ) : "";
	
	$wishlist_status	= get_post_meta( get_the_ID(), 'wishlist_status', true );
	$status_hint_text	= $wishlist_status == 'private' ? __('Private List', 'wishlist') : __('Public List', 'wishlist');
	$status_class		= $wishlist_status == 'private' ? 'fa-lock' : 'fa-unlock-alt';
	
	$html .= "<div class='single_wishlist'>";

	//$html .= "<a href='$wishlist_page_url?list=$item_slug' class='single_wishlist_inside'>";
	$html .= "<a href='$wishlist_url' class='single_wishlist_inside'>";

	if( $total_items > 0 ) $html .= "<span class='single_wishlist_img' style='background-image:url($bg_image_url);'></span>";
	else $html .= "<span class='single_wishlist_img'><i class='fa fa-heart' aria-hidden='true'></i></span>";

    $html .= sprintf("<h3>%s</h3>", get_the_title( $wishlist_id ) );
    $html .= sprintf("<small>%s : %s</small>", __('Items', 'wishlist'), $total_items );
	$html .= sprintf("<span class='hint--top' aria-label='%s'><span class='fa %s'></span></span>", $status_hint_text, $status_class );
	$html .= sprintf("<span class='createdby hint--top' aria-label='%s'><i class='fa fa-user'></i> <span>%s</span></span>",
			__('Created by', 'wishlist'), get_the_author_meta( 'display_name' ) );
	
	$html .= "</a></div>";
	
	return $html;
}

function pickplugins_wl_update_post_status_function( $post_id, $post, $update ) {

	if ( wp_is_post_revision( $post_id ) || $post->post_type != "wishlist" ) return;

	update_post_meta( $post_id, 'wishlist_status', 'public' );
}
add_action( 'wp_insert_post', 'pickplugins_wl_update_post_status_function', 10, 3 );




function pickplugins_wl_get_wishlist_pages(){

    $pages_array = array( '' => __( 'Select Page', 'woo-wishlist' ) );

    foreach( get_pages() as $page ):
        $pages_array[ $page->ID ] = $page->post_title;
    endforeach;

    return $pages_array;
}












