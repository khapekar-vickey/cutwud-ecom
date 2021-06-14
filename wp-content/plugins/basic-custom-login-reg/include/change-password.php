<?php
//----------------------SET NEW PASSWORD---------------------------------
function wpum_setnewPassword(){
  if(isset($_REQUEST['wpum_setnewPassword'])=="wpum_setnewPassword"){
    global $wpdb; 
    $url = home_url('/change-password/?success=true');

    $user_id        =   isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
    $user_pass      =   isset($_REQUEST['pass1']) ? $_REQUEST['pass1'] : "";
    $userdata['ID'] = $wpdb->escape($user_id);
    $userdata['user_pass'] = $wpdb->escape($user_pass);
    $user_info = get_userdata($user_id);
    $uname= $user_info->user_login;

    wp_update_user( $userdata );
    // print_r($userdata);
    // echo $uname;
    // exit;
    //wp_signon(array('user_login' => $username, 'user_password' => $pass1), false);
    wp_signon(array('user_login' => $uname, 'user_password' => $user_pass), false);

     echo '<script>window.location.href="'.$url.'"</script>';
    exit;
  }
}

add_action( 'after_setup_theme', 'wpum_setnewPassword' );