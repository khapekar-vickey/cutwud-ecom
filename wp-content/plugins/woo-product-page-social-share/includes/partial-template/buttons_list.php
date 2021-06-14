<?php

function wpss_buttons_list_field_setting() {

	$options = get_option( 'wpss_register_settings_fields' ); ?>

	<input type="hidden" name="wpss_register_settings_fields[wpss_buttons_list_field]" id="wpss_buttons_list_field_values" value="<?php echo $options['wpss_buttons_list_field']; ?>">
	
	<ul id="selected">
		
		<section class="selected_container">
			
		<?php
		
			$selected_services = explode( ",", $options['wpss_buttons_list_field'] );

			require_once WPSS_PLUGIN_PATH . "/assets/data/template.php" ;

			foreach ( $selected_services as $value ) {
				
				if ( !empty( $value ) ) {
					
					echo $templates[$value];
				}
			}

		?>
		
		</section>
		
		<button id="social_service_toggle_btn" class="button" data-toggle="modal" data-target="#myModal">Add Social Service +</button>
	
	</ul>

<?php require_once WPSS_PLUGIN_INCLUDES_PATH . "/modal_template.php"; }

?>