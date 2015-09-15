<?php
/*
Plugin Name: SLF Sykkelturer
Description: Gjør poster om til sykkelturer med advanced custom fields funksjonalitet og kategorier om til byer.
Author: Benedicte Raae
Version: 1.0
*/

class SLF_Bike_Rides {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array($this, 'enque_styles') );
		add_action( 'admin_menu', array( $this, 'change_post_label' ) );
		add_action( 'init', array( $this, 'change_post_object' ) );
		add_filter( 'get_the_archive_title', array( $this, 'add_logo_to_archive_title') );
		add_filter( 'the_content', array( $this, 'add_map_after_content' ) );

		// Remove simple taxonomies filters
		remove_filter(	'the_excerpt', 'yoast_simple_taxonomies_excerpt_filter', 10);
		remove_filter(	'the_content', 'yoast_simple_taxonomies_content_filter', 10);
	}

	public function enque_styles() {

		wp_enqueue_style(
			'slf-calculator-style',
			plugin_dir_url( __FILE__ ) . 'slf-bike-rides.css'
		);
	}

	function change_post_label() {
		global $menu;
		global $submenu;
		$menu[5][0] = __( 'Sykkelturer', 'slf-bike-rides' );
		$submenu['edit.php'][5][0] = __( 'Sykkelturer', 'slf-bike-rides' );
		$submenu['edit.php'][10][0] = __( 'Legg til ny', 'slf-bike-rides' );
		echo '';
	}

	function change_post_object() {
		global $wp_post_types;
		$labels = &$wp_post_types['post']->labels;
		$labels->name = __('Sykkeltur', 'slf-bike-rides');
		$labels->singular_name = __('Sykkeltur', 'slf-bike-rides');
		$labels->add_new = __('Legg til ny', 'slf-bike-rides');
		$labels->add_new_item = __('Legg til ny sykkeltur', 'slf-bike-rides');
		$labels->edit_item = __('Rediger sykkeltur', 'slf-bike-rides');
		$labels->new_item = __('Sykkeltur', 'slf-bike-rides');
		$labels->view_item = __('Vis sykkeltur', 'slf-bike-rides');
		$labels->search_items = __('Søk i sykkelturer', 'slf-bike-rides');
		$labels->not_found = __('Ingen sykkelturer funnet', 'slf-bike-rides');
		$labels->not_found_in_trash = __('Ingen sykkelturer funnet i papirkurven', 'slf-bike-rides');
		$labels->all_items = __('Alle sykkelturer', 'slf-bike-rides');
		$labels->menu_name = __('Sykkelturer', 'slf-bike-rides');
		$labels->name_admin_bar = __('Sykkeltur', 'slf-bike-rides');
	}

	function add_logo_to_archive_title( $title ) {

		if( is_category() ) {
			$acf_helper = new SLF_Bike_Rides_ACF_Helper();
			$cat_ID = get_query_var('cat');
			$category_logo_tag = $acf_helper->get_acf_category_logo_tag($cat_ID, "medium", false);

			if($category_logo_tag)
				$title = $category_logo_tag;
			else
				$title = get_cat_name($cat_ID);
		}
		return $title;
	}

	function add_map_after_content($content) {

		$map_image_field = get_field_object("map");
		$map_comment = get_field_object("map_comment");

		if(is_single() && $map_image_field['value']) {
			$content = $content . '<figure class="wp-caption alignnone">';
			$content = $content . sprintf('<a href="%1$s">', $map_image_field['value']['sizes']['large']);
			$content = $content . sprintf('<img src="%1$s" class="size-full" alt="%2$s" />', $map_image_field['value']['sizes']['large'], $map_comment['value']);
			$content = $content . '</a>';
			$content = $content . sprintf('<figcaption class="wp-caption-text">%1$s</figcaption>', $map_comment['value']);
			$content = $content . '</figure>';
		}

		return $content;
	}
}

// Initialize plugin
$slf_bike_rides = new SLF_Bike_Rides();

include_once('acf-helper.php');
include_once('twentyfifteen-meta-override.php');
include_once('twentyfifteen-thumbnail-override.php');
