<?php
if( !defined('ABSPATH') ) exit;
if( !function_exists('SWH_Widget_Agent') ){
	function SWH_Widget_Agent() {
		register_widget('SWH_Widget_Agent_Class');
	}
	add_action('widgets_init', 'SWH_Widget_Agent');
}
class SWH_Widget_Agent_Class extends WP_Widget{
	
	function __construct(){
		$widget_ops = array( 'classname' => 'author-profile', 'description' => __('Displays the Agent on the left/right sidebar in Property single page.', 'swh') );
	
		parent::__construct( 'swh-widget-agent' , __('SWH Widget Agent (Listed by)', 'swh') , $widget_ops);
	}	

	function widget($args, $instance){
		extract( $args );
		$title = apply_filters('widget_title', esc_attr( $instance['title'] ) );
		$agent = get_post_meta(get_the_ID() ,'agent' ,true);
		
		if( $agent == 'null' || empty( $agent ) )
			return;
		
		if( get_post_type( get_the_ID() ) == 'property' && is_singular('property') && $agent ):
			print  $before_widget;
				print $before_title . $title . $after_title;		
				?>
					<div class="image-box">
						<?php 
							if( has_post_thumbnail() ){
								print get_the_post_thumbnail($agent, 'agents-thumbnail-320-303');
							}
						?>
						<?php if( function_exists('have_rows') && have_rows('socials', $agent) ): ?>
							<ul class="social-icons">
								<?php while ( have_rows('socials',$agent) ) : the_row();?>
									<li><a href="<?php print esc_attr(get_sub_field('link'));?>" class="fa <?php print esc_attr(get_sub_field('profile'));?>"></a></li>
								<?php endwhile;?>
							</ul>
						<?php endif;?>
					</div>
					<div class="desc-box">
						<h4><?php print get_post_meta( $agent, 'name', true ); ?></h4>
						<?php if( get_post_meta( $agent, 'phone', true ) ):?>
						<p class="person-number">
							<i class="fa fa-phone"></i> <?php print get_post_meta( $agent, 'phone', true ); ?>
						<?php endif;?>
						<?php if( get_post_meta( $agent, 'email', true ) ):?>
						<p class="person-email">
							<i class="fa fa-envelope"></i> <?php print get_post_meta( $agent, 'email', true ); ?>
						</p>
						<?php endif;?>
						<?php if( get_post_meta( $agent, 'fax', true ) ):?>
						<p class="person-fax">
							<i class="fa fa-print"></i> <?php print get_post_meta( $agent, 'fax', true ); ?>
						</p>
						<?php endif;?>
						<?php if( !get_post_meta($agent,'external_profile',true) ):?>
							<a href="<?php print get_permalink( $agent );?>" class='gray-btn'><?php _e('View full profile','swh');?></a>
						<?php else:?>
							<a href="<?php print get_post_meta($agent,'external_profile',true);?>" class='gray-btn'><?php _e('View full profile','swh');?></a>
						<?php endif;?>
					</div>
				<?php 
			print $after_widget;		
		endif;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}
	function form( $instance ){
		$defaults = array(
			'title' => __('Listed By', 'swh'),
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