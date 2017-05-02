<?php get_header();?>
<div class="content-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 blog-content">
				<div class="blog-post page">
					<div class="post-content">
					<h2><?php _e('404 Error: not found!','swh')?></h2>
					<p><?php _e('It seems we can not find what you are looking for. Perhaps searching can help.','swh')?></p>
					<?php 
	             		$tag_cloud = array(
						    'smallest'                  => 8, 
						    'largest'                   => 22,
						    'unit'                      => 'pt', 
						    'number'                    => 45,  
						    'format'                    => 'flat',
						    'separator'                 => ' ',
						    'orderby'                   => 'name', 
						    'order'                     => 'ASC',
						    'exclude'                   => null, 
						    'include'                   => null, 
						    'link'                      => 'view', 
							'taxonomy'  => array('post_tag'), 
						    'echo'                      => true
						);       	
		             	wp_tag_cloud($tag_cloud);
		             ?>
		             </div>
	             </div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>