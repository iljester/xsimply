<?php
/**
 * XSimply functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package XSimply
 */

/**
 * Set constat web author link for footer credits
 * Do not move or edit
 */
define( 'XSIMPLY_AUTHOR_SITE', '<a href="https://www.iljester.com">Il Jester</a>' );

/**
 * Define version
 * For any use
 */
define('XSIMPLY_VER', '1.7');

/**
 * xsimply setup
 */
if ( ! function_exists( 'xsimply_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function xsimply_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on X-Simply, use a find and replace
		 * to change 'xsimply' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'xsimply', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'xsimply' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'xsimply_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 70,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
		
		/**
		 * Add editor style
		 * 
		 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
		 */
		add_editor_style( trailingslashit( get_template_directory_uri() ) . 'css/editor-style.css' );
		
		/**
		 * These supports are only raccomended.
		 */
			
		// responsive embeds
		add_theme_support( "responsive-embeds" );

		// align wide
		add_theme_support( "align-wide" );

		// block styles
		add_theme_support( "wp-block-styles" );
		
		/**
		 * Add Custom font to editor style
		 */
		$selected_font = get_theme_mod( 'xsimply_typography_choices', 'titillium_web' );
		$fonts = xsimply_fonts();
		$font  = sanitize_text_field( str_replace(" ", "+", $fonts[$selected_font] ) );
		$font_url = str_replace( ',', '%2C', "//fonts.googleapis.com/css?family={$font}:400,400i,700,700i&display=swap" );
		add_editor_style( $font_url );
	}
endif;
add_action( 'after_setup_theme', 'xsimply_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function xsimply_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'xsimply_content_width', 640 );
}
add_action( 'after_setup_theme', 'xsimply_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function xsimply_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'xsimply' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'xsimply' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'xsimply_widgets_init' );

/**
 * Normalize char size for tag cloud widget
 */
function xsimply_set_tag_cloud_font_size($args) {

	// normalize size
    $args['smallest'] = 14; /* Set the smallest size to 14px */
	$args['largest'] = 14;  /* set the largest size to 14px */
	
    return $args; 
}
add_filter('widget_tag_cloud_args','xsimply_set_tag_cloud_font_size');

/**
 * Enqueue scripts and styles.
 */
function xsimply_scripts() {

	// include dashicons
	wp_enqueue_style( 'dashicons' );

	// append font
	$selected_font = get_theme_mod( 'xsimply_typography_choices', 'titillium_web' );
	if( $selected_font !== 'system_ui' ) {
		$fonts = xsimply_fonts();
		$font  = sanitize_text_field( str_replace(" ", "+", $fonts[$selected_font] ) );
		$tag   = sanitize_title( $fonts[$selected_font] );
		$url   = esc_url( "https://fonts.googleapis.com/css?family={$font}:400,400i,700,700i&display=swap" );
		wp_enqueue_style( "xsimply-{$tag}", "{$url}");
	}
	
	// get main style
	wp_enqueue_style( 'xsimply-style', get_stylesheet_uri() );

	// set color scheme
	if( get_theme_mod( 'xsimply_theme_color' ) === 'metal' ) {
		wp_enqueue_style( 'xsimply-metal', get_template_directory_uri() . '/css/metal.css' );
	}
	elseif( get_theme_mod( 'xsimply_theme_color' ) === 'pig' ) {
		wp_enqueue_style( 'xsimply-pig', get_template_directory_uri() . '/css/pig.css' );
	} 
	elseif( get_theme_mod( 'xsimply_theme_color' ) === 'sea' ) {
		wp_enqueue_style( 'xsimply-sea', get_template_directory_uri() . '/css/sea.css' );
	} 
	elseif( get_theme_mod( 'xsimply_theme_color') === 'night' ) {
		wp_enqueue_style( 'xsimply-night', get_template_directory_uri() . '/css/night.css' );
	}

	// css for device
	wp_enqueue_style( 'xsimply-device', get_template_directory_uri() . '/css/device.css' );

	wp_enqueue_script( 'xsimply-menu-nav', get_template_directory_uri() . '/js/menu-nav.js', array('jquery'), '1.0', true );

	wp_enqueue_script( 'xsimply-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	// thread comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'xsimply_scripts' );

/**
 * Add inline css rules for xsimply theme
 */
function xsimply_inline_css() {
	
	// an empty array to transport css rules
	$xsimply_css_rules = array();
	
	// add typography
	$selected_font = get_theme_mod( 'xsimply_typography_choices', 'titillium_web' );
	$fonts = xsimply_fonts();
	
	if( $selected_font !== 'system_ui' ) {
		$font = sanitize_text_field( $fonts[$selected_font] );
		$fs = '';
		if( $selected_font === 'dancing_script' ) {
			$fs = "font-size: 1.5rem;";
		}
		$xsimply_css_rules[] = "body { font-family: \"{$font}\";{$fs} }";
	}
	
	// get current layout wide 
	$wide = get_theme_mod( 'xsimply_theme_layout_wide', 'normal' );
	if( $wide !== 'normal' && $wide !== 'thin' ) {
		$xsimply_css_rules[] = "div#page { width: 100%; padding: 0 40px; box-sizing: border-box;}";
	}
	
	if( $wide === 'thin' ) {
		/** 57.2390572391% = 680px **/
		$xsimply_css_rules[] = "div#page { width: 57.2390572391%; padding: 0 40px; box-sizing: border-box;}";
		$xsimply_css_rules[] = "#primary { width: 100%; float: none; padding-right: 0; padding-bottom: 20px; }";
		$xsimply_css_rules[] = "#secondary { float: none; width: 100%; padding: 0;}";
		$xsimply_css_rules[] = "#secondary .widget { padding: 0; }";
	}

	// get current layout alignment
	$alignment = get_theme_mod( 'xsimply_theme_layout_align', 'center' );
	if( $alignment !== 'center' ) {
		switch( $alignment ) {
			case 'left' : 
				$xsimply_css_rules[] = "div#page { margin-left: 0; padding-left: 40px; }";
			break;
			case 'right' :
				$xsimply_css_rules[] = "div#page { margin-right: 0; padding-right: 40px; }";
			break;
			default:
				$xsimply_css_rules[] = "div#page { margin-left: 0; padding-left: 40px; }";
		}
	}
	
	// align header image
	$header_image_align = get_theme_mod( 'xsimply_center_image_header', 0 );
	$has_fixed_header = get_theme_mod( 'xsimply_fixed_image_header', 0 );
	if( (bool) $header_image_align === true  ) {
		$xsimply_css_rules[] = '.custom-header{text-align:center;}';
	}
	
	// align menu
	$menu_align = get_theme_mod( 'xsimply_theme_layout_menu_align', 'left' );
	if( $menu_align !== 'left' ) {
		switch( $menu_align ) {
			case 'right' :
				$xsimply_css_rules[] = '#primary-menu {text-align:right;display:block;width:100%;}#primary-menu > li {float:none;display: inline-block;text-align: initial;}';
			break;
			case 'center' :
				$xsimply_css_rules[] = '#primary-menu {text-align:center;display:block;width:100%;}#primary-menu > li {float:none;display: inline-block;text-align: initial;}';
			break;
		}
	}
	
	// get current theme color
	$theme_color = get_theme_mod( 'xsimply_theme_color', 'light' );
	
	/**
	 * Customize header text and background
	 */
	$customize_active = get_theme_mod( 'xsimply_customize_active', 0 );

	if( get_background_color() && (bool) $customize_active === false ) {
		if( in_array( $theme_color, array_keys( xsimply_color_scheme() ) ) ) {
			switch( $theme_color ) {
				case 'light' : 
					$bg_color   = '#FFFFFF'; 
					$link_color = '#505050';
					$link_hover = '#000000';
					break;
				case 'metal' : 
					$bg_color   = '#DAD9D9'; 
					$link_color = '#505050';
					$link_hover = '#0C0C0C';
					break;
				case 'pig'   : 
					$bg_color   = '#EABDBD'; 
					$link_color = '#D86464';
					$link_hover = '#B12B2B';
					break;
				case 'sea'   : 
					$bg_color   = '#213142'; 
					$link_color = '#D3DEEC';
					$link_hover = '#1DA1F2';
					break;
				case 'night' : 
					$bg_color   = '#000000'; 
					$link_color = '#ABABAB';
					$link_hover = '#E4E4E4';
					break;
				default: $bg_color = '#' . get_background_color();
					     $link_color = '#505050';
						 $link_hover = '';
			}
			$bg_color   = sanitize_hex_color( $bg_color );
			$link_color = sanitize_hex_color( $link_color );
			$link_hover = sanitize_hex_color( $link_hover );
			$xsimply_css_rules[] = "body.custom-background { background-color: {$bg_color}; }";
			$xsimply_css_rules[] = "a, a:visited, .site-title a, .site-description { color: {$link_color}; }";
			$xsimply_css_rules[] = "a:hover { color: {$link_hover}; }";
		}
	
	}
	
	/**
	 * Semi-transparent background
	 */
	$opacity = get_theme_mod( 'xsimply_opacity', '0.7' );

	switch( $theme_color ) {
		case 'light' : $bgcolor = "rgba(255, 255, 255, {$opacity})"; break;
		case 'metal' : $bgcolor = "rgba(220, 220, 220, {$opacity})"; break;
		case 'pig' 	 : $bgcolor = "rgba(62, 12, 12, {$opacity})"; break;
		case 'sea' 	 : $bgcolor = "rgba(18, 53, 78, {$opacity})"; break;
		case 'night' : $bgcolor = "rgba(0, 0, 0, {$opacity})"; break;
		default: $bgcolor = "rgba(18, 53, 78, {$opacity})";
	}

	if( get_background_image() ) {
		$bgcolor = esc_html( $bgcolor );
		$xsimply_css_rules[] = ".site { background-color: {$bgcolor}; padding: 20px 40px; box-sizing: content-box; }";
		$xsimply_css_rules[] = '.widget-area { width: 38%; padding-right: 0; }';
	}
	
	if( !empty( $xsimply_css_rules ) ) {
		$xsimply_css_rules_string = implode( PHP_EOL, $xsimply_css_rules );
		echo '<style type="text/css" id="xsimply-inline-css">';
		echo "{$xsimply_css_rules_string}";
		echo '</style>';
	}
}
add_action('wp_head', 'xsimply_inline_css', 9999 );

/**
 * Check if attachment has post parent
 */
function xsimply_attachment_has_post_parent() {
	global $post;

	if(  $post->post_parent > 0 ) 
		return true;
	
	return false;
}

/**
 * Filter html to allow only <em> and <strong> html tag
 */
function xsimply_html_filter( $value ) {

	return wp_kses( $value, array('strong' => array(), 'em' => array() ) );

}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
