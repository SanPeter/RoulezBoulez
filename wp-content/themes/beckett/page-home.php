<?php
/**
 * Template Name: Home
 * @package beckett
 */

get_header(); ?>

	<!-- Portfolio Home -->
	<?php get_template_part( 'content-projects-home' ); ?>

	<!-- Widgets Home -->
	<?php get_template_part( 'content-widgets-home' ); ?>	

	<!-- Blog Home -->
	<?php get_template_part( 'content-posts-home' ); ?>
	
	<!-- Testimonials Home -->
	<?php get_template_part( 'content-testimonials-home' ); ?>
	
	<!-- Featured Content -->
	<?php get_template_part( 'content-featured-home' ); ?>
	
	<!-- Static Content -->	
	<?php while (have_posts()) : the_post(); //home content section ?>
		<?php if($post->post_content):?>
		<section id="main-content" class="content-area">
					<?php // $home_content_bkg = get_theme_mod('beckett_home_content_bkg'); ?>

					<div id="home-content" class="full home-section clearfix <?php // if($home_content_bkg) echo "has-background"; ?>">
						<div class="inside">

						<?php the_content(); ?>

						</div>
					</div>
		</section><!-- #main-content -->
		<?php endif; ?>
	<?php endwhile; ?>

<?php get_footer(); ?>
