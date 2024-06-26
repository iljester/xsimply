<?php
/**
 * X-Simply Theme Customizer
 * 
 * @package X-Simply
 */

/**
 * Create an array of available fonts
 */
function xsimply_fonts() {
	
	$fonts = array(
		'titillium_web'  => 'Titillium Web',
		'dancing_script' => 'Dancing Script',
		'dm_sans'		 => 'DM Sans',
		'inconsolata'	 => 'Inconsolata',
		'lato'			 => 'Lato',
		'lora'			 => 'Lora',
		'merriweather'	 => 'Merriweather',
		'montserrat'	 => 'Montserrat',
		'muli'			 => 'Muli',
		'noto_sans'		 => 'Noto Sans',
		'noto_serif'	 => 'Noto Serif',
		'noto_sans_jp'	 => 'Noto Sans JP',
		'nunito'		 => 'Nunito',
		'open_sans' 	 => 'Open Sans',
		'playfair_display' => 'Playfair Display',
		'poppins'		 => 'Poppins',
		'pt_sans'		 => 'PT Sans',
		'quicksand'		 => 'Quicksand',
		'rajdhani'		 => 'Rajdhani',
		'raleway'		 => 'Raleway',
		'roboto'		 => 'Roboto',
		'roboto_slab'	 => 'Roboto Slab',
		'roboto_condensed' => 'Roboto Condensed',
		'source_serif_pro' => 'Source Serif Pro',
		'system_ui' 	 => 'System UI',
		'ubuntu'		 => 'Ubuntu' 
	);
	return $fonts;

}

/**
 * Create an array of color schemes
 */
