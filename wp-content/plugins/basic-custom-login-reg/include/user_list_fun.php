<?php
function new_modify_user_table( $column ) {
    $column['wpuser_status'] = 'Status';
    //$column['xyz'] = 'XYZ';
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table' );
/*
*---------------------------------------------------------------------------------->
*/
function new_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'wpuser_status' :
            return get_the_author_meta( 'wpuser_status', $user_id );
            break;
        case 'xyz' :
            return '';
            break;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );
/*
*---------------------------------------------------------------------------------->
*/

function wcsbulk_useractivation($redirect_to, $doaction, $user_ids)
{
	//$user_ids = $_REQUEST['users'];
	
	if($_REQUEST['action']!=-1)
	{
		$useraction = $_REQUEST['action'];
	}else if($_REQUEST['action2']!=-1)
	{
		$useraction = $_REQUEST['action2'];
	}else{
		$useraction ='';
	}

	if($useraction=="active" || $useraction =="inactive"){

				foreach ( $user_ids as $user_id ) 
				{
					$wpuserstatus = get_user_meta($user_id, 'wpuser_status',true);
					if($wpuserstatus != $useraction)
					{
						//echo $user_id.'--'.$useraction;
						update_user_meta( $user_id, 'wpuser_status', $useraction );
						$user = new WP_User( $user_id );

						//------------Mail send To User 
						$email = $user->user->email;
						$subj = 'Greetings!! Welcome to '.get_bloginfo('name');   
						$body = '<html><body><p>Hello '.$user->user->display_name.',<br/><br/> Welcome to Swanky. Please click on the below link to login your account:
						<div><a href='.home_url('/login/').'>Login</a></div><br/><br/>
						Please login with your credentials to explore more on Swanky.<br/><br/> 
						We would love to chat. Just hit our contact form to get in touch with feedback, questions, or ideas for us!<br/><br/>Have an awesome day!<br/>
						Regards,<br>'.get_bloginfo('name').' Team  </body></html></p>';

						$headers ='';
						$headers .= 'From:'.get_bloginfo('name').' <info@'.$_SERVER['HTTP_HOST'].">\r\n" .'Reply-To: noreply@'.$_SERVER['HTTP_HOST']. "\r\n" .'MIME-Version: 1.0' . "\r\n".'Content-type: text/html; charset=iso-8859-1' . "\r\n".'X-Mailer: PHP/' . phpversion();

						wp_mail($email,$subj,$body,$headers);
            		}

			    }

			    wp_redirect($redirect_to);
	}
	return $redirect_to;
}
add_filter( 'handle_bulk_actions-users', 'wcsbulk_useractivation', 10, 3 );

/*
*----------------------- -------------admin_footer---------------------------------
*/

//add_action('admin_footer', 'my_user_del_button');

add_action( 'admin_footer-users.php', 'umu_user_action_button' );
add_action( 'admin_action_black_list', 'umu_user_action_button' );

function umu_user_action_button() {
    $screen = get_current_screen();
    if ( $screen->id == "users" ){   // Only add to users.php page
        //return;
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
          $('<option>').val('active').text('<?php _e( 'Active', 'upload_media' )?>').appendTo("select[name='action']");
          $('<option>').val('active').text('<?php _e( 'Active', 'upload_media' )?>').appendTo("select[name='action2']");

          $('<option>').val('inactive').text('<?php _e( 'Inactive', 'upload_media' )?>').appendTo("select[name='action']");
          $('<option>').val('inactive').text('<?php _e( 'Inactive', 'upload_media' )?>').appendTo("select[name='action2']");
        });
      </script>
    <?php
  }
}

/*
*----------------------- ------------- ------------------------>
*/