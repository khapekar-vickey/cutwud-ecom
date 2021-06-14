<?php
//======================Order SMS====================
function process_ordermessages($data_arr)
    {
        global $woocommerce,$post;
        $username = "info@icarefurnishers.com";
        $hash = "e8320ca87aef8c2475d2d940d88f4854c13962600f962e3104fc1cf443b23c10";
        $apiKey = urlencode('1Zilr7YwMkg-6IeKWxhi1ldsGmf8MAdPZvW4G4o0Lc');
        $case = $data_arr['action'];
        $order = new WC_Order( $data_arr['order_id']);
        $items = $order->get_items();
        foreach ( $items as $item ) {
            $ProductName = $item['name'];
            $product_id = $item['product_id'];
            $product_variation_id = $item['variation_id'];
            // Get an instance of corresponding the WC_Product object
            $product = $item->get_product();
            $product_name = $product->get_name(); // Get the product name

            $item_quantity = $item->get_quantity(); // Get the item quantity

            $OrderAmount = $item->get_total(); // Get the item line total
        }
        //$OrderAmount=123;

        switch ($case) {
             case "send_orderstatus":
                
                //$mobile_number = trim($_POST['mobile_number']);
                $mobile_number = trim($data_arr['mobile_number']);
                $order_id = trim($data_arr['order_id']);
                $ord_status = trim($data_arr['ord_status']);
                
                
                $Textlocal = new Textlocal(false, false, $apiKey);
                //$Textlocal = new Textlocal('info@icarefurnishers.com', 'Ss@202923');
                                
                $numbers = array($mobile_number);
                $sender = 'ICRFUR';
                //$message = "Your One Time Password is " ;
                if($ord_status=="placed")
                {
                  $message = "Order Placed: Your order for ".$ProductName." with order id: ".$order_id." amounting to ".$OrderAmount." has been received. We will send you an update when your order is packed /shipped. https://tx.gl/r/1n4m1/#AdvdTrack#";
                }elseif($ord_status=="processing")
                {
                  $DelivaryDate = date('dd MM yy');
                  $message = "Packed/Shipped: Your Order ".$order_id." has been shipped and will be delivered by ".$DelivaryDate.". you will be received another SMS when the Wishmaster from Icarefurnishers will deliver it. Track your order https://tx.gl/r/1n4m1/#AdvdTrack#";
                }elseif ($ord_status=="completed") {
                  # code...
                  $info = $order_id;
                  $info .= " ".$ProductName;
                  $message = "Delivered: ".$info." was delivered. Click here to give feedback: https://tx.gl/r/1n4sa/#AdvdTrack#";
                }
                

                //========================================End
                
                try{
                    return $response = $Textlocal->sendSms($numbers, $message, $sender);
                    //require_once ("verification-form.php");
                    //exit();
                }catch(Exception $e){
                    die('Error: '.$e->getMessage());
                }
                break;
        }
    }

/*Send text message after admin change order status*/
add_action( 'woocommerce_order_status_changed', 'dk_woocommerce_order_status_changed_action', 10, 3 );
function dk_woocommerce_order_status_changed_action( $order_id, $old_status, $new_status ) 
{
      global $woocommerce,$post;
      $current_user = wp_get_current_user();
      $uid = $current_user->ID;
      $uname = $current_user->user_firstname;
      $order = new WC_Order( $order_id );
      //$order = wc_get_order( $order_id );
      $payment_method = $order->get_payment_method();
      $ord_status = $order->status;
        
    // Get the user ID from WC_Order methods
    $user_id = $order->get_user_id(); // or $order->get_customer_id();
    //$user_id = get_post_meta($order_id, '_customer_user', true);
    //$order->status
    $user_phone = get_user_meta($user_id, "user_phone", true);
    
    //dk_sendorder_status($user_phone,$order_id,$ord_status);
    $data_arr=array();
    $data_arr=array(
                  "mobile_number" => $user_phone,
                  "order_id" => $order_id,
                  "ord_status" => $ord_status,
                  "action" => "send_orderstatus"
            );

    process_ordermessages($data_arr);

}//dk_woocommerce_order_status_changed_action

add_action('woocommerce_checkout_order_processed', 'dk_sendsms_afterorder_placed', 10, 1);

function dk_sendsms_afterorder_placed($order_id)
{
      global $woocommerce,$post;
      $current_user = wp_get_current_user();
      $uid = $current_user->ID;
      $uname = $current_user->user_firstname;
      $order = new WC_Order( $order_id );
      $ord_status = $order->status;
        
    // Get the user ID from WC_Order methods
    $user_id = $order->get_user_id(); // or $order->get_customer_id();
    //$user_id = get_post_meta($order_id, '_customer_user', true);
    //$order->status
    $user_phone = get_user_meta($user_id, "user_phone", true);
    
    //dk_sendorder_status($user_phone,$order_id,$ord_status);

    $data_arr=array();
    $data_arr=array(
                  "mobile_number" => $user_phone,
                  "order_id" => $order_id,
                  "ord_status" => $ord_status,
                  "action" => "send_orderstatus"
            );

    process_ordermessages($data_arr);
}
//https://stackoverflow.com/questions/42530626/getting-order-data-after-successful-checkout-hook
//======================Order SMS==================== end