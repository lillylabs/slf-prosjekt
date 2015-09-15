<?

/*
 * Overrides the twentyfifteen_post_thumbnail function in twentyfifteen.
 * Adds data from advanced custom fields.
 *
 */

include_once('acf-helper.php');

if ( ! function_exists( 'twentyfifteen_entry_meta' ) ) :

function twentyfifteen_post_thumbnail() {
	if ( post_password_required() || is_attachment() ) {
		return;
	}

	$categories = get_the_category();
	$cat_ID = $categories[0]->term_id;

	$acf_helper = new SLF_Bike_Rides_ACF_Helper();

	if( has_post_thumbnail() ) {

		printf('<div class="post-thumbnail">');

		if ( is_singular() ) {
			the_post_thumbnail();
			$acf_helper->the_acf_category_logo_tag($cat_ID, "medium", true);
		} else {
			printf('<a class="post-thumbnail" href=%s aria-hidden="true">', get_the_permalink());
				the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
			printf('</a>');
			if(!is_category()) {
				$acf_helper->the_acf_category_logo_tag($cat_ID, "medium", true);
			}
		}

		printf('</div><!-- .post-thumbnail -->');

	} else if ( !is_category() ) {

		printf('<div class="entry-title entry-header">');
		$acf_helper->the_acf_category_logo_tag($cat_ID, "medium", true);
		printf('</div>');

	}

}

endif;
