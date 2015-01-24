<?php
/**
 * ncgbase template for displaying the header
 *
 * @package WordPress
 * @subpackage ncgbase
 * @since ncgbase 1.0
 */
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="ie ie-no-support" <?php language_attributes();?>> <![endif]-->
<!--[if IE 7]>         <html class="ie ie7" <?php language_attributes();?>> <![endif]-->
<!--[if IE 8]>         <html class="ie ie8" <?php language_attributes();?>> <![endif]-->
<!--[if IE 9]>         <html class="ie ie9" <?php language_attributes();?>> <![endif]-->
<!--[if gt IE 9]><!--> <html <?php language_attributes();?>> <!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo('charset');?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php wp_title();?></title>
		<meta name="viewport" content="width=device-width" />
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.png" />
		<!--[if lt IE 9]>
			<script src="<?php echo get_template_directory_uri();?>/js/html5shiv.js"></script>
		<![endif]-->	
		<style type="text/css">
			@font-face {
			  font-family: 'Glyphicons Halflings';
			  src: url('fonts/glyphicons-halflings-regular.eot');
			  src: url('fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'), url('fonts/glyphicons-halflings-regular.woff') format('woff'), url('fonts/glyphicons-halflings-regular.ttf') format('truetype'), url('fonts/glyphicons-halflings-regular.svg#glyphicons-halflingsregular') format('svg');
			}
		</style>
<?php wp_head();?>

	</head>
	<body <?php body_class();?>>
		<div class="site">
			<header class="site-header">
			<?php get_template_part('templates/menu');?>
			<?php if (get_header_image()) : ?>
				<div class = "container">
					<div class = "row">
						<div class = "col-xs-12">
							<img id = "header-image" class = "img-responsive" src="<?php echo( get_header_image() ); ?>" alt="<?php echo( get_bloginfo( 'title' ) ); ?>" />		
						</div>
					</div>
					
				</div>
				
			<?php endif; ?>
			</header>