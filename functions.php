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


// Inaktivera application-passwords (Används ej) Kom med WP 5.6
add_filter( 'wp_is_application_passwords_available' , '__return_false' );

// Hindra ändringar av e-post på wordpress-sida:	
// https://wordpress.stackexchange.com/a/238251/183776
// Serversida:
add_action( 'user_profile_update_errors', 
	function ( $errors, $update, $user ) {
		$old = get_user_by('id', $user->ID);
		
		if( $user->user_email != $old->user_email   && (!current_user_can('create_users')) ) {
			$user->user_email = $old->user_email;
		}
	}, 10, 3 );

// Klientsida:
add_action('admin_init', function () {
	global $pagenow;
	
	// apply only to user profile or user edit pages
	if ($pagenow!=='profile.php' && $pagenow!=='user-edit.php') {
		return;
	}
	
	// do not change anything for the administrator
	if (current_user_can('administrator')) {
		return;
	}
	
	add_action( 'admin_footer', function () {
		?>
	    <script>
	        jQuery(document).ready( function($) {
	            var fields_to_disable = ['email', 'first_name', 'last_name'];
	            for(i=0; i<fields_to_disable.length; i++) {
	            	$('#'+ fields_to_disable[i]).each(function( index ) {
		            	var $this = $(this);
	            		$this.prop( "disabled", true );
	            		$this.after(
	            			$('<input type="hidden">').attr('name', $this.attr('name')).val($this.val())
	            			);
	                });
	            }
	            $('#email-description').html('Om du vill ändra din e-post gör du det här: <a href="/civicrm/profile/edit/?gid=15&reset=1">Mina medlemsuppgifter</a>');
	        });
	    </script>
	<?php
	});
});





// Google Analytics for Speleo.se 
add_action( 'wp_head', function() {
	if ( $_SERVER['HTTP_HOST'] == 'speleo.se' ) {
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
} );





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
add_action( 'admin_head-profile.php', function() {
    remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
});


// Old, pre wordpress 6
//add_action( 'admin_init', function() {
//    global $_wp_admin_css_colors;
//
//    /* Remove everything else */
//    $_wp_admin_css_colors = array( 'fresh' => $_wp_admin_css_colors['fresh'] );
//}, 1 );


/* Filter user color option */
add_filter( 'get_user_option_admin_color', function( $color ){
    return 'fresh';
}, 1, 1 );


	
add_filter('user_contactmethods',function ( $contactmethods ) {
	//$contactmethods['facebook'] = 'Facebook';
	//$contactmethods['twitter'] = 'Twitter';
	unset($contactmethods['yim']);
	unset($contactmethods['aim']);
	unset($contactmethods['jabber']);
	return $contactmethods;
},10,1);



/**
 * Inloggningsutan på /wp-login.php
 */

// Logga över inloggningen
add_action( 'login_enqueue_scripts', function () { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ssf_logo_color_print.svg);
        height:200px;
        width:300px;
        background-size: 300px 200px;
        background-repeat: no-repeat;
        padding-bottom: 10px;
        }
        body.login {
			background-color: #2a4090;
			color: #ffec00;
        }
        form#loginform, form#lostpasswordform, form#resetpassform, #login_error, #login .message {
        	color: #2a4090/*#444*/;
        }
        body.login .button-primary {
        	background-color: #2a4090;
        	color: #ffec00;
        }
        body.login .button-primary:hover {
        	background-color: #3f539b;
        	color: #ffec00;
        }
        body.login a{
        	color: #ffec00 !important;
        }
        #login_instructions {
        	margin-bottom: 2em;
        }
    </style>
<?php });
// Istället för länk till WordPress när man trycker på loggan
add_filter( 'login_headerurl', function ( $login_header_url ) {	return '/'; });
// Istället för "Drivs av Wordpress" (Texten syns inte då den ersätts med loggan.)
add_filter( 'login_headertext', function( $login_header_text ){	return 'Sveriges Speleologförbund'; });
// Text som visas över inloggningsformuläret.
add_filter( 'login_message', function ( $message ) { return '<p id="login_instructions">Som medlem i Sveriges Speleologförbund är du välkommen att logga in. Som användnamn används ditt medlemsnummer. Du kan även logga in med din e-postadress.</p><p><a href="/civicrm/contribute/transact/?reset=1&id=1">Klicka här för att bli medlem</a></p><br> '; });
// TODO!
// Orginal: <a href="https://dev.speleo.se/wp-login.php?action=register">Registrera</a>
add_filter( 'register', function ( $registration_url ) { return ''/*'<a href="/bli-melemsformulär...">TODO: Bli medlem</a>'*/; });

// Kan även använda '__return_false'
add_filter( 'xmlrpc_enabled', function () { sleep(5); return false; } );

/**
 * Filters the login redirect URL.
 *
 * @since 3.0.0
 *
 * @param string           $redirect_to           The redirect destination URL.
 * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
 * @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
 */
add_filter( 'login_redirect', function($redirect_to, $requested_redirect_to = null, $user = null) {
	// Denna anropas både vid laddning av login-sidan, misslyckad inloggning och lyckad inloggning.
	// Om ej inloggad används retur värdet till att sätta det dolda fältet `redirect_to` i formuläret
	// redirect_to och requested_redirect_to kan då sättas med GET-parametern ?redirect_to=/grottor-se-demo/
	//
	// https://speleo.se/ssf-login/?redirect_to=/inloggning-till-grottdatabasen/
	// https://speleo.se/ssf-login/?redirect_to=/grottor-se-demo/
	if ( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
		// Kod från: http://docs.itthinx.com/document/groups/api/examples/
		if (Groups_User_Group::read( $user->ID, Groups_Group::read_by_name( 'Medlem' )->group_id)) {
			if ($requested_redirect_to && strpos($requested_redirect_to, 'wp-admin') === false) {
				//if (in_array($requested_redirect_to,  ['/grottor-se-demo/','/inloggning-till-grottdatabasen/'])) {
				return $requested_redirect_to;
			}
			return 	'/medlem/';
		} elseif (Groups_User_Group::read( $user->ID, Groups_Group::read_by_name( 'Varit medlem' )->group_id)) {
			return '/fornya-ditt-medlemskap/';
		}
	}
	// Ej inloggad eller misslyckad, låt vald redirect vara.
	return $redirect_to;
}, 10, 3);

// Möjliggör kategorier på sidor. (Behövs för olika sidfötter)
include('functions-category-tag-pages.php');

// Inkludera mailinställningar för speleo.se
include('mailsettings.php');
