<?php get_header();?>
<?php
global $sweethome;
$layout = isset( $sweethome['blog_layout'] ) ? $sweethome['blog_layout'] : 'right';
?>
<div class="content-section">
	<div class="container">
		<div class="row">
			<?php if( $layout == 'left' ):?>
				<?php get_sidebar();?>
			<?php endif;?>
			<div class="col-md-8 blog-content">
				<?php
					global $wp_query;
					if( have_posts() ) :
						$postnum = 0;
						while ( have_posts() ) :
							the_post();
							$postnum++;
							get_template_part('content', null);
							if ( !is_single() && $postnum < $wp_query->query_vars['posts_per_page']) :
								print '<div class="post-divider"></div>';
							endif;
						endwhile;
					else:
						?><h3><?php _e('Nothing Found.','swh');?></h3><?php
					endif;
				?>
			</div>
			<?php get_sidebar();?>
		</div>
		<?php swh_content_nav();?>
	</div>
</div>
<?php get_footer();?>
