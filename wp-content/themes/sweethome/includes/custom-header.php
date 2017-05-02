<?php
if( !defined('ABSPATH') ) exit;
if( !function_exists('swh_custom_header_setup') ){
	function swh_custom_header_setup() {
		/**
		 * @param array $args {
		 *     An array of custom-header support arguments.
		 *
		 *     @type bool   $header_text            Whether to display custom header text. Default false.
		 *     @type int    $width                  Width in pixels of the custom header image. Default 1260.
		 *     @type int    $height                 Height in pixels of the custom header image. Default 240.
		 *     @type bool   $flex_height            Whether to allow flexible-height header images. Default true.
		 *     @type string $admin_head_callback    Callback function used to style the image displayed in
		 *                                          the Appearance > Header screen.
		 *     @type string $admin_preview_callback Callback function used to create the custom header markup in
		 *                                          the Appearance > Header screen.
		 * }
		 */
		add_theme_support( 'custom-header', apply_filters( 'swh_custom_header_args', array(
			'default-text-color'     => null,
			'width'                  => 212,
			'height'                 => 38,
			'flex-height'            => true,
			'flex-width'             => true,
			'wp-head-callback'       => 'swh_header_style',
			'admin-head-callback'    => 'swh_admin_header_style',
			'admin-preview-callback' => 'swh_admin_header_image',
		) ) );
	}
	add_action( 'after_setup_theme', 'swh_custom_header_setup' );	
}

if ( ! function_exists( 'swh_header_style' ) ){
	function swh_header_style() {
		return;
	}
}

if( !function_exists('swh_admin_header_style') ){
	function swh_admin_header_style(){
		// If we get this far, we have custom styles.
		?>
			<style type="text/css" id="swh-header-css">tr.displaying-header-text{display:none;}</style>
			<?php		
	}
}

if ( ! function_exists( 'swh_admin_header_image' ) ) :
	function swh_admin_header_image() {
	?>
		<?php if ( get_header_image() ) : ?>
			<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	<?php
	}
endif;

