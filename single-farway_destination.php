<?php
/**
 * Single destination template.
 *
 * @package Farway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="farway-content" id="primary">
		<div class="content-inner content-inner--960">

			<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'farway' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'farway' ); ?></a>
				<span>/</span>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'farway_destination' ) ); ?>"><?php esc_html_e( 'Destinations', 'farway' ); ?></a>
				<span>/</span>
				<span><?php the_title(); ?></span>
			</nav>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="trip-hero-media"><?php the_post_thumbnail( 'large' ); ?></div>
			<?php endif; ?>

			<h1 class="trip-detail-title"><?php the_title(); ?></h1>

			<?php
			$destination_meta = farway_destination_meta( get_the_ID() );
			$destination_facts = array_filter( array(
				__( 'Country', 'farway' )         => $destination_meta['country'],
				__( 'Region', 'farway' )          => $destination_meta['region'],
				__( 'Best time', 'farway' )       => $destination_meta['best_season'],
				__( 'Currency', 'farway' )        => $destination_meta['currency'],
				__( 'Language', 'farway' )        => $destination_meta['language'],
			) );
			if ( ! empty( $destination_facts ) ) :
				?>
				<div class="fact-grid">
					<?php foreach ( $destination_facts as $label => $value ) : ?>
						<div class="fact-item">
							<span class="fact-label"><?php echo esc_html( $label ); ?></span>
							<span class="fact-value"><?php echo esc_html( $value ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<?php
			$trips = new WP_Query( array(
				'post_type'      => 'farway_trip',
				'posts_per_page' => 6,
				'meta_query'     => array(
					array(
						'key'   => '_farway_destination_id',
						'value' => get_the_ID(),
					),
				),
			) );
			if ( $trips->have_posts() ) :
				?>
				<h2 class="trips-here-title"><?php esc_html_e( 'Trips here', 'farway' ); ?></h2>
				<div class="card-grid">
					<?php while ( $trips->have_posts() ) : $trips->the_post(); ?>
						<?php farway_trip_card( $GLOBALS['post'] ); ?>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>

		</div>
	</div>
	<?php
endwhile;

get_footer();
