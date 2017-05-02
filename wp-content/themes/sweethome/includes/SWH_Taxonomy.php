<?php
if( !defined('ABSPATH') ) exit;
if( !class_exists('SWH_Taxonomy') ){
	class SWH_Taxonomy {
		function __construct() {
			add_action('init', array( $this, 'property_type' ), 100);
			add_action('init', array( $this, 'location' ), 100);
			add_action('init', array( $this, 'property_tag' ), 100);
			add_action('init', array( $this, 'property_status' ), 100);
		}
		
		function property_type() {
			global $sweethome;
			$rewrite_ptype = isset( $sweethome['rewrite_ptype'] ) ? trim( $sweethome['rewrite_ptype'] ) : 'ptype';
			$labels = array(
				'name'                       => __( 'Property types', 'swh' ),
				'singular_name'              => __( 'Property types', 'swh' ),
				'search_items'               => __( 'Search Property types', 'swh' ),
				'popular_items'              => __( 'Popular Property types', 'swh' ),
				'all_items'                  => __( 'All Property type', 'swh' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Property type', 'swh' ),
				'update_item'                => __( 'Update Property type', 'swh' ),
				'add_new_item'               => __( 'Add New Property type', 'swh' ),
				'new_item_name'              => __( 'New Property type Name', 'swh' ),
				'separate_items_with_commas' => __( 'Separate Property type with commas', 'swh' ),
				'add_or_remove_items'        => __( 'Add or remove Property type', 'swh' ),
				'choose_from_most_used'      => __( 'Choose from the most used Property type', 'swh' ),
				'not_found'                  => __( 'No Property type found.', 'swh' ),
				'menu_name'                  => __( 'Property type', 'swh' ),
			);
				
			register_taxonomy( 'ptype',
				array (
					0 => 'property',
				),
				array(
					'hierarchical' => true,
					'rewrite'	=> array( 'slug' => $rewrite_ptype, 'with_front' => true ),
					'label' => __('Property type','swh'),
					'show_ui' => true,
					'query_var' => true,
					'show_admin_column' => true,
					'labels' => $labels
				)
			);
		}
		
		function location() {
			global $sweethome;
			$rewrite_location = isset( $sweethome['rewrite_location'] ) ? trim( $sweethome['rewrite_location'] ) : 'location';
			$labels = array(
				'name'                       => __( 'Locations', 'swh' ),
				'singular_name'              => __( 'Locations', 'swh' ),
				'search_items'               => __( 'Search Locations', 'swh' ),
				'popular_items'              => __( 'Popular Locations', 'swh' ),
				'all_items'                  => __( 'All Locations', 'swh' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Location', 'swh' ),
				'update_item'                => __( 'Update Location', 'swh' ),
				'add_new_item'               => __( 'Add New Location', 'swh' ),
				'new_item_name'              => __( 'New Location Name', 'swh' ),
				'separate_items_with_commas' => __( 'Separate Locations with commas', 'swh' ),
				'add_or_remove_items'        => __( 'Add or remove Location', 'swh' ),
				'choose_from_most_used'      => __( 'Choose from the most used Location', 'swh' ),
				'not_found'                  => __( 'No Location type found.', 'swh' ),
				'menu_name'                  => __( 'Locations', 'swh' ),
			);		
			register_taxonomy( 'location',
				array (
					0 => 'property',
				),
				array( 
					'hierarchical' => true,
					'rewrite'	=> array( 'slug' => $rewrite_location, 'with_front' => true ),
					'label' => __('Locations','swh'),
					'show_ui' => true,
					'query_var' => true,
					'show_admin_column' => true,
					'labels' => $labels
				) 
			);			
		}
		function property_tag() {
			global $sweethome;
			$rewrite_property_tag = isset( $sweethome['rewrite_property_tag'] ) ? trim( $sweethome['rewrite_property_tag'] ) : 'property_tag';
			$labels = array(
				'name'                       => __( 'Additional Features', 'swh' ),
				'singular_name'              => __( 'Additional Features', 'swh' ),
				'search_items'               => __( 'Search Additional Features', 'swh' ),
				'popular_items'              => __( 'Popular Additional Features', 'swh' ),
				'all_items'                  => __( 'All Additional Features', 'swh' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Additional Feature', 'swh' ),
				'update_item'                => __( 'Update Additional Feature', 'swh' ),
				'add_new_item'               => __( 'Add New Additional Feature', 'swh' ),
				'new_item_name'              => __( 'New Additional Feature Name', 'swh' ),
				'separate_items_with_commas' => __( 'Separate Additional Features with commas', 'swh' ),
				'add_or_remove_items'        => __( 'Add or remove Additional Feature', 'swh' ),
				'choose_from_most_used'      => __( 'Choose from the most used Additional Features', 'swh' ),
				'not_found'                  => __( 'No Additional Features type found.', 'swh' ),
				'menu_name'                  => __( 'Additional Features', 'swh' ),
			);						
			register_taxonomy( 'property_tag',
				array (
					0 => 'property',
				),
				array(
					'hierarchical' => false,
					'rewrite'	=> array( 'slug' => $rewrite_property_tag, 'with_front' => true ),
					'label' => __('Additional Features','swh'),
					'show_ui' => true,
					'query_var' => true,
					'show_admin_column' => false,
					'labels' => $labels
				)
			);
		}
		
		function property_status() {
			global $sweethome;
			$rewrite_status = isset( $sweethome['rewrite_status'] ) ? trim( $sweethome['rewrite_status'] ) : 'status';		
			$labels = array(
				'name'                       => __( 'Status', 'swh' ),
				'singular_name'              => __( 'Status', 'swh' ),
				'search_items'               => __( 'Search Status', 'swh' ),
				'popular_items'              => __( 'Popular Status', 'swh' ),
				'all_items'                  => __( 'All Status', 'swh' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Status', 'swh' ),
				'update_item'                => __( 'Update Status', 'swh' ),
				'add_new_item'               => __( 'Add New Status', 'swh' ),
				'new_item_name'              => __( 'New Status Name', 'swh' ),
				'separate_items_with_commas' => __( 'Separate Status with commas', 'swh' ),
				'add_or_remove_items'        => __( 'Add or remove Status', 'swh' ),
				'choose_from_most_used'      => __( 'Choose from the most used Status', 'swh' ),
				'not_found'                  => __( 'No Status Features type found.', 'swh' ),
				'menu_name'                  => __( 'Status', 'swh' ),
			);				
			register_taxonomy( 'status',
				array (
					0 => 'property',
				),
				array(
					'hierarchical' => true,
					'rewrite'	=> array( 'slug' => $rewrite_status, 'with_front' => true ),
					'label' => __('Status','swh'),
					'show_ui' => true,
					'query_var' => true,
					'show_admin_column' => true,
					'labels' => $labels
				) 
			);
		}
	}
	new SWH_Taxonomy();
}