<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package XSimply
 */

/**
 * For compatibily previus version
 */
function xsimply_retrocompat( $version = "5.2") {
	
	global $wp_version;
	
	if( $wp_version >= $version ) {
		return true;
	}
	
	return false;
	
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function xsimply_body_classes( $classes ) {

	// if is set background image
	$background_image = get_background_image();
	if( filter_var( $background_image, FILTER_VALIDATE_URL ) !== false ) {
		$classes[] = 'has-background-image';
	}
	
	// add class for different color scheme
	$color_scheme = get_theme_mod('xsimply_theme_color');
	if( isset( $color_scheme ) ) {
		$classes[] = "color-scheme-{$color_scheme}";
	} else {
		$classes[] = 'color-scheme-light';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'xsimply_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function xsimply_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'xsimply_pingback_header' );
