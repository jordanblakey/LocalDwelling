<?php
if( !defined('ABSPATH') ) exit;
if( !function_exists('SWH_Widget_PropertySearch') ){
	function SWH_Widget_PropertySearch() {
		register_widget('SWH_Widget_PropertySearch_Class');
	}
	add_action('widgets_init', 'SWH_Widget_PropertySearch');
}
class SWH_Widget_PropertySearch_Class extends WP_Widget{
	var $post_type = 'property';
	
	function __construct(){
		$widget_ops = array( 'classname' => 'swh-propertysearch-widget', 'description' => __('SWH Property Search Form', 'swh') );
	
		parent::__construct( 'swh-propertysearch-widget' , __('SWH Property Search', 'swh') , $widget_ops);
	}	
	
	function widget($args, $instance){
		extract( $args );
		$html = null;
		$title = apply_filters('widget_title', isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : null );
		$taxonomies = get_object_taxonomies( $this->post_type );
		if( !empty( $taxonomies ) ){
			$html .= '
				<div class="search-section">
					<div class="container">
						<form action="'.get_post_type_archive_link( $this->post_type ).'" method="get" name="property-search" id="property-search">			
			';
					
			for ( $i = 0;  $i < count( $taxonomies );  $i++) {
				$on = $instance[$taxonomies[$i]] == 'on' ? $instance[$taxonomies[$i]] : null;
				$taxonomy = get_taxonomy( $taxonomies[$i] );
				$taxonomy_label = $instance[ 'label_'. $taxonomies[$i] ] ? $instance[ 'label_'. $taxonomies[$i] ] : $taxonomy->labels->name;
				$taxonomy_args = array(
					'show_option_all'    => __('Any','swh'),
					'orderby'            => 'ID', 
					'order'              => 'ASC',
					'hide_empty'         => 0, 
					'echo'               => 0,
					'selected'           => isset( $_GET[ 'var_'. $taxonomies[$i] ] ) ? $_GET[ 'var_'. $taxonomies[$i] ] : null,
					'hierarchical'       => 0, 
					'name'               => 'var_'. $taxonomies[$i],
					'id'                 => 'var_'. $taxonomies[$i],
					'class'              => 'elselect',
					'depth'              => 0,
					'tab_index'          => 0,
					'taxonomy'           => $taxonomies[$i],
					'hide_if_empty'      => false

				);
				if( $taxonomies[$i]!='property_tag' && $on =='on'){
					$html .= '
						<div class="select-wrapper select-small" id="select-'.$taxonomies[$i].'">
							<p>'.$taxonomy_label.'</p>
							'.wp_dropdown_categories($taxonomy_args).'
						</div>
					';
				}	
			}
			### meta
				
			foreach ( swh_property_meta_array() as $key=>$value ){
				$label = isset( $instance[ 'label_'.$key ] )  ? trim( $instance[ 'label_'.$key ] ) : $value;
				$selector = isset( $instance[ 'selector_'.$key ] ) ? explode(",",  $instance[ 'selector_'.$key ] ) : array('1','2','3','4','5','6','7','8','9');
				$meta_on = isset( $instance[ $key ] ) ? 'on' : 'off';
				if( $meta_on == 'on' ): 
					$html .= '
						<div class="select-wrapper select-small" id="select-'.$key.'">
							<p>'.$label.'</p>
							'.swh_bbg_dropdown_numbers( $key, $selector ).'
						</div>
					';
				endif;
			}
			
			$html .= '<input type="submit" value="'.__('Search','swh').'" class="yellow-btn">';
						if( !get_option('permalink_structure') ){
							$html .= '<input type="hidden" name="post_type" value="'.$this->post_type.'">';
						}
						$html .= function_exists( 'swh_add_searchfields_form' ) ? swh_add_searchfields_form() : '';
						$html .= wp_nonce_field('propertys_act','propertys',null,false);
						$html .= '
						</form>
					</div>
				</div>
			';
		}
		print $html;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : null;
		$taxonomies = get_object_taxonomies( $this->post_type );
		if( !empty( $taxonomies ) ){
			for ( $i = 0;  $i < count( $taxonomies );  $i++){
				$taxonomy = get_taxonomy( $taxonomies[$i] );
				$instance[$taxonomies[$i]] = $new_instance[$taxonomies[$i]];
				$instance['label_'.$taxonomies[$i]] = $new_instance['label_'.$taxonomies[$i]];
			}
		}	
		
		foreach ( swh_property_meta_array() as $key=>$value ){
			$instance[$key] = $new_instance[$key];
			$instance['label_'.$key] = $new_instance['label_'.$key];
			$instance['selector_'.$key] = $new_instance['selector_'.$key];
		}
		
		return $instance;
		
	}
	function form( $instance ){	
		//$instance = wp_parse_args( (array) $instance, $defaults );
		$taxonomies = get_object_taxonomies( $this->post_type );
		if( !empty( $taxonomies ) ){
			for ( $i = 0;  $i < count( $taxonomies );  $i++) {
				if( isset( $taxonomies[$i] ) ):
					$taxonomy = get_taxonomy( $taxonomies[$i] );
					$instance_tax_onoff = isset( $instance[$taxonomies[$i]] ) ? 'on' : 'off';
					$label = isset( $instance[ 'label_'.$taxonomies[$i] ] ) ? $instance[ 'label_'.$taxonomies[$i] ] : $taxonomy->labels->name;
					?>			
					<p> 
					    <label for="<?php echo $this->get_field_id( $taxonomies[$i] ); ?>"><?php print $taxonomy->labels->name;?></label>
					    <input type="checkbox" <?php checked('on', $instance_tax_onoff,true);?> name="<?php print $this->get_field_name( $taxonomies[$i] );?>" id="<?php print $this->get_field_id( $taxonomies[$i] );?>">
					    <br/>
					    <label for="<?php echo $this->get_field_id( $taxonomies[$i] ); ?>"><?php _e('Label','swh');?></label>
					    <input value="<?php print $label;?>" class="swh-dropdown" type="text" value="" id="<?php echo $this->get_field_id( 'label_'. $taxonomies[$i] ); ?>" name="<?php print $this->get_field_name( 'label_'.$taxonomies[$i] );?>">
					</p>
					<?php
				endif;
			}
		}
		### meta
		foreach ( swh_property_meta_array() as $key=>$value ){
			$label = isset( $instance[ 'label_'.$key ] ) ? $instance[ 'label_'.$key ] : $value;
			$option_on_off = isset( $instance[$key] ) ? 'on' : 'off';
			$selector_value = !empty( $instance[ 'selector_'.$key ] ) ? $instance[ 'selector_'.$key ] : null;
			?>
			<p>  
			    <label><?php print $value;?></label>
			    <input type="checkbox" <?php checked('on', $option_on_off,true);?> name="<?php print $this->get_field_name( $key );?>" id="<?php print $this->get_field_id( $key );?>"><br/>
				<label><?php _e('Label','swh');?></label>
			    <input class="swh-dropdown" value="<?php print $label;?>" class="swh-dropdown" type="text" value="" id="<?php echo $this->get_field_id( 'label_'. $key ); ?>" name="<?php print $this->get_field_name( 'label_'.$key);?>">
			    <label><?php _e('Selector','swh');?></label>
			    <textarea class="swh-dropdown" name="<?php echo $this->get_field_name( 'selector_'.$key ); ?>" id="<?php echo $this->get_field_id( 'selector_'.$key ); ?>"><?php print $selector_value;?></textarea>
			</p>
			<?php
		}		
	}	
}