<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$pickplugins_wl_wishlist_page = get_option( 'pickplugins_wl_wishlist_page' );

$home_text = get_option( 'pickplugins_wl_breadcrumb_home_text' );
$home_text = empty( $home_text ) ? __('Home', 'wishlist') : $home_text;
$home_text = apply_filters( 'wishlist_bredcrumb_home_text', $home_text );

$breadcrumb_enable =  get_option( 'pickplugins_wl_breadcrumb_enable' );

?>

<!-- Bredcrumb -->

<?php if( $breadcrumb_enable == 'yes' ) : ?>

    <div class="wishlist-breadcrumb">
        <a class="breadcrumb-item" href="<?php echo get_bloginfo('url'); ?>"><i class="fa fa-home"></i> <?php echo $home_text; ?></a>
        <span class="breadcrumb-separator"><i class="fa fa-long-arrow-right"></i> </span>
        <a class="breadcrumb-item" href="<?php echo get_permalink($pickplugins_wl_wishlist_page); ?>"><?php echo get_the_title($pickplugins_wl_wishlist_page); ?></a>
        <span class="breadcrumb-separator"><i class="fa fa-long-arrow-right"></i> </span>
        <a class="breadcrumb-item" href="#"><?php echo get_the_title(); ?></a>
    </div>

	<?php $breadcrumb_text_color = get_option( 'pickplugins_wl_breadcrumb_text_color' ); ?>
	<?php echo ! empty( $breadcrumb_text_color ) ? "<style>.wishlist-breadcrumb a{ color: {$breadcrumb_text_color} !important; }</style>" : ""; ?>

<?php endif; ?>

<!-- Bredcrumb End -->








