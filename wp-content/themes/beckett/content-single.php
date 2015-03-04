<?php
/**
 * @package beckett
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<header class="entry-header">
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="meta clearfix">

<?php /* TODO: Translate the Post text

				<span class="posted"><?php _e('Posted ', 'beckett'); ?></span>
				<span class="date"><?php _e('on', 'beckett'); ?> <?php the_time( 'M j, Y' ); ?></span>
				<span class="category"><?php _e('in', 'beckett'); ?> <?php the_category(', '); ?></span>		
*/?>
				<span class="posted">Publiée</span>
				<span class="date">le <?php the_time( 'j M Y' ); ?></span>
				<span class="category">dans <?php the_category(', '); ?></span>		

			</div>
		<?php endif; ?>		

	</header><!-- .entry-header -->
	
	<div class="body-wrap">
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'beckett' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	</div><!-- .body-wrap -->
	
	
</article><!-- #post-## -->
