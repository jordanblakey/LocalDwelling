<?php if( !defined('ABSPATH') ) exit; ?>
	<div class="col-md-4 listing-single-item">
		<div class="item-inner">
			<?php
				if( has_post_thumbnail() ){
					$property_type = wp_get_post_terms( get_the_ID() , 'ptype', array("fields" => "all"));
					$property_icon = get_option('taxonomy_' . $property_type[0]->term_id);
					$property_class_icon = !empty( $property_icon['swh_css_class'] ) ? $property_icon['swh_css_class'] : 'fa-home';
					$featured = get_post_meta( get_the_ID(), 'featured',true ) ? true : false;
					print '<div class="image-wrapper">';
						print '<a href="'.get_permalink( get_the_ID() ).'">'.get_the_post_thumbnail( get_the_ID(),'property-thumbnail-370-270' ) . '</a>';
						if( !empty( $property_type ) ):
							print '<a href="'.get_term_link( $property_type[0]->term_id, 'ptype' ).'" class="fa '.$property_class_icon.' property-type-icon"></a>';
						endif;
						if( $featured ){
							$property_link = !get_option('permalink_structure') ? get_post_type_archive_link('property') . '&featured=1' : get_post_type_archive_link('property') . '?featured=1';
							print '<a href="'.$property_link.'" class="featured"><i class="fa fa-star"></i>'.__('featured','swh').'</a>';
						}
					print '</div>';
				}
			?>
			<div class="desc-box">
				<?php
					$sqft = get_post_meta( get_the_ID(), 'sq_ft', true );
					$bathrooms = get_post_meta(get_the_ID(), 'bathrooms', true);
					$bedrooms = get_post_meta( get_the_ID() , 'bedrooms', true );
				?>
				<h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
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
					</ul>
				<div class="buttons-wrapper">
					<?php if( swh_get_property_price(get_the_ID()) != SWH_NA ):?>
							<a href="<?php the_permalink();?>" class="yellow-btn"><?php print swh_get_property_price( get_the_ID() );?></a>
					<?php endif;?>
					<a href="<?php the_permalink();?>" class="gray-btn"><span class="fa fa-file-text-o"></span><?php _e('Details','swh');?></a>
				</div>
				<div class="clearfix">
				</div>
			</div>
		</div>
	</div>
