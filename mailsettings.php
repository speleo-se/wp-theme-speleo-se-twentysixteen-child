<?php
// https://premium.wpmudev.org/blog/wordpress-email-settings/

/* enter the full email address you want displayed */
add_filter("wp_mail_from", function ( $email ){
	return "mailsender@speleo.se";
});


/* enter the full name you want displayed alongside the email address */
add_filter("wp_mail_from_name", function ( $from_name ){
	return "Sveriges Speleologförbund";
});


add_filter ( 'wp_mail', function ( $args ) {
	$args['headers'] = ['Reply-To: Sveriges Speleologförbund <medlem@speleo.se>'];
	return $args;
});


