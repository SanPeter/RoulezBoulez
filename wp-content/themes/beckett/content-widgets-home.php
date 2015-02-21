<?php
if(is_active_sidebar('home_content')) { 
	$sidebar = 'home_content';
}
?>
<?php if( beckett_get_widgets_count( $sidebar ) > 0 ) { ?>
	<section id="widgets-home" class="widget-area" >
		<div class="inside widgets clear default thumbs">
	   		<?php dynamic_sidebar( $sidebar ); ?>
		</div>
	</section>
<?php }; ?>
