<?php

/*
 * Overrides the twentyfifteen_entry_meta function in twentyfifteen.
 * Adds data from advanced custom fields and simple taxonomies.
 *
 */

include_once('acf-helper.php');

if ( ! function_exists( 'twentyfifteen_entry_meta' ) ) :

function twentyfifteen_entry_meta() {

	if ( is_sticky() && is_home() && ! is_paged() ) {
		printf( '<span class="sticky-post">%s</span>', __( 'Featured', 'twentyfifteen' ) );
	}

	if ( 'attachment' == get_post_type() ) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			get_the_date(),
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date()
		);

		printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
			_x( 'Posted on', 'Used before publish date.', 'twentyfifteen' ),
			esc_url( get_permalink() ),
			$time_string
		);
	}

	$type = is_singular() ? "content" : "excerpt";

	if ( 'post' == get_post_type() ) {

		$acf_helper = new SLF_Bike_Rides_ACF_Helper();

		print('<div class="acf-fields">');
			$acf_helper->the_acf_bike_ride_meta("start_location");
			$acf_helper->the_acf_bike_ride_distance_meta();
		print('</div>');

		if(function_exists('yoast_simple_taxonomies_filter'))
			print(yoast_simple_taxonomies_filter("", $type));

		print('<div class="acf-fields">');
			if($type == 'content') {
				$acf_helper->the_acf_bike_ride_meta("sights");
				$acf_helper->the_acf_bike_ride_meta("surroundings");
				$acf_helper->the_acf_bike_ride_meta("traffic");
				$acf_helper->the_acf_bike_ride_meta("plus");
				$acf_helper->the_acf_bike_ride_meta("extra_info");
			}
			$acf_helper->the_acf_bike_ride_pdf_meta();
		print('</div>');
	}

	if ( is_attachment() && wp_attachment_is_image() ) {
		// Retrieve attachment metadata.
		$metadata = wp_get_attachment_metadata();

		printf( '<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
			_x( 'Full size', 'Used before full size attachment link.', 'twentyfifteen' ),
			esc_url( wp_get_attachment_url() ),
			$metadata['width'],
			$metadata['height']
		);
	}
}
endif;
