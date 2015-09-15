<?php
/*
Plugin Name: SLF Calculator
Plugin URI: https://wordpress.org/plugins/hello-dolly/
Description: The SLF Calculator lets you calculate the benefits of cycling to work instead of driving a car. It can be inluded on any page or post with the shortcode [slf-calculator].
Author: Benedicte Raae
Version: 1.0
*/

class SLF_Calculator {

	protected $data_as_json;
	protected $data;

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array($this, 'enque_styles') );
		add_action( 'wp_enqueue_scripts', array($this, 'enque_scripts') );
		add_shortcode('slf-calculator', array($this, 'shortcode') );

		$this->data_as_json = file_get_contents( plugin_dir_url( __FILE__ ) . 'slf-calculator-data.json');
		$this->data = json_decode($this->data_as_json, true);
	}

	public function enque_scripts() {

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

	public function enque_styles() {

		wp_enqueue_style(
			'slf-calculator-style',
			plugin_dir_url( __FILE__ ) . 'slf-calculator.css'
		);
	}

	public function shortcode() {
		ob_start();
		include 'slf-calculator-template.php';
		$template = ob_get_clean();

    	return $template;
	}

	public function the_data_as_JSON() {
		echo $this->data_as_json;
	}

	public function is_default_display($display) {
		return $display == $this->get_default_input('display');
	}

	public function is_default_car_type($car_type) {
		return $car_type == $this->get_default_input('carType');
	}

	public function get_constant($constant, $car_type = null) {
		if($car_type) {
			return $this->data["constants"][$constant][$car_type];
		} else {
			return $this->data["constants"][$constant];
		}
	}

	public function get_default_input($input) {
		return $this->data["input"][$input];
	}

	public function the_default_input($input) {
		echo $this->get_default_input($input);
	}

	public function get_default_km_per_year() {
		return 2 * $this->get_default_input("distanceToWork")
					* $this->get_default_input("daysPerWeek")
					* $this->get_default_input("weeksPerYear");
	}

	public function get_default_calculation($constant) {

		if( "reducedCO2Kg" == $constant || "reducedNOXGram" == $constant || "reducedDustGram" == $constant ) {
			return $this->get_default_km_per_year() * $this->get_constant($constant."PerKm", $this->get_default_input("carType"));
		} else {
			return $this->get_default_km_per_year() * $this->get_constant($constant."PerKm");
		}
	}
}

$slf_calculator = new SLF_Calculator();
