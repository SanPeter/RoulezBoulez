<?php
/**
 * The template for displaying Archive pages.
 * @package beckett
 */

get_header(); ?>

	<div id="primary">
		
				<header class="main entry-header">
					<div class="inside">		
					<h1 class="entry-title">
						<?php
							if ( is_category() ) :
								single_cat_title();

							elseif ( is_tag() ) :
								single_tag_title();

							elseif ( is_author() ) :
								printf( __( 'Author: %s', 'beckett' ), '<span class="vcard">' . get_the_author() . '</span>' );

							elseif ( is_day() ) :
								printf( __( 'Day: %s', 'beckett' ), '<span>' . get_the_date() . '</span>' );

							elseif ( is_month() ) :
								printf( __( 'Month: %s', 'beckett' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'beckett' ) ) . '</span>' );

							elseif ( is_year() ) :
								printf( __( 'Year: %s', 'beckett' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'beckett' ) ) . '</span>' );

							elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
								_e( 'Asides', 'beckett' );

							elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
								_e( 'Galleries', 'beckett');

							elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
								_e( 'Images', 'beckett');

							elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
								_e( 'Videos', 'beckett' );

							elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
								_e( 'Quotes', 'beckett' );

							elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
								_e( 'Links', 'beckett' );

							elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
								_e( 'Statuses', 'beckett' );

							elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
								_e( 'Audios', 'beckett' );

							elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
								_e( 'Chats', 'beckett' );

							else :
								_e( 'Archives', 'beckett' );

							endif;
						?>
					</h1>					
					<?php // Show an optional term description.		
					$term_description = term_description();
					if ( ! empty( $term_description ) ) {
					?>
					
					<span class="meta">			
						<?php echo $term_description; ?>		
					</span>	
					<?php } ?>	
					</div>
				</header><!-- .entry-header -->
				<main id="main" class="site-main" role="main">
					<div class="main-inside clear">
					<div class="content-area">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php beckett_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
		</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
