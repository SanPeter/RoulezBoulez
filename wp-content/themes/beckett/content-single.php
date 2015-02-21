<?php
/**
 * @package beckett
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title">', esc_url( get_permalink() ) ), '</h1>' ); ?>
		
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="meta clearfix">

				<span class="posted"><?php _e('Posted ', 'beckett'); ?></span>					
				<span class="author"><?php _e('by', 'beckett'); ?> <?php the_author_posts_link(); ?></span>
				<span class="date"><?php _e('on', 'beckett'); ?> <?php the_time( 'M j, Y' ); ?></span>
				<span class="category"><?php _e('in', 'beckett'); ?> <?php the_category(', '); ?></span>		
				<span class="commentCount">| <a href="<?php comments_link(); ?>"><?php comments_number(__('No Comments', 'beckett'), __('One Comment', 'beckett'), __('% Comments', 'beckett')); ?></a></span>

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
