<?php
/*
*---------------------------------------END--START------------------------------------->
//Extract Custom Data from WooCommerce Session and Insert it into Cart Object

*                 Add extra price :  woocommerce_cart_item_price 
*/

function wpcc_filter_woocommerce_cart_item_price( $wc, $cart_item, $cart_item_key ) { 
	// make filter magic happen here... 

	//print_r($cart_item);
	$product_id = $cart_item['product_id'];
	//$cart_itemCVal = $cart_item['variation']['wpcc_userConfiguratordata'];
	$eperson = $cart_item['variation']['Product-Price'];;
	$currency_symbol = get_woocommerce_currency_symbol();
    $wrap_price = "";

    if($wrap_price!="")
    {
      $wrap_price_thml = ' + '.$currency_symbol.number_format($wrap_price,2);
    }else{
      $wrap_price_thml="";
    }
   
   if($product_id!="" && $eperson!="")
        {     
        	  $extraPrice=$eperson;
              
               //$wcp = $wc.' + '.$currency_symbol. number_format($extraPrice,2).$wrap_price_thml;
               $wcp = $wc.' + '.$extraPrice;
        }else{
           $wcp = $wc;
        } 
        return $wcp; 
}
         
// add the filter 
add_filter( 'woocommerce_cart_item_price', 'wpcc_filter_woocommerce_cart_item_price', 10, 3 ); 

/*------------------------------------- <---START-> ---------------------------------->
*            Check tag is added or not for tag based shipping 
*/

function wpcc_tag_filter_woocommerce_cart_itemprice() { 
    // make filter magic happen here... 
   //D:\xampp\htdocs\paintpup\wp-content\plugins\advanced-flat-rate-shipping-for-woocommerce\admin\class-advanced-flat-rate-shipping-for-woocommerce-admin.php line no 881
   
        foreach( WC()->cart->get_cart() as $cart_item )
        {
          $product_id = $cart_item['product_id'];
          $product_tag = $cart_item['variation']['product_tag'];
        }
        return $product_tag;

}

/*------------------------------------- <-END--START-> ---------------------------------->
*            Change the line total price // Display the line total price
*/
add_filter( 'woocommerce_get_discounted_price', 'wpcc_calculate_discounted_price', 10, 2 );
function wpcc_calculate_discounted_price( $price, $values ) 
{
    // You have all your data on $values;
  
   //  $cartCVal1 = $values['variation']['wpcc_userConfiguratordata'];
   // $optionVal1 = isset($cartCVal1['option']) ? $cartCVal1['option'] : '';

    $product_id = $values['product_id'];
    //$cart_itemCVal = $cart_item['variation']['wpcc_userConfiguratordata'];
    $eperson = $values['variation']['Product-Price'];
    $wrap_price = 0;

     if($product_id!="" && $eperson!="")
        {       $extraPrice=0;
               //$extraPrice = get_extraprice_ofpet_and_person($eperson,$epet,$product_id);
        		$extraPrice = $eperson;

             return $_price_ = $price+$extraPrice+$wrap_price; 
                     
    }else{
               $_price_ = $price;
     }

     return $_price_;
}
add_filter( 'woocommerce_cart_item_subtotal', 'wpcc_display_discounted_price', 10, 2 );
// wc_price => format the price with your own currency
function wpcc_display_discounted_price( $values, $item ) {
    return wc_price( $item[ 'line_total' ] );
}

/*------------------------------------- <-END--START-> ---------------------------------->
                                    woocommerce_cart_subtotal 
*/
function wpcc_update_woocommerce_cart_subtotal( $cart_subtotal, $compound, $obj ){
$coupon_code_my = 'freeweek';
$childqty = 0;
$adultqty = 0;
$cart = WC()->session->get( 'cart' );
foreach ( $cart as $value ) 
{

    $rel_p_id = get_post_meta( $value['product_id'],'product_type_age' , true );
    if($rel_p_id=='child')
    {
    $childProducts[] = $value['product_id'];
    $childqty += $value['quantity'];
    }
}
foreach ( $cart as $value ) 
{

    $rel_p_id = get_post_meta( $value['product_id'],'product_type_age' , true );
    if($rel_p_id=='adult')
    {
        $adultProducts[] = $value['product_id'];
        $adultqty += $value['quantity'];
    }
}

$childProductsTotal = sizeof($childProducts);
$adultProductsTotal = sizeof($adultProducts);
$product = new WC_Product( $childProducts[0] );
$price = $product->price;

$t = 0;

foreach ( $obj->cart_contents as $key => $product ) :

$product_price = $product['line_total'];
$rel_p_id = get_post_meta( $product['product_id'],'product_type_age' , true );
foreach ( WC()->cart->get_coupons( 'order' ) as $code => $coupon ) :

if( $coupon->code == $coupon_code_my && $rel_p_id=='adult' && $childProductsTotal > 0 && $adultqty==$childqty):

$product_price = $price * $product['quantity'];

endif;

endforeach;

$t += $product_price;

endforeach;

if($cart_subtotal==wc_price( $t )){return $cart_subtotal; }else{

//return ( $t > 0 ) ? sprintf( '<s>%s</s> %s', $cart_subtotal, wc_price( $t ) ) : $cart_subtotal ;
 return ( $t > 0 ) ? sprintf( '%s', wc_price( $t ) ) : $cart_subtotal ;
}

}
add_filter( 'woocommerce_cart_subtotal', 'wpcc_update_woocommerce_cart_subtotal', 99, 3 );
/*Woocommerce Cart Section end
*------------------------------------ <-END--START-> ---------------------------------->
*/

//https://wordpress.stackexchange.com/questions/243340/way-to-display-media-library-in-frontend
add_filter( 'ajax_query_attachments_args', 'the_selfimg_filter_media' );
/**
 * This filter insures users only see their own media
 */
function the_selfimg_filter_media( $query ) {
    // admins get to see everything
    if ( ! current_user_can( 'manage_options' ) )
        $query['author'] = get_current_user_id();
    return $query;
}

/*
*------------------------------------ <-END--START-> ---------------------------------->
                    Add Custome data in Order
*/
//add_action('woocommerce_add_order_item_meta','wpcc_add_values_to_order_item_meta',1,2);
if(!function_exists('wpcc_add_values_to_order_item_meta'))
{
  function wpcc_add_values_to_order_item_meta($item_id, $values)
  {
        global $woocommerce,$wpdb;
        if($item_id)
        {
        /*echo '********************Dhanraj********************';
        print_r($values);*/
           /* $cartCVal2 = $values['variation']['wpcc_userConfiguratordata'];

            wc_add_order_item_meta($item_id,'wpcc_userConfiguratordata',$cartCVal2);*/  

            $product_id = $values['product_id'];
            $title = get_the_title($cart_item['product_id']);

            $post_title = 'ordid '.$item_id.' pid '.$product_id.' uid '.get_current_user_id();

            // Create post object
            $my_post = array(
              'post_title'    => wp_strip_all_tags( $post_title ),
              'post_content'  => $title,
              'post_status'   => 'draft',
              'post_type'   => 'create-job',
              'post_author'=>get_current_user_id()
            );
             
            // Insert the post into the database
            $postid = wp_insert_post( $my_post );

            update_post_meta( $postid, 'job_orderid', $item_id );
            update_post_meta( $postid, 'job_customer', get_current_user_id() );
          }
           
  }
}