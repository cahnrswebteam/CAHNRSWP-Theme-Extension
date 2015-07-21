<?php get_header(); ?>

	<main class="spine-blank-template">

		<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>

			<?php get_template_part('parts/headers'); ?>
			<?php get_template_part('parts/featured-images'); ?>

			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php the_content(); ?>

			</div>

		<?php endwhile; endif; ?>

		<?php get_template_part( 'parts/footers' ); ?>

	</main>

<?php get_footer(); ?>