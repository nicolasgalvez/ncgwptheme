<?php
/**
 * mhc template for the sidebar
 *
 * @package WordPress
 * @subpackage mhc
 * @since mhc 1.0
 */
?>
<?php if ( is_active_sidebar( 'Sidebar' ) ) : ?>
	<ul>
		<?php dynamic_sidebar('Sidebar'); ?>
	</ul>
<?php else: ?>
	<div class = "well">
		<h2>You have no widgets!</h2>
		<a class = "btn btn-primary" href = "<?php echo get_admin_url(); ?>/widgets.php">Add Widgets</a>
	</div>
<?php endif; ?>