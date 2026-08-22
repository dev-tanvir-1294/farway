<?php
/**
 * Search results template.
 *
 * @package Farway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="farway-content" id="primary">
	<div class="content-inner content-inner--medium">

		<h1 class="post-title">
			<?php printf( esc_html__( 'Search results for "%s"', 'farway' ), esc_html( get_search_query() ) ); ?>
		</h1>

		<?php if ( have_posts() ) : ?>
			<div class="card-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					if ( 'farway_trip' === get_post_type() ) {
						farway_trip_card( $GLOBALS['post'] );
					} elseif ( 'farway_destination' === get_post_type() ) {
						farway_destination_card( $GLOBALS['post'] );
					} elseif ( 'farway_faq' === get_post_type() ) {
						?>
						<article class="search-faq">
							<h2 class="search-faq-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
							<div class="entry-summary"><?php the_excerpt(); ?></div>
						</article>
						<?php
					} else {
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'story-card' ); ?>>
							<a href="<?php the_permalink(); ?>" class="trip-media">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large' ); ?>
								<?php else : ?>
									<div class="trip-placeholder"><?php esc_html_e( 'Post', 'farway' ); ?></div>
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
			<p><?php esc_html_e( 'No results found. Try a different search.', 'farway' ); ?></p>
		<?php endif; ?>

	</div>
</div>

<?php get_footer(); ?>
