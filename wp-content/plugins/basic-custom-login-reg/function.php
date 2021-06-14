<?php
/*require_once dirname( __FILE__ ) . '/includes/countrystate_city_js.php';
require_once dirname( __FILE__ ) . '/includes/countrystate_city.php';*/
function wpum_featured_media_uploader($atts=array(), $content=null) {
	
	global $wpdb,$post;
	$noImageUrl = '../wp-content/plugins/upload_media/noimage.png';
	$post_id = $atts[0];
		// Save attachment ID
		$featuredImg_src = wp_get_attachment_image_src( get_post_meta($post_id, '_thumbnail_id', true), 'thumbnail' );
			$featuredImgsrc = $featuredImg_src ? $featuredImg_src[0] : $noImageUrl;
		if($post_id!="")
		{
			$_thumbnail_id 	= get_post_meta($post_id, '_thumbnail_id', true);
			$_thumbnail_url	= get_post_meta($post_id, '_thumbnail_url', true);
		}
		
		wp_enqueue_media();
		//include_once(WPUM_ROOT.'/js/ulpoad-media_js.php');
		wp_enqueue_script('wpum_uploadmedia-js');
		wp_enqueue_style('wpum_uploadmedia-style');
		

		?>	<div id='wpumimage-preview-wrapper'>
				<div class="wpum_imagepreviewBox">
				<img id='wpum_imagepreview' src='<?php echo $featuredImgsrc; ?>' height='70px'>
				<a href="javascript:void(0)" class="Removewpumicon"><i class="fa fa-times">X</i></a>
				</div>
			
			<input type='hidden' name='wpum_thumbnail_id' required="required" id='wpum_thumbnail_id' value='<?php echo $_thumbnail_id; ?>'>
			<input type='hidden' name='wpum_thumbnail_url' id='wpum_thumbnail_url' value='<?php echo $_thumbnail_URL; ?>'>
			<p>
			<input id="wpumupload_image_button" type="button" class="button" value="<?php _e( 'Upload' ); ?>" />
			</p>
			</div>
		<?php

	}
add_filter('widget_text', 'do_shortcode');
add_filter( 'wpum_featured_media_uploader', 'do_shortcode' );
add_shortcode('WPMM-UPLOADEDIA','wpum_featured_media_uploader');

/*
*--------------------------------------------------------------------------------->
*/
if(isset($_POST['wpum_settingaction'])=="wpumsettingspage")
{

if ( get_option('wpum_imagetype') !== false) {

            // The option already exists, so we just update it.
            update_option( 'wpum_imagetype', $_POST['wpum_imagetype'] );
            update_option( 'wpum_width', $_POST['wpum_width'] );
            update_option( 'wpum_height', $_POST['wpum_height'] );
            update_option( 'wpum_gsitekey', $_POST['wpum_gsitekey'] );
            update_option( 'wpum_userroles', $_POST['wpum_userroles'] );
            update_option( 'wpum_userredirect', $_POST['wpum_userredirect'] );

        } else {

            // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
            $deprecated = null;
            $autoload = 'no';
            add_option( 'wpum_imagetype', 'png,jpg,jpeg', $deprecated, $autoload );
            add_option( 'wpum_width', 50, $deprecated, $autoload );
            add_option( 'wpum_height', 50, $deprecated, $autoload );
            add_option( 'wpum_gsitekey', '', $deprecated, $autoload );
            add_option( 'wpum_userroles', '', $deprecated, $autoload );
            add_option( 'wpum_userredirect', 'my-account', $deprecated, $autoload );
        }

        echo '<script>window.location.herf="wp-admin/options-general.php?page=wpum-setting"</script>';
}

	if ( get_option('wpum_imagetype')=="") 
	{

		// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
		$deprecated = null;
		$autoload = 'no';
		add_option( 'wpum_imagetype', "'png',' jpg',' jpeg','gif'", $deprecated, $autoload );
		add_option( 'wpum_width', 50, $deprecated, $autoload );
		add_option( 'wpum_height', 50, $deprecated, $autoload );
	}
/*
*-----------------------------Add all Pages---------------------------------------------------->
*/
function wpum_doTransaction($key,$value)
		{
			switch($key) {
							case 'Login':
							wpum_createpage($key,$value);
							break;
							case 'Registration':
							wpum_createpage($key,$value);
							break;
							case 'Edit Profile':
							wpum_createpage($key,$value);
							break;
							case 'Profile':
							wpum_createpage($key,$value);
							break;
							case 'Lost Password':
							wpum_createpage($key,$value);
							break;
							case 'Change Password':
							wpum_createpage($key,$value);
							break;
							case 'Dashboard':
							wpum_createpage($key,$value);
							break;
						}
		}


		function wpum_createpage($keys,$values)
		{		$pageID='';
				$pageID = get_posts( array( 'name' => $keys,'post_type' => 'page'));

			   if($pageID[0]->ID=="")
			   { //$pageID is not existes

						$post_id = wp_insert_post(array (
							'post_type' 	=> 'page',
							'post_title' 	=> $keys,
							'post_name' 	=> $keys,
							'post_status' 	=> 'publish',
							'post_content' 	=> $values,
							'comment_status' => 'closed',   // if you prefer
							'ping_status' 	=> 'closed',      // if you prefer
						));

			    }//$pageID is not existes

		}

function wpum_createdefault_pages()
{
		$array = array(
			"Login" 			=> '[WPUM_LOGIN title="Login"]',
			"Registration" 		=> '[WPUM_NEWUSER_REGISTRATION uid="" userrole="" title="Registration" redirect_slug="login"]',
			"Edit Profile" 		=> '[WPUM_EDIT_USERPROFILE title="Edit Profile" redirect_slug="dashboard"]',
			"Profile" 			=> '[WPUM_LOGIN title=""][WPUM_DASHBOARD title="DASHBOARD"]',
			"Lost Password" 	=> '[WPUM-loastandreste_password]',
			"Change Password" 	=> '[WPUM_CAHNGEPASSWORD title="Change Password"]',
			"Dashboard" 		=> '[WPUM_DASHBOARD title="DASHBOARD"][WPUM_LOGIN title=""]'
		);
		
		foreach($array as $key => $value) {
				wpum_doTransaction($key,$value);
		}

		

}

add_action('after_setup_theme', 'wpum_createdefault_pages');



  /*
*--------------------------------------------------------------------------------->
*/