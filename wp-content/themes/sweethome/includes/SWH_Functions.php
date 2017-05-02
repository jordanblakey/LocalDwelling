<?php
if( !defined('ABSPATH') ) exit;
if( !function_exists('swh_post_nav') ){
	function swh_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
	
		if ( ! $next && ! $previous ) {
			return;
		}
	
		?>
		 <ul class="pager">
		 	<li class="previous"><?php previous_post_link( '%link', __( '&laquo;%title', 'swh' ) ) ?></li>
			<li class="next"><?php next_post_link( '%link', __( '%title&raquo;', 'swh' ) )?></li>
		</ul><!-- .nav-links -->
		<?php
	}
}
if( !function_exists('swh_count_property_by_agent') ){
	function swh_count_property_by_agent( $agent_ID ) {
		wp_reset_postdata();wp_reset_query();
		$wp_query = new WP_Query(array(
			'post_type'	=>	'property',
			'post_status'	=>	'publish',
			'meta_query'	=>	array(
				array(
					'key'=>'agent',
					'value'=> $agent_ID,
					'compare'=>'='
				)
			)
		));
		$found_post = $wp_query->found_posts;
		wp_reset_postdata();wp_reset_query();
		return $found_post;
	}
}

if( ! function_exists( 'sweethome_acf_google_map_api' ) ){
	/**
	 * @param unknown_type $api
	 * @return unknown
	 */
	function sweethome_acf_google_map_api( $api ){
	
		global $sweethome;
	
		$api['key'] = isset( $sweethome['gmap_api'] ) ? $sweethome['gmap_api'] : '';
	
		return $api;
	
	}
	
	add_filter('acf/fields/google_map/api', 'sweethome_acf_google_map_api');	
}

if( !function_exists( 'swh_bootstrap_link_pages' ) ){
	/**
	 * Link Pages
	 * @author toscha
	 * @link http://wordpress.stackexchange.com/questions/14406/how-to-style-current-page-number-wp-link-pages
	 * @param  array $args
	 * @return void
	 * Modification of wp_link_pages() with an extra element to highlight the current page.
	 */
	function swh_bootstrap_link_pages( $args = array () ) {
		$defaults = array(
			'before'      => '<p>' . __('Pages:','swh'),
			'after'       => '</p>',
			'before_link' => '',
			'after_link'  => '',
			'current_before' => '',
			'current_after' => '',
			'link_before' => '',
			'link_after'  => '',
			'pagelink'    => '%',
			'echo'        => 1
		);

		$r = wp_parse_args( $args, $defaults );
		$r = apply_filters( 'wp_link_pages_args', $r );
		extract( $r, EXTR_SKIP );

		global $page, $numpages, $multipage, $more, $pagenow;

		if ( ! $multipage )
		{
			return;
		}

		$output = $before;

		for ( $i = 1; $i < ( $numpages + 1 ); $i++ )
		{
			$j       = str_replace( '%', $i, $pagelink );
			$output .= ' ';

			if ( $i != $page || ( ! $more && 1 == $page ) )
			{
				$output .= "{$before_link}" . _wp_link_page( $i ) . "{$link_before}{$j}{$link_after}</a>{$after_link}";
			}
			else
			{
				$output .= "{$current_before}{$link_before}<a>{$j}</a>{$link_after}{$current_after}";
			}
		}

		print $output . $after;
	}
}
if( !function_exists('swh_social_profile') ){
	function swh_social_profile(){
		return array(
			'fa-google-plus'	=>	'Google Plus',
			'fa-facebook'	=>	'Facebook',
			'fa-twitter'	=>	'Twitter',
			'fa-instagram'	=>	'Instagram',
			'fa-tumblr'		=>	'Tumblr',
			'fa-linkedin'	=>	'Linkedin',
			'fa-flickr'		=>	'Flickr',
			'fa-weibo'		=>	'Weibo',
			'fa-pinterest'	=>	'Pinterest',
			'fa-youtube'	=>	'Youtube'
		);
	}
}
if( !function_exists('swh_wp_title') ){
	function swh_wp_title( $title, $sep ) {
		global $paged, $page;
		if ( is_feed() )
			return $title;

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'swh' ), max( $paged, $page ) );

		return $title;
	}
	add_filter( 'wp_title', 'swh_wp_title', 10, 2 );
}
if( !function_exists('swh_get_post_types') ){
	function swh_get_post_types( $post_types ){
		$post_types['post']	=	__('Post','swh');
		$post_types['property']	=	__('Property','swh');
		return apply_filters('swh_set_post_types', $post_types);
	}
}
if( !function_exists('swh_option_orders') ){
	function swh_option_orders(){
		return array(
			'DESC'	=>	__('DESC','swh'),
			'ASC'	=>	__('ASC','swh')
		);
	}	
}
if( !function_exists('swh_option_orderby') ){
	function swh_option_orderby( $post_type='post' ) {
		$orderby = array(
			'ID'	=>	__('Order by Post ID','swh'),
			'author'	=>	__('Order by author','swh'),
			'title'	=>	__('Order by title','swh'),
			'name'	=>	__('Order by Post name (Post slug)','swh'),
			'date'	=>	__('Order by date','swh'),
			'modified'	=>	__('Order by last modified date','swh'),
			'rand'	=>	__('Order by Random','swh'),
			'comment_count'	=>	__('Order by number of comments','swh'),
			'price'		=>	__('Price','swh')
		);
		return $orderby;
	}
}
if( !function_exists('swh_social_profiles') ){
	function swh_social_profiles( $socials_array ) {
		$socials_array = array(
			'fa-facebook'		=>	__('Facebook','swh'),
			'fa-google-plus'	=>	__('Google Plus','swh'),
			'fa-twitter'		=>	__('Twitter','swh'),
			'fa-pinterest'		=>	__('Pinterest','swh'),
			'fa-dribbble'		=>	__('Dribbble','swh'),
			'fa-linkedin'		=>	__('Linkedin','swh'),
			'fa-youtube'		=>	__('Youtube','swh')
		);
		return apply_filters('swh_social_profiles', $socials_array);
	}
}
	
