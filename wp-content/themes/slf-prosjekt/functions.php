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

function slf_footer_text() {
	echo '<p>© Syklistene 2015 | Østensjøveien 29, 0661 Oslo | 22 47 30 30</p>';
}
add_action('twentyfifteen_credits', 'slf_footer_text');

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
	$has_nav_menu = has_nav_menu($location);

	if ( !$has_nav_menu && is_multisite() ) {
		switch_to_blog( SITE_ID_CURRENT_SITE );
		$has_nav_menu = has_nav_menu( $location);
		restore_current_blog();
	}

	return $has_nav_menu;
}

/**
 * Adding entry-header inside Twenty Fifteen post-thumbnail
 *
 */

if ( ! function_exists( 'twentyfifteen_comment_nav' ) ) :

function twentyfifteen_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
			the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
		?>
		<header class="entry-header">
			<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
		</header>
	</a>

	<?php endif; // End is_singular()
}

endif;

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
