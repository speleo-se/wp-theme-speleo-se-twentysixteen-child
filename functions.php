<?php
// Bootstrap för child-tema för ssf:
// Källa: https://developer.wordpress.org/themes/advanced-topics/child-themes/
add_action( 'wp_enqueue_scripts', 'speleo_se_theme_enqueue_styles' );
function speleo_se_theme_enqueue_styles() {

    $parent_style = 'parent-style'; // This is 'twentysixteen-style' for the Twenty Sixteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}



# https://www.wpwhitesecurity.com/hide-wordpress-version-number/
# REmove meta-generator-tag:
remove_action('wp_head', 'wp_generator');
# Remove from rss-feed:
function remove_wp_version_rss() {
 return'';
 }
 
add_filter('the_generator','remove_wp_version_rss');





// Google Analytics for Speleo.se 
//add_action( 'wp_head', 'my_google_analytics_script' );
function my_google_analytics_script() {
?> 
  <!-- Global site tag (gtag.js) - Google Analytics --> 
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-159069439-1"></script> 
  <script> 
    window.dataLayer = window.dataLayer || []; 
    function gtag(){dataLayer.push(arguments);} 
    gtag('js', new Date()); 
   
    gtag('config', 'UA-159069439-1'); 
  </script> 
  <?php
}




// Möjliggör kategorier på sidor.
include('functions-category-tag-pages.php');