if( !class_exists('SWH_Walker_Nav_Menu') ){
	class SWH_Walker_Nav_Menu extends Walker_Nav_Menu {
		function start_lvl(&$output, $depth = 0, $args = array()) {
			$output .= "\n<ul class=\"dropdown-menu\">\n";
		}
		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			$item_html = '';
			parent::start_el($item_html, $item, $depth, $args);

			if ( $item->is_dropdown && $depth === 0 ) {
				$item_html = str_replace( '<a', '<a class="dropdown-toggle" data-toggle="dropdown"', $item_html );
				//$item_html = str_replace( '<a', '<a', $item_html );
				$item_html = str_replace( '</a>', ' <b class="caret"></b></a>', $item_html );
			}

			$output .= $item_html;
		}
		function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
			if ( $element->current )
				$element->classes[] = 'active';

			$element->is_dropdown = !empty( $children_elements[$element->ID] );

			if ( $element->is_dropdown ) {
				if ( $depth === 0 ) {
					$element->classes[] = 'dropdown';
				} elseif ( $depth === 1 ) {
					// Extra level of dropdown menu,
					// as seen in http://twitter.github.com/bootstrap/components.html#dropdowns
					$element->classes[] = 'dropdown-submenu';
				}
			}
			parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
		}
	}
}
if( !function_exists('swh_avatar_class') ){
	function swh_avatar_class( $class ) {
		$class = str_replace("class='avatar", "class='media-object ", $class) ;
		return $class;
	}
	add_filter('get_avatar','swh_avatar_class');
}

