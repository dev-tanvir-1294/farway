<?php
/**
 * The footer for the Farway theme.
 *
 * @package Farway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
	<footer class="site-footer">
		<div class="footer-inner">
			<div class="footer-brand">
				<div class="brand">
					<span class="mark"></span><?php echo esc_html( get_bloginfo( 'name' ) ); ?>
				</div>
				<p><?php echo esc_html( farway_theme_mod( 'farway_subcopy', __( 'One search across 4,200 verified trip operators worldwide — real availability, transparent pricing, no surprise fees at checkout.', 'farway' ) ) ); ?></p>
			</div>

			<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
				<div class="footer-widgets">
					<?php dynamic_sidebar( 'footer-1' ); ?>
				</div>
			<?php endif; ?>

			<div class="footer-column">
				<h3 class="footer-title"><?php esc_html_e( 'Explore', 'farway' ); ?></h3>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/#destinations' ) ); ?>"><?php esc_html_e( 'Destinations', 'farway' ); ?></a></li>
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'farway_trip' ) ); ?>"><?php esc_html_e( 'Trips', 'farway' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#stories' ) ); ?>"><?php esc_html_e( 'Stories', 'farway' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>"><?php esc_html_e( 'FAQ', 'farway' ); ?></a></li>
				</ul>
			</div>

			<div class="footer-column">
				<h3 class="footer-title"><?php esc_html_e( 'Contact', 'farway' ); ?></h3>
				<ul>
					<li><?php echo esc_html( farway_theme_mod( 'farway_contact_phone', '+1 (555) 010-2030' ) ); ?></li>
					<li><?php echo esc_html( farway_theme_mod( 'farway_contact_email', 'hello@example.com' ) ); ?></li>
					<li><?php echo esc_html( farway_theme_mod( 'farway_contact_address', '12 Harbor Street, Suite 40' ) ); ?></li>
					<li><?php echo esc_html( farway_theme_mod( 'farway_contact_hours', 'Mon–Sat, 9:00–18:00' ) ); ?></li>
				</ul>
			</div>
		</div>

		<div class="footer-bottom">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'farway' ); ?></p>
		</div>
	</footer>

<?php wp_footer(); ?>
</body>
</html>
