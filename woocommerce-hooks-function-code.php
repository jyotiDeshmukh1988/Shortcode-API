<?php
// woocommerce hooks functions
// Display trust badges on checkout page
add_action( 'woocommerce_review_order_after_submit', 'approved_trust_badges' );
function approved_trust_badges() {
echo '<div class="trust-badges" style="text-align:center;margin:0 auto;"><img src="http://localhost/Boilerplate-Plugin-Development/wp-content/uploads/2021/06/trustbadge.jpg"/></div>
<div class="trust-badge-message" style="text-align:center;margin:0 auto;">I added the trust badges above with a WooCommerce hook</div>';
}

// Display payment methods on shopping cart page
add_action( 'woocommerce_after_cart_totals', 'available_payment_methods' );
function available_payment_methods() {
echo '<div class="payment-methods-cart-page" style="text-align:center;margin:0 auto;"><img src="https://img.tpng.net/detail/500x0_398-3987066_payment-methods-png.png"/></div>
<div class="payment-methods-message" style="text-align:center;margin:0 auto;">We accept the following payment methods</div>';
}

/**
* Change "home" to "all products" in Woo breadcrumbs
*/
add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_home_text' );
function wcc_change_breadcrumb_home_text( $defaults ) {
// Change the breadcrumb home text from 'Home' to 'All Products'
$defaults['home'] = 'All Products';
return $defaults;
}

/* @snippet Add next/prev buttons @ WooCommerce Single Product Page */
 
add_action( 'woocommerce_before_single_product', 'bbloomer_prev_next_product' );
 
// and if you also want them at the bottom...
//add_action( 'woocommerce_after_single_product', 'bbloomer_prev_next_product' );
 
function bbloomer_prev_next_product(){ ?>
<style>
 /* CSS */
.prev_next_buttons {
line-height: 40px;
margin-bottom: 20px;
}
.prev_next_buttons a[rel="prev"], .prev_next_buttons a[rel="next"] {
display: block;
}
.prev_next_buttons a[rel="prev"] {
float: right;
}
.prev_next_buttons a[rel="next"] {
float: left;
}
.prev_next_buttons::after {
content: '';
display: block;
clear:both;
}
</style>
<?php 
echo '<div class="prev_next_buttons">';
 
   // 'product_cat' will make sure to return next/prev from current category
        $previous = next_post_link('%link', '&larr; PREVIOUS', TRUE, ' ', 'product_cat');
   $next = previous_post_link('%link', 'NEXT &rarr;', TRUE, ' ', 'product_cat');
 
   echo $previous;
   echo $next;
    
echo '</div>';       
}

/* woocomerce product titles are too long – let’s set a character length limit on the shop page */
// Limit all WooCommerce product titles to max number of words
// Note: this is simple PHP that can be placed in your functions.php file
// Note: substr may give you problems, please check Option 3
add_filter( 'the_title', 'shorten_woo_product_title', 10, 2 );
/*function shorten_woo_product_title( $title, $id ) {
	if ( is_shop() && get_post_type( $id ) === 'product' ) {
	return substr( $title, 0, 30 ); // change last number to the number of characters you want
	} else {
	return $title;
	}
}*/
function shorten_woo_product_title( $title, $id ) {
	if ( is_shop() && get_post_type( $id ) === 'product' ) {
	return wp_trim_words( $title, 5 ); // change last number to the number of WORDS you want
	} else {
	return $title;
	}
}

/* @snippet Remove Product Tabs & Echo Long Description */
  
