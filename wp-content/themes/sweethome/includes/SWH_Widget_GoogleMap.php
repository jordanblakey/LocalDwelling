<?php
if( !defined('ABSPATH') ) exit;
if( !function_exists('SWH_Widget_GoogleMap') ){
	function SWH_Widget_GoogleMap() {
		register_widget('SWH_Widget_GoogleMap_Class');
	}
	add_action('widgets_init', 'SWH_Widget_GoogleMap');
}
class SWH_Widget_GoogleMap_Class extends WP_Widget{
	
	function __construct(){
		$widget_ops = array( 'classname' => 'swh-googlemap', 'description' => __('Displays the Google Map in The Contact Page', 'swh') );
	
		parent::__construct( 'swh-googlemap' , __('SWH Google Map', 'swh') , $widget_ops);
	}	

	function widget($args, $instance){
		extract( $args );
		$title = apply_filters('widget_title', isset( $instance['title'] ) ? esc_attr($instance['title']) : null );
		$lat = isset( $instance['lat'] ) ? esc_attr($instance['lat']) : null;
		$lng = isset( $instance['lng'] ) ? esc_attr($instance['lng']) : null;
		print  $before_widget;
		if( !empty( $title ) ){
			print $before_title . $title . $after_title;
		}
		
			if( $lat && $lng ):
			?>
			<div class="col-md-12 map-wrapper">
				<div class="inner-wrapper">
					<div id="map"></div>
					<div class="clearfix">
					</div>
				</div>
			</div>
			<script type="text/javascript">
				(function($) {
				  "use strict";
					$(document).ready(function(){
						initialize( <?php print $lat;?>, <?php print $lng;?>, 'map');
					})
				})(jQuery);
			</script>
			<?php
			endif;
		print $after_widget;		
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['lat'] = $new_instance['lat'];
		$instance['lng'] = $new_instance['lng'];
		return $instance;
	}
	function form( $instance ){
		global $sweethome;
		//$instance = wp_parse_args( (array) $instance, $defaults );
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'lat' ); ?>"><?php _e('Lat:', 'swh'); ?></label>
				<input id="<?php echo $this->get_field_id( 'lat' ); ?>" name="<?php echo $this->get_field_name( 'lat' ); ?>" value="<?php echo !empty( $instance['lat'] ) ? esc_attr($instance['lat']) : NULL; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'lng' ); ?>"><?php _e('Lng:', 'swh'); ?></label>
				<input id="<?php echo $this->get_field_id( 'lng' ); ?>" name="<?php echo $this->get_field_name( 'lng' ); ?>" value="<?php echo !empty( $instance['lng'] ) ? esc_attr($instance['lng']) : NULL; ?>" style="width:100%;" />
			</p>						
		<?php 
	}
}
