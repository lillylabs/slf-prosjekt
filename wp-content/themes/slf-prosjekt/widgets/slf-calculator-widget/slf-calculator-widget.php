<?php

/*
Widget Name: SLF Calculator widget
Description: Lets visitors calculate savings by choosing to bike to work.
Author: Benedicte Raae, Lilly Labs
Author URI: http://lillylabs.no
*/

class SLF_Calculator_Widget extends SiteOrigin_Widget {

  function __construct() {
    //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

    //Call the parent constructor with the required arguments.
    parent::__construct(
      // The unique id for your widget.
      'slf-calculator-widget',

      // The name of the widget for display purposes.
      __('SLF Calculator', 'slf-calculator-widget-text-domain'),

      // The $widget_options array, which is passed through to WP_Widget.
      // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
      array(
        'description' => __('A hello world widget.', 'slf-calculator-widget-text-domain'),
         // 'help'        => 'http://example.com/hello-world-widget-docs',
      ),

      //The $control_options array, which is passed through to WP_Widget
      array(
      ),

      //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
      array(
        'text' => array(
          'type' => 'text',
          'label' => __('Hello world! goes here.', 'siteorigin-widgets'),
          'default' => 'Hello world!'
        ),
      ),

      //The $base_folder path string.
      plugin_dir_path(__FILE__)
    );
  }

  function get_template_name($instance) {
      return 'slf-calculator-template';
  }

  function get_style_name($instance) {
      return '';
  }
}

siteorigin_widget_register('slf-calculator-widget', __FILE__, 'SLF_Calculator_Widget');