<?php
add_action( 'admin_menu', 'register_media_uploader_settings_page' );

function register_media_uploader_settings_page() 
	{
		add_submenu_page( 'options-general.php', 'WPUM Setting', 'WPUM Setting', 'manage_options', 'wpum-setting', 'media_uploader_settings_page_callback' );

	}

	function media_uploader_settings_page_callback() 
	{
		wp_enqueue_script('wpum_setting-js');
		wp_enqueue_style('wpum_uploadmedia-style');

		?>
	
		
		<form name="media_uploader" id="media_uploader" acction="" method="post" class="wpum_settingspage">
		<input class="btn btn-primary open1" type="submit" value="Submit" name="submit" style="float:right; margin-right: 50px; margin-top:20px; border: 3px solid #458592; padding: 3px; border-radius: 2px; z-index: 9;font-size: 17px;">
		<h2>Featured Image Setting :</h2>
		
		<input type="hidden" name="wpum_settingaction" value="wpumsettingspage">
			<div id="sf12" class="frm">
			<table width="100%">
				<tr>
				<td>Image Type <span style="color:#F00">* </span></td>
				<td><input type="text" required="required" name="wpum_imagetype" value="<?php echo get_option('wpum_imagetype');?>"></td>
				</tr>
				<tr>
					<td> Width : <span style="color:#F00">* </span></<td>
					<td><input type="number" required="required" value="<?php echo get_option('wpum_width');?>" min="50" step="10" max="1000" value="50" name="wpum_width"></td>
				</tr>
				<tr>
					<td>Height : <span style="color:#F00">* </span></td>
					<td><input type="number" required="required" value="<?php echo get_option('wpum_height');?>" min="50" step="10" max="1000" value="50" name="wpum_height"></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
		</table>
			<h2>General Setting :</h2>

		<table width="100%">
			<tr>
				<td>Google Captcha Key<span style="color:#F00">* </span></td>
				<td><input type="text" required="required" name="wpum_gsitekey" value="<?php echo get_option('wpum_gsitekey');?>"></td>
			</tr>

			<tr>
				<td>Add User Roles<span style="color:#F00">* </span></td>
				<td><input type="text" placeholder="Ex. ourpartner,interiordesigner" required="required" name="wpum_userroles" value="<?php echo get_option('wpum_userroles');?>"> </td>
			</tr>
			<tr>
				<td>User Redirect to<span style="color:#F00">* </span></td>
				<td><input type="text" placeholder="Ex. my-account" required="required" name="wpum_userredirect" value="<?php echo get_option('wpum_userredirect');?>"></td>
			</tr>
		</table>
		
			</div>
				<input class="btn btn-primary open1" type="submit" value="Submit" name="submit" style="float:right; margin-right: 50px; border: 3px solid #458592; padding: 3px; border-radius: 2px; z-index: 9;font-size: 17px;">
				<div class="clear"></div>
		</form>
		
		<hr>
		<hr>

		<?php
		//settings page
echo "<div class='wpum_settingspage'><h4>Use Shortcode</h4>
Upload
<input id='wpumcopyshortcode' readonly='readonly' value='[WPMM-UPLOADEDIA]'>
Edit Image :
<input id='wpumcopyshortcode1' readonly='readonly' value='[WPMM-UPLOADEDIA POST_ID]'>
<h3>Add this code in your custom post data save function.</h3>";
echo '<textarea readonly="readonly" id="wpumcopydata" >
$_thumbnail_id = isset($_POST["wpum_thumbnail_id"]) ? $_POST["wpum_thumbnail_id"] : "";
$_thumbnail_url = isset($_POST["wpum_thumbnail_url"]) ? $_POST["wpum_thumbnail_url"] : "";
update_post_meta($post_id, "_thumbnail_id", $_thumbnail_id);
update_post_meta($post_id, "_thumbnail_url", $_thumbnail_url); "</textarea></div><div class="clear"></div>';

	}