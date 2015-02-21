<?php
/**
 * @package beckett
 */

get_header(); ?>

	<div id="primary" class="">
		<header class="main entry-header">
			<div class="inside">			
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

			<?php if( $post->post_excerpt ) { ?>				
			<span class="meta">			
				<?php echo $post->post_excerpt; ?>		
			</span>	
			<?php } ?>	
			</div>
		</header><!-- .entry-header -->
		
		
		<main id="main" class="site-main" role="main">
			<div class="main-inside clear">
			<div class="content-area">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php if ( comments_open() || '0' != get_comments_number() ) : // If comments are open or we have at least one comment, load up the comment template?>
						<div class="comments-wrap">
							<?php comments_template(); ?>
						</div>
				<?php endif; ?>

			<?php endwhile; // end of the loop. ?>
			</div>
			<?php get_sidebar(); ?>
			</div>
		</main><!-- #main -->
		
	</div><!-- #primary -->


<?php get_footer(); ?>