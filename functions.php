<?php

add_action( 'wp_enqueue_scripts', 'extension_wp_enqueue_scripts', 21 );
/**
 * Enqueue scripts and styles required for front end pageviews.
 */
function extension_wp_enqueue_scripts() {
	wp_dequeue_style( 'spine-theme-extra' );
	wp_enqueue_script( 'extension-js', get_stylesheet_directory_uri() . '/js/extension.js', array( 'jquery' ), '' );
}

add_filter( 'spine_option_defaults', 'extension_spine_option_defaults' );
/**
 * Reset some defaults for the options set in the customizer for the Spine theme.
 */
function extension_spine_option_defaults( $defaults ) {
	$defaults['campus_location'] = 'extension';
	$defaults['bleed'] = false;
	$defaults['articletitle_show'] = false;
	$defaults['articletitle_header'] = true;
	return $defaults;
}