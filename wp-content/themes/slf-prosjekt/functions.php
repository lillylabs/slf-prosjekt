<?php
/**
 * @package SLF Project
 *
 * Add your custom functions here.
 */

function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_add_before_row_html() {
  if (is_page_template('project.php') || is_page_template('one-page.php')) {
    return '<div class="hentry"><div class="entry-content">';
  } else {
    return '';
  }
}
add_action( 'siteorigin_panels_before_row', 'theme_add_before_row_html' );

function theme_add_after_row_html() {
  if (is_page_template('project.php') || is_page_template('one-page.php')) {
    return '</div></div>';
  } else {
    return '';
  }
}
add_action( 'siteorigin_panels_after_row', 'theme_add_after_row_html' );