function xsimply_color_scheme() {
	
	$schemes = array(
		'light' => __( 'Light (default)', 'xsimply'),
		'metal' => __( 'Metal', 'xsimply' ),
		'pig'	=> __( 'Piggy', 'xsimply' ),
		'sea' 	=> __( 'Sea', 'xsimply' ),
		'night' => __( 'Night', 'xsimply' )
	);
	return $schemes;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function xsimply_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'background_image' )->transport = 'refresh';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'xsimply_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'xsimply_customize_partial_blogdescription',
		) );
	}

	$wp_customize->add_setting('xsimply_theme_color', array(
		'default'           => 'light',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	));

	$wp_customize->add_control('xsimply_theme_color', array(
		'label'      => __('Theme Colors', 'xsimply'),
		'description' => __('Note. If you are using a background image, use the most suitable color scheme or set 1 in page opacity (background image section).', 'xsimply'),
		'section'    => 'colors',
		'settings'   => 'xsimply_theme_color',
		'type'       => 'radio',
		'choices'     => xsimply_color_scheme(),
		'priority' => 1
	));
	
	$wp_customize->add_setting('xsimply_customize_active', array(
		'default'           => '0',
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	));
	
	$wp_customize->add_control('xsimply_customize_active', array(
		'label'      => __('Allow customization below', 'xsimply'),
		'description' => __('If set, you can customize header text and background color', 'xsimply'),
		'section'    => 'colors',
		'settings'   => 'xsimply_customize_active',
		'type'       => 'checkbox', 
		'priority'	 => 2
	));

	$wp_customize->add_setting('xsimply_opacity', array(
		'default'           => '0.7',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	));

	$wp_customize->add_control('xsimply_opacity', array(
		'label'      => __('Page Opacity', 'xsimply'),
		'description' => __('Default 0.7. Set 1 for full color without transparency. 0 for full transparency.', 'xsimply'),
		'section'    => 'background_image',
		'settings'   => 'xsimply_opacity',
		'type'       => 'number',
		'input_attrs' => array(
			'min' => 0,
			'max' => 1
		  ),
	));
	
	$wp_customize->add_setting('xsimply_center_image_header', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	));

	$wp_customize->add_control('xsimply_center_image_header', array(
		'label'      => __('Center Image', 'xsimply'),
		'description' => __('Center the image if the size is smaller than suggested. No fixed cover.', 'xsimply'),
		'section'    => 'header_image',
		'settings'   => 'xsimply_center_image_header',
		'type'       => 'checkbox'
	));

	$wp_customize->add_setting('xsimply_bg_header', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	));

	$wp_customize->add_control('xsimply_bg_header', array(
		'label'      => __('Background Image Header', 'xsimply'),
		'section'    => 'header_image',
		'settings'   => 'xsimply_bg_header',
		'type'       => 'checkbox'
	));

	$wp_customize->add_setting('xsimply_fixed_image_header', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	));

	$wp_customize->add_control('xsimply_fixed_image_header', array(
		'label'      => __('Fixed Cover', 'xsimply'),
		'description' => __('Set image header like fixed cover (only with Background Image Header!).', 'xsimply'),
		'section'    => 'header_image',
		'settings'   => 'xsimply_fixed_image_header',
		'type'       => 'checkbox'
	));

	$wp_customize->add_section( 'xsimply_footer', array(
		'title' => __('Footer', 'xsimply'),
		'priority'   => 140
	) );

	$wp_customize->add_setting('xsimply_my_site_cp', array(
		'default'           => '{copy}{year} {blogname}',
		'sanitize_callback' => 'xsimply_html_filter',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	));

	$wp_customize->add_control('xsimply_my_site_cp', array(
		'label'      => __('Site Info', 'xsimply'),
		'description' => __('Allowed tags: strong, em. Press "Enter" to wrap up. Use {copy} for &copy;, {year} for current year, {blogname} for blog name.', 'xsimply'),
		'section'    => 'xsimply_footer',
		'settings'   => 'xsimply_my_site_cp',
		'type'       => 'textarea'
	));

	$wp_customize->add_setting('xsimply_hide_cms_credits', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	));

	$wp_customize->add_control('xsimply_hide_cms_credits', array(
		'label'      => sprintf( __('Hide %s credits', 'xsimply'), 'WordPress' ),
		'description' => sprintf( __('You can support the development and diffusion of %s by leaving credits.', 'xsimply' ), 'WordPress'),
		'section'    => 'xsimply_footer',
		'settings'   => 'xsimply_hide_cms_credits',
		'type'       => 'checkbox'
	));

	$wp_customize->add_setting('xsimply_hide_theme_credits', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	));

	$wp_customize->add_control('xsimply_hide_theme_credits', array(
		'label'      => sprintf( __('Hide %s credits', 'xsimply'), 'XSimply' ),
		'description' => sprintf( __('You can support the development and diffusion of %s by leaving credits.', 'xsimply' ), 'XSimply'),
		'section'    => 'xsimply_footer',
		'settings'   => 'xsimply_hide_theme_credits',
		'type'       => 'checkbox'
	));


	$wp_customize->add_section('xsimply_layout', array(
		'title' => __( 'Layout', 'xsimply' ),
		'priority' => 30
	));
	
	$wp_customize->add_setting('xsimply_theme_layout_wide', array(
		'default'           => 'normal',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	));

	$wp_customize->add_control('xsimply_theme_layout_wide', array(
		'label'      => __('Layout Wide', 'xsimply'),
		'description' => __('Set layout wide', 'xsimply'),
		'section'    => 'xsimply_layout',
		'settings'   => 'xsimply_theme_layout_wide',
		'type'       => 'radio',
		'choices'     => array(
			'thin' => __('Thin', 'xsimply' ),
			'normal' => __('Normal (default)', 'xsimply'),
			'full' => __( 'Full', 'xsimply')
		),
		'priority' => 1
	));

	$wp_customize->add_setting('xsimply_theme_layout_align', array(
		'default'           => 'center',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	));

	$wp_customize->add_control('xsimply_theme_layout_align', array(
		'label'      => __('Layout Alignment', 'xsimply'),
		'description' => __('Set layout alignment (default: "Center").', 'xsimply'),
		'section'    => 'xsimply_layout',
		'settings'   => 'xsimply_theme_layout_align',
		'type'       => 'select',
		'choices'     => array(
			'left' => __('Left', 'xsimply'),
			'center' => __( 'Center', 'xsimply'),
			'right' => __( 'Right', 'xsimply' )
		),
		'priority' => 1
	));
	
	$wp_customize->add_setting('xsimply_theme_layout_menu_align', array(
		'default'           => 'left',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	));

	$wp_customize->add_control('xsimply_theme_layout_menu_align', array(
		'label'      => __('Menu Alignment', 'xsimply'),
		'description' => __('Set menu alignment (default: "Left").', 'xsimply'),
		'section'    => 'xsimply_layout',
		'settings'   => 'xsimply_theme_layout_menu_align',
		'type'       => 'select',
		'choices'     => array(
			'left' => __('Left', 'xsimply'),
			'center' => __( 'Center', 'xsimply'),
			'right' => __( 'Right', 'xsimply' )
		),
		'priority' => 1
	));
	
	$wp_customize->add_section('xsimply_typography', array(
		'title' => __( 'Typography', 'xsimply' ),
		'priority' => 50
	));
	
	$wp_customize->add_setting('xsimply_typography_choices', array(
		'default'           => 'titillium_web',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	));

	$wp_customize->add_control('xsimply_typography_choices', array(
		'label'      => __('Font', 'xsimply'),
		'description' => __('Choose your font (default: Titillium Web). Note: System Ui is the font used in the user\'s operating system/browser.', 'xsimply'),
		'section'    => 'xsimply_typography',
		'settings'   => 'xsimply_typography_choices',
		'type'       => 'select',
		'choices'    => xsimply_fonts()
	));
	
}
add_action( 'customize_register', 'xsimply_customize_register' );

/**
 * Update theme style with background image
 */
