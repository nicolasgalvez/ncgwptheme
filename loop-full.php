<?php
/**
 * mhc template for displaying an full-width Loop
 *
 * @package WordPress
 * @subpackage mhc
 * @since mhc 1.0
 */
?>
<section id="post-<?php the_ID();?>" <?php post_class('full'); ?>>
	<div class="row">
		<article id="post-<?php the_ID();?>" <?php post_class(); ?>>
		<div>
			<?php if ('' != get_the_post_thumbnail()):?>
				<?php the_post_thumbnail();?>
			<?php endif;?>
		</div>
		<div>
			<a class="post-title" href = "<?php the_permalink(); ?>"><h2><?php the_title();?></h2></a>
			<?php the_content();?>
		</div>
		</article>
	</div>
</section>