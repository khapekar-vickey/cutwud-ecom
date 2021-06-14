<?php
add_shortcode( 'wpum-password-lostform','wpumrender_password_lost_form');
/**
*https://code.tutsplus.com/tutorials/build-a-custom-wordpress-user-flow-part-3-password-reset--cms-23811
 * A shortcode for rendering the form used to initiate the password reset.
 *
 * @param  array   $attributes  Shortcode attributes.
 * @param  string  $content     The text content for shortcode. Not used.
 *
 * @return string  The shortcode output
 */
function wpumrender_password_lost_form( $attributes, $content = null ) {
    // Parse shortcode attributes
    $default_attributes = array( 'show_title' => false );
    $attributes = shortcode_atts( $default_attributes, $attributes );
 
    if ( is_user_logged_in() ) {
        return __( 'You are already signed in.', 'personalize-login' );
    } else {
        include WPUM_ROOT. '/form/password_lost_form.php';
    }
}

/*          Send Password Reste Request Email to user
*/
add_filter( 'retrieve_password_message','replace_retrieve_password_message', 10, 4 );
/**
 * Returns the message body for the password reset mail.
 * Called through the retrieve_password_message filter.
 *
 * @param string  $message    Default mail message.
 * @param string  $key        The activation key.
 * @param string  $user_login The username for the user.
 * @param WP_User $user_data  WP_User object.
 *
 * @return string   The mail message to send.
 */
function replace_retrieve_password_message( $message, $key, $user_login, $user_data ) {
    // Create new message
    $msg  = __( 'Hello!', 'personalize-login' ) . "\r\n\r\n";
    $msg .= sprintf( __( 'You asked us to reset your password for your account using the email address %s.', 'personalize-login' ), $user_login ) . "\r\n\r\n";
    $msg .= __( "If this was a mistake, or you didn't ask for a password reset, just ignore this email and nothing will happen.", 'personalize-login' ) . "\r\n\r\n";
    $msg .= __( 'To reset your password, visit the following address:', 'personalize-login' ) . "\r\n\r\n";
    $msg .= site_url( "lost-password/?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n\r\n";
    $msg .= __( 'Thanks!', 'personalize-login' ) . "\r\n";
 
    return $msg;
}

add_shortcode( 'wpum-password-reset-form', 'wpumrender_password_reset_form'  );

/**
 * A shortcode for rendering the form used to reset a user's password.
 *
 * @param  array   $attributes  Shortcode attributes.
 * @param  string  $content     The text content for shortcode. Not used.
 *
 * @return string  The shortcode output
 */
function wpumrender_password_reset_form( $attributes, $content = null ) {
    // Parse shortcode attributes
    $default_attributes = array( 'show_title' => false );
    $attributes = shortcode_atts( $default_attributes, $attributes );
 
    if ( is_user_logged_in() ) {
        return __( 'You are already signed in.', 'personalize-login' );
    } else {
        if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
            $attributes['login'] = $_REQUEST['login'];
            $attributes['key'] = $_REQUEST['key'];
 
            // Error messages
            $errors = array();
            if ( isset( $_REQUEST['error'] ) ) {
                $error_codes = explode( ',', $_REQUEST['error'] );
 
                foreach ( $error_codes as $code ) {
                    $errors []= $this->get_error_message( $code );
                }
            }
            $attributes['errors'] = $errors;
            include WPUM_ROOT. '/form/password_reset_form.php';
        } else {
            return __( 'Invalid password reset link.', 'personalize-login' );
        }
    }
}

add_action( 'login_form_rp', 'do_password_reset'  );
add_action( 'login_form_resetpass', 'do_password_reset' );

/**
 * Resets the user's password if the password reset form was submitted.
 */
function do_password_reset() {
    if ( isset($_POST['wpumresetpassform_url'])!="" ) {

        $rp_key = $_POST['rp_key'];
        $rp_login = $_POST['rp_login'];
 
        $user = check_password_reset_key( $rp_key, $rp_login );
 
        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
                wp_redirect( home_url( 'login?login=expiredkey' ) );
            } else {
                wp_redirect( home_url( 'login?login=invalidkey' ) );
            }
            exit;
        }
 
        if ( isset( $_POST['pass1'] ) ) {
            /*if ( $_POST['pass1'] != $_POST['pass2'] ) {
                // Passwords don't match
                $redirect_url = home_url( 'member-password-reset' );
 
                $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );
 
                wp_redirect( $redirect_url );
                exit;
            }
 
            if ( empty( $_POST['pass1'] ) ) {
                // Password is empty
                $redirect_url = home_url( 'member-password-reset' );
 
                $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );
 
                wp_redirect( $redirect_url );
                exit;
            }*/
 
            // Parameter checks OK, reset password
            reset_password( $user, $_POST['pass1'] );

            //wp_redirect( home_url( 'login?password=changed' ) );
            echo 'Success';
             wp_die();
        } else {
            echo "Invalid request.";
             wp_die();
        }
 
        exit;
    }
}

/* ---------------------- Lost password and Reset password ------------------- */
function wpum_loastandreste_password()
{
		if(isset($_GET['action'])=='rp' && $_GET['key'] !="" && $_GET['login'] !="")
		{
			echo do_shortcode('[wpum-password-reset-form]');
		}else{
			echo do_shortcode('[wpum-password-lostform]');
		}
}

add_shortcode( 'WPUM-loastandreste_password', 'wpum_loastandreste_password');