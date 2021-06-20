<?php
/**
 * Plugin Name: Shortcode API Plugin
 * Description: How to use the shortcode api in wordpress
 * Author: Jyoti Deshmukh
 */

function testshortcode(){
	return "jyoti";
}
add_shortcode("testshort","testshortcode");

function mycaption_shortcode($atts,$content=null){
	return "<span class='headline'>'".$content."'</span>";	
}
add_shortcode("mycaption","mycaption_shortcode");

/**
 * [current_year] returns the Current Year as a 4-digit string.
 * @return string Current Year
*/
function getcurrentyear($atts,$content=null){
	return getdate()["year"];
}
add_shortcode("currentyear","getcurrentyear");

/**
 * [cta_button] returns the HTML code for a CTA Button.
 * @return string Button HTML Code
*/
add_shortcode( 'cta_button', 'salcodes_cta' );
function salcodes_cta($atts){
	$a = shortcode_atts(array(
	"link" => "#",
	"id" => "salcodes",
	"color" => "blue",
	"class" => "search-submit",
	"size" => "",
	"label" => "button",
	"target" => "_self"
	),$atts);
	$output = '<p><a href="'.esc_attr($a['link']).'" class="'.esc_attr($a['class']).'" id="'.esc_attr($a['id']).'" target="'.esc_attr($a['target']).'">'. esc_attr($a['label']).'</a></p>';
	return $output;
}
/**
 * [boxed] returns the HTML code for a content box with colored titles.
 * @return string HTML code for boxed content
*/
add_shortcode("boxed","salcodes_boxed");
function salcodes_boxed($atts, $content=null,$tag=''){
	$a = shortcode_atts(array(
	"title" => "Title",
	"title_color" => "White",
	"color" => "blue"
	),$atts);
	$output = '<div class="salcodes-boxed" style="border:2px solid ' . esc_attr( $a['color'] ) . ';">'.'<div class="salcodes-boxed-title" style="background-color:' . esc_attr( $a['color'] ) . ';"><h3 style="color:' . esc_attr( $a['title_color'] ) . ';">' . esc_attr( $a['title'] ) . '</h3></div>'.'<div class="salcodes-boxed-content"><p>' . esc_attr( $content ) . '</p></div>'.'</div>';
	return $output;
}
/** Enqueuing the Stylesheet for the CTA Button */

function salcodes_enqueue_scripts() {
 global $post;
 $has_shortcode = has_shortcode( $post->post_content, 'cta_button') || has_shortcode( $post->post_content, 'boxed');
 if( is_a( $post, 'WP_Post' ) && $has_shortcode) {
 wp_register_style( 'salcodes-stylesheet',  plugin_dir_url( __FILE__ ) . 'css/style.css' );
     wp_enqueue_style( 'salcodes-stylesheet' );
 }
}
add_action( 'wp_enqueue_scripts', 'salcodes_enqueue_scripts');



/**
we will display a Google AdSense banner inside a shortcode.
**/
// The shortcode function
function wpb_demo_shortcode_2() { 
 
// Advertisement code pasted inside a variable
$string .= '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-format="fluid"
     data-ad-layout="in-article"
     data-ad-client="ca-pub-0123456789101112"
     data-ad-slot="9876543210"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>';
 
// Ad code returned
return $string; 
}
// Register shortcode
add_shortcode('my_ad_code', 'wpb_demo_shortcode_2'); 

function recent_posts_function($atts){
   $a = shortcode_atts(array(
      'posts' => 1,
   ), $atts);
   $return_string = '<ul>';
   query_posts(array('orderby' => 'date', 'order' => 'DESC' , 'showposts' => $a['posts']));
   if (have_posts()) :
      while (have_posts()) : the_post();
         $return_string .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
      endwhile;
   endif;
   $return_string .= '</ul>';

   wp_reset_query();
   return $return_string;
}
add_shortcode("recentpost","recent_posts_function");
?>
