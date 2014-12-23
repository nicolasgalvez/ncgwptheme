<?php
$latest_blog_posts = new WP_Query(array('posts_per_page' => 3));

if ($latest_blog_posts->have_posts()):
	while ($latest_blog_posts->have_posts()):$latest_blog_posts->the_post();
		get_template_part('helpers/tile');
	endwhile;
endif;