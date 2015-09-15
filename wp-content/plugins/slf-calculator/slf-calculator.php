<?php
/*
Plugin Name: SLF Calculator
Plugin URI: https://wordpress.org/plugins/hello-dolly/
Description: The SLF Calculator lets you calculate the benefits of cycling to work instead of driving a car. It can be inluded on any page or post with the shortcode [slf-calculator].
Author: Benedicte Raae
Version: 1.0
*/

function slf_calculator_enqueue_scripts() {

	wp_enqueue_style(
		'slf-calculator-style',
		plugin_dir_url( __FILE__ ) . 'slf-calculator.css'
	);

	wp_enqueue_script(
		'angularjs',
		plugin_dir_url( __FILE__ ) . 'vendor/angular/angular.min.js'
	);

	wp_enqueue_script(
		'angularjs-locale-nb',
		plugin_dir_url( __FILE__ ) . 'vendor/angular/angular-locale_nb.js',
		array( 'angularjs' )
	);

	wp_enqueue_script(
		'slf-calculator-js',
		plugin_dir_url( __FILE__ ) . 'slf-calculator.js',
		array( 'angularjs', 'angularjs-locale-nb' )
	);

}
add_action( 'wp_enqueue_scripts', 'slf_calculator_enqueue_scripts' );

function slf_calculator_shortcode() {

	$template_file_path = plugin_dir_url( __FILE__ ) . '/slf-calculator-template.php';
    return file_get_contents( $template_file_path );

}
add_shortcode('slf-calculator', 'slf_calculator_shortcode');
