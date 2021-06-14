<?php
      wp_enqueue_script('wpum_jquerymin-js');
    //wp_enqueue_script('wpum_libjquery-js');
    wp_enqueue_script('wpum_jquery.validatejs');
?>
<div class="loginregistration">
<div id="password-lost-form" class="widecolumn">
           <h3><?php _e( 'Forgot Your Password?', 'personalize-login' ); ?></h3>
       <p>
        <?php
            _e(
                "Enter your email address and we'll send you a link you can use to pick a new password.",
                'personalize_login'
            );
        ?>
    </p>
 
    <form id="lostpasswordform" action="" method="post">
        <p class="form-row">
        <input type="hidden" id="wplostpassword_url" value="<?php echo wp_lostpassword_url(); ?>">
            <label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?></label>
            <input type="text" name="user_login" id="user_login" required="required">
        </p>
 
        <p class="lostpassword-submit">
            <input type="submit" name="submit" class="lostpassword-button"
                   value="<?php _e( 'Reset Password', 'personalize-login' ); ?>"/>
        </p>
    </form>
</div>
</div>
<?php
    wp_enqueue_script('wpum_formvalidationjs');