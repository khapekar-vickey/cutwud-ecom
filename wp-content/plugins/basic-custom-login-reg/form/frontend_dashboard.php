<?php
function wpum_userdashboard($atts=null,$content=null)
{
		global $current_user,$wpdb,$username,$firstname,$lastname,$pass1,$email,$pass2;
		get_currentuserinfo();

	if (is_user_logged_in()) 
	{ 
			/****************************Add Html Here********************************/
	?>
	<div class="profilesec">
	<div class="row">
	<div class="col-sm-3">
	<?php
					// Start the Loop.
					//while ( have_posts() ) : the_post();
					$user_ID = get_current_user_id();
											                 
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
				$user_avatar = wp_get_attachment_image_src( $profile_pic, 'thumbnail' );

				}
					
	                     ?>

	                     <?php $user_data = get_user_meta( $current_user->ID);
	            
	                     //echo '<pre>';
	                    //print_r($user_data);
	                    ?>
	                    
	<div class="profileimg"><div class="thumbnail"><img id="wpum-img" src="<?php echo !empty($profile_pic) ? $user_avatar[0] : ''; ?>" style="<?php echo  empty($profile_pic) ? 'display:none;' :'' ?> max-width: 250px; max-height: 250px;" /></div></div> 

	<div class="user-profile-view">
	<h3><?php echo ''. ucwords(get_the_author_meta( 'first_name', $current_user->ID )); ?>  <?php echo ' '. ucwords(get_the_author_meta( 'last_name', $current_user->ID )); ?></h3>     
	</div>
	<?php 
	//endwhile; // End of the loop.
				?>
	<div class="button">            
	<a class="btn btn-primary" href="<?php echo home_url('/edit-profile/'); ?>">Edit Profile</a>
	<a class="btn btn-primary" href="<?php echo home_url('/change-password/'); ?>">Change Password</a>

	<!-- <a class="btn btn-primary" href="<?php echo home_url('/edit-payment-details/'); ?>">Payment Details</a> -->
	</div>
	                 
	</div>
	<div class="col-sm-9">
	<div class="profileright">
	<p><label>Name: </label> <?php echo $first_name.' '.$last_name; ?></p>
	<p><label>Email: </label> <?php echo $email; ?></p>
	<p><label>Mobile No: </label> <?php echo $phoneno; ?></p>
	<p><label>Country: </label> <?php echo get_wpum_country($user_country); ?></p>
	<p><label>State: </label> <?php echo get_wpum_state($user_state); ?></p>
	<p><label>City: </label> <?php echo $user_city; ?></p>
	<p><label>Address: </label> <?php echo $user_address; ?></p>
	<p><label>Zipcode: </label> <?php echo $zipcode; ?></p>

	</div>
	</div>
	</div>
	</div>
	<?php
			/****************************Add Html Above********************************/
	} //endif;
	else{
			//echo do_shortcode('[WPUM_LOGIN title="Login"]');
	}

}

add_filter('widget_text', 'do_shortcode');
add_filter( 'wpum_userdashboard', 'do_shortcode' );
add_shortcode('WPUM_DASHBOARD','wpum_userdashboard');