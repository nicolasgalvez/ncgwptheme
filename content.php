<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 10/24/14
 * Time: 6:20 PM
 */
if ( have_posts() ):

	while ( have_posts() ):the_post();
		get_template_part( 'loop', get_post_format() );

	endwhile;

else:

	get_template_part( 'loop', 'empty' );

endif;