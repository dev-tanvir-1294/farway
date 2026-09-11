<?php
/**
 * Single trip template.
 *
 * @package Farway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$meta = farway_trip_meta( get_the_ID() );
	$dest_id   = $meta['destination'];
	$dest_name = $dest_id ? get_the_title( $dest_id ) : '';
	?>
	<div class="farway-content" id="primary">
		<div class="content-inner content-inner--960">

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'farway' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'farway' ); ?></a>
				<span>/</span>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'farway_trip' ) ); ?>"><?php esc_html_e( 'Trips', 'farway' ); ?></a>
				<span>/</span>
				<span><?php the_title(); ?></span>
			</nav>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="trip-hero-media"><?php the_post_thumbnail( 'large' ); ?></div>
			<?php endif; ?>

			<div class="trip-detail-grid">
				<div class="trip-detail-main">
					<div class="trip-meta">
						<?php if ( $dest_name ) : ?>
							<span class="trip-location"><?php echo esc_html( $dest_name ); ?></span>
						<?php endif; ?>
						<?php if ( $meta['duration'] && isset( farway_duration_options()[ $meta['duration'] ] ) ) : ?>
							<span class="trip-duration"><?php echo esc_html( farway_duration_options()[ $meta['duration'] ] ); ?></span>
						<?php endif; ?>
						<?php if ( $meta['trip_type'] ) : ?>
							<span><?php echo esc_html( ucfirst( $meta['trip_type'] ) ); ?></span>
						<?php endif; ?>
						<?php if ( $meta['difficulty'] ) : ?>
							<span><?php echo esc_html( ucfirst( $meta['difficulty'] ) ); ?></span>
						<?php endif; ?>
						<?php if ( $meta['group_size'] ) : ?>
							<span><?php printf( esc_html( _n( 'Up to %d person', 'Up to %d people', (int) $meta['group_size'], 'farway' ) ), (int) $meta['group_size'] ); ?></span>
						<?php endif; ?>
					</div>

					<h1 class="trip-detail-title"><?php the_title(); ?></h1>

					<div class="entry-content">
						<?php the_content(); ?>
					</div>

					<?php $inclusions = farway_inclusions_list( $meta['inclusions'] ); ?>
					<?php if ( $inclusions ) : ?>
						<div class="trip-inclusions">
							<h2><?php esc_html_e( "What's included", 'farway' ); ?></h2>
							<ul>
								<?php foreach ( $inclusions as $item ) : ?>
									<li><?php echo esc_html( $item ); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
				</div>

				<aside class="trip-detail-aside">
					<div class="booking-card">
						<div class="booking-price">
							<?php if ( $meta['sale_price'] !== '' && floatval( $meta['sale_price'] ) > 0 ) : ?>
								<span class="booking-amount"><?php echo esc_html( farway_price( $meta['sale_price'] ) ); ?></span>
								<span class="booking-was"><?php echo esc_html( farway_price( $meta['price'] ) ); ?></span>
								<span class="booking-per"><?php esc_html_e( 'per person', 'farway' ); ?></span>
							<?php elseif ( $meta['price'] !== '' ) : ?>
								<span class="booking-amount"><?php echo esc_html( farway_price( $meta['price'] ) ); ?></span>
								<span class="booking-per"><?php esc_html_e( 'per person', 'farway' ); ?></span>
							<?php endif; ?>
						</div>

						<form class="inquiry-form" id="inquiry-form">
							<input type="hidden" name="trip_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
							<input type="hidden" name="destination" value="<?php echo esc_attr( $dest_name ); ?>">
							<input type="text" name="name" placeholder="<?php esc_attr_e( 'Your name', 'farway' ); ?>" required>
							<input type="email" name="email" placeholder="<?php esc_attr_e( 'Email address', 'farway' ); ?>" required>
							<input type="tel" name="phone" placeholder="<?php esc_attr_e( 'Phone (optional)', 'farway' ); ?>">
							<input type="number" name="travelers" min="1" max="9" value="2" placeholder="<?php esc_attr_e( 'Travelers', 'farway' ); ?>">
							<input type="date" name="depart" placeholder="<?php esc_attr_e( 'Preferred date', 'farway' ); ?>">
							<textarea name="message" rows="3" placeholder="<?php esc_attr_e( 'Anything else we should know?', 'farway' ); ?>"></textarea>
							<button type="submit" class="cta"><?php esc_html_e( 'Book this trip', 'farway' ); ?> <span class="arrow">&rarr;</span></button>
							<div class="form-status" aria-live="polite"></div>
						</form>
					</div>
				</aside>
			</div>

		</div>

		</article>
	</div>
	<?php
endwhile;

get_footer();
