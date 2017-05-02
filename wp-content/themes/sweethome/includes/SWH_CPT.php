<?php
if( !defined('ABSPATH') ) exit;
if( !class_exists('SWH_CPT') ){
	class SWH_CPT {
		function __construct() {
			add_action('init', array( $this, 'cpt_property' ));
			add_action('init', array( $this, 'cpt_agent' ));
			add_action('init', array( $this,'cpt_service' ));
		}	
		function cpt_property() {
			global $sweethome;
			$rewrite_property = isset( $sweethome['rewrite_property'] ) ? trim( $sweethome['rewrite_property'] ) : 'property';
			register_post_type('property', 
				array(
					'label' => __('Property','swh'),
					'menu_icon'	=>	'dashicons-admin-home',
					'description' => '',
					'public' => true,
					'show_ui' => true,
					'show_in_menu' => true,
					'capability_type' => 'post',
					'map_meta_cap' => true,
					'hierarchical' => false,
					'rewrite' => array('slug' => $rewrite_property, 'with_front' => 1),
					'query_var' => true,
					'has_archive' => true,
					'exclude_from_search'	=>	false,
					'supports' => array('title','editor','publicize','comments','revisions','thumbnail','author'),
					'taxonomies' => array('rsale','ptype','location','bed','bath','sqft','price'),
					'labels' => array (
						'name' => __('Property','swh'),
						'singular_name' => __('Property','swh'),
						'menu_name' => __('Property','swh'),
						'add_new' => __('Add Property','swh'),
						'add_new_item' => __('Add New Property','swh'),
						'edit' => __('Edit','swh'),
						'edit_item' => __('Edit Property','swh'),
						'new_item' => __('New Property','swh'),
						'view' => __('View Property','swh'),
						'view_item' => __('View Property','swh'),
						'search_items' => __('Search Property','swh'),
						'not_found' => __('No Property Found','swh'),
						'not_found_in_trash' => __('No Property Found in Trash','swh'),
						'parent' => __('Parent Property','swh')
					)
				)
			);
		}		
		
		function cpt_agent() {
			global $sweethome;
			$rewrite_agent = isset( $sweethome['rewrite_agent'] ) ? trim( $sweethome['rewrite_agent'] ) : 'agent';
			register_post_type('agent', 
				array(
					'label' => __('Agents','swh'),
					'menu_icon'	=>	'dashicons-businessman',
					'description' => '',
					'public' => true,
					'show_ui' => true,
					'show_in_menu' => true,
					'capability_type' => 'post',
					'map_meta_cap' => true,
					'hierarchical' => false,
					'rewrite' => array('slug' => $rewrite_agent, 'with_front' => true),
					'query_var' => true,
					'has_archive' => true,
					//'exclude_from_search'	=>	true,
					'supports' => array('title','editor','publicize','comments','revisions','thumbnail','author'),
					'labels' => array (
						'name' => __('Agents','swh'),
						'singular_name' => __('Agents','swh'),
						'menu_name' => __('Agents','swh'),
						'add_new' => __('Add Agents','swh'),
						'add_new_item' => __('Add New Agents','swh'),
						'edit' => __('Edit','swh'),
						'edit_item' => __('Edit Agents','swh'),
						'new_item' => __('New Agents','swh'),
						'view' => __('View Agents','swh'),
						'view_item' => __('View Agents','swh'),
						'search_items' => __('Search Agents','swh'),
						'not_found' => __('No Agents Found','swh'),
						'not_found_in_trash' => __('No Agents Found in Trash','swh'),
						'parent' => __('Parent Agents','swh'),
					)
				)
			);
		}
		
		function cpt_service() {
			global $sweethome;
			$rewrite_service = isset( $sweethome['rewrite_service'] ) ? trim( $sweethome['rewrite_service'] ) : 'service';			
			register_post_type('service', 
				array(
					'label' => __('Services','swh'),
					'menu_icon'	=>	'dashicons-lightbulb',
					'description' => '',
					'public' => true,
					'show_ui' => true,
					'show_in_menu' => true,
					'capability_type' => 'post',
					'map_meta_cap' => true,
					'hierarchical' => false,
					'rewrite' => array('slug' => $rewrite_service, 'with_front' => true),
					'query_var' => true,
					//'exclude_from_search'	=>	true,
					'supports' => array('title','publicize'),
					'labels' => array (
						'name' => __('Services','swh'),
						'singular_name' => __('Services','swh'),
						'menu_name' => __('Services','swh'),
						'add_new' => __('Add Services','swh'),
						'add_new_item' => __('Add New Services','swh'),
						'edit' => __('Edit','swh'),
						'edit_item' => __('Edit Services','swh'),
						'new_item' => __('New Services','swh'),
						'view' => __('View Services','swh'),
						'view_item' => __('View Services','swh'),
						'search_items' => __('Search Services','swh'),
						'not_found' => __('No Services Found','swh'),
						'not_found_in_trash' => __('No Services Found in Trash','swh'),
						'parent' => __('Parent Services','swh'),
					)
				) 
			);
		}				
	}
	new SWH_CPT();
}