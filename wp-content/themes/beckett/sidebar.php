<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package beckett
 */
?>

<?php
if(is_archive() && is_active_sidebar('sidebar_posts')) : $sidebar = 'sidebar_posts';
elseif(is_home() && is_active_sidebar('sidebar_posts')) : $sidebar = 'sidebar_posts';
elseif(is_single() && is_active_sidebar('sidebar_posts')) : $sidebar = 'sidebar_posts';
elseif(is_page() && is_active_sidebar('sidebar_pages')) : $sidebar = 'sidebar_pages';
elseif(is_search() && is_active_sidebar('sidebar_posts')) : $sidebar = 'sidebar_posts';		
else : $sidebar = 'sidebar_default';?>
<?php endif; ?>

<?php if( beckett_get_widgets_count( $sidebar ) > 0 ) { ?>
	<div id="secondary" class="widget-area sidebar" role="complementary">
		<div class="inside widgets clear">
	   		<?php dynamic_sidebar( $sidebar ); ?>
		</div>
	</div><!-- #secondary -->
<?php } ?>
