<?php
/**
 * Lighting Store Theme Customizer
 *
 * @package Lighting Store
 */

/**
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Lighting_Store_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Lighting_Store_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Lighting_Store_Customize_Section_Pro(
				$manager,
				'example_1',
				array(
					'priority' => 9,
					'title'    => esc_html__( 'Lighting Store Pro', 'lighting-store' ),
					'pro_text' => esc_html__( 'Go Pro', 'lighting-store' ),
					'pro_url'  => esc_url( 'https://www.logicalthemes.com/themes/lighting-store-wordpress-theme/' ),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'lighting-store-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'lighting-store-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Lighting_Store_Customize::get_instance();

function lighting_store_customize_register( $wp_customize ) {	

	//add home page setting pannel
	$wp_customize->add_panel( 'lighting_store_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => esc_html__( 'LT Settings', 'lighting-store' ),
	) );

	//Layout Setting
	$wp_customize->add_section( 'lighting_store_left_right' , array(
    	'title'      => esc_html__( 'General Settings', 'lighting-store' ),
		'priority'   => null,
		'panel' => 'lighting_store_panel_id'
	) );

	$wp_customize->add_setting('lighting_store_theme_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'lighting_store_sanitize_choices'
	));
	$wp_customize->add_control('lighting_store_theme_options',array(
        'type' => 'radio',
        'description' => __( 'Choose sidebar between different options', 'lighting-store' ),
        'label' => esc_html__( 'Post Sidebar Layout.', 'lighting-store' ),
        'section' => 'lighting_store_left_right',
        'choices' => array(
            'One Column' => esc_html__('One Column ','lighting-store'),
            'Three Columns' => esc_html__('Three Columns','lighting-store'),
            'Four Columns' => esc_html__('Four Columns','lighting-store'),
            'Right Sidebar' => esc_html__('Right Sidebar','lighting-store'),
            'Left Sidebar' => esc_html__('Left Sidebar','lighting-store'),
            'Grid Layout' => esc_html__('Grid Layout','lighting-store')
        ),
	));

	$lighting_store_font_array = array(
        '' =>'No Fonts',
        'Abril Fatface' => 'Abril Fatface',
        'Acme' =>'Acme', 
        'Anton' => 'Anton', 
        'Architects Daughter' =>'Architects Daughter',
        'Arimo' => 'Arimo', 
        'Arsenal' =>'Arsenal',
        'Arvo' =>'Arvo',
        'Alegreya' =>'Alegreya',
        'Alfa Slab One' =>'Alfa Slab One',
        'Averia Serif Libre' =>'Averia Serif Libre', 
        'Bangers' =>'Bangers', 
        'Boogaloo' =>'Boogaloo', 
        'Bad Script' =>'Bad Script',
        'Bitter' =>'Bitter', 
        'Bree Serif' =>'Bree Serif', 
        'BenchNine' =>'BenchNine',
        'Cabin' =>'Cabin',
        'Cardo' =>'Cardo', 
        'Courgette' =>'Courgette', 
        'Cherry Swash' =>'Cherry Swash',
        'Cormorant Garamond' =>'Cormorant Garamond', 
        'Crimson Text' =>'Crimson Text',
        'Cuprum' =>'Cuprum', 
        'Cookie' =>'Cookie',
        'Chewy' =>'Chewy',
        'Days One' =>'Days One',
        'Dosis' =>'Dosis',
        'Droid Sans' =>'Droid Sans', 
        'Economica' =>'Economica', 
        'Fredoka One' =>'Fredoka One',
        'Fjalla One' =>'Fjalla One',
        'Francois One' =>'Francois One', 
        'Frank Ruhl Libre' => 'Frank Ruhl Libre', 
        'Gloria Hallelujah' =>'Gloria Hallelujah',
        'Great Vibes' =>'Great Vibes', 
        'Handlee' =>'Handlee', 
        'Hammersmith One' =>'Hammersmith One',
        'Inconsolata' =>'Inconsolata',
        'Indie Flower' =>'Indie Flower', 
        'IM Fell English SC' =>'IM Fell English SC',
        'Julius Sans One' =>'Julius Sans One',
        'Josefin Slab' =>'Josefin Slab',
        'Josefin Sans' =>'Josefin Sans',
        'Kanit' =>'Kanit',
        'Lobster' =>'Lobster',
        'Lato' => 'Lato',
        'Lora' =>'Lora', 
        'Libre Baskerville' =>'Libre Baskerville',
        'Lobster Two' => 'Lobster Two',
        'Merriweather' =>'Merriweather',
        'Monda' =>'Monda',
        'Montserrat' =>'Montserrat',
        'Muli' =>'Muli',
        'Marck Script' =>'Marck Script',
        'Noto Serif' =>'Noto Serif',
        'Open Sans' =>'Open Sans',
        'Overpass' => 'Overpass', 
        'Overpass Mono' =>'Overpass Mono',
        'Oxygen' =>'Oxygen',
        'Orbitron' =>'Orbitron',
        'Patua One' =>'Patua One',
        'Pacifico' =>'Pacifico',
        'Padauk' =>'Padauk',
        'Playball' =>'Playball',
        'Playfair Display' =>'Playfair Display',
        'PT Sans' =>'PT Sans',
        'Philosopher' =>'Philosopher',
        'Permanent Marker' =>'Permanent Marker',
        'Poiret One' =>'Poiret One',
        'Quicksand' =>'Quicksand',
        'Quattrocento Sans' =>'Quattrocento Sans',
        'Raleway' =>'Raleway',
        'Rubik' =>'Rubik',
        'Rokkitt' =>'Rokkitt',
        'Russo One' => 'Russo One', 
        'Righteous' =>'Righteous', 
        'Slabo' =>'Slabo', 
        'Source Sans Pro' =>'Source Sans Pro',
        'Shadows Into Light Two' =>'Shadows Into Light Two',
        'Shadows Into Light' =>  'Shadows Into Light',
        'Sacramento' =>'Sacramento',
        'Shrikhand' =>'Shrikhand',
        'Tangerine' => 'Tangerine',
        'Ubuntu' =>'Ubuntu',
        'VT323' =>'VT323',
        'Varela Round' =>'Varela Round',
        'Vampiro One' =>'Vampiro One',
        'Vollkorn' => 'Vollkorn',
        'Volkhov' =>'Volkhov',
        'Yanone Kaffeesatz' =>'Yanone Kaffeesatz'
    );

	//Typography
	$wp_customize->add_section( 'lighting_store_typography', array(
    	'title'      => __( 'Typography', 'lighting-store' ),
		'priority'   => null,
		'panel' => 'lighting_store_panel_id'
	) );
	
	// This is Paragraph Color picker setting
	$wp_customize->add_setting( 'lighting_store_paragraph_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lighting_store_paragraph_color', array(
		'label' => __('Paragraph Color', 'lighting-store'),
		'section' => 'lighting_store_typography',
		'settings' => 'lighting_store_paragraph_color',
	)));

	//This is Paragraph FontFamily picker setting
	$wp_customize->add_setting('lighting_store_paragraph_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'lighting_store_sanitize_choices'
	));
	$wp_customize->add_control(
	    'lighting_store_paragraph_font_family', array(
	    'section'  => 'lighting_store_typography',
	    'label'    => __( 'Paragraph Fonts','lighting-store'),
	    'type'     => 'select',
	    'choices'  => $lighting_store_font_array,
	));

	$wp_customize->add_setting('lighting_store_paragraph_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('lighting_store_paragraph_font_size',array(
		'label'	=> __('Paragraph Font Size','lighting-store'),
		'section'	=> 'lighting_store_typography',
		'setting'	=> 'lighting_store_paragraph_font_size',
		'type'	=> 'text'
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'lighting_store_atag_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lighting_store_atag_color', array(
		'label' => __('"a" Tag Color', 'lighting-store'),
		'section' => 'lighting_store_typography',
		'settings' => 'lighting_store_atag_color',
	)));

	//This is "a" Tag FontFamily picker setting
	$wp_customize->add_setting('lighting_store_atag_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'lighting_store_sanitize_choices'
	));
	$wp_customize->add_control(
	    'lighting_store_atag_font_family', array(
	    'section'  => 'lighting_store_typography',
	    'label'    => __( '"a" Tag Fonts','lighting-store'),
	    'type'     => 'select',
	    'choices'  => $lighting_store_font_array,
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'lighting_store_li_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lighting_store_li_color', array(
		'label' => __('"li" Tag Color', 'lighting-store'),
		'section' => 'lighting_store_typography',
		'settings' => 'lighting_store_li_color',
	)));

	//This is "li" Tag FontFamily picker setting
	$wp_customize->add_setting('lighting_store_li_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'lighting_store_sanitize_choices'
	));
	$wp_customize->add_control(
	    'lighting_store_li_font_family', array(
	    'section'  => 'lighting_store_typography',
	    'label'    => __( '"li" Tag Fonts','lighting-store'),
	    'type'     => 'select',
	    'choices'  => $lighting_store_font_array,
	));

	// This is H1 Color picker setting
	$wp_customize->add_setting( 'lighting_store_h1_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lighting_store_h1_color', array(
		'label' => __('H1 Color', 'lighting-store'),
		'section' => 'lighting_store_typography',
		'settings' => 'lighting_store_h1_color',
	)));

	//This is H1 FontFamily picker setting
	$wp_customize->add_setting('lighting_store_h1_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'lighting_store_sanitize_choices'
	));
	$wp_customize->add_control(
	    'lighting_store_h1_font_family', array(
	    'section'  => 'lighting_store_typography',
	    'label'    => __( 'H1 Fonts','lighting-store'),
	    'type'     => 'select',
	    'choices'  => $lighting_store_font_array,
	));

	//This is H1 FontSize setting
	$wp_customize->add_setting('lighting_store_h1_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('lighting_store_h1_font_size',array(
		'label'	=> __('H1 Font Size','lighting-store'),
		'section'	=> 'lighting_store_typography',
		'setting'	=> 'lighting_store_h1_font_size',
		'type'	=> 'text'
	));

	// This is H2 Color picker setting
	$wp_customize->add_setting( 'lighting_store_h2_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lighting_store_h2_color', array(
		'label' => __('H2 Color', 'lighting-store'),
		'section' => 'lighting_store_typography',
		'settings' => 'lighting_store_h2_color',
	)));

	//This is H2 FontFamily picker setting
	$wp_customize->add_setting('lighting_store_h2_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'lighting_store_sanitize_choices'
	));
	$wp_customize->add_control(
	    'lighting_store_h2_font_family', array(
	    'section'  => 'lighting_store_typography',
	    'label'    => __( 'H2 Fonts','lighting-store'),
	    'type'     => 'select',
	    'choices'  => $lighting_store_font_array,
	));

	//This is H2 FontSize setting
	$wp_customize->add_setting('lighting_store_h2_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('lighting_store_h2_font_size',array(
		'label'	=> __('H2 Font Size','lighting-store'),
		'section'	=> 'lighting_store_typography',
		'setting'	=> 'lighting_store_h2_font_size',
		'type'	=> 'text'
	));

	// This is H3 Color picker setting
	$wp_customize->add_setting( 'lighting_store_h3_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lighting_store_h3_color', array(
		'label' => __('H3 Color', 'lighting-store'),
		'section' => 'lighting_store_typography',
		'settings' => 'lighting_store_h3_color',
	)));

	//This is H3 FontFamily picker setting
	$wp_customize->add_setting('lighting_store_h3_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'lighting_store_sanitize_choices'
	));
	$wp_customize->add_control(
	    'lighting_store_h3_font_family', array(
	    'section'  => 'lighting_store_typography',
	    'label'    => __( 'H3 Fonts','lighting-store'),
	    'type'     => 'select',
	    'choices'  => $lighting_store_font_array,
	));

	//This is H3 FontSize setting
	$wp_customize->add_setting('lighting_store_h3_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('lighting_store_h3_font_size',array(
		'label'	=> __('H3 Font Size','lighting-store'),
		'section'	=> 'lighting_store_typography',
		'setting'	=> 'lighting_store_h3_font_size',
		'type'	=> 'text'
	));

	// This is H4 Color picker setting
	$wp_customize->add_setting( 'lighting_store_h4_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lighting_store_h4_color', array(
		'label' => __('H4 Color', 'lighting-store'),
		'section' => 'lighting_store_typography',
		'settings' => 'lighting_store_h4_color',
	)));

	//This is H4 FontFamily picker setting
	$wp_customize->add_setting('lighting_store_h4_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'lighting_store_sanitize_choices'
	));
	$wp_customize->add_control(
	    'lighting_store_h4_font_family', array(
	    'section'  => 'lighting_store_typography',
	    'label'    => __( 'H4 Fonts','lighting-store'),
	    'type'     => 'select',
	    'choices'  => $lighting_store_font_array,
	));

	//This is H4 FontSize setting
	$wp_customize->add_setting('lighting_store_h4_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('lighting_store_h4_font_size',array(
		'label'	=> __('H4 Font Size','lighting-store'),
		'section'	=> 'lighting_store_typography',
		'setting'	=> 'lighting_store_h4_font_size',
		'type'	=> 'text'
	));

	// This is H5 Color picker setting
	$wp_customize->add_setting( 'lighting_store_h5_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lighting_store_h5_color', array(
		'label' => __('H5 Color', 'lighting-store'),
		'section' => 'lighting_store_typography',
		'settings' => 'lighting_store_h5_color',
	)));

	//This is H5 FontFamily picker setting
	$wp_customize->add_setting('lighting_store_h5_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'lighting_store_sanitize_choices'
	));
	$wp_customize->add_control(
	    'lighting_store_h5_font_family', array(
	    'section'  => 'lighting_store_typography',
	    'label'    => __( 'H5 Fonts','lighting-store'),
	    'type'     => 'select',
	    'choices'  => $lighting_store_font_array,
	));

	//This is H5 FontSize setting
	$wp_customize->add_setting('lighting_store_h5_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('lighting_store_h5_font_size',array(
		'label'	=> __('H5 Font Size','lighting-store'),
		'section'	=> 'lighting_store_typography',
		'setting'	=> 'lighting_store_h5_font_size',
		'type'	=> 'text'
	));

	// This is H6 Color picker setting
	$wp_customize->add_setting( 'lighting_store_h6_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'lighting_store_h6_color', array(
		'label' => __('H6 Color', 'lighting-store'),
		'section' => 'lighting_store_typography',
		'settings' => 'lighting_store_h6_color',
	)));

	//This is H6 FontFamily picker setting
	$wp_customize->add_setting('lighting_store_h6_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'lighting_store_sanitize_choices'
	));
	$wp_customize->add_control(
	    'lighting_store_h6_font_family', array(
	    'section'  => 'lighting_store_typography',
	    'label'    => __( 'H6 Fonts','lighting-store'),
	    'type'     => 'select',
	    'choices'  => $lighting_store_font_array,
	));

	//This is H6 FontSize setting
	$wp_customize->add_setting('lighting_store_h6_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('lighting_store_h6_font_size',array(
		'label'	=> __('H6 Font Size','lighting-store'),
		'section'	=> 'lighting_store_typography',
		'setting'	=> 'lighting_store_h6_font_size',
		'type'	=> 'text'
	));

	//Topbar section
	$wp_customize->add_section('lighting_store_topbar',array(
		'title'	=> esc_html__('Topbar','lighting-store'),
		'priority'	=> null,
		'panel' => 'lighting_store_panel_id',
	));

	$wp_customize->add_setting( 'lighting_store_sticky_header',array(
		'default'	=> false,
      	'sanitize_callback'	=> 'lighting_store_sanitize_checkbox'
    ) );
    $wp_customize->add_control('lighting_store_sticky_header',array(
    	'type' => 'checkbox',
    	'description' => __( 'Click on the checkbox to enable sticky header.', 'lighting-store' ),
        'label' => __( 'Sticky Header','lighting-store' ),
        'section' => 'lighting_store_topbar'
    ));

    //Show /Hide Topbar
	$wp_customize->add_setting( 'lighting_store_show_topbar',array(
		'default' => false,
      	'sanitize_callback'	=> 'lighting_store_sanitize_checkbox'
    ) );
    $wp_customize->add_control('lighting_store_show_topbar',array(
    	'type' => 'checkbox',
    	'description' => __( 'Click on the checkbox to enable Topbar.', 'lighting-store' ),
        'label' => __( 'Topbar','lighting-store' ),
        'section' => 'lighting_store_topbar'
    ));

	$wp_customize->add_setting('lighting_store_topar_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('lighting_store_topar_text',array(
		'label'	=> __('Topbar Text','lighting-store'),
		'section' => 'lighting_store_topbar',
		'type'	 => 'text'
	));

	$wp_customize->add_setting('lighting_store_email',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_email'
	));
	$wp_customize->add_control('lighting_store_email',array(
		'label'	=> __('Add Email Address','lighting-store'),
		'section' => 'lighting_store_topbar',
		'type'	 => 'text'
	));

	$wp_customize->add_setting('lighting_store_phoneno',array(
		'default'	=> '',
		'sanitize_callback'	=> 'lighting_store_sanitize_phone_number'
	));	
	$wp_customize->add_control('lighting_store_phoneno',array(
		'label'	=> __('Add Phone Number','lighting-store'),
		'section' => 'lighting_store_topbar',
		'type'	  => 'text'
	));

	//home page slider
	$wp_customize->add_section( 'lighting_store_slidersettings' , array(
    	'title'      => esc_html__( 'Slider Settings', 'lighting-store' ),
		'priority'   => null,
		'panel' => 'lighting_store_panel_id'
	) );

	$wp_customize->add_setting('lighting_store_slider_hide_show',array(
       'default' => false,
       'sanitize_callback'	=> 'lighting_store_sanitize_checkbox'
	));
	$wp_customize->add_control('lighting_store_slider_hide_show',array(
	   'type' => 'checkbox',
	   'description' => __( 'Click on the checkbox to enable slider.', 'lighting-store' ),
	   'label' => esc_html__('Show / Hide slider','lighting-store'),
	   'section' => 'lighting_store_slidersettings',
	));

	for ( $count = 1; $count <= 4; $count++ ) {
		$wp_customize->add_setting( 'lighting_store_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'lighting_store_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'lighting_store_slider_page' . $count, array(
			'label'    => esc_html__( 'Select Slider Page', 'lighting-store' ),
	   		'description' => __( 'Slider Image Size (1200px x 650px)', 'lighting-store' ),
			'section'  => 'lighting_store_slidersettings',
			'type'     => 'dropdown-pages'
		) );
	}

	// Features Section
	$wp_customize->add_section('lighting_store_features_section',array(
		'title'	=> __('Features Section','lighting-store'),
		'panel' => 'lighting_store_panel_id',
	));

	$wp_customize->add_setting('lighting_store_support_title',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('lighting_store_support_title',array(
		'label'	=> __('Support Title','lighting-store'),
		'section' => 'lighting_store_features_section',
		'type'	  => 'text'
	));

	$wp_customize->add_setting('lighting_store_support_text',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('lighting_store_support_text',array(
		'label'	=> __('Support Text','lighting-store'),
		'section' => 'lighting_store_features_section',
		'type'	  => 'text'
	));

	$wp_customize->add_setting('lighting_store_delivery_title',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('lighting_store_delivery_title',array(
		'label'	=> __('Delivery Title','lighting-store'),
		'section' => 'lighting_store_features_section',
		'type'	  => 'text'
	));

	$wp_customize->add_setting('lighting_store_delivery_text',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('lighting_store_delivery_text',array(
		'label'	=> __('Delivery Text','lighting-store'),
		'section' => 'lighting_store_features_section',
		'type'	  => 'text'
	));

	$wp_customize->add_setting('lighting_store_nextday_delivery_title',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('lighting_store_nextday_delivery_title',array(
		'label'	=> __('Next Day Delivery Title','lighting-store'),
		'section' => 'lighting_store_features_section',
		'type'	  => 'text'
	));

	$wp_customize->add_setting('lighting_store_nextday_delivery_text',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('lighting_store_nextday_delivery_text',array(
		'label'	=> __('Next Day Delivery Text','lighting-store'),
		'section' => 'lighting_store_features_section',
		'type'	  => 'text'
	));

	// Special Products
	$wp_customize->add_section('lighting_store_special_products_section',array(
		'title'	=> __('Special Products','lighting-store'),
		'panel' => 'lighting_store_panel_id',
	));

	$wp_customize->add_setting('lighting_store_section_title',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('lighting_store_section_title',array(
		'label'	=> __('Section Title','lighting-store'),
		'section' => 'lighting_store_special_products_section',
		'type'	  => 'text'
	));

	$wp_customize->add_setting('lighting_store_section_text',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('lighting_store_section_text',array(
		'label'	=> __('Section Text','lighting-store'),
		'section' => 'lighting_store_special_products_section',
		'type'	  => 'text'
	));
	
	$wp_customize->add_setting( 'lighting_store_special_products_page', array(
		'default'           => '',
		'sanitize_callback' => 'lighting_store_sanitize_dropdown_pages'
	));
	$wp_customize->add_control( 'lighting_store_special_products_page', array(
		'label'    => __( 'Select Product Page', 'lighting-store' ),
		'section'  => 'lighting_store_special_products_section',
		'type'     => 'dropdown-pages'
	));

	//footer
	$wp_customize->add_section('lighting_store_footer_section',array(
		'title'	=> esc_html__('Footer Text','lighting-store'),
		'panel' => 'lighting_store_panel_id'
	));
		
	$wp_customize->add_setting('lighting_store_footer_copy',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('lighting_store_footer_copy',array(
		'label'	=> esc_html__('Copyright Text','lighting-store'),
		'section'	=> 'lighting_store_footer_section',
		'type'		=> 'text'
	));

	//Wocommerce Shop Page
	$wp_customize->add_section('lighting_store_woocommerce_shop_page',array(
		'title'	=> __('Woocommerce Shop Page','lighting-store'),
		'panel' => 'lighting_store_panel_id'
	));

	$wp_customize->add_setting( 'lighting_store_products_per_column' , array(
		'default'           => 3,
		'transport'         => 'refresh',
		'sanitize_callback' => 'lighting_store_sanitize_choices',
	) );
	$wp_customize->add_control( 'lighting_store_products_per_column', array(
		'label'    => __( 'Product Per Columns', 'lighting-store' ),
		'description'	=> __('How many products should be shown per Column?','lighting-store'),
		'section'  => 'lighting_store_woocommerce_shop_page',
		'type'     => 'select',
		'choices'  => array(
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
		),
	)  );

	$wp_customize->add_setting('lighting_store_products_per_page',array(
		'default'	=> 9,
		'sanitize_callback'	=> 'lighting_store_sanitize_float',
	));	
	$wp_customize->add_control('lighting_store_products_per_page',array(
		'label'	=> __('Product Per Page','lighting-store'),
		'description'	=> __('How many products should be shown per page?','lighting-store'),
		'section'	=> 'lighting_store_woocommerce_shop_page',
		'type'		=> 'number'
	));

	// logo site title
	$wp_customize->add_setting('lighting_store_site_title_tagline',array(
       'default' => true,
       'sanitize_callback'	=> 'lighting_store_sanitize_checkbox'
    ));
    $wp_customize->add_control('lighting_store_site_title_tagline',array(
       'type' => 'checkbox',
       'label' => __('Display Site Title and Tagline in Header','lighting-store'),
       'section' => 'title_tagline'
    ));
}
add_action( 'customize_register', 'lighting_store_customize_register' );