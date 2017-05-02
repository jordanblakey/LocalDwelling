<?php get_header();?>
<?php 
global $sweethome;
$layout = isset( $sweethome['blog_layout'] ) ? $sweethome['blog_layout'] : 'right'; 
?>
<!-- content-Section -->
<div class="content-section">
	<div class="container">
		<div class="row">
			<?php if( $layout == 'left' ):?>
				<?php get_sidebar();?>
			<?php endif;?>		
			<div class="col-md-8 blog-content">
				<?php 
					if ( have_posts() ) : the_post();
						get_template_part('content', get_post_format());
						swh_post_nav();
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
					endif;
				?>
				<div class="clearfix"></div>
			</div>
			<?php get_sidebar();?>
		</div>
	</div>
</div>
<?php get_footer();?>