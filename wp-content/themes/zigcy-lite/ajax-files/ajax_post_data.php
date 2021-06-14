<?php

require_once('../../../../wp-load.php');

global $wpdb;	  
$user_id = get_current_user_id();
$date = date('Y-m-d H:i:s');
if(isset($_POST['action'])=='crispshop_add_cart')
{
	global $woocommerce, $wpdb;
	$productID =$_POST['product_id'];
	$productPrice =$_POST['product_price'];
	$variationID="";
	$quantity=1;
	$product = wc_get_product( $productID );
		$selected_attrString="";
		$array=array();
		foreach ($_POST['product_attr'] as $key => $value) 
		{
		  # code...
		  //$selected_attrString .=$key."=";
		  foreach ($value as $keys => $values) 
		  {
		    # code...
		    if($values!="")
		    {
		    	 $array[]=array(
				    	'AttributeCode'=>trim($key),
				    	'AttributeValue'=>trim($values)
				    );
		    }
		  
		    //$selected_attrString .=$values."_";
		  }
		    // $selected_attrString = rtrim($selected_attrString,'_');
		    // $selected_attrString .= "&";

		}

		//$selected_attrString = rtrim($selected_attrString,'&');

		$imageAPiURl= "https://image.icarefurnishers.com/api/Image/Getimage?sku=".$product->get_sku().'&attributeJson=';
		
		$encodeData= json_encode($array);
		$my_img = str_replace('"', "'", $imageAPiURl.$encodeData.'&width=100&height=100');

		//$my_img = $imageAPiURl.json_encode(array($selected_attrString)).'&width=100&height=100';
		
		$mypic = '<a href="'.$my_img.'" target="_blank"><img style="width:150px;" class="mypic" data-imdid="'.$productID.'" src="'.$my_img.'"></a>';

		$product_arr[] = $_POST['product_attr'];

		$product_arr['Product-Image'] = $mypic;
		$product_arr['Product-Price'] = $productPrice;
		
		$cartCount =WC()->cart->get_cart_contents_count();
     
     if($woocommerce->cart->get_cart() && $cartCount>0)
     {
           foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) 
           {
                 

                if( ($cart_item_key && $cart_item['product_id'] == $productID))
                   {
                          
                            WC()->cart->set_quantity($cart_item_key,1);

                    }else{
                           WC()->cart->add_to_cart($productID,$quantity,$variationID,$product_arr);
                       //WC()->cart->add_to_cart($prodFrameID,$quantity);
                    }   
          }

    }else{
      //echo '*************';

      WC()->cart->add_to_cart($productID,$quantity,$variationID,$product_arr);
      //WC()->cart->add_to_cart($prodFrameID,$quantity);
    }
                   
      echo '<a href="'.home_url('/cart/').'">View Cart</a>';
      //echo '<script>window.location.href="'.home_url('/cart/').'"</script>'; 
		die;
}

if(isset($_POST['actionremove'])=='RemoveCartData')
{
	global $woocommerce, $wpdb;
	$woocommerce->cart->empty_cart();
	die;
}	

if(isset($_POST['action2'])=='getproductimages')
{
		$selected_attrString="";
		$product_id = $_POST['product_id'];
		// Get $product object from product ID
 		$product = wc_get_product( $product_id );
 		$array=array();

		foreach ($_POST['product_attr'] as $key => $value) 
		{
		  # code...
	
		 
		 foreach ($value as $keys => $values) 
		  {
		    # code...
		    //$selected_attrString .=$values."_";

		    if($key!="pa_size")
              {
		   
		    	 $array[]=array(
				    	'AttributeCode'=>trim($key),
				    	'AttributeValue'=>trim($values)
				    );
			}	   
		   
		   
		  }
		    /*$selected_attrString = rtrim($selected_attrString,'_');
		    $selected_attrString .= "&";*/

		}

		//print_r($array); die;
		
		$encodeData= json_encode($array);
		$imageAPiURl= "https://image.icarefurnishers.com/api/Image/Getimage?sku=".$product->get_sku().'&attributeJson=';
		$selected_attrString = $imageAPiURl.$encodeData.'&width=1000&height=1000';

		//echo $selected_attrString = rtrim($selected_attrString,'&');
		echo $selected_attrString ;
		die;
}

if(isset($_POST['action3'])=='getAttrProductimages')
{
		$selected_attrString="";
		$product_id = $_POST['product_id'];
		// Get $product object from product ID
 		$product = wc_get_product( $product_id );
 		$radioValue  = $_POST['radioValue'];
 		$termkey = $_POST['termkey'];

		$array= array();
		$array['AttributeCode']= trim($termkey);
		$array['AttributeValue'] = trim($radioValue);

 		$encodeData= json_encode($array);
 		
		$imageAPiURl= "https://image.icarefurnishers.com/api/Image/Getimage?sku=".$product->get_sku().'&attributeJson=';
		$selected_attrString = $imageAPiURl.'['.$encodeData.']&width=1000&height=1000';

		//echo $selected_attrString = rtrim($selected_attrString,'&');
		echo $selected_attrString ;
		die;
}
?>