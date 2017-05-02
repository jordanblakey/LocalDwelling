<?php if( !defined('ABSPATH') ) exit; ?>
<?php get_header();?>
	<?php the_post();?>
	<!-- content-Section -->
	<div class="content-section">
		<div class="container">
			<div class="row">
				<div class="col-md-8 page-content">
					<div class="inner-wrapper">
						<?php 
						$sqft = get_post_meta( get_the_ID(), 'sq_ft', true );
						$bathrooms = get_post_meta(get_the_ID(), 'bathrooms', true);
						$bedrooms = get_post_meta( get_the_ID() , 'bedrooms', true );		
						$status = wp_get_post_terms( get_the_ID() , 'status', array("fields" => "all"));
						$property_tag = wp_get_post_terms( get_the_ID() , 'property_tag', array("fields" => "all"));
						$location = get_post_meta(get_the_ID(),'location',true);
						$property_type = wp_get_post_terms( get_the_ID() , 'ptype', array("fields" => "all"));
						if( isset( $property_type[0]->term_id ) ){
							$property_icon = get_option('taxonomy_' . $property_type[0]->term_id );
						}
						
						$property_class_icon = !empty( $property_icon['swh_css_class'] ) ? $property_icon['swh_css_class'] : 'fa-home';
						?>
						<?php if( function_exists('have_rows') && have_rows('gallery') ): ?>
						<div class="property-images-slider">
							<div id="details-slider" class="flexslider">
								<?php if( !empty( $property_type ) ):?>
									<a href="<?php print get_term_link( $property_type[0]->term_id, 'ptype' );?>" class='fa <?php print $property_class_icon;?> property-type-icon'></a>
								<?php endif;?>
								<?php if( swh_get_property_price( get_the_ID() ) != SWH_NA ):?>
									<a href="#" class="yellow-btn"><?php print swh_get_property_price( get_the_ID() );?></a>
								<?php endif;?>
								<?php if( !empty( $status ) ):?>
									<a href="<?php print get_term_link( $status[0]->term_id,'status' );?>" class='status'><?php print $status[0]->name ? $status[0]->name : SWH_NA;?></a>
								<?php endif;?>
								<ul class="slides">
									<?php while ( have_rows('gallery', get_the_ID()) ) : the_row();?>
									<?php 
									$image = wp_get_attachment_image_src(get_sub_field('image'),'property-thumbnail-770-481');
									?>
									<li>
										<div class="image-wrapper">
											<img src="<?php print $image[0];?>" alt="gallery">
										</div>
									</li>
									<?php endwhile;?>
								</ul>
							</div>
							<div id="details-carousel" class="flexslider">
								<ul class="slides">
									<?php while ( have_rows('gallery') ) : the_row();?>
									<?php 
									$image = wp_get_attachment_image_src(get_sub_field('image'),'property-thumbnail-124-76');
									?>									
									<li><img alt="gallery" src="<?php print $image[0];?>"></li>
									<?php endwhile;?>
								</ul>
							</div>
						</div>
						<?php endif;?>
						<div class="property-desc">					
							<h3><?php the_title();?></h3>
							<ul class="slide-item-features item-features">
								<?php if( $sqft ):?>
									<li><span class="fa fa-arrows-alt"></span><?php print $sqft ? $sqft : 0;?> <?php _e('Sq Ft','swh');?></li>
								<?php endif;?>
								<?php if( $bathrooms ):?>
									<li><span class="fa fa-male"></span><?php print $bathrooms ? $bathrooms : 0;?> <?php _e(' Bathrooms','swh');?></li>
								<?php endif;?>
								<?php if( $bedrooms ):?>
									<li><span class="fa fa-inbox"></span><?php print $bedrooms ? $bedrooms : 0?> <?php _e('Bedrooms','swh');?></li>
								<?php endif;?>
								<?php if( get_post_meta( get_the_ID() , 'garages',true ) ):?>
									<li><span class="fa fa-truck"></span><?php print get_post_meta( get_the_ID() , 'garages',true );?> <?php _e('Garages','swh');?></li>
								<?php endif;?>
							</ul>
							<?php the_content();?>
							<?php if( !empty( $property_tag ) ):?>
							<div class="additional-features">
								<h3><?php _e('Additional Features','swh');?></h3>
								<ul class="features">
									<?php for ($i = 0; $i < count( $property_tag ); $i++) :?>
										<li class="single-feature"><a href="<?php print get_term_link( $property_tag[$i]->term_id,'property_tag' );?>"><i class="fa fa-check-circle"></i><?php print $property_tag[$i]->name;?></a></li>
									<?php endfor;?>
								</ul>
							</div>
							<?php endif;?>
							<?php if( !empty( $location['lat'] ) && !empty( $location['lng'] ) ):?>
								<div class="property-location">
									<h3><?php _e('Property Location','swh');?></h3>
									<?php 
										global $sweethome;
										if( ! empty( $sweethome['gmap_marker'] ) ){
											print '<div id="property-location-map" data-icon="'. esc_url( $sweethome['gmap_marker']['url'] ) .'"></div>';		
										}
										else{
											print '<div id="property-location-map" data-icon=""></div>';
										}
									?>
									
								</div>
								<script type="text/javascript">
									(function($) {
									  "use strict";
										$(document).ready(function(){
											initialize( <?php print $location['lat'];?>, <?php print $location['lng'];?>, 'property-location-map');
										})
									})(jQuery);
								</script>
							<?php endif;?>
						</div>
					</div>
					<?php 
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}					
					?>
				</div>
				<?php get_sidebar();?>
			</div>
		</div>
	</div>	
	
<?php get_footer();?>
