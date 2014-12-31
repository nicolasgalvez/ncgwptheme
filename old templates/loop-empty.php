<?php
/**
 * ncgbase template for displaying an empty Loop
 *
 * @package WordPress
 * @subpackage ncgbase
 * @since ncgbase 1.0
 */
?>

<article id="post-none" class="post empty">

	<h1 class="post-title"><?php _e( 'Nothing Found', 'ncgbase' ); ?></h1>

	<div class="post-content">

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
				<?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'ncgbase' ), admin_url( 'post-new.php' ) ); ?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p>
				<?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ncgbase' ); ?>
			</p>

			<?php get_search_form(); ?>

		<?php else : ?>

			<p>
				<?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'ncgbase' ); ?>
			</p>

			<?php get_search_form(); ?>

		<?php endif; ?>

	</div>

</article>