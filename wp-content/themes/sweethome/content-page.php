				<div <?php post_class('blog-post');?>>
					<div class="post-content">
						<?php
							the_title( '<h1>', '</h1>' );
							the_content();
						?>
						<?php wp_link_pages(); ?>
						<?php if(!is_single() && has_post_thumbnail()):?>
						<div class="featured-image">
							<?php print get_the_post_thumbnail( get_the_ID(),'post-thumbnails-585-230' );?>
							<?php if( !is_page() ):?>
								<a href="<?php the_permalink();?>" class="readmore-btn"><?php _e('more','swh');?></a>
							<?php endif;?>
						</div>
						<?php endif;?>
					</div>
				</div>
