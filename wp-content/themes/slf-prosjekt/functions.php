<?php
/**
 * @package SLF Project
 *
 * Add your custom functions here.
 */

function theme_enqueue_styles() {
	wp_enqueue_style(
		'parent-style',
		get_template_directory_uri() . '/style.css'
	);
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_scripts() {
	wp_enqueue_script(
		'angularjs',
		get_stylesheet_directory_uri() . '/js/vendor/angular/angular.min.js'
	);
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );

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
 * Style SiteOrigin rows to match theme
 *
 */

function theme_add_before_row_html() {
	if (is_page_template('rows.php') || is_page_template('one-page.php')) {
		return '<div class="hentry"><div class="entry-content">';
	} else {
		return '';
	}
}
add_action( 'siteorigin_panels_before_row', 'theme_add_before_row_html' );

function theme_add_after_row_html() {
	if (is_page_template('rows.php') || is_page_template('one-page.php')) {
		return '</div></div>';
	} else {
		return '';
	}
}
add_action( 'siteorigin_panels_after_row', 'theme_add_after_row_html' );

/**
 * Style SiteOrigin buttons to match SLF
 *
 */
 
function slf_modify_button_form( $form_options, $widget ){
	// Lets add a new theme option
	if( !empty($form_options['design']['fields']['theme']['options']) ) {
		$form_options['design']['fields']['theme']['options'] = array(
			'flat' => __('Flat', 'siteorigin-widgets'),
			'wire' => __('Wire', 'siteorigin-widgets')
		);
	}

	return $form_options;
}
add_filter('siteorigin_widgets_form_options_sow-button', 'slf_modify_button_form', 10, 2);

function slf_button_less_file( $filename, $instance, $widget ){
	if( !empty($instance['design']['theme']) && $instance['design']['theme'] == 'flat' ) {
		$filename = get_stylesheet_directory() . '/less/slf-button-flat.less';
	} else if ( !empty($instance['design']['theme']) && $instance['design']['theme'] == 'wire' ) {
		$filename = get_stylesheet_directory() . '/less/slf-button-wire.less';
	}
	return $filename;
}
add_filter( 'siteorigin_widgets_less_file_sow-button', 'slf_button_less_file', 10, 3 );

/**
 * Style SiteOrigin features to match SLF
 *
 */
 
function slf_features_template_file( $filename, $instance, $widget ){
	return $filename = get_stylesheet_directory() . '/tpl/slf-features-base.php';
}
add_filter( 'siteorigin_widgets_template_file_sow-features', 'slf_features_template_file', 10, 3 );

/**
 * Style SiteOrigin features to match SLF
 *
 */
function slf_widgets_collection($folders){
 	$folders[] = get_stylesheet_directory() . '/widgets/';
	return $folders;
}
add_filter('siteorigin_widgets_widget_folders', 'slf_widgets_collection');
