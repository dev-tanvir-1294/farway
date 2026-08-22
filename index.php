<?php
/**
 * The main template file — used for blog index, archives, and as a fallback.
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

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large', array( 'class' => 'post-thumb' ) ); ?></a>
					<?php endif; ?>

					<h2 class="post-card-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>

					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div>

					<a href="<?php the_permalink(); ?>" class="cta read-more">
						<?php esc_html_e( 'Read more', 'farway' ); ?> <span class="arrow">&rarr;</span>
					</a>
				</article>

			<?php endwhile; ?>

			<?php the_posts_pagination(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'Nothing found.', 'farway' ); ?></p>

		<?php endif; ?>

	</div>
</div>

<?php get_footer(); ?>
