<?php
if( !defined('ABSPATH') ) exit;
if( !function_exists('SWH_Widget_ContactUs') ){
	function SWH_Widget_ContactUs() {
		register_widget('SWH_Widget_ContactUs_Class');
	}
	add_action('widgets_init', 'SWH_Widget_ContactUs');
}
class SWH_Widget_ContactUs_Class extends WP_Widget{
	
	function __construct(){
		$widget_ops = array( 'classname' => 'footer-contact-info', 'description' => __('Displays the Contact Widget at Footer.', 'swh') );
	
		parent::__construct( 'footer-contact-info' , __('SWH Contact Us', 'swh') , $widget_ops);
	}	

	function widget($args, $instance){
		extract( $args );
		$title = apply_filters('widget_title', esc_attr($instance['title']) );
		$phone = isset( $instance['phone'] ) ? esc_attr($instance['phone']) : null;
		$email = isset( $instance['email'] ) ? esc_attr($instance['email']) : null;
		$fax = isset( $instance['fax'] ) ? esc_attr($instance['fax']) : null;
		print  $before_widget;
			if( !empty( $title ) ){
			print $before_title . $title . $after_title;
		}
		?>
			<?php if( $phone ):?>
			<p class="website-number">
				<i class="fa fa-phone"></i> <?php print $phone;?>
			</p>
			<?php endif;?>
			<?php if( $email ):?>
			<p class="website-email">
				<a href="mailto:<?php print $email;?>"><i class="fa fa-envelope"></i> <?php print $email;?></a>
			</p>
			<?php endif;?>
			<?php if( $fax ):?>
			<p class="website-fax">
				<i class="fa fa-print"></i> <?php print $fax;?>
			</p>
			<?php endif;?>
		<?php 
		print $after_widget;		
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['phone'] = strip_tags( $new_instance['phone'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		$instance['fax'] = strip_tags( $new_instance['fax'] );
		return $instance;
	}
	function form( $instance ){
		global $sweethome;
		$defaults = array(
			'title' => __('Contact Info', 'swh'),
			'email'	=>	!empty( $sweethome['c_email'] ) ? esc_attr($sweethome['c_email']) : get_bloginfo('admin_email'),
			'phone'	=>	!empty( $sweethome['c_telephone'] ) ? esc_attr($sweethome['c_telephone']) : null,
			'fax'	=>	!empty( $sweethome['c_fax'] ) ? esc_attr($sweethome['c_fax']) : null,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'swh'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo !empty( $instance['title'] ) ? esc_attr($instance['title']) : NULL; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e('Phone:', 'swh'); ?></label>
				<input id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo !empty( $instance['phone'] ) ? esc_attr($instance['phone']) : NULL; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e('Email:', 'swh'); ?></label>
				<input id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo esc_attr($instance['email']); ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'fax' ); ?>"><?php _e('Fax:', 'swh'); ?></label>
				<input id="<?php echo $this->get_field_id( 'fax' ); ?>" name="<?php echo $this->get_field_name( 'fax' ); ?>" value="<?php echo !empty( $instance['fax'] ) ? esc_attr( $instance['fax']) : NULL; ?>" style="width:100%;" />
			</p>						
		<?php 
	}
}
