<?php
/**
 * Templ
 * Some stuff for helping with Wordpress
 */

namespace NCG;

class Templ {
	private $template_dir = 'templates';
	public function __construct() {
	}
	public function query($args = array('posts_per_page' => 3), $slug = false) {
		global $wp_query;
		// The Query
		$wp_query = new \WP_Query($args);
		// The Loop
		while ($wp_query->have_posts()) {
			$wp_query->the_post();
			$this->render($slug);
		}
		/* Restore original Post Data
		 * NB: Because we are using new WP_Query we aren't stomping on the
		 * original $wp_query and it does not need to be reset with
		 * wp_reset_query(). We just need to set the post data back up with
		 * wp_reset_postdata().
		 */
		wp_reset_postdata();
		return $wp_query;
	}
	private function render($slug) {
		get_template_part('loop', $slug);
	}
}