<?php
/**
 * Template Name: Rows
 * @package SLF Project
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
	?>
	
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
				<?php the_content(); ?>

				<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<footer class="entry-footer hentry"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>
	
			</article><!-- #post-## -->
		
		<?php

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>