<?php

function wpss_buttons_style_field_setting() {

	$options = get_option( 'wpss_register_settings_fields' ); ?>

	<div class="buttons_style_preview">

		<label for="rounded_radio">
			<input type="radio" id="rounded_radio" name="wpss_register_settings_fields[wpss_buttons_style_field]" value="rounded" <?php echo $options['wpss_buttons_style_field'] == 'rounded' ? 'checked' : "" ?>>
			<img data-toggle="tooltip" data-placement="top" title="Rounded" src="<?php echo plugins_url("/assets/icon/rounded.png",WPSS_PLUGIN_URL); ?>">
		</label>

		<label for="square_radio">
			<input type="radio" id="square_radio" name="wpss_register_settings_fields[wpss_buttons_style_field]" value="square" <?php echo $options['wpss_buttons_style_field'] == 'square' ? 'checked' : "" ?>>
			<img data-toggle="tooltip" data-placement="top" title="Squared" src="<?php echo plugins_url("/assets/icon/square.png",WPSS_PLUGIN_URL); ?>">
		</label>

		<label for="circle_radio">
			<input type="radio" id="circle_radio" name="wpss_register_settings_fields[wpss_buttons_style_field]" value="circle" <?php echo $options['wpss_buttons_style_field'] == 'circle' ? 'checked' : "" ?>>
			<img data-toggle="tooltip" data-placement="top" title="Circled" src="<?php echo plugins_url("/assets/icon/circle.png",WPSS_PLUGIN_URL); ?>">
		</label>

	</div>

<?php } ?>