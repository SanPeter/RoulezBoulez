<div <?php post_class('small'); ?>>	
	<div class="inside">
	
	<?php if(has_post_thumbnail()) : ?>			
		<a href="<?php the_permalink() ?>" rel="bookmark" ><?php the_post_thumbnail('beckett_post_thumb_small', array('class' => 'postThumb alignleft', 'alt' => ''.get_the_title().'', 'title' => ''.get_the_title().'')); ?></a>
	<?php endif; ?>	
		

	<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" ><?php the_title(); ?></a></h2>	
	
	
	</div>
</div>