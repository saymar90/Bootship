<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @since Bootship 0.1
 */

get_header(); ?>

	<div id="primary" class="content-area error404">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<img  class="error-img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/404.svg" alt="">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Not Found', 'bootship' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-wrapper">
					<div class="page-content">
						<p><?php esc_html_e( 'Try searching or ', 'bootship' ); ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_html_e( 'Go back to Home', 'bootship' ); ?></a></p>

						<div class="error-404__search">
						<?php
							get_search_form();
						?>
						</div>
					</div><!-- .page-content -->
				</div>
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>