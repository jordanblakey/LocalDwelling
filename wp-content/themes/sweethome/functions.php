<?php
if( !defined('ABSPATH') ) exit;
if ( ! isset( $content_width ) ) $content_width = 900;
### Define
if( !defined('SWH_THEME_URI') ){
	define('SWH_THEME_URI', get_template_directory_uri());
}
if( !defined('SWH_THEME_DIR') ){
	define('SWH_THEME_DIR', get_template_directory());
}
if( !defined('SWH_NA') ){
	define('SWH_NA', 'N/A');
}
require_once ( SWH_THEME_DIR . '/includes/class-tgm-plugin-activation.php');
require_once ( SWH_THEME_DIR . '/includes/Required_Plugins.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Functions.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_CPT.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Taxonomy.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_MetaBox.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Agent_Table.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Property_Table.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Widget_PropertySearch.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Widget_PropertySlider.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Widget_ContactInfo.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Widget_SubscribeForm.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Widget_GoogleMap.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Widget_Agent.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Widget_Property.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Widget_Tabbed_Posts.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Widget_MainListingPosts.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Widget_MainListingAgents.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Widget_Services_Block.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Widget_ContactForm.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Ajax.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Apperance.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_WooCommerce.php');
require_once ( SWH_THEME_DIR . '/includes/custom-header.php');
require_once ( SWH_THEME_DIR . '/includes/SWH_Taxonomy_Filter.php');
require_once ( SWH_THEME_DIR . '/includes/config.php');
require_once ( SWH_THEME_DIR . '/includes/wpes-envato-theme-update.php');

