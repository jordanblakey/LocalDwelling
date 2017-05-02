<?php
/**
 * Template Name: Page Contact
 */
get_header();?>
<!-- content-Section -->
<div class="content-section">
	<div class="container">
		<?php if( have_posts() ) : the_post();?>
			<?php the_content();?>
		<?php endif;?>
	</div>
</div>
<?php get_footer();?>
