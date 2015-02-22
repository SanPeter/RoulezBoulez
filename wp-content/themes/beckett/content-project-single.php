<?php
/**
 * @package beckett
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
	$featured_image = "";
	$c = ""; 
	if (is_single()) {
		if( has_post_thumbnail() ) { 
			$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'beckett_full_width' ); 
			$c = "has-background";		
		}
	} 
	?>
	
	
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'beckett' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->	
	
</article><!-- #post-## -->
