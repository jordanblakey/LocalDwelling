<?php
if( !defined('ABSPATH') ) exit;
if( !class_exists('SWH_Taxonomy_Filter') ){
	class SWH_Taxonomy_Filter {
		var $post_type = 'property';
		function __construct() {
			$post_type = isset( $_GET['post_type'] ) ? esc_attr( $_GET['post_type'] ) : null;
			add_action('restrict_manage_posts', array( $this , 'property' ) );
			if( is_admin() && isset( $post_type ) ){
				add_filter('parse_query', array( $this , 'convert_id_to_term_in_query' ));
			}
		}
		function property() {
			global $typenow;
			global $pagenow;
			$html = '';
			
			$taxonomies = get_object_taxonomies( $this->post_type );
			
			if ( $typenow == $this->post_type && !empty( $taxonomies ) ){
				
				for ( $i = 0;  $i < count( $taxonomies );  $i++) {
					$taxonomy = get_taxonomy( $taxonomies[$i] );
					if( $taxonomies[$i] ){
						$args = array(
							'show_option_all' => sprintf( __('All %s','swh'), $taxonomy->labels->name ),
							'taxonomy'        => $taxonomies[$i],
							'name'               => $taxonomies[$i],
							'hide_empty'	=>	0,
							'selected'        =>  isset( $_GET[ $taxonomies[$i] ] ) ? $_GET[ $taxonomies[$i] ] : null,
							'hierarchical'	=>	true,
							'show_count'	=>	true,
							'echo'	=>	0
						);
						$html .= wp_dropdown_categories($args);						
					}
				}
				//$html .= $this->agent_dropdown();
			}
			
			print $html;
		}
		function convert_id_to_term_in_query($query) {
			global $pagenow;
			$post_type = array( $this->post_type );
			$taxonomies = get_object_taxonomies( $this->post_type );

			$q_vars = &$query->query_vars;
		
			if( isset( $q_vars['post_type'] ) && $q_vars['post_type']== $this->post_type ){
				
				for ( $i = 0;  $i < count( $taxonomies );  $i++) {
					
					if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $this->post_type && isset($q_vars[$taxonomies[$i]]) && is_numeric($q_vars[$taxonomies[$i]]) && $q_vars[$taxonomies[$i]] != 0) {
						$term = get_term_by('id', $q_vars[$taxonomies[$i]], $taxonomies[$i]);
						$q_vars[$taxonomies[$i]] = $term->slug;
					}
				}
			}
		}
		function agent_dropdown(){
			$html = null;
			wp_reset_postdata();wp_reset_query();
			$agent_query = new WP_Query( array('post_type'=>'agent','post_status'=>'publish') );
			if( $agent_query->have_posts() ){
				$html .= '<select name="ofagent">';
				$html .= '<option value="0">'.__('All Agents','swh').'</option>';
					while ( $agent_query->have_posts() ) {	
						$agent_query->the_post();
						global $post;
						$current = isset( $_GET['ofagent'] ) ? $_GET['ofagent'] : null;
						$html .= '<option '.selected( $current , $post->ID,false).' value="'.$post->ID.'">'.$post->post_title . ' ('. swh_count_property_by_agent( $post->ID ) .')'. '</option>';
					}
				$html .= '</select>';
			}
			wp_reset_postdata();wp_reset_query();
			return $html;
		}
				
	}
	new SWH_Taxonomy_Filter();
}