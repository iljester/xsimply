<?php
/**
 * Custom Header feature
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package X-Simply
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses xsimply_header_style()
 */
function xsimply_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'xsimply_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1188,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'xsimply_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'xsimply_custom_header_setup' );

if ( ! function_exists( 'xsimply_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see xsimply_custom_header_setup().
	 */
	function xsimply_header_style() {
		$header_text_color = get_header_textcolor();
		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}
		
		// If we get this far, we have custom styles. Let's do this.
		echo '<style type="text/css" id="xsimply-custom-header">' . PHP_EOL;
		if ( ! display_header_text() ) {
			// Has the text been hidden?
			echo '.site-title, .site-description { position: absolute; clip: rect(1px,1px,1px,1px); }';
		} else {
			// If the user has set a custom color for the text use that.
			$header_text_color_with_hash = sanitize_hex_color( '#' . $header_text_color );
			echo ".site-title a, .site-description { color: {$header_text_color_with_hash}; }";
		}
		echo PHP_EOL;
		echo '</style>';
		
	}
endif;

/**
 * Displays header image
 */
if( !function_exists( 'xsimply_custom_header' ) ) :

	function xsimply_custom_header() {
		$obj = get_custom_header();

		if( empty( $obj->url ) ) {
			return;
		}

		$url 	= $obj->url;
		$width 	= $obj->width;
		$height = $obj->height;

		/**
		* Settings custom options
		*/
		if( ! has_custom_logo() && ! display_header_text() ) {
			echo '<a href="' . esc_url( get_home_url('/') ) . '" rel="home" class="custom-header-link">';
		}

		if( get_theme_mod( 'xsimply_bg_header' ) ) {

			$inline_css = 'background-image: url(' . esc_url( $url ) . ');height:' . esc_attr( $height ) . 'px;width:100%;background-position:center center;max-width:100%;background-repeat:no-repeat;';
			if( (bool) get_theme_mod( 'xsimply_fixed_image_header', 0 ) ) {
				$inline_css .= 'background-attachment:fixed;background-size:cover;';
			}

			echo '<div width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" class="bg-header" style="' . esc_attr( $inline_css ) . '"></div>';

		} else {

			echo '<img src="' . esc_url( $url )  . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" class="custom-header-img" />';
		}

		if( ! has_custom_logo() && ! display_header_text() ) {
			echo '</a>';
		}

	}

endif;
