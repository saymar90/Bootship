<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @since Bootship 0.1
 */
?>

		</div><!-- #main -->
		<footer id="colophon" class="site-footer container" role="contentinfo">
			<div class="site-info">
				<?php do_action( 'bootship_credits' ); ?>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'bootship' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'bootship' ); ?>"><?php printf( __( 'Proudly powered by %s', 'bootship' ), 'WordPress' ); ?></a>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>
