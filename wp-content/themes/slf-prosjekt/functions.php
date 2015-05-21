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
 