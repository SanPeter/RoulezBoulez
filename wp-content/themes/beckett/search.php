<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package beckett
 */

get_header(); ?>

	<div id="primary" class="">
			
				<header class="main entry-header" style="">
					<div class="inside">					
					<h1 class="entry-title"><h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'beckett' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</div>
				</header><!-- .entry-header -->
			
		<main id="main" class="site-main" role="main">
			<div class="main-inside clear">
			<div class="content-area">
		<?php if ( have_posts() ) : ?>		

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'content', 'search' );
				?>

			<?php endwhile; ?>

			<?php beckett_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
		</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>