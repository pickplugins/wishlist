<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



?>


<!-- Tags -->

<?php $wishlist_tags = wp_get_post_terms( get_the_id(), 'wishlist_tags' ) ?>

<?php if( ! is_wp_error( $wishlist_tags ) && !empty( $wishlist_tags ) ) :  ?>

    <div class="wishlist-tags"><?php echo __('Tags:', 'wishlist'); ?>
		<?php foreach( wp_get_post_terms( get_the_id(), 'wishlist_tags' ) as $tag ) : ?>
            <a href="#" class="wishlist-tag"><?php echo $tag->name; ?> (<?php echo $tag->count; ?>), </a>
		<?php endforeach; ?>
    </div>

<?php endif; ?>

<!-- Tags End -->