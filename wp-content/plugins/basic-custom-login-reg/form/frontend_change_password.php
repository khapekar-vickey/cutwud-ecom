<?php
function wpum_changePassword($atts=null,$content=null)
{
    wp_enqueue_style('wpum_registrationform-style');
    wp_enqueue_script('wpum_jquerymin-js');
    //wp_enqueue_script('wpum_libjquery-js');
   wp_enqueue_script('wpum_jquery.validatejs');

    global $wpdb,$current_user,$wpdb,$username,$firstname,$lastname,$pass1,$email,$pass2;
    ob_start();
    $formheading    = $atts['title'];
    $wpum_userid    = $current_user->ID;
    ?>
        <div class="loginregistration">
            <div class="login">
                <h1><?php echo $formheading ?></h1>
                <?php if(isset($_GET['success'])=='true'){
            echo '<div class="alert alert-success" style="margin: 10px 0 20px;">Your changes has been successfully saved.</div>';
            } ?>
                <div class="inner-page edit-profile">
    <div class="changepass">
      
   
    <form method="post" action="" name="wpumregister_form" id="wpumregister_form" >
    <input type="hidden" name="user_id" value="<?php echo $wpum_userid; ?>">
    <input type="hidden" name="wpum_setnewPassword" value="wpum_setnewPassword">
    
        <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="pass1">New Password
                                <span class="starvalid"> *</span>
                            </label>
                            <input type="password" name="pass1" id="pass1" class="form-control" minlength="8"  required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="pass2">Confirm Password
                                <span class="starvalid"> *</span>
                            </label>
                            <input type="password" id="pass2" name="pass2" class="form-control" minlength="8" required>
                        </div>
                    </div>
        </div>
        <div class="submit-box col-sm-12">
                <input type="submit" name="submit" class="btn btn-primary" value="Update"/> 
        </div>
    </form>

</div>
</div>
<?php 
wp_enqueue_script('wpum_formvalidationjs');
        wp_reset_postdata();
        return ob_get_clean();

} 

add_filter('widget_text', 'do_shortcode');
add_filter( 'wpum_changePassword', 'do_shortcode' );
add_shortcode('WPUM_CAHNGEPASSWORD','wpum_changePassword');