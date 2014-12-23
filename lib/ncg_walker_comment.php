<?php
/** COMMENTS WALKER */
namespace NCG;
class NCG_Walker_Comment extends \Walker_Comment {
	/**
	 * Output a single comment.
	 * Modified to move meta to the bottom, and clean up layout.
	 *
	 * @access protected
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param object $comment Comment to display.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments.
	 */
	protected function comment( $comment, $depth, $args ) {
		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag; ?> <?php comment_class($this -> has_children ? 'parent' : ''); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID(); ?>">
		<?php endif; ?>

		<header class = "comment-heading">
		<div class="comment-author vcard">
			<?php
			if (0 != $args['avatar_size'])
				echo get_avatar($comment, $args['avatar_size']);
 ?>
			<?php printf(__('<p>%s</p>'), get_comment_author_link()); ?>
		</div>
	
		</header>
		<div class = "comment-body">
			<?php comment_text(get_comment_id(), array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
		<footer>
		<?php if ( '0' == $comment->comment_approved ) : ?>
			<div class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ) ?></div>
		<?php endif; ?>	
		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url(get_comment_link($comment -> comment_ID, $args)); ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time());
	 ?></a><?php edit_comment_link(__('(Edit)'), '&nbsp;&nbsp;', ''); ?>
			</div>
			<div class="reply">
				<?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
			</div>				
			</footer>	
<?php
	}
	}
