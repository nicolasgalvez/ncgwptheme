<?php
/**
 * ncgbase Index template
 *
 * @package WordPress
 * @subpackage ncgbase
 * @since ncgbase 1.0
 */

get_header(); ?>
	<section class="page-content primary container" role="main">
		<div class = "row">
			<div class = "col-md-9">
				<?php
					if ( have_posts() ):
						while ( have_posts() ) : the_post();
							get_template_part( 'loop', get_post_format() );
						endwhile;
					else :
						get_template_part( 'loop', 'empty' );
					endif;
				?>
				<?php get_template_part( 'template-part', 'pagination' ); ?>

				<?php if (is_single()): ?>
					  <?php comments_template(); ?>
				<?php endif; ?>
			</div>
			<div id = "sidebar" class = "col-md-3">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</section>
<?php get_footer(); ?>