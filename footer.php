<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 */
?>

		</div><!-- .site-content -->

<?php
$pageTagNames = array_column(get_the_tags() ?: [], 'name');
$eventTagNames = array_column(get_the_terms( get_the_ID(), 'event-tag' ) ?: [], 'name');

$subFooter = null;
foreach (['Stockholms Grottklubb', 'Expedition Bjurälven'] as $sub) {
	if (in_array($sub, $pageTagNames) || in_array($sub, $eventTagNames)) {
		$subFooter = $sub;
		break;
	}
}
if ($subFooter == 'Stockholms Grottklubb') {
?>
		<footer class="site-footer lokalklubb sgk">
			<div class="site-info">
				<section class="widget_text widget widget_custom_html">
					<div class="footercolumn">
						<h2 class="widget-title">Info SGK</h2>
						<div class="textwidget custom-html-widget">
							<strong>Adress inomhusmöten:</strong><br>
							<a href="https://goo.gl/maps/su96smhXEpemon7t7">Hartwickska huset</a><br>
							S:t Paulsgatan 39b<br>
							Stockholm<br>
							(T-Bana, Mariatorget)<br>
							<br>
							<strong>Tid:</strong><br>
							kl.18:30 - 21.00<br>
							(om ej annat meddelats)<br>
						</div>
					</div>
					<div class="footercolumn">
						<img class="footer_logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sgk_logo.png">
					</div>
					<div class="footercolumn">
						<h2 class="widget-title">Stockholms Grottklubb</h2>
						<div class="textwidget custom-html-widget">
							<strong>Grundad:</strong> 1983<br>
							<strong>Org.nr:</strong> 802407-0628<br>
						</div>
					</div>
				</section>
			</div>
		</footer>
<?php
} else if ($subFooter == 'Expedition Bjurälven') {
?>
		<footer class="site-footer lokalklubb bjuralven">
			<div class="site-info">
				<section class="widget_text widget widget_custom_html">
					<div class="footercolumn">
						<img class="footer_logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/expedition_bjuralven_logo.png">
					</div>
				</section>
			</div>
		</footer>
<?php
}
/* ********* SSF ********* */
?>
		<footer id="colophon" class="site-footer" role="contentinfo">

			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Primary Menu', 'twentysixteen' ); ?>">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'menu_class'     => 'primary-menu',
							)
						);
					?>
				</nav><!-- .main-navigation -->
			<?php endif; ?>

			<?php if ( has_nav_menu( 'social' ) ) : ?>
				<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentysixteen' ); ?>">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'social',
								'menu_class'     => 'social-links-menu',
								'depth'          => 1,
								'link_before'    => '<span class="screen-reader-text">',
								'link_after'     => '</span>',
							)
						);
					?>
				</nav><!-- .social-navigation -->
			<?php endif; ?>
			<?php if ($subFooter) { ?>
				<span class="site-title"><?php echo $subFooter; ?> är en del av:</span>
			<?php } ?>
			<div class="site-info">
				<?php
					/**
					 * Fires before the twentysixteen footer text for footer customization.
					 *
					 * @since Twenty Sixteen 1.0
					 */
					do_action( 'twentysixteen_credits' );
				?>
	<section class="widget_text widget widget_custom_html">
		<div class="footercolumn">
			<h2 class="widget-title">Sveriges Speleologförbund SSF</h2>
			<div class="textwidget custom-html-widget">
				<strong>Grundat:</strong> 1966<br>
				<strong>Org.nr:</strong> 802010-4892<br>
				<br>
			</div>
			<h2 class="widget-title">Forum</h2>
			<div class="textwidget custom-html-widget">
				<a href="https://www.facebook.com/groups/swedespeleo/" target="_blank">Sveriges Speleologförbund på Facebook</a>
			</div>
		</div>
		<div class="footercolumn">
			<img class="footer_logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ssf_logo_color_print.svg">
		</div>
		<div class="footercolumn">
			<h2 class="widget-title">Betalning till SSF</h2>
			<div class="textwidget custom-html-widget">
				<span class="footer-key">Plusgiro:</span><span class="footer-value">634208-3</span>
				<span class="footer-key">Bankgiro:</span><span class="footer-value">5002-0494</span>

				<span class="footer-key footer-key-space">Swish:</span>
				<span class="footer-value" style="clear: both;">
					Medlemsavgifter: 123-6084065<br>
					Nedåt: 123-5116629<br>
					Årsmöte: 123-5787650
				</span>
				<span class="footer-key footer-key-space">Från utlandet:</span>
				<details style="clear: both;">
  				<summary style="line-height: 1em; padding-top:2px; margin-bottom: 0.5em;">
						<span style="display: inline-block;"><span class="footer-key">IBAN:</span><span class="footer-value"><span class="numbergroup">SE25</span><span class="numbergroup">3000</span><span class="numbergroup">0000</span><span class="numbergroup">0183</span><span class="numbergroup">8170</span>1708</span></span>
					</summary>
					<span class="footer-key">SWIFT/BIC:</span><span class="footer-value">NDEASESS</span>
					<span class="footer-key">Address:</span>
					<span class="footer-value">
						Sveriges Speleologförbund SSF<br>
						BOX 16013<br>
						SE-720 16 Västerås<br>
						Sweden
					</span>
					<span class="footer-key">Address of bank:</span>
					<span class="footer-value">
						Nordea Bank AB<br>
						Smålandsgatan 17<br>
						SE-105 71 Stockholm<br>
						Sweden
					</span>
				</details>
			</div>
		</div>
	</section>
				<span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">&copy <?php bloginfo( 'name' ); ?> <?php echo date('Y'); ?></a></span>
				<?php
				if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
				}
				?>
				<?php /*
				<a href="< ? php echo esc_url( __( 'https://wordpress.org/', 'twentysixteen' ) ); ? >" class="imprint">
					< ? php
					/ * translators: %s: WordPress * /
					printf( __( 'Proudly powered by %s', 'twentysixteen' ), 'WordPress' );
					? >
				</a>
				*/ ?>
			</div><!-- .site-info -->
		</footer><!-- .site-footer -->
	</div><!-- .site-inner -->
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
