<?php if( !defined('ABSPATH') ) exit;?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<head>
<!--Meta Tags-->
<meta charset="UTF-8">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!-- Set Viewport-->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php global $sweethome;?>
<?php wp_head();?>
<link rel='stylesheet' id='style-css'  href='<?php echo get_template_directory_uri(); ?>/custom.css' type='text/css' media='all' />
</head>
<body id="top" <?php body_class();?>>
<header>
	<div id="top-strip">
		<div class="container">
			<?php if( is_array( swh_social_profiles(null) ) ):?>
			<ul class="pull-left social-icons">
				<?php
					foreach ( swh_social_profiles(null) as $key=>$value ){
						if( isset( $sweethome[ 's-' . $key ] ) && $sweethome[ 's-' . $key ] != null ){
							print '<li><a target="_blank" href="'.esc_url( $sweethome[ 's-' . $key ] ).'" class="fa '.esc_attr( $key ).'"></a></li>';
						}
					}
				?>
			</ul>
			<?php endif;?>
			<div id="contact-box" class='pull-right'>
				<a href="https://app.propertyware.com/pw/portals/localdwelling/tenant.action" target="_blank">Tenant Login</a>
				<a href="https://app.propertyware.com/pw/portals/localdwelling/owner.action" target="_blank">Owner Login</a>
				<?php if( isset( $sweethome['c_telephone'] ) ):?>
					<a href="#" class='fa fa-phone'><span><?php print $sweethome['c_telephone'];?></span></a>
				<?php endif;?>
			</div>
		</div>
	</div>



	<div id="premium-bar">
		<div class="container">
			<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<?php if( !is_rtl() ):?>
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only"><?php _e('Toggle navigation','swh');?></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					<?php endif;?>
					<a class="navbar-brand" href="<?php print home_url();?>">
						<?php if ( get_header_image() ) : ?>
							<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="logo">
						<?php else:?>
							<img src="<?php print get_template_directory_uri();?>/assets/img/logo.png" alt="logo">
						<?php endif;?>
					</a>
				</div>
				<?php if( is_rtl() ):?>
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only"><?php _e('Toggle navigation','swh');?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				<?php endif;?>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<?php
						if( has_nav_menu('header_main_navigation') ){
							wp_nav_menu(array(
								'theme_location'=>'header_main_navigation',
								'menu_class'=>'nav navbar-nav navbar-right',
								'walker' => new SWH_Walker_Nav_Menu(),
								'container'	=>	null
							));
						}
						else{
							?>
								<ul class="nav navbar-nav navbar-right">
									<li><a href="<?php print home_url();?>"><?php _e('Home','swh');?></a></li>
									<li><a href="#"><?php _e('Buy Now','swh')?></a></li>
								</ul>
							<?php
						}
					?>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container-fluid -->
			</nav>
		</div>
	</div>
</header>
<!-- /Header -->
<!-- <div class="slider-section">

</div> -->
<!-- head-Section -->

<?php

	if( is_active_sidebar( apply_filters( 'swh_header_sidebar' , 'swh-header-sidebar') ) ){
		dynamic_sidebar( apply_filters( 'swh_header_sidebar' , 'swh-header-sidebar') );
	}

?>
