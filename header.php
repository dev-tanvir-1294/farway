<?php
/**
 * The header for the Farway theme.
 *
 * @package Farway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( get_header_image() ) : ?>
	<div class="custom-header-image"><?php the_header_image_tag(); ?></div>
<?php endif; ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'farway' ); ?></a>

<?php if ( is_front_page() ) : ?>

	<div class="stage">

		<svg class="route-path" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
			<path class="route-line" d="M -40 620 Q 380 380 760 480 T 1500 260"></path>
			<path class="route-line" d="M 120 850 Q 500 700 900 760 T 1480 620" opacity="0.5"></path>
			<circle class="route-dot" cx="-40" cy="620" r="3.5"></circle>
			<circle class="route-dot dim" cx="760" cy="480" r="3"></circle>
			<circle class="route-dot" cx="1360" cy="285" r="3.5"></circle>
		</svg>

		<div class="coords">
			<span>23.8103&deg; N</span>
			<span>90.4125&deg; E</span>
			<span><?php esc_html_e( 'LIVE FARE GRID', 'farway' ); ?></span>
		</div>

		<nav class="farway-nav" aria-label="<?php esc_attr_e( 'Primary', 'farway' ); ?>">
			<div class="brand">
				<?php
				if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
					the_custom_logo();
				} else {
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand-link">
						<span class="mark"></span><?php echo esc_html( get_bloginfo( 'name' ) ); ?>
					</a>
					<?php
				}
				?>
			</div>

			<div class="nav-menu-wrap">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav-links',
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s<li class="signin"><a href="' . esc_url( farway_account_url() ) . '">' . esc_html__( 'Sign in', 'farway' ) . '</a></li></ul>',
					'fallback_cb'    => 'farway_default_menu',
				) );
				?>
			</div>

			<button type="button" class="nav-toggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'farway' ); ?>" aria-expanded="false">
				<span></span><span></span><span></span>
			</button>
		</nav>

<?php else : ?>

	<header class="farway-page-header">
		<nav class="farway-nav" aria-label="<?php esc_attr_e( 'Primary', 'farway' ); ?>">
			<div class="brand">
				<?php
				if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
					the_custom_logo();
				} else {
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand-link">
						<span class="mark"></span><?php echo esc_html( get_bloginfo( 'name' ) ); ?>
					</a>
					<?php
				}
				?>
			</div>
			<div class="nav-menu-wrap">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav-links',
					'fallback_cb'    => 'farway_default_menu',
				) );
				?>
			</div>
			<button type="button" class="nav-toggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'farway' ); ?>" aria-expanded="false">
				<span></span><span></span><span></span>
			</button>
		</nav>
	</header>

<?php endif; ?>