/*remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_after_single_product_summary', 'bbloomer_wc_output_long_description', 10 );  
function bbloomer_wc_output_long_description() {
?>
   <div class="woocommerce-tabs">
   <h2>Product Description</h2>
   <?php the_content(); ?>
   </div>
<?php
}
*/
/* WooCommerce: Display Product Gallery Vertically (Single Product Page) */
add_filter ( 'woocommerce_product_thumbnails_columns', 'bbloomer_change_gallery_columns' );
function bbloomer_change_gallery_columns() { ?>
<style>
/**
 * @snippet       CSS to Move Gallery Columns @ Single Product Page
 * @sourcecode    https://businessbloomer.com/?p=20518
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 3.5.4
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */ 
/* Make image 75% width to make room to its right */
.single-product div.product .woocommerce-product-gallery .flex-viewport {
    width: 75%;
    float: left;
} 
/* Make Gallery 25% width and place it beside the image */
.single-product div.product .woocommerce-product-gallery .flex-control-thumbs {
    width: 25%;
    float: left;
}
/* Style each Thumbnail with width and margins */
.single-product div.product .woocommerce-product-gallery .flex-control-thumbs li img {
    width: 90%;
    float: none;
    margin: 0 0 10% 10%;
}
</style>	
 <?php    return 1; 
}

/**
 * @snippet       Change No. of Thumbnails per Row @ Product Gallery
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 5.0
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_filter( 'woocommerce_single_product_image_gallery_classes', 'bbloomer_5_columns_product_gallery' );
 
function bbloomer_5_columns_product_gallery( $wrapper_classes ) {?>
<style>
/* Remove default "clear" at position 5, 9, etc. This is for 4 columns */
.woocommerce-product-gallery .flex-control-thumbs li:nth-child(4n+1) {
    clear: none;
}
/* Add new "clear" at position 6, 11, etc. This is for 5 columns */
.woocommerce-product-gallery .flex-control-thumbs li:nth-child(5n+1) {
    clear: left;
}
</style>
   <?php 
   $columns = 2; // change this to 2, 3, 5, etc. Default is 4.
   $wrapper_classes[2] = 'woocommerce-product-gallery--columns-' . absint( $columns );
   return $wrapper_classes;
}

/**
 * @snippet       Display RRP/MSRP @ WooCommerce Single Product Page
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WC 4.6
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 Url - https://www.businessbloomer.com/woocommerce-display-rrp-msrp-manufacturer-price/
 */
  
// -----------------------------------------
// 1. Add RRP field input @ product edit page
  
add_action( 'woocommerce_product_options_pricing', 'bbloomer_add_RRP_to_products' );      
  
