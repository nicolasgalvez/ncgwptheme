<?php
/**
 * mhc template for displaying the hero slider Loop.
 *
 * @package WordPress
 * @subpackage mhc
 * @since mhc 1.0
 */
// get rid of the extra <p> tags wp might throw around. 
 remove_filter( 'the_content', 'wpautop' ); 
?>
<div id="post-<?php the_ID();?>" <?php post_class("item"); ?> style = "background-image:url(<?php get_slider_image(); ?>)">
	<?php if ('' != get_the_post_thumbnail()):?>
		<?php //the_post_thumbnail();?>
	<?php endif;?>
	<div class="carousel-caption">
		<div class = "row">
			<article>
				<a href = "<?php the_permalink(); ?>"><h1 class="post-title"><?php the_title();?></h1></a>
				<div class="post-content">
					<?php the_excerpt(__('Continue reading &raquo', 'mhc'));?>
				</div>
			</article>
		</div>
		
	</div>
</div>