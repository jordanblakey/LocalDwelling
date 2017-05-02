<?php
if( !defined('ABSPATH') ) exit;
if( !class_exists('SWH_MetaBox') ){
	class SWH_MetaBox {
		function __construct() {
			add_action('init', array( $this, 'metabox' ));
		}
		function metabox(){
			if(function_exists("register_field_group"))
			{
				if(function_exists("register_field_group"))
				{
					register_field_group(array (
						'id' => 'acf_agents',
						'title' => __('Agents','swh'),
						'fields' => array (
						array (
							'key' => 'field_537ff920d39aa',
							'label' => __('Name','swh'),
							'name' => 'name',
							'type' => 'text',
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'formatting' => 'html',
							'maxlength' => '',
							),
							array (
								'key' => 'field_537ffb7b36fff',
								'label' => __('Email Address','swh'),
								'name' => 'email',
								'type' => 'text',
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'formatting' => 'html',
								'maxlength' => '',
							),
							array (
								'key' => 'field_537f1c6808398',
								'label' => __('Phone','swh'),
								'name' => 'phone',
								'type' => 'text',
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'formatting' => 'html',
								'maxlength' => '',
							),
							array (
								'key' => 'field_537f1c9f08399',
								'label' => __('Fax','swh'),
								'name' => 'fax',
								'type' => 'text',
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'formatting' => 'html',
								'maxlength' => '',
							),
							array (
								'key' => 'field_537f1cc20839a',
								'label' => __('Socials','swh'),
								'name' => 'socials',
								'type' => 'repeater',
								'sub_fields' => array (
							array (
								'key' => 'field_537f1ccb0839b',
								'label' => __('Profile','swh'),
								'name' => 'profile',
								'type' => 'select',
								'column_width' => '',
								'choices' => swh_social_profile(),
								'default_value' => '',
								'allow_null' => 0,
								'multiple' => 0,
							),
							array (
								'key' => 'field_537f1ce50839c',
								'label' => __('Link','swh'),
								'name' => 'link',
								'type' => 'text',
								'column_width' => '',
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'formatting' => 'html',
								'maxlength' => '',
								),
								),
								'row_min' => '',
								'row_limit' => '',
								'layout' => 'table',
								'button_label' => __('Add Row','swh'),
							),
							array (
								'key' => 'field_537ffc014e670',
								'label' => __('External Profile','swh'),
								'name' => 'external_profile',
								'type' => 'text',
								'default_value' => '',
								'placeholder' => 'http://',
								'prepend' => '',
								'append' => '',
								'formatting' => 'html',
								'maxlength' => '',
							),
						),
						'location' => array (
							array (
							array (
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'agent',
								'order_no' => 0,
								'group_no' => 0,
								),
							),
						),
						'options' => array (
							'position' => 'normal',
							'layout' => 'default',
							'hide_on_screen' => array (
							),
						),
						'menu_order' => 0,
						)
					);
				}
				register_field_group(array (
					'id' => 'acf_property-image',
					'title' => __('Property Image','swh'),
					'fields' => array (
						array (
							'key' => 'field_53927b8823e98',
							'label' => __('Large Image','swh'),
							'name' => 'large_image',
							'type' => 'image',
							'instructions' => __('This image should be large, it will be used as the slider if you setup it up on the Widget Slider.','swh'),
							'save_format' => 'id',
							'preview_size' => 'medium',
							'library' => 'all',
						),
					),
					'location' => array (
						array (
							array (
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'property',
								'order_no' => 0,
								'group_no' => 0,
							),
						),
					),
					'options' => array (
							'position' => 'side',
							'layout' => 'default',
							'hide_on_screen' => array (
						),
					),
					'menu_order' => 0,
					)
				);				
				register_field_group(array (
					'id' => 'acf_property',
					'title' => __('Property','swh'),
					'fields' => array (
					array (
						'key' => 'field_537ff9d426588',
						'label' => __('Agent','swh'),
						'name' => 'agent',
						'type' => 'post_object',
						'post_type' => array (
						0 => 'agent',
						),
						'taxonomy' => array (
						0 => 'all',
						),
						'allow_null' => 1,
						'multiple' => 0,
					),
					array (
						'key' => 'field_538be7e6f3682',
						'label' => __('Featured','swh'),
						'name' => 'featured',
						'type' => 'true_false',
						'message' => '',
						'default_value' => 0,
					),
					array (
						'key' => 'field_537ffe50ae5f7',
						'label' => __('Location','swh'),
						'name' => 'location',
						'type' => 'google_map',
						'center_lat' => '',
						'center_lng' => '',
						'zoom' => '',
						'height' => '',
					),
					array (
						'key' => 'field_5382eac74b3b5',
						'label' => __('Sq ft','swh'),
						'name' => 'sq_ft',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5382ead64b3b6',
						'label' => __('Price','swh'),
						'name' => 'price',
						'type' => 'number',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'min' => '',
						'max' => '',
						'step' => '',
					),
					array (
						'key' => 'field_5382eaee4b3b7',
						'label' => __('Bathrooms','swh'),
						'name' => 'bathrooms',
						'type' => 'select',
						'choices' => $this->number(),
						'default_value' => '',
						'allow_null' => 0,
						'multiple' => 0,
					),
					array (
						'key' => 'field_5382eafa4b3b8',
						'label' => __('Bedrooms','swh'),
						'name' => 'bedrooms',
						'type' => 'select',
						'choices' => $this->number(),
						'default_value' => '',
						'allow_null' => 0,
						'multiple' => 0,
					),
					array (
						'key' => 'field_5382eb094b3b9',
						'label' => __('Garages','swh'),
						'name' => 'garages',
						'type' => 'select',
						'choices' => $this->number(),
						'default_value' => '',
						'allow_null' => 0,
						'multiple' => 0,
					),
					array (
						'key' => 'field_537f0fa25f4a6',
						'label' => __('Gallery','swh'),
						'name' => 'gallery',
						'type' => 'repeater',
						'sub_fields' => array (
							array (
								'key' => 'field_537f0fba5f4a7',
								'label' => __('Image','swh'),
								'name' => 'image',
								'type' => 'image',
								'column_width' => '',
								'save_format' => 'id',
								'preview_size' => 'thumbnail',
								'library' => 'all',
							),
						),
						'row_min' => '',
						'row_limit' => 50,
						'layout' => 'row',
						'button_label' => __('Add Row','swh'),
					),
					),
					'location' => array (
						array (
							array (
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'property',
								'order_no' => 0,
								'group_no' => 0,
							),
						),
					),
					'options' => array (
						'position' => 'normal',
						'layout' => 'default',
						'hide_on_screen' => array (
						),
					),
					'menu_order' => 0,
					)
				);
				register_field_group(array (
					'id' => 'acf_services',
					'title' => 'Services',
					'fields' => array (
						array (
							'key' => 'field_538ed45b3d23d',
							'label' => __('Sub Title','swh'),
							'name' => 'sub_title',
							'type' => 'text',
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'formatting' => 'html',
							'maxlength' => '',
						),
						array (
							'key' => 'field_538ed4713d23e',
							'label' => __('Class','swh'),
							'name' => 'class',
							'type' => 'text',
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'formatting' => 'html',
							'maxlength' => '',
							'instructions'	=>	sprintf( __('Check all icon class %s','swh') , '<a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/">'.__('here','swh').'</a>')
						),
						array (
							'key' => 'field_538ed4773d23f',
							'label' => __('Read more link','swh'),
							'name' => 'read_more',
							'type' => 'text',
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'formatting' => 'html',
							'maxlength' => '',
						),
					),
					'location' => array (
						array (
							array (
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'service',
								'order_no' => 0,
								'group_no' => 0,
							),
						),
					),
					'options' => array (
						'position' => 'acf_after_title',
						'layout' => 'default',
						'hide_on_screen' => array (
						),
					),
					'menu_order' => 0,
					)
				);
			}
		}
		function number(){
			return array(
				'0'	=>	__('None','swh'),
				'1'	=>	'1',
				'2'	=>	'2',
				'3'	=>	'3',
				'4'	=>	'4',
				'5'	=>	'5',
				'6'	=>	'6',
				'7'	=>	'7',
				'8'	=>	'8',
				'9'	=>	'9',
				'10'	=>	'10',
				'11'	=>	'11',
				'12'	=>	'12',
				'13'	=>	'13',
				'14'	=>	'14',
				'15'	=>	'15',
				'16'	=>	'16',
				'17'	=>	'17',
				'18'	=>	'18',
				'19'	=>	'19',
				'20'	=>	'20',		
			);
		}
	}
	new SWH_MetaBox();
}