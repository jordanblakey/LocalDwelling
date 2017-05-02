<?php get_header();?>
<!-- content-Section -->
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
						else{
							print '<div class="alert alert-warning">'.__('Comment is closed.','seh').'</div>';
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