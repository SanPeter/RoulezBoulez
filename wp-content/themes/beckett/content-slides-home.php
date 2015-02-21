<?php
$args = array(
	'ignore_sticky_posts' => 1,
	'posts_per_page' => 20,
	'post_type' => 'slide'
);
$slides = new WP_Query( $args );	
?>

<?php if($slides->post_count > 0) :?>
<div id="slideshow">			
	<div class="flexslider">		
		<ul class="slides">	
			<?php $i = 1; while ($slides->have_posts()) : $slides->the_post(); ?>
			<?php
			//Get slide options			
			$slide_background_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'beckett_full_width' ); 			
			$slide_background_img = $slide_background_img[0];

			$s_styles = "";
			$s_class = "slide";
			if($slide_background_img){
				$s_styles .= "background-image: url(".$slide_background_img.");";							
			}		
			?>					

			<li id="slide-<?php echo $i; ?>" <?php post_class($s_class); ?> style="<?php echo $s_styles;?>">								
					<div class="content">
						<div class="box">
							<div class="inside">
								<div class="text">
									<?php the_content(); ?>								
								</div>
							</div>
						</div>					
					</div>									
			</li>				
			<?php $i++;endwhile; ?>
		</ul>
	</div>					
</div>
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function(){
jQuery('#slideshow .flexslider').imagesLoaded(function() {		
	jQuery('#slideshow .flexslider').flexslider({
		slideshowSpeed: 10000,  
		directionNav: true,
		slideshow: true,				 				
		animation: 'fade',
		animationLoop: true
	});  
});
});
//]]>
</script>
<?php endif; ?>