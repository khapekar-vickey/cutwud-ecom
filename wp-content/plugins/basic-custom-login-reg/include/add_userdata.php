<?php
//---------------------------Create new user--------------------------------
function wpum_createUsers(){

    if(isset($_POST['wpum_action'])=="wpum_addnewuser" && $_POST['wpum_action']!="wpum_updateprofile")
    {
      
       //print_r($_REQUEST);
      // exit;
        $first_name   =  isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : "";
        $last_name   =  isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : "";
        $username     =  isset($_REQUEST['user_login']) ? $_REQUEST['user_login'] : "";
        $email        =  isset($_REQUEST['user_email']) ? $_REQUEST['user_email'] : "";
        $pass         =  isset($_REQUEST['pass1']) ? $_REQUEST['pass1'] : "";
        $userrole         =  isset($_REQUEST['userrole']) ? $_REQUEST['userrole'] : "";
        $profile_pic = empty($_POST['wpum_image_id']) ? '' : $_POST['wpum_image_id'];


        $random_hash  =  substr(md5(uniqid(rand(), true)), 16, 16);

        $user_city   =  isset($_REQUEST['user_city']) ? $_REQUEST['user_city'] : "";
        $user_address   =  isset($_REQUEST['user_address']) ? $_REQUEST['user_address'] : "";
        $user_state   =  isset($_REQUEST['user_state']) ? $_REQUEST['user_state'] : "";
        $user_country   =  isset($_REQUEST['user_country']) ? $_REQUEST['user_country'] : "";

        $phoneno      =  isset($_REQUEST['phoneno']) ? $_REQUEST['phoneno'] : "";
        $zipcode     =  isset($_REQUEST['zipcode']) ? $_REQUEST['zipcode'] : "";
        $redirect_slug     =  isset($_REQUEST['wpum_redirect_slug']) ? $_REQUEST['wpum_redirect_slug'] : "";
        
       
        $userdata = array(
                        'user_login'  =>  $username,
                        'user_email'  =>  $email,
                        'first_name'  =>  $first_name,
                        'last_name' =>    $last_name,
                        'user_pass'   =>  $pass,
                        'display_name'=>  $first_name,                
                        'role' => $userrole
              );
        
        $userid   = username_exists($username);


        if ($userid=="" && email_exists($email) == "" ) {
            $user_id = wp_insert_user( $userdata );


            update_user_meta( $user_id, 'user_phone', $phoneno );
            update_user_meta( $user_id, 'user_address', $user_address );
            update_user_meta( $user_id, 'user_city', $user_city );
            update_user_meta( $user_id, 'user_country', $user_country );
            update_user_meta( $user_id, 'user_state', $user_state );
            update_user_meta( $user_id, 'user_postcode', $zipcode );
            update_user_meta($user_id, 'wpum_user_avatar', $profile_pic);

            //update_user_meta($user_id, 'wpuser_status','inactive');
            update_user_meta($user_id, 'wpuser_status','active');
            update_user_meta($user_id, 'activation_key', $random_hash);

            $activationLink =  get_site_url() . '/login/?wpum_token=' . $random_hash . "&id=" . $user_id;

            //------------Mail send To User 
                $email = $email;

              if($userrole=='volunteer')
              {
                  include_once('usermail.php');
                   echo '<script>window.location.href="'.home_url('/'.$redirect_slug.'/?reg=success').'"</script>';
              }else{
                  //include_once('spe-usermail.php');
                  include_once('usermail.php');
                   echo '<script>window.location.href="'.home_url('/'.$redirect_slug.'/?user_id='.$user_id.'&reg=success').'"</script>';
              }
                
               /* echo '<script>window.location.href="'.home_url('/'.$redirect_slug.'/?reg=success').'"</script>';*/
        }else{
                echo '<script>window.location.href="'.home_url('/'.$redirect_slug.'/?ermsg=notreg').'"</script>';
        }
    }
}

add_action( 'init', 'wpum_createUsers');
/*
*----------------------- ------------- ------------------------>
*/

