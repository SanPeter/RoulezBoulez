<?php
// @package beckett
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	
<div id="container">
	<div class="site-header">	

				<?php 
				$ttrust_header_class = "";
				$ttrust_header_text = get_theme_mod( 'beckett_header_text' ); 
				if($ttrust_header_text) $ttrust_header_class = " has-text";
				?>
			
				<div class="inside clearfix<?php echo $ttrust_header_class; ?>">
					
					<?php if($ttrust_header_text){ ?>
					<div class="header-text">
						<?php echo $ttrust_header_text; ?>
					</div>
					<?php } ?>
					
					<?php $logo_head_tag = ( is_front_page() ) ? "h1" : "h3";	?>
					<?php $ttrust_logo = get_theme_mod( 'beckett_logo' ); ?>
					<div id="logo">

					<?php if( $ttrust_logo ) { ?>

						<<?php echo $logo_head_tag; ?> class="logo"><a href="<?php bloginfo('url'); ?>"><img src="<?php echo $ttrust_logo; ?>" alt="<?php bloginfo('name'); ?>" /></a></<?php echo $logo_head_tag; ?>>

					<?php } else { ?>

						<<?php echo $logo_head_tag; ?>><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></<?php echo $logo_head_tag; ?>>

					<?php } ?>
					</div>					
					
					<div id="main-nav" class="">

						<?php wp_nav_menu( array(
							'container'			=> 'nav',
							'container_id'		=> 'main-menu',
							'menu_class' 		=> 'menu',
							'theme_location'	=> 'primary',
							'fallback_cb' 		=> 'main_nav'
						) ); ?>

					</div>
					<div id="menu-bg"></div>
					<!--<div class="menu-toggle the-menu-toggle" id="menu-toggle"><span></span></div>-->
				</div>			
			
	</div>
	<div class="middle clear">
		
	<?php //Slides
	if( is_front_page() ) {
		get_template_part( 'content-slides-home' ); 
	} // if() 
	?>