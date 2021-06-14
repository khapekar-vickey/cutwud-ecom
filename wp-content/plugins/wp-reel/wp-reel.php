<?php
/* 
Plugin Name: WP Reel
Plugin URI: http://altert.net/demo/wp-reel-demo/
Author URI: http://altert.net
Version: 1.0
Text Domain: wp-reel
Domain Path: /lang
Author:Alexey Tikhonov
Description: This plugin allows to replace WP gallery with <a href="http://jquery.vostrel.cz/reel">jQuery.Reel</a> by Petr Vostřel

*/

add_action( 'plugins_loaded', 'wp_reel_load_textdomain' );


function wp_reel_load_textdomain() {
  load_plugin_textdomain( 'wp-reel', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' ); 
}

add_action('wp_enqueue_scripts', 'wp_reel_scripts');

// Scripts initialization

function wp_reel_scripts() {
	if(!is_admin()) {
	wp_enqueue_script ('jquery');
	wp_enqueue_script('reel', plugin_dir_url( __FILE__ ) .'js/jquery.reel-min.js', array('jquery'), '', true);
	}
}

// Add custom settings via settings API

function wp_reel_settings_api_init() {
	// Add the section to media settings so we can add our
	// fields to it
	add_settings_section(
		'wp_reel_setting_section',
		__('WP Reel Options', 'wp-reel'),
		'wp_reel_setting_section_callback_function',
		'media'
	);
	

	add_settings_field(
		'wp_reel_setting_replace_gallery',
		__('Replace wordpress gallery', 'wp-reel'),
		'wp_reel_setting_callback_function_replace_gallery',
		'media',
		'wp_reel_setting_section'
	);
	
	add_settings_field(
		'wp_reel_setting_default_speed',
		__('Default animation speed', 'wp-reel'),
		'wp_reel_setting_callback_function_default_speed',
		'media',
		'wp_reel_setting_section'
	);
	
	// Register our setting so that $_POST handling is done for us and
	// our callback function just has to echo the <input>
    register_setting( 'media', 'wp_reel_setting_replace_gallery' );
    register_setting( 'media', 'wp_reel_setting_default_speed' );
}


add_action( 'admin_init', 'wp_reel_settings_api_init' );

// WP Reel options on media settings

function wp_reel_setting_section_callback_function() {
	echo '<p>'.__('Options related to WP Reel plugin', 'wp-reel').'</p>';
}



function wp_reel_setting_callback_function_replace_gallery() {
	echo '<input name="wp_reel_setting_replace_gallery" id="wp_reel_setting_replace_gallery" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'wp_reel_setting_replace_gallery' ), false ) . ' /> '.__('Replaces all galleries with WP Reel galleries', 'wp-reel');

}
function wp_reel_setting_callback_function_default_speed() {

	echo '<input name="wp_reel_setting_default_speed" id="wp_reel_setting_default_speed" type="text"  class="code" value="' . get_option( 'wp_reel_setting_default_speed', 0) . '" /> ';
}


// Custom filter function to modify default gallery shortcode output

function reel_gallery( $output, $attr ) {

	// Initialize
	global $post, $wp_locale;
    $return = $output;


	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( ! $attr['orderby'] ) unset( $attr['orderby'] );
	}

	// Get attributes from shortcode
	extract( shortcode_atts( array(
	    'area' => '',
	    'attr' => '{}',
	    'brake' => '0.23',
	    'clickfree' => 'false',   
	    'cursor' => 'url("'. plugin_dir_url( __FILE__ ) .'cur/jquery.reel.cur"),hand',
	    'cw'    => 'false',
	    'delay' => '0',
	    'directional' => '',
	    'draggable' => 'true',
	    'duration' => '',
	    'entry' => '',
	    'footage' => '6',
	    'frame'    => '1',
	    'frames' => '36',
	    'framelock' => 'false',
	    'graph' => '',
	    'hint' => '',
	    'horizontal' => 'true',
	    'indicator' => '0',
	    'inversed' => 'false',
	    'klass' => '',
	    'laziness' => '6',
	    'loops'    => 'true',
	    'monitor' => '',
	    'opening' => '0',
	    'orbital' => '0',
	    'oritentable' => '',
        'preload' => 'fidelity',
        'preloader' => '4',
        'rebound' => '0.5',
        'responsive' => 'false',
        'revolution'    => '',
        'row' => '1',
        'rows' => '0',
        'rowlock' => 'false',
        'scrollable' => 'true',
        'shy' => 'false',
        'spacing' => '0',
        'speed' => get_option( 'wp_reel_setting_default_speed' , 0),
        'steppable' => 'true',
        'stitched' => '0',
        'tempo' => '25',
        'timeout' => '',
        'throwable' => 'true',
        'velocity' => '0',
        'vertical' => 'false',
        'wheelable' => 'true',
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'full',
		'include'    => '',
		'exclude'    => '',
		'width' => '',
		'height' => '',	
		'reel' => '',
		'size' => ''
		
		
		
		
	), $attr ) );
	
	if (!get_option( 'wp_reel_setting_replace_gallery' , false ) && ($reel!="1")) return $return;
	
	// do not process non-reel gallery
	// Initialize
	$id = intval( $id );
	$attachments = array();
	if ( $order == 'RAND' ) $orderby = 'none';

	if ( ! empty( $include ) ) {

		// Include attribute is present
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

		// Setup attachments array
		foreach ( $_attachments as $key => $val ) {
			$attachments[ $val->ID ] = $_attachments[ $key ];
		}

	} else if ( ! empty( $exclude ) ) {

		// Exclude attribute is present 
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );

		// Setup attachments array
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	} else {
		// Setup attachments array
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	}

	if ( empty( $attachments ) ) return $return;

	// Filter gallery differently for feeds
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
		return $output;
	}

	// Iterate through the attachments 
	$i = 0;
    $images=count($attachments);
    if ($images>1) $frames=$images;
	if ($frame>$frames) $frame=$frames;
	foreach ( $attachments as $id => $attachment ) {
	    $i++;
		
		 $image_attributes = wp_get_attachment_image_src( $id, $size ); // returns an array
        if ($i==1) {
         
          if (($width=='') || ($height=='')) {
             
              if( $image_attributes ) {
                  $width=$image_attributes[1];
                  $height=$image_attributes[2];          
              }      
          }
           $revolution=max($width,$height);
          if ($vertical=="true") $horizontal="false";
//          if (($vertical=="true")&&($cursor=='url("'. plugin_dir_url( __FILE__ ) .'cur/jquery.reel.cur"),hand')) $cursor='url("'. plugin_dir_url( __FILE__ ) .'cur/jquery.reel-vert.cur"),hand';
          $output = "<img data-area='$area' data-attr='$attr' data-brake='$brake' data-clickfree='$clickfree' data-cursor='$cursor' data-cw='$cw' data-delay='$delay' data-directional='$directional' data-draggable='$draggable' data-duration='$duration' data-entry='$entry' data-footage='$footage' data-framelock='$framelock' data-graph='$graph' data-hint='$hint' data-horizontal='$horizontal' data-indicator='$indicator' data-inversed='$inversed' data-klass='$klass' data-lazyness='$lazyness' data-monitor='$monitor' data-opening='$opening' data-orbital='$orbital' data-orientable='$orientable' data-preload='$preload' data-preloader='$preloader' data-rebound='$rebound' data-responsive='$responsive' data-row='$row' data-rows='$rows' data-rowlock='$rowlock' data-scrollable='$scrollable' data-shy='$shy' data-spacing='$spacing' data-steppable='$steppable' data-tempo='$tempo' data-throwable='$throwable' data-velocity='$velocity' data-vertical='$vertical' data-wheelable='$wheelable' width='$width' height='$height'  class='reel' data-revolution='$revolution'  data-speed='$speed'  data-loops='$loops'  data-frames='$frames' data-size='$size' data-frame='$frame'  ";
          
          if ($images>1) $output.=" data-images='";
          else {
           if ($stitched=="0") $stitched=$image_attributes[1];
           $output.=" data-stitched='".$stitched."' data-image='";
           }
         }
        if (($images>1)&&($i==$frame)) $imgurl=$image_attributes[0];
        elseif (($images==1)&&($i==1)) $imgurl=$image_attributes[0];
		$output .= $image_attributes[0];
        if ($i<$images) $output.=",";
        
	}

	$output .= "' src='$imgurl' >";
    
	return $output;

}

// Apply filter to default gallery shortcode
add_filter( 'post_gallery', 'reel_gallery', 10, 2 );
