<?php
/**
 *
 * @package WordPress
 * @subpackage slf_project
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- Added support for network header -->
<div class="network-header">
	<div class="network-header-container">
		<div class="network-branding">
			<a class="network-title" href="<?php echo esc_url('http://syklistene.no'); ?>" rel="home">
				<img class="network-logo" src="<?php echo slf_get_network_logo() ?>"></img>
				<span>syklistene.no</span>
			</a>
		</div>

		<div class="network-navigation">
			<?php $args = array('theme_location' => 'network-menu', 'container' => '', 'menu_class' => 'network-menu'); ?>
			<?php slf_network_wp_nav_menu( array('theme_location' => 'network-menu', 'container' => '', 'menu_class' => 'network-menu', 'fallback_cb' => '') ); ?>
		</div>
	</div>
</div>
<!-- End customization -->


<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyfifteen' ); ?></a>

	<div id="sidebar" class="sidebar">

		<header id="masthead" class="site-header" role="banner">
			<div class="site-branding">

				<!-- Added support for logo -->
				<?php if( has_header_image() ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img class="site-logo" src="<?php header_image(); ?>"></img>
					</a>
				<?php endif; ?>
				<!-- End customization -->

				<?php
					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif;

					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; ?></p>
					<?php endif;
				?>
				<button class="secondary-toggle"><?php _e( 'Menu and widgets', 'twentyfifteen' ); ?></button>
			</div><!-- .site-branding -->
		</header><!-- .site-header -->

		<?php get_sidebar(); ?>
	</div><!-- .sidebar -->

	<div id="content" class="site-content">
