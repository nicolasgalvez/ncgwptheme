<?php
	/**
	 * ncgbase functions file
	 *
	 * @package WordPress
	 * @subpackage ncgbase
	 * @since ncgbase 1.0
	 */

	/**
	 * Include library files like walkers, etc.
	 * These are reusable utils which should each have their own git. Maybe I should make the dir vendors?
	 */
	require_once "lib/templ.class.php";
	require_once "lib/ncg_walker_comment.php";
	require_once "lib/wp_bootstrap_navwalker.php";

	/**
	 * Initiate a new instance of my template helper. I use the NCG namespace, hopefully that's ok with your version of php.
	 * All this does is get a post query based on common criteria (like last 5) and display using a custom wrapper (like for a bootstrap slider)
	 * I will probably be removing this and start using the loop like God intended.
	 */
	$templ = new \NCG\Templ();

	// Add theme support
	// I'm not sure if I need theme support for these other post types. Not on the base I think, but I should do it anywayyy.
	add_theme_support('post-formats', array(
		'image',
		'quote',
		'status',
		'link'
	));
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size( 900, 350, array( 'center', 'center')  ); // 50 pixels wide by 50 pixels tall, crop from the center
	add_theme_support('automatic-feed-links');
	// This is the custom header. By default it will use the image found in /images/logo.png, if any.
	$custom_header_args = array(
		'default-image' => get_template_directory_uri() . '/images/logo.png',
	);
	add_theme_support('custom-header', $custom_header_args);
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );
	/**
	 * Support shortcode in custom excerpt (I had to do this for a client.)
	 * https://wordpress.org/support/topic/shortcodes-dont-work-in-excerpts
	 */
	function ncgbase_shortcode($data) {
		// modify post object here
		$data = do_shortcode($data);
		return ($data);
	}

	add_action('the_excerpt', 'ncgbase_shortcode');

	// And just in case, here's a function to strip the shortcode out again. Why? Who knows.
	function ncgbase_strip_shortcode($data) {
		// modify post object here
		$data = strip_shortcodes($data);
		return $data;
	}

	/**
	 * Add BootStrap 3 responsive embed to embed objects.
	 */
	function ncg_embed_html($html, $url, $attr, $post_id) {
		return '<div class="video-container">' . $html . '</div>';
	}

	add_filter('embed_oembed_html', 'ncg_embed_html', 99, 4);

	/**
	 * Register main navigation menu
	 */
	register_nav_menu('main-menu', __('Your sites main menu', 'ncgbase'));

	/**
	 * Register widget areas.
	 */
	if (function_exists('register_sidebars')) {
		register_sidebar(array(
			'id' => 'home-sidebar',
			'name' => __('Home widgets', 'ncgbase'),
			'description' => __('Shows on home page', 'ncgbase')
		));

		register_sidebar(array(
			'id' => 'footer-sidebar',
			'name' => __('Footer widgets', 'ncgbase'),
			'description' => __('Shows in the sites footer', 'ncgbase')
		));
		register_sidebar(array(
			'id' => 'sidebar',
			'name' => __('Sidebar Widgets', 'ncgbase'),
			'description' => __('Shows on the regular pages', 'ncgbase')
		));
	}
	add_action('widgets_init', 'register_sidebars');

	/**
	 * This was here when I got here. What is it? I'm taking it out and seeing what happens.
	 */
	if (!isset($content_width)) {
		//$content_width = 650;
	}

	/******************************************************************************\
	 Scripts and Styles
	 \******************************************************************************/

	/**
	 * Enqueue ncgbase scripts
	 * @return void
	 */
	function ncgbase_enqueue_scripts() {
		wp_enqueue_style('ncgbase-styles', get_stylesheet_uri(), array(), '1.0');
		//wp_enqueue_script('jquery');
		wp_enqueue_script('jquery', get_template_directory_uri() . '/node/bower_components/jquery/dist/jquery.min.js', array(), '1.0', true);
		wp_enqueue_script('bootstrap', get_template_directory_uri() . '/node/bower_components/bootstrap-sass/dist/js/bootstrap.min.js', array(), '1.0', true);
		wp_enqueue_script('default-scripts', get_template_directory_uri() . '/js/scripts.min.js', array(), '1.0', true);
		if (is_singular()) {
			wp_enqueue_script('comment-reply');
		}
	}

	add_action('wp_enqueue_scripts', 'ncgbase_enqueue_scripts');

	/**
	 * Include editor stylesheets
	 * @return void
	 */
	function ncgbase_editor_style() {
		add_editor_style('wp-editor-style.css');
	}

	add_action('init', 'ncgbase_editor_style');

	/******************************************************************************\
	 Content functions
	 \******************************************************************************/

	/**
	 * Displays meta information for a post
	 * @return void
	 */
	function ncgbase_post_meta() {

			echo '<i class = "glyphicon glyphicon-time"></i> ' . get_the_time(get_option('date_format')) . '.';

		if(get_the_category_list(', ')) {
			echo ' Posted in '. get_the_category_list(', ') . '.';
		}
		echo get_the_tag_list(' <i class = "glyphicon glyphicon-tags"></i> ', ', ');

		edit_post_link(__(' (edit)', 'ncgbase'), '<br><span class="edit-link"><i class = "glyphicon glyphicon-pencil"></i> ', '</span>');
	}

	/**
	 * For BootStrap. Set .active on first post. Not sure we need that though...
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
	 * This is for using the contact form for jetpack.
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
	 * Still need to add js refresh.
	 */
	function ncgbase_customize_register($wp_customize) {
		// get list of categories for dropdown
		$categories = get_categories();
		$cats = array('' => 'Select');
		foreach ($categories as $cat) {
			$cats[$cat -> slug] = $cat -> name;
		}

		$section = wp_get_theme() . '-section';

		$wp_customize -> add_panel(wp_get_theme() . '-panel', array(
			'priority' => 10,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __(wp_get_theme() . "'s options"),
			'description' => 'Options built for you.',
		));
		$wp_customize -> add_section($section, array(
			'title' => __('Homepage Goodies', 'ncgbase'),
			'priority' => 30,
			'panel' => wp_get_theme() . '-panel'
		));

		// Show map?
		$wp_customize -> add_setting('ncg_map_active', array(
			'default' => 'false',
			'transport' => 'refresh',
			'sanitize_callback' => 'ncgbase_sanitize_layout'
		));

		$wp_customize -> add_control(new WP_Customize_Control($wp_customize, 'ncg_map_active', array(
			'label' => __('Show map?', 'ncgbase'),
			'section' => $section,
			'settings' => 'ncg_map_active',
			'type' => 'radio',
			'choices' => array(
				'true' => __('Show', 'ncgbase'),
				'false' => __('Hide', 'ncgbase')
			)
		)));
		// The embed code for maps
		$wp_customize -> add_setting('ncg_map_embed', array(
			'default' => 'false',
			'transport' => 'refresh',
			'sanitize_callback' => 'ncgbase_sanitize_layout'
		));

		$wp_customize -> add_control(new WP_Customize_Control($wp_customize, 'ncg_map_embed', array(
			'label' => __('Paste the embed code from google', 'ncgbase'),
			'section' => $section,
			'settings' => 'ncg_map_embed',
			'type' => 'text'
		)));
		// Slider
		$wp_customize -> add_setting('ncg_slider_query', array(
			'default' => '',
			'transport' => 'refresh'
		));

		$wp_customize -> add_control(new WP_Customize_Control($wp_customize, 'ncg_slider_query', array(
			'label' => __('Post category for slider', 'ncgbase'),
			'section' => $section,
			'settings' => 'ncg_slider_query',
			'type' => 'select',
			'choices' => $cats
		)));
		// Action content types
		$wp_customize -> add_setting('ncg_action', array(
			'default' => '',
			'transport' => 'refresh',
			'sanitize_callback' => 'ncgbase_sanitize_layout'
		));

		$wp_customize -> add_control(new WP_Customize_Control($wp_customize, 'ncg_action', array(
			'label' => __('Call to action items', 'ncgbase'),
			'section' => $section,
			'settings' => 'ncg_action',
			'type' => 'select',
			'choices' => $cats
		)));
	}

	add_action('customize_register', 'ncgbase_customize_register');

	function ncgbase_sanitize_layout($value) {
		// nothing here yet.
		return $value;
	}

	/**
	 * Print custom header styles
	 * @return void
	 */
	function ncgbase_custom_header() {
		$styles = '';
		if ($color = get_header_textcolor()) {
			echo '<style type="text/css"> ' . '.site-header .logo .blog-name, .site-header .logo .blog-description {' . 'color: #' . $color . ';' . '}' . '</style>';
		}
	}

	add_action('wp_head', 'ncgbase_custom_header', 11);

	$custom_bg_args = array(
		'default-color' => 'fba919',
		'default-image' => '',
	);
	add_theme_support('custom-background', $custom_bg_args);

	/* End Customizer */

	/*
	 * WooCommerce
	 * Some basic BootStrap support.
	 */
	// Customize the WooCommerce breadcrumb
	if (!function_exists('woocommerce_breadcrumb')) {
		function woocommerce_breadcrumb($args = array()) {

			$defaults = array(
				'delimiter' => '<span class="divider">Delimiter</span>',
				'wrap_before' => '<ol class="breadcrumb">',
				'wrap_after' => '</ol>',
				'before' => '<li>',
				'after' => '</li>',
				'home' => null
			);

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
	 * ACF slider support. Uses 'get_field' to look for an image.
	 * returns true if image found, else checks for a thumbnail image to use.
	 * @return bool
	 */
	function get_slider_image() {
		if (function_exists('get_field')) {
			$image = get_field('slider_image');
			if (is_array($image)) {
				echo $image['url'];
				return true;
			}
		}

		if (has_post_thumbnail()) {
			ncg_get_thumb();
			return true;
		} else
			return false;
	}
	
	add_filter( 'comment_form_default_fields', 'bootstrap3_comment_form_fields' );
function bootstrap3_comment_form_fields( $fields ) {
    $commenter = wp_get_current_commenter();
    
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
    
    $fields   =  array(
        'author' => '<div class="form-group comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                    '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
        'email'  => '<div class="form-group comment-form-email"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                    '<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
        'url'    => '<div class="form-group comment-form-url"><label for="url">' . __( 'Website' ) . '</label> ' .
                    '<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>',
    );
    
    return $fields;
}

add_filter( 'comment_form_defaults', 'bootstrap3_comment_form' );
function bootstrap3_comment_form( $args ) {
    $args['comment_field'] = '<div class="form-group comment-form-comment">
            <label for="comment">' . _x( 'Comment', 'noun' ) . '</label> 
            <textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
        </div>';
    return $args;
}