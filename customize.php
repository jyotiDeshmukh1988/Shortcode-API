<?php
/**
 * Registers options with the Theme Customizer
 *
 * @param      object    $wp_customize    The WordPress Theme Customizer
 * @package    Dosth
 */
add_action("customize_register","nd_dosth_customize_register");
function nd_dosth_customize_register($wp_customize){
	// All the Customize Options you create goes here

    // Move Homepage Settings section underneath the "Site Identity" section
	$wp_customize->get_section("title_tagline")->priority = 1;
	$wp_customize->get_section("static_front_page")->priority = 2;
	$wp_customize->get_section("static_front_page")->title = __( 'Home page preferences', 'twentytwenty' );
	
	// add new panel for footer
	$wp_customize->add_panel('twentytwenty_footer_theme_options',
		array(
		'priority' => 100,
		'title' => __('Footer Copyright','twentytwenty'),
		'description' => __('Used for updating the footer copyright content','twentytwenty')
		)
	);
	// add new section for the panel
	$wp_customize->add_section('twentytwenty_footer_section', 
		array(
		'priority' => 1,
		'title' => __('Text Options','twentytwenty'),
		'panel' => 'twentytwenty_footer_theme_options'
		)
	);
	// add setting to the section
	/* A Setting just holds a piece of Data in the Database. 
	And we manage this piece of Data with the Help of a Control (Form Field)
	and we can add this Form Field to any Section inside the Customize Panel.
	*/
	$wp_customize->add_setting('twentytwenty_copyright_text',
		array(
		'default' => __('All Rights reserved','twentytwenty'),
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'refresh'
		)
	);
	// Control for Copyright text
	// How to add a Control and link it to the Setting and a particular Section
	$wp_customize->add_control('twentytwenty_copyright_text', // setting ID
		array(
		"type" => "text",
		"priority" => 10,
		"section" => "twentytwenty_footer_section", // section ID
		"label" => "Copyright Text",
		"description" => "Text put here will update the text in the footer"		
		)
	);
	// Setting for Read More text.
	$wp_customize->add_setting( 'nd_dosth_readmore_text',
		array(
			'type'              => 'option',
			'default'           => __( 'Read More ', 'nd_dosth' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	// Control for Read More text
	$wp_customize->add_control( 'nd_dosth_readmore_text', 
		array(
			'type'        => 'text',
			'priority'    => 10,
			'section'     => 'twentytwenty_footer_section',
			'label'       => 'Read More text',
			'description' => 'Text put here will be as the text for Read More link in the archives',
		) 
	);
	// Setting to Show/Hide Read More Link.
	$wp_customize->add_setting( 'nd_dosth_readmore_checkbox',
		array(
			'type'              => 'option',
			'default'           => true,
			'sanitize_callback' => 'nd_dosth_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);

	// Control to Show/Hide Read More Link.
	$wp_customize->add_control( 'nd_dosth_readmore_checkbox', 
		array(
			'type'        => 'checkbox',
			'section'     => 'twentytwenty_footer_section',
			'label'       => 'Show Read More Link',
			'description' => 'Turn off this checkbox to hide Read More Link on Post archives',
		) 
	);
	
}