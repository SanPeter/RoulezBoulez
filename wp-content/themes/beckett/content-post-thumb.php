<?php
/**
 * @package beckett
 */

if(has_post_thumbnail()) : ?>
	<div class="featured-image">
		<a href="<?php the_permalink() ?>" rel="bookmark" ><?php the_post_thumbnail( 'beckett_post_thumb', array( 'class' => 'post-thumb', 'alt' => ''. the_title_attribute( 'echo=0' ) .'', 'title' => ''. the_title_attribute( 'echo=0' ) .'' ) ); ?></a>
	</div>
<?php endif; ?>