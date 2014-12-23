<?php
	/**
	 * mhc functions file
	 *
	 * @package WordPress
	 * @subpackage mhc
	 * @since mhc 1.0
	 */
	require_once "lib/templ.class.php";
	require_once "lib/ncg_walker_comment.php";
	require_once "lib/wp_bootstrap_navwalker.php";
	$templ = new \NCG\Templ();
	/******************************************************************************\
	 Theme support, standard settings, menus and widgets
	 \******************************************************************************/

	add_theme_support('post-formats', array('image', 'quote', 'status', 'link'));
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	$custom_header_args = array('width' => 330, 'height' => 99, 'default-image' => get_template_directory_uri() . '/images/logo.jpg', );
	add_theme_support('custom-header', $custom_header_args);

	/**
	 * Support shortcode in custom excerpt
	 * https://wordpress.org/support/topic/shortcodes-dont-work-in-excerpts
	 */

	function mhc_shortcode($data) {
		// modify post object here
		$data = do_shortcode($data);
		return ($data);
	}

	add_action('the_excerpt', 'mhc_shortcode');

	function mhc_strip_shortcode($data) {
		// modify post object here
		$data = strip_shortcodes($data);
		return $data;
	}

	/**
	 * Add bootstrap responsive embed to embed objects.
	 */
	add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);

	function my_embed_oembed_html($html, $url, $attr, $post_id) {
		return '<div class="video-container">' . $html . '</div>';
	}

	/**
	 * Print custom header styles
	 * @return void
	 */
	function mhc_custom_header() {
		$styles = '';
		if ($color = get_header_textcolor()) {
			echo '<style type="text/css"> ' . '.site-header .logo .blog-name, .site-header .logo .blog-description {' . 'color: #' . $color . ';' . '}' . '</style>';
		}
	}

	add_action('wp_head', 'mhc_custom_header', 11);

	$custom_bg_args = array('default-color' => 'fba919', 'default-image' => '', );
	add_theme_support('custom-background', $custom_bg_args);

	register_nav_menu('main-menu', __('Your sites main menu', 'mhc'));

	if (function_exists('register_sidebars')) {
		register_sidebar(array('id' => 'home-sidebar', 'name' => __('Home widgets', 'mhc'), 'description' => __('Shows on home page', 'mhc')));

		register_sidebar(array('id' => 'footer-sidebar', 'name' => __('Footer widgets', 'mhc'), 'description' => __('Shows in the sites footer', 'mhc')));
		register_sidebar(array('id' => 'sidebar', 'name' => __('Sidebar Widgets', 'mhc'), 'description' => __('Shows on the regular pages', 'mhc')));
	}
	add_action('widgets_init', 'register_sidebars');

	if (!isset($content_width)) {
		$content_width = 650;
	}

	/**
	 * Include editor stylesheets
	 * @return void
	 */
	function mhc_editor_style() {
		add_editor_style('css/wp-editor-style.css');
	}

	add_action('init', 'mhc_editor_style');

	/******************************************************************************\
	 Scripts and Styles
	 \******************************************************************************/

	/**
	 * Enqueue mhc scripts
	 * @return void
	 */
	function mhc_enqueue_scripts() {
		wp_enqueue_style('mhc-styles', get_stylesheet_uri(), array(), '1.0');
		//wp_enqueue_script('jquery');
		//wp_enqueue_script('bootstrap', get_template_directory_uri() . '/scss/vendor/bootstrap/javascripts/bootstrap.js', array(), '1.0', true);
		wp_enqueue_script('default-scripts', get_template_directory_uri() . '/js/scripts.min.js', array(), '1.0', true);
		if (is_singular()) {
			wp_enqueue_script('comment-reply');
		}
	}

	add_action('wp_enqueue_scripts', 'mhc_enqueue_scripts');

	/******************************************************************************\
	 Content functions
	 \******************************************************************************/

	/**
	 * Displays meta information for a post
	 * @return void
	 */
	function mhc_post_meta() {
		if (get_post_type() == 'post') {
			echo sprintf(__('Posted %s in %s. by %s. %s', 'mhc'), '<i class = "glyphicon glyphicon-time"></i> ' . get_the_time(get_option('date_format')), get_the_category_list(', '), get_the_author_link(), get_the_tag_list('<br><i class = "glyphicon glyphicon-tags"></i> ', ', '));
		}
		edit_post_link(__(' (edit)', 'mhc'), '<br><span class="edit-link"><i class = "glyphicon glyphicon-pencil"></i> ', '</span>');
	}

	/**
	 * booty
	 */
	add_filter('post_class', 'wps_first_post_class');
	function wps_first_post_class($classes) {
		global $wp_query;
		if (0 == $wp_query -> current_post) {
			$classes[] = 'active';
		}
		return $classes;
	}

	/**
	 * Remove jetpack form stylesheet
	 */
	function remove_grunion_style() {
		wp_deregister_style('grunion.css');
	}

	add_action('wp_print_styles', 'remove_grunion_style');

	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function theme_name_wp_title($title, $sep) {
		if (is_feed()) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$magic = get_bloginfo('name', 'display');

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo('description', 'display');
		if ($site_description && (is_home() || is_front_page())) {
			$magic .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if (($paged >= 2 || $page >= 2) && !is_404()) {
			$magic .= " $sep " . sprintf(__('Page %s', '_s'), max($paged, $page));
		}

		return $magic . $title;
	}

	add_filter('wp_title', 'theme_name_wp_title', 10, 2);

	/**
	 * Customizer Controls
	 */
	function mhc_customize_register($wp_customize) {
		// get list of categories for dropdown
		$categories = get_categories();
		$cats = array('' => 'Select');
		foreach ($categories as $cat) {
			$cats[$cat -> slug] = $cat -> name;
		}

		$section = wp_get_theme() . '-section';

		$wp_customize -> add_panel(wp_get_theme() . '-panel', array('priority' => 10, 'capability' => 'edit_theme_options', 'theme_supports' => '', 'title' => __(wp_get_theme() . "'s options"), 'description' => 'Options built for you.', ));
		$wp_customize -> add_section($section, array('title' => __('Homepage Goodies', 'mhc'), 'priority' => 30, 'panel' => wp_get_theme() . '-panel'));

		// Show map?
		$wp_customize -> add_setting('ncg_map_active', array('default' => 'false', 'transport' => 'refresh', 'sanitize_callback' => 'mhc_sanitize_layout'));

		$wp_customize -> add_control(new WP_Customize_Control($wp_customize, 'ncg_map_active', array('label' => __('Show map?', 'mhc'), 'section' => $section, 'settings' => 'ncg_map_active', 'type' => 'radio', 'choices' => array('true' => __('Show', 'mhc'), 'false' => __('Hide', 'mhc')))));
		// The embed code for maps
		$wp_customize -> add_setting('ncg_map_embed', array('default' => 'false', 'transport' => 'refresh', 'sanitize_callback' => 'mhc_sanitize_layout'));

		$wp_customize -> add_control(new WP_Customize_Control($wp_customize, 'ncg_map_embed', array('label' => __('Paste the embed code from google', 'mhc'), 'section' => $section, 'settings' => 'ncg_map_embed', 'type' => 'text')));
		// Slider
		$wp_customize -> add_setting('ncg_slider_query', array('default' => '', 'transport' => 'refresh'));

		$wp_customize -> add_control(new WP_Customize_Control($wp_customize, 'ncg_slider_query', array('label' => __('Post category for slider', 'mhc'), 'section' => $section, 'settings' => 'ncg_slider_query', 'type' => 'select', 'choices' => $cats)));
		// Slider
		$wp_customize -> add_setting('ncg_action', array('default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'mhc_sanitize_layout'));

		$wp_customize -> add_control(new WP_Customize_Control($wp_customize, 'ncg_action', array('label' => __('Call to action items', 'mhc'), 'section' => $section, 'settings' => 'ncg_action', 'type' => 'select', 'choices' => $cats)));
	}

	add_action('customize_register', 'mhc_customize_register');

	function mhc_sanitize_layout($value) {
		// nothing here yet.
		return $value;
	}

	/* End Customizer */

	/*
	 * Woocommerce
	 */
	// Customize the WooCommerce breadcrumb
	if (!function_exists('woocommerce_breadcrumb')) {
		function woocommerce_breadcrumb($args = array()) {

			$defaults = array('delimiter' => '<span class="divider">Delimiter</span>', 'wrap_before' => '<ol class="breadcrumb">', 'wrap_after' => '</ol>', 'before' => '<li>', 'after' => '</li>', 'home' => null);

			$args = wp_parse_args($args, $defaults);
			// Don't display on product single page
			if (is_singular('product')) {
			} else {
				wc_get_template('global/breadcrumb.php', $args);
			}
		}

	}
	function ncg_get_thumb($size) {
		global $post;
		$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post -> ID), $size);
		echo $thumb['0'];
	}

	/**
	 * ACF
	 */
	function get_slider_image() {
		if (function_exists('get_field')) {
			$image = get_field('slider_image');
			if(is_array($image)) {
				echo $image['url'];
		} elseif (has_post_thumbnail()) {
			ncg_get_thumb('full');
		}
		}
	}
