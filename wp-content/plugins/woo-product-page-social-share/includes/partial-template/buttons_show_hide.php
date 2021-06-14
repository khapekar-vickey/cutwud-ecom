<?php

function wpss_show_hide_field_setting() {

	$options = get_option( 'wpss_register_settings_fields' ); ?>

    <label class="switch">
    	
    	<input type="checkbox" name="wpss_register_settings_fields[wpss_show_hide_field]" <?php checked( 'on', $options['wpss_show_hide_field'], true ); ?> />
		
		<span class="slider"></span>
	
	</label>

<?php } ?>