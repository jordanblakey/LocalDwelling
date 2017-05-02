<?php
/**
 * Template Name: Homepage
 */
get_header();?>
	<?php if( have_posts() ) : the_post();?>
		<?php the_content();?>
	<?php endif;?>
<?php get_footer();?>