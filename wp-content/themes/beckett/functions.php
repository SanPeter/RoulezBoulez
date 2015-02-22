<?php
/**
 * 	Beckett by ThemeTrust © 2014
 *   =====================================================
 *	 1. 	Theme Setup
 *	 	1.1		Content Width
 *	 	1.2		Beckett_Setup
 *		1.3		Post Image Sizes
 *	 2. 	Header
 *	 	2.1		Beckett Scripts
 *		2.4		Customizer Head
 *	 3. Includes
 *		3.1		Template Tags
 *		3.2		Extra Functions
 *		3.3		Customizer Additions
 *		3.4		Jetpack Compatibility
 *		3.5		Widgets
 *	 4. Shortcodes
 *
 * @package beckett
 */

//////////////////////////////////////////////////////////////
// 1. Theme Setup
/////////////////////////////////////////////////////////////

//	1.1 Content Width
if ( ! isset( $content_width ) ) {
	$content_width = 1000; /* This will have to be overridden. */
}

//	1.2 Beckett_Setup
if ( ! function_exists( 'beckett_setup' ) ) :
	function beckett_setup() {

		// 1.2.1 Set Globals
		global $ttrust_config;

		$ttrust_config['theme'] 			= 'Beckett ';
		$ttrust_config['version']		= '1.0';

		// 1.2.2 Make theme available for translation.
		load_theme_textdomain( 'beckett', get_template_directory() . '/languages' );

		// 1.2.3 Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// 1.2.4 Add support for thumbnails
		add_theme_support( 'post-thumbnails' );

		// 1.2.5 This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Main Menu', 'beckett' ),
		) );

		// 1.2.6 Enable support for Post Formats (currently disabled).
		//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

		// 1.2.7 Load and instantiate the Portfolio CPT Class v1.0 -- Warning: WP<3.8 requires images/blue-folder-stand.png
		load_template( get_template_directory() . '/inc/class-portfolio-cpt.php', true );

		$portfolio_cpt = new Portfolio_CPT( 'beckett' ); // Sending in the textdomain
		$portfolio_cpt->project_init();
		$portfolio_cpt->skills_init();

		// 1.2.8 Load and instantiate the Testimonial CPT Class v1.0 -- Warning: WP<3.8 requires images/user-icon.png
		load_template( get_template_directory() . '/inc/class-testimonial-cpt.php', true );
		
		$testimonial_cpt = new Testimonial_CPT( 'beckett' ); // Sending in the textdomain
		$testimonial_cpt->testimonial_init();
		
		// 1.2.9 Load and instantiate the Slide CPT Class v1.0
		load_template( get_template_directory() . '/inc/class-slide-cpt.php', true );	
		
		$slide = new Slide_CPT( 'beckett' ); // Sending in the textdomain
		$slide->slide_init();	

		// 1.2.10 Enable Featured Content
		add_theme_support( 'featured-content', array(
		   'filter'     => 'beckett_get_featured_posts',
		   'max_posts'  => get_theme_mod( 'beckett_featured_pages_count' ),
		   'post_types' => array( 'post', 'page' ),
		) );

		// 1.2.11 Setup the WordPress Core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'beckett_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// 1.2.12 Enable support for HTML5 markup.
		add_theme_support( 'html5', array(
			'comment-list',
			'search-form',
			'comment-form',
			'gallery',
			'caption',
		) );

		// 1.2.13 Add Menus
		function mobile_nav() {
			echo '<ul>';
			wp_list_pages('sort_column=menu_order&title_li=');
			echo '</ul>';
		}

		function main_nav() {
			echo '<nav id="main-menu"><ul class="menu clearfix">';
			wp_list_pages('sort_column=menu_order&title_li=');
			echo '</ul></nav>';
		}


	} // beckett_setup()
endif; // if()

add_action( 'after_setup_theme', 'beckett_setup' );

// 1.3 Add Post Image Sizes & Video Tracker
add_image_size('beckett_post_thumb_small', 375, 190, true);
add_image_size( 'beckett_post_thumb', 800, 450, true );
add_image_size( 'beckett_post_thumb_big', 1000, 9999, true );
add_image_size( 'beckett_project_thumb', 800, 600, true );
add_image_size( 'beckett_full_width', 2000, 9999, true );

//////////////////////////////////////////////////////////////
// 2. Header
/////////////////////////////////////////////////////////////

