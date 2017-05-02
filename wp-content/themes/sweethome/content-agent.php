<?php if( !defined('ABSPATH') ) exit; ?>
<?php 
if( is_archive( 'agent' ) ){
	$classes = 'col-sm-6 col-xs-12';
}
else{
	$classes = 'col-xs-12';
}

?>
<div <?php post_class('single-agent ' .$classes);?>>
	<div class="image-box">
		<?php 
			if( has_post_thumbnail() ){
				print get_the_post_thumbnail(NULL, 'agents-thumbnail-270-256');
			}
		?>
		<?php if( function_exists('have_rows') && have_rows('socials') ): ?>
			<ul class="social-icons">
				<?php while ( have_rows('socials') ) : the_row();?>
					<li><a href="<?php print get_sub_field('link');?>" class="fa <?php print get_sub_field('profile');?>"></a></li>
				<?php endwhile;?>
			</ul>
		<?php endif;?>
	</div>
	<div class="desc-box">
		<h4><?php print get_post_meta(get_the_ID(),'name',true);?></h4>
		<p class="person-number">
			<i class="fa fa-phone"></i> <?php print get_post_meta( get_the_ID(), 'phone', true ); ?>
		</p>
		<p class="person-email">
			<i class="fa fa-envelope"></i> <?php print get_post_meta( get_the_ID(), 'email', true ); ?>
		</p>
		<p class="person-fax">
			<i class="fa fa-print"></i> <?php print get_post_meta( get_the_ID(), 'fax', true ); ?>
		</p>
		<?php if( !is_singular('agent') ):?>
			<?php if( !get_post_meta(get_the_ID(),'external_profile',true) ):?>
				<a href="<?php print get_permalink( get_the_ID() );?>" class='gray-btn'><?php _e('View full profile','swh');?></a>
			<?php else:?>
				<a href="<?php print get_post_meta(get_the_ID(),'external_profile',true);?>" class='gray-btn'><?php _e('View full profile','swh');?></a>
			<?php endif;?>
		<?php else:?>
			<?php 
				$property_link = !get_option('permalink_structure') ? get_post_type_archive_link('property') . '&ofagent=' . get_the_ID() : get_post_type_archive_link('property') . '?ofagent=' . get_the_ID();
			?>
			<a href="<?php print $property_link;?>" class='gray-btn'><?php _e('View all property','swh');?></a>
		<?php endif;?>
	</div>
	<?php if( is_singular('agent') ):?>
		<div class="post-content">
			<?php the_content();?>
			<?php wp_link_pages(); ?>
		</div>
	<?php endif;?>
</div>