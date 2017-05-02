<?php
if( !defined('ABSPATH') ) exit;
if( !function_exists('SWH_Widget_Tabbed_Posts') ){
	function SWH_Widget_Tabbed_Posts() {
		register_widget('SWH_Widget_Tabbed_Posts_Class');
	}
	add_action('widgets_init', 'SWH_Widget_Tabbed_Posts');
}
class SWH_Widget_Tabbed_Posts_Class extends WP_Widget{
	
	function __construct(){
		$widget_ops = array( 'classname' => 'tabbed-content', 'description' => __('Displays the Tabbed Posts/Property', 'swh') );
	
		parent::__construct( 'swh-tabbed-content' , __('SWH Tabbed Posts/Property', 'swh') , $widget_ops);
	}	
	
	function widget($args, $instance){
		extract( $args );
		wp_reset_postdata();wp_reset_query();
		$title = apply_filters('widget_title', esc_attr( $instance['title'] ) );
		
		### get tab show option.
		$show_popular = isset( $instance['show_popular'] ) ? esc_attr( $instance['show_popular'] ) : null;
		$show_recent = isset( $instance['show_recent'] ) ? esc_attr( $instance['show_recent'] ) : null;
		$show_comment = isset( $instance['show_comment'] ) ? esc_attr( $instance['show_comment'] ) : null;
		
		$post_type = isset( $instance['post_type'] ) ? esc_attr( $instance['post_type'] ) : 'post';
		$sticky = isset( $instance['sticky'] ) ? esc_attr( $instance['sticky'] ) : null;
		$limit = isset( $instance['limit'] ) ? absint( $instance['limit'] ) : 5;
		
		$popular_orderby = isset( $instance['popular_orderby'] ) ? esc_attr( $instance['popular_orderby'] ) : 'ID';
		$popular_order = isset( $instance['popular_order'] ) ? esc_attr( $instance['popular_order'] ) : 'DESC';

		$recent_orderby = isset( $instance['recent_orderby'] ) ? esc_attr( $instance['recent_orderby'] ) : 'ID';
		$recent_order = isset( $instance['recent_order'] ) ? esc_attr( $instance['recent_order'] ) : 'DESC';		
		
		###  popular post.
		$wp_array_popular = null;
		$wp_array_recent = null;
		$wp_array = array(
			'post_type'	=>	$post_type,
			'post_status'	=>	'publish',
			'showposts'	=>	$limit,
			'ignore_sticky_posts'	=>	1
		);
		$taxonomies = get_object_taxonomies( $post_type );
		print  $before_widget;
		print $before_title . $title . $after_title;
		
		?>
			<ul class="nav nav-tabs" id="myTab">
				<?php if( $show_popular ):?>
					<li><a href="#popular" data-toggle="tab"><?php _e('Popular','swh')?></a></li>
				<?php endif;?>
				<?php if( $show_recent ):?>
					<li><a href="#recent" data-toggle="tab"><?php _e('Recent','swh')?></a></li>
				<?php endif;?>
				<?php if( $show_comment ):?>
					<li><a href="#comments" data-toggle="tab"><?php _e('Comments','swh');?></a></li>
				<?php endif;?>
			</ul>
			<div class="tab-content">
				<?php if( $show_popular ):?>
					<?php 
						wp_reset_postdata();wp_reset_query();
						$wp_array_popular = $wp_array;
						$wp_array_popular['orderby']	=	$popular_orderby;
						$wp_array_popular['order']	=	$popular_order;
						### check sticky/featured post.
						if( $sticky ){
							if( $post_type == 'post' ){
								$wp_array_popular['ignore_sticky_posts'] = 0;
							}
							elseif( $post_type == 'property' ){
								$wp_array_popular['meta_query'] = array(
									array(
										'key'=>'featured',
										'value'=> 1,
										'compare'=>'='
									)
								);	
							}
						}
						### check taxonomy.
						if( !empty( $taxonomies ) ){
							for ( $i = 0;  $i < count( $taxonomies );  $i++) {
								$taxonomy = get_taxonomy( $taxonomies[$i] );
								$instance_tax = $instance[ 'popular_'.$taxonomies[$i] ];
								if( $instance_tax ){
									$wp_array_popular['tax_query'][] = array(
										'taxonomy' => $taxonomies[$i],
										'field' => 'id',
										'terms' => array((int)$instance_tax)
									);
								}
							}
						}
						$wp_query_popular = new WP_Query( $wp_array_popular );
					?>
					<?php if( $wp_query_popular->have_posts() ) :?>
					<div class="tab-pane fade in" id="popular">
						<ul class="tab-content-wrapper">
							<?php while ( $wp_query_popular->have_posts() ) : $wp_query_popular->the_post();?>
								<li class="tab-content-item">
									<?php if(has_post_thumbnail()):?>
										<div class="pull-left thumb">
											<a href="<?php the_permalink();?>"><?php print get_the_post_thumbnail(null,'thumbnail', array('class'=>'property-thumbnail-50-50'));?></a>
										</div>
									<?php endif;?>
									<h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
								</li>
							<?php endwhile;?>
						</ul>
					</div>
					<?php endif;?>
				<?php endif;wp_reset_postdata();wp_reset_query();?>
				<?php if( $show_recent ):?>
					<?php 
					wp_reset_postdata();wp_reset_query();
					$wp_array_recent = $wp_array;
					$wp_array_recent['orderby']	=	$recent_orderby;
					$wp_array_recent['order']	=	$recent_order;
					$wp_array_recent['ignore_sticky_posts'] = 1;
					### check taxonomy.
					if( !empty( $taxonomies ) ){
						for ( $i = 0;  $i < count( $taxonomies );  $i++) {
							$taxonomy = get_taxonomy( $taxonomies[$i] );
							$instance_tax = $instance[ 'recent_'.$taxonomies[$i] ];
							if( $instance_tax ){
								$wp_array_recent['tax_query'][] = array(
									'taxonomy' => $taxonomies[$i],
									'field' => 'id',
									'terms' => array((int)$instance_tax)
								);
							}
						}
					}
					$wp_query_recent = new WP_Query( $wp_array_recent );
					?>
					<?php if( $wp_query_recent->have_posts() ):?>
						<div class="tab-pane fade" id="recent">
							<ul class="tab-content-wrapper">
								<?php while ( $wp_query_recent->have_posts() ) : $wp_query_recent->the_post();?>
									<li class="tab-content-item">
										<?php if(has_post_thumbnail()):?>
											<div class="pull-left thumb">
												<a href="<?php the_permalink();?>"><?php print get_the_post_thumbnail(null,'thumbnail', array('class'=>'property-thumbnail-50-50'));?></a>
											</div>
										<?php endif;?>
										<h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
									</li>
								<?php endwhile;?>
							</ul>
						</div>
					<?php endif;?>
				<?php endif;?>
				<?php if( $show_comment ):?>
				<div class="tab-pane fade" id="comments">
					 <?php
						$defaults = array(
							'order' => 'DESC',
							'post_status' => 'publish',
							'post_type' => $post_type,
							'status' => 'approve',
							'number'	=>	$limit
						);				 
					 	$comments = get_comments( $defaults );
					 	if( $comments ):
					 ?>
						<ul class="tab-content-wrapper">
							<?php foreach ( $comments as $comment ):?>
								<li class="tab-content-item">
									<div class="pull-left thumb">
										<?php print get_avatar( $comment->user_id, 50 );?>
									</div>
									<h5><a href="<?php print get_comment_link( $comment );?>"><?php print wp_trim_words($comment->comment_content, 15, __('...','swh'));?></a></h5>
								</li>
							<?php endforeach;?>
						</ul>
						<?php endif;?>
				</div>
				<?php endif;?>
			</div>
		<?php 
		print $after_widget;		
		wp_reset_postdata();wp_reset_query();
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post_type'] = $new_instance['post_type'];
		
		$taxonomies = get_object_taxonomies( $new_instance['post_type'] );
		if( !empty( $taxonomies ) ){
			for ( $i = 0;  $i < count( $taxonomies );  $i++){
				$taxonomy = get_taxonomy( $taxonomies[$i] );
				$instance['popular_'.$taxonomies[$i]] = $new_instance['popular_'.$taxonomies[$i]];
				$instance['recent_'.$taxonomies[$i]] = $new_instance['recent_'.$taxonomies[$i]];
			}
		}		
		
		$instance['sticky']	=	$new_instance['sticky'];
		
		$instance['popular_order'] = $new_instance['popular_order'];
		$instance['popular_orderby'] = $new_instance['popular_orderby'];
		$instance['limit'] = $new_instance['limit'];
		
		
		$instance['recent_order'] = $new_instance['recent_order'];
		$instance['recent_orderby'] = $new_instance['recent_orderby'];
		
		$instance['show_popular']	=	$new_instance['show_popular'];
		$instance['show_recent']	=	$new_instance['show_recent'];
		$instance['show_comment']	=	$new_instance['show_comment'];
		
		return $instance;
	}
	function form( $instance ){
		global $sweethome;
		$defaults = array(
			'title' => __('Tabbed Widget', 'swh'),
			'post_type'	=>	'post',
			'sticky'	=>	'off',
			'show_popular'	=>	'on',
			'show_recent'	=>	'on',
			'show_comment'	=>	'on',
			'popular_order'	=>	'DESC',
			'popular_orderby'	=>	'ID',
			'limit'	=>	5,
			'recent_order'	=>	'DESC',
			'recent_orderby'	=>	'ID',
		);
		$post_type = isset( $instance['post_type'] ) ? $instance['post_type'] : 'post';
		$taxonomies = get_object_taxonomies( $post_type );
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'swh'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo !empty( $instance['title'] ) ? esc_attr( $instance['title'] ) : NULL; ?>" style="width:100%;" />
			</p>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e('Post Type:', 'swh'); ?></label>
			    <select style="width:100%;" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
			    	<?php 
			    		foreach ( swh_get_post_types(null) as $key=>$value ){
			    			$selected = ( $instance['post_type'] == $key ) ? 'selected' : null;
			    			?>
			    				<option <?php print $selected; ?> value="<?php print $key;?>"><?php print $value;?></option>
			    			<?php 
			    		}
			    	?>
			    </select>  
			</p>
			<h3 style="border-bottom: 2px solid hsl(0, 0%, 94%);"><?php _e('Popular Posts Tab','swh')?></h3>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'show_popular' ); ?>"><?php _e('Show:', 'swh'); ?></label>
			    <input type="checkbox" <?php checked('on', $instance['show_popular'], true);?> id="<?php echo $this->get_field_id( 'show_popular' ); ?>" name="<?php echo $this->get_field_name( 'show_popular' ); ?>"/>
			    <small><?php _e('Displaying Popular tab.','swh');?></small>
			</p>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'sticky' ); ?>"><?php _e('Featured:', 'swh'); ?></label>
			    <input type="checkbox" <?php checked('on', $instance['sticky'], true);?> id="<?php echo $this->get_field_id( 'sticky' ); ?>" name="<?php echo $this->get_field_name( 'sticky' ); ?>"/>
			    <small><?php _e('The featured is known as the Property Featured or The Sticky Post, depend in the Post Type.','swh');?></small>
			</p>			
		
			<?php 
			if( !empty( $taxonomies ) ){
				for ( $i = 0;  $i < count( $taxonomies );  $i++) {
					$taxonomy = get_taxonomy( $taxonomies[$i] );
					//print_r( $taxonomy->hierarchical );
					?>
						<p> 
						    <label for="<?php echo $this->get_field_id( 'popular_'.$taxonomies[$i] ); ?>"><?php print $taxonomy->labels->name;?></label>
						    <?php if( $taxonomy->hierarchical == 1 ):?>
					    	<?php 
								wp_dropdown_categories($args = array(
										'show_option_all'    => 'All',
										'orderby'            => 'ID', 
										'order'              => 'ASC',
										'show_count'         => 1,
										'hide_empty'         => 1, 
										'child_of'           => 0,
										'echo'               => 1,
										'selected'           => isset( $instance['popular_'.$taxonomies[$i]] ) ? $instance['popular_'.$taxonomies[$i]] : null,
										'hierarchical'       => 0, 
										'name'               => $this->get_field_name( 'popular_'.$taxonomies[$i] ),
										'id'                 => $this->get_field_id( 'popular_'.$taxonomies[$i] ),
										'taxonomy'           => $taxonomies[$i],
										'hide_if_empty'      => true,
										'class'              => 'regular-text sweethome-dropdown',
						    		)
					    		);
					    		else:
					    		?>
					    			<input id="<?php echo $this->get_field_id( 'popular_'.$taxonomies[$i] ); ?>" name="<?php echo 'popular_'.$this->get_field_name( 'popular_'.$taxonomies[$i] ); ?>" value="<?php echo !empty( $instance['popular_'.$taxonomies[$i]] ) ? $instance['popular_'.$taxonomies[$i]] : NULL; ?>" style="width:100%;" />
					    			<small><?php printf( __('Put the %s slug, separated by a common(,)','swh') , $taxonomy->labels->name );?></small>
					    		<?php 
					    		endif;					    		
					    	?>
						</p>
					<?php
				}
			}
			?>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'popular_orderby' ); ?>"><?php _e('Orderby:', 'swh'); ?></label>
			    <select style="width:100%;" id="<?php echo $this->get_field_id( 'popular_orderby' ); ?>" name="<?php echo $this->get_field_name( 'popular_orderby' ); ?>">
			    	<?php 
			    		foreach ( swh_option_orderby() as $key=>$value ){
			    			$selected = ( $instance['popular_orderby'] == $key ) ? 'selected' : null;
			    			?>
			    				<option <?php print $selected; ?> value="<?php print $key;?>"><?php print $value;?></option>
			    			<?php 
			    		}
			    	?>
			    </select>  
			</p>			
			<p>  
			    <label for="<?php echo $this->get_field_id( 'popular_order' ); ?>"><?php _e('Order:', 'swh'); ?></label>
			    <select style="width:100%;" id="<?php echo $this->get_field_id( 'popular_order' ); ?>" name="<?php echo $this->get_field_name( 'popular_order' ); ?>">
			    	<?php 
			    		foreach ( swh_option_orders() as $key=>$value ){
			    			$selected = ( $instance['popular_order'] == $key ) ? 'selected' : null;
			    			?>
			    				<option <?php print $selected; ?> value="<?php print $key;?>"><?php print $value;?></option>
			    			<?php 
			    		}
			    	?>
			    </select>  
			</p>
			<hr>
			<h3 style="border-bottom: 2px solid hsl(0, 0%, 94%);"><?php _e('Recent Posts Tab','swh')?></h3>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'show_recent' ); ?>"><?php _e('Show:', 'swh'); ?></label>
			    <input type="checkbox" <?php checked('on', $instance['show_recent'], true);?> id="<?php echo $this->get_field_id( 'show_recent' ); ?>" name="<?php echo $this->get_field_name( 'show_recent' ); ?>"/>
			    <small><?php _e('Displaying Recent tab.','swh');?></small>
			</p>			
			<?php 
			if( !empty( $taxonomies ) ){
				for ( $i = 0;  $i < count( $taxonomies );  $i++) {
					$taxonomy = get_taxonomy( $taxonomies[$i] );
					//print_r( $taxonomy->hierarchical );
					?>
						<p> 
						    <label for="<?php echo $this->get_field_id( 'recent_'.$taxonomies[$i] ); ?>"><?php print $taxonomy->labels->name;?></label>
						    <?php if( $taxonomy->hierarchical == 1 ):?>
					    	<?php 
								wp_dropdown_categories($args = array(
										'show_option_all'    => 'All',
										'orderby'            => 'ID', 
										'order'              => 'ASC',
										'show_count'         => 1,
										'hide_empty'         => 1, 
										'child_of'           => 0,
										'echo'               => 1,
										'selected'           => isset( $instance['recent_'.$taxonomies[$i]] ) ? $instance['recent_'.$taxonomies[$i]] : null,
										'hierarchical'       => 0, 
										'name'               => $this->get_field_name( 'recent_'.$taxonomies[$i] ),
										'id'                 => $this->get_field_id( 'recent_'.$taxonomies[$i] ),
										'taxonomy'           => $taxonomies[$i],
										'hide_if_empty'      => true,
										'class'              => 'regular-text sweethome-dropdown',
						    		)
					    		);
					    		else:
					    		?>
					    			<input id="<?php echo $this->get_field_id( 'recent_'.$taxonomies[$i] ); ?>" name="<?php echo $this->get_field_name( 'recent_'.$taxonomies[$i] ); ?>" value="<?php echo !empty( $instance['recent_'.$taxonomies[$i]] ) ? $instance['recent_'.$taxonomies[$i]] : NULL; ?>" style="width:100%;" />
					    			<small><?php printf( __('Put the %s slug, separated by a common(,)','swh') , $taxonomy->labels->name );?></small>
					    		<?php 
					    		endif;					    		
					    	?>
						</p>
					<?php
				}
			}
			?>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'recent_orderby' ); ?>"><?php _e('Orderby:', 'swh'); ?></label>
			    <select style="width:100%;" id="<?php echo $this->get_field_id( 'recent_orderby' ); ?>" name="<?php echo $this->get_field_name( 'recent_orderby' ); ?>">
			    	<?php 
			    		foreach ( swh_option_orderby() as $key=>$value ){
			    			$selected = ( $instance['recent_orderby'] == $key ) ? 'selected' : null;
			    			?>
			    				<option <?php print $selected; ?> value="<?php print $key;?>"><?php print $value;?></option>
			    			<?php 
			    		}
			    	?>
			    </select>  
			</p>			
			<p>  
			    <label for="<?php echo $this->get_field_id( 'recent_order' ); ?>"><?php _e('Order:', 'swh'); ?></label>
			    <select style="width:100%;" id="<?php echo $this->get_field_id( 'recent_order' ); ?>" name="<?php echo $this->get_field_name( 'recent_order' ); ?>">
			    	<?php 
			    		foreach ( swh_option_orders() as $key=>$value ){
			    			$selected = ( $instance['recent_order'] == $key ) ? 'selected' : null;
			    			?>
			    				<option <?php print $selected; ?> value="<?php print $key;?>"><?php print $value;?></option>
			    			<?php 
			    		}
			    	?>
			    </select>  
			</p>
			<hr>	
			<h3 style="border-bottom: 2px solid hsl(0, 0%, 94%);"><?php _e('Comment Tab','swh')?></h3>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'show_comment' ); ?>"><?php _e('Show:', 'swh'); ?></label>
			    <input type="checkbox" <?php checked('on', $instance['show_comment'], true);?> id="<?php echo $this->get_field_id( 'show_comment' ); ?>" name="<?php echo $this->get_field_name( 'show_comment' ); ?>"/>
			    <small><?php _e('Displaying Comment tab.','swh');?></small>
			</p>			
			<hr>
			<p>  
			    <label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e('Limit:', 'swh'); ?></label>
			    <input id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo $instance['limit'];?>" style="width:100%;" />
			</p>
			<hr>
			<style>.sweethome-dropdown{width:100%;}</style>
		<?php 
		
	}
	
}