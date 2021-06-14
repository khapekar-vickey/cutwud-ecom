<?php
/*
*----------------------- -------------User Registration Form ------------------------>
*/
function wpumnewsuer_editprofileForm($atts=null,$content=null)
{
	wp_enqueue_style('wpum_registrationform-style');
    wp_enqueue_script('wpum_jquerymin-js');
    //wp_enqueue_script('wpum_libjquery-js');
    wp_enqueue_script('wpum_jquery.validatejs');
    wp_enqueue_media();
    wp_enqueue_script('wpumuser_avataruploader');

    global $wpdb,$current_user,$username,$firstname,$lastname,$pass1,$email,$pass2;
    ob_start();
    $_userid        = $atts['uid'];
    $wpum_userid	= $current_user->ID;
    $formheading    = $atts['title'];
    //$userrole       = $atts['userrole'];
    $wpum_redirect_slug = $atts['redirect_slug'];
    $userrole       = $current_user->roles[0];
    get_currentuserinfo();

//print_r($current_user);
    if($wpum_userid!="")
    {
        $user_country   = esc_attr( get_the_author_meta( 'user_country', $current_user->ID ) );
         $user_country   = isset($user_country)? $user_country : 230;
        $user_state     = esc_attr( get_the_author_meta( 'user_state', $current_user->ID ) );
        $user_city      = esc_attr( get_the_author_meta( 'user_city', $current_user->ID ) );
        $first_name     = esc_attr( get_the_author_meta( 'first_name', $current_user->ID ) );
        $last_name      = esc_attr( get_the_author_meta( 'last_name', $current_user->ID ) );
        $user_login     = esc_attr( get_the_author_meta( 'user_login', $current_user->ID ) );
        $email          = esc_attr( get_the_author_meta( 'user_email', $current_user->ID ) );
        $phoneno        = esc_attr( get_the_author_meta( 'user_phone', $current_user->ID ) );
        $user_address   = esc_attr( get_the_author_meta( 'user_address', $current_user->ID ) );
        $zipcode        = esc_attr( get_the_author_meta( 'user_postcode', $current_user->ID ) );

        $profile_pic = ($user!=='add-new-user') ? get_user_meta($current_user->ID, 'wpum_user_avatar', true): false;

    if( !empty($profile_pic) ){
        $image = wp_get_attachment_image_src( $profile_pic, 'thumbnail' );

    }


        $siteKey        = get_option('wpum_gsitekey');
        $buttonname="Update";
    }else{
      $user_country = $user_state = $user_city="";
      $first_name= $last_name=$user_login=$email=$phoneno=$user_address=$zipcode="";
      $buttonname="Submit";
    }
    

    if (is_user_logged_in()) { ?>
       <div class="loginregistration reg-log">
        <div class="login">
                    <?php  echo do_shortcode('[WPUM_WELCOMEUSER]');?>
            <h1><?php echo $formheading; ?></h1>
            <form action="" method="post" id="wpum_editprofile" name="wpum_editprofile">
			<input type="hidden" name="wpum_action" value="wpum_updateprofile">
            <input type="hidden" name="userrole" value="<?php echo $userrole;?>">
			<input type="hidden" name="wpum_userid" value="<?php echo $wpum_userid; ?>">
            <input type="hidden" name="wpum_redirect_slug" value="<?php echo $wpum_redirect_slug; ?>">
            
			
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="firstname">First Name
                                <span class="starvalid"> *</span>
                            </label>
                            <input name="first_name" id="first_name" class="form-control"
                                   pattern="[a-zA-Z][a-zA-Z ]*" value="<?php echo $first_name; ?>" readonly="readonly" required>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="last_name">Last Name
                                <span class="starvalid"> *</span>
                            </label>
                            <input name="last_name" id="last_name" class="form-control"
                                   pattern="^[a-zA-Z0-9]+$"
                                   value="<?php echo $last_name; ?>" readonly="readonly" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="user_login">User Name
                                <span class="starvalid"> *</span>
                            </label>
                            <input name="user_login" id="user_login" class="form-control"
                                   value="<?php echo $user_login; ?>" readonly="readonly" required>
                        </div>
                    </div>


                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="email">Email Address<span class="starvalid"> *</span></label>
                            <input type="email"  name="user_email" value="<?php echo $email; ?>"   id="user_email" class="form-control" required >
                            <div id="check-email"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="pass1">Password
                                <span class="starvalid"></span>
                            </label>
                            <input type="password" name="pass1" id="pass1" class="form-control" length="[6, 15]" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="phoneno">Phone Number</label>
                            <input type="text" id="phoneno" name="phoneno"
                                   class="form-control"
                                   value="<?php echo $phoneno; ?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="b-address">Address</label>
                        <input type="text" id="user_address" name="user_address"
                               class="form-control" value="<?php echo $user_address; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                        <label for="user_country">Country
                                <span class="starvalid"> *</span>
                            </label>
                    <select required="required" name="user_country" id="user_country" class="regular-text" >
                    <?php get_allcountries($user_country);?>
                    </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                        <label for="user_state">State
                                <span class="starvalid"> *</span>
                            </label>
                        <select required="required" name="user_state" id="user_state" class="regular-text" >
                        <?php get_allstates($user_country,$user_state);?>
                        </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                         <label for="pass2">City
                                <span class="starvalid"> *</span>
                            </label>
                            <select required="required" name="user_city" id="user_city" class="regular-text" >
                            <?php get_allcities($user_state,$user_city); ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                   
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="zipcode">Zip Code</label>
                            <input type="text" id="zipcode" name="zipcode" length="[3, 8]" class="form-control" value="<?php echo $zipcode; ?>" title="Please enter between 3-8 alphanumeric Zipcode." >
                        </div>
                    </div>
               

               
                   
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="zipcode">Profile Image</label>
                   
                    <input type="hidden" class="button" name="wpum_image_id" id="wpum_image_id" value="<?php echo !empty($profile_pic) ? $profile_pic : ''; ?>" />
                    <img id="wpum-img" src="<?php echo !empty($profile_pic) ? $image[0] : ''; ?>" style="<?php echo  empty($profile_pic) ? 'display:none;' :'' ?> max-width: 100px; max-height: 100px;" />
                    <p>
                     <input type="button" data-id="wpum_image_id" data-src="wpum-img" class="button wpum-image" name="wpum_image" id="wpum-image" value="Upload" />
                     </p>
                        </div>
                    </div>
            </div>

                
                <div class="submit">
   
                    <input type="submit" id="wpum_submit"  name="wpum_submit" class="btn btn-primary" value="<?php echo $buttonname;?>"/>
                </div>

            </form>
        </div>
    </div>

    
    <?php
    	include_once WPUM_ROOT. '/form/countrystate_city_js.php';
        wp_enqueue_script('wpum_formvalidationjs');
        wp_reset_postdata();
        return ob_get_clean();
    } //endif;
    else{
       echo do_shortcode('[WPUM_LOGIN title="Login"]');
    }
  
}
add_filter('widget_text', 'do_shortcode');
add_filter( 'wpumnewsuer_editprofileForm', 'do_shortcode' );
add_shortcode('WPUM_EDIT_USERPROFILE','wpumnewsuer_editprofileForm');
/*
*----------------------- -------------END User Registration Form ------------------------>
*/