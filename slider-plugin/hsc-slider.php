<?php 

/**
	 Plugin Name: Slider
	 Plugin URI: http://wordpress.org/plugins/hello-dolly/
	Description: A Slider plugin to show slider in the website.
	Author: Harmandeep Singh
	Version: 1.0
	Author URI: http://ma.tt/
 */

function hsc_slider_scripts(){

		wp_enqueue_script( 'slick-js',  get_stylesheet_directory_uri().'/asset/js/slick.min.js');
		wp_enqueue_style( 'slick-css' , get_stylesheet_directory_uri().'/asset/css/slick.css' );
		wp_enqueue_style( 'slick-theme-css' , get_stylesheet_directory_uri().'/asset/css/slick-theme.css' );

	wp_enqueue_style( 'hsc-slider-style' , plugin_dir_url(__FILE__).'/hsc-slider.css' );
	
}

add_action( 'wp_enqueue_scripts', 'hsc_slider_scripts', 100 );

function hsc_slider_post_type(){
	$labels = array(
	    'name'                => _x( 'Sliders', 'Post Type General Name', 'hsc' ),
	    'singular_name'       => _x( 'Slider', 'Post Type Singular Name', 'hsc' ),
	    );
	     
    $args = array(
        'label'               => __( 'Sliders', 'hsc' ),
        'description'         => __( 'Slider for Website ', 'hsc' ),
        'labels'              => $labels,
        'show_in_rest' 		  => true,
        'supports'            => array( 'title' ),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'menu_icon'		      => 'dashicons-slides',
        'show_in_admin_bar'   => true,
        'menu_position'       => 50,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => false,
        'capability_type'     => 'page',
    );
	     
	register_post_type( 'hsc_slider', $args );
}
add_action( 'init', 'hsc_slider_post_type', 0 );

function hsc_slider_metaboxes() {
	$prefix = '_slider_';
    $cmb = new_cmb2_box( array(
        'id'            => 'slider',
        'title'         => __( 'Slides', 'cmb2' ),
        'object_types'  => array( 'hsc_slider', ), 
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, 
    ) );

    $slide = $cmb->add_field( array(
        'name'       => __( 'Slide', 'cmb2' ),
        'description' => 'Add slides to show in the slider',
        'id'         => $prefix .'slide',
        'type'       => 'group',
        'options'     => array(
			'group_title'       => __( 'Slide {#}', 'cmb2' ), 
			'add_button'        => __( 'Add New Slide', 'cmb2' ),
			'remove_button'     => __( 'Remove Slide', 'cmb2' ),
			'sortable'          => true,
			'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), 
		), 
    ) );
    
    $cmb->add_group_field( $slide, array(
		'name'    => 'Show Slide',
		'id'      => 'visibility',
		'type'    => 'radio_inline',
		'options' => array(
			'on' => __( 'On', 'cmb2' ),
			'off'   => __( 'Off', 'cmb2' ),
		),
		'default' => 'on',
	) );

    $cmb->add_group_field( $slide, array(
		'name' => 'Background Image',
		'description' => 'Add background Image to show in slide Aspect Ratio 16:9 (Min height 600px).',
		'id'   => 'image',
		'type' => 'file',
		'options' => array(
			'url' => false, 
		),
		'text'    => array(
			'add_upload_file_text' => 'Add Background Image' 
		),
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
		),
		'preview_size' => 'thumbnail',
	) );
	
	$cmb->add_group_field( $slide, array(
		'name' => 'Image Alt',
		'description' => 'Alt tag for the Image.',
		'id'   => 'image_alt',
		'type' => 'text',
	) );

	$cmb->add_group_field( $slide, array(
		'name'    => 'Background Overlay',
		'id'      => 'overlay',
		'type'    => 'radio_inline',
		'options' => array(
			'on' => __( 'Show', 'cmb2' ),
			'off'   => __( 'Hide', 'cmb2' ),
		),
		'default' => 'on',
	) );

	$cmb->add_group_field( $slide, array(
		'name' => 'Image Link',
		'description' => 'Link to redirect from the slide(Keep empty if no redirection required).',
		'id'   => 'bg_link',
		'type' => 'text_url',
	) );

	$cmb->add_group_field( $slide, array(
		'name' => 'Heading Style',
		'description' => 'Choose the styleing for the heading.',
		'id'   => 'heading_style',
		'type' => 'select',
		'default'          => 'h2',
		'options'          => array(
			'h1' => __('h1', 'cmb2'),
			'h2' => __('h2', 'cmb2'),
			'h3' => __('h3', 'cmb2'),
			'h4' => __('h4', 'cmb2'),
			'p'  => __('p', 'cmb2'),
		),
	) );

	$cmb->add_group_field($slide, array(
		'name' => 'Heading',
		'description' => 'Enter Title to show on the slide above background Image.',
		'id'   => 'heading',
		'type' => 'text',
	));

	$cmb->add_group_field( $slide, array(
		'name' => 'Body',
		'description' => 'Enter Sub heading to show on the slide below title.',
		'id'   => 'body',
		'type' => 'textarea',
	) );

	$cmb->add_group_field( $slide, array(
		'name' => 'Button Text',
		'description' => 'Button text to show in link button.',
		'id'   => 'button_text',
		'type' => 'text',
	) );

	$cmb->add_group_field( $slide, array(
		'name' => 'Button Link',
		'description' => 'Link to redirect from the slide button.',
		'id'   => 'button_link',
		'type' => 'text_url',
	) );

}
add_action( 'cmb2_admin_init', 'hsc_slider_metaboxes' );

