<?php
if( !defined('ABSPATH') ) exit;
if( !function_exists('SWH_Widget_Services_Block') ){
	function SWH_Widget_Services_Block() {
		register_widget('SWH_Widget_Services_Block_Class');
	}
	add_action('widgets_init', 'SWH_Widget_Services_Block');
}
class SWH_Widget_Services_Block_Class extends WP_Widget{
	
	function __construct(){
		$widget_ops = array( 'classname' => 'service-block', 'description' => __('Displays the Service Block', 'swh') );
	
		parent::__construct( 'swh-service-block' , __('SWH Service Block', 'swh') , $widget_ops);
	}	
	
	function widget($args, $instance){
		extract( $args );
		$title = apply_filters('widget_title', esc_attr( $instance['title'] ) );
		$wp_array = array(
			'post_type'	=>	'service',
			'post_status'	=>	'publish',
		);
		$wp_query = new WP_Query( $wp_array );
		if( $wp_query->have_posts() ) :
		?>
		<div class="services-section">
			<div class="container">
				<?php if( $title ):?>
				<div class="title-box">
					<h3><?php print $title;?></h3>
					<div class="bordered">
					</div>
				</div>
				<?php endif;?>
				<div class="services-wrapper">
					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
					<?php 
						$class = get_post_meta(get_the_ID(),'class',true) ? get_post_meta(get_the_ID(),'class',true) : 'fa-html5';
						$readmore = get_post_meta( get_the_ID(),'read_more',true ) ? get_post_meta( get_the_ID(),'read_more',true ) : '#';
					?>
					<div class="col-md-3 single-service">
						<div class="bordered top-bordered">
						</div>
						<h4><?php the_title();?></h4>
						<?php if( get_post_meta( get_the_ID(), 'sub_title',true ) ):?>
							<p><?php print get_post_meta( get_the_ID(), 'sub_title',true );?></p>
						<?php endif;?>
						<div class="fa <?php print $class;?> icon-service"></div>
						<div class="bordered"></div>
						<a href="<?php print $readmore;?>" class='readmore'><?php _e('+ read more','swh');?></a>
					</div>
					<?php endwhile;?>
				</div>
			</div>
		</div>
		<?php
		endif;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}
	function form( $instance ){
		$defaults = array(
			'title' => __('Our Services', 'swh'),
			'column'	=>	4
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'swh'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo !empty( $instance['title'] ) ? esc_attr( $instance['title'] ) : NULL; ?>" style="width:100%;" />
			</p>		
		<?php 
	}	
}