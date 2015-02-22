<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package beckett
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('content'); ?>>
	
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'beckett' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
		
</div><!-- #post-## -->