if( !function_exists('swh_comments_list_callback') ){
	function swh_comments_list_callback( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
			<li <?php comment_class('media'); ?> id="comment-<?php comment_ID(); ?>">
				<a class="pull-left" href="<?php print get_comment_author_url();?>"><?php echo get_avatar( $comment, $args['avatar_size'] );?></a>
				<div class="media-body">
			<?php if ( get_option('woocommerce_enable_review_rating') == 'yes' && get_post_type( $comment->comment_post_ID ) == 'product' ) : ?>
				<?php $rating = esc_attr( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) );?>
				<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf(__( 'Rated %d out of 5', 'swh' ), $rating) ?>">
					<span style="width:<?php echo ( intval( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) ) / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo intval( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) ); ?></strong> <?php _e( 'out of 5', 'swh' ); ?></span>
				</div>
			<?php endif; ?>				
					<h4 class="media-heading"><?php comment_author_link(); ?> <span>/ <?php printf( __('%s ago','swh'), human_time_diff( get_comment_time('U'), current_time('timestamp') ));?></span></h4>
					<?php if( !is_singular('product') ):?>
						<?php comment_reply_link(array_merge( $args, array('add_below' => null, 'depth' => $depth, 'max_depth' => $args['max_depth'],'reply_text'=>'<i class="fa fa-reply"></i> '.__('Reply','swh')))) ?>
					<?php endif;?>
					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'swh' ); ?></p>
					<?php endif; ?>	
					<?php comment_text() ?>
				</div>
		<?php 
	}
}
if( !function_exists('swh_subscribe_form_handle') ){
	function swh_subscribe_form_handle() {
		$subscribe = isset( $_REQUEST['subscribe'] ) ?  $_REQUEST['subscribe'] : null;
		$email = isset( $_REQUEST['email'] ) ?  $_REQUEST['email'] : null;
		if( wp_verify_nonce( $subscribe,'subscribe_act' ) && is_email( $email ) ){
			$user_id = wp_insert_user(array(
				'user_login'	=>	$_REQUEST['email'],
				'user_email'	=>	$_REQUEST['email'],
				'user_pass'		=>	wp_generate_password(6)
			));
		}
	}
	add_action('init', 'swh_subscribe_form_handle');
}
if( !function_exists('swh_filter_body_class') ){
	function swh_filter_body_class( $classes ) {
		$classes[] = 'blog-page';
		if( is_singular('property') ){
			$classes[] = 'property-details-page';
		}
		if( is_single() ){
			$classes[] = 'single-page';
		}
		return $classes;
	}
	add_filter('body_class', 'swh_filter_body_class');
}
if( !function_exists('swh_filter_post_class') ){
	function swh_filter_post_class( $classes ) {
		if( is_singular('agent') ){
			$classes[] = 'agent-post';
		}
		return $classes;
	}
	add_filter('post_class', 'swh_filter_post_class');
}

if( !function_exists('swh_filter_tag_cloud') ){
	function swh_filter_tag_cloud( $args ) {
		$args['format'] = 'list';
		$args['smallest'] = 8;
		$args['largest'] = 15;
		return $args;
	}
	add_filter( 'widget_tag_cloud_args', 'swh_filter_tag_cloud' );
}

