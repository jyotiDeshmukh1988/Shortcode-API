<?php
/**
 * Plugin Name: Icon Block
 * Description: This plugin will add font-awesome icon block in the Gutenberg editor blocks.
 * Author: Harmandeep Singh
 * Version: 1.0.0
 * Author URI: https://profile.wordpress.org/harmancheema
 */

if(!function_exists('hsc_load_fontawesome_setting')){
	function hsc_load_fontawesome_setting( $wp_customize){
		
		$wp_customize->add_section( 'icon_block' , array(
		    'title'      => __('Icon Block'),
		    'priority'   => 50,
		) );
		$wp_customize->add_setting(
		    'choose_icons_family',
		    array(
		        'default' 	=> 'fa4',
		        "transport" => "refresh",
		    ));

		$wp_customize->add_control('choose_icons_family', array(
            'label'   		=> __('Show Full Width'),
            'section' 		=> 'icon_block',
            'type'    		=> 'select',
			'description' 	=> __( 'Choose option to include font-awesome in the website.' ),
		  	'choices' 		=> array(
		  		'no'		=> __( 'Already exists' ),
			   'fa4' 	=> __( 'Font Awesome 4.7' ),
			   'fa5' 	=> __( 'Font Awesome 5.0' ),
			),
        ));

	}
}
add_action( 'customize_register', 'hsc_load_fontawesome_setting' );

if(!function_exists('hsc_include_assets')){

	function hsc_include_assets(){
		$type = get_theme_mod('choose_icons_family');
		switch($type){

			case 'fa4':
			$assets = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css';
			wp_enqueue_style('font-awesome', $assets, array(), '4.7');
			break;

			case 'fa5':
			$assets = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.0/css/fontawesome.css';
			wp_enqueue_style('font-awesome', $assets, array(), '5.1');			
			break;

			case 'no':
			$assets = '';
			break;

			default:
			$assets = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css';
			wp_enqueue_style('font-awesome', $assets, array(), '4.7');
			break;
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hsc_include_assets', 101 );

if(!function_exists('load_hsc_fontawesome_icon_block')){ 
	function load_hsc_fontawesome_icon_block() {
	  wp_enqueue_script(
	    'navigation-menu-block',
	    plugin_dir_url(__FILE__) . 'assets/hsc-icons.js',
	    array('wp-blocks','wp-editor'),
	    true
	  );
	  $type = get_theme_mod('choose_icons_family');
		switch($type){

			case 'fa4':
			$assets = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css';
			wp_enqueue_style('font-awesome', $assets, array(), '4.7');
			break;

			case 'fa5':
			$assets = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.0/css/fontawesome.css';
			wp_enqueue_style('font-awesome', $assets, array(), '5.1');			
			break;

			case 'no':
			$assets = '';
			break;

			default:
			$assets = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css';
			wp_enqueue_style('font-awesome', $assets, array(), '4.7');
			break;
		}
	}
}
add_action('enqueue_block_editor_assets', 'load_hsc_fontawesome_icon_block');
