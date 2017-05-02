<?php
if( !defined('ABSPATH') ) exit;
if( !function_exists('SWH_Widget_SubscribeForm') ){
	function SWH_Widget_SubscribeForm() {
		register_widget('SWH_Widget_SubscribeForm_Class');
	}
	add_action('widgets_init', 'SWH_Widget_SubscribeForm');
}
class SWH_Widget_SubscribeForm_Class extends WP_Widget{
	
	function __construct(){
		$widget_ops = array( 'classname' => 'footer-newsletter', 'description' => __('Displays the Subscribe/Newletter form at Footer', 'swh') );
	
		parent::__construct( 'footer-newsletter' , __('SWH Subscribe Form', 'swh') , $widget_ops);
	}	
	
	function widget($args, $instance){
		extract( $args );
		$title = apply_filters('widget_title', esc_attr( $instance['title'] ) );
		$text = isset( $instance['text'] ) ? esc_attr( $instance['text'] ) : null;
		$form_method = isset( $instance['form_method'] ) ? esc_attr( $instance['form_method'] ) : 'get';
		$action = !empty( $instance['action'] ) ? $instance['action'] : home_url();

		print  $before_widget;
		print $before_title . $title . $after_title;
			print $text ? '<p>'.$text.'</p>' : null;
			?>
			<form class='footer-search' method="<?php print $form_method;?>" action="<?php print $action;?>">
				<input name="email" id="email-address" type="text" placeholder="<?php _e('E-mail','swh')?>">
				<input type="submit" value="<?php _e('Submit','swh');?>">
				<?php wp_nonce_field('subscribe_act','subscribe',null,true);?>
			</form>
			<?php
		
		print $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['text'] = strip_tags( $new_instance['text'] );
		$instance['form_method'] = strip_tags( $new_instance['form_method'] );
		$instance['action'] = strip_tags( $new_instance['action'] );
		return $instance;
	}
	function form( $instance ){
		$defaults = array(
			'title' => __('Newsletter', 'swh'),
			'form_method'	=>	'get',
			'action'	=>	null
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'swh'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo !empty( $instance['title'] ) ? esc_attr( $instance['title'] ) : NULL; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e('Text:', 'swh'); ?></label>
				<textarea id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" style="width:100%;"><?php echo !empty( $instance['text'] ) ? esc_attr( $instance['text'] ) : NULL; ?></textarea>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'form_method' ); ?>"><?php _e('Form method:', 'swh'); ?></label>
				<select style="width: 100%;" id="<?php echo $this->get_field_id( 'form_method' ); ?>" name="<?php echo $this->get_field_name( 'form_method' ); ?>">
					<?php 
						foreach ( $this->form_method() as $key=>$value ){
							?>
								<option <?php selected(  $instance['form_method'] , $key, true);?> value="<?php print $key;?>"><?php print $value;?>
							<?php 
						}
					?>					
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'action' ); ?>"><?php _e('Action Link:', 'swh'); ?></label>
				<input id="<?php echo $this->get_field_id( 'action' ); ?>" name="<?php echo $this->get_field_name( 'action' ); ?>" value="<?php echo esc_attr( $instance['action'] ); ?>" style="width:100%;" />
				<p><?php _e('Using the external link if you want to handle the data on other website or leave blank for default.','swh')?></p>
			</p>			
		<?php 
	}
	function form_method(){
		return array(
			'get'	=>	'GET',
			'post'	=>	'POST'	
		);
	}
}