if( !function_exists('swh_filter_property_featured') ){
	/**
	 * Get featured property
	 * @param array $query
	 */
	function swh_filter_property_featured( $query ){
		$featured = isset( $_GET['featured'] ) ? (int)$_GET['featured'] : 0;
		if( is_post_type_archive( 'property' ) && $featured == 1 && $query->is_main_query() ){
			$query->set('meta_query',array(
				array(
					'key'=>'featured',
					'value'=> 1,
					'compare'=>'='
				)
			));			
		}
		return $query;
	}
	add_filter('pre_get_posts', 'swh_filter_property_featured',20,1);
}
if( !function_exists('swh_filter_property_agent') ){
	/**
	 * Get all the property of this Agent
	 * @param array $query
	 */
	function swh_filter_property_agent( $query ){
		$agent = isset( $_GET['ofagent'] ) ? (int)$_GET['ofagent'] : null;
		if( !is_admin() && is_post_type_archive( 'property' ) && $agent != '' && $query->is_main_query() ){
			$query->set('meta_query',array(
				array(
					'key'=>'agent',
					'value'=> strip_tags( $_GET['ofagent'] ),
					'compare'=>'='
				)
			));
		}
		return $query;
	}
	add_filter('pre_get_posts', 'swh_filter_property_agent',30,1);
}
if( !function_exists('swh_filter_property_search') ){
	function swh_filter_property_search( $query ) {
		$propertys = isset( $_GET['propertys'] ) ? trim( $_GET['propertys'] ) : null;
		if( !is_admin() && is_post_type_archive( 'property' ) && wp_verify_nonce( $propertys,'propertys_act' ) && $query->is_main_query() ){
			$tax_data = array();
			$taxonomies = get_object_taxonomies( 'property' );
			if( !empty( $taxonomies ) ){
				for ( $i = 0;  $i < count( $taxonomies );  $i++) {
					if( !empty( $_GET[ 'var_'. $taxonomies[$i] ] ) ){
						$tax_data[] = array(
							'taxonomy' => $taxonomies[$i],
							'field' => 'id',
							'terms' => array( (int) $_GET[ 'var_'. $taxonomies[$i] ] )
						);
					}
				}
			}
			$query->set( 'tax_query', $tax_data );
			### meta query	
			$meta_query = array(	
				'relation' => 'AND',
			);
			if( !empty( $_GET['sq_ft'] ) && $_GET['sq_ft'] != 'any' ){
				$meta_query[] = array(
					'key'=>'sq_ft',
					'value'=> (int)$_GET['sq_ft'],
					'compare'=>'=',
					'type' => 'NUMERIC'
				);
			}
			if( !empty( $_GET['bathrooms'] ) && $_GET['bathrooms'] != 'any' ){
				$meta_query[] = array(
					'key'=>'bathrooms',
					'value'=> (int)$_GET['bathrooms'],
					'compare'=>'=',
					'type' => 'NUMERIC'
				);
			}
			if( !empty( $_GET['bedrooms'] ) && $_GET['bedrooms'] != 'any' ){
				$meta_query[] = array(
					'key'=>'bedrooms',
					'value'=> (int)$_GET['bedrooms'],
					'compare'=>'=',
					'type' => 'NUMERIC'
				);				
			}
			if( !empty( $_GET['garages'] ) && $_GET['garages'] != 'any' ){
				$meta_query[] = array(
					'key'=>'garages',
					'value'=> (int)$_GET['garages'],
					'compare'=>'=',
					'type' => 'NUMERIC'
				);				
			}
			if( !empty( $_GET['minprice'] ) && $_GET['minprice'] != 'any' ){
				$meta_query[] = array(
					'key'=>'price',
					'value'=> (int)$_GET['minprice'],
					'compare'=>'>=',
					'type' => 'NUMERIC'
				);				
			}
			if( !empty( $_GET['maxprice'] ) && $_GET['maxprice'] != 'any' ){
				$meta_query[] = array(
					'key'=>'price',
					'value'=> (int)$_GET['maxprice'],
					'compare'=>'<=',
					'type' => 'NUMERIC'
				);				
			}
			$query->set( 'meta_query', $meta_query );
		}

		return $query;
	}
	add_filter('pre_get_posts', 'swh_filter_property_search',10,1);
}

if( !function_exists('swh_content_nav') ){
	function swh_content_nav() {
		$output = '';
		global $wp_query;
		if ( $wp_query->max_num_pages > 1 ){
				$output .= '<div class="pagination-wrapper">';
					$output .= get_the_posts_pagination( array(
						'type'				=>	'list',
						'mid_size'			=>	2,
						'prev_text'			=> __( 'Previous', 'swh' ),
						'next_text'         => __( 'Next', 'swh' )
					) );
				$output .= '</div>';
		}
		if( ! empty( $output ) ){
			$output = str_ireplace( 'page-numbers' , 'page-numbers pagination' , $output );
			print  $output; 
		}
	}
}

if( !function_exists('swh_get_property_price') ){
	function swh_get_property_price( $post_id, $format = NULL ) {
		$price = get_post_meta( $post_id, 'price', true ) ? get_post_meta( $post_id, 'price', true ) : SWH_NA;
		if( $price > 0 )
			return swh_price_format( $price );
		return $price;
	}
}

