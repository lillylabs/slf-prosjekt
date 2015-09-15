<?php

class SLF_Bike_Rides_ACF_Helper {

	function get_acf_category_logo_tag($cat_ID, $size, $link) {
		if(!$cat_ID)
			return "";

		$logo = get_field( "logo", "category_".$cat_ID );
		$logo_link = get_category_link($cat_ID);
		$logo_img_tag = "";

		if($logo) {
			$logo_url = $logo["sizes"][$size];
			if($link)
				$logo_img_tag =	'<div class="logo"><a href="'.$logo_link.'"><img src="'.$logo_url.'" /></a></div>';
			else
				$logo_img_tag =	'<div class="logo"><img src="'.$logo_url.'" /></div>';
		}

		return $logo_img_tag;
	}

	function the_acf_category_logo_tag($category, $size, $link) {
		echo $this->get_acf_category_logo_tag($category, $size, $link);
	}

	function the_acf_bike_ride_meta($field_name) {
		if( class_exists('acf')) {
			$field = get_field_object($field_name);
			if($field['value'] != '')
				printf('<div class="acf-field acf-field-%1$s"><span class="label">%2$s:</span> %3$s </div>', $field['name'], $field['label'], $field['value']);
		}
	}

	function the_acf_bike_ride_distance_meta() {
		$distance_field = get_field_object("distance");
		$note_field = get_field_object("distance_note");

		if($distance_field['value'] != '')
			printf('<div class="acf-field acf-field-%1$s"><span class="label">%2$s:</span> %3$s %4$s %5$s </div>', $distance_field['name'], $distance_field['label'], $distance_field['value'], _x('kilometer', 'twentyfifteen'), $note_field['value']);
	}

	function the_acf_bike_ride_pdf_meta() {
		$field = get_field_object("pdf");
		if($field['value'] != '')
			printf('<div class="acf-field acf-field-%1$s"><span class="label"></span><a target="_blank" href="%3$s">%2$s</a>', $field['name'], _x('Last ned som pdf', '', 'twentyfifteen' ), $field['value']);
	}
}
