<?php
/**
 * mhc Index template
 *
 * @package WordPress
 * @subpackage mhc
 * @since mhc 1.0
 */

get_header(); ?>

	<section class="page-content primary container" role="main">
		<div class = "row">
			<div class = "col-md-9">
				<?php
					if ( have_posts() ):

						while ( have_posts() ) : the_post();

							get_template_part( 'loop' );

							wp_link_pages(
								array(
									'before'           => '<div class="linked-page-nav"><p>' . sprintf( __( '<em>%s</em> is separated in multiple parts:', 'mhc' ), get_the_title() ) . '<br />',
									'after'            => '</p></div>',
									'next_or_number'   => 'number',
									'separator'        => ' ',
									'pagelink'         => __( '&raquo; Part %', 'mhc' ),
								)
							);

						endwhile;

					else :

						get_template_part( 'loop', 'empty' );

					endif;
				?>
				<div class="pagination">

					<?php get_template_part( 'template-part', 'pagination' ); ?>

				</div>
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