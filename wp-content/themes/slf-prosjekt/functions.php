<?php
/**
 *
 * @package WordPress
 * @subpackage SLF_Project
 *
 */

function theme_enqueue_styles() {
	wp_enqueue_style(
		'parent-style',
		get_template_directory_uri() . '/style.css'
	);
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

/**
 * SLF network band with menu
 *
 */

function slf_get_network_logo() {
	return get_bloginfo('stylesheet_directory')."/gfx/chain.png";
}

function register_slf_menus() {
	register_nav_menu( 'network-menu', __( 'Network Menu' ) );
}
add_action( 'init', 'register_slf_menus' );

function slf_network_wp_nav_menu($args = '') {

	if(has_nav_menu( $args['theme_location'] )) {
		wp_nav_menu( $args );
	} elseif ( is_multisite() ) {
		switch_to_blog( SITE_ID_CURRENT_SITE );
		wp_nav_menu( $args );
		restore_current_blog();
	} else {
		// To trigger fallback_cb
		wp_nav_menu( $args );
	}
}

function slf_has_network_wp_nav_menu($location) {
	if(has_nav_menu($location)) {
		return true;
	} elseif ( is_multisite() ) {
		switch_to_blog( SITE_ID_CURRENT_SITE );
		return has_nav_menu( $location);
		restore_current_blog();
	}
}

/**
 * Override Twenty Fifteen custom header
 *
 */

function slf_custom_header_args($args) {
	$args['width'] = 530;
	$args['flex-width'] = true;
	$args['height'] = 200;
	$args['flex-height'] = true;

	return $args;
}
add_filter('twentyfifteen_custom_header_args', 'slf_custom_header_args', 10, 3);

function twentyfifteen_header_style() {
	$header_image = get_header_image();

	// If no custom options for text are set, let's bail.
	if ( empty( $header_image ) && display_header_text() ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css" id="twentyfifteen-header-css">
	<?php
		// Short header for when there is no Custom Header and Header Text is hidden.
		if ( empty( $header_image ) && ! display_header_text() ) :
	?>
		.site-header {
			padding-top: 14px;
			padding-bottom: 14px;
		}

		.site-branding {
			min-height: 42px;
		}

		@media screen and (min-width: 46.25em) {
			.site-header {
				padding-top: 21px;
				padding-bottom: 21px;
			}
			.site-branding {
				min-height: 56px;
			}
		}
		@media screen and (min-width: 55em) {
			.site-header {
				padding-top: 25px;
				padding-bottom: 25px;
			}
			.site-branding {
				min-height: 62px;
			}
		}
		@media screen and (min-width: 59.6875em) {
			.site-header {
				padding-top: 0;
				padding-bottom: 0;
			}
			.site-branding {
				min-height: 0;
			}
		}
	<?php
		endif;

		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
	<?php endif; ?>
	</style>
	<?php
}

/**
 * SLF Calculator
 *
 */

function slf_calculator_enqueue_scripts() {
	wp_enqueue_script(
		'angularjs',
		get_stylesheet_directory_uri() . '/js/vendor/angular/angular.min.js'
	);

	wp_enqueue_script(
		'angularjs-locale-nb',
		get_stylesheet_directory_uri() . '/js/vendor/angular/angular-locale_nb.js',
		array( 'angularjs' )
	);

	wp_enqueue_script(
		'slf-calculator-js',
		get_stylesheet_directory_uri() . '/js/slf-calculator.js',
		array( 'angularjs', 'angularjs-locale-nb' )
	);
}
add_action( 'wp_enqueue_scripts', 'slf_calculator_enqueue_scripts' );


function slf_calculator_shortcode() {
    ob_start();
    get_template_part('slf-calculator');
    return ob_get_clean();
}
add_shortcode('slf-calculator', 'slf_calculator_shortcode');