function xsimply_update_theme_style_with_background_image() {

	if( get_background_image() && get_theme_mod('xsimply_theme_color') !== 'sea' ) {
		set_theme_mod( 'xsimply_theme_color', 'night' );
	}
	elseif(get_background_image() && get_theme_mod('xsimply_theme_color') !== 'night' ) {
		set_theme_mod( 'xsimply_theme_color', 'sea' );
	}

}
//add_action('init', 'xsimply_update_theme_style_with_background_image' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function xsimply_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function xsimply_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function xsimply_customize_preview_js() {
	wp_enqueue_script( 'xsimply-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'xsimply_customize_preview_js' );

/**
 * Set customizer scripts in head
 */
function xsimply_header_customizer_scripts() {
	
	$sb_act = (int) is_active_sidebar(1);

	?>

	<script type="text/javascript" id="xsimply-header-customizer-scripts">

	function xsimplySelectiveStripTags( string ) {

		var x = string.split( " " );
		var n = x.length;
		var t = Array();
		var regex = /<(.*?)>/gm;
		for( i = 0; i < n; i++ ) {
			
			if( x[i].search(regex) > -1 && x[i].search(/<\/?strong>/gm) > -1 ) {
					t[i] = 0;
			} 
			else if( x[i].search(regex) > -1 && x[i].search(/<\/?em>/gm) > -1 ) {
					t[i] = 0;
			}
			else {
					// t[i] = x[i].replace(/<[^>]*>?/gm, '');
					if( x[i].search(regex) > -1 ) {
						t[i] = 1;
					} else {
						t[i] = 0;
					}
			}
		}

		var xt = t.join(" ");

		if( xt.search('1') > -1 ) {
			return 1;
		} else {
			return 0;
		}

	}

	jQuery(function($) {
		
		wp.customize('xsimply_customize_active', function(setting) {
			setting.bind( function(value) {
				if( value == 1 ) {
					$('#customize-control-header_textcolor button.wp-color-result').prop('disabled', false );
					$('#customize-control-background_color button.wp-color-result').prop('disabled', false );
				} else {
					$('#customize-control-header_textcolor button.wp-color-result').prop('disabled', true );
					$('#customize-control-background_color button.wp-color-result').prop('disabled', true );
				}
			});
		});
		
		wp.customize( 'xsimply_theme_layout_wide', function( setting ) {
			setting.bind( function( value ) {
				var code = 'error';
				if ( value == 'thin' ) {
					setting.notifications.add( code, new wp.customize.Notification(
						code,
						{
							type: 'info',
							message: '<?php echo esc_html_e( 'Selecting "Thin", the sidebar will be moved to the footer', 'xsimply'); ?>'
						}
					) );
				} else {
					setting.notifications.remove( code );
				}
			} );
		} );
		
		wp.customize( 'xsimply_opacity', function( setting ) {
			setting.bind( function( value ) {
				var code = 'invalid_number';
				if ( value > 1 ) {
					setting.notifications.add( code, new wp.customize.Notification(
						code,
						{
							type: 'error',
							message: '<?php echo esc_html_e( "You can choose a number between 0 and 1. Decimal allowed.", "xsimply"); ?>'
						}
					) );
				} else {
					setting.notifications.remove( code );
				}
			} );

		} );

		wp.customize( 'xsimply_fixed_image_header', function( setting ) {
			setting.bind( function( value ) {
				var code 	  = 'invalid_setting';
				var bg_header = wp.customize.instance('xsimply_bg_header').get();
				if ( value == true && bg_header == 0 ) {
					setting.notifications.add( code, new wp.customize.Notification(
						code,
						{
							type: 'warning',
							message: '<?php echo esc_html_e( "Fixed Cover works only background image header!", "xsimply" ); ?>'
						}
					) );
				} else {
					setting.notifications.remove( code );
				}
			} );

		} );

		wp.customize( 'xsimply_my_site_cp', function( setting ) {
			setting.bind( function( value ) {
				var code 	  = 'tag_unallowed';

				if ( xsimplySelectiveStripTags(value) == 1 ) {

					setting.notifications.add( code, new wp.customize.Notification(
						code,
						{
							type: 'error',
							message: '<?php echo esc_html_e( "You are trying to use an html tag not allowed!", "xsimply" ); ?>'
						}
					) );
				} else {
					setting.notifications.remove( code );
				}
			} );

		} );

	} );
	
	</script><?php
}
add_action('customize_controls_print_scripts', 'xsimply_header_customizer_scripts');

/**
 * Set scripts in customizer footer
 */
function xsimply_footer_customizer_scripts() {
	
	$customize_active = get_theme_mod( 'xsimply_customize_active', 0 );
	
	if( false !== (bool) $customize_active ) {
		return;
	}
	
	?><script type="text/javascript" id="xsimply-footer-customizer-scripts">
	jQuery(function($) {		
		$('#customize-control-header_textcolor button.wp-color-result').prop('disabled', true );
		$('#customize-control-background_color button.wp-color-result').prop('disabled', true );
	});
	</script><?php
}
add_action('customize_controls_print_footer_scripts', 'xsimply_footer_customizer_scripts', 999 );
