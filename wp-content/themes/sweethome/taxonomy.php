<?php if( !defined('ABSPATH') ) exit; ?>
<?php get_header();?>
<div class="content-section">
	<div class="container">
		<div class="row listings-items-wrapper">
			<?php if(have_posts()) :?>
				<?php while (have_posts()):the_post();?>
					<?php get_template_part('content', get_post_type());?>
				<?php endwhile;?>
			<?php endif;?>
		</div>
		<?php swh_content_nav();?>
	</div>
</div>
<?php get_footer();?>
