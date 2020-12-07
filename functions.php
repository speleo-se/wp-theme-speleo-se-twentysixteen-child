<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Bootstrap för child-tema för ssf:
// Källa: https://developer.wordpress.org/themes/advanced-topics/child-themes/
add_action( 'wp_enqueue_scripts', function() {

    $parent_style = 'parent-style'; // This is 'twentysixteen-style' for the Twenty Sixteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
} );



# https://www.wpwhitesecurity.com/hide-wordpress-version-number/
# REmove meta-generator-tag:
remove_action('wp_head', 'wp_generator');
# Remove version from rss-feed:
add_filter('the_generator', function() {
	return '';
} );




// Google Analytics for Speleo.se 
/*
add_action( 'wp_head', function() {
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
} );
*/




/**
 * Ny avatar för användare på Speleo.se (Måste ha en grottare)
 *
 * Inspired by: https://www.wpbeginner.com/wp-tutorials/how-to-change-the-default-gravatar-on-wordpress/
 *
 * Bild från: https://www.needpix.com/photo/469435/elen-feuerriegel-underground-astronaut-caver-expedition-sitting-homo-naledi-rising-star-exploration-paleoanthropology
 * Föreställande Elen Feuerriegel
 * https://en.wikipedia.org/wiki/Elen_Feuerriegel
 * Konstnör okänd, men ska vara CC0.
 *
 * Ändra till denna på wp-admin -> Inställningar -> Diskussion
 */
add_filter( 'avatar_defaults', function($avatar_defaults) {
  $myavatar = (($_SERVER[HTTPS] ?? 'off') == 'on' ? 'https' : 'http' ).'://'.$_SERVER['HTTP_HOST'].'/wp-content/themes/'.basename(__DIR__).'/assets/images/avatar-250x250.png';
  $avatar_defaults[$myavatar] = "Speleo avatar";
  return $avatar_defaults;
} );



/**
 * Ta bort möjlighet för användare att välja färg på admin.
 * Ger renare gränssnitt.
 */
#https://shellcreeper.com/how-to-remove-wp-admin-color-scheme-option/
/* Admin hook */
add_action( 'admin_init', function() {
    global $_wp_admin_css_colors;

    /* Remove everything else */
    $_wp_admin_css_colors = array( 'fresh' => $_wp_admin_css_colors['fresh'] );
}, 1 );


/* Filter user color option */
add_filter( 'get_user_option_admin_color', function( $color ){
    return 'fresh';
}, 1, 1 );

/**
 * Inloggningsutan på /wp-login.php
 */

// Logga över inloggningen
add_action( 'login_enqueue_scripts', function () { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ssf_logo_color_print.svg);
        height:100px;
        width:300px;
        background-size: 300px 100px;
        background-repeat: no-repeat;
        padding-bottom: 10px;
        }
        
    </style>
<?php });
// Istället för länk till WordPress när man trycker på loggan
add_filter( 'login_headerurl', function ( $login_header_url ) {	return '/'; });
// Istället för "Drivs av Wordpress" (Texten syns inte då den ersätts med loggan.)
add_filter( 'login_headertext', function( $login_header_text ){	return 'Sveriges Speleologförbund'; });
// Text som visas över inloggningsformuläret.
add_filter( 'login_message', function ( $message ) { return 'Som medlem i Sveriges Speleologförbund är du välkommen att logga in. Som användnamn används ditt medlemsnummer. Du kan även logga in med din e-postadress.'; });
// TODO!
// Orginal: <a href="https://dev.speleo.se/wp-login.php?action=register">Registrera</a>
add_filter( 'register', function ( $registration_url ) { return ''/*'<a href="/bli-melemsformulär...">TODO: Bli medlem</a>'*/; });




// Möjliggör kategorier på sidor. (Behövs för olika sidfötter)
include('functions-category-tag-pages.php');


// Inkludera mailinställningar för speleo.se
include('mailsettings.php');

