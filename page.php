<?php
/**
 * Template for static pages.
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

			<h1 class="post-title"><?php the_title(); ?></h1>

			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large', array( 'class' => 'post-thumb' ) ); ?>
			<?php endif; ?>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>

		<?php endwhile; ?>

	</div>
</div>

<?php get_footer(); ?>
