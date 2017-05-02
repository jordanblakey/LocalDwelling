<?php
if( !defined('ABSPATH') ) exit;
if( !class_exists('SWH_Apperance') ){
	class SWH_Apperance {
		function __construct() {
			add_action('wp_head', array( $this, 'init' ));
		}
		function init(){
			global $sweethome;
			$style = null;
			if( !empty( $sweethome['background-topbar'] ) && $sweethome['background-topbar'] != 'hsl(201, 100%, 45%)' ){
				$style .= 'header #top-strip{background-color:'.$sweethome['background-topbar'].'}';
			}
			if( !empty( $sweethome['background-menu'] ) &&  $sweethome['background-menu'] != 'hsla(0, 0%, 9%, 0.7)' ){
				$style .= '#premium-bar{background-color:'.$sweethome['background-menu'].'}';
			}
			if( !empty( $sweethome['color-text-menu'] ) && $sweethome['color-text-menu'] != '#fff' ){
				$style .= '#premium-bar nav li a{color:'.$sweethome['color-text-menu'].'}';
			}
			if( !empty( $sweethome['color-text-active-menu'] ) && $sweethome['color-text-active-menu'] != '#333' ){
				$style .= '#premium-bar nav .current-menu-item a{color:'.$sweethome['color-text-active-menu'].'!important;}';
			}
			if( !empty( $sweethome['background-footer'] ) && $sweethome['background-footer'] != 'hsl(201, 8%, 33%)' ){
				$style .= 'footer{background:'.$sweethome['background-footer'].'}';
			}
			if( !empty( $sweethome['background-footer-strip'] ) && $sweethome['background-footer-strip'] != 'hsl(201, 100%, 45%)' ){
				$style .= '.bottom-strip{background:'.$sweethome['background-footer-strip'].'}';
			}
			if( !empty( $sweethome['color-footer'] ) && $sweethome['color-footer'] != 'hsl(0, 100%, 100%)' ){
				$style .= '.bottom-strip .container p{color:'.$sweethome['color-footer'].'}';
			}							
			if( !empty( $style ) ){
				print '<style>'.$style.'</style>';
			}
		}
	}
	new SWH_Apperance();
}