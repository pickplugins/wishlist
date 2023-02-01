<?php


if (!defined('ABSPATH')) exit;  // if direct access 



/* Wishlist Copy */
/* ===== === ===== */

function pickplugins_wl_ajax_offline_wishlist_items()
{

	$items	= isset($_POST['items']) ? wishlist_recursive_sanitize_arr($_POST['items']) : "";

	$response = [];


	error_log(serialize($items));

	foreach ($items as $item) {

		$objType = isset($item['objType']) ? $item['objType'] : '';
		$objId = isset($item['objId']) ? $item['objId'] : '';
		$wishlistId = isset($item['wishlistId']) ? $item['wishlistId'] : '';

		$response[$objId]['title'] = get_the_title($objId);
		$response[$objId]['thumb'] = get_the_post_thumbnail_url($objId);
	}



	echo json_encode($response);


	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_offline_wishlist_items', 'pickplugins_wl_ajax_offline_wishlist_items');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_offline_wishlist_items', 'pickplugins_wl_ajax_offline_wishlist_items');


/* Wishlist Copy */
/* ===== === ===== */

function pickplugins_wl_ajax_wishlist_copy()
{

	$wishlist_id = isset($_POST['wishlist_id']) ? sanitize_text_field($_POST['wishlist_id']) : "";

	if (empty($wishlist_id) || !is_user_logged_in()) die();

	$nepickplugins_wl_wishlist_ID = wp_insert_post(array(
		'post_title' 	=>  get_the_title($wishlist_id),
		'post_name' 	=> sanitize_title(get_the_title($wishlist_id)),
		'post_type' 	=> 'wishlist',
		'post_status' 	=> 'publish',
		'author' 		=> get_current_user_id(),
	));

	update_post_meta($nepickplugins_wl_wishlist_ID, 'wishlist_status', 'public');

	$wishlisted_items = pickplugins_wl_get_wishlisted_items($wishlist_id);

	foreach ($wishlisted_items as $item) {

		pickplugins_wl_add_to_wishlist($nepickplugins_wl_wishlist_ID, $item->post_id, 'post');
	}

	$wishlist_settings = get_option('wishlist_settings');
	$archive_page_id = isset($wishlist_settings['archives']['page_id']) ? $wishlist_settings['archives']['page_id'] : '';


	$item_url		= basename(get_permalink($nepickplugins_wl_wishlist_ID));
	$item_slug		= basename(parse_url($item_url, PHP_URL_PATH));

	if (!empty($archive_page_id)) $single_url = get_the_permalink($nepickplugins_wl_wishlist_ID);
	else $single_url = $archive_page_id;

	echo $single_url;

	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_wishlist_copy', 'pickplugins_wl_ajax_wishlist_copy');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_wishlist_copy', 'pickplugins_wl_ajax_wishlist_copy');



/* Update Wishlist Vote */
/* ===== === ===== */

function pickplugins_wl_ajax_update_vote()
{

	$wishlist_id	= isset($_POST['wishlist_id']) ? sanitize_text_field($_POST['wishlist_id']) : "";
	$vote_type		= isset($_POST['vote_type']) ? sanitize_text_field($_POST['vote_type']) : "";

	if (empty($wishlist_id) || empty($vote_type) || !is_user_logged_in()) die();

	$pickplugins_wl_votes = get_post_meta($wishlist_id, 'pickplugins_wl_votes', true);
	if (empty($pickplugins_wl_votes)) $pickplugins_wl_votes = array();


	$pickplugins_wl_votes[get_current_user_id()]['action'] = $vote_type;
	update_post_meta($wishlist_id, 'pickplugins_wl_votes', $pickplugins_wl_votes);


	$vote_count = pickplugins_wl_get_votes_count($wishlist_id);

	echo json_encode($vote_count);

	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_update_vote', 'pickplugins_wl_ajax_update_vote');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_update_vote', 'pickplugins_wl_ajax_update_vote');




/* Update pickplugins_wl_ajax_sync_local_saved */
/* ===== === ===== */

