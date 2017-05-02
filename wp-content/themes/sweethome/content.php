				<div <?php post_class('blog-post');?>>
					<div class="meta-data">
						<div class="meta-data-item">
							<i class="fa fa-calendar-o"></i>
							<a href="#"><?php print get_the_date('d M');?></a>
							<div class="meta-divider">
							</div>
						</div>
						<div class="meta-data-item">
							<i class="fa fa-user"></i>
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php print get_the_author_meta('display_name');?></a>
							<div class="meta-divider">
							</div>
						</div>
						<?php if( comments_open() ):?>
						<div class="meta-data-item">
							<i class="fa fa-comments"></i>
								<?php comments_popup_link( __( 'no comment', 'swh' ), __( '1 comment', 'swh' ), __( '% comments', 'swh' ),null, '<a href="#">'.__('Comment Off','swh').'</a>' ); ?>
							<div class="meta-divider">
							</div>
						</div>
						<?php endif;?>
					</div>
					<div class="post-content">
						<?php
							if ( is_single() ) :
								the_title( '<h2>', '</h2>' );
								the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'swh' ) );								
							else :
								the_title( '<h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
								the_excerpt();
							endif;
						?>
						<?php wp_link_pages(); ?>
						<?php if(!is_single() && has_post_thumbnail()):?>
							<div class="featured-image">
								<a href="<?php the_permalink();?>"><?php print get_the_post_thumbnail( get_the_ID(),'post-thumbnails-585-230' );?></a>
								<a href="<?php the_permalink();?>" class="readmore-btn"><?php _e('more','swh');?></a>
							</div>
						<?php endif;?>
						<?php if(has_tag() && is_single()):?>
							<p><?php _e('Tags','swh');?>:
								<?php the_tags( '<span class="tag-links">', ' ', '</span>' ); ?>
							</p>
						<?php endif;?>
						<?php if( has_category() && is_single()):?>
							<p><?php _e('Categories','swh');?>: <span class="tag-links"><?php the_category(' '); ?></span></p>
						<?php endif;?>	
						<?php if( is_single() ):?>
							<i class="fa fa-pencil-square-o"></i> <?php edit_post_link( __( 'Edit', 'swh' ), '<span class="edit-link">', '</span>' );?>
						<?php endif;?>
					</div>			
				</div>