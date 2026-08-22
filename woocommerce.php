<?php
/**
 * WooCommerce template.
 *
 * Renders the WooCommerce store and account pages inside the Farway layout.
 *
 * @package Farway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="farway-content" id="primary">
	<div class="content-inner">
		<?php woocommerce_content(); ?>
	</div>
</div>

<?php
get_footer();
