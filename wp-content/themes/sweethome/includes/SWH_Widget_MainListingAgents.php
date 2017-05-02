<?php
if( !defined('ABSPATH') ) exit;
if( !function_exists('SWH_Widget_MainListingAgents') ){
	function SWH_Widget_MainListingAgents() {
		register_widget('SWH_Widget_MainListingAgents_Class');
	}
	add_action('widgets_init', 'SWH_Widget_MainListingAgents');
}
class SWH_Widget_MainListingAgents_Class extends WP_Widget{
	
	function __construct(){
		$widget_ops = array( 'classname' => 'swh-widget-main-listing-agents', 'description' => __('Displays the Agents listing on the homepage', 'swh') );
	
		parent::__construct( 'swh-widget-main-listing-agents' , __('SWH Main Agents Listing', 'swh') , $widget_ops);
	}	
	
	function widget($args, $instance){
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		$orderby = isset( $instance['orderby'] ) ? esc_attr($instance['orderby']) : 'ID';
		$order = isset( $instance['order'] ) ? esc_attr($instance['order']) : 'DESC';
		$limit = isset( $instance['limit'] ) ? absint($instance['limit']) : 4;
		$post_type = 'agent';
		$current_post = get_the_ID();
		$wp_array = array(
			'post_type'	=>	$post_type,
			'post_status'	=>	'publish',
			'showposts'	=>	$limit,
			'orderby'	=>	$orderby,
			'order'		=>	$order
		);
		wp_reset_postdata();wp_reset_query();
		$wp_query = new WP_Query( $wp_array );
		
		if( $wp_query->have_posts() ):
			?>
			<div class="agents-section">
				<div class="container">
					<?php if( $title ):?>
						<div class="title-box">
							<h3><?php print $title;?></h3>
							<div class="bordered"></div>
						</div>
					<?php endif;?>
					<div class="owl-carousel agents-slider">
						<?php while ($wp_query->have_posts()):$wp_query->the_post();?>
							<?php get_template_part('content', $post_type);?>
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
		$instance['orderby'] = strip_tags($new_instance['orderby']);
		$instance['order'] = strip_tags($new_instance['order']);
		$instance['limit'] = strip_tags($new_instance['limit']);
		return $instance;
	}
	function form( $instance ){
		$defaults = array(
			'title' => __('Our agents', 'swh'),
			'order'	=>	'DESC',
			'orderby'	=>	'ID',
			'limit'	=>	4
		);
		$post_type = isset( $instance['post_type'] ) ? $instance['post_type'] : 'property';
		$taxonomies = get_object_taxonomies( $post_type );
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'swh'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo !empty( $instance['title'] ) ? esc_attr($instance['title']) : NULL; ?>" style="width:100%;" />
			</p>
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
			    <input id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo absint($instance['limit']);?>" style="width:100%;" />
			</p>
			<style>.sweethome-dropdown{width:100%;}</style>
		<?php 
	}
}