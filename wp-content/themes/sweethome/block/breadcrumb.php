<?php
	global $sweethome, $wp_query;
	$inline_css = null;
	if( $sweethome['breadcrumb'] == '1' && is_front_page() )
		return;
?>
<div class="page-title-section" <?php print isset( $sweethome['header_bg']['url'] ) ? 'style="background:url('.$sweethome['header_bg']['url'].')"' : null; ?>>
	<div class="container">
		<div class="pull-left page-title">
			<h2><?php print swh_current_pagename();?></h2>
		</div>
		<?php if( isset( $wp_query->found_posts ) && $wp_query->found_posts > 0 ):?>
			<div class="pull-right breadcrumb">
				<?php swh_breadcrumb_wp_title();?>
			</div>
		<?php endif;?>
	</div>
</div>