function wpum_update_Profile()
{
	if(isset($_POST['wpum_action'])=="wpum_updateprofile" && $_POST['wpum_action'] !="wpum_addnewuser")
	{
	     /* print_r($_POST);
          exit;*/
	
      $first_name   =  isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : "";
      $last_name   =  isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : "";
      $username     =  isset($_REQUEST['user_login']) ? $_REQUEST['user_login'] : "";
      $email        =  isset($_REQUEST['user_email']) ? $_REQUEST['user_email'] : "";
      $pass         =  isset($_REQUEST['pass1']) ? $_REQUEST['pass1'] : "";
      $userrole    =  isset($_REQUEST['userrole']) ? $_REQUEST['userrole'] : "";
      $redirect    =  isset($_REQUEST['wpum_redirect_slug']) ? $_REQUEST['wpum_redirect_slug'] : "";
      $profile_pic = empty($_POST['wpum_image_id']) ? '' : $_POST['wpum_image_id'];

      $random_hash  =  substr(md5(uniqid(rand(), true)), 16, 16);

      $user_city   =  isset($_REQUEST['user_city']) ? $_REQUEST['user_city'] : "";
      $user_address   =  isset($_REQUEST['user_address']) ? $_REQUEST['user_address'] : "";
      $user_state   =  isset($_REQUEST['user_state']) ? $_REQUEST['user_state'] : "";
      $user_country   =  isset($_REQUEST['user_country']) ? $_REQUEST['user_country'] : "";

      $phoneno      =  isset($_REQUEST['phoneno']) ? $_REQUEST['phoneno'] : "";
      $zipcode     =  isset($_REQUEST['zipcode']) ? $_REQUEST['zipcode'] : "";
      $userid = isset($_POST['wpum_userid']) ? $_POST['wpum_userid'] : "";

	          $userdata = array(
                       // 'user_login'  =>  $username,
                        'user_email'  =>  $email,
                        'first_name'  =>  $first_name,
                        'last_name' =>    $last_name,
                        'display_name'=>  $first_name
              );

	            if($pass1 !=""){
	                              $userdata['user_pass'] .=$pass;
	                          }


	             $userdata['ID'] .= $userid;

	                        //print_r($userdata);
	                        $user_id = wp_update_user($userdata);

					update_user_meta( $user_id, 'user_phone', $phoneno );
					update_user_meta( $user_id, 'user_address', $user_address );
					update_user_meta( $user_id, 'user_city', $user_city );
					update_user_meta( $user_id, 'user_country', $user_country );
					update_user_meta( $user_id, 'user_state', $user_state );
					update_user_meta( $user_id, 'user_postcode', $zipcode );
          update_user_meta($user_id, 'wpum_user_avatar', $profile_pic);
	                  
                       echo '<script>window.location.href="'.home_url('/'.$redirect.'/?success=true').'"</script>';
                      /*if($userrole=='customer')
                      {
	                       //wp_redirect(home_url('/profile/?success=true'));
                           echo '<script>window.location.href="'.home_url('/step-1/?edit=').'"</script>';
                      }else{
                        echo '<script>window.location.href="'.home_url('/step/?edit=').'"</script>';
                      }*/
	     
	   
	  //-------------------------------------------
	}
}
add_action( 'init', 'wpum_update_Profile' );

/*
*------------------------------------------------------------------------------
*/

//--------------------------------Captcha Validation------------------------------------------------

 // remember user input if validation fails
      function getValue($fieldName) {
        $value = '';
        if (isset($_REQUEST[$fieldName])) { 
          $value = $_REQUEST[$fieldName];
        }
        return $value;
      }
      
      // server-side validation status helper function
      function getValidationStatus($fieldName) {
        // validation status param, e.g. "NameValid" from "Name"
        $requestParam = $fieldName . 'Valid';
        if ((isset($_REQUEST[$requestParam]) && $_REQUEST[$requestParam] == 0)) {
          // server-side field validation failed, show error indicator
          $messageHtml = "<label class='incorrect' for='{$fieldName}'>*</label>";
        } else {
          // server-side field validation passed, no message shown
          $messageHtml = '';
        }
        return $messageHtml;
      }
//--------------------------------Captcha Validation End ---------------------------------------------