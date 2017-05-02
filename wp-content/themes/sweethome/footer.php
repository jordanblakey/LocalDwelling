<?php if( !defined('ABSPATH') ) exit;?>
<?php global $sweethome;?>
<!-- footer-section -->
<footer>
<div class="container"><?php dynamic_sidebar('swh-footer-sidebar');?></div>
</footer>
<div class="bottom-strip">
	<div class="container">
		<div class="col-md-4">
			<p class="pull-left">
				<?php print $sweethome['footer_text'];?>
			</p>
		</div>
		<div class="col-md-4 bottom-strip-middle">
			<a href="#top" class='fa fa-arrow-circle-up' id='backtop-btn'></a>
		</div>
		<div class="col-md-4">
			<?php if( is_array( swh_social_profiles(null) ) ):?>
				<ul class="social-icons">
					<?php 
						foreach ( swh_social_profiles(null) as $key=>$value ){
							if( isset( $sweethome[ 's-' . $key ] ) && $sweethome[ 's-' . $key ] != null ){
								print '<li><a href="'.$sweethome[ 's-' . $key ].'" class="fa '.$key.'"></a></li>';
							}
						}
					?>
				</ul>
			<?php endif;?>
		</div>
	</div>
</div>
<?php wp_footer();?>
</body>
</html>
