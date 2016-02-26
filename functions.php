<?php

include_once( __DIR__ . '/includes/customizer.php' ); // Include CAHNRS customizer functionality.

class WSU_Extension_Theme {

	/**
	 * Setup the hooks used in the theme.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'remove_header_meta' ) );
		add_action( 'admin_init', array( $this, 'editor_styles' ) );
		add_filter( 'tiny_mce_plugins', array( $this, 'disable_emojis_tinymce' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1 );
		add_action( 'wp_enqueue_scripts', array( $this, 'dequeue_scripts' ), 21 );
		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_filter( 'theme_page_templates', array( $this, 'theme_page_templates' ) );
		add_action( 'init', array( $this, 'global_menu' ) );
		add_filter( 'nav_menu_css_class', array( $this, 'global_menu_classes' ), 10, 3 );
		add_filter( 'nav_menu_item_id', array( $this, 'global_menu_ids' ), 10, 3 );
		add_filter( 'rest_api_init', array( $this, 'register_global_menu_route' ) );
	}

	/**
 	 * Remove certain things Wordpress adds to the header.
 	 */
	public function remove_header_meta() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );	
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
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

	/**
	 * Editor stylesheet
	 */
	public function editor_styles() {
		add_editor_style( '/css/editor.css' );
	}

	/**
	 * Filter function to remove the TinyMCE emoji plugin.
	 *
	 * @param array $plugins The list of default TinyMCE plugins.
	 *
	 * @return array Modified list of default TinyMCE plugins.
	 */
	public function disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}

	/**
	 * Enqueue scripts and styles for the front end.
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'cahnrs', 'http://repo.wsu.edu/cahnrs/0/cahnrs.min.css', array( 'spine-theme' ) );
		wp_enqueue_style( 'spine-theme-child', get_stylesheet_directory_uri() . '/style.css', array( 'cahnrs' ) );
		wp_enqueue_script( 'cahnrs', 'http://repo.wsu.edu/cahnrs/0/cahnrs.min.js', array( 'jquery' ) );
	}

	/**
	 * Dequeue Spine Bookmark stylesheet.
	 */
	public function dequeue_scripts() {
		wp_dequeue_style( 'spine-theme-extra' );
	}

	/**
	 * Add custom body classes.
	 *
	 * @param array $classes Current list of body classes.
	 *
	 * @return array Modified list of body classes.
	 */
	function body_class( $classes ) {
		if ( get_post_meta( get_the_ID(), 'body_class', true ) ) {
			$classes[] = get_post_meta( get_the_ID(), 'body_class', true );
		}
		if ( is_customize_preview() ) {
			$classes[] = 'customizer-preview';
		}
		$classes[] = 'spine-' . esc_attr( spine_get_option( 'spine_color' ) );
		return $classes;
	}

	/**
	 * Remove most of the Spine page templates.
	 */
	public function theme_page_templates( $templates ) {
		unset( $templates['templates/blank.php'] );
		unset( $templates['templates/halves.php'] );
		unset( $templates['templates/margin-left.php'] );
		unset( $templates['templates/margin-right.php'] );
		unset( $templates['templates/section-label.php'] );
		unset( $templates['templates/side-left.php'] );
		unset( $templates['templates/side-right.php'] );
		//unset( $templates['templates/single.php'] );
		return $templates;
	}

	/**
	 * Set up the 'global' navigation menu.
	 */
	public function global_menu() {
		register_nav_menus( array(
			'global' => 'Global Menu',
		) );
	}

	/**
	 * Remove all classes from 'global' menu items.
	 *
	 * @param array    $classes Current list of nav menu item classes.
	 * @param WP_Post  $item    Post object representing the menu item.
	 * @param stdClass $args    Arguments used to create the menu.
	 *
	 * @return array Modified list of nav menu classes.
	 */
	public function global_menu_classes( $classes, $item, $args ) {
		if ( 'global' === $args->theme_location ) {
			$classes = array();
		}
		return $classes;
	}

	/**
	 * Remove ids from 'global' menu items.
	 *
	 * @param string   $menu_id Current nav menu item id.
	 * @param WP_Post  $item    Post object representing the menu item.
	 * @param stdClass $args    Arguments used to create the menu.
	 *
	 * @return string Modified menu id.
	 */
	public function global_menu_ids( $menu_id, $item, $args ) {
		if ( 'global' === $args->theme_location ) {
			$menu_id = '';
		}
		return $menu_id;
	}

	/**
	 * Register 'global' menu route for WP API v2.
	 *
	 * @return array
	 */
	public function register_global_menu_route() {
		register_rest_route( 'wp/v2', '/global-menu', array(
			array(
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_global_menu' ),
			)
		) );
	}

	/**
	 * Get 'global' menu.
	 *
	 * @return string Menu markup.
	 */
	public static function get_global_menu() {
		if ( has_nav_menu( 'global' ) ) {
			ob_start();
			$global_nav_args = array(
				'theme_location'  => 'global',
				'container'       => false,
				'container_class' => false,
				'container_id'    => false,
				'menu_class'      => null,
				'menu_id'         => null,
				'echo'            => true,
				'fallback_cb'     => false,
				'items_wrap'      => '<ul>%3$s</ul>',
				'depth'           => 1,
			);
			wp_nav_menu( $global_nav_args );
			return ob_get_clean();
		} else {
			return '';
		}
	}

}

new WSU_Extension_Theme();