function pickplugins_wl_ajax_sync_local_saved()
{

	$items	= isset($_POST['items']) ? wishlist_recursive_sanitize_arr($_POST['items']) : "";

	$response = [];


	error_log(serialize($items));

	foreach ($items as $item) {

		$objType = isset($item['objType']) ? $item['objType'] : '';
		$objId = isset($item['objId']) ? $item['objId'] : '';
		$wishlistId = isset($item['wishlistId']) ? $item['wishlistId'] : '';

		pickplugins_wl_add_to_wishlist($wishlistId, $objId, $objType);

		$response[$objId] = '';
	}



	echo json_encode($response);

	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_sync_local_saved', 'pickplugins_wl_ajax_sync_local_saved');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_sync_local_saved', 'pickplugins_wl_ajax_sync_local_saved');




/* Update Wishlist from Popup */
/* ===== === ===== */

function pickplugins_wl_ajax_update_wishlist()
{

	$pickplugins_wl_action	= isset($_POST['pickplugins_wl_action']) ? sanitize_text_field($_POST['pickplugins_wl_action']) : "";
	$wishlist_id			= isset($_POST['wishlist_id']) ? sanitize_text_field($_POST['wishlist_id']) : "";
	$wishlist_title			= isset($_POST['wishlist_title']) ? sanitize_text_field($_POST['wishlist_title']) : "";
	$wishlist_sd			= isset($_POST['wishlist_sd']) ? sanitize_text_field($_POST['wishlist_sd']) : "";
	$wishlist_status		= isset($_POST['wishlist_status']) ? sanitize_text_field($_POST['wishlist_status']) : "public";

	$wishlist_settings = get_option('wishlist_settings');
	$archive_page_id = isset($wishlist_settings['archives']['page_id']) ? $wishlist_settings['archives']['page_id'] : '';

	$wishlist_post_data = get_post($wishlist_id);
	$wishlist_author_id = $wishlist_post_data->post_author;

	$current_user_id = get_current_user_id();


	if ($wishlist_author_id != $current_user_id) {
		return;
		die();
	}

	if ($pickplugins_wl_action === "delete") {

		wp_delete_post($wishlist_id, true);

		echo get_the_permalink($archive_page_id);
		die();
	}

	if ($pickplugins_wl_action === "update") {


		$ret = wp_update_post(array(
			'ID'           	=> $wishlist_id,
			'post_title'   	=> $wishlist_title,
			'post_name'		=> sanitize_title($wishlist_title),
			'post_content' 	=> $wishlist_sd,
		));

		update_post_meta($wishlist_id, 'wishlist_status', $wishlist_status);

		$item_url		= basename(get_permalink($wishlist_id));
		$item_slug		= basename(parse_url($item_url, PHP_URL_PATH));

		//if( ! empty( $wishlist_page ) ) $single_url = get_the_permalink( $wishlist_page ) . "?list=$item_slug";

		//else $single_url = get_the_permalink( $wishlist_id );

		$single_url = get_the_permalink($wishlist_id);

		echo $single_url;

		die();
	}


	echo "<li class='menu_item add_new'><i class='fa fa-plus'></i> " . __('Add New', 'wishlist') . "</li>";
?>
	<li class='menu_item create'>
		<div class='wishlist-create-wrap'>
			<div class='wishlist-create'>

				<h2 class='wishlist-create-title'><?php echo __('Create your wishlist', 'wishlist'); ?></h2>


				<input type='text' class='wishlist_name' placeholder='<?php echo __('Wishlist Name', 'wishlist'); ?>' />
				<input type='hidden' class='item_id' value='' />

				<label for="makePrivate"> <input type='checkbox' id="makePrivate" class='item_id' value='' /> <?php echo __('Make Private', 'wishlist'); ?>
				</label>

				<div class='wl-button wishlist-create-cancel'><?php echo __('Cancel', 'wishlist'); ?></div>
				<div class='wl-button wishlist-create-save'><?php echo __('Create Wishlist', 'wishlist'); ?></div>

			</div>
		</div>
	</li>
<?php


	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_update_wishlist', 'pickplugins_wl_ajax_update_wishlist');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_update_wishlist', 'pickplugins_wl_ajax_update_wishlist');




/* Update Wishlist from Popup */
/* ===== === ===== */

