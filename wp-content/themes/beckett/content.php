<?php
/**
 * @package beckett
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="body-wrap">
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="meta clearfix">

				<span class="posted"><?php _e('Posted ', 'beckett'); ?></span>					
				<span class="author"><?php _e('by', 'beckett'); ?> <?php the_author_posts_link(); ?></span>
				<span class="date"><?php _e('on', 'beckett'); ?> <?php the_time( 'M j, Y' ); ?></span>
				<span class="category"><?php _e('in', 'beckett'); ?> <?php the_category(', '); ?></span>		
				<span class="commentCount">| <a href="<?php comments_link(); ?>"><?php comments_number(__('No Comments', 'beckett'), __('One Comment', 'beckett'), __('% Comments', 'beckett')); ?></a></span>

			</div>
		<?php endif; ?>

		<?php get_template_part( 'content-post-thumb'); ?>

	</header><!-- .entry-header -->

	<?php
		$show_excerpt = TRUE;
		if ( is_search() || $show_excerpt ) : // Display Excerpts on Option or Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
		<?php beckett_more_link(); ?>		
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>	
	</div>
</article><!-- #post-## -->
