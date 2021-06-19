<?php

/**
	 Plugin Name: Woocommerce Product Slider
	 Plugin URI: http://wordpress.org/plugins/hello-dolly/
	Description: A Slider plugin to show feature product slider in the website.
	Author: Harmandeep Singh
	Version: 1.0
	Author URI: http://ma.tt/
 */


function hsc_product_slider_shortcode( $atts){
	$atts = shortcode_atts(array( 'feature' => 'true', 'exclude' => ''), $atts);
   
    if($atts['feature'] == true){
        $args = array(
            'post_type'           => 'product',
            'posts_per_page'      => '-1',
            'post__in'            => wc_get_featured_product_ids(),
        );
    }else{
        $args = array(
            'post_type'           => 'product',
            'posts_per_page'      => '-1',
        );
    }
    
    $products = new WP_Query($args);
    $html = '';
    if($products->have_posts()){ 
        $html .= '<div class="hsc-product-slider">';
        while($products->have_posts()){$products->the_post();
            $title = get_the_title(get_the_ID());
            $image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            if(!$image){
                $image = '/wp-content/uploads/woocommerce-placeholder-600x600.png';
            }
            $link = get_the_permalink(get_the_ID());
            $html .= '<div class="product-slide">';
            $html .= '<div class="text-center">';
            $html .= '<a href="'.$link.'"><img src="'.$image.'">';
            $html .= $title.'</a>';
            $html .= '</div>';
            $html .= '</div>';
        }
        $html .= '</div>';
    }
    wp_reset_postdata();
	
	$script = "<script>/** Website Prouct Slider */
    jQuery('.hsc-product-slider').slick({
        dots: true,
        arrows: true,
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1
    });</script>";
    $style = "<!-- Product slider style --><style>
    .hsc-product-slider{
        max-width: 100%;
    }
    .hsc-product-slider .slick-prev:before, .hsc-product-slider .slick-next:before{
        color: #000;
        font-weight: 700;
    }
    .hsc-product-slider .slick-dots{
        right: 0;
        width: auto;
        top: -30px;
    }
    .product-slide{
        padding:0 20px;
        border-right: 1px solid #ccc;
    }
    .hsc-product-slider .slick-prev {
        left: -5px;
    }
    .hsc-product-slider .slick-next {
        right: -5px;
    }
    .hsc-product-slider .product-slide img{
        margin-bottom: 20px;
    }
    </style><!-- End Product slider style -->";
    add_action( 'wp_footer', function() use( $script ){
        echo $script;
    });
    add_action( 'wp_footer', function() use( $style ){
        echo $style;
    });
	return $html;
}
add_shortcode( 'hsc-product-slider', 'hsc_product_slider_shortcode');