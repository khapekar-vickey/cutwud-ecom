<?php
/**
 * Plugin Name: 	Basic Custom login-reg
 * Plugin URI:		http://dkawale.info/
 * Description:		Add a media uploader to your settings page.
 * Version: 		0.1.2
 * Author: 			Dhanraj Kawale
 * Author URI: 		http://dkawale.info/
 */
define( 'WPUM_VERSION', '1.1.2' );
define( 'WPUM_FILE', __FILE__ );
define( 'WPUM_ROOT', dirname( __FILE__ ) );
define( 'WPUM_ROOT_URI', plugins_url( '', __FILE__ ) );
define( 'WPUM_ASSET_URI', WPUM_ROOT_URI . '/assets' );
define('FIELD_SUFFIX','WPUM_');
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );

/*wp_enqueue_script('NameMySccript', 'path/to/MyScript', 
'dependencies_MyScript', 'VersionMyScript', 'InfooterTrueorFalse');*/

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( is_plugin_active( 'basic-custom-login-reg/basic-loginreg.php' ) ) 
{
 
	wp_register_script( 'wpum_uploadmedia-js', WPUM_ROOT_URI . '/js/ulpoad-media.js');
	wp_register_script( 'wpum_setting-js', WPUM_ROOT_URI . '/js/setting.js');
	wp_register_script('wpumuser_avataruploader', WPUM_ROOT_URI .'/js/user_avataruploader.js');
	wp_register_style( 'wpum_uploadmedia-style', WPUM_ROOT_URI . '/css/uploadmedia-style.css');
	wp_register_style( 'wpum_registrationform-style', WPUM_ROOT_URI . '/css/registrationform.css');

	/*Captcha CSS*/
	//wp_register_style( 'wpum_captchabdc-layout-style', WPUM_ROOT_URI . '/captcha/lib/botdetect/public/bdc-layout-stylesheet.css');
	//wp_register_style( 'wpum_captcha-style', WPUM_ROOT_URI . '/captcha/examples/jquery-validation-captcha/stylesheet.css');
	/*Captcha CSS*/

	wp_register_script( 'wpum_jquerymin-js', WPUM_ROOT_URI . '/js/jquery.min.js');
	wp_register_script( 'wpum_libjquery-js', WPUM_ROOT_URI . '/js/lib/jquery.js');
	wp_register_script( 'wpum_jquery.validatejs', WPUM_ROOT_URI . '/js/dist/jquery.validate.js');
	wp_register_script( 'wpum_formvalidationjs', WPUM_ROOT_URI . '/js/frontend_formvalidation.js');

	wp_enqueue_style('wpum_registrationform-style');



		require_once(WPUM_ROOT. '/function.php');
		require_once WPUM_ROOT. '/include/includes.php';
		require_once WPUM_ROOT. '/include/settings.php';
		//require_once WPUM_ROOT. '/captcha/examples/jquery-validation-captcha/botdetect.php';
}//is_plugin_active end