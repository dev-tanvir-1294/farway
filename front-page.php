<?php
/**
 * Front page template — single-view agency front.
 *
 * @package Farway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$has_search = isset( $_GET['from'] ) || isset( $_GET['trip_length'] ) || isset( $_GET['destination'] ) || isset( $_GET['depart'] ) || isset( $_GET['travelers'] );
?>

		<main class="farway-main" id="primary">
			<div class="copy">
				<div class="eyebrow"><?php echo esc_html( farway_theme_mod( 'farway_eyebrow', __( 'Departures open', 'farway' ) ) ); ?></div>

				<h1 class="headline">
					<span class="tw-line"><?php echo wp_kses_post( farway_typewriter( farway_theme_mod( 'farway_headline', __( 'Wander further,', 'farway' ) ), 'tw-char' ) ); ?></span>
					<span class="tw-line"><?php echo wp_kses_post( farway_typewriter( farway_theme_mod( 'farway_headline_accent', __( 'book with', 'farway' ) ), 'tw-char' ) ); ?> <em><?php echo wp_kses_post( farway_typewriter( farway_theme_mod( 'farway_headline_em', __( 'certainty.', 'farway' ) ), 'tw-char' ) ); ?></em></span>
				</h1>

				<p class="subcopy">
					<?php echo esc_html( farway_theme_mod( 'farway_subcopy', __( 'One search across 4,200 verified trip operators worldwide — real availability, transparent pricing, no surprise fees at checkout.', 'farway' ) ) ); ?>
				</p>

				<div class="stat-board">
					<div class="stat">
						<div class="num"><span class="flip" data-target="<?php echo esc_attr( farway_theme_mod( 'farway_stat1_value', '4200' ) ); ?>">0</span></div>
						<div class="label"><?php echo esc_html( farway_theme_mod( 'farway_stat1_label', __( 'Operators listed', 'farway' ) ) ); ?></div>
					</div>
					<div class="stat">
						<div class="num"><span class="flip" data-target="<?php echo esc_attr( farway_theme_mod( 'farway_stat2_value', '18' ) ); ?>">0</span>%</div>
						<div class="label"><?php echo esc_html( farway_theme_mod( 'farway_stat2_label', __( 'Avg. saved vs. retail', 'farway' ) ) ); ?></div>
					</div>
					<div class="stat">
						<div class="num"><span class="flip" data-target="<?php echo esc_attr( farway_theme_mod( 'farway_stat3_value', '342' ) ); ?>">0</span></div>
						<div class="label"><?php echo esc_html( farway_theme_mod( 'farway_stat3_label', __( 'Trips booked today', 'farway' ) ) ); ?></div>
					</div>
				</div>
			</div>

			<div class="pass-wrap">
				<div class="verified-tag"><?php esc_html_e( 'Best fare, verified', 'farway' ); ?></div>
				<div class="pass">
					<div class="notch left"></div>
					<div class="notch right"></div>

					<div class="pass-top">
						<div>
							<div class="pass-kicker"><?php esc_html_e( 'Boarding pass — search', 'farway' ); ?></div>
							<div class="pass-title"><?php esc_html_e( 'Book a trip', 'farway' ); ?></div>
						</div>
						<div class="pass-ref">
							REF
							<b>FW-<?php echo esc_html( wp_rand( 1000, 9999 ) ); ?>-KX</b>
						</div>
					</div>

					<?php
					$departures  = farway_departures();
					$destinations = get_posts( array(
						'post_type'      => 'farway_destination',
						'posts_per_page' => -1,
						'orderby'        => 'title',
						'order'          => 'ASC',
					) );
					$from = isset( $_GET['from'] ) ? sanitize_text_field( wp_unslash( $_GET['from'] ) ) : farway_theme_mod( 'farway_from_code', 'DAC' );
					$to   = isset( $_GET['destination'] ) ? absint( $_GET['destination'] ) : 0;
					?>
					<form class="farway-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
						<div class="route-row">
							<div class="code-field">
								<label class="code-label" for="farway-from"><?php esc_html_e( 'From', 'farway' ); ?></label>
								<button type="button" class="route-picker" id="farway-from" data-target="from-options" aria-haspopup="listbox" aria-expanded="false">
									<span class="route-code" id="from-code"><?php echo esc_html( $from ); ?></span>
									<span class="route-caret" aria-hidden="true">&#9662;</span>
								</button>
								<div class="code-sub" id="farway-from-city"><?php echo esc_html( isset( $departures[ $from ] ) ? $departures[ $from ] : reset( $departures ) ); ?></div>
								<div class="route-options" id="from-options" role="listbox" aria-label="<?php esc_attr_e( 'Choose departure', 'farway' ); ?>" hidden>
									<?php foreach ( $departures as $code => $city ) : ?>
										<button type="button" class="route-option<?php echo $code === $from ? ' selected' : ''; ?>" data-value="<?php echo esc_attr( $code ); ?>" data-city="<?php echo esc_attr( $city ); ?>" data-code="<?php echo esc_attr( $code ); ?>" role="option" aria-selected="<?php echo $code === $from ? 'true' : 'false'; ?>">
											<span class="route-option-code"><?php echo esc_html( $code ); ?></span>
											<span class="route-option-city"><?php echo esc_html( $city ); ?></span>
										</button>
									<?php endforeach; ?>
								</div>
								<input type="hidden" name="from" id="farway-from-input" value="<?php echo esc_attr( $from ); ?>">
							</div>
							<span class="plane" aria-hidden="true">&#9992;</span>
							<div class="code-field code-field--right">
								<label class="code-label" for="farway-destination"><?php esc_html_e( 'To', 'farway' ); ?></label>
								<button type="button" class="route-picker" id="farway-destination" data-target="to-options" aria-haspopup="listbox" aria-expanded="false">
									<span class="route-code" id="to-code"><?php echo $to ? esc_html( get_the_title( $to ) ) : esc_html__( 'ANY', 'farway' ); ?></span>
									<span class="route-caret" aria-hidden="true">&#9662;</span>
								</button>
								<div class="code-sub" id="farway-to-city"><?php echo $to ? esc_html( get_the_title( $to ) ) : esc_html__( 'Open destination', 'farway' ); ?></div>
								<div class="route-options" id="to-options" role="listbox" aria-label="<?php esc_attr_e( 'Choose destination', 'farway' ); ?>" hidden>
									<button type="button" class="route-option<?php echo ! $to ? ' selected' : ''; ?>" data-value="" data-city="<?php esc_attr_e( 'Open destination', 'farway' ); ?>" data-code="ANY" role="option" aria-selected="<?php echo ! $to ? 'true' : 'false'; ?>">
										<span class="route-option-code">ANY</span>
										<span class="route-option-city"><?php esc_html_e( 'Open destination', 'farway' ); ?></span>
									</button>
									<?php foreach ( $destinations as $destination ) : ?>
										<button type="button" class="route-option<?php echo $to == $destination->ID ? ' selected' : ''; ?>" data-value="<?php echo esc_attr( $destination->ID ); ?>" data-city="<?php echo esc_attr( $destination->post_title ); ?>" data-code="<?php echo esc_attr( $destination->post_title ); ?>" role="option" aria-selected="<?php echo $to == $destination->ID ? 'true' : 'false'; ?>">
											<span class="route-option-code"><?php echo esc_html( $destination->post_title ); ?></span>
											<span class="route-option-city"><?php esc_html_e( 'Destination', 'farway' ); ?></span>
										</button>
									<?php endforeach; ?>
								</div>
								<input type="hidden" name="destination" id="farway-destination-input" value="<?php echo esc_attr( $to ); ?>">
							</div>
						</div>

						<div class="field-grid">
							<div class="field field-date">
								<label for="farway-depart"><?php esc_html_e( 'Departure date', 'farway' ); ?></label>
								<button type="button" class="date-picker" id="date-picker" aria-haspopup="dialog" aria-expanded="false">
									<span class="date-day" id="date-day"><?php esc_html_e( 'Add date', 'farway' ); ?></span>
									<span class="date-block">
										<span class="date-month" id="date-month"><?php esc_html_e( 'Choose date', 'farway' ); ?></span>
										<span class="date-year" id="date-year"><?php echo esc_html( gmdate( 'Y' ) ); ?></span>
									</span>
									<span class="date-chevron" aria-hidden="true">&#9662;</span>
								</button>
								<div class="calendar" id="calendar" role="dialog" aria-label="<?php esc_attr_e( 'Choose departure date', 'farway' ); ?>" hidden>
									<div class="calendar-head">
										<button type="button" class="calendar-nav" id="cal-prev" aria-label="<?php esc_attr_e( 'Previous month', 'farway' ); ?>">&lsaquo;</button>
										<span class="calendar-title" id="cal-title"></span>
										<button type="button" class="calendar-nav" id="cal-next" aria-label="<?php esc_attr_e( 'Next month', 'farway' ); ?>">&rsaquo;</button>
									</div>
									<div class="calendar-dow">
										<?php foreach ( array( 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su' ) as $dow ) : ?>
											<span><?php echo esc_html( $dow ); ?></span>
										<?php endforeach; ?>
									</div>
									<div class="calendar-grid" id="calendar-grid"></div>
								</div>
								<input type="hidden" name="depart" id="farway-depart" value="<?php echo esc_attr( isset( $_GET['depart'] ) ? sanitize_text_field( wp_unslash( $_GET['depart'] ) ) : '' ); ?>">
							</div>
							<div class="field">
								<label for="farway-length"><?php esc_html_e( 'Trip length', 'farway' ); ?></label>
								<button type="button" class="field-picker" id="farway-length" data-target="length-options" aria-haspopup="listbox" aria-expanded="false">
									<span class="field-picker-value" id="length-value"><?php esc_html_e( 'Any length', 'farway' ); ?></span>
									<span class="field-picker-caret" aria-hidden="true">&#9662;</span>
								</button>
								<div class="field-options" id="length-options" role="listbox" aria-label="<?php esc_attr_e( 'Choose trip length', 'farway' ); ?>" hidden>
									<button type="button" class="field-option<?php echo empty( $_GET['trip_length'] ) ? ' selected' : ''; ?>" data-value="" data-label="<?php esc_attr_e( 'Any length', 'farway' ); ?>" role="option" aria-selected="<?php echo empty( $_GET['trip_length'] ) ? 'true' : 'false'; ?>">
										<span class="field-option-label"><?php esc_html_e( 'Any length', 'farway' ); ?></span>
									</button>
									<?php foreach ( farway_duration_options() as $value => $label ) : ?>
										<button type="button" class="field-option<?php echo ( isset( $_GET['trip_length'] ) && sanitize_text_field( wp_unslash( $_GET['trip_length'] ) ) === $value ) ? ' selected' : ''; ?>" data-value="<?php echo esc_attr( $value ); ?>" data-label="<?php echo esc_attr( $label ); ?>" role="option" aria-selected="<?php echo ( isset( $_GET['trip_length'] ) && sanitize_text_field( wp_unslash( $_GET['trip_length'] ) ) === $value ) ? 'true' : 'false'; ?>">
											<span class="field-option-label"><?php echo esc_html( $label ); ?></span>
										</button>
									<?php endforeach; ?>
								</div>
								<input type="hidden" name="trip_length" id="farway-length-input" value="<?php echo esc_attr( isset( $_GET['trip_length'] ) ? sanitize_text_field( wp_unslash( $_GET['trip_length'] ) ) : '' ); ?>">
							</div>
							<div class="field">
								<label for="travelersInput"><?php esc_html_e( 'Travelers', 'farway' ); ?></label>
								<div class="val val-stepper">
									<button type="button" id="minus" aria-label="<?php esc_attr_e( 'Decrease travelers', 'farway' ); ?>">&minus;</button>
									<span id="travelerLabel"><?php echo esc_html( isset( $_GET['travelers'] ) ? max( 1, absint( $_GET['travelers'] ) ) : 2 ); ?> <?php esc_html_e( 'adults', 'farway' ); ?></span>
									<button type="button" id="plus" aria-label="<?php esc_attr_e( 'Increase travelers', 'farway' ); ?>">+</button>
									<input type="hidden" name="travelers" id="travelersInput" value="<?php echo esc_attr( isset( $_GET['travelers'] ) ? max( 1, absint( $_GET['travelers'] ) ) : 2 ); ?>">
								</div>
							</div>
						</div>

						<button type="submit" class="cta"><?php esc_html_e( 'Find trips', 'farway' ); ?> <span class="arrow">&rarr;</span></button>
					</form>

					<div class="barcode-row">
						<div class="barcode" id="barcode"></div>
						<div class="barcode-label"><?php esc_html_e( 'Instant confirm', 'farway' ); ?></div>
					</div>
				</div>
			</div>
		</main>

		<div class="hero-scroll" aria-hidden="true">
			<span><?php esc_html_e( 'Explore', 'farway' ); ?></span>
			<div class="scroll-line"></div>
		</div>

	</div><!-- .stage -->

	<div class="farway-sections" id="farway-sections">

		<?php if ( $has_search ) : ?>
			<section class="section search-results" id="search-results" aria-labelledby="search-results-heading">
				<div class="section-inner">
					<div class="section-head">
						<span class="section-eyebrow"><?php esc_html_e( 'Search results', 'farway' ); ?></span>
						<h2 class="section-title" id="search-results-heading"><?php esc_html_e( 'Trips matching your search', 'farway' ); ?></h2>
					</div>

					<?php
					$search_query = farway_trip_search_query();
					if ( $search_query->have_posts() ) :
						?>
						<div class="card-grid">
							<?php while ( $search_query->have_posts() ) : $search_query->the_post(); ?>
								<?php farway_trip_card( $GLOBALS['post'] ); ?>
							<?php endwhile; ?>
						</div>
						<?php wp_reset_postdata(); ?>
					<?php else : ?>
						<p class="empty-note"><?php esc_html_e( 'No trips match those filters yet. Try widening your dates or destination.', 'farway' ); ?></p>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'farway_section_trips', '1' ) ) : ?>
			<section class="section" id="trips" aria-labelledby="trips-heading">
				<div class="section-inner">
					<div class="section-head">
						<span class="section-eyebrow"><?php esc_html_e( 'Featured departures', 'farway' ); ?></span>
						<h2 class="section-title" id="trips-heading"><?php echo esc_html( farway_theme_mod( 'farway_trips_title', __( 'Trips people are booking now', 'farway' ) ) ); ?></h2>
					</div>
					<?php
					$trips = new WP_Query( array(
						'post_type'      => 'farway_trip',
						'posts_per_page' => 6,
						'meta_key'       => '_farway_featured',
						'orderby'        => 'meta_value_num date',
						'order'          => 'DESC',
					) );
					if ( $trips->have_posts() ) :
						?>
						<div class="card-grid">
							<?php while ( $trips->have_posts() ) : $trips->the_post(); ?>
								<?php farway_trip_card( $GLOBALS['post'] ); ?>
							<?php endwhile; ?>
						</div>
						<div class="section-action">
							<a class="ghost-cta" href="<?php echo esc_url( get_post_type_archive_link( 'farway_trip' ) ); ?>"><?php esc_html_e( 'View all trips', 'farway' ); ?> &rarr;</a>
						</div>
						<?php wp_reset_postdata(); ?>
					<?php else : ?>
						<p class="empty-note"><?php esc_html_e( 'No trips published yet. Add some under Trips in the dashboard.', 'farway' ); ?></p>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'farway_section_destinations', '1' ) ) : ?>
			<section class="section section-alt" id="destinations" aria-labelledby="destinations-heading">
				<div class="section-inner">
					<div class="section-head">
						<span class="section-eyebrow"><?php esc_html_e( 'Where to next', 'farway' ); ?></span>
						<h2 class="section-title" id="destinations-heading"><?php echo esc_html( farway_theme_mod( 'farway_destinations_title', __( 'Destinations', 'farway' ) ) ); ?></h2>
					</div>
					<?php
					$destinations_query = new WP_Query( array(
						'post_type'      => 'farway_destination',
						'posts_per_page' => 8,
					) );
					if ( $destinations_query->have_posts() ) :
						?>
						<div class="card-grid">
							<?php while ( $destinations_query->have_posts() ) : $destinations_query->the_post(); ?>
								<?php farway_destination_card( $GLOBALS['post'] ); ?>
							<?php endwhile; ?>
						</div>
						<?php wp_reset_postdata(); ?>
					<?php else : ?>
						<p class="empty-note"><?php esc_html_e( 'No destinations published yet.', 'farway' ); ?></p>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'farway_section_stories', '1' ) ) : ?>
			<section class="section" id="stories" aria-labelledby="stories-heading">
				<div class="section-inner">
					<div class="section-head">
						<span class="section-eyebrow"><?php esc_html_e( 'Journal', 'farway' ); ?></span>
						<h2 class="section-title" id="stories-heading"><?php echo esc_html( farway_theme_mod( 'farway_stories_title', __( 'Stories from the road', 'farway' ) ) ); ?></h2>
					</div>
					<?php
					$stories = new WP_Query( array(
						'post_type'      => 'post',
						'posts_per_page' => 3,
					) );
					if ( $stories->have_posts() ) :
						?>
						<div class="card-grid">
							<?php while ( $stories->have_posts() ) : $stories->the_post(); ?>
								<article class="story-card">
									<a href="<?php the_permalink(); ?>" class="trip-media">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'large' ); ?>
										<?php else : ?>
											<div class="trip-placeholder"><?php esc_html_e( 'Story', 'farway' ); ?></div>
										<?php endif; ?>
									</a>
									<div class="trip-body">
										<div class="trip-meta">
											<span><?php echo esc_html( get_the_date() ); ?></span>
										</div>
										<h3 class="trip-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									</div>
								</article>
							<?php endwhile; ?>
						</div>
						<?php wp_reset_postdata(); ?>
					<?php else : ?>
						<p class="empty-note"><?php esc_html_e( 'No stories published yet.', 'farway' ); ?></p>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'farway_section_testimonials', '1' ) ) : ?>
			<section class="section section-alt" id="testimonials" aria-labelledby="testimonials-heading">
				<div class="section-inner">
					<div class="section-head">
						<span class="section-eyebrow"><?php esc_html_e( 'Verified reviews', 'farway' ); ?></span>
						<h2 class="section-title" id="testimonials-heading"><?php echo esc_html( farway_theme_mod( 'farway_testimonials_title', __( 'Travelers love Farway', 'farway' ) ) ); ?></h2>
					</div>
					<?php
					$testimonials = new WP_Query( array(
						'post_type'      => 'farway_testimonial',
						'posts_per_page' => 3,
					) );
					if ( $testimonials->have_posts() ) :
						?>
						<div class="card-grid">
							<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
								<?php
								$testimonial_role     = get_post_meta( get_the_ID(), '_farway_role', true );
								$testimonial_rating   = (int) get_post_meta( get_the_ID(), '_farway_rating', true );
								$testimonial_trip_id  = (int) get_post_meta( get_the_ID(), '_farway_trip_id', true );
								$testimonial_verified = get_post_meta( get_the_ID(), '_farway_verified', true );
								?>
								<figure class="testimonial-card">
									<?php if ( $testimonial_rating ) : ?>
										<div class="testimonial-stars" aria-label="<?php printf( esc_attr__( 'Rated %d out of 5', 'farway' ), $testimonial_rating ); ?>">
											<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
												<span class="<?php echo $i <= $testimonial_rating ? 'is-filled' : ''; ?>">&#9733;</span>
											<?php endfor; ?>
										</div>
									<?php endif; ?>
									<blockquote><?php the_content(); ?></blockquote>
									<?php if ( $testimonial_trip_id ) : ?>
										<a class="testimonial-trip" href="<?php echo esc_url( get_permalink( $testimonial_trip_id ) ); ?>"><?php esc_html_e( 'View this trip', 'farway' ); ?> &rarr;</a>
									<?php endif; ?>
									<figcaption>
										<?php if ( has_post_thumbnail() ) : ?>
											<span class="testimonial-avatar"><?php the_post_thumbnail( 'thumbnail' ); ?></span>
										<?php endif; ?>
										<span class="testimonial-identity">
											<span class="testimonial-author">
												<?php the_title(); ?>
												<?php if ( $testimonial_verified ) : ?>
													<span class="testimonial-verified" title="<?php esc_attr_e( 'Verified reviewer', 'farway' ); ?>">&#10003;</span>
												<?php endif; ?>
											</span>
											<?php if ( $testimonial_role ) : ?>
												<span class="testimonial-role"><?php echo esc_html( $testimonial_role ); ?></span>
											<?php endif; ?>
										</span>
									</figcaption>
								</figure>
							<?php endwhile; ?>
						</div>
						<?php wp_reset_postdata(); ?>
					<?php else : ?>
						<p class="empty-note"><?php esc_html_e( 'No testimonials published yet.', 'farway' ); ?></p>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'farway_section_faq', '1' ) ) : ?>
			<section class="section" id="faq" aria-labelledby="faq-heading">
				<div class="section-inner narrow">
					<div class="section-head">
						<span class="section-eyebrow"><?php esc_html_e( 'Good to know', 'farway' ); ?></span>
						<h2 class="section-title" id="faq-heading"><?php echo esc_html( farway_theme_mod( 'farway_faq_title', __( 'Before you book', 'farway' ) ) ); ?></h2>
					</div>
					<?php
					$faqs = new WP_Query( array(
						'post_type'      => 'farway_faq',
						'posts_per_page' => 8,
						'orderby'        => 'menu_order title',
						'order'          => 'ASC',
					) );
					if ( $faqs->have_posts() ) :
						?>
						<div class="faq-list">
							<?php while ( $faqs->have_posts() ) : $faqs->the_post(); ?>
								<details class="faq-item">
									<summary>
										<span><?php the_title(); ?></span>
										<?php $faq_topic = get_post_meta( get_the_ID(), '_farway_topic', true ); ?>
										<?php if ( $faq_topic ) : ?>
											<span class="faq-topic"><?php echo esc_html( $faq_topic ); ?></span>
										<?php endif; ?>
									</summary>
									<div class="faq-answer"><?php the_content(); ?></div>
								</details>
							<?php endwhile; ?>
						</div>
						<?php wp_reset_postdata(); ?>
					<?php else : ?>
						<p class="empty-note"><?php esc_html_e( 'No FAQs published yet.', 'farway' ); ?></p>
					<?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'farway_section_contact', '1' ) ) : ?>
			<section class="section section-alt" id="contact" aria-labelledby="contact-heading">
				<div class="section-inner">
					<div class="section-head">
						<span class="section-eyebrow"><?php esc_html_e( 'Human help', 'farway' ); ?></span>
						<h2 class="section-title" id="contact-heading"><?php echo esc_html( farway_theme_mod( 'farway_contact_title', __( 'Talk to a travel expert', 'farway' ) ) ); ?></h2>
					</div>
					<div class="contact-grid">
						<div class="contact-info">
							<ul>
								<li><span><?php esc_html_e( 'Phone', 'farway' ); ?></span><?php echo esc_html( farway_theme_mod( 'farway_contact_phone', '+1 (555) 010-2030' ) ); ?></li>
								<li><span><?php esc_html_e( 'Email', 'farway' ); ?></span><?php echo esc_html( farway_theme_mod( 'farway_contact_email', 'hello@example.com' ) ); ?></li>
								<li><span><?php esc_html_e( 'Address', 'farway' ); ?></span><?php echo esc_html( farway_theme_mod( 'farway_contact_address', '12 Harbor Street, Suite 40' ) ); ?></li>
								<li><span><?php esc_html_e( 'Hours', 'farway' ); ?></span><?php echo esc_html( farway_theme_mod( 'farway_contact_hours', 'Mon–Sat, 9:00–18:00' ) ); ?></li>
							</ul>
						</div>
						<form class="inquiry-form" id="inquiry-form">
							<div class="inquiry-row">
								<input type="text" name="name" placeholder="<?php esc_attr_e( 'Your name', 'farway' ); ?>" required>
								<input type="email" name="email" placeholder="<?php esc_attr_e( 'Email address', 'farway' ); ?>" required>
							</div>
							<div class="inquiry-row">
								<input type="tel" name="phone" placeholder="<?php esc_attr_e( 'Phone (optional)', 'farway' ); ?>">
								<input type="number" name="travelers" min="1" max="9" value="2" placeholder="<?php esc_attr_e( 'Travelers', 'farway' ); ?>">
							</div>
							<div class="inquiry-row">
								<input type="date" name="depart" placeholder="<?php esc_attr_e( 'Preferred date', 'farway' ); ?>">
								<input type="text" name="destination" placeholder="<?php esc_attr_e( 'Destination', 'farway' ); ?>">
							</div>
							<textarea name="message" rows="4" placeholder="<?php esc_attr_e( 'Tell us what you are dreaming about…', 'farway' ); ?>"></textarea>
							<button type="submit" class="cta"><?php esc_html_e( 'Send inquiry', 'farway' ); ?> <span class="arrow">&rarr;</span></button>
							<div class="form-status" aria-live="polite"></div>
						</form>
					</div>
				</div>
			</section>
		<?php endif; ?>

	</div><!-- .farway-sections -->

<?php get_footer(); ?>
