<?php
/**
 * Ranjani template for displaying the header
 *
 * @package WordPress
 * @subpackage Ranjani
 * @since Ranjani 1.0
 */
// get rid of the extra <p> tags wp might throw around. 
 remove_filter( 'the_content', 'wpautop' ); 
?>
<div id="post-<?php the_ID();?>" <?php post_class("item"); ?>>
	<?php if ('' != get_the_post_thumbnail()):?>
		<?php the_post_thumbnail();?>
	<?php endif;?>
	<div class="carousel-caption">
		<article id="post-<?php the_ID();?>" <?php post_class(); ?>>
			<h1 class="post-title"><?php the_title();?></h1>
			<div class="post-meta">
				<?php ranjani_post_meta();?>
			</div>
			<div class="post-content">
				<?php the_content(__('Continue reading &raquo', 'ranjani'));?>
			</div>
		</article>
	</div>
</div>