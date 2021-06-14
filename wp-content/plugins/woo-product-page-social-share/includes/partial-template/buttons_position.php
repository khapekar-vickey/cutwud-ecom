<?php

function wpss_buttons_position_field_setting() {

	$options = get_option( 'wpss_register_settings_fields' );
	
	$select_fields = array(
		"wpss_position_default" => "Default",
		"wpss_position_apt" => "After Product Title",
		"wpss_position_bpt" => "Before Product Title",
		"wpss_position_asd" => "After Short Description",
		"wpss_position_aatcb" => "After Add To Cart Button",
		"wpss_position_bti" => "Before Tab Information"
	);
?>
    <select name="wpss_register_settings_fields[wpss_buttons_position_field]" id="wpss_buttons_position">

	<?php
		
		foreach ( $select_fields as $key => $value ) {
			
			echo "<option value=$key";
			
			if( isset( $options['wpss_buttons_position_field'] ) && $key == $options['wpss_buttons_position_field'] ){
			
				echo " selected";
			}
			
			echo ">$value</option>";
		}
	?>

    </select>

<?php }

?>