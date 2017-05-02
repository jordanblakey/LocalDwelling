<?php
/**
 * The template for displaying Comments
 * The area of the page that contains comments and the comment form.
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
				<?php if ( have_comments() ) : ?>
				<div class="comments-section">
					<h4 class="box-title">
						<?php
							printf( _n( 'One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'swh' ),
								number_format_i18n( get_comments_number() ), get_the_title() );
						?>
					</h4>
					
					<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
					<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
						<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'swh' ); ?></h1>
						<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'swh' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'swh' ) ); ?></div>
					</nav><!-- #comment-nav-above -->
					<?php endif; // Check for comment navigation. ?>	
					
									
					<ul class="media-list">
						<?php
							wp_list_comments( array(
								'style'      => 'ul',
								'short_ping' => true,
								'avatar_size'=> 64,
								'callback'	=>	'swh_comments_list_callback'
							) );
						?>
					</ul>
					
					<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
					<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
						<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'swh' ); ?></h1>
						<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'swh' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'swh' ) ); ?></div>
					</nav><!-- #comment-nav-below -->
					<?php endif; // Check for comment navigation. ?>
			
				</div>
				<?php endif;?>
				<?php if( comments_open() ):?>
					<div class="contact-form-wrapper comment-form-wrapper" <?php if( get_current_user_id() ) : print 'style="float:none;"';endif;?>>
						<div class="inner-wrapper">
							<h4 class="box-title"><?php _e('Leave a comment','swh');?></h4>
							
							<?php 
								$required_text = null;
								$logged_div = !get_current_user_id() ? '<div class="contact-form-right">' : null;
								$logged_enddiv = !get_current_user_id() ? '</div>' : NULL;
								$button_style = get_current_user_id() ? 'style="width:30%"' : null;
								$args = array(
								  'id_form'           => 'commentform',
								  'id_submit'         => 'submit',
								  'class_submit'	=>	NULL,
								  'title_reply'       => __( 'Add your comment','swh' ),
								  'title_reply_to'    => __( 'Leave a Reply to %s','swh' ),
								  'cancel_reply_link' => __( 'Cancel Reply','swh' ),
								  'label_submit'      => __( 'Send message','swh' ),
								  'comment_field'	=>	'
										'.$logged_div.'
											<textarea id="comment" name="comment" placeholder="'.__('Message','swh').'"></textarea>
											<input '.$button_style.' type="submit" value="'.__('Send message','swh').'">
										'.$logged_enddiv.'				                      
								  ',
								  'must_log_in' => '<p class="must-log-in">' .
								    sprintf(
								      __( 'You must be <a href="%s">logged in</a> to post a comment.','swh' ),
								      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
								    ) . '</p>',
								
								  'logged_in_as' => '<p class="logged-in-as">' .
								    sprintf(
								    __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','swh' ),
								      admin_url( 'profile.php' ),
								      $user_identity,
								      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
								    ) . '</p>',
								
								  'comment_notes_before' => '<p class="comment-notes">' .
								    __( 'Your email address will not be published.','swh' ) . ( $req ? $required_text : '' ) .
								    '</p>',
								
								  'comment_notes_after' => null,
								
								  'fields' => apply_filters( 'comment_form_default_fields', array(
									'author'	=>	'
									  <div class="contact-form-left">
				                      <span><i class="fa fa-user"></i></span><input type="text" id="author" name="author" placeholder="'.__('Name','swh').'">		
									',
									'email'	=>	'
									  <span><i class="fa fa-envelope-o"></i></span><input type="text" id="email" name="email" placeholder="'.__('E-mail','swh').'">
									',
									'url'	=>	'
									  <span><i class="fa fa-link"></i></span><input type="text" id="url" name="url" placeholder="'.__('Website','swh').'">
									  </div>
									'
								    )
								  ),
								);
								comment_form($args);
							?>							
							
						</div>
					</div>
				<?php endif;?>