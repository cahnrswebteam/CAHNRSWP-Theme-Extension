<?php

include_once( 'includes/customizer/customizer.php' ); // Include CAHNRS customizer functionality.

add_action( 'wp_enqueue_scripts', 'extension_wp_enqueue_scripts', 21 );
/**
 * Enqueue scripts and styles required for front end pageviews.
 */
function extension_wp_enqueue_scripts() {
	wp_dequeue_style( 'spine-theme-extra' );
	wp_enqueue_script( 'extension-js', get_stylesheet_directory_uri() . '/js/extension.js', array( 'jquery' ), '' );
}

add_filter( 'body_class', 'cahnrswp_custom_body_class' );
/**
 * Something like this would come in handy...
 */
function cahnrswp_custom_body_class( $classes ) {
	if ( get_post_meta( get_the_ID(), 'body_class', true ) ) {
		$classes[] = get_post_meta( get_the_ID(), 'body_class', true );
	}
	return $classes;
}