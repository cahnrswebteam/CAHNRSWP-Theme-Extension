<?php

include_once( 'includes/customizer/customizer.php' ); // Include CAHNRS customizer functionality.

add_action( 'init', 'disable_header_cruft' );
/**
 * Remove some stuff Wordpress adds to the header.
 */
function disable_header_cruft() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	remove_action( 'wp_head', 'feed_links_extra', 3 ); 
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'parent_post_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'start_post_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
	remove_action( 'wp_head', 'rel_canonical');
	remove_action( 'wp_head', 'wp_generator' );
}

add_action( 'wp_enqueue_scripts', 'extension_wp_enqueue_scripts', 21 );
/**
 * Enqueue scripts and styles required for front end pageviews.
 */
function extension_wp_enqueue_scripts() {
	wp_dequeue_style( 'spine-theme-extra' );
	wp_enqueue_script( 'extension-js', get_stylesheet_directory_uri() . '/js/extension.js', array( 'jquery' ) );
}

add_filter( 'body_class', 'cahnrswp_custom_body_class' );
/**
 * Body classes.
 */
function cahnrswp_custom_body_class( $classes ) {
	if ( get_post_meta( get_the_ID(), 'body_class', true ) ) {
		$classes[] = get_post_meta( get_the_ID(), 'body_class', true );
	}
	if ( is_customize_preview() ) {
		$classes[] = 'customizer-preview';
	}
	$classes[] = 'spine-' . esc_attr( spine_get_option( 'spine_color' ) );
	return $classes;
}

add_filter( 'theme_page_templates', 'remove_spine_page_templates' );
/**
 * Remove most of the Spine page templates.
 */
function remove_spine_page_templates( $templates ) {
	unset( $templates['templates/blank.php'] );
	unset( $templates['templates/halves.php'] );
	unset( $templates['templates/margin-left.php'] );
	unset( $templates['templates/margin-right.php'] );
	unset( $templates['templates/section-label.php'] );
	unset( $templates['templates/side-left.php'] );
	//unset( $templates['templates/side-right.php'] );
	unset( $templates['templates/single.php'] );
	return $templates;
}