// 2.1 Beckett Scripts
if ( ! function_exists( 'beckett_scripts_n_styles' ) ) {
	function beckett_scripts_n_styles() {

		global $wp_version;

		// 2.1.1  CSS
		wp_enqueue_style( 'beckett-style', get_stylesheet_uri(), false );	
		wp_enqueue_style( 'flexslider', get_bloginfo( 'template_url' ) . '/css/flexslider.css', false );	

		// 2.1.2  Fonts
		wp_enqueue_style( 'font-awesome', get_bloginfo( 'template_url' ) . '/css/font-awesome.min.css', false, '4.0.3', 'all' );
		wp_enqueue_style('lato-font', '//fonts.googleapis.com/css?family=Lato:400,700,900', false);		
		wp_enqueue_style( 'font-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:300,400,700,300italic,400italic,700italic', false );
		

		// 2.1.3  Scripts
		wp_enqueue_script( 'beckett-jquery-ui', '//code.jquery.com/ui/1.10.4/jquery-ui.min.js', array( 'jquery' ), '1.10.4', true );
		wp_enqueue_script( 'beckett-jquery-actual', get_bloginfo( 'template_url' ).'/js/jquery.actual.js', array( 'jquery' ), '1.0.16', true );
		wp_enqueue_script( 'beckett-flexslider', get_bloginfo( 'template_url' ).'/js/jquery.flexslider-min.js', array( 'jquery' ), '2.2.2', true);

		// Others
		wp_enqueue_script( 'beckett-scrollto', get_bloginfo( 'template_url' ) . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.6', true );
		wp_enqueue_script( 'beckett-isotope', get_bloginfo( 'template_url' ) . '/js/jquery.isotope.js', array( 'jquery' ), '1.3.110525', true );
		wp_enqueue_script( 'beckett-fitvids', get_bloginfo( 'template_url' ) . '/js/jquery.fitvids.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'beckett-theme_trust_js', get_bloginfo( 'template_url' ) . '/js/theme_trust.js', array( 'jquery' ), '1.0', true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		if( is_active_widget( false, '', 'ttrust_flickr' ) ) {
	    	wp_enqueue_script( 'flickrfeed', get_bloginfo( 'template_url' ) . '/js/jflickrfeed.js', array( 'jquery' ), '0.8', true);
		}

	}

} // if()

add_action( 'wp_enqueue_scripts', 'beckett_scripts_n_styles' );


//	2.3 Customizer Head
if ( ! function_exists( 'beckett_theme_head' ) ) {
	function beckett_theme_head() { ?>
		<?php if (get_theme_mod('beckett_favicon') ) : ?>
			<link rel="shortcut icon" href="<?php echo get_theme_mod('beckett_favicon'); ?>" />
		<?php endif; ?>
		<meta name="generator" content="<?php global $ttrust_config; echo $ttrust_config['theme'] . ' ' . $ttrust_config['version']; ?>" />

		<!--[if IE 8]>
		<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/css/ie8.css" type="text/css" media="screen" />
		<![endif]-->
		<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

		<?php

		$color = array();

		$color['text'] 			    = get_theme_mod( 'beckett_text_color' );
		$color['accent'] 		    = get_theme_mod( 'beckett_accent_color' );
		$color['header'] 		    = get_theme_mod( 'beckett_header_color' );
		$color['menu'] 			    = get_theme_mod( 'beckett_menu_color' );
		$color['menu_hover'] 	    = get_theme_mod( 'beckett_menu_hover_color' );
		$color['menu_background'] 	= get_theme_mod( 'beckett_menu_background_color' );
		$color['header'] 		    = get_theme_mod( 'beckett_header_color' );
		$color['link'] 			    = get_theme_mod( 'beckett_link_color' );
		$color['link_hover'] 	    = get_theme_mod( 'beckett_link_hover_color' );

		// Colors
		if( $color ){ ?>

		<style>

			<?php // Accent Color
			if( $color['accent'] ) { ?>
			.pull, blockquote { border-color: <?php echo $color['accent']; ?>; }
			.home .post.small:hover .overlay { background-color: <?php echo $color['accent']; ?>; }
			.widget_ttrust_service i { color: <?php echo $color['accent']; ?>; }
			.project.small .overlay span { background-color: <?php echo $color['accent']; ?>; }
			<?php } ?>

			<?php // Header Color
			if( $color['header'] ) { ?>
			.site-header.solid, .site-header, body.has-slideshow .site-header.solid { background: <?php echo $color['header']; ?>; }
			<?php } ?>

			<?php // Menu Color
			if( $color['menu'] ) { ?>
			#main-nav ul a, .site-header #main-nav ul ul li a { color: <?php echo $color['menu']; ?>; }
			<?php } ?>

			<?php // Menu Hover Color
			if( $color['menu_hover'] ) { ?>
			#main-nav ul li a:hover, .site-header #main-nav ul ul li a:hover { color: <?php echo $color['menu_hover']; ?>; }
			#main-menu li a:hover { border-bottom: 3px solid <?php echo $color['menu_hover']; ?>; }
			<?php } ?>
			
			<?php // Menu Background Color
			if( $color['menu_background'] ) { ?>
			#menu-bg { background: <?php echo $color['menu_background']; ?>; }
			<?php } ?>

			<?php // Link Color
			if( $color['link'] ) { ?>
			a, a:visited { color: <?php echo $color['link']; ?>; }
			<?php } ?>

			<?php // Link Color Hover
			if( $color['link_hover'] ) { ?>
			a:hover { color: <?php echo $color['link_hover']; ?>; }
			<?php } ?>

			<?php if (get_theme_mod('beckett_custom_css') ) {
			echo get_theme_mod('beckett_custom_css');
			} ?>

		</style>

		<?php } // if($color)

	} // beckett_theme_head()
} // if()

add_action( 'wp_head','beckett_theme_head' );


//////////////////////////////////////////////////////////////
// 3. Includes
/////////////////////////////////////////////////////////////

//	3.1 Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

//	3.2 Custom functions that act independently of the theme templates.
require get_template_directory() . '/inc/extras.php';

//	3.3 Customizer additions.
require get_template_directory() . '/inc/customizer.php';

//	3.4 Load Jetpack compatibility file.
require get_template_directory() . '/inc/jetpack.php';

//	3.5 Widgets
require get_template_directory() . '/inc/widgets.php';


//////////////////////////////////////////////////////////////
// 4. Shortcodes
/////////////////////////////////////////////////////////////

// 4.1 Pull-Quote Shortcode
if(! function_exists( 'beckett_pullquotes' ) ) {
	function beckett_pullquotes( $atts, $content = null ) {

		extract(shortcode_atts(array(
			'side' => 'right',
		), $atts));

		if( $side != 'right' || $side != 'left' ) {

			return false;

		} else {

			return "<span class='pull pull$side'>" . do_shortcode( $content ) . "</span>";

		}

	}

	add_shortcode('pullquote', 'beckett_pullquotes');

}