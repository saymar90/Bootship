<?php
/**
 * Bootship back compat functionality
 *
 * Prevents Bootship from running on WordPress versions prior to 3.6,
 * since this theme is not meant to be backward compatible and relies on
 * many new functions and markup changes introduced in 3.6.
 *
 * @package WordPress
 * @since Bootship 0.1
 */

/**
 * Prevent switching to Bootship on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Bootship 0.1
 */
function bootship_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'bootship_upgrade_notice' );
}
add_action( 'after_switch_theme', 'bootship_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Bootship on WordPress versions prior to 3.6.
 *
 * @since Bootship 0.1
 */
function bootship_upgrade_notice() {
	$message = sprintf( __( 'Bootship requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'bootship' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevent the Theme Customizer from being loaded on WordPress versions prior to 3.6.
 *
 * @since Bootship 0.1
 */
function bootship_customize() {
	wp_die( sprintf( __( 'Bootship requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'bootship' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'bootship_customize' );

/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 3.4.
 *
 * @since Bootship 0.1
 */
function bootship_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Bootship requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'bootship' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'bootship_preview' );
