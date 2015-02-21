<?php
/**
 * @package beckett
 */
?>
	<?php global $ttrust_config; ?>
	<div class="project small <?php echo $ttrust_config['isotope_class']; ?>" id="<?php echo $post->ID; ?>">
		<div class="inside">
			<a href="<?php the_permalink(); ?>" rel="bookmark" alt="<?php the_title(); ?>" >
				<?php if( has_post_thumbnail() ) {
					the_post_thumbnail( 'beckett_project_thumb', array( 'class' => '', 'alt' => '' . the_title_attribute( 'echo=0' ) . '', 'title' => '' . the_title_attribute( 'echo=0' ) . '' ) );
					}
				?>
				<span class="title"><span><?php the_title(); ?></span></span>
				<span class="overlay"><span></span></span>
			</a>
		</div>
	</div>