<?php
$featured_background = get_theme_mod( 'beckett_featured_content_image' );

$args = array(
	'ignore_sticky_posts' => 1,
	'posts_per_page' => 20,
	'post_type' => 'page',	
	'tag'       => 'featured'
);
$featured_items = new WP_Query( $args );	
?>

<?php if($featured_items->post_count > 0) { ?>
<section id="featured-items"  <?php if( $featured_background ) { ?> class="has-background" <?php }?> >
	
			<?php $featured_title = get_theme_mod( 'beckett_featured_title', __( 'Our Team', 'beckett' ) ); ?>
			<?php $blog_page_id = get_option( 'page_for_posts' ); ?>
			<?php if( $featured_title ) { ?>
				<header <?php if( $featured_background ) { ?> class="has-background" style="background-image: url('<?php echo $featured_background; ?>');" <?php } ?>>
				<h2><?php echo wp_kses_post($featured_title); ?></h2>
				<?php echo wpautop(wp_kses_post( do_shortcode(get_theme_mod('beckett_featured_summary') )) ); ?>			
				<span class="header-triangle"></span>
				</header>
			<?php } ?>

<div class="featured-items">					
		<div class="thumbs default">	
			<?php $i = 1; while ($featured_items->have_posts()) : $featured_items->the_post(); ?>
			
			<div id="featured-item-<?php echo $i; ?>" <?php post_class('small'); ?> >						
				<div class="inside">
					<?php the_post_thumbnail("medium", array('class' => '', 'alt' => ''.get_the_title().'', 'title' => ''.get_the_title().'')); ?>
					<h3><?php the_title(); ?></h3>
					<?php the_excerpt(); ?>							
				</div>												
			</div>				
			<?php $i++;endwhile; ?>
		</div>
	</div>					
</div>
<?php } ?>