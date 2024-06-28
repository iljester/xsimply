<?php
/**
 * The header part
 *
 * @package XSimply
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php if( xsimply_retrocompat() ) {
	wp_body_open();
} ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'xsimply' ); ?></a>

	<header id="masthead" class="site-header<?php echo has_header_image()? ' has-header-image' : ''; ?>">
		<div class="site-branding<?php xsimply_display_classes_for_header(); ?>">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$xsimply_description = get_bloginfo( 'description', 'display' );
			if ( $xsimply_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo esc_html( $xsimply_description ); ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<div class="custom-header">
			<?php xsimply_custom_header(); ?>
		</div>

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" data-menu="primary-menu" aria-expanded="false">
				<span class="button-menu"><?php esc_html_e('Menu', 'xsimply' ); ?></span>
			</button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu'
			) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