if( !function_exists('swh_price_format') ){
	function swh_price_format( $number = null ){
		global $sweethome;
		$currency = $sweethome['currency'] ? $sweethome['currency'] : '$';
		$thousand_separator = $sweethome['thousand_separator'] ? $sweethome['thousand_separator'] : ',';
		$decimal_separator = $sweethome['decimal_separator'] ? $sweethome['decimal_separator'] : '.';
		
		$price_format = number_format( (int)$number, 0, $decimal_separator, $thousand_separator );
		if( $sweethome['currency_position'] =='left' ){
			return $currency . $price_format;
		}
		else{
			return $price_format . $currency;
		}
	}	
}

if( !function_exists('swh_bbg_dropdown_numbers') ){
	function swh_bbg_dropdown_numbers( $id, $selector = NULL ) {
		$html = '<select class="elselect" id="'.$id.'" name="'.$id.'">';
			$html .= '<option value="any">'.__('Any','swh').'</option>';
			for ( $i=0; $i <= count( $selector ); $i++ ){
				$current = isset( $_GET[ $id ] ) ? $_GET[ $id ] : null;
				if( !empty( $selector[$i] ) ){
					
					if( $id == 'minprice' || $id == 'maxprice' ){
						$html .= '<option '.selected( $current, $selector[$i] , false).' value="'.$selector[$i].'">'. swh_price_format( $selector[$i] ) .'</option>';
					}
					else{
						$html .= '<option '.selected( $current, $selector[$i] , false).' value="'.$selector[$i].'">'.$selector[$i].'</option>';
					}
				}
			}
		$html .= '</select>';
		return $html;
	}
}

if( !function_exists('swh_property_meta_array') ){
	function swh_property_meta_array() {
		return array(
			'sq_ft'	=>	__('Sq ft','swh'),
			'bathrooms'	=>	__('Bathrooms','swh'),
			'bedrooms'	=>	__('Bedrooms','swh'),
			'garages'	=>	__('Garages','swh'),
			'minprice'	=>	__('Min Price','swh'),
			'maxprice'	=>	__('Max Price','swh')
		);
	}
}

if( !function_exists('swh_ptype_taxonomy_add_class_field') ){
	function swh_ptype_taxonomy_add_class_field() {
		?>
		<div class="form-field">
			<label for="term_meta[swh_css_class]"><?php _e( 'Put the Class name', 'swh' ); ?></label>
			<input type="text" name="term_meta[swh_css_class]" id="term_meta[swh_css_class]" value="">
			<p class="description"><?php _e( 'example: fa-home or fa-building-o','swh' ); ?></p>
		</div>
	<?php
	}
	add_action( 'ptype_add_form_fields', 'swh_ptype_taxonomy_add_class_field', 10, 2 );	
}

if( !function_exists('swh_ptype_taxonomy_edit_meta_field') ){
	function swh_ptype_taxonomy_edit_meta_field($term) {
	
		// put the term ID into a variable
		$t_id = $term->term_id;
	
		// retrieve the existing value(s) for this meta field. This returns an array
		$term_meta = get_option( "taxonomy_$t_id" ); ?>
		<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[swh_css_class]"><?php _e( 'Put the Class name', 'swh' ); ?></label></th>
			<td>
				<input type="text" name="term_meta[swh_css_class]" id="term_meta[swh_css_class]" value="<?php echo esc_attr( $term_meta['swh_css_class'] ) ? esc_attr( $term_meta['swh_css_class'] ) : ''; ?>">
				<p class="description"><?php _e( 'example: fa-home or fa-building-o','swh' ); ?></p>
			</td>
		</tr>
	<?php
	}
	add_action( 'ptype_edit_form_fields', 'swh_ptype_taxonomy_edit_meta_field', 10, 2 );
}

if( !function_exists('swh_save_ptype_taxonomy_cssclass') ){
	function swh_save_ptype_taxonomy_cssclass( $term_id ) {
		if ( isset( $_POST['term_meta'] ) ) {
			$t_id = $term_id;
			$term_meta = get_option( "taxonomy_$t_id" );
			$cat_keys = array_keys( $_POST['term_meta'] );
			foreach ( $cat_keys as $key ) {
				if ( isset ( $_POST['term_meta'][$key] ) ) {
					$term_meta[$key] = $_POST['term_meta'][$key];
				}
			}
			// Save the option array.
			update_option( "taxonomy_$t_id", $term_meta );
		}
	}
	add_action( 'edited_ptype', 'swh_save_ptype_taxonomy_cssclass', 10, 2 );
	add_action( 'create_ptype', 'swh_save_ptype_taxonomy_cssclass', 10, 2 );	
}

