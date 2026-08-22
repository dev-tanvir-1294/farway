<?php
/**
 * Archive template for trips and destinations.
 *
 * @package Farway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="farway-content" id="primary">
	<div class="content-inner content-inner--wide">

		<h1 class="post-title">
			<?php
			if ( is_post_type_archive( 'farway_trip' ) ) {
				esc_html_e( 'All trips', 'farway' );
			} elseif ( is_post_type_archive( 'farway_destination' ) ) {
				esc_html_e( 'All destinations', 'farway' );
			} elseif ( is_post_type_archive( 'farway_faq' ) ) {
				esc_html_e( 'Frequently asked questions', 'farway' );
			} else {
				the_archive_title();
			}
			?>
		</h1>
		<p class="archive-description">
			<?php
			if ( is_post_type_archive( 'farway_trip' ) ) {
				esc_html_e( 'Browse every departure currently available.', 'farway' );
			} elseif ( is_post_type_archive( 'farway_destination' ) ) {
				esc_html_e( 'Find your next place on the map.', 'farway' );
			} elseif ( is_post_type_archive( 'farway_faq' ) ) {
				esc_html_e( 'Answers to the questions travelers ask most.', 'farway' );
			} else {
				the_archive_description();
			}
			?>
		</p>

		<?php if ( have_posts() ) : ?>
			<?php $is_faq_archive = is_post_type_archive( 'farway_faq' ); ?>
			<div class="<?php echo $is_faq_archive ? 'faq-list' : 'card-grid'; ?>">
				<?php
				while ( have_posts() ) :
					the_post();
					if ( 'farway_trip' === get_post_type() ) {
						farway_trip_card( $GLOBALS['post'] );
					} elseif ( 'farway_destination' === get_post_type() ) {
						farway_destination_card( $GLOBALS['post'] );
					} elseif ( 'farway_faq' === get_post_type() ) {
						?>
						<details class="faq-item">
							<summary><?php the_title(); ?></summary>
							<div class="faq-answer"><?php the_content(); ?></div>
						</details>
						<?php
					} else {
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'story-card' ); ?>>
							<a href="<?php the_permalink(); ?>" class="trip-media">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large' ); ?>
								<?php else : ?>
									<div class="trip-placeholder"><?php esc_html_e( 'Story', 'farway' ); ?></div>
								<?php endif; ?>
							</a>
							<div class="trip-body">
								<div class="trip-meta"><span><?php echo esc_html( get_the_date() ); ?></span></div>
								<h2 class="trip-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							</div>
						</article>
						<?php
					}
				endwhile;
				?>
			</div>

			<?php the_posts_pagination(); ?>

		<?php else : ?>
			<p><?php esc_html_e( 'Nothing found.', 'farway' ); ?></p>
		<?php endif; ?>

	</div>
</div>

<?php get_footer(); ?>
