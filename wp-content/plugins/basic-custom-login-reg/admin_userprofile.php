<?php
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { 
 wp_enqueue_media();
 wp_enqueue_script('wpumuser_avataruploader');
$user_country = esc_attr( get_the_author_meta( 'user_country', $user->ID ) );
// $user_country   = 230;
$user_state = esc_attr( get_the_author_meta( 'user_state', $user->ID ) );
$user_city= esc_attr( get_the_author_meta( 'user_city', $user->ID ) );

$profile_pic = ($user!=='add-new-user') ? get_user_meta($user->ID, 'wpum_user_avatar', true): false;

    if( !empty($profile_pic) ){
        $image = wp_get_attachment_image_src( $profile_pic, 'thumbnail' );

    }

	?>
<h3><?php _e("User Profile Details", "blank"); ?></h3>

<table class="form-table">

		<tr>
            <th>
                <label for="image"><?php _e('Main Profile Image', 'wpum') ?></label>
            </th>

            <td>
                <input type="button" data-id="wpum_image_id" data-src="wpum-img" class="button wpum-image" name="wpum_image" id="wpum-image" value="Upload" />
                <input type="hidden" class="button" name="wpum_image_id" id="wpum_image_id" value="<?php echo !empty($profile_pic) ? $profile_pic : ''; ?>" />
                <img id="wpum-img" src="<?php echo !empty($profile_pic) ? $image[0] : ''; ?>" style="<?php echo  empty($profile_pic) ? 'display:none;' :'' ?> max-width: 100px; max-height: 100px;" />
            </td>
        </tr>

<tr>
<th><label for="user_phone"><?php _e("Phone"); ?></label></th>
<td>
<input type="text" name="user_phone" id="user_phone" value="<?php echo esc_attr( get_the_author_meta( 'user_phone', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Please enter your phone."); ?></span>
</td>
</tr>
<tr>
<th><label for="user_address"><?php _e("Address"); ?></label></th>
<td>
<input type="text" name="user_address" id="user_address" value="<?php echo esc_attr( get_the_author_meta( 'user_address', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Please enter your address."); ?></span>
</td>
</tr>

<tr>
<th><label for="user_country"><?php _e("Country"); ?></label></th>
<td>
<select name="user_country" id="user_country" class="regular-text" >
<?php get_allcountries($user_country);?>
</select>
<br />
<span class="description"><?php _e("Please enter your country."); ?></span>
</td>
</tr>

<tr>
<th><label for="user_state"><?php _e("State"); ?></label></th>
<td>
<select name="user_state" id="user_state" class="regular-text" >
<?php get_allstates($user_country,$user_state);?>
</select>
<br />
<span class="description"><?php _e("Please enter your state."); ?></span>
</td>
</tr>

<tr>
<th><label for="user_city"><?php _e("City"); ?></label></th>
<td>
<select name="user_city" id="user_city" class="regular-text" >
<?php get_allcities($user_state,$user_city); ?>
</select>
<br />
<span class="description"><?php _e("Please enter your city."); ?></span>
</td>
</tr>

<tr>
<th><label for="user_postcode"><?php _e("Postal Code"); ?></label></th>
<td>
<input type="text" name="user_postcode" id="user_postcode" value="<?php echo esc_attr( get_the_author_meta( 'user_postcode', $user->ID ) ); ?>" class="regular-text" /><br />
<span class="description"><?php _e("Please enter your postal code."); ?></span>
</td>
</tr>
</table>

<?php 
include_once WPUM_ROOT. '/form/countrystate_city_js.php';
}

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {

//if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }

update_user_meta( $user_id, 'user_phone', $_POST['user_phone'] );
update_user_meta( $user_id, 'user_address', $_POST['user_address'] );
update_user_meta( $user_id, 'user_city', $_POST['user_city'] );
update_user_meta( $user_id, 'user_country', $_POST['user_country'] );
update_user_meta( $user_id, 'user_state', $_POST['user_state'] );
update_user_meta( $user_id, 'user_postcode', $_POST['user_postcode'] );

if( current_user_can('edit_users') ){
        $profile_pic = empty($_POST['wpum_image_id']) ? '' : $_POST['wpum_image_id'];
        update_user_meta($user_id, 'wpum_user_avatar', $profile_pic);
    }

}
?>