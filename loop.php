<?php
/**
 * ncgbase template for displaying the standard Loop
 *
 * @package WordPress
 * @subpackage ncgbase
 * @since ncgbase 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<header>
    <h2 class="post-title"><?php

        if ( is_singular() ) :
            the_title();
        else : ?>

            <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php
            the_title(); ?>
            </a><?php

        endif; ?>
    </h2>
    <small class="post-meta"><?php
        ncgbase_post_meta(); ?>
    </small>
</header>
	<div class="post-content">
		<?php if ( is_front_page() || is_category() || is_archive() || is_search() || !is_singular()) : ?>
            <?php

            if ( '' != get_the_post_thumbnail() ) : ?>
                <?php the_post_thumbnail('thumbnail'); ?><?php
            endif; ?>
			<?php the_excerpt(); ?>
			<a class = "btn btn-primary" href="<?php the_permalink(); ?>"><?php _e( 'Read more &raquo;', 'ncgbase' ); ?></a>

		<?php else : ?>

			<?php the_content( __( 'Continue reading &raquo', 'ncgbase' ) ); ?>

		<?php endif; ?>

		<?php
			wp_link_pages(
				array(
					'before'           => '<div class="linked-page-nav"><p>'. __( 'This article has more parts: ', 'ncgbase' ),
					'after'            => '</p></div>',
					'next_or_number'   => 'number',
					'separator'        => ' ',
					'pagelink'         => __( '&lt;%&gt;', 'ncgbase' ),
				)
			);
		?>

	</div>

</article>