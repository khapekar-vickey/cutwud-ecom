<?php
/**
 * icarefurnishers functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package icarefurnishers
 */

if ( ! function_exists( 'icarefurnishers_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function icarefurnishers_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on icarefurnishers, use a find and replace
		 * to change 'icarefurnishers' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'icarefurnishers', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'icarefurnishers' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'icarefurnishers_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'icarefurnishers_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function icarefurnishers_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'icarefurnishers_content_width', 640 );
}
add_action( 'after_setup_theme', 'icarefurnishers_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function icarefurnishers_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'icarefurnishers' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'icarefurnishers' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	 /*
 * Register widget area for Woo commerce product filter.
 * Developer nae : Vickey
 */
    register_sidebar( array(
        'name'          => esc_html__( 'WooCommerce Product Filter', 'icarefurnishers' ),
        'id'            => 'woo-commerce-product-filter',
        'description'   => esc_html__( 'Add widgets here.', 'icarefurnishers' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'icarefurnishers_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function icarefurnishers_scripts() {
	wp_enqueue_style( 'icarefurnishers-style', get_stylesheet_uri() );

	wp_enqueue_script( 'icarefurnishers-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'icarefurnishers-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'icarefurnishers_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
* Custom feature image
*/
function wpcustom_featured_image() {
   //Execute if singular
   if ( is_singular() ) {
       $id = get_queried_object_id ();
       // Check if the post/page has featured image
       if ( has_post_thumbnail( $id ) ) {
           // Change thumbnail size, but I guess full is what you'll need
           $image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );
           $url = $image[0];
       } else {
           //Set a default image if Featured Image isn't set
           $url = '';
       }
   }
   return $url;
}
// End custom featured image

//login Page Css
function media_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/css/style-login.css' );
}
add_action( 'login_enqueue_scripts', 'media_login_stylesheet' );

function media_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'media_login_logo_url' );

include('footer_details.php');

/**
* Load Theme Setup Page
*/
require get_template_directory() . '/textlocal_sms/textlocal.class.php';
require get_template_directory() . '/sendsms_function.php';
require get_template_directory() . '/commen_function.php';
require get_template_directory() . '/woo_extraprice.php';
require get_template_directory() . '/function_partner_list.php';
require get_template_directory() . '/function_interior_list.php';
require get_template_directory() . '/function_homepage_slider.php';
require get_template_directory() . '/add_term_metabox.php';