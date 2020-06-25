<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

/*
 *  Override single wishlist template
 *  return $content;
 *
 * */

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










add_action('wishlist_single_main','wishlist_single_title_display');
add_action('wishlist_single_main','wishlist_bredcrumb_display');
add_action('wishlist_single_main','wishlist_content_display');
add_action('wishlist_single_main','wishlist_tags_display');
add_action('wishlist_single_main','wishlist_editing_display');
add_action('wishlist_single_main','wishlist_meta_display');
add_action('wishlist_single_main','wishlist_delete_form_display');
add_action('wishlist_single_main','wishlist_edit_form_display');
add_action('wishlist_single_main','wishlist_items_display');










function wishlist_single_title_display(){

	include (wishlist_plugin_dir.'templates/wishlist-single/title.php');
}

function wishlist_bredcrumb_display(){

    include (wishlist_plugin_dir.'templates/wishlist-single/breadcrumb.php');
}
function wishlist_content_display(){

	include (wishlist_plugin_dir.'templates/wishlist-single/content.php');
}


function wishlist_tags_display(){

	include (wishlist_plugin_dir.'templates/wishlist-single/tags.php');
}


function wishlist_editing_display(){

	include (wishlist_plugin_dir.'templates/wishlist-single/editing.php');
}


function wishlist_meta_display(){

	include (wishlist_plugin_dir.'templates/wishlist-single/meta.php');
}


function wishlist_delete_form_display(){

	include (wishlist_plugin_dir.'templates/wishlist-single/delete-form.php');
}

function wishlist_edit_form_display(){

	include (wishlist_plugin_dir.'templates/wishlist-single/edit-form.php');
}


function wishlist_items_display(){

	include (wishlist_plugin_dir.'templates/wishlist-single/items.php');
}