if( !function_exists('swh_breadcrumb_wp_title') ){
	function swh_breadcrumb_wp_title() {
 		if( function_exists('bcn_display') ){
			bcn_display();
		} 
	}
}

if( !function_exists('swh_current_pagename') ){
	function swh_current_pagename() {
		global $post, $wp_query;
		if( is_home() || is_front_page() ){
			return get_bloginfo('name');
		}
		elseif( is_page() || is_single() ){
			return $post->post_title;
		}
		elseif( is_category() || is_tag() || is_tax() ){
			return $wp_query->get_queried_object()->name;
		}
		elseif( is_post_type_archive('property') ){
			return __('Property listing','swh');
		}
		elseif( is_post_type_archive('agent') ){
			return __('Our agents','swh');
		}
		elseif( is_author() ){
			return $wp_query->queried_object->data->display_name;
		}
		elseif( is_search() ){
			return __('Browsing Search','swh');
		}
		elseif( is_day() ){
			return sprintf( __( 'Daily Archives: <span>%s</span>', 'swh' ), get_the_date() );
		}
		elseif( is_month() ){
			return sprintf( __( 'Monthly Archives: <span>%s</span>', 'swh' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'swh' ) ) );
		}
		elseif( is_year() ){
			return sprintf( __( 'Yearly Archives: <span>%s</span>', 'swh' ), get_the_date( _x( 'Y', 'yearly archives date format', 'swh' ) ) );
		}
		elseif( is_tax() ){
			return $wp_query->queried_object->name;
		}
		elseif ( is_404() ){
			return __('404 Error','swh');
		}
		elseif( class_exists('Woocommerce') && function_exists('is_shop') && is_shop() ){
			return __('Shop','swh');
		}
	}
}

if( !function_exists('swh_header_background') ){
	function swh_header_background() {
		global $sweethome;
		if( !empty( $sweethome['header_bg']['url'] ) ){
			print '<style>.page-title-section{background-image:url("'.$sweethome['header_bg']['url'].'")!important;}</style>';
		}
	}
	//add_action('wp_footer', 'swh_header_background');
}
if( !function_exists('swh_show_favicon') ){
	function swh_show_favicon() {
		global $sweethome;
		if( !empty( $sweethome['favicon']['url'] ) ){
			print '<link rel="shortcut icon" href="'.$sweethome['favicon']['url'].'">';
		}
	}
	add_action('wp_head', 'swh_show_favicon');
}
if( !function_exists('swh_custom_css') ){
	function swh_custom_css() {
		global $sweethome;
		$css = NULL;
		if( !empty( $sweethome['custom_css'] ) ){
			$css = '<style>'.$sweethome['custom_css'].'</style>';
		}
		print $css;
	}
	add_action('wp_head', 'swh_custom_css');
}
if( !function_exists('swh_custom_js') ){
	function swh_custom_js() {
		global $sweethome;
		$js = NULL;
		if(!empty( $sweethome['custom_js'] ) ){
			$js .= '<script>jQuery(document).ready(function($){'.$sweethome['custom_js'].'});</script>';
		}
		print $js;
	}
	add_action('wp_footer', 'swh_custom_js');
}
if( !function_exists('swh_google_analytics') ){
	function swh_google_analytics() {
		global $sweethome;
		if( !empty( $sweethome['google-analytics'] ) ){
			$code = trim( $sweethome['google-analytics'] );
			print '
			<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push([\'_setAccount\', \''.$code.'\']);
			_gaq.push([\'_trackPageview\']);
			(function() {
			var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
			ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
			var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
		})();
		</script>
		';
		}
	}
	add_action('wp_footer', 'swh_google_analytics');
}
if( !function_exists('swh_search_query') ){
	function swh_search_query($query) {
		if ($query->is_search && $query->is_main_query()) {
			$query->set('post_type', array( 'post'));
		}
		return $query;
	}
	//add_filter('pre_get_posts','swh_search_query');	
}