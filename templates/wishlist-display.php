<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$current_user_id = get_current_user_id();

if( isset( $_GET['list'] ) ) {
    
	$wishlist_post = get_posts( array(
		'post_type'      => 'wishlist',
		'posts_per_page' => 1,
		'post_name__in'  => array( sanitize_text_field($_GET['list']) )
	) );

	echo do_shortcode( "[wishlist_single id='{$wishlist_post[0]->ID}']" );


	return;
}


if ( get_query_var('paged') ) { $paged = get_query_var('paged');} 
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); } 
else { $paged = 1; }
	
$pickplugins_wl_list_per_page = get_option( 'pickplugins_wl_list_per_page' );
if( empty( $pickplugins_wl_list_per_page ) ) $pickplugins_wl_list_per_page = 10;

$pickplugins_wl_default_wishlist_id = get_option( 'pickplugins_wl_default_wishlist_id' );
$pickplugins_wl_wishlist_page 		= get_option( 'pickplugins_wl_wishlist_page' );

if( empty( $pickplugins_wl_wishlist_page ) ) $pickplugins_wl_wishlist_page = get_the_ID();
	
?>

<div class="pickplugins_wl_wishlist_display pick">
	
	
	<!-- User login Check -->
	
	<?php if( ! is_user_logged_in() ) { ?>
	<p class='pick_notice pick_error'>You must <a href="<?php echo wp_login_url( get_permalink() ); ?>">Logged</a> in to see Wishlists</p> </div>
	<?php return; } ?>
	
	<!-- User login Check End-->
	

	
	<!-- Default Wishlist -->
	
	<?php 
	$wishlisted_items 	= pickplugins_wl_get_wishlisted_items( $pickplugins_wl_default_wishlist_id );
	$total_items		= count( $wishlisted_items );
	$item_url 			= basename( get_permalink( $pickplugins_wl_default_wishlist_id ) );	
	$item_slug 			= basename( parse_url($item_url, PHP_URL_PATH) );
	$first_item 		= reset( $wishlisted_items );	
	?>
	<div class='single_wishlist'>
		<a href="<?php echo get_the_permalink( $pickplugins_wl_wishlist_page )."?list=$item_slug"; ?>" class="single_wishlist_inside">
			
			<?php if( $total_items > 0 ) {  ?>
			<span class="single_wishlist_img" style="background-image: url('<?php echo get_the_post_thumbnail_url($first_item->post_id);?>');"></span>
			<?php } else { ?>
			<span class="single_wishlist_img dashicons dashicons-heart"></span>
			<?php } ?>
			
			<h3><?php echo get_the_title( $pickplugins_wl_default_wishlist_id ); ?></h3>
			<small><?php echo __('Total Items', 'woo-wishlist') .": $total_items"; ?></small>
        </a>
	</div>
	
	<!-- Default Wishlist END -->
	
	
	
	<!-- Wishlist Query -->
	
	<?php 
	$Wishlist_Query = new WP_Query( array (
		'post_type' 	=> 'wishlist',
		'post_status' 	=> array( 'publish' ),
		'author' 		=> $current_user_id,
        'post__not_in' 	=> array( $pickplugins_wl_default_wishlist_id ),
		'posts_per_page'=> $pickplugins_wl_list_per_page,
		'paged' 		=> $paged,
	) );
	?>
	
	<?php if ( $Wishlist_Query->have_posts() ) : while ( $Wishlist_Query->have_posts() ) : $Wishlist_Query->the_post(); ?>
			
	<?php 
	$wishlisted_items 	= pickplugins_wl_get_wishlisted_items( get_the_ID() );
	$total_items		= count( $wishlisted_items );
	$item_url 			= basename( get_permalink() );	
	$item_slug 			= basename( parse_url($item_url, PHP_URL_PATH) );
	$first_item 		= reset( $wishlisted_items );	
	?>
	
	<div class='single_wishlist'>
		<a href="<?php echo get_the_permalink( $pickplugins_wl_wishlist_page )."?list=$item_slug"; ?>" class="single_wishlist_inside">

			<?php if( $total_items > 0 ) { ?>
			<span class="single_wishlist_img" style="background-image:url('<?php echo get_the_post_thumbnail_url($first_item->post_id);?>');"></span>
			<?php } else { ?>
			<span class="single_wishlist_img dashicons dashicons-heart"></span>
			<?php } ?>
			
            <h3><?php echo get_the_title(); ?></h3>
            <small><?php echo __('Total Items', 'woo-wishlist') .": $total_items"; ?></small>
        </a>
	</div>
		
	<?php endwhile; ?>
	
	<?php $big = 999999999;
	$paginate = array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, $paged ),
		'total' => $Wishlist_Query->max_num_pages
	);
	?>
	<div class="paginate"> <?php echo paginate_links($paginate); ?> </div>
	<?php wp_reset_query(); endif; ?>
	
	<!-- End of Wishlist Query -->
	
	
	
</div>