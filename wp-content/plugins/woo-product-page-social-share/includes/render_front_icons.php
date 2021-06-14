<?php

// ---------------------------------------------------------
// Add Front End Buttons Filtering Admin Options
// ---------------------------------------------------------

add_action( 'wp_enqueue_scripts', 'wpss_social_addtoany_js' );

// get settings
$wpss_options = get_option( 'wpss_register_settings_fields' );

function wpss_social_addtoany_js() {

	global $wpss_options;

	if ( $wpss_options['wpss_show_hide_field'] == 'on' ) {
    	
		wp_enqueue_script( 'wpss_addtoany_script' );
		
		wp_enqueue_script( 'wpcee_frontend_js' );
		
		wp_enqueue_style( 'wpcee_front_end' );
	}
}

$scriptJS = '';

if ( $wpss_options['wpss_show_hide_field'] == 'on' ) {

	require_once WPSS_PLUGIN_PATH . "assets/data/background.php" ;

		switch ( $wpss_options['wpss_buttons_position_field'] ) {
			
			case 'wpss_position_default':
				
				$wpss_position = 55;
			break;
			
			case 'wpss_position_apt':
				
				$wpss_position = 8;
			break;
			
			case 'wpss_position_bpt':
			
				$wpss_position = 3;
			break;
			
			case 'wpss_position_asd':
				
				$wpss_position = 25;
			break;
			
			case 'wpss_position_aatcb':
				
				$wpss_position = 35;
			break;
			
			case 'wpss_position_bti':
				
				$wpss_position = 5;
			break;
			
			case 'wpss_position_ffr':
				
				$scriptJS .= '';
			
			break;
			
			case 'wpss_position_ffl':
				
				$scriptJS .= '';
			break;
		}

}else{ return; }

global $wpss_position;

add_action( "woocommerce_single_product_summary", "wpss_render_social_buttons_front", $wpss_position );

add_action( "woocommerce_after_single_product_summary", "wpss_render_social_buttons_front_before_tab", $wpss_position );

function wpss_render_social_buttons_front(){

	global $wpss_position, $wpss_options, $wpss_backgrounds;

	if ( $wpss_position == 55 || $wpss_position == 8 || $wpss_position == 3 || $wpss_position == 25 || $wpss_position == 35 ) {

		$html  = '<div class="wpss_social_share_buttons not_before_tab row a2a_kit a2a_kit_size_32 a2a_default_style">';
		
		$social_services = explode( ",", $wpss_options['wpss_buttons_list_field'] );

		foreach ( $social_services as $value ) {
			
			if ( !empty( $value ) ) {

				if ( isset( $wpss_options['wpss_buttons_icontext_field'] ) && $wpss_options['wpss_buttons_icontext_field'] == 'text_icons' ) {
					
					$text = ucwords( str_replace( "_", " ", $value ) );
					
					$color = $wpss_backgrounds[$value];
					
					$bg   = "style='$color;line-height: 32px!important;color: white!important;padding: 2px 5px!important;white-space: nowrap;'";
					
					$class = 'text_only';
				
				}else{
					
					$text = '';
					
					$bg   = '';
					
					$class = 'icons_only';
				}

				if ( isset( $wpss_options['wpss_buttons_style_field']) && $wpss_options['wpss_buttons_style_field'] == 'square' && $wpss_options['wpss_buttons_icontext_field'] == 'icons_only' ) {
					
					echo '<style type="text/css">.a2a_svg, .a2a_count { border-radius: 0 !important; }</style>';
				
				}elseif( isset( $wpss_options['wpss_buttons_style_field']) && $wpss_options['wpss_buttons_style_field'] == 'circle'  && $wpss_options['wpss_buttons_icontext_field'] == 'icons_only' ){
					
					echo '<style type="text/css">.a2a_svg, .a2a_count { border-radius: 100% !important; }</style>';
				}

				$html .= "<a $bg class='a2a_button_$value $class col-xs-6 col-md-6 col-lg-6'>".$text."</a>";
			}
		}
		
		$html .= '</div>';
		
		echo $html;
	}
}

function wpss_render_social_buttons_front_before_tab(){
	
	global $wpss_position, $wpss_options, $wpss_backgrounds;

	if ( $wpss_position == 5 ) {
		
		$html  = '<div class="wpss_social_share_buttons before_tab row a2a_kit a2a_kit_size_32 a2a_default_style">';
		
		$social_services = explode( ",", $wpss_options['wpss_buttons_list_field'] );

		foreach ( $social_services as $value ) {
			
			if ( !empty( $value ) ) {

				if ( isset( $wpss_options['wpss_buttons_icontext_field'] ) && $wpss_options['wpss_buttons_icontext_field'] == 'text_icons' ) {
					
					$text = ucwords( str_replace("_", " ", $value ) );
					
					$color = $wpss_backgrounds[$value];
					
					$bg   = "style='$color ;line-height: 32px!important;color: white!important;padding: 2px 5px!important;white-space: nowrap;'";
					
					$class = 'text_only';
				
				}else{
					
					$text = '';
					
					$bg   = '';
					
					$class = 'icons_only';
				}

				if ( isset( $wpss_options['wpss_buttons_style_field']) && $wpss_options['wpss_buttons_style_field'] == 'square' && $wpss_options['wpss_buttons_icontext_field'] == 'icons_only' ) {
					
					echo '<style type="text/css">.a2a_svg, .a2a_count { border-radius: 0 !important; }</style>';
				
				}elseif( isset( $wpss_options['wpss_buttons_style_field']) && $wpss_options['wpss_buttons_style_field'] == 'circle'  && $wpss_options['wpss_buttons_icontext_field'] == 'icons_only' ){
					
					echo '<style type="text/css">.a2a_svg, .a2a_count { border-radius: 100% !important; }</style>';
				}

				$html .= "<a $bg class='a2a_button_$value $class col-xs-6 col-md-6 col-lg-3'>".$text."</a>";
			}
		}

		$html .= '</div>';

		echo $html;
	}
}

?>