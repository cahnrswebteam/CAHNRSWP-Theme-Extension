<?php get_header(); ?>

	<main class="spine-blank-template">

		<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>

			<?php get_template_part('parts/headers'); ?>
			<?php get_template_part('parts/featured-images'); ?>

			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php remove_filter( 'the_content', 'wpautop', 10 ); ?>
				<?php the_content(); ?>
				<?php add_filter( 'the_content', 'wpautop', 10 ); ?>

			</div>

		<?php endwhile; endif; ?>

		<?php get_template_part( 'parts/footers' ); ?>

	</main>

<?php get_footer(); ?>