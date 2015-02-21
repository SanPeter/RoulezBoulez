<?php
/**
 * @package beckett
 */

get_header(); ?>

	<div id="primary">
		<?php			
		if (is_blog() && !is_front_page()) {?>
		<header class="main entry-header">
			<div class="inside">
					<?php
					$blog_page_id = get_option('page_for_posts'); 
					$blog_page = get_page($blog_page_id);		
					?>			
						<h1 class="entry-title"><?php echo $blog_page->post_title; ?></h1>					
						<?php if( $blog_page->post_excerpt ) { ?>
						<hr class="short" />
						<span class="meta">			
							<?php echo $blog_page->post_excerpt; ?>		
						</span>	
						<?php } ?>	
						<span class="overlay"></span>					
			</div>
		</header><!-- .entry-header -->
		<?php } ?>
		
		<main id="main" class="site-main" role="main">
			<div class="main-inside clear">
			<div class="content-area">
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>		

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
		</div>
		<?php beckett_paging_nav(); ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
