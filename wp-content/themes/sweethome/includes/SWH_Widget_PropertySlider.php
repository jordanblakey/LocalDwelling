<?php
if( !defined('ABSPATH') ) exit;
if( !function_exists('SWH_Widget_PropertySlider') ){
	function SWH_Widget_PropertySlider() {
		register_widget('SWH_Widget_PropertySlider_Class');
	}
	add_action('widgets_init', 'SWH_Widget_PropertySlider');
}
class SWH_Widget_PropertySlider_Class extends WP_Widget{
	var $post_type = 'property';
	
	function __construct(){
		$widget_ops = array( 'classname' => 'swh-propertslider-widget', 'description' => __('SWH Property Slider', 'swh') );
	
		parent::__construct( 'swh-propertslider-widget' , __('SWH Property Slider', 'swh') , $widget_ops);
	}	
	
	function widget($args, $instance){
		extract( $args );
		$html = null;
		$title = apply_filters('widget_title', isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : null );
		$show = (int)$instance['shows'] ? absint( $instance['shows'] ) : 3;
		$featured = isset( $instance['featured'] ) ? 1 : 0;
		$large_image = isset( $instance['large_image'] ) ? esc_attr( $instance['large_image'] ) : null;
		$taxonomies = get_object_taxonomies( $this->post_type );
		if( !is_front_page() )
			return;
		$query_array = array(
			'post_type'	=>	'property',
			'post_status'	=>	'publish',
			'showposts'	=>	$show,
			'orderby'	=>	'title',
			'order'		=>	'DESC'
		);
		if( $featured == 1 ){
			$query_array['meta_query'] = array(
				array(
					'key'=>'featured',
					'value'=> 1,
					'compare'=>'='
				)
			);			
		}
		if( $large_image ){
			$query_array['meta_query'] = array(
				'key'=>'large_image',
				'value'=> '',
				'compare'=>'!='
			);
		}
		if( !empty( $taxonomies ) ){
			for ( $i = 0;  $i < count( $taxonomies );  $i++){
				if( !empty( $instance[ $taxonomies[$i] ] ) || $instance[ $taxonomies[$i] ] != 0 ){
					$query_array['tax_query'] = array(
						array(
							'taxonomy' => $taxonomies[$i],
							'field' => 'id',
							'terms' => $instance[ $taxonomies[$i] ]
						)
					);					
				}
			}		
		}
		$query_array	=	apply_filters( 'swh-propertslider-widget/args' , $query_array);
		wp_reset_postdata();wp_reset_query();
		$wp_query = new WP_Query( $query_array );
		if( $wp_query->have_posts() ) :
		?>
			<div class="main-flexslider">
				<ul class="slides">
					<?php
					while ( $wp_query->have_posts() ) : $wp_query->the_post();
					$sqft = get_post_meta( get_the_ID(), 'sq_ft', true );
					$bathrooms = get_post_meta(get_the_ID(), 'bathrooms', true);
					$bedrooms = get_post_meta( get_the_ID() , 'bedrooms', true );
					$garages = get_post_meta( get_the_ID() , 'garages',true );
					$large_image_id = get_post_meta( get_the_ID(), 'large_image',true ) ? get_post_meta( get_the_ID(), 'large_image',true ) : null;
					?>
						<li class="slides" id="slide-n<?php the_ID();?>">
							<?php
								if($large_image_id){
									print wp_get_attachment_image( $large_image_id, 'property-thumbnail-1920-638' );
								}
							?>
							<div class="slide-box">
								<h2><?php the_title();?></h2>
								<?php 
									$post_content = get_post( get_the_ID() );
									print '<p>'. wp_trim_words($post_content->post_content, 40, '...') .'</p>';
								?>
								<ul class="slide-item-features">
									<?php if( $sqft ):?>
										<li><span class="fa fa-arrows-alt"></span><?php print $sqft;?> <?php _e('Sq Ft','swh');?></li>
									<?php endif;?>
									<?php if( $bathrooms ):?>
										<li><span class="fa fa-male"></span><?php print $bathrooms;;?> <?php _e(' Bathrooms','swh');?></li>
									<?php endif;?>
									<?php if( $bedrooms ):?>
										<li><span class="fa fa-inbox"></span><?php print $bedrooms;?> <?php _e('Bedrooms','swh');?></li>
									<?php endif;?>
									<?php if( $garages ):?>
										<li><span class="fa fa-truck"></span><?php print $garages;?> <?php _e('Garages','swh');?></li>
									<?php endif;?>
								</ul>
								<div class="slider-buttons-wrapper">
									<a href="<?php the_permalink();?>" class="yellow-btn"><?php print swh_get_property_price( get_the_ID() );?></a>
									<a href="<?php the_permalink();?>" class="gray-btn"><span class="fa fa-file-text-o"></span><?php _e('Details','swh');?></a>
								</div>
							</div>
						</li>
					<?php endwhile;?>
				</ul>
			</div>
		<?php 
		endif;
		wp_reset_postdata();wp_reset_query();
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['shows'] = (int)$new_instance['shows'];
		$instance['featured'] = $new_instance['featured'];
		$instance['large_image'] = $new_instance['large_image'];
		$taxonomies = get_object_taxonomies( $this->post_type );
		if( !empty( $taxonomies ) ){
			for ( $i = 0;  $i < count( $taxonomies );  $i++){
				$taxonomy = get_taxonomy( $taxonomies[$i] );
				$instance[$taxonomies[$i]] = $new_instance[$taxonomies[$i]];
			}
		}		
		
		return $instance;
		
	}
	function form( $instance ){
		$defaults = array(
			'featured' => 'on',
			'large_image'	=>	'on'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$taxonomies = get_object_taxonomies( $this->post_type );
		?>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'featured' ); ?>"><?php _e('Featured:', 'swh'); ?></label>
			    <input type="checkbox" <?php checked('on', $instance['featured'], true);?> id="<?php echo $this->get_field_id( 'featured' ); ?>" name="<?php echo $this->get_field_name( 'featured' ); ?>"/>
			    <small><?php _e('Only display the Featured property.','swh');?></small>
			</p>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'large_image' ); ?>"><?php _e('Large Image:', 'swh'); ?></label>
			    <input type="checkbox" <?php checked('on', $instance['large_image'], true);?> id="<?php echo $this->get_field_id( 'large_image' ); ?>" name="<?php echo $this->get_field_name( 'large_image' ); ?>"/>
			    <small><?php _e('Only display the Large image Property.','swh');?></small>
			</p>
			<?php if( !empty( $taxonomies ) ):
				for ( $i = 0;  $i < count( $taxonomies );  $i++) :
					$taxonomy = get_taxonomy( $taxonomies[$i] );
			?>	
			<p>  
			    <label for="<?php echo $this->get_field_id( $taxonomies[$i] ); ?>"><?php print $taxonomy->labels->name ?></label>
			    	<?php 
			    		if( $taxonomy->hierarchical == 1 ):
							wp_dropdown_categories($args = array(
									'show_option_all'    => 'All',
									'orderby'            => 'ID', 
									'order'              => 'ASC',
									'show_count'         => 1,
									'hide_empty'         => 0,
									'echo'               => 1,
									'selected'           => isset( $instance[ $taxonomies[$i] ] ) ? $instance[ $taxonomies[$i] ] : null,
									'hierarchical'       => 0, 
									'name'               => $this->get_field_name( $taxonomies[$i] ),
									'id'                 => $this->get_field_id( $taxonomies[$i] ),
									'taxonomy'           => $taxonomies[$i],
									'hide_if_empty'      => true,
									'class'              => 'postform swh-dropdown swh-' . $taxonomies[$i],
					    		)
				    		);
			    		else:
			    		?>
			    			<input id="<?php echo $this->get_field_id( $taxonomies[$i] ); ?>" name="<?php echo $this->get_field_name( $taxonomies[$i] ); ?>" value="<?php echo !empty( $instance[$taxonomies[$i]] ) ? $instance[$taxonomies[$i]] : NULL; ?>" style="width:100%;" />
    						<small><?php printf( __('Put the "%s" ID, separated by the common(,)','swh') , $taxonomy->labels->name );?></small>
    					<?php 			    		
			    		endif;
			    	?>
			</p>
				<?php endfor;?>
			<?php endif;?>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'shows' ); ?>"><?php _e('Shows:', 'swh'); ?></label>
			    <input id="<?php echo $this->get_field_id( 'shows' ); ?>" name="<?php echo $this->get_field_name( 'shows' ); ?>" value="<?php echo (isset( $instance['shows'] )) ? (int)$instance['shows'] : 3; ?>" style="width:100%;" />
			</p>			
		<?php 
	}	
}