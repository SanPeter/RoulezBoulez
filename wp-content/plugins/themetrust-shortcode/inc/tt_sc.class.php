<?php

/**
 * Shortcode Class for Theme Trust Shortcode Plugin
 *
 * @package tt-shortcode
 * @author ThemeTrust, Inc. - Rob Ward
 * @license http://opensource.org/licenses/MIT MIT license
 * @version Release @package_version@
 * @since v1.0
 */
if ( ! class_exists( 'TT_Sc' ) ) {
    class TT_Sc {

		// Class Variables

		/* @var $localizationDomain string for translation domain */
        private $localizationDomain 	= 'themetrust';
		/* @var $thispluginurl string for the URL of the plugin (set in constructor) */
        private $thispluginurl 			= '';
        /* @var $thispluginpath string for the path of the plugin (set in constructor) */
        private $thispluginpath 		= '';
	    /* @var $tt_shortcodes array of shortcodes being used (set in constructor) */
	    public $tt_shortcodes           = array();

	    /**
	     * Constructor function to grab text domain and register with hooks
	     */
		public function __construct( $thispluginurl ){

	        /* @var global $tt_sc_config[] */
			global $tt_sc_config;

			$this->thispluginurl  = $thispluginurl;
			$this->thispluginpath = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/';
			$this->tt_shortcodes  = array(
				'button',
				'one_third', 'one_third_last',
				'two_third', 'two_third_last',
				'one_half', 'one_half_last',
				'one_fourth', 'one_fourth_last',
				'three_fourth', 'three_fourth_last',
				'slideshow',
				'tab_group', 'tab',
				'toggle_group', 'toggle'
			);

			// Register and Unregister Shortcodes
			$this->tt_sc_register_and_unregister_shortcodes();

			// Actions
			add_action( 'init',                 array( &$this, 'tt_sc_register_and_unregister_shortcodes' ) );
			add_action( 'wp_enqueue_scripts',   array( &$this, 'tt_sc_dependencies' ), 0 );
			add_action( 'wp_footer',            array( &$this, 'tt_sc_footer_scripts' ) );
			// TinyMCE
			add_action( 'admin_head',            array( &$this, 'tt_sc_mce_button' ) );
			add_action( 'admin_enqueue_scripts', array( &$this, 'tt_sc_admin_css' ) );

		} // __construct

		// -- Class Functions

		/**
		 * Handle shortcode registration automatically using the array of shortcodes within the function
		 *
		 * @since 1.1
		 */
		function tt_sc_register_and_unregister_shortcodes(){

			$tt_shortcodes = $this->tt_shortcodes;

			// Loop through the array, unregistering where they already exist. Functions have to be named strictly according to convention for this to pan out
			foreach( $tt_shortcodes as $tt_shortcode ) {

				$tt_shortfunction = "tt_sc_" . $tt_shortcode;

				if( shortcode_exists( $tt_shortcode ) ){

					remove_shortcode( $tt_shortcode );

				} // if

				add_shortcode( $tt_shortcode, array( &$this, $tt_shortfunction ) );

		 	} // foreach

		} // tt_sc_register_and_unregister_shortcodes

	    /**
	     * Check on the existence of necessary scripts and styles and include if not registered/enqueued.
	     *
	     * @since 1.1
	     */
		function tt_sc_dependencies() {

			if ( ! wp_script_is( 'slideshow', 'enqueued' ) ) {

				// Register and enqueue script
				wp_register_script( 'tt_sc_flexslider.js', $this->thispluginurl . 'js/jquery.flexslider.js', array('jquery'), '1.8', true );
				wp_enqueue_script( 'tt_sc_flexslider.js' );

				// Register and enqueue style
				wp_register_style( 'tt_sc_flexslider', $this->thispluginurl . 'css/flexslider.css', false, '1.8', 'all' );
				wp_enqueue_style( 'tt_sc_flexslider' );

			} // if

			wp_register_script( 'tt_sc_bootstrap', $this->thispluginurl . 'js/bootstrap.min.js', array('jquery'), '1.8', true );
			wp_enqueue_script( 'tt_sc_bootstrap' );

			wp_register_style( 'tt_sc_style', $this->thispluginurl . 'css/tt_shortcode.css' );
			wp_enqueue_style( 'tt_sc_style' );

		} // tt_sc_dependencies

	    /**
	     * Add a custom dropdown button to the tinyMCE editor
	     *
	     * @since 1.2
	     */
	    function tt_sc_mce_button(){

		    $current_screen = get_current_screen();
		    $current_post_type = $current_screen->post_type;

		    if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) )
			    return;

		    if( ! in_array( $current_post_type, array( 'post', 'page', 'project', 'slide', 'jetpack-portfolio' ) ) )
			    return;


		    if ( 'true' == get_user_option( 'rich_editing' ) ) {

			    add_filter( 'mce_external_plugins',  array( &$this, 'tt_sc_register_tinymce_javascript' ) );
			    add_filter( 'mce_buttons',           array( &$this, 'tt_sc_register_button' ) );

		    } // if

	    } //tt_sc_mce_button

	    /**
	     * Register the tinyMCE script
	     *
	     * @param $plugin_array
	     *
	     * @return $plugin_array
	     * @since 1.2
	     */
	    function tt_sc_register_tinymce_javascript( $plugin_array ){

		    $plugin_array['tt_sc_button'] = $this->thispluginurl . '/js/tt_sc_tinymce.js';

		    return $plugin_array;

	    } // tt_sc_register_tinymce_javascript

	    /**
	     * Adds buttons for all the styles into TinyMCE
	     *
	     * @return array $buttons
	     * @since 1.2
	     */
	    function tt_sc_register_button( $buttons ){

		    array_push( $buttons, 'tt_sc_button' );

		    return $buttons;

	    } // tt_sc_register_button

	    /**
	     * Enqueue admin CSS for TinyMCE shortcode button
	     */
	    function tt_sc_admin_css(){

		    wp_enqueue_style( 'tt_sc_admin_css', $this->thispluginurl . '/css/tt_sc_admin.css' );

	    } // tt_sc_admin_css

	    /**
	     * Button Shortcode
	     *
	     * @param $atts             Shortcode attributes
	     *
	     * @return string $output   Button html
	     */
		function tt_sc_button( $atts ) {

			extract( shortcode_atts(array(

				'label'		=> 'Button Text',
				'id' 		=> '1',
				'url'		=> '',
				'target'	=> '_parent',
				'size'		=> '',
				'color'		=> '',
				'ptag'		=> false

			), $atts ));

			//
			$link = $url ? $url : get_permalink($id);
			$s = "";

			$output = '<div class="tt_sc">' . "\n";

			if( $color )
				$s .= "background-color:" . $color . ";";

			if( $ptag )
				$output .=  wpautop( '<a href="' . $link . '" target="' . $target . '" style="' . $s . '" class=button ' . $size . '">' . $label . '</a>' );
			else
				$output .= '<a href="' . $link . '" target="' . $target . '" style="' . $s . '" class="button ' . $size . '">' . $label . '</a>';

			$output .= '</div><!--tt_sc -->';

			return $output;

		} // tt_sc_button

	    /**
	     * Slideshow Shortcode
	     *
	     * @param string $atts      Options
	     * @param string $content   Images to appear in slideshow
	     *
	     * @return string $output   Slideshow html
	     */
		function tt_sc_slideshow( $atts, $content = null ) {

		    $content = str_replace( '<br />', '', $content );
			$content = str_replace( '<img', '<li><img', $content );
			$content = str_replace( '/>', '/></li>', $content );

			$output = '<div class="tt_sc">' . "\n";
			$output .= '<div class="flexslider clearfix primary normal"><ul class="slides">' . $content . '</ul></div>';
			$output .= '</div><!--tt_sc -->';

			return $output;

		 } // tt_sc_slideshow

		// -- Column Shortcodes

	    /**
	     * One-third column shortcode
	     *
	     * @param string $content   Content in the columns
	     *
	     * @return string $output   Column html
	     * @since 1.0
	     */
		function tt_sc_one_third( $atts, $content = null ) {

			$output = '<div class="tt_sc">' . "\n";
			$output .= '<div class="one_third column">';
			$output .= do_shortcode( $content );
			$output .= '</div>';
			$output .= '</div><!--tt_sc -->';

			return $output;

		} // tt_sc_one_third

	    /**
	     * One-third last column shortcode
	     *
	     * @param string $content   Content in the columns
	     *
	     * @return string $output   Column html
	     * @since 1.0
	     */
		function tt_sc_one_third_last( $atts, $content = null ) {

			$output = '<div class="tt_sc">' . "\n";
			$output .=  '<div class="one_third column last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
			$output .= '</div><!--tt_sc -->';

			return $output;

		} // tt_sc_one_third_last

	    /**
	     * Two-thirds column shortcode
	     *
	     * @param string $content   Content in the columns
	     *
	     * @return string $output   Column html
	     * @since 1.0
	     */
		function tt_sc_two_third( $atts, $content = null ) {

			$output = '<div class="tt_sc">' . "\n";
			$output .= '<div class="two_third column">' . do_shortcode( $content ) . '</div>';
			$output .= '</div><!--tt_sc -->';

			return $output;

		} // tt_sc_two_third

	    /**
	     * Two-thirds last column shortcode
	     *
	     * @param string $content   Content in the columns
	     *
	     * @return string $output   Column html
	     * @since 1.0
	     */
		function tt_sc_two_third_last( $atts, $content = null ) {

			$output = '<div class="tt_sc">' . "\n";
			$output .= '<div class="two_third column last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
			$output .= '</div><!--tt_sc -->';

			return $output;

		} // tt_sc_two_third_last

	    /**
	     * One-half column shortcode
	     *
	     * @param string $content   Content in the columns
	     *
	     * @return string $output   Column html
	     * @since 1.0
	     */
		function tt_sc_one_half( $atts, $content = null ) {

			$output = '<div class="tt_sc">' . "\n";
			$output .= '<div class="one_half column">' . do_shortcode( $content ) . '</div>';
			$output .= '</div><!--tt_sc -->';

			return $output;

		} // tt_sc_one_half

	    /**
	     * One-half last column shortcode
	     *
	     * @param string $content   Content in the columns
	     *
	     * @return string $output   Column html
	     * @since 1.0
	     */
		function tt_sc_one_half_last( $atts, $content = null ) {

			$output = '<div class="tt_sc">' . "\n";
			$output .= '<div class="one_half column last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
			$output .= '</div><!--tt_sc -->';

			return $output;

		} // tt_sc_one_half_last

	    /**
	     * One-fourth column shortcode
	     *
	     * @param string $content   Content in the columns
	     *
	     * @return string $output   Column html
	     * @since 1.0
	     */
		function tt_sc_one_fourth( $atts, $content = null ) {

			$output = '<div class="tt_sc">' . "\n";
			$output .= '<div class="one_fourth column">' . do_shortcode( $content ) . '</div>';
			$output .= '</div><!--tt_sc -->';

			return $output;

		} // tt_sc_one_fourth

	    /**
	     * One-fourth last column shortcode
	     *
	     * @param string $content   Content in the columns
	     *
	     * @return string $output   Column html
	     * @since 1.0
	     */
		function tt_sc_one_fourth_last( $atts, $content = null ) {

			$output = '<div class="tt_sc">' . "\n";
			$output .= '<div class="one_fourth column last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
			$output .= '</div><!--tt_sc -->';

			return $output;

		} // tt_sc_one_fourth_last


	    /**
	     * Three-fourths column shortcode
	     *
	     * @param string $content   Content in the columns
	     *
	     * @return string $output   Column html
	     * @since 1.0
	     */
		function tt_sc_three_fourth( $atts, $content = null ) {

			$output = '<div class="tt_sc">' . "\n";
			$output .= '<div class="three_fourth column">' . do_shortcode( $content ) . '</div>';
			$output .= '</div><!--tt_sc -->';

			return $output;

		} // tt_sc_three_fourth

	    /**
	     * Three-fourths last column shortcode
	     *
	     * @param string $content   Content in the columns
	     *
	     * @return string $output   Column html
	     * @since 1.0
	     */
		function tt_sc_three_fourth_last( $atts, $content = null ) {

			$output = '<div class="tt_sc">' . "\n";
			$output .= '<div class="three_fourth column last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
			$output .= '<div class="three_fourth column last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
			$output .= '</div><!--tt_sc -->';

			return $output;

		} // tt_sc_three_fourth_last

	    /**
	     * Create a global array to store tab attributes, used in the tab group function below.
	     *
	     * Usage:
	     * [tab_group nav="tabs" style="framed" background="#eee" color="#333"] -Colors only for pills
	     * [tab title="Tab 1"] Tab content. [/tab]
	     * [tab title="Tab n"] Tab content. [/tab]
	     * [/tab_group]
	     *
	     * Use a global var to store the tabs array, including title,
	     * tab content (put later into $tab_contents[]) and a unique ID to target
	     * the correct pane
	     *
	     * @param string $atts      Title of tabs
	     * @param string $content   Content in the tabs
	     *
	     * @since 1.1
	     */
		function tt_sc_tab( $atts, $content ){

			extract( shortcode_atts( array(
				'title' => 'Tab %d'
			), $atts ) );

			$x = $GLOBALS['tt_sc_tab_count'];
			$GLOBALS['tt_sc_tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tt_sc_tab_count'] ), 'content' =>  $content, 'id' => uniqid( rand(), false  ) );

			$GLOBALS['tt_sc_tab_count']++;

		} // tt_sc_tab

	    /**
	     * Create the tab group and tabs using the global defined above
	     *
	     * @param string $atts      Tabs, nav or pilled, framed or unframed
	     * @param string $content   Content in the tabs
	     *
	     * @return string $output   Tabs html
	     * @since 1.1
	     */
		function tt_sc_tab_group( $atts, $content ) {

			extract( shortcode_atts( array(
				 // Option to use tabs or pills and open or closed framing
				'nav' 	     => 'tabs',
				'style'      => 'framed',
			), $atts ) );

			$GLOBALS['tt_sc_tab_count'] = 0;

			do_shortcode( $content );

			if( is_array( $GLOBALS['tt_sc_tabs'] ) ) {

				// Create arrays for the foreach loop to contain the tab selectors and contents. We will pull this apart outside of the loop using implode()

				$i = 0;

				foreach( $GLOBALS['tt_sc_tabs'] as $tab ){

					if($i == 0){

						$class = "active";

					} else {

						$class = "";

					} // if

					$tabs[] = "\n" . '<li class="' . $class . '"><a href="#tabs-' . $tab['id'] . '" data-toggle="tab" title="' . $tab['title'] . '">' . $tab['title'] . '</a></li>';
					$tab_contents[] = "\n" . '<div class="tab-pane ' . $class . '" id="tabs-' . $tab['id'] . '">' . $tab['content'] . '</div>';
					$i++;

				} // foreach

				$output = '<div class="tt_sc">' . "\n";
				$output .= '<ul class="nav nav-' . $nav . '">' . implode( "\n", $tabs ) . '</ul>' . "\n\t\t" . "\n" . '<div class="tab-content ' . $style . ' ' . $nav . '">' . implode( "\n", $tab_contents ) . '</div>' . "\n";
				$output .= '</div><!--tt_sc -->';

			} // if

			return $output;

		} // tt_sc_tab_group

	    /**
	     * Create the tab group and tabs using the global defined above
	     *
	     * Usage:
	     * [toggle_group type="accordion"] (NOTE: undefined type defaults to normal toggle behavior)
	     * [toggle title="Toggle 1"] Toggle content. [/toggle]
	     * [toggle title="Toggle 1"] Toggle content. [/toggle]
	     * [/toggle_group]
	     *
	     * @param string $atts      Tabs, nav or pilled, framed or unframed
	     * @param string $content   Content in the tabs
	     *
	     * @return string $output   Tabs html
	     * @since 1.1
	     */
		function tt_sc_toggle( $atts, $content ){

			extract( shortcode_atts( array(
				'title' => 'Toggle %d'
			), $atts ) );

			$x = $GLOBALS['toggle_count'];
			$GLOBALS['toggles'][$x] = array( 'title' => sprintf( $title, $GLOBALS['toggle_count'] ), 'content' =>  $content, 'id' => uniqid( rand(), false ) );

			$GLOBALS['toggle_count']++;

		} // tt_sc_toggle()

	    /**
	     * Create the toggle group and toggles using the global defined above
	     *
	     * @param string $atts      Toggles, panel or accordion, framed or unframed
	     * @param string $content   Content in the toggles
	     *
	     * @return string $output   Toggles html
	     * @since 1.1
	     */
		function tt_sc_toggle_group( $atts, $content ){

			extract( shortcode_atts( array(
				'type'  => 'panel',
				'style' => 'framed'
			), $atts ) );

			$GLOBALS['toggle_count'] = 0;

			do_shortcode( $content );

			$output = '<div class="tt_sc">' . "\n";

			if( is_array( $GLOBALS['toggles'] ) ){

				$panel_id = uniqid( rand(), false );

				if( $type == "accordion" ){

					$output .= "\t" . '<div class="' . $type . '" id="' . $type . '-' . $panel_id . '">' . "\n";
					$i = 0;

					foreach( $GLOBALS['toggles'] as $toggle ) {

						if( $i == 0 ){

							$class = " in";

						} else {

							$class = "";

						} // if

						// Tons'o' tabs in here to make this readable
						$output .= "\t\t" . '<div class="' . $type . '-group">' . "\n";
			            $output .= "\t\t\t" . '<div class="' . $type . '-heading">' . "\n";
						$output .= "\t\t\t\t" . '<h4 class="' . $type . '-title">' . "\n";
						$output .= "\t\t\t\t\t" . '<a href="#toggle-' . $toggle['id'] . '" data-toggle="collapse" data-parent="#' . $type . '-' . $panel_id . '">' . $toggle['title'] . '</a>' . "\n";
						$output .= "\t\t\t\t" . '</h4>' . "\n";
						$output .= "\t\t\t" . '</div>' . "\n";

						$output .= "\t\t\t" . '<div id="toggle-' . $toggle['id'] . '" class="' . $type . '-body collapse' . $class . '">' . "\n";
						$output .= "\t\t\t\t" . '<div class="' . $type . '-inner">' . $toggle['content'] . '</div>' . "\n";
						$output .= "\t\t\t" . '</div>' . "\n";
						$output .= "\t\t" . '</div>' . "\n";

		 				$i++;

					} // foreach

					$output .= "\t" . '</div><!-- accordion -->' . "\n";

				} else {

					/* Because toggles appear in a different order from the tabs, we are going to use the foreach to accomplish more here.
					*  This first requires laying out the toggle group master div. This div decides whether it is a normal toggle or an accordion.
					*/

					$output .= "\t" . '<div class="' . $type . '-group" id="' . $type . '2">' . "\n";
					$i = 0;
					foreach( $GLOBALS['toggles'] as $toggle ) {

						if($i == 0){

							$class = " in";

						} else {

							$class = "";

						} // if

						$output .= "\t\t" . '<div class="' . $type . ' ' . $type . '-default">' . "\n";
						$output .= "\t\t\t" . '<div class="' . $type . '-heading">' . "\n";
						$output .= "\t\t\t\t" . '<h4 class="' . $type . '-title">' . "\n";
						$output .= "\t\t\t\t\t" . '<a href="#toggle-' . $toggle['id'] . '" data-toggle="collapse" data-parent="#' . $type . '">' . $toggle['title'] . '</a>' . "\n";
						$output .= "\t\t\t\t" . '</h4>' . "\n";
						$output .= "\t\t\t" . '</div>' . "\n";

						$output .= "\t\t\t" . '<div id="toggle-' . $toggle['id'] . '" class="' . $type . '-collapse collapse' . $class . '">' . "\n";
						$output .= "\t\t\t\t" . '<div class="' . $type . '-body">' . $toggle['content'] . '</div>' . "\n";
						$output .= "\t\t\t" . '</div>' . "\n";
						$output .= "\t\t" . '</div>' . "\n";

						$i++;


					} // foreach

					$output .= "\t" . '</div>' . "\n";

				} // if

				$output .= '</div><!--tt_sc -->' . "\n";

			} // if

			return $output;

		} // tt_sc_toggle_group()

	    /**
	     * Put tab activation JS in the footer
	     *
	     * @since 1.1
	     */
	    function tt_sc_footer_scripts(){

		    $script = "
				<script type='text/javascript'>
					 jQuery(document).ready(function ($) {

					if(jQuery('#tabs').length > 0 ) {
						$('#tabs').tab();
					}
					if(jQuery('#accordion').length > 0 ) {
						$('#accordion').collapse({
						  toggle: true,
						  hide: true
						});
					}
				});
				</script>";

		    echo $script;

	    } // tt_sc_footer_scripts

    } // End Class
} // End if()
?>