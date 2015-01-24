<?php
/**
 * ncgbase template for displaying Archives
 *
 * @package WordPress
 * @subpackage ncgbase
 * @since ncgbase 1.0
 */

get_header(); ?>

	<section class="page-content primary container" role="main">
		<div class = "row">
			<div class = "col-md-9">
				
		<?php if ( have_posts() ) : ?>

			<h1 class="archive-title">
				<?php
					if ( is_category() ):
						printf( __( 'Category Archives: %s', 'ncgbase' ), single_cat_title( '', false ) );

					elseif ( is_tag() ):
						printf( __( 'Tag Archives: %s', 'ncgbase' ), single_tag_title( '', false ) );

					elseif ( is_tax() ):
						$term     = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
						$taxonomy = get_taxonomy( get_query_var( 'taxonomy' ) );
						printf( __( '%s Archives: %s', 'ncgbase' ), $taxonomy->labels->singular_name, $term->name );

					elseif ( is_day() ) :
						printf( __( 'Daily Archives: %s', 'ncgbase' ), get_the_date() );

					elseif ( is_month() ) :
						printf( __( 'Monthly Archives: %s', 'ncgbase' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'ncgbase' ) ) );

					elseif ( is_year() ) :
						printf( __( 'Yearly Archives: %s', 'ncgbase' ), get_the_date( _x( 'Y', 'yearly archives date format', 'ncgbase' ) ) );

					elseif ( is_author() ) : the_post();
						printf( __( 'All posts by %s', 'ncgbase' ), get_the_author() );

					else :
						_e( 'Archives', 'ncgbase' );

					endif;
				?>
			</h1><?php

			if ( is_category() || is_tag() || is_tax() ):
				$term_description = term_description();
				if ( ! empty( $term_description ) ) : ?>

					<div class="archive-description"><?php
						echo $term_description; ?>
					</div><?php

				endif;
			endif;

			if ( is_author() && get_the_author_meta( 'description' ) ) : ?>

				<div class="archive-description">
					<?php the_author_meta( 'description' ); ?>
				</div><?php

			endif;
			// Get rid of the special shortcode callback we made.
			remove_action('the_excerpt', 'ncgbase_shortcode');
			add_action('the_excerpt', 'ncgbase_strip_shortcode');
			while ( have_posts() ) : the_post();
				get_template_part( 'content', 'archive' );
			endwhile;

		else :

			get_template_part( 'loop', 'empty' );

		endif; ?>
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