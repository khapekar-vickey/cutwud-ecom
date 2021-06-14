<?php

// ---------------------------------------------------------
// Register Plugin Options Via Settins API
// ---------------------------------------------------------

function wpss_register_settings() {

		// add_settings_section( $id, $title, $callback, $page )
		add_settings_section(
			'wpss_main_settings_section',
			'Main Settings',
			'wpss_main_settings_description',
			'wpss_settings_section'
		);

		// add_settings_field( $id, $title, $callback, $page, $section, $args )
		add_settings_field(
			'wpss_show_hide_field',
			'Show / Hide Sharing Buttons',
			'wpss_show_hide_field_setting',
			'wpss_settings_section',
			'wpss_main_settings_section'
		);

		// add_settings_field( $id, $title, $callback, $page, $section, $args )
		add_settings_field(
			'wpss_buttons_position_field',
			'Buttons Visible Position',
			'wpss_buttons_position_field_setting',
			'wpss_settings_section',
			'wpss_main_settings_section'
		);

		// add_settings_field( $id, $title, $callback, $page, $section, $args )
		add_settings_field(
			'wpss_buttons_style_field',
			'Buttons Style',
			'wpss_buttons_style_field_setting',
			'wpss_settings_section',
			'wpss_main_settings_section'
		);

				// add_settings_field( $id, $title, $callback, $page, $section, $args )
		add_settings_field(
			'wpss_buttons_list_field',
			'Social Buttons To Add',
			'wpss_buttons_list_field_setting',
			'wpss_settings_section',
			'wpss_main_settings_section'
		);

		// add_settings_field( $id, $title, $callback, $page, $section, $args )
		add_settings_field(
			'wpss_buttons_icontext_field',
			'Icons / Icons With Text',
			'wpss_buttons_icontext_field_setting',
			'wpss_settings_section',
			'wpss_main_settings_section'
		);

		// register_setting( $option_group, $option_name, $sanitize_callback )
		register_setting( 'wpss_settings_group', 'wpss_register_settings_fields', 'wpss_main_settings_validate' ) ;
}

function wpss_main_settings_description() {
	//Empty
}

?>