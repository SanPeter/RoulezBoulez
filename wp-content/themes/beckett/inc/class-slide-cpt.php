<?php

// ThemeTrust Slide CPT Class v1.0 //

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Slide_CPT {

	protected $textdomain;
	protected $posts;
	protected $version;

	public function __construct( $textdomain )	{
		// Initialize variables
		global $wp_version;
		$this->version		= $wp_version;
		$this->textdomain	= $textdomain;
		$this->posts		= array();


		// Add the action hooks
		add_action( 'init', array( &$this, 'register_Slides' ) );	// Register Associated Taxonomy

		if( $this->version >= 3.8 ) {
			add_action( 'admin_head', array( &$this, 'add_menu_icons_styles' ) ); // Add icon if WP =< 3.8
		}

		add_action( 'after_switch_theme', array( &$this, 'custom_flush_rules' ) );		// Flush rewrite rules
	}

	public function Slide_init() {

		// Define the settings
		$settings = array(
			'labels' 		=> array(
				'name' 					=> __( 'Slides', $this->textdomain),
				'menu_name' 			=> __( 'Slides', $this->textdomain),
				'singular_name' 		=> __( 'Slide', $this->textdomain),
				'all_items' 			=> __( 'All Slides', $this->textdomain),
		        'add_new' 				=> __( 'Add New', $this->textdomain ),
				'add_new_item' 			=> __( 'Add New Slide', $this->textdomain ),
				'edit_item' 			=> __( 'Edit Slide', $this->textdomain ),
				'new_item' 				=> __( 'New Slide', $this->textdomain ),
				'view_item' 			=> __( 'View Slide', $this->textdomain ),
				'search_items' 			=> __( 'Search Slides', $this->textdomain ),
				'not_found' 			=> __( 'No Slides found', $this->textdomain ),
				'not_found_in_trash'	=> __( 'No Slides found in Trash', $this->textdomain )
			),
			'public' 				=> true,
			'publicly_queryable' 	=> true,
			'show_ui' 				=> true,
			'show_in_menu' 			=> true,
			'show_in_nav_menus' 	=> false,
			'menu_position ' 		=> null,
			'menu_icon' 			=> get_template_directory_uri(). '/images/image-empty.png',
			'supports' 				=> array( 'title', 'editor', 'thumbnail', 'revisions' ),
			'hierarchical' 			=> false,
			'has_archive' 			=> true,
			'rewrite'				=> array(
				'slug' => 'Slide'
			)
		); // End $settings

		// Conditional to set the icon if WP 3.8 <
		if( $this->version >= 3.8 ) {

			$settings['menu_icon'] = '';

		}

		// Store the settings in the post array
		$this->posts['Slide'] = $settings;

	}

	public function register_Slides() {
		// Loop through the registered posts
		// and register all posts stored in the array
		foreach( $this->posts as $key=>$value ) {
			register_post_type( $key, $value );
		}
	}

	public function add_menu_icons_styles() {
	?>

		<style>
			#adminmenu .menu-icon-slide div.wp-menu-image:before { content: '\f161'; }
		</style>

	<?php
	}

	// Flush Rules
	public function custom_flush_rules(){

		//defines the post type so the rules can be flushed.
		$this->register_Slides();

		//and flush the rules.
		flush_rewrite_rules();
	}

} // End Slide_CPT
?>