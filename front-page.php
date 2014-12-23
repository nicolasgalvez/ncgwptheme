<?php
/**
 * mhc template for displaying the Front-Page
 *
 * @package WordPress
 * @subpackage mhc
 * @since mhc 1.0
 */

get_header();?>
	<section id="hero">
		<!-- how bout a carousel? -->
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

			<!-- Wrapper for slides -->
			<div class="carousel-inner">
				<?php
				if(term_exists(get_theme_mod('ncg_slider_query'))) {
					// If there is a slide category then load the slides.
					$templ->query( array( 'category_name' => get_theme_mod('ncg_slider_query') ), 'slide' );
				} else {
					// if not, load the latest 3 posts.
					$templ->query( array( 'posts_per_page' => 3 ), 'slide' );
				}
				?>
			</div>
			<!-- Controls -->
			<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
			</a>
		</div>
	</section>

	<!-- The call to action section -->
	<section id = "action" class="container">
		<div class="row">
				<a href = "#action"  class = "action-title"><h1 class = "align-center">
						Our Story
					</h1>
					<p class = "align-center"><i class = "glyphicon glyphicon-chevron-down"></i></p>
				</a>
			<?php
			if(term_exists(get_theme_mod('ncg_action'))) {
				// If there is an action category, load it.
				$templ->query( array( 'category_name' => get_theme_mod('ncg_action'), 'posts_per_page' => 3 ), 'action' );
			} else {
				// if not, load the latest 3 posts.
				$templ->query( array( 'posts_per_page' => 2 ), 'action' );
			}
			?>
			<hr>
		</div>
	</section>
<?php if(get_theme_mod('ncg_map_active') == 'true'):?>
	<section id = "map" class = "container">
		<div class = "row">
                <h1>Location</h1>
                <p class = "lead">Directions to the studio</p>
			<div  class = "embed-responsive embed-responsive-16by9">
				<div class="overlay" onClick="style.pointerEvents='none'"></div>

                <iframe class = "embed-responsive-item" src="<?php echo get_theme_mod('ncg_map_embed') ?>" width="600" height="450" frameborder="0" style="border:0"></iframe>
			</div>
		</div>
	</section>
<?php endif; ?>
	<section class="home-widgets container">
		<?php if ( function_exists( 'dynamic_sidebar' ) ): ?>
			<ul>
				<?php dynamic_sidebar( 'home-sidebar' ); ?>
			</ul>
		<?php endif; ?>
	</section>
<?php get_footer(); ?>