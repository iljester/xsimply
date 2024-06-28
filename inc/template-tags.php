<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package X-Simply
 */

if ( ! function_exists( 'xsimply_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function xsimply_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'xsimply' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'xsimply_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function xsimply_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'xsimply' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">'
			. esc_html( get_the_author() ) . '</a>'
			. '</span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'xsimply_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function xsimply_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_label = '<span class="cat-label">' . esc_html__('Archived:', 'xsimply' ) . '</span>';
			$categories_list  = get_the_category_list( esc_html_x( ', ', 'tags item separator', 'xsimply' ) );
			if ( $categories_list ) {
				/* translators: 2: label, list of categories. */
				printf( '<span class="cat-links">' . esc_html__( '%1$s %2$s', 'xsimply' ) . '</span>', $categories_label, $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_label = '<span class="tag-label">' . esc_html__('Tagged:', 'xsimply' ) . '</span>';
			$tags_list  = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'xsimply' ) );
			if ( $tags_list ) {
				/* translators: 2: label, list of tags. */
				printf( '<span class="tags-links">' . esc_html__( '%1$s %2$s', 'xsimply' ) . '</span>', $tags_label, $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		echo '<span class="sub-entry-footer">';

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'xsimply' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'xsimply' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);

		echo '</span>';
		
	}
endif;

if ( ! function_exists( 'xsimply_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function xsimply_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

if( ! function_exists('xsimply_get_my_site_cp') ) :
	/**
	 * Displays copyright and others information for this site
	 */
	function xsimply_get_my_site_cp() {

		$site_cp = get_theme_mod('xsimply_my_site_cp', '{copy}{year} {blogname}');

		if( empty( $site_cp ) ) {
			return;
		}

		$string = str_replace( array(
			'{copy}', '{year}', '{blogname}'
		),
		array( 
			'&copy;', gmdate('Y'), get_bloginfo('name')
		), $site_cp );
		$filtered = xsimply_html_filter( $string );
		$output = nl2br( $filtered );

		printf( '<div class="my-site-cp"><p>%s</p></div>', $output ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}

endif;

if( ! function_exists('xsimply_display_classes_for_header') ) :
	/**
	 * Display classes for header
	 * 
	 * Detects if custom logo is set and a class is added
	 * Detects if header text is displayed and a class is added
	 */
	function xsimply_display_classes_for_header() {

		$has_custom_logo = has_custom_logo() ? ' has-custom-logo' : '';
		$has_header_title = display_header_text() ? ' has-header-title' : '';

		echo esc_attr( $has_custom_logo . $has_header_title );

	}
endif;

if ( ! function_exists('xsimply_display_credits') ) :
	/**
	 * Display credits for ClassicPress and Theme
	 */
	function xsimply_display_credits() { 

		$cms_credits = (bool) get_theme_mod('xsimply_hide_cms_credits', 0);
		$theme_credits = (bool) get_theme_mod('xsimply_hide_theme_credits', 0);
		
		if( $cms_credits === false || $theme_credits === false ) :
		?>

		<div class="site-info">
				<?php 
				// cms credits
				if( $cms_credits === false ) :
				printf( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					esc_html__('Powered by %s', 'xsimply' ), '<a href="' . XSIMPLY_CMS_LINK . '">WordPress</a>' ); 
				endif;

				// separator
				if( $cms_credits === false && $theme_credits === false ) : ?>
					<span class="sep"> /&nbsp;/ </span>
				<?php endif;
				
				// theme credits
				if( $theme_credits === false ) :
				printf( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					esc_html__('Theme %s by Il Jester', 'xsimply' ), '<a href="' . XSIMPLY_THEME_LINK . '">XSimply</a>' );
				endif;
				?>
		</div><!-- .site-info -->
		<?php

		endif;
	}
endif;