if( ! function_exists( 'swh_theme_update' ) ){
	function swh_theme_update() {
		global $sweethome;

		$purchase_code = isset( $sweethome['purchase_code'] ) ? $sweethome['purchase_code'] : null;
		$access_token = isset( $sweethome['access_token'] ) ? $sweethome['access_token'] : null;
		if( ! empty( $purchase_code ) && ! empty( $access_token ) ){
			new WPES_Envato_Theme_Update( basename( get_template_directory() ) , $purchase_code , $access_token , false );
		}
	}
	add_action( 'init' , 'swh_theme_update' );
}
if( !function_exists( 'swh_after_setup_theme' ) ){
	function swh_after_setup_theme() {
		//------------------------------ Load Language -----------------------------------------//
		load_theme_textdomain( 'swh', get_template_directory() . '/languages' );
		//------------------------------ Add Theme Support -------------------------------------//
		add_theme_support( 'title-tag' );
		add_theme_support( 'jetpack-responsive-videos' );
		add_image_size('post-thumbnails-585-230', 585,230,true);
		add_image_size('property-thumbnail-124-76', 124,76, true);
		add_image_size('property-thumbnail-370-270', 370,270, true);
		add_image_size('property-thumbnail-770-481', 770,481, true);
		add_image_size('property-thumbnail-1920-638', 1920, 638, true);
		add_image_size('agents-thumbnail-270-256', 270, 256, true);
		add_image_size('agents-thumbnail-320-303', 320, 303, true);
		add_theme_support( 'woocommerce' );
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );
		add_filter('widget_text', 'do_shortcode');
		add_theme_support( 'custom-background', array(
			'default-color' => 'f6f2ef',
		) );
		add_theme_support('menus');
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
	}
	add_action('after_setup_theme', 'swh_after_setup_theme');
}
if( !function_exists('swh_enqueue_scripts') ){
	/**
	* Enqueue the scripts and styles
	*/
	function swh_enqueue_scripts() {
		global $sweethome;
		/** enqueue styles **/
		wp_enqueue_style('bootstrap.min.css', '//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css');
		wp_enqueue_style('bootstrap-theme.min.css', SWH_THEME_URI . '/assets/css/bootstrap-theme.min.css');
		wp_enqueue_style('font-awesome.min.css', SWH_THEME_URI . '/assets/css/font-awesome.min.css');
		wp_enqueue_style('flexslider.css', SWH_THEME_URI . '/assets/css/flexslider.css');
		wp_enqueue_style('select-theme-default.css', SWH_THEME_URI . '/assets/css/select-theme-default.css');
		wp_enqueue_style('owl.carousel.css', SWH_THEME_URI . '/assets/css/owl.carousel.css');
		wp_enqueue_style('owl.theme.css', SWH_THEME_URI . '/assets/css/owl.theme.css');
		wp_enqueue_style( 'swh-google-fonts1', swh_googlefont_url1(), array(), null );
		wp_enqueue_style( 'swh-google-fonts2', swh_googlefont_url2(), array(), null );
		if( class_exists('WooCommerce') ){
			wp_enqueue_style('swh-woocommerce', SWH_THEME_URI . '/assets/css/woocommerce.css');
		}
		wp_enqueue_style( 'style', get_bloginfo( 'stylesheet_url' ), array(), null );
		/** enqueue scripts **/
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		wp_enqueue_script('bootstrap.min.js', '//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js', array(), '', true);
		wp_enqueue_script('jquery.flexslider-min.js', SWH_THEME_URI . '/assets/js/jquery.flexslider-min.js', array('jquery'), '', true);
		wp_enqueue_script('select.min.js', SWH_THEME_URI . '/assets/js/select.min.js', array('jquery'), '', true);
		wp_enqueue_script('owl.carousel.min.js', SWH_THEME_URI . '/assets/js/owl.carousel.min.js', array('jquery'), '', true);
		wp_enqueue_script('jquery.matchheight-min.js', SWH_THEME_URI . '/assets/js/jquery.matchheight-min.js', array('jquery'), '', true);
		wp_enqueue_script('script.js', SWH_THEME_URI . '/assets/js/script.js', array('jquery'), '', true);
		wp_enqueue_script('custom.js', SWH_THEME_URI . '/assets/js/custom.js', array('jquery'), '', true);
		echo '<script>var swh_template_uri = "'.get_template_directory_uri().'";</script>';
		echo '<script>var swh_ajax_uri = "'.admin_url('admin-ajax.php').'";</script>';


		$google_map_url	=	esc_url( add_query_arg( array(
			'key'		=>	isset( $sweethome['gmap_api'] ) ? $sweethome['gmap_api'] : '',
			'language'	=>	! empty( $sweethome['gmap_language'] ) ? esc_attr( $sweethome['gmap_language'] ) : 'en'
		), 'maps.googleapis.com/maps/api/js' ) );

		wp_enqueue_script('googlemap',$google_map_url, array('jquery'), '', true);

		wp_enqueue_script('gmap.js', SWH_THEME_URI . '/assets/js/gmap.js', array('jquery'), '', true);
	}
	add_action('wp_enqueue_scripts', 'swh_enqueue_scripts');
}
if( !function_exists('swh_googlefont_url1') ){
	function swh_googlefont_url1() {
		$font_url = '';
		$font_url = add_query_arg( 'family', 'Roboto:300,400,900italic,700italic,500italic,400italic,300italic,100italic,900,700,500,300,100', "//fonts.googleapis.com/css" );
		return $font_url;
	}
}
if( !function_exists('swh_googlefont_url2') ){
	function swh_googlefont_url2() {
		$font_url = '';
		$font_url = add_query_arg( 'family', 'Open+Sans:300italic,400italic,600italic,300,400,600', "//fonts.googleapis.com/css" );
		return $font_url;
	}
}
if( !function_exists('swh_admin_enqueue_scripts') ){
	function swh_admin_enqueue_scripts() {
		wp_enqueue_style('redux-admin.css', SWH_THEME_URI . '/assets/css/redux-admin.css');
		wp_enqueue_style('admin.css', SWH_THEME_URI . '/assets/css/admin.css');
	}
	add_action('admin_enqueue_scripts', 'swh_admin_enqueue_scripts');
}
if( !function_exists('swh_register_my_menus') ){
	/**
	* Register the header menu navigation.
	*/
	function swh_register_my_menus() {
		register_nav_menus(
			array(
				'header_main_navigation' => __('Home Page Navigation','swh'),
				)
			);
		}
		add_action( 'init', 'swh_register_my_menus' );
	}
	/**
	* Register 5 widget areas.
	*/
	if( !function_exists('swh_widgets_init') ){
		function swh_widgets_init() {
			register_sidebar(
				$args = array(
					'name'          => __( 'Right Post/Page Sidebar', 'swh' ),
					'id'            => 'swh-right-sidebar-post',
					'description'   => __('Display the widgets on the Right Post/Page/Category/Archive Sidebar','swh'),
					'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
					'after_widget'  => '</div>',
					'before_title' => '<h4 class="widget-title">',
					'after_title' => '</h4>',
					)
				);
				register_sidebar(
					$args = array(
						'name'          => __( 'Right Property Sidebar', 'swh' ),
						'id'            => 'swh-right-sidebar-property',
						'description'   => __('Display the widgets on the Right Property Sidebar','swh'),
						'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
						'after_widget'  => '</div>',
						'before_title' => '<h4 class="widget-title">',
						'after_title' => '</h4>',
						)
					);
					register_sidebar(
						$args = array(
							'name'          => __( 'Right Agent Sidebar', 'swh' ),
							'id'            => 'swh-right-sidebar-agent',
							'description'   => __('Display the widgets on the Right Agent Sidebar','swh'),
							'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
							'after_widget'  => '</div>',
							'before_title' => '<h4 class="widget-title">',
							'after_title' => '</h4>',
							)
						);
						register_sidebar(
							$args = array(
								'name'          => __( 'Header Sidebar', 'swh' ),
								'id'            => 'swh-header-sidebar',
								'description'   => __('Display the Breadcrumb/Property Slider','swh'),
								'before_widget' => NULL,
								'after_widget'  => NULL,
								'before_title' => NULL,
								'after_title' => NULL,
								)
							);
							register_sidebar(
								$args = array(
									'name'          => __( 'Footer Sidebar', 'swh' ),
									'id'            => 'swh-footer-sidebar',
									'description'   => __('Display the widgets on the Footer Sidebar','swh'),
									'before_widget' => '<div id="%1$s" class="col-md-3 %2$s">',
									'after_widget'  => '</div>',
									'before_title' => '<h3 class="footer-title">',
									'after_title' => '</h3>',
									)
								);
								register_sidebars( 1,
								array(
									'name' => 'widgetized-page-top',
									'before_widget' => '
									<div id="%1$s" class="widget %2$s">',
									'after_widget' => '</div>
									',
									'before_title' => '
									<h2 class="widgettitle">',
									'after_title' => '</h2>
									'
								)
							);

							register_sidebars( 1,
							array(
								'name' => 'widgetized-page-bottom',
								'before_widget' => '
								<div id="%1$s" class="widget %2$s">',
								'after_widget' => '</div>
								',
								'before_title' => '
								<h2 class="widgettitle">',
								'after_title' => '</h2>
								'
							)
						);

					}
					add_action( 'widgets_init', 'swh_widgets_init' );
				}
