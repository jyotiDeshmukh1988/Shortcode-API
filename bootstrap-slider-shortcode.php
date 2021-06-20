<?php
function pp_scripts() {
// Registering Bootstrap style
wp_enqueue_style( 'bootstrap_min_css', get_stylesheet_directory_uri().'/assets/css/bootstrap.min.css' );
//wp_enqueue_script('jquery');
//Registering Bootstrap Script
wp_enqueue_script( 'bootstrap_min_js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '', true );
}
add_action( 'wp_enqueue_scripts', 'pp_scripts' );
add_action( 'init', 'custom_bootstrap_slider' );
/**
 * Register a Custom post type for.
 */
function custom_bootstrap_slider() {
	$labels = array(
		'name'               => _x( 'Slider', 'post type general name'),
		'singular_name'      => _x( 'Slide', 'post type singular name'),
		'menu_name'          => _x( 'Bootstrap Slider', 'admin menu'),
		'name_admin_bar'     => _x( 'Slide', 'add new on admin bar'),
		'add_new'            => _x( 'Add New', 'Slide'),
		'add_new_item'       => __( 'Name'),
		'new_item'           => __( 'New Slide'),
		'edit_item'          => __( 'Edit Slide'),
		'view_item'          => __( 'View Slide'),
		'all_items'          => __( 'All Slide'),
		'featured_image'     => __( 'Featured Image', 'text_domain' ),
		'search_items'       => __( 'Search Slide'),
		'parent_item_colon'  => __( 'Parent Slide:'),
		'not_found'          => __( 'No Slide found.'),
		'not_found_in_trash' => __( 'No Slide found in Trash.'),
	);

	$args = array(
		'labels'             => $labels,
		'menu_icon'	     => 'dashicons-star-half',
    	'description'        => __( 'Description.'),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array('title','editor','thumbnail')
	);

	register_post_type( 'slider', $args );
}

if ( ! function_exists('events_shortcode') ) {

    function events_shortcode() {
    	 $slider = get_posts(array('post_type' => 'slider', 'posts_per_page' => 5));
       $imgslide = '<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
	  <li data-target="#myCarousel" data-slide-to="3"></li>
	  <li data-target="#myCarousel" data-slide-to="4"></li>
    </ol>
  <div class="carousel-inner" role="listbox">';
		$count = 0;
		foreach($slider as $slide){
		if ( $count == 0 ) $class .= 'active'; else $class = '';
		$imgslide .= '<div class="item '.$class.'">';
		//$imgslide .= '<div class="item active">';
        $imgslide .= '<img src="'.wp_get_attachment_url( get_post_thumbnail_id($slide->ID)).'"/>';
		$imgslide .= '<div class="carousel-caption"><h3>"'.$slide->post_content.'"</h3></div>';
		$imgslide .= '</div>';
      $count++; 
		}
        $imgslide .= '<a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>';
	$imgslide .= '</div>';
        return $imgslide;
    }
    add_shortcode( 'events', 'events_shortcode' );    
}