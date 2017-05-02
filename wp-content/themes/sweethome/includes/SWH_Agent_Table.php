<?php
if( !defined('ABSPATH') ) exit;
if( !class_exists('SWH_Agent_Table') ){
	class SWH_Agent_Table {
		function __construct() {
			add_filter('manage_edit-agent_columns' , array($this,'cpt_columns'));
			add_action( "manage_agent_posts_custom_column", array($this,'modify_column'), 10, 2 );
			add_filter('pre_get_posts', array( $this , 'pre_query' ),30,1);
		}
		function cpt_columns($columns){
			$new_columns = array(
				'name'	=>	__('Name','swh'),
				'image'	=>	__('Image','swh'),
				'email'	=>	__('Email','swh'),					
				'phone'	=>	__('Phone','swh'),
				'fax'	=>	__('Fax','swh'),
				'property'	=>	__('Property(s)','swh')
			);
			unset( $columns['author'] );
			return array_merge($columns, $new_columns);
		}	
		function modify_column($column, $post_id){
			switch ($column) {
				case 'name':
					print get_post_meta($post_id,'name',true);
				break;				
				case 'image':
					if( has_post_thumbnail($post_id) ){
						print get_the_post_thumbnail($post_id,'property-thumbnail-124-76');
					}
				break;
				case 'phone':
					print get_post_meta($post_id,'phone',true);
				break;
				case 'fax':
					print get_post_meta($post_id,'fax',true);
				break;	
				case 'email':
					print get_post_meta($post_id,'email',true);
				break;
				case 'property':
					$count = swh_count_property_by_agent( $post_id );
					if( $count > 0 ){
						print '<a href="'.admin_url('edit.php?post_type=property&ofagent='.$post_id).'">'. swh_count_property_by_agent( $post_id ) .'</a>';
					}
					
				break;
			}
		}
		function pre_query( $query ){
			if( is_admin() && isset( $_GET['post_type'] ) && $_GET['post_type'] =='property' && isset( $_GET['ofagent'] ) ){
				$query->set('meta_query',array(
					array(
						'key'=>'agent',
						'value'=> $_GET['ofagent'],
						'compare'=>'='
					)
				));	
			}
			return $query;
		}
	}
	new SWH_Agent_Table();
}