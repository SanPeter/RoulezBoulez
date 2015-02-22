<?php
/**
 * The Template for displaying all single posts.
 *
 * @package beckett
 */

get_header(); ?>

<div id="primary">
	
	<header class="main entry-header">
		<div class="inside">
			<h1 class="entry-title"><?php _e( 'Testimonials', 'beckett' ); ?></h1>					
		</div>
	</header><!-- .entry-header -->
	
	
	<main id="main" class="site-main" role="main">
		<div class="main-inside clear">
		<div class="content-area">
	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>			

		<?php endwhile; // end of the loop. ?>
	<?php endif; ?>
	</div>
	<?php get_sidebar(); ?>
	</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>