function pickplugins_wl_ajax_remove_wishlist_item()
{


	$response = [];


	$pickplugins_wl_action	= isset($_POST['pickplugins_wl_action']) ? sanitize_text_field($_POST['pickplugins_wl_action']) : "";
	$wishlist_id			= isset($_POST['wishlist_id']) ? sanitize_text_field($_POST['wishlist_id']) : "";
	$item_id			= isset($_POST['item_id']) ? sanitize_text_field($_POST['item_id']) : "";

	$wishlist_title			= isset($_POST['wishlist_title']) ? sanitize_text_field($_POST['wishlist_title']) : "";
	$wishlist_sd			= isset($_POST['wishlist_sd']) ? sanitize_text_field($_POST['wishlist_sd']) : "";
	$wishlist_status		= isset($_POST['wishlist_status']) ? sanitize_text_field($_POST['wishlist_status']) : "public";

	$wishlist_settings = get_option('wishlist_settings');
	$archive_page_id = isset($wishlist_settings['archives']['page_id']) ? $wishlist_settings['archives']['page_id'] : '';

	$wishlist_post_data = get_post($wishlist_id);
	$wishlist_author_id = $wishlist_post_data->post_author;

	$current_user_id = get_current_user_id();


	if ($wishlist_author_id != $current_user_id) {
		return;
		die();
	}


	pickplugins_wl_remove_from_wishlist($wishlist_id, $item_id);
	$response['removed'] = true;

	echo json_encode($response);


	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_remove_wishlist_item', 'pickplugins_wl_ajax_remove_wishlist_item');
//add_action('wp_ajax_nopriv_pickplugins_wl_ajax_update_wishlist', 'pickplugins_wl_ajax_remove_wishlist_item');	








/* Load Menu Items on Hover */
/* ===== === ===== */

function pickplugins_wl_ajax_get_wishlist_menu_items()
{

	$wishlist_settings = get_option('wishlist_settings');

	$default_wishlist_id = isset($wishlist_settings['default_wishlist_id']) ? $wishlist_settings['default_wishlist_id'] : '';

	$item_id 	 		= isset($_POST['item_id']) ? sanitize_text_field($_POST['item_id']) : 0;
	$current_user_id 	= get_current_user_id();
	$wishlisted_array 	= pickplugins_wl_is_wishlisted($item_id);

	$total_items 		= " (" . count(pickplugins_wl_get_wishlisted_items($default_wishlist_id, -1, 1, false)) . ")";

	if (!empty($default_wishlist_id) && in_array($default_wishlist_id, $wishlisted_array))
		echo "<li class='menu_item menu_item-{$default_wishlist_id} wishlist_saved' wishlist='$default_wishlist_id'><i class='fa fa-heart' aria-hidden='true'></i> " . get_the_title($default_wishlist_id) . " <span class='counter'>$total_items</spam></li>";
	else echo "<li class='menu_item menu_item-{$default_wishlist_id}' wishlist='$default_wishlist_id'><i class='fa fa-heart' aria-hidden='true'></i> " . get_the_title($default_wishlist_id) . " <span class='counter'>$total_items</spam></li>";

	$wishlist_array = get_posts(array(
		'post_type' => 'wishlist',
		'author' => $current_user_id,
		'post__not_in' => array($default_wishlist_id),
		'posts_per_page' => -1,
	));

	foreach ($wishlist_array as $list) :

		$total_items = " (" . count(pickplugins_wl_get_wishlisted_items($list->ID, -1, 1, true)) . ")";

		if ($wishlisted_array && in_array($list->ID, $wishlisted_array))
			echo "<li class='menu_item menu_item-{$list->ID} wishlist_saved' wishlist='{$list->ID}'><i class='fa fa-heart' aria-hidden='true'></i> {$list->post_title} <span class='counter'>$total_items</spam></li>";
		else echo "<li class='menu_item menu_item-{$list->ID}' wishlist='{$list->ID}'><i class='fa fa-heart' aria-hidden='true'></i> {$list->post_title} <span class='counter'>$total_items</spam></li>";

	endforeach;

	echo "<li class='menu_item add_new'><i class='fa fa-plus'></i> " . __('Add New', 'wishlist') . "</li>";
?>
	<li class='menu_item create'>
		<div class='wishlist-create-wrap'>
			<div class='wishlist-create'>

				<input type='text' class='wishlist_name' placeholder='<?php echo __('Wishlist Name', 'wishlist'); ?>'>
				<input type='hidden' class='item_id' value=''>
				<label for=""><input type='checkbox' class='make_private' value='1'> <?php echo __('Make Private', 'wishlist'); ?></label>
				<br>
				<div class='wl-button wishlist-create-cancel'><?php echo __('Cancel', 'wishlist'); ?></div>
				<div class='wl-button wishlist-create-save'><?php echo __('Create Wishlist', 'wishlist'); ?></div>


			</div>
		</div>
	</li>
<?php



	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_get_wishlist_menu_items', 'pickplugins_wl_ajax_get_wishlist_menu_items');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_get_wishlist_menu_items', 'pickplugins_wl_ajax_get_wishlist_menu_items');


function pickplugins_wl_ajax_add_remove_item_on_wishlist()
{
	$response = array();

	$pickplugins_wl_action = isset($_POST['pickplugins_wl_action']) ? sanitize_text_field($_POST['pickplugins_wl_action']) : "";
	$item_id = isset($_POST['item_id']) ? sanitize_text_field($_POST['item_id']) : "";
	$wishlist_id = isset($_POST['wishlist_id']) ? sanitize_text_field($_POST['wishlist_id']) : "";
	$obj_type = isset($_POST['obj_type']) ? sanitize_text_field($_POST['obj_type']) : "post";


	//error_log($obj_type);

	if (empty($pickplugins_wl_action) || empty($item_id) || !is_user_logged_in()) die();

	if (empty($wishlist_id)) $wishlist_id = get_option('pickplugins_wl_default_wishlist_id');

	if ($pickplugins_wl_action == "remove_from_wishlist") {

		//echo pickplugins_wl_remove_from_wishlist( $wishlist_id, $item_id ) ? "removed" : "not";
		pickplugins_wl_remove_from_wishlist($wishlist_id, $item_id);

		$response['status'] = 'removed';
		//die();
	}

	if ($pickplugins_wl_action == "add_in_wishlist") {

		//echo pickplugins_wl_add_to_wishlist( $wishlist_id, $item_id ) ? "added" : "";
		pickplugins_wl_add_to_wishlist($wishlist_id, $item_id, $obj_type);

		$response['status'] = 'added';
		//die();
	}

	$response['count'] = do_shortcode("[wishlist_count_by_post id='" . $item_id . "']");

	$total_items = count(pickplugins_wl_get_wishlisted_items($wishlist_id, -1, 1, false));
	$response['total_count'] = $total_items;


	echo json_encode($response);

	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_add_remove_item_on_wishlist', 'pickplugins_wl_ajax_add_remove_item_on_wishlist');
//add_action('wp_ajax_nopriv_pickplugins_wl_ajax_add_remove_item_on_wishlist', 'pickplugins_wl_ajax_add_remove_item_on_wishlist');


function pickplugins_wl_ajax_create_save_wishlist()
{

	$responses = array();

	$wishlist_name 	= isset($_POST['wishlist_name']) ? sanitize_text_field($_POST['wishlist_name']) : "";
	$item_id 	= isset($_POST['item_id']) ? sanitize_text_field($_POST['item_id']) : "";
	$is_private 	= isset($_POST['is_private']) ? sanitize_text_field($_POST['is_private']) : "";


	$isPrivate = ($is_private=='true') ? 'private' : 'public';




	if (is_user_logged_in()) {

		$wishlist_ID = wp_insert_post(array(
			'post_title' 	=> $wishlist_name,
			'post_type' 	=> 'wishlist',
			'post_status' 	=> 'publish',
			'author' 		=> get_current_user_id(),
		));

		update_post_meta($wishlist_ID, 'wishlist_status', $isPrivate);
		pickplugins_wl_add_to_wishlist($wishlist_ID, $item_id, 'post');

		$responses['wishlist_id'] = $wishlist_ID;
	}



	echo json_encode($responses);

	die();
}
add_action('wp_ajax_pickplugins_wl_ajax_create_save_wishlist', 'pickplugins_wl_ajax_create_save_wishlist');
add_action('wp_ajax_nopriv_pickplugins_wl_ajax_create_save_wishlist', 'pickplugins_wl_ajax_create_save_wishlist');
