<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package FlatNatura
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php do_action( 'before' ); ?>
	<div class="site-top">
		<div class="clearfix container">	
			<nav class="site-menu" role="navigation">
				<div class="menu-toggle"><i class="fa fa-bars"></i></div>
				<div class="menu-text"></div>
				<?php wp_nav_menu( array( 'container_class' => 'clearfix menu-bar', 'theme_location' => 'primary' ) ); ?>
			</nav>
			<div class="site-search">
				<div class="search-toggle"><i class="fa fa-search"></i></div>
					<div class="search-expand">
					<div class="search-expand-inner">
						<?php get_search_form(); ?>
					</div>
				</div>
			</div>		
		</div>
	</div>	

	<header class="site-header" role="banner">
		<div class="clearfix container">
			<div class="site-branding">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div>	
		</div><!-- .site-branding -->
	</header><!-- #masthead -->

	<div class="site-main">
		<div class="clearfix container">
