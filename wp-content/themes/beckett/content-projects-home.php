	<?php
	$projects_count = get_theme_mod( 'beckett_recent_projects_count', 3);
	?>
	<?php if($projects_count > 0) { ?>
	<section id="projects-home">
		
		<div id="projects" class="portfolio-content">
			
			<header>
			<h2><?php echo wp_kses_post(get_theme_mod( 'beckett_recent_projects_title', __( 'Recent Projects', 'beckett' ) )); ?></h2>			
			<?php $portfolio_page_id = beckett_get_portfolio_id(); ?>
			<?php echo wpautop(wp_kses_post( do_shortcode(get_theme_mod('beckett_recent_projects_summary') )) ); ?>	
			
			<?php $portfolio_page_id = beckett_get_portfolio_id(); ?>
			<?php if($portfolio_page_id) : ?>			
			<a href="<?php echo esc_url( get_permalink( $portfolio_page_id ) ); ?>" class="view-all"></a>			
			<?php endif; ?>
					
			</header>
				
			<?php				
					$args = array(
						'ignore_sticky_posts' 	=> 1,
			    		'posts_per_page' 		=> $projects_count,
			    		'post_type' 			=> array('project')
					);			

				$projects = new WP_Query( $args ); ?>
				<?php
				global $ttrust_config;
				$ttrust_config['isotope_class'] = '';				
				?>
			<div class="thumbs clearfix">
				<?php  while ( $projects->have_posts() ) : $projects->the_post(); ?>
					<?php get_template_part( 'content-project-thumb' ); ?>
				<?php endwhile; ?>
			</div>
			
		</div>
		
	</section><!-- #projects-home -->
	<?php } ?>