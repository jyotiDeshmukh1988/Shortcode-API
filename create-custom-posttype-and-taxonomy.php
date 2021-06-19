<?php
// custom post type and taxonomy code
/*
* Creating a function to create our CPT
*/
 
function custom_post_type() {
 
// Set UI labels for Custom Post Type
    $labels_books = array(
        'name'                => _x( 'Books', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'Book', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'Books', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent Book', 'twentytwenty' ),
        'all_items'           => __( 'All Books', 'twentytwenty' ),
        'view_item'           => __( 'View Book', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New Book', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Edit Book', 'twentytwenty' ),
        'update_item'         => __( 'Update Book', 'twentytwenty' ),
        'search_items'        => __( 'Search Book', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );
     
// Set other options for Custom Post Type
     
    $args_book = array(
        'label'               => __( 'Books', 'twentytwenty' ),
        'description'         => __( 'Book news and reviews', 'twentytwenty' ),
        'labels'              => $labels_books,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'topics','subjects' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
 
    );
     
    // Registering your Custom Post Type
    register_post_type( 'Books', $args_book );
	
	$labels_subject = array(
    'name' => _x( 'Subjects', 'taxonomy general name' ),
    'singular_name' => _x( 'Subject', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Subjects' ),
    'all_items' => __( 'All Subjects' ),
    'parent_item' => __( 'Parent Subject' ),
    'parent_item_colon' => __( 'Parent Subject:' ),
    'edit_item' => __( 'Edit Subject' ), 
    'update_item' => __( 'Update Subject' ),
    'add_new_item' => __( 'Add New Subject' ),
    'new_item_name' => __( 'New Subject Name' ),
    'menu_name' => __( 'Subjects' ),
  );    
 
	// Now register the taxonomy subjects
	// Add new taxonomy, make it hierarchical like categories
	//first do the translations part for GUI
	  register_taxonomy('subjects',array('books'), array(
		'hierarchical' => true,
		'labels' => $labels_subject,
		'show_ui' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'subject' ),
	  ));
	  
	  $labels_topics = array(
    'name' => _x( 'Topics', 'taxonomy general name' ),
    'singular_name' => _x( 'Topic', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Topics' ),
    'popular_items' => __( 'Popular Topics' ),
    'all_items' => __( 'All Topics' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Topic' ), 
    'update_item' => __( 'Update Topic' ),
    'add_new_item' => __( 'Add New Topic' ),
    'new_item_name' => __( 'New Topic Name' ),
    'separate_items_with_commas' => __( 'Separate topics with commas' ),
    'add_or_remove_items' => __( 'Add or remove topics' ),
    'choose_from_most_used' => __( 'Choose from the most used topics' ),
    'menu_name' => __( 'Topics' ),
  ); 
	 
	// Now register the non-hierarchical taxonomy like tag for topics
	 
	  register_taxonomy('topics','books',array(
		'hierarchical' => false,
		'labels' => $labels_topics,
		'show_ui' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'topic' ),
	  ));
 
}
 
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'custom_post_type', 0 );