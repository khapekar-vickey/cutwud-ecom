<?php
/*
Plugin Name: My Custom Post Types
Description: Add post types for custom articles
Author: 
*/

/*
// Hook <strong>lc_custom_post_custom_article()</strong> to the init action hook
add_action( 'init', 'ht_custom_post_Advertisement_Pop_up' );
// The custom function to register a custom article post type
function ht_custom_post_Advertisement_Pop_up() {
// Set the labels, this variable is used in the $args array
$labels = array(
'name'               => __( 'Advertisement Pop-ups' ),
'singular_name'      => __( 'Advertisement Pop-up' ),
'add_new'            => __( 'Add New Advertisement Pop-up' ),
'add_new_item'       => __( 'Add New Advertisement Pop-up' ),
'edit_item'          => __( 'Edit Advertisement Pop-up' ),
'new_item'           => __( 'New Advertisement Pop-up' ),
'all_items'          => __( 'All Advertisement Pop-up' ),
'view_item'          => __( 'View Advertisement Pop-up' ),
'search_items'       => __( 'Search Advertisement Pop-up' ),
'featured_image'     => 'Poster',
'set_featured_image' => 'Add Poster'






);
// The arguments for our post type, to be entered as parameter 2 of register_post_type()
$args = array(
'labels'            => $labels,
'description'       => 'Holds our Advertisement Pop-up post specific data',
'public'            => true,
'menu_position'     => 5,
'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
'has_archive'       => true,
'show_in_admin_bar' => true,
'show_in_nav_menus' => true,
'query_var'         => true,
);
// Call the actual WordPress function
// Parameter 1 is a name for the post type
// Parameter 2 is the $args array
register_post_type( 'advertisement', $args);




}


add_action( 'pre_get_posts', 'add_advertisement_to_frontpage' );
// Alter the main query
function add_advertisement_to_frontpage( $query ) {
if ( is_home() && $query->is_main_query() ) {
$query->set( 'post_type', array( 'post', 'advertisement' ) );
}
return $query;
}
*/


