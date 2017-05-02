<?php get_header();?>
<div class="content-section">
	<div class="container">
		<div class="row">
			<div class="col-md-8 blog-content wrapper-woocommerce">
				<div <?php post_class('page blog-post post-content');?>>
					<?php 
						if ( have_posts() ) :
							woocommerce_content();
						endif;
					?>
				</div>
				<div class="clearfix"></div>
			</div>
			<?php get_sidebar();?>
		</div>
	</div>
</div>
<?php get_footer();?>