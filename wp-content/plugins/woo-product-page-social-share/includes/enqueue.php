<?php

// ---------------------------------------------------------
// Styles & Scripts For Backend Settings Page [/wp-admin/admin.php?page=woo-social-sharing]
// ---------------------------------------------------------
function wpss_enqueue_assets(){
	
	if ( get_current_screen()->id == 'toplevel_page_woo-social-sharing' ) {
		
		wp_enqueue_style( "wpcee_css", plugins_url( "assets/css/style.css", WPSS_PLUGIN_URL ), true );
		
		wp_enqueue_style( "wpcee_bootstrap_css", plugins_url( "assets/css/bootstrap.css", WPSS_PLUGIN_URL ), false );
		
		wp_enqueue_style( "wpcee_icons", plugins_url( "assets/css/icons.26.svg.css", WPSS_PLUGIN_URL ), true );
		
		wp_enqueue_style( "select2_css", plugins_url( "assets/css/select2.min.css", WPSS_PLUGIN_URL), true );
		
		wp_enqueue_script( "select2_js", plugins_url( "assets/js/select2.min.js", WPSS_PLUGIN_URL ), true );
		
		wp_enqueue_script( "wpcee_popper_js", plugins_url( "assets/js/popper.min.js", WPSS_PLUGIN_URL ), true );
		
		wp_enqueue_script( "wpcee_bootstrap_js", plugins_url( "assets/js/bootstrap.min.js", WPSS_PLUGIN_URL ),array('jquery'), true );
		
		wp_enqueue_script( "wpcee_app", plugins_url( "assets/js/app.js", WPSS_PLUGIN_URL ), array( 'jquery', 'wp-color-picker', 'wpcee_bootstrap_js' ), true );
	}
}

// ---------------------------------------------------------
// Styles & Scripts For Front End Buttons Content
// ---------------------------------------------------------

add_action( 'wp_enqueue_scripts', 'wpss_social_icons_front_render_js' );

function wpss_social_icons_front_render_js() {
    
    wp_register_script( 'wpss_addtoany_script', '//static.addtoany.com/menu/page.js', true );
    
    wp_register_script( "wpcee_frontend_js", plugins_url( "assets/js/script.js", WPSS_PLUGIN_URL ), array( 'jquery' ), true );
    
    wp_register_style( "wpcee_front_end", plugins_url( "assets/css/front_style.css", WPSS_PLUGIN_URL ), true );
    
    wp_enqueue_style( "wpcee_front_bootstrap", plugins_url( "assets/css/bootstrap.css", WPSS_PLUGIN_URL ), true );
}

// ---------------------------------------------------------
// Add async tag to load addtoadny script asynchronous
// ---------------------------------------------------------

add_filter( 'script_loader_tag', 'wpss_addtoany_script_async', 10, 3 );

function wpss_addtoany_script_async( $tag, $handle, $src ) {

    if ( 'wpss_addtoany_script' != $handle ) return $tag;

    return str_replace( '<script', '<script async', $tag );
}

?>