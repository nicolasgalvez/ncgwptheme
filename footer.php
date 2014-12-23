<?php
/**
 * mhc template for displaying the footer
 *
 * @package WordPress
 * @subpackage mhc
 * @since mhc 1.0
 */
?>

			</div>
<footer id = "colophon">
	<div class = "container">
		<ul class="footer-widgets row"><?php
			if ( function_exists( 'dynamic_sidebar' ) ) :
				dynamic_sidebar( 'footer-sidebar' );
			endif; ?>
		</ul>
	</div>
	<div class = "container">
		<div class = "row">
			<p>Copyright &copy; <?php echo date('Y')?> <?php bloginfo('name'); ?></p>
		</div>
	</div>
</footer>
		<?php wp_footer(); ?>
	</body>
</html>