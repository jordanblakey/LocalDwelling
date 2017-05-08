<?php
/**
 * Template Name: Page Widgetized
 */
?>
<?php get_header();?>
<div class="content-section">
	<div class="container">
		<div class="row">
			<div class="col-md-8 blog-content">
				<?php
					if ( have_posts() ) : the_post();
						get_template_part('content', get_post_type());
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
					endif;
				?>
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("widgetized-page-top") ) : ?>
				<?php endif; ?>

				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("widgetized-page-bottom") ) : ?>
				<?php endif; ?>
				<div class="clearfix"></div>
			</div>
			<?php get_sidebar();?>
		</div>
	</div>
</div>
<?php get_footer();?>