function hsc_slider_save($post_id){
	if(get_post_type($post_id) == 'hsc_slider'){
   		$shortcode = '[hsc-slider id="'.$post_id.'" name="'.get_the_title($post_id).'"]';
   		update_post_meta( $post_id, 'slider_shortcode', $shortcode);
   	}
}
add_action('save_post', 'hsc_slider_save');

add_filter('manage_hsc_slider_posts_columns' , 'add_portfolio_columns');
function add_portfolio_columns($columns) {
    return array_merge($columns,
              array('shortcode' => __('Shortcode'),));
}

add_action( 'manage_hsc_slider_posts_custom_column' , 'custom_order_column', 10, 2 );

function hsc_slider_shortcode_order_column( $columns ) {
    $new = array();
	foreach($columns as $key => $title) {
		if ($key=='date') // Put the Thumbnail column before the Author column
	      $new['shortcode'] = 'Shortcode';
	    $new[$key] = $title;
	  }
	  return $new;
}
add_filter( 'manage_hsc_slider_posts_columns', 'hsc_slider_shortcode_order_column', 10 );

function custom_order_column( $column, $post_id ) {
    switch ( $column ) {
        case 'shortcode' :
            echo "<input type='text' readonly='readonly' value='".get_post_meta( $post_id , 'slider_shortcode' , true )."' style='width:350px; cursor: text;'  onClick='this.select();'>"; 
            break;
    }
}

function hsc_slider_shortcode( $atts){
	$atts = shortcode_atts(array( 'id' => '', 'name' => '', 'dots' => 'false', 'arrows' => 'false', 'infinte' => 'true', 'class' => 'hsc-slider', 'autoplay' => 'false' ), $atts);
	$sliderId = $atts['id'];

	$slides = get_post_meta($sliderId, '_slider_slide', true);

	$html = '<div class="'.$atts["class"].'" id="slider-'.$sliderId.'">';
	$i = 1;
	foreach($slides as $slide){
		(isset($slide['visibility'])) ?$visibility = $slide['visibility'] : $visibility = '';
		(isset($slide['image'])) ? $image = $slide['image'] : $image = '';
		(isset($slide['image_alt'])) ? $image_alt = $slide['image_alt'] : $image_alt = '';
		(isset($slide['bg_link'])) ? $bg_link = $slide['bg_link'] : $bg_link = '';
		(isset($slide['heading'])) ? $heading = $slide['heading'] : $heading = '';
		(isset($slide['body'])) ? $body = $slide['body'] : $body = '';
		(isset($slide['button_link'])) ? $button_link = $slide['button_link'] : $button_link = '';
		(isset($slide['button_text'])) ? $button_text = $slide['button_text'] : $button_text = '';
		(isset($slide['overlay']) && $slide['overlay'] == 'on') ? $overlay = 'overlay' : $overlay = '';
		switch($slide['heading_style']){
			case 'h1':
				$headingStyle = '<h1 class="h2">'.$heading.'</h1>';
			break;
			case 'h2':
				$headingStyle = '<h2 class="h2">'.$heading.'</h2>';
			break;
			case 'h3':
				$headingStyle = '<h3 class="h2">'.$heading.'</h3>';
			break;
			case 'h4':
				$headingStyle = '<h4 class="h2">'.$heading.'</h3>';
			break;
			case 'p':
				$headingStyle = '<p class="h2">'.$heading.'</p>';
			break;
			default:
				$headingStyle = '<h2 class="h2">'.$heading.'</h2>';
			break;
		}

		if($visibility != 'off'){
			$html .= '<div class="slide" id="slide'.$i.'">';

			$html .= '<div class="slide-inner '.$overlay.'">';

			if($bg_link){
				$html .= '<a href="'.$bg_link.'">';
			}
			if($image){
				$html .= '<img src="'.$image.'" class="slide-bg" alt="'.$image_alt.'">';
			}
			if($bg_link){
				$html .= '</a>';
			}
			$html .= '<div class="slide-content container">';
			
			if($heading) $html .= $headingStyle;

			if($body){
				$html .= '<div class="slide-body ">'.$body.'</div>';
			}
			if($button_text){
				$html .= '<a class="button btn btn-primary slider_button" href="'.$button_link.'">'.$button_text.'</a>';
			}
			$html .='</div>';
			$html .= '</div></div>';

			$i++;
		}

	}
	$html .= '</div>';
	$script = "<script>/** Website Homepage Slider */
    jQuery('.".$atts['class']."').slick({
        dots: ".$atts['dots'].",
        arrows: ".$atts['arrows'].",
		infinite: ".$atts['infinte'].",
		autoplay: ".$atts['autoplay'].",
        slidesToShow: 1,
        slidesToScroll: 1
    });</script>";

    add_action( 'wp_footer', function() use( $script ){
        echo $script;
    });
	return $html;
}
add_shortcode( 'hsc-slider', 'hsc_slider_shortcode');

function hsc_sldier_register_meta_boxes() {
    add_meta_box( 'hsc_slides', __( 'Slides', 'hsc' ), 'hsc_slider_metabox_callback', 'hsc_slider' );
}
add_action( 'add_meta_boxes', 'hsc_sldier_register_meta_boxes' );
 
function hsc_slider_metabox_callback( $post ) {
	echo 'Test metabox';
}
 
function hsc_slider_save_meta_box( $post_id ) {
}
add_action( 'save_post', 'hsc_slider_save_meta_box' );