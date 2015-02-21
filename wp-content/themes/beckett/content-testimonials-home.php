	<?php
	$testimonials_background = get_theme_mod( 'beckett_testimonials_image' );
	$testimonials_count = get_theme_mod( 'beckett_testimonials_count', 3 );
	$args = array(
		'ignore_sticky_posts' => 1,    	
		'post_type' => array(				
		'testimonial'					
		),
		'posts_per_page' => $testimonials_count,
	);
	$testimonials = new WP_Query( $args );		
	?>
	<?php if($testimonials->have_posts() && $testimonials_count > 0) { ?>
	<section id="testimonials"  <?php if( $testimonials_background ) { ?> class="has-background" <?php }?> >
		
				<?php $testimonials_title = get_theme_mod( 'beckett_testimonials_title', __( 'Testimonials', 'beckett' ) ); ?>
				<?php $blog_page_id = get_option( 'page_for_posts' ); ?>
				<?php if( $testimonials_title ):?>
					<header <?php if( $testimonials_background ) { ?> class="has-background" style="background-image: url('<?php echo get_theme_mod( 'beckett_testimonials_image' ); ?>');" <?php } ?>>
					<h2><?php echo wp_kses_post($testimonials_title); ?></h2>
					<?php echo wpautop(wp_kses_post( do_shortcode(get_theme_mod('beckett_testimonials_summary') )) ); ?>			
					<span class="header-triangle"></span>
					</header>		

				<?php endif; ?>		
				
				<div class="testimonials">
					<div class="flexslider">		
						<ul class="slides">
						<?php while ($testimonials->have_posts()) : $testimonials->the_post(); ?>			    
						<li class="testimonial clearfix">	
							<div class="left">			
								<?php the_post_thumbnail("ttrust_square_medium", array('class' => '', 'alt' => ''.get_the_title().'', 'title' => ''.get_the_title().'')); ?>						
							</div>	
							<div class="right">			
								<?php the_content(); ?>	
								<span class="title"><span><?php the_title(); ?></span></span>
							</div>			
						</li>
						<?php endwhile; ?>		
						</ul>
					</div>
					<script type="text/javascript">
					//<![CDATA[
					jQuery(document).ready(function(){
					jQuery('#testimonials .flexslider').imagesLoaded(function() {		
						jQuery('#testimonials .flexslider').flexslider({
							slideshowSpeed: 8000,  
							directionNav: true,
							slideshow: true,				 				
							animation: 'fade',
							animationLoop: true
						});  
					});
					});
					//]]>
					</script>
				</div>	
		
	</section><!-- #testimonials -->
	<?php } ?>