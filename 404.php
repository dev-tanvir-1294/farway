<?php
/**
 * 404 template.
 *
 * @package Farway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="farway-content" id="primary">
	<div class="content-inner content-inner--narrow content-inner--center">
		<p class="post-date"><?php esc_html_e( '404 — off route', 'farway' ); ?></p>
		<h1 class="post-title post-title--large"><?php esc_html_e( 'This page has flown away.', 'farway' ); ?></h1>
		<p class="archive-description archive-description--spaced"><?php esc_html_e( 'The page you are looking for does not exist or has moved.', 'farway' ); ?></p>
		<?php get_search_form(); ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="cta read-more"><?php esc_html_e( 'Back home', 'farway' ); ?> <span class="arrow">&rarr;</span></a>
	</div>
</div>

<?php get_footer(); ?>
