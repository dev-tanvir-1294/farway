<?php
/**
 * Single FAQ template.
 *
 * @package Farway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$faq_topic = get_post_meta( get_the_ID(), '_farway_topic', true );
	?>
	<div class="farway-content" id="primary">
		<div class="content-inner content-inner--narrow">

			<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'farway' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'farway' ); ?></a>
				<span>/</span>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'farway_faq' ) ); ?>"><?php esc_html_e( 'FAQs', 'farway' ); ?></a>
				<span>/</span>
				<span><?php the_title(); ?></span>
			</nav>

			<h1 class="trip-detail-title"><?php the_title(); ?></h1>

			<?php if ( $faq_topic ) : ?>
				<p class="faq-single-topic"><?php echo esc_html( $faq_topic ); ?></p>
			<?php endif; ?>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>

		</div>
	</div>
	<?php
endwhile;

get_footer();
