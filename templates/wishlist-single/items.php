<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$wishlist_id = get_the_id();

$pickplugins_wl_list_items_per_page = get_option( 'pickplugins_wl_list_items_per_page' );
if( empty( $pickplugins_wl_list_items_per_page ) ) $pickplugins_wl_list_items_per_page = 10;	

if ( get_query_var('paged') ) { $paged = get_query_var('paged');}
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }


?>




<!-- Items Query -->

<?php
$wishlisted_items 	= pickplugins_wl_get_wishlisted_items( $wishlist_id, $pickplugins_wl_list_items_per_page, $paged );
$total_items		= count( pickplugins_wl_get_wishlisted_items( $wishlist_id ) );

?>


<?php if ( $wishlisted_items && $total_items > 0  ) : ?>

    <p class='pick_notice pick_success'><?php echo sprintf( __("%s Item showing out of %s Items", 'wishlist' ), "<strong>".count($wishlisted_items)."</strong>", "<strong>$total_items</strong>" ); ?></p>

	<?php do_action( 'pickplugins_wl_before_loop_wishlist_items', $wishlist_id ); ?>

    <div class="wishlist-items">

		<?php foreach( $wishlisted_items as $item ) : do_action( 'pickplugins_wl_loop_single_item', $item->post_id, $wishlist_id ); endforeach; ?>

    </div>

	<?php do_action( 'pickplugins_wl_after_loop_wishlist_items', $wishlist_id ); ?>

	<?php $big = 999999999;
	$paginate = array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, $paged ),
		'total' => (int)ceil($total_items / $pickplugins_wl_list_items_per_page)
	);
	?>
    <div class="paginate"> <?php echo paginate_links($paginate); ?> </div>

<?php else : ?>

    <p class='pick_notice pick_warning'><?php echo __( 'Sorry, No items found !', 'wishlist' ); ?></p>

<?php endif; ?>

<!-- End of Items Query -->