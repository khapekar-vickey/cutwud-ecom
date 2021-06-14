<?php
        wp_enqueue_script('wpum_jquerymin-js');
        // wp_enqueue_script('wpum_libjquery-js');
        wp_enqueue_script('wpum_jquery.validatejs');
?>
<div class="loginregistration">
<div id="password-reset-form" class="widecolumn">
   
        <h3><?php _e( 'Pick a New Password', 'personalize-login' ); ?></h3>
   
 
    <form name="wpumresetpassform" id="wpumresetpassform" action="" method="post" autocomplete="off">
    <input type="hidden" name="wpumresetpassform_url" id="wpumresetpassform_url" value="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" />
        <input type="hidden" id="user_login" name="rp_login" value="<?php echo esc_attr( $attributes['login'] ); ?>" autocomplete="off" />
        <input type="hidden" name="rp_key" value="<?php echo esc_attr( $attributes['key'] ); ?>" />
         
        <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
            <?php foreach ( $attributes['errors'] as $error ) : ?>
                <p>
                    <?php echo $error; ?>
                </p>
            <?php endforeach; ?>
        <?php endif; ?>
 
        <p>
            <label for="pass1"><?php _e( 'New password', 'personalize-login' ) ?></label>
            <input type="password" required="required" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" />
        </p>
        <p>
            <label for="pass2"><?php _e( 'Repeat new password', 'personalize-login' ) ?></label>
            <input type="password" required="required" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" />
        </p>
         
        <p class="description"><?php echo wp_get_password_hint(); ?></p>
         
        <p class="resetpass-submit">
            <input type="submit" name="submit" id="resetpass-button"
                   class="button" value="<?php _e( 'Reset Password', 'personalize-login' ); ?>" />
        </p>
    </form>
</div>
</div>
<?php
    wp_enqueue_script('wpum_formvalidationjs');