<?php
function wpum_custom_login()
{
    $msg='';
    //print_r($_POST);
    if($_POST['username']!="") 
    {  
          global $wpdb;  
          //wp_clear_auth_cookie();
          //We shall SQL escape all inputs  
          $username = $wpdb->escape($_REQUEST['username']);  
          $password = $wpdb->escape($_REQUEST['password']);  
          $remember = $wpdb->escape($_REQUEST['rememberme']);  
          $user_obj = get_user_by('login', $username );
          if(!$user_obj)
          {
            $user_obj = get_user_by('email', $username );
          }
   
        $value = get_user_meta($user_obj->ID, 'wpuser_status', true);

        if($value =='inactive' || $value==""){
            //echo "<strong>ERROR</strong>: You need to activate your account. ".$username;//create an error
            $url = home_url('/login/?inact=2');
             echo '<script>window.location.href="'.$url.'"</script>';
          
        }else{    

          if($remember) $remember = "true";  
          else $remember = "false";  

          $login_data = array();  
          $login_data['user_login'] = $username;  
          $login_data['user_password'] = $password;  
          $login_data['remember'] = $remember;  

          $user_verify = wp_signon( $login_data, false );  

          $userID = $user_verify->ID;

          wp_set_current_user( $userID, $username );
          wp_set_auth_cookie( $userID, true, false );
          do_action( 'wp_login', $username ,$password);


          if ( is_wp_error($user_verify) )   
          {  
            $msg= "Invalid login details";  
            // Note, I have created a page called "Error" that is a child of the login page to handle errors. This can be anything, but it seemed a good way to me to handle errors.  
            // echo "<script type='text/javascript'>window.location.href='". home_url() ."'</script>";  
            //exit();  
          }
    }
  }//username
}//custom_login
// run it before the headers and cookies are sent
add_action( 'after_setup_theme', 'wpum_custom_login' );

//----------------------my_users_page_loaded---------------------------------


//----------------------wp_login Redirect---------------------------------

function wpum_login_redirect( $user_login, $user ) {
    // echo "<pre>";
    // print_r($user);
    // exit;
  $roles_arr = array(get_option('wpum_userroles'));
  $wpum_userredirect = get_option('wpum_userredirect');



    if( $user->roles[0] == 'administrator' ) {
        $url = admin_url();
    }/*elseif($user->roles[0] == 'ourpartner' ||  $user->roles[0] == 'interiordesigner') {
                   
        $url = home_url('/profile/');

    }*/else if( in_array($user->roles[0], $roles_arr) && $wpum_userredirect!="NA")
     {

          $url = home_url('/'.$wpum_userredirect);       

    }else{
     //$url = home_url('/login/?loginfail=1'); 
      $r = $_SERVER['HTTP_REFERER'];
     $url = $r; 
    }
    //wp_redirect( $url );
    echo '<script>window.location.href="'.$url.'"</script>';
    exit;   
}
add_action('wp_login', 'wpum_login_redirect', 10, 2);

//----------------------login authenticate---------------------------------

add_filter('authenticate', function($user, $email, $password){
 
    //Check for empty fields
        if(empty($email) || empty ($password)){        
            //create new error object and add errors to it.
            $error = new WP_Error();
 
            if(empty($email)){ //No email
                $error->add('empty_username', __('<strong>ERROR</strong>: Email field is empty.'));
            }
            else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //Invalid Email
                $error->add('invalid_username', __('<strong>ERROR</strong>: Email is invalid.'));
            }
 
            if(empty($password)){ //No password
                $error->add('empty_password', __('<strong>ERROR</strong>: Password field is empty.'));
            }
 
            return $error;
        }
 
        //Check if user exists in WordPress database
       $userS = get_user_by('email', $email);
        if($userS){
          $user = $userS;
        } else
        {
         $user = get_user_by('login', $email); 
        }
 
        //bad email
        if(!$user){
            $error = new WP_Error();
            $error->add('invalid', __('<strong>ERROR</strong>: Either the email or password you entered is invalid.'));
            return $error;
        }
        else{ //check password
            if(!wp_check_password($password, $user->user_pass, $user->ID)){ //bad password
                $error = new WP_Error();
                $error->add('invalid', __('<strong>ERROR</strong>: Either the email or password you entered is invalid.'));
                return $error;
            }else{
                return $user; //passed
            }
        }
}, 20, 3);

/* - ++++++++++++++++++++++++++++++++++++++ +++++++++++++++++++++++++++++++++++++++++++ -*/

add_action( 'after_setup_theme', 'wpum_custom_logout' );
function wpum_custom_logout()
{
    if(isset($_GET['wpum_action'])=='logout')
    {
          wp_logout();

      echo '<script>window.location.href="'.home_url('/login/?logout=successfuly').'"</script>';
      exit;
    }
}

/* - ++++++++++++++++++++++++++++++++++++++ +++++++++++++++++++++++++++++++++++++++++++ -*/

add_action( 'after_setup_theme', 'wpum_useractivation' );
function wpum_useractivation()
{
   global $wpdb;
    //echo $_GET['wpum_token'].'////'.$_GET['id'];
    
    if(isset($_GET['wpum_token'])!='' && $_GET['id']!="" )
    {
         
         $activation_key  = esc_attr( get_user_meta($_GET['id'], 'activation_key', true) );
         $random_hash  =  substr(md5(uniqid(rand(), true)), 16, 16);

         if($_GET['wpum_token']==$activation_key)
         {

          update_user_meta($_GET['id'], 'wpuser_status','active');
          update_user_meta($_GET['id'], 'activation_key', $random_hash);
          echo '<script>window.location.href="'.home_url('/login/?active=true').'"</script>';
          exit;
        }else{
          echo '<script>window.location.href="'.home_url('/login/?active=false').'"</script>';
          exit;
        }
    }
}

/* - ++++++++++++++++++++++++++++++++++++++ +++++++++++++++++++++++++++++++++++++++++++ -*/