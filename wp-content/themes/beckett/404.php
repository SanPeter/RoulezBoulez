<?php
/**
 * @package beckett
 */

get_header(); ?>

	<div id="primary">

		<header class="main entry-header">
			<div class="inside">			
				<h2><?php _e( 'Oops! That page can&rsquo;t be found.', 'beckett' ); ?></h2>				
				</div>
		</header><!-- .entry-header -->

			<main id="main" class="site-main" role="main">
				<div class="main-inside clear">
				<div class="content-area">
					
				<p><?php _e( 'The page you are looking for could not be found. Try a different address, or search using the form below.', 'beckett' ); ?></p>

				<?php get_search_form(); ?>

				<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

				<?php if ( beckett_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
				<div class="widget widget_categories">
					<h2 class="widget-title"><?php _e( 'Most Used Categories', 'beckett' ); ?></h2>
					<ul>
					<?php
						wp_list_categories( array(
							'orderby'    => 'count',
							'order'      => 'DESC',
							'show_count' => 1,
							'title_li'   => '',
							'number'     => 10,
						) );
					?>
					</ul>
				</div><!-- .widget -->
				<?php endif; ?>

			</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
