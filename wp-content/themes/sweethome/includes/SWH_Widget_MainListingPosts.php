<?php
if( !defined('ABSPATH') ) exit;
if( !function_exists('SWH_Widget_MainListingPosts') ){
	function SWH_Widget_MainListingPosts() {
		register_widget('SWH_Widget_MainListingPosts_Class');
	}
	add_action('widgets_init', 'SWH_Widget_MainListingPosts');
}
class SWH_Widget_MainListingPosts_Class extends WP_Widget{
	
	function __construct(){
		$widget_ops = array( 'classname' => 'swh-widget-main-listing-posts', 'description' => __('Displays the Property listing on the homepage', 'swh') );
	
		parent::__construct( 'swh-widget-main-listing-posts' , __('SWH Main Property Listing', 'swh') , $widget_ops);
	}	

	function widget($args, $instance){
		extract( $args );
		$title = apply_filters('widget_title', esc_attr( $instance['title'] ) );
		$featured = ( $instance['featured'] =='on' ) ? 1 : 0;
		$orderby = isset( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : 'ID';
		$order = isset( $instance['order'] ) ? esc_attr( $instance['order'] ) : 'DESC';
		$limit = isset( $instance['limit'] ) ? absint( $instance['limit'] ) : 3;
		$element_class = isset( $instance['element_class'] ) ? esc_attr($instance['element_class']) : null;
		$margintop = isset( $instance['margin-top'] ) ? esc_attr($instance['margin-top']) : null;
		$marginbottom = isset( $instance['margin-bottom'] ) ? esc_attr($instance['margin-bottom']) : null;
		$post_type = 'property';
		$current_post = get_the_ID();
		$wp_array = array(
			'post_type'	=>	$post_type,
			'post_status'	=>	'publish',
			'showposts'	=>	$limit,
			'orderby'	=>	$orderby,
			'order'		=>	$order
		);
		
		if( $orderby == 'price' ){
			$wp_array['orderby']	=	'meta_value_num';
			$wp_array['meta_key']	=	'price';
		}
		
		$taxonomies = get_object_taxonomies( $post_type );
		if( !empty( $taxonomies ) ){
			for ( $i = 0;  $i < count( $taxonomies );  $i++) {
				$taxonomy = get_taxonomy( $taxonomies[$i] );
				$instance_tax = $instance[ $taxonomies[$i] ];
				if( $instance_tax ){
					$wp_array['tax_query'][] = array(
						'taxonomy' => $taxonomies[$i],
						'field' => 'id',
						'terms' => array((int)$instance_tax)
					);
				}
			}
		}
		if( $featured == 1 ){
			$wp_array['meta_query'] = array(
				array(
					'key'=>'featured',
					'value'=> 1,
					'compare'=>'='
				)
			);			
		}
		$inline_css = null;
		if( $margintop || $marginbottom ){
			$inline_css .= 'style="';
			if( $margintop ){
				$inline_css .= 'margin-top:' . $margintop . ';';
			}
			if( $marginbottom ){
				$inline_css .= 'margin-bottom:' . $marginbottom . ';';
			}
			$inline_css .= '"';
		}		
		
		wp_reset_postdata();wp_reset_query();
		$wp_query = new WP_Query( $wp_array );
		if( $wp_query->have_posts() ):
			?>
			<div <?php print $inline_css;?> class="recent-listings <?php print $element_class;?>">
				<div class="container">
				<?php if( $title ):?>
					<div class="title-box">
						<h3><?php print $title;?></h3>
						<div class="bordered"></div>
					</div>
				<?php endif;?>
				<div class="row listings-items-wrapper">
					<?php while ($wp_query->have_posts()):$wp_query->the_post();?>
						<?php get_template_part('content', get_post_type());?>
					<?php endwhile;?>
				</div>
				</div>
			</div>
			<?php 
		endif;
		wp_reset_postdata();wp_reset_query();
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['featured'] = isset( $new_instance['featured'] ) ? $new_instance['featured'] : null;
		$taxonomies = get_object_taxonomies( 'property' );
		if( !empty( $taxonomies ) ){
			for ( $i = 0;  $i < count( $taxonomies );  $i++) {
				$instance[ $taxonomies[$i] ] = $new_instance[ $taxonomies[$i] ];
			}
		}
		$instance['orderby'] = strip_tags($new_instance['orderby']);
		$instance['order'] = strip_tags($new_instance['order']);
		$instance['limit'] = absint( $new_instance['limit'] );
		$instance['margin-top'] = strip_tags($new_instance['margin-top']);
		$instance['margin-bottom'] = strip_tags($new_instance['margin-bottom']);
		$instance['element_class'] = strip_tags($new_instance['element_class']);
		return $instance;
	}
	function form( $instance ){
		$defaults = array(
			'title' => __('Recent Listings', 'swh'),
			'featured'	=>	'off',
			'order'	=>	'DESC',
			'orderby'	=>	'ID',
			'limit'	=>	3,
			'margin-top'	=>	null,
			'margin-bottom'	=>	null,
			'element_class'	=>	'recent-listings-' . rand(1000, 9999)
		);
		$taxonomies = get_object_taxonomies( 'property' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'swh'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo !empty( $instance['title'] ) ? strip_tags($instance['title']) : NULL; ?>" style="width:100%;" />
			</p>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'featured' ); ?>"><?php _e('Featured:', 'swh'); ?></label>
			    <input type="checkbox" <?php checked('on', $instance['featured'], true);?> id="<?php echo $this->get_field_id( 'featured' ); ?>" name="<?php echo $this->get_field_name( 'featured' ); ?>"/>
			    <small><?php _e('Only display the Featured property.','swh');?></small>
			</p>
			<?php 
			if( !empty( $taxonomies ) ){
				for ( $i = 0;  $i < count( $taxonomies );  $i++) {
					$taxonomy = get_taxonomy( $taxonomies[$i] );
					//print_r( $taxonomy->hierarchical );
					?>
						<p> 
						    <label for="<?php echo $this->get_field_id( 'popular_'.$taxonomies[$i] ); ?>"><?php print $taxonomy->labels->name;?></label>
						    <?php if( $taxonomy->hierarchical == 1 ):?>
					    	<?php 
								wp_dropdown_categories($args = array(
										'show_option_all'    => 'All',
										'orderby'            => 'ID', 
										'order'              => 'ASC',
										'show_count'         => 1,
										'hide_empty'         => 1, 
										'child_of'           => 0,
										'echo'               => 1,
										'selected'           => isset( $instance[$taxonomies[$i]] ) ? strip_tags($instance[$taxonomies[$i]]) : null,
										'hierarchical'       => 0, 
										'name'               => $this->get_field_name( $taxonomies[$i] ),
										'id'                 => $this->get_field_id( $taxonomies[$i] ),
										'taxonomy'           => $taxonomies[$i],
										'hide_if_empty'      => true,
										'class'              => 'regular-text sweethome-dropdown',
						    		)
					    		);
					    		else:
					    		?>
					    			<input id="<?php echo $this->get_field_id( 'popular_'.$taxonomies[$i] ); ?>" name="<?php echo $this->get_field_name( $taxonomies[$i] ); ?>" value="<?php echo !empty( $instance[$taxonomies[$i]] ) ? strip_tags($instance[$taxonomies[$i]]) : NULL; ?>" style="width:100%;" />
					    			<small><?php printf( __('Put the %s slug, separated by a common(,)','swh') , $taxonomy->labels->name );?></small>
					    		<?php 
					    		endif;					    		
					    	?>
						</p>
					<?php
				}
			}
			?>			
			
			<p>  
			    <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('Orderby:', 'swh'); ?></label>
			    <select style="width:100%;" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
			    	<?php 
			    		foreach ( swh_option_orderby() as $key=>$value ){
			    			$selected = ( $instance['orderby'] == $key ) ? 'selected' : null;
			    			?>
			    				<option <?php print $selected; ?> value="<?php print $key;?>"><?php print $value;?></option>
			    			<?php 
			    		}
			    	?>
			    </select>  
			</p>			
			<p>  
			    <label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e('Order:', 'swh'); ?></label>
			    <select style="width:100%;" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
			    	<?php 
			    		foreach ( swh_option_orders() as $key=>$value ){
			    			$selected = ( $instance['order'] == $key ) ? 'selected' : null;
			    			?>
			    				<option <?php print $selected; ?> value="<?php print $key;?>"><?php print $value;?></option>
			    			<?php 
			    		}
			    	?>
			    </select>  
			</p>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e('Limit:', 'swh'); ?></label>
			    <input id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo absint( $instance['limit'] );?>" style="width:100%;" />
			</p>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'element_class' ); ?>"><?php _e('Class:', 'swh'); ?></label>
			    <input id="<?php echo $this->get_field_id( 'element_class' ); ?>" name="<?php echo $this->get_field_name( 'element_class' ); ?>" value="<?php echo esc_attr( $instance['element_class'] );?>" style="width:100%;" />
			</p>			
			<p>  
			    <label for="<?php echo $this->get_field_id( 'margin-top' ); ?>"><?php _e('Margin Top:', 'swh'); ?></label>
			    <input id="<?php echo $this->get_field_id( 'margin-top' ); ?>" name="<?php echo $this->get_field_name( 'margin-top' ); ?>" value="<?php echo esc_attr( $instance['margin-top'] );?>" style="width:100%;" />
			</p>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'margin-bottom' ); ?>"><?php _e('Margin Bottom:', 'swh'); ?></label>
			    <input id="<?php echo $this->get_field_id( 'margin-bottom' ); ?>" name="<?php echo $this->get_field_name( 'margin-bottom' ); ?>" value="<?php echo esc_attr( $instance['margin-bottom'] );?>" style="width:100%;" />
			</p>
			
			<style>.sweethome-dropdown{width:100%;}</style>
		<?php 
	}
}