<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package beckett
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function beckett_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'beckett_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function beckett_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	//	Add Browser to Body Class
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

    if($is_lynx) $classes[] = 'lynx';
    elseif($is_gecko) $classes[] = 'gecko';
    elseif($is_opera) $classes[] = 'opera';
    elseif($is_NS4) $classes[] = 'ns4';
    elseif($is_safari) $classes[] = 'safari';
    elseif($is_chrome) $classes[] = 'chrome';
    elseif($is_IE) $classes[] = 'ie';
    else $classes[] = 'unknown';
    if($is_iphone) $classes[] = 'iphone';    

	if(beckett_has_slideshow()){		
		$classes[] = 'has-slideshow';
	}
	
	return $classes;
}

add_filter( 'body_class', 'beckett_body_classes' );


/**
 * Checks if there are any home page slides.
 *
 * @return string id
 */
function beckett_has_slideshow() {
	$args = array(
		'ignore_sticky_posts' => 1,
		'posts_per_page' => 1,
		'post_type' => 'slide'
	);
	$slides = new WP_Query( $args );
    
    if($slides->post_count > 0){
		return true;
	}
}


/**
 * Gets the id of the page using the portfolio page template.
 *
 * @return string id
 */
function beckett_get_portfolio_id() {
    $portfolio_ID = "";
	$pages = get_pages(array(
        'meta_key'      =>  '_wp_page_template',
        'meta_value'    =>  'page-portfolio.php',
        'hierarchical'  =>  0,
        'post-type'     =>  'page',
        'number'        =>  1
    ));
    foreach($pages as $page){
        $portfolio_ID = $page->ID;
    }
    return $portfolio_ID;
}

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function beckett_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'beckett' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'beckett_wp_title', 10, 2 );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function beckett_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'beckett_setup_author' );


/**
 * Add tags to pages.
 */
function add_tags_to_pages() {  
	// Add tag metabox to page
	register_taxonomy_for_object_type('post_tag', 'page'); 
}
 // Add to the admin_init hook of your theme functions.php file 
add_action( 'init', 'add_tags_to_pages' );
