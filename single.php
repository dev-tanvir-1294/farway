<?php
/**
 * Template for single blog posts.
 *
 * @package Farway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="farway-content" id="primary">
	<div class="content-inner content-inner--narrow">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<p class="post-date">
				<?php echo esc_html( get_the_date() ); ?>
			</p>

			<h1 class="post-title"><?php the_title(); ?></h1>

			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large', array( 'class' => 'post-thumb' ) ); ?>
			<?php endif; ?>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<?php
			$tags = get_the_tags();
			if ( $tags ) :
				?>
				<div class="entry-tags">
					<?php foreach ( $tags as $tag ) : ?>
						<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>">#<?php echo esc_html( $tag->name ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'farway' ),
				'after'  => '</div>',
			) );
			?>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>

			</article>

		<?php endwhile; ?>

	</div>
</div>

<?php get_footer(); ?>
