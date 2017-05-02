<?php
if( !defined('ABSPATH') ) exit;
if( !function_exists('SWH_Widget_ContactForm') ){
	function SWH_Widget_ContactForm() {
		register_widget('SWH_Widget_ContactForm_Class');
	}
	add_action('widgets_init', 'SWH_Widget_ContactForm');
}
class SWH_Widget_ContactForm_Class extends WP_Widget{
	
	function __construct(){
		$widget_ops = array( 'classname' => 'contact-form-wrapper', 'description' => __('Displays the Contact Form.', 'swh') );
	
		parent::__construct( 'contact-form-wrapper' , __('SWH Contact Form', 'swh') , $widget_ops);
	}	
	
	function widget($args, $instance){
		extract( $args );
		global $sweethome;
		$title = apply_filters('widget_title', esc_attr( $instance['title'] ) );
		print  $before_widget;
		//print $before_title . $title . $after_title;
			?>
				<div class="inner-wrapper">
					<?php if( $title ):?>
						<h4 class="box-title"><?php print $title;?></h4>
					<?php endif;?>
					<form class='contact-form' method="POST">
						<div class="contact-form-left">
							<span><i class='fa fa-user'></i></span><input type="text" name='name' placeholder='Name' id='name'>
							<span><i class='fa fa-envelope-o'></i></span><input type="text" name='email' placeholder='e-mail' id='email'>
							<span><i class='fa fa-link'></i></span><input type="text" name='website' placeholder='website' id='website'>
						</div>
						<div class="contact-form-right">
							<textarea id="message" name='message' placeholder='Message'></textarea>
							<input type="hidden" id="action" name="action" value="swh_contactform_act">
							<input type="submit" value='send message' id='submit-btn'>
						</div>
						<?php wp_nonce_field('swh_contactform_act','swh_contactform',true,true);?>
					</form>
					<div class="clearfix"></div>
					<div style="display: none;" class="alert"></div>
				</div>
			<?php 
		
		//print $after_widget;		
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}
	function form( $instance ){
		global $sweethome;
		$defaults = array(
			'title' => __('Get in touch', 'swh'),
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'swh'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo !empty( $instance['title'] ) ? esc_attr( $instance['title']) : NULL; ?>" style="width:100%;" />
			</p>
		<?php 
	}
}
