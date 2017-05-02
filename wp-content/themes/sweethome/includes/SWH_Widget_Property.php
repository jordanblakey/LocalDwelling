<?php
if( !defined('ABSPATH') ) exit;
if( !function_exists('SWH_Widget_Property') ){
	function SWH_Widget_Property() {
		register_widget('SWH_Widget_Property_Class');
	}
	add_action('widgets_init', 'SWH_Widget_Property');
}
class SWH_Widget_Property_Class extends WP_Widget{
	
	function __construct(){
		$widget_ops = array( 'classname' => 'similar-listings-widget', 'description' => __('Displays the Property listing on left/right sidebar', 'swh') );
	
		parent::__construct( 'swh-widget-property' , __('SWH Property Listing', 'swh') , $widget_ops);
	}	
	
	function widget($args, $instance){
		extract( $args );
		wp_reset_postdata();wp_reset_query();
		$title = apply_filters('widget_title', esc_attr( $instance['title'] ) );
		$related_property_agent = isset( $instance['related_property_agent'] ) ? esc_attr( $instance['related_property_agent'] ) : null;
		$show_price = isset( $instance['show_price'] ) ? esc_attr( $instance['show_price'] ) : null;
		$orderby = isset( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : 'ID';
		$order = isset( $instance['order'] ) ? esc_attr( $instance['order'] ) : 'DESC';
		$limit = isset( $instance['limit'] ) ? absint( $instance['limit'] ) : 3;
		$current_post = get_the_ID();
		$wp_array = array(
			'post_type'	=>	'property',
			'post_status'	=>	'publish',
			'showposts'	=>	$limit,
			'orderby'	=>	$orderby,
			'order'		=>	$order
		);
		if( $current_post ){
			$wp_array['post__not_in']	=	array($current_post);
		}
		if( $related_property_agent ){
			$current_agent = get_post_meta( $current_post,'agent',true );
			if( $current_agent ){
				$wp_array['meta_query'] = array(
			       array(
			           'key' => 'agent',
			           'value' => $current_agent,
			           'compare' => '=',
			       )
			   );
			}
		}
		
		$wp_query = new WP_Query( $wp_array );
		
		if( $wp_query->have_posts() ):
		print  $before_widget;
		print $before_title . $title . $after_title;
		?>
			<ul class="similar-listings">
				<?php while( $wp_query->have_posts() ) : $wp_query->the_post();?>
					<li class="tab-content-item">
						<?php if(has_post_thumbnail()):?>
						<div class="pull-left thumb">
							<a href="<?php the_permalink();?>"><?php print get_the_post_thumbnail(null,'thumbnail', array('class'=>'property-thumbnail-50-50'));?></a>
						</div>
						<?php endif;?>
						<h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
						<?php if( $show_price == 'on' && swh_get_property_price( get_the_ID() ) != SWH_NA ):?>
							<h5><?php print swh_get_property_price( get_the_ID() );?></h5>
						<?php endif;?>
					</li>
				<?php endwhile;?>
			</ul>
		<?php
		print $after_widget;
		endif;
		wp_reset_postdata();wp_reset_query();
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['all'] = $new_instance['all'];
		$instance['related_property_agent'] = $new_instance['related_property_agent'];
		$instance['show_price'] = $new_instance['show_price'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['order'] = $new_instance['order'];
		$instance['limit'] = $new_instance['limit'];
		return $instance;
	}
	function form( $instance ){
		$defaults = array(
			'title' => __('Property Listings', 'swh'),
			'related_property_agent'	=>	'off',
			'show_price'	=>	'on',
			'order'	=>	'DESC',
			'orderby'	=>	'ID',
			'limit'	=>	3
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'swh'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo !empty( $instance['title'] ) ? esc_attr( $instance['title'] ) : NULL; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'related_property_agent' ); ?>"><?php _e('Related Property:', 'swh'); ?></label><br/>
				<input <?php checked('on', $instance['related_property_agent'],true);?> type="checkbox" id="<?php echo $this->get_field_id( 'related_property_agent' ); ?>" name="<?php echo $this->get_field_name( 'related_property_agent' ); ?>"/>
				<small><?php _e('Displaying the Related Property of current Agent in Property Single page.','swh');?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'show_price' ); ?>"><?php _e('Displaying the Price:', 'swh'); ?></label>
				<input type="checkbox" <?php checked('on', $instance['show_price'],true);?> id="<?php echo $this->get_field_id( 'show_price' ); ?>" name="<?php echo $this->get_field_name( 'show_price' ); ?>"/>
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
			    <input id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo absint( $instance['limit'] );?>" style="width:100%;" />
			</p>
		<?php 
	}
}