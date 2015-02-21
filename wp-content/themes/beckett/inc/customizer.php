<?php
/**
 * beckett Theme Customizer
 *
 * @package beckett
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function beckett_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	//Remove unwanted
	$wp_customize->remove_control('background_color');

	// -- Custom Controllers

	// Project Dropdown
	require_once( 'class-customizer-post-dropdown.php' );

	// Header, Text Area
	require_once( 'classes-customizer.php' );

	// -- Sanitization Callbacks

	// Boolean
	function beckett_sanitize_checkbox( $input ) {
	    if ( $input == 1 ) {
	        return 1;
	    } else {
	        return '';
	    }
	}

	// Numeric
	function beckett_sanitize_number( $input ) {
		if ( is_numeric( $input ) ) {
			return $input;
		} else {
			return '20';
		}
	}
	
	//Text Area Control
	class TTrust_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() {
			?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
			<?php
		}
	}

	// Logo
	$wp_customize->add_setting( 'beckett_logo' , array(
	    'default'   		=> '',
	    'type'				=> 'theme_mod',
	    'transport'			=> 'refresh',
	    'sanitize_callback'	=> 'esc_url_raw'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
		'label'      => __('Logo', 'beckett'),
		'section'    => 'title_tagline',
		'settings'   => 'beckett_logo',
	    'priority'   => 11
	) ) );
	
	$wp_customize->add_setting( 'beckett_favicon' , array(
	    'default'   		=> '',
	    'type'				=> 'theme_mod',
	    'transport'			=> 'refresh',
	    'sanitize_callback'	=> 'esc_url_raw'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'favicon', array(
		'label'      => __('Favicon', 'beckett'),
		'section'    => 'title_tagline',
		'settings'   => 'beckett_favicon',
	    'priority'   => 12
	) ) );
	
	$wp_customize->add_setting( 'beckett_header_text' , array(
	    'default'     => __('', 'beckett'),
	    'type' => 'theme_mod',
	    'transport' => 'refresh',
	    'sanitize_callback'	 => 'wp_kses_post'
	) );

	$wp_customize->add_control( new TTrust_Textarea_Control( $wp_customize, 'beckett_header_text', array(
		'label'        => __('Header Text', 'beckett'),
		'section'    => 'title_tagline',
		'settings'   => 'beckett_header_text',
		'priority'   => 13
	) ) );
	
	// -- Homepage Panel
	$wp_customize->add_panel( 'beckett_home', array(
		'priority'		 => 3,
	    'title'     	 => __( 'Homepage', 'beckett' ),
	    'description'	 => __('Use the following settings to customize the appearance of your Beckett homepage.', 'beckett'),
	) );

	$wp_customize->add_section( 'beckett_home' , array(
	    'title'     	=> __( 'Homepage', 'beckett' ),
	    'description'	=> __('Use the following settings to customize the appearance of your beckett homepage.', 'beckett'),
	    'priority'   	=> 3,
	) );
	
	// Portfolio Section --------------------------------------------------------------
	$wp_customize->add_section( 'beckett_portfolio' , array(
	    'title'     	=> __( 'Portfolio', 'beckett' ),
	    'priority'   	=> 1,
	    'panel'			=> 'beckett_home'
	) );

	// Home Projects Title
	$wp_customize->add_setting( 'beckett_recent_projects_title' , array(
	    'default'     		=> __( 'Recent Projects', 'beckett' ),
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );

	$wp_customize->add_control( 'beckett_recent_projects_title', array(
		'label'      => __( 'Recent Projects Title', 'beckett' ),
		'section'    => 'beckett_portfolio',
		'settings'   => 'beckett_recent_projects_title',
		'priority'   => 37
	) );
	
	// Recent Project Summary
	$wp_customize->add_setting( 'beckett_recent_projects_summary' , array(
	    'default'     => __('', 'beckett'),
	    'type' => 'theme_mod',
	    'transport' => 'refresh',
	    'sanitize_callback'	 => 'wp_kses_post'
	) );

	$wp_customize->add_control( new TTrust_Textarea_Control( $wp_customize, 'beckett_recent_projects_summary', array(
		'label'        => __('Recent Projects Summary', 'beckett'),
		'section'    => 'beckett_portfolio',
		'settings'   => 'beckett_recent_projects_summary',
		'priority'   => 38
	) ) );

	// Number of Recent Projects to Show
	$wp_customize->add_setting( 'beckett_recent_projects_count' , array(
	    'default'			=> '3',
	    'type'				=> 'theme_mod',
	    'transport'			=> 'refresh',
	    'sanitize_callback'	=> 'beckett_sanitize_number'
	) );

	$wp_customize->add_control( 'beckett_recent_projects_count', array(
		'label'		=> __( 'Number of Recent Projects to Show', 'beckett' ),
		'section'	=> 'beckett_portfolio',
		'settings'	=> 'beckett_recent_projects_count',
		'type'		=> 'select',
	    'choices'	=> array(
			'0' => '0',
	        '3' => '3',
	        '6' => '6',
	        '9' => '9',
	        ),
		'priority'	=> 40
	) );
	
	// Recent Posts Section ----------------------------------------------------------
	$wp_customize->add_section( 'beckett_recent_posts' , array(
	    'title'     	=> __( 'Recent Posts', 'beckett' ),
	    'priority'   	=> 2,
	    'panel'			=> 'beckett_home'
	) );

	// Recent Posts Title
	$wp_customize->add_setting( 'beckett_recent_posts_title' , array(
	    'default'			=> __( 'From the Blog', 'beckett' ),
	    'type'				=> 'theme_mod',
	    'transport'			=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );

	$wp_customize->add_control( 'beckett_recent_posts_title', array(
		'label'		=> __( 'Recent Posts Title', 'beckett' ),
		'section'	=> 'beckett_recent_posts',
		'settings'	=> 'beckett_recent_posts_title',
		'priority'	=> 44
	) );
	
	// Recent Posts Summary
	$wp_customize->add_setting( 'beckett_recent_posts_summary' , array(
	    'default'     => __('', 'beckett'),
	    'type' => 'theme_mod',
	    'transport' => 'refresh',
	    'sanitize_callback'	 => 'wp_kses_post'
	) );

	$wp_customize->add_control( new TTrust_Textarea_Control( $wp_customize, 'beckett_recent_posts_summary', array(
		'label'        => __('Recent Posts Summary', 'beckett'),
		'section'    => 'beckett_recent_posts',
		'settings'   => 'beckett_recent_posts_summary',
		'priority'   => 45
	) ) );
	
	// Background Image for Recent Posts Section Header
	$wp_customize->add_setting( 'beckett_recent_posts_image' , array(
	    'default'     		=> '',
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_url_raw'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'beckett_recent_posts_image', array(
		'label'      => __( 'Recent Posts Heading Background', 'beckett' ),
		'section'    => 'beckett_recent_posts',
		'settings'   => 'beckett_recent_posts_image',
		'priority'   => 46
	) ) );

	// Number of Recent Posts to Show
	$wp_customize->add_setting( 'beckett_recent_posts_count' , array(
	    'default'			=> '3',
	    'type'				=> 'theme_mod',
	    'transport'			=> 'refresh',
	    'sanitize_callback'	=> 'beckett_sanitize_number'
	) );

	$wp_customize->add_control( 'beckett_recent_posts_count', array(
		'label'		=> __( 'Number of posts to Show', 'beckett' ),
		'section'	=> 'beckett_recent_posts',
		'settings'	=> 'beckett_recent_posts_count',
		'type'		=> 'select',
	    'choices'	=> array(
	        '0' => '0',
			'3' => '3',
	        '6' => '6',
	        '9' => '9',
	        ),
		'priority'	=> 53
	) );
	
	// Testimonials Section ----------------------------------------------------------
	$wp_customize->add_section( 'beckett_testimonials' , array(
	    'title'     	=> __( 'Testimonials', 'beckett' ),
	    'priority'   	=> 3,
	    'panel'			=> 'beckett_home'
	) );
	
	// Testimonials Title
	$wp_customize->add_setting( 'beckett_testimonials_title' , array(
	    'default'			=> __( 'Testimonials', 'beckett' ),
	    'type'				=> 'theme_mod',
	    'transport'			=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );

	$wp_customize->add_control( 'beckett_testimonials_title', array(
		'label'		=> __( 'Testimonials Title', 'beckett' ),
		'section'	=> 'beckett_testimonials',
		'settings'	=> 'beckett_testimonials_title',
		'priority'	=> 50
	) );
	
	// Testimonials Summary
	$wp_customize->add_setting( 'beckett_testimonials_summary' , array(
	    'default'     => __('', 'beckett'),
	    'type' => 'theme_mod',
	    'transport' => 'refresh',
	    'sanitize_callback'	 => 'wp_kses_post'
	) );

	$wp_customize->add_control( new TTrust_Textarea_Control( $wp_customize, 'beckett_testimonials_summary', array(
		'label'        => __('Testimonials Summary', 'beckett'),
		'section'    => 'beckett_testimonials',
		'settings'   => 'beckett_testimonials_summary',
		'priority'   => 51
	) ) );
	
	// Background Image for Testimonials Section Header
	$wp_customize->add_setting( 'beckett_testimonials_image' , array(
	    'default'     		=> '',
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_url_raw'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'beckett_testimonials_image', array(
		'label'      => __( 'Testimonials Heading Background', 'beckett' ),
		'section'    => 'beckett_testimonials',
		'settings'   => 'beckett_testimonials_image',
		'priority'   => 46
	) ) );
	
	// Number of Testimonials to Show
	$wp_customize->add_setting( 'beckett_testimonials_count' , array(
	    'default'			=> '3',
	    'type'				=> 'theme_mod',
	    'transport'			=> 'refresh',
	    'sanitize_callback'	=> 'beckett_sanitize_number'
	) );

	$wp_customize->add_control( 'beckett_testimonials_count', array(
		'label'		=> __( 'Number of Testimonials to Show', 'beckett' ),
		'section'	=> 'beckett_testimonials',
		'settings'	=> 'beckett_testimonials_count',
		'type'		=> 'select',
	    'choices'	=> array(
	        '0' => '0',
			'3' => '3',
	        '6' => '6',
	        '9' => '9',
	        ),
		'priority'	=> 53
	) );
	
	
	// Featured Content Section ----------------------------------------------------------
	$wp_customize->add_section( 'beckett_featured_content' , array(
	    'title'     	=> __( 'Featured Content', 'beckett' ),
	    'priority'   	=> 5,
	    'panel'			=> 'beckett_home'
	) );
	
	// Testimonials Title
	$wp_customize->add_setting( 'beckett_featured_title' , array(
	    'default'			=> __( 'Our Team', 'beckett' ),
	    'type'				=> 'theme_mod',
	    'transport'			=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );

	$wp_customize->add_control( 'beckett_featured_title', array(
		'label'		=> __( 'Featured Content Title', 'beckett' ),
		'section'	=> 'beckett_featured_content',
		'settings'	=> 'beckett_featured_title',
		'priority'	=> 55
	) );
	
	// featured Summary
	$wp_customize->add_setting( 'beckett_featured_summary' , array(
	    'default'     => __('', 'beckett'),
	    'type' => 'theme_mod',
	    'transport' => 'refresh',
	    'sanitize_callback'	 => 'wp_kses_post'
	) );

	$wp_customize->add_control( new TTrust_Textarea_Control( $wp_customize, 'beckett_featured_summary', array(
		'label'        => __('Featured Content Summary', 'beckett'),
		'section'    => 'beckett_featured_content',
		'settings'   => 'beckett_featured_summary',
		'priority'   => 56
	) ) );
	
	// Background Image for Featured Section Header
	$wp_customize->add_setting( 'beckett_featured_content_image' , array(
	    'default'     		=> '',
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_url_raw'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'beckett_featured_content_image', array(
		'label'      => __( 'Featured Content Heading Background', 'beckett' ),
		'section'    => 'beckett_featured_content',
		'settings'   => 'beckett_featured_content_image',
		'priority'   => 57
	) ) );	
	
	// -- Custom  CSS Section

	$wp_customize->add_section( 'beckett_css' , array(
	    'title'     	=> __( 'Custom CSS', 'beckett' ),
	    'description'	=> __('Add your own custom CSS.', 'beckett'),
	    'priority'   	=> 59,
	) );
	
	$wp_customize->add_setting( 'beckett_custom_css' , array(
	    'default'     => __('', 'beckett'),
	    'type' => 'theme_mod',
	    'transport' => 'refresh',
	    'sanitize_callback'	 => 'wp_kses_post'
	) );

	$wp_customize->add_control( new TTrust_Textarea_Control( $wp_customize, 'beckett_custom_css', array(
		'label'        => __('CSS', 'beckett'),
		'section'    => 'beckett_css',
		'settings'   => 'beckett_custom_css',
		'priority'   => 62
	) ) );

	// -- Colors Section

	// Accent (Borders)
	$wp_customize->add_setting( 'beckett_accent_color' );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
			'label'      => __( 'Accent Color', 'beckett' ),
			'section'    => 'colors',
			'settings'   => 'beckett_accent_color'
		) )
	);
	
	// Header
	$wp_customize->add_setting( 'beckett_header_color' );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'header_color', array(
			'label'      => __( 'Header Background Color', 'beckett' ),
			'section'    => 'colors',
			'settings'   => 'beckett_header_color'
		) )
	);
	
	// Menu Color
	$wp_customize->add_setting( 'beckett_menu_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_color', array(
			'label'      => __( 'Menu Color', 'beckett' ),
			'section'    => 'colors',
			'settings'   => 'beckett_menu_color',
			'priority'   => 13
		) )
	);
	
	// Menu Color Hover Color
	$wp_customize->add_setting( 'beckett_menu_hover_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_hover_color', array(
			'label'      => __( 'Menu Hover Color', 'beckett' ),
			'section'    => 'colors',
			'settings'   => 'beckett_menu_hover_color',
			'priority'   => 14
		) )
	);
	
	// Menu Background Color
	$wp_customize->add_setting( 'beckett_menu_background_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_background_color', array(
			'label'      => __( 'Menu Background Color', 'beckett' ),
			'section'    => 'colors',
			'settings'   => 'beckett_menu_background_color',
			'priority'   => 14
		) )
	);

	// Link Color
	$wp_customize->add_setting( 'beckett_link_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
			'label'      => __( 'Link Color', 'beckett' ),
			'section'    => 'colors',
			'settings'   => 'beckett_link_color',
			'priority'   => 15
		) )
	);

	// Link Hover Color (Incl. Active)
	$wp_customize->add_setting( 'beckett_link_hover_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_hover_color', array(
			'label'      => __( 'Link Hover Color', 'beckett' ),
			'section'    => 'colors',
			'settings'   => 'beckett_link_hover_color',
			'priority'   => 16
		) )
	);
	
	// -- Footer Section

	$wp_customize->add_section( 'beckett_footer' , array(
	    'title'      => __( 'Footer', 'beckett' ),
	    'priority'   => 50,
	) );

	// Left Footer Text (Custom Control)
	$wp_customize->add_setting( 'beckett_footer_left' , array(
	    'default'     => '',
	    'type' => 'theme_mod',
	    'transport' => 'refresh',
	    'sanitize_callback'	 => 'wp_kses_post'
	) );

	$wp_customize->add_control( new TTrust_Textarea_Control( $wp_customize, 'footer_left', array(
	    'label'   => __('Primary Footer Text', 'beckett'),
	    'section' => 'beckett_footer',
	    'settings'   => 'beckett_footer_left',
	    'priority'   => 71
	) ) );

	// Right Footer Text (Custom Control)
	$wp_customize->add_setting( 'beckett_footer_right' , array(
	    'default'     => '',
	    'type' => 'theme_mod',
	    'transport' => 'refresh',
	    'sanitize_callback'	 => 'wp_kses_post'
	) );

	$wp_customize->add_control( new TTrust_Textarea_Control( $wp_customize, 'footer_right', array(
	    'label'   => __('Secondary Footer Text', 'beckett'),
	    'section' => 'beckett_footer',
	    'settings'   => 'beckett_footer_right',
	    'priority'   => 72
	) ) );

}
add_action( 'customize_register', 'beckett_customize_register' );