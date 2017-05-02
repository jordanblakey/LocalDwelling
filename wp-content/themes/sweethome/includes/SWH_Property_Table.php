<?php
if( !defined('ABSPATH') ) exit;
if( !class_exists('SWH_Property_Table') ){
	class SWH_Property_Table {
		function __construct() {
			add_filter('manage_edit-property_columns' , array($this,'cpt_columns'));
			add_action( "manage_property_posts_custom_column", array($this,'modify_column'), 10, 2 );
		}
		function cpt_columns($columns){
			$new_columns = array(
				'agent'	=>	__('Agent','swh'),
			);
			return array_merge($columns, $new_columns);
		}	
		function modify_column($column, $post_id){
			switch ($column) {
				case 'agent':
					$agent_id = get_post_meta($post_id,'agent',true);
					if( $agent_id ){
						print '<a href="'.admin_url('post.php?post='.$agent_id.'&action=edit').'">'.get_the_post_thumbnail($agent_id,'property-thumbnail-124-76').'</a>';
					}
				break;		
			}
		}
	}
	new SWH_Property_Table();
}