<div class="col-md-4 blog-sidebar">
	<?php if( (function_exists('is_woocommerce') && is_woocommerce()) || ( function_exists('is_shop') && is_shop() ) ):?>
		<?php dynamic_sidebar('swh-right-sidebar-post');?>
	<?php elseif( is_single() || !is_page()):?>
		<?php dynamic_sidebar('swh-right-sidebar-' . get_post_type());?>
	<?php else:?>
		<?php dynamic_sidebar('swh-right-sidebar-post');?>
	<?php endif;?>
</div>