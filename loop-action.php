<?php
/**
 * mhc template for displaying a Loop of action items.
 *
 * @package WordPress
 * @subpackage mhc
 * @since mhc 1.0
 */
?>
<article id="post-<?php the_ID();?>" <?php post_class('action'); ?>>
	<?php if ('' != get_the_post_thumbnail()) {
		the_post_thumbnail('thumbnail', array('class'=>'img-circle center-block'));
	} else {
		echo '<img class = "img-circle center-block" src="http://placehold.it/150x150" />';
	}
	?>
	<h1><a class="post-title" href = "<?php the_permalink(); ?>"><?php the_title();?></a></h1>
	<p><?php the_excerpt(); ?></p>
	<p>
		<a type = "button" class = "btn btn-primary" href = "<?php the_permalink(); ?>">Read More</a>
	</p>
</article>