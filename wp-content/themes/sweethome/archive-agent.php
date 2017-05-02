<?php if( !defined('ABSPATH') ) exit; ?>
<?php get_header(); ?>
<!-- content-Section -->
<div class="content-section">
	<div class="container">
		<div class="row">
		<?php 
			if( have_posts() ):
				while ( have_posts() ): the_post();
					get_template_part('content', get_post_type());
				endwhile;
			endif;
		?>
		</div>
		<?php swh_content_nav();?>	
	</div>
</div>

<?php get_footer();?>