function bbloomer_add_RRP_to_products() {          
    woocommerce_wp_text_input( array( 
        'id' => 'rrp', 
        'class' => 'short wc_input_price', 
        'label' => __( 'RRP', 'woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
        'data_type' => 'price', 
    ));      
}
  
// -----------------------------------------
// 2. Save RRP field via custom field
  
add_action( 'save_post_product', 'bbloomer_save_RRP' );
  
function bbloomer_save_RRP( $product_id ) {
    global $pagenow, $typenow;
    if ( 'post.php' !== $pagenow || 'product' !== $typenow ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( isset( $_POST['rrp'] ) ) {
        update_post_meta( $product_id, 'rrp', $_POST['rrp'] );
    }
}
 
// -----------------------------------------
// 3. Display RRP field @ single product page
  
add_action( 'woocommerce_single_product_summary', 'bbloomer_display_RRP', 9 );
  
function bbloomer_display_RRP() {
    global $product;
    if ( $product->get_type() <> 'variable' && $rrp = get_post_meta( $product->get_id(), 'rrp', true ) ) {
        echo '<div class="woocommerce_rrp">';
        _e( 'RRP: ', 'woocommerce' );
        echo '<span>' . wc_price( $rrp ) . '</span>';
        echo '</div>';
    }
}

/**
 * @snippet       Add Custom Field to Product Variations - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 4.6
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 Url - https://www.businessbloomer.com/woocommerce-add-custom-field-product-variation/
 */
 
// -----------------------------------------
// 1. Add custom field input @ Product Data > Variations > Single Variation
 
add_action( 'woocommerce_variation_options_pricing', 'bbloomer_add_custom_field_to_variations', 10, 3 );
 
function bbloomer_add_custom_field_to_variations( $loop, $variation_data, $variation ) {
   woocommerce_wp_text_input( array(
'id' => 'custom_field[' . $loop . ']',
'class' => 'short',
'label' => __( 'RRP', 'woocommerce' ),
'value' => get_post_meta( $variation->ID, 'custom_field', true )
   ) );
}
 
// -----------------------------------------
// 2. Save custom field on product variation save
 
add_action( 'woocommerce_save_product_variation', 'bbloomer_save_custom_field_variations', 10, 2 );
 
function bbloomer_save_custom_field_variations( $variation_id, $i ) {
   $custom_field = $_POST['custom_field'][$i];
   if ( isset( $custom_field ) ) update_post_meta( $variation_id, 'custom_field', esc_attr( $custom_field ) );
}
 
// -----------------------------------------
// 3. Store custom field value into variation data
 
add_filter( 'woocommerce_available_variation', 'bbloomer_add_custom_field_variation_data' );
 
function bbloomer_add_custom_field_variation_data( $variations ) {
   $variations['custom_field'] = '<div class="woocommerce_custom_field">RRP : <span>' . get_post_meta( $variations[ 'variation_id' ], 'custom_field', true ) . '</span></div>';
   return $variations;
}

/**
 * @snippet       Get Related Products by Same Title @ WooCommerce Single
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 3.8
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 Url - https://www.businessbloomer.com/woocommerce-custom-related-products/
 */
 
add_filter( 'woocommerce_related_products', 'bbloomer_related_products_by_same_title', 9999, 3 ); 
 
function bbloomer_related_products_by_same_title( $related_posts, $product_id, $args ) {
   $product = wc_get_product( $product_id );
   $title = $product->get_name();
   //echo $product."=>".$title;
   $related_posts = get_posts( array(
      'post_type' => 'product',
      'post_status' => 'publish',
      'title' => $title,
      'fields' => 'ids',
      'posts_per_page' => -1,
      'exclude' => array( $product_id ),
   ));
   //print_r($related_posts);
   return $related_posts;
}

/**
* @snippet       Add an HTML Symbol to the Add to Cart Buttons - WooCommerce
* @how-to        Get CustomizeWoo.com FREE
* @sourcecode    https://businessbloomer.com/?p=73212
* @author        Rodolfo Melogli
* @testedwith    WooCommerce 3.5.1
* @donate $9     https://businessbloomer.com/bloomer-armada/
Url - https://www.businessbloomer.com/woocommerce-add-icon-add-cart-buttons/
*/
 
add_filter( 'woocommerce_product_single_add_to_cart_text', 'bbloomer_add_symbol_add_cart_button_single' );
 
function bbloomer_add_symbol_add_cart_button_single( $button ) {
$button_new = '&raquo; ' . $button;
return $button_new;
}

/**
 * @snippet       Checkbox to hide Related Products - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 3.5.7
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 Url - https://www.businessbloomer.com/woocommerce-checkbox-to-disable-related-products-conditionally/
 */
  
// -----------------------------------------
// 1. Add new checkbox product edit page
  
add_action( 'woocommerce_product_options_general_product_data', 'bbloomer_add_related_checkbox_products' );        
  
function bbloomer_add_related_checkbox_products() {           
woocommerce_wp_checkbox( array( 
   'id' => 'hide_related', 
   'class' => '', 
   'label' => 'Hide Related Products'
   ) 
);      
}
  
// -----------------------------------------
// 2. Save checkbox into custom field
  
add_action( 'save_post_product', 'bbloomer_save_related_checkbox_products' );
  
function bbloomer_save_related_checkbox_products( $product_id ) {
   global $pagenow, $typenow;
   if ( 'post.php' !== $pagenow || 'product' !== $typenow ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( isset( $_POST['hide_related'] ) ) {
      update_post_meta( $product_id, 'hide_related', $_POST['hide_related'] );
    } else delete_post_meta( $product_id, 'hide_related' );
}
  
// -----------------------------------------
// 3. Hide related products @ single product page
  
add_action( 'woocommerce_after_single_product_summary', 'bbloomer_hide_related_checkbox_products', 1 );
  
function bbloomer_hide_related_checkbox_products() {
    global $product;
    if ( ! empty ( get_post_meta( $product->get_id(), 'hide_related', true ) ) ) {
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    }
}

/**
 * @snippet       Add "Quantity" Label in front of Add to Cart Button - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @sourcecode    https://businessbloomer.com/?p=21986
 * @author        Rodolfo Melogli
 * @testedwith    WC 3.5.1
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 Url - https://www.businessbloomer.com/woocommerce-add-quantity-label-front-add-cart-button/
 */
 
add_action( 'woocommerce_before_add_to_cart_quantity', 'bbloomer_echo_qty_front_add_cart' );
 
function bbloomer_echo_qty_front_add_cart() {
 echo '<div class="qty">Quantity: </div>'; ?>
 <style>
 div.qty {
    float: left;
    padding: 10px;
}
 </style>
 <?php
}

/**
WooCommerce: Product Enquiry Form @ Single Product Page (CF7)
 * @snippet       Show CF7 Form @ WooCommerce Single Product
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WC 5
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 url - https://www.businessbloomer.com/woocommerce-show-inquiry-form-single-product-page-cf7/
 */
  
add_action( 'woocommerce_after_add_to_cart_form', 'bbloomer_woocommerce_cf7_single_product', 30 );
  
function bbloomer_woocommerce_cf7_single_product() {
   echo '<button type="submit" id="trigger_cf" class="single_add_to_cart_button button alt">Product Inquiry</button>';
   echo '<div id="product_inq" style="display:none">';
   echo do_shortcode('[contact-form-7 id="67" title="Contact form 1"]');
   echo '</div>';
   wc_enqueue_js( "
      $('#trigger_cf').on('click', function(){
         if ( $(this).text() == 'Product Inquiry' ) {
            $('#product_inq').css('display','block');
            $('input[name=\'your-subject\']').val('" . the_title() . "');
            $('#trigger_cf').html('Close');
         } else {
            $('#product_inq').hide();
            $('#trigger_cf').html('Product Inquiry');
         }
      });
   " );
}

/**
* @snippet       Change "Add to Cart" Button Label if Product Already @ Cart
* @how-to        Get CustomizeWoo.com FREE
* @author        Rodolfo Melogli
* @compatible    WC 5.0
* @donate $9     https://businessbloomer.com/bloomer-armada/
Url - https://www.businessbloomer.com/woocommerce-rename-add-to-cart-button-if-product-already-cart/
*/
 
// Part 1
// Single Product Page Add to Cart
 
add_filter( 'woocommerce_product_single_add_to_cart_text', 'bbloomer_custom_add_cart_button_single_product', 9999 );
 
function bbloomer_custom_add_cart_button_single_product( $label ) {
   if ( WC()->cart && ! WC()->cart->is_empty() ) {
      foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {
         $product = $values['data'];
         if ( get_the_ID() == $product->get_id() ) {
            $label = 'Already in Cart. Add again?';
            break;
         }
      }
   }
   return $label;
}
 
// Part 2
// Loop Pages Add to Cart
 
add_filter( 'woocommerce_product_add_to_cart_text', 'bbloomer_custom_add_cart_button_loop', 9999, 2 );
 
function bbloomer_custom_add_cart_button_loop( $label, $product ) {
   if ( $product->get_type() == 'simple' && $product->is_purchasable() && $product->is_in_stock() ) {
      if ( WC()->cart && ! WC()->cart->is_empty() ) {
         foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {
            $_product = $values['data'];
            if ( get_the_ID() == $_product->get_id() ) {
               $label = 'Already in Cart. Add again?';
               break;
            }
         }
      }
   }
   return $label;
}

/**
 * @snippet       Checkbox to display Custom Product Badge Part 1 - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @source        https://businessbloomer.com/?p=17419
 * @author        Rodolfo Melogli
 * @compatible    Woo 3.5.3
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
// First, let's remove related products from their original position
 
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
 
// Second, let's add a new tab
 
add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
 
function woo_new_product_tab( $tabs ) {
    
$tabs['related_products'] = array(
   'title'    => __( 'Try it with', 'woocommerce' ),
   'priority'    => 50,
   'callback'    => 'woo_new_product_tab_content'
);
   return $tabs;
}
 
// Third, let's put the related products inside
 
function woo_new_product_tab_content() {
woocommerce_output_related_products();
}
