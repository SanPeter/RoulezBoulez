<?php
$posts_count = get_theme_mod( 'beckett_recent_posts_count', 3 );
?>
<?php if($posts_count > 0) { ?>

<section id="blog">
	<?php $recent_posts_title = get_theme_mod( 'beckett_recent_posts_title', __( 'Recent Posts', 'beckett' ) ); ?>
	<?php $blog_page_id = get_option( 'page_for_posts' ); ?>
	<?php if( $recent_posts_title ):?>
		<header <?php if( get_theme_mod( 'beckett_recent_posts_image' ) ) { ?> class="has-background" style="background-image: url('<?php echo get_theme_mod( 'beckett_recent_posts_image' ); ?>');" <?php } ?>>
		<h2><?php echo wp_kses_post($recent_posts_title); ?></h2>
		<?php echo wpautop(wp_kses_post( do_shortcode(get_theme_mod('beckett_recent_posts_summary') )) ); ?>			
		<span class="header-triangle"></span>
		</header>		
		
	<?php endif; ?>
	
	<?php
	$args = array(
		'ignore_sticky_posts' => 1,
    	'posts_per_page' => $posts_count,
    	'post_type' => array(
			'post'
		)
	);
	?>
	<?php $recentPosts = new WP_Query( $args ); ?>
	<div class="posts">
		<div class="default thumbs">
	<?php while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
		<?php get_template_part( 'content-post-small' ); ?>
	<?php endwhile; ?>
		</div>
	</div>
</section><!-- #blog -->
<?php } ?>