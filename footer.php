<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package XSimply
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php xsimply_get_my_site_cp(); ?>
		<div class="search-box"> 
			<?php get_search_form(); ?>
		</div>
		<?php xsimply_display_credits(); ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
