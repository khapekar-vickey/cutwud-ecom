<?php
function wpum_loginFrom($atts=null,$content=null)
{
    wp_enqueue_style('wpum_registrationform-style');
    if (!is_user_logged_in() )
    {
        wp_enqueue_script('wpum_jquerymin-js');
        //wp_enqueue_script('wpum_libjquery-js');
        wp_enqueue_script('wpum_jquery.validatejs');
    }

    global $wpdb,$current_user,$wpdb,$username,$firstname,$lastname,$pass1,$email,$pass2;
    ob_start();
    $formheading    = $atts['title'];

     if (is_user_logged_in() ){
        //wp_redirect("/login/");
        /*echo '<script>window.location.href="'.home_url().'"</script>';
    exit;*/
        }
    ?>
        

        <div class="loginregistration_">
            <div class="login_">
                <!-- <h1><?php //echo $formheading ?></h1> -->
                <?php
if($_GET['reg']=='success')
        {
            echo '<div class="alert alert-success" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.str_replace('?login=failed','','Succesfully Registered, Please login using your username and password.').'</div>';
        }
        elseif($_REQUEST['active'] == "true")
        {
            echo '<div class="alert alert-success" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Your account has been activated successfully, please login below.</div>';
        }
        elseif($_REQUEST['active'] == "false")
        {
            echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Warning!</strong> Error in account activation.</div>';
        }

        if(isset($_GET['inact'])==2){
           echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Warning!</strong> Your account is not activated.Please activate it.</div>';
        }


        if(isset($_GET['loginfail'])==1){
        echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Warning!</strong> Invalid login details.</div>';
        }

         if (!is_user_logged_in()) {
                ?>
                <form action="" method="post" name="wpum_login" id="wpum_login" autocomplete="off" >
                    <input type="hidden" name="wpum_loginaction" value="wpum_loginaction"/>
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="form-group">
                            <label for="username">Username/Email<span class="starvalid"> *</span></label>
                                <input value="" class="form-control" id="username" name="username" type="text" required>
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="form-group">
                            <label for="password">Password <span class="starvalid">* </span></label><input value="" class="form-control" name="password" id="password" type="password" required> </div>
                        </div>
                    </div>
                    <div class="submit">
                            <span class="checkbox reg">
                            <input type="checkbox" value="forever" name="rememberme"> Remember Me | <a href="<?php echo wp_lostpassword_url();?>">Forgot password?</a>
                            </span>
                        <input type="submit" name="next" class="btn btn-primary" value="Submit"/>
                        <span class="checkbox">
                    <div><br>Don't have an account? Please 
                        <!-- <a href="<?php echo get_bloginfo('url');?>/registration/"> --><a href="javascript:void(0)" class="signupboxtop">register</a> here.</div>
                    </span>
                    </div>

                </form>
                <?php
                    }else{
                            echo do_shortcode('[WPUM_WELCOMEUSER]');
                    }
                ?>
            </div>
        </div>
       
<?php 

wp_enqueue_script('wpum_formvalidationjs');
        wp_reset_postdata();
        return ob_get_clean();

} 

add_filter('widget_text', 'do_shortcode');
add_filter( 'wpum_loginFrom', 'do_shortcode' );
add_shortcode('WPUM_LOGIN','wpum_loginFrom');



function wpum_welcomeuser()
{
    ?>
    <span class="welcome-logout" style="float: right; top: 5px;"> 
            <?php
                if (is_user_logged_in()) {
                $user = wp_get_current_user();
                echo 'Welcome <strong><a href="'.home_url().'" >'.$user->display_name.'</a></strong>
                | <a  href="'.home_url('/login/').'?wpum_action=logout">Logout</a>';
                } else { ?>
                <strong><?php echo '<a  href="'.home_url('/login/').'">Login</a>'
                //wp_loginout(); ?></strong>
                or <a href="<?php bloginfo('url') ?>/registration"> <strong>Register</strong></a>
                <?php }
            ?> 
        </span>
    <?php
}

add_filter( 'wpum_welcomeuser', 'do_shortcode' );
add_shortcode('WPUM_WELCOMEUSER','wpum_welcomeuser');