<?php
if( !class_exists('SWH_Ajax') ){
	class SWH_Ajax {
		function __construct() {
			add_action('wp_ajax_swh_contactform_act', array( $this , 'contactform' ));
			add_action('wp_ajax_nopriv_swh_contactform_act', array( $this , 'contactform' ));
		}
		function contactform(){
			$headers = null;
			global $sweethome;
			$message = null;
			if( $sweethome['cf_active'] != 1 ){
				if( !$message ){
					print json_encode(array(
						'resp'	=>	'error',
						'element_class'	=>	'alert-warning',
						'message'	=>	$sweethome['cf_deactive_message']
					));
					exit;
				}
			}
			
			$name = wp_filter_nohtml_kses($_POST['name']);
			$email = wp_filter_nohtml_kses($_POST['email']);
			$website = wp_filter_nohtml_kses($_POST['website']);
			$message_content = wp_filter_nohtml_kses($_POST['message']);
			
			if( !$name ){
				print json_encode(array(
					'resp'	=>	'error',
					'element_class'	=>	'alert-warning',
					'message'	=>	$sweethome['cf_name_error']	
				));
				exit;
			}
			if( !$email ){
				print json_encode(array(
					'resp'	=>	'error',
					'element_class'	=>	'alert-warning',
					'message'	=>	$sweethome['cf_email_error']
				));
				exit;
			}			
			if( !is_email( $email ) ){
				print json_encode(array(
					'resp'	=>	'error',
					'element_class'	=>	'alert-warning',
					'message'	=>	$sweethome['cf_email_error']
				));
				exit;
			}
			if( !$message_content ){
				print json_encode(array(
					'resp'	=>	'error',
					'element_class'	=>	'alert-warning',
					'message'	=>	$sweethome['cf_content_error']
				));
				exit;
			}
			$admin_email = is_email( $sweethome['cf_email'] ) ? trim( $sweethome['cf_email'] ) : get_bloginfo('admin_email'); 
			$subject = $sweethome['cf_subject'] ? $sweethome['cf_subject'] : sprintf( __('New message from %s','swh') , get_bloginfo('name'));
			$message .= $message_content . '<br/>';
			$message .= sprintf( __('From: %s','swh') , $name) . '<br/>';
			$message .= sprintf( __('Email: %s','swh') , $email). '<br/>';
			$message .= sprintf( __('Website: %s','swh') , $website). '<br/>';
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8";			
			$mail = wp_mail( $admin_email , $subject, nl2br( $message ), $headers);
			if( $mail === true ){
				print json_encode(array(
					'resp'	=>	'success',
					'element_class'	=>	'alert-success',
					'message'	=>	$sweethome['cf_sent_successfully']
				));
				exit;
			}
			else{
				print json_encode(array(
					'resp'	=>	'error',
					'element_class'	=>	'alert-warning',
					'message'	=>	$sweethome['cf_sent_failed']
				));
				exit;
			}
		}
	}
	new SWH_Ajax();
}