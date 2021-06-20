<?php
if(!function_exists('hsc_blog_page')){
	function hsc_blog_page( $atts ){
		$atts = shortcode_atts(array('items' => '5'), $atts);
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$args = array( 'post_type' => 'post', 'paged' => $paged, 'posts_per_page' => $atts['items']);
		$blog = new WP_Query( $args );
        if($blog->have_posts()){           
			$html = '<div class="blog">';
			while($blog->have_posts()){ 
			    $blog->the_post();
				$classA = get_post_class(get_the_ID());
				$class = implode(' ', $classA);
				$featureImg = get_the_post_thumbnail(get_the_ID(), 'full');
				$feature = get_the_post_thumbnail_url(get_the_ID(), "full");
				$title = get_the_title( get_the_ID() );
				$content = wp_trim_words(get_the_content(), '45');
				$date = get_the_date('d');
				$dateFull = get_the_date('M Y');
				$link = get_the_permalink(get_the_ID());
				$terms = get_the_terms( get_the_ID(),'category' );
				$author= get_the_author_meta('display_name'); 
				$html .= '<article  class="'.$class.' blog_page">';
				$html .= '<div class="blog_title">';
				$html .= '<h4>'.$title.'</h4>';
                $html .= '<div class="author_name"><i class="fa fa-universal-access" aria-hidden="true"></i>Tool Talk</div>';
				$html .= '<div class="post-content"><div class="entry-meta"><i class="fa fa-calendar" aria-hidden="true"></i><span class="date">'.$date.'</span> <span class="month">'.$dateFull.'</span></div>';			
				$html .= '</div>';
				$html .= '<div class="row blog_text">';
                $html .= '<div class="col-md-12">';			
			    $html .= '<div class="col-md-3 blog_img">';
				$html .= '<div class="blog_image">'.$featureImg.'</div>';
			    $html .= '</div>';	
			    $html .= '<div class="col-md-9 blog_img_content">';

				$html .= '<div class="post-body">';
				
				$html .= '<div class="content">'.$content.'</div>';
				$html .= '<div class="read-more link"><a href="'.$link.'" class="button btn btn-primary">Read More</a></div>';
				$html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
				$html .= '</article>';
			
			
			}
        }
		$html .= '</div>';
		$big = 999999999;
		$html .= paginate_links( array(
  'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
  'format' => '?paged=%#%',
  'current' => max( 1, get_query_var('paged') ),
  'total' => $blog->max_num_pages
) );
        return $html;

	}
		
}
add_shortcode( 'blog', 'hsc_blog_page' );