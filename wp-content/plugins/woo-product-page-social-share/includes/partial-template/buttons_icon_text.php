<?php

function wpss_buttons_icontext_field_setting() {

		$options = get_option('wpss_register_settings_fields');

		$select_fields = array(

			"icons_only" => "Icons Only",
			"text_icons" => "Text With Icons",
		);
?>
		<select name="wpss_register_settings_fields[wpss_buttons_icontext_field]" id="wpss_buttons_icontext_field">
			
			<?php
			
				foreach ( $select_fields as $key => $value ) {
					
					echo "<option value=$key";
					
					if( isset( $options['wpss_buttons_icontext_field'] ) && $key == $options['wpss_buttons_icontext_field'] ){
					
						echo " selected";
					}
					
					echo ">$value</option>";
				}
			?>
		</select>
<?php }

?>