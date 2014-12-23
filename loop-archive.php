<?php
/**
 * mhc template for displaying the standard Loop
 *
 * @package WordPress
 * @subpackage mhc
 * @since mhc 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<header>
    <h1 class="post-title"><?php

        if ( is_singular() ) :
            the_title();
        else : ?>

            <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php
            the_title(); ?>
            </a><?php

        endif; ?>
    </h1>
    <small class="post-meta"><?php
        mhc_post_meta(); ?>
    </small>
</header>

 <?php
	if ( '' != get_the_post_thumbnail() ) : ?>
		<div class="post-thumbnail">
		    <?php the_post_thumbnail('thumbnail'); ?>
		</div>
	<?php endif; ?>

	<div class="post-content">
		<?php if ( is_front_page() || is_category() || is_archive() || is_search() || !is_singular()) : ?>
			<?php the_excerpt(); ?>
			<a class = "btn btn-primary" href="<?php the_permalink(); ?>"><?php _e( 'Read more &raquo;', 'mhc' ); ?></a>

		<?php else : ?>

			<?php the_content( __( 'Continue reading &raquo', 'mhc' ) ); ?>

		<?php endif; ?>

		<?php
			wp_link_pages(
				array(
					'before'           => '<div class="linked-page-nav"><p>'. __( 'This article has more parts: ', 'mhc' ),
					'after'            => '</p></div>',
					'next_or_number'   => 'number',
					'separator'        => ' ',
					'pagelink'         => __( '&lt;%&gt;', 'mhc' ),
				)
			);
		?>

	</div>

</article>