<?php

include_once( __DIR__ . '/includes/customizer.php' ); // Include CAHNRS customizer functionality.

class WSU_Extension_Theme {

	/**
	 * Setup the hooks used in the theme.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 21 );
		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_filter( 'theme_page_templates', array( $this, 'theme_page_templates' ) );
		add_filter( 'wsuwp_people_html', array( $this, 'people_wrapper_html' ), 10, 3 );
		add_filter( 'wsuwp_people_sort_items', array( $this, 'people_sort' ), 10, 1 );
		add_filter( 'wsuwp_people_item_html', array( $this, 'people_html' ), 10, 3 );
		add_action( 'wp_ajax_nopriv_profile_request', array( $this, 'profile_request' ) );
		add_action( 'wp_ajax_profile_request', array( $this, 'profile_request' ) );
	}

	/**
 	 * Remove some stuff Wordpress adds to the header.
 	 */
	public function init() {
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
		add_filter( 'tiny_mce_plugins', array( $this, 'disable_emojis_tinymce' ) );
	}

	/**
	 * Filter function to remove the tinymce emoji plugin.
	 * 
	 * @param array $plugins  
	 * @return array Difference betwen the two arrays
	 */
	public function disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}

	/**
	 * Enqueue custom scripts.
	 */
	public function enqueue_scripts() {
		wp_dequeue_style( 'spine-theme-extra' );
		wp_enqueue_style( 'cahnrs', 'http://m1.wpdev.cahnrs.wsu.edu/global/cahnrs.css', array( 'wsu-spine' ) );
		wp_enqueue_script( 'cahnrs', 'http://m1.wpdev.cahnrs.wsu.edu/global/cahnrs.js', array( 'jquery' ) );
		//wp_enqueue_script( 'extension-js', get_stylesheet_directory_uri() . '/js/extension.js', array( 'jquery' ) );
		$post = get_post();
		if ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'wsuwp_people' ) ) {
			wp_enqueue_style( 'cahnrs-people', get_stylesheet_directory_uri() . '/css/people.css' );
			wp_enqueue_script( 'cahnrs-people', get_stylesheet_directory_uri() . '/js/people.js', array( 'jquery' ) );
			wp_localize_script( 'cahnrs-people', 'personnel', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		}
	}

	/**
	 * Add custom body classes.
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
		//unset( $templates['templates/side-right.php'] );
		unset( $templates['templates/single.php'] );
		return $templates;
	}

	/**
	 * Just a test.
	 */
	public function people_wrapper_html( $html, $people, $atts ) {
		if ( $atts['filters'] ) {
			$filters = explode( ',', $atts['filters'] );
		}
		ob_start();
		include_once( __DIR__ . '/parts/people-actions.php' );
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	/**
	 * Use the provided Content Syndicate filter to sort people results before displaying.
	 */
	public function people_sort( $people ) {
		usort( $people, array( $this, 'sort_alpha' ) );
		if ( 1 === ( count( $people ) % 2 ) ) {
			$person = new stdClass();
			$person->title = '';
			$person->office = '';
			$person->position_title = '';
			$person->email = '';
			$person->phone = '';
			$people[] = $person;
		}
		return $people;
	}
	/**
	 * Sort people alphabetically by their last name.
	 *
	 * @param stdClass $a Object representing a person.
	 * @param stdClass $b Object representing a person.
	 *
	 * @return int Whether person a's last name is alphabetically smaller or greater than person b's.
	 */
	public function sort_alpha( $a, $b ) {
		return strcasecmp( $a->last_name, $b->last_name );
	}

	/**
	 * Provide a custom HTML template for use with syndicated people.
	 *
	 * @param string   $html   The HTML to output for an individual person.
	 * @param stdClass $person Object representing a person received from people.wsu.edu.
	 *
	 * @return string The HTML to output for a person.
	 */
	public function people_html( $html, $person, $type ) {
		if ( isset( $person->working_titles[0] ) ) {
			$title = $person->working_titles[0];
		} else {
			$title = ucwords( strtolower( $person->position_title ) );
		}
		if ( ! empty( $person->email_alt ) ) {
			$email = $person->email_alt;
		} else {
			$email = $person->email;
		}
		if ( ! empty( $person->office_alt ) ) {
			$office = $person->office_alt;
		} else {
			$office = $person->office;
		}
		if ( ! empty( $person->phone_alt ) ) {
			$phone = $person->phone_alt;
		} else {
			$phone = $person->phone;
		}
		ob_start();
		include( __DIR__ . '/parts/people.php' );
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	/**
	 * AJAX profile request.
	 */
	public function profile_request() {
		if ( $_POST['profile'] ) {
			$response = wp_remote_get( 'https://people.wsu.edu/wp-json/posts/' . $_POST['profile'], array( 'sslverify' => false ) );
			if ( is_wp_error( $response ) ) {
				return '<!-- error -->';
			}
			$data = wp_remote_retrieve_body( $response );
			if ( empty( $data ) ) {
				return '<!-- error -->';
			}
			$person = json_decode( $data );
			include( __DIR__ . '/parts/profile.php' );
		}
		exit;
	}

}

new WSU_Extension_Theme();