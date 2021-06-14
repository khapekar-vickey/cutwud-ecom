<?php
/**
 * Zigcy Lite functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Zigcy Lite
 */


/** important constants **/
define( 'zigcy_lite_THEME_URI', get_template_directory_uri() );
define( 'zigcy_lite_THEME_DIR', get_template_directory() );

if ( ! function_exists( 'zigcy_lite_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function zigcy_lite_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Zigcy Lite, use a find and replace
		 * to change 'zigcy-lite' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'zigcy-lite', get_template_directory() . '/languages' );

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

		add_image_size( 'sm-blog-img', 390, 290, true );


		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'zigcy-lite' ),
			'menu-2' => esc_html__( 'Currency Menu', 'zigcy-lite' ),
			'menu-3' => esc_html__( 'Language Menu', 'zigcy-lite' ),

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

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );
		
		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'zigcy_lite_custom_background_args', array(
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
add_action( 'after_setup_theme', 'zigcy_lite_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function zigcy_lite_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'zigcy_lite_content_width', 640 );
}
add_action( 'after_setup_theme', 'zigcy_lite_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function zigcy_lite_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'zigcy-lite' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'zigcy-lite' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'zigcy-lite' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'zigcy-lite' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	$footer_widget_regions = apply_filters( 'zigcy_lite_footer_widget_regions', 5 );
	
	for ( $i = 1; $i <= intval( $footer_widget_regions ); $i++ ) {
		
		register_sidebar( array(
			/* translators: %d: Value*/
			'name' 				=> sprintf( __( 'Footer Widget Area %d', 'zigcy-lite' ), $i ),
			'id' 				=> sprintf( 'footer-%d', $i ),
			/* translators: %d: Value*/
			'description' 		=> sprintf( __( ' Add Widgetized Footer Region %d.', 'zigcy-lite' ), $i ),
			'before_widget' 	=> '<div id="%1$s" class="widget %2$s">',
			'after_widget' 		=> '</div>',
			'before_title' 		=> '<h2 class="widget-title">',
			'after_title' 		=> '</h2>',
		));
	}

}
add_action( 'widgets_init', 'zigcy_lite_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function zigcy_lite_scripts() {

	$query_args = array('family' => 'Poppins:100,200,300,400,500,600,700,800|Roboto:400,300,500,700');

  	wp_enqueue_style('google-fonts', add_query_arg($query_args, "//fonts.googleapis.com/css"));
  	
	wp_enqueue_style( 'zigcy-lite-style', get_stylesheet_uri() );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/externals/font-awesome/css/font-awesome.min.css' );
    wp_enqueue_style( 'linearicons',zigcy_lite_THEME_URI . '/assets/externals/linearicons/style.css');
	wp_enqueue_script( 'SmoothScroll',zigcy_lite_THEME_URI.'/assets/externals/SmoothScroll/SmoothScroll.js',array(),'20151215', true );		

	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.min.css' );
	wp_enqueue_style( 'owl-theme-default', get_template_directory_uri() . '/assets/css/owl.theme.default.min.css' );
 	wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/css/slick.css', array(), '20151215' );

    wp_enqueue_style( 'zigcy-lite-responsive', zigcy_lite_THEME_URI. '/assets/css/responsive.css' );    

    /* *************** Date : 10-06-2020 ***************** */
    /* *************** Vickey ******************/
    wp_enqueue_style( 'custom-style', get_template_directory_uri(). '/assets/css/style.css' );    
	/* ****************************************** */
    wp_enqueue_script( 'jarallax', get_template_directory_uri() . '/assets/js/jarallax.js', array( 'jquery' ), '1.1.3', true );

	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), '20151215', true );
    wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/slick.min.js',array('jquery'), '20151215' );

	wp_enqueue_script( 'zigcy-lite-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );

    /* *************** Date : 10-06-2020 ***************** */
    /* *************** Vickey ******************/
	wp_enqueue_script( 'zigcy-lite-navigation', get_template_directory_uri() . '/assets/js/custom-product.js', array(), '20151215', true );
	/* ****************************************************** */
	wp_enqueue_script( 'zigcy-lite-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'zigcy-lite-yith', get_template_directory_uri() . '/assets/js/yith-wcwl-custom.js', array(), '20151215', true );
	wp_enqueue_script( 'zigcy-lite-scripts',zigcy_lite_THEME_URI.'/assets/js/custom.js',array(), '20151215', true );

	wp_register_script( 'vcma-ajax', zigcy_lite_THEME_URI . '/assets/js/sml-ajax.js', array( 'jquery' ), '20151215', true );
    wp_localize_script( 'vcma-ajax', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_enqueue_script( 'vcma-ajax' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'zigcy_lite_scripts' );

/**
* Enque admin scripts and styles
*/
function zigcy_lite_admin_scripts() {
	
    wp_enqueue_style( 'zigcy-lite-customizer-styles',zigcy_lite_THEME_URI. '/inc/customizer/assets/css/customizer-style.css');
    
    wp_register_script( 'zigcy-lite-customizer-scripts', zigcy_lite_THEME_URI. '/inc/customizer/assets/js/customizer-script.js',array('jquery','customize-controls','jquery-ui-sortable'), '20151215', false );
    wp_enqueue_style('zigcy-lite-spectrum-css',zigcy_lite_THEME_URI.'/inc/customizer/assets/spectrum/spectrum.css');
	wp_enqueue_script('zigcy-lite-spectrum-js', zigcy_lite_THEME_URI . '/inc/customizer/assets/spectrum/spectrum.js',array('jquery'));

	$zigcy_lite = array();
    $zigcy_lite['ajax_url'] = admin_url('admin-ajax.php');
    wp_localize_script( 'zigcy-lite-customizer-scripts', 'ZigcyLiteLoc', $zigcy_lite );

	wp_enqueue_script( 'zigcy-lite-customizer-scripts' );
}
add_action( 'customize_controls_enqueue_scripts', 'zigcy_lite_admin_scripts');




/* 
 All product list show in home page
 Developer name : Vickey
 Date : 10-06-2020
*/

if( !function_exists('products_list_in_a_product_category') ) {

    function products_list_in_a_product_category( $atts ) {

        // Shortcode Attributes
        $atts = shortcode_atts(
            array(
                'cat'       => '',
                'limit'     => '15', // default product per page
                'column'    => '4', // default columns
            ),
            $atts, 'productslist'
        );

        // The query
        $posts = get_posts( array(
            'post_type'      => 'product',
            'posts_per_page' => intval($atts['limit'])+1,
            'product_cat'    => $atts['cat'],
        ) );

        $output = '<div class="products-in-'.$atts['cat'].'">';
        $output = '<h3>Products</h3>';
        // The loop
        foreach($posts as $post_obj)
            $ids_array[] = $post_obj->ID;

        // $ids = implode( ',', $ids_array );

        $columns = $atts['column'];

        $output .= do_shortcode ( "[products ids=$ids columns=$columns ]" ) . '</div>';

        return $output;
    }
    add_shortcode( 'productslist', 'products_list_in_a_product_category' );
}

function product_show_category_wise(){
?>

	<ul class="products">
    <?php
        $args = array( 'post_type' => 'product','product_cat' => 'chair' );
        $loop = new WP_Query( $args );
        ?>
        	<h2>chair</h2>
        <?php
        while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>

            

                <li class="product">    

                    <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">

                        <?php woocommerce_show_product_sale_flash( $post, $product ); ?>

                        <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>

                        <h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>

                        <span class="price"><?php echo $product->get_price_html(); ?></span>                    

                    </a>

                    <?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>

                </li>

    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
</ul><!--/.products-->
<?php
}
add_shortcode( 'product_show_category_wise_SC', 'product_show_category_wise' );


/* 
******************* Distcription :- Creating Custom Blog Post Type *****************
**************************** Developer Name :- Vickey ******************************
****************************** Date :- 11-06-2020 **********************************
*/


/* ************ Blog Custom Post Type ************ */
add_action( 'init', 'blogs_post_type' );
function blogs_post_type() {
    $labels = array(
        'name' => 'Blogs',
        'singular_name' => 'Blog',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Blog',
        'edit_item' => 'Edit Blog',
        'new_item' => 'New Blog',
        'view_item' => 'View Blog',
        'search_items' => 'Search Blogs',
        'not_found' =>  'No Blogs found',
        'not_found_in_trash' => 'No Blogs in the trash',
        'parent_item_colon' => '',
    );
 
    register_post_type( 'blogs', array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'exclude_from_search' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 10,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
        'register_meta_box_cb' => 'blogs_meta_boxes', // Callback function for custom metaboxes
    ) );
}

/* *********** Adding a Metabox ************** */
function blogs_meta_boxes() {
    add_meta_box( 'blogs_form', 'Blog Details', 'blogs_form', 'blogs', 'normal', 'high' );
}
 
function blogs_form() {
    $post_id = get_the_ID();
    $blog_data = get_post_meta( $post_id, '_blog', true );
    $client_name = ( empty( $blog_data['client_name'] ) ) ? '' : $blog_data['client_name'];
    $source = ( empty( $blog_data['source'] ) ) ? '' : $blog_data['source'];
    $link = ( empty( $blog_data['link'] ) ) ? '' : $blog_data['link'];
 
    wp_nonce_field( 'blogs', 'blogs' );
    ?>
    <p>
        <label>Client's Name (optional)</label><br />
        <input type="text" value="<?php echo $client_name; ?>" name="blog[client_name]" size="40" />
    </p>
    <p>
        <label>Business/Site Name (optional)</label><br />
        <input type="text" value="<?php echo $source; ?>" name="blog[source]" size="40" />
    </p>
    <p>
        <label>Link (optional)</label><br />
        <input type="text" value="<?php echo $link; ?>" name="blog[link]" size="40" />
    </p>
    <?php
}

/* ************** Saving the Custom Meta ************** */
add_action( 'save_post', 'blogs_save_post' );
function blogs_save_post( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
 
    if ( ! empty( $_POST['blogs'] ) && ! wp_verify_nonce( $_POST['blogs'], 'blogs' ) )
        return;
 
    if ( ! empty( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return;
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;
    }
 
    if ( ! wp_is_post_revision( $post_id ) && 'blogs' == get_post_type( $post_id ) ) {
        remove_action( 'save_post', 'blogs_save_post' );
 
        wp_update_post( array(
            'ID' => $post_id,
        ) );
 
        add_action( 'save_post', 'blogs_save_post' );
    }
 
    if ( ! empty( $_POST['blog'] ) ) {
        $blog_data['client_name'] = ( empty( $_POST['blog']['client_name'] ) ) ? '' : sanitize_text_field( $_POST['blog']['client_name'] );
        $blog_data['source'] = ( empty( $_POST['blog']['source'] ) ) ? '' : sanitize_text_field( $_POST['blog']['source'] );
        $blog_data['link'] = ( empty( $_POST['blog']['link'] ) ) ? '' : esc_url( $_POST['blog']['link'] );
 
        update_post_meta( $post_id, '_blog', $blog_data );
    } else {
        delete_post_meta( $post_id, '_blog' );
    }
}

/* *********** Customizing the List View ********************/
add_filter( 'manage_edit-blogs_columns', 'blogs_edit_columns' );
function blogs_edit_columns( $columns ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => 'Title',
        'blog' => 'Blog',
        'blog-client-name' => 'Client\'s Name',
        'blog-source' => 'Business/Site',
        'blog-link' => 'Link',
        'author' => 'Posted by',
        'date' => 'Date'
    );
 
    return $columns;
}
 
add_action( 'manage_posts_custom_column', 'blogs_columns', 10, 2 );
function blogs_columns( $column, $post_id ) {
    $blog_data = get_post_meta( $post_id, '_blog', true );
    switch ( $column ) {
        case 'blog':
            the_excerpt();
            break;
        case 'blog-client-name':
            if ( ! empty( $blog_data['client_name'] ) )
                echo $blog_data['client_name'];
            break;
        case 'blog-source':
            if ( ! empty( $blog_data['source'] ) )
                echo $blog_data['source'];
            break;
        case 'blog-link':
            if ( ! empty( $blog_data['link'] ) )
                echo $blog_data['link'];
            break;
    }
}

/**
 * Display a Blogs
 *
 * @param  int $post_per_page  The number of blogs you want to display
 * @param  string $orderby  The order by setting  https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters
 * @param  array $blog_id  The ID or IDs of the blog(s), comma separated
 *
 * @return  string  Formatted HTML
 */

function get_blogs_data( $posts_per_page = 1, $orderby = 'none', $blog_id = null ) {
    $args = array(
        'posts_per_page' => (int) $posts_per_page,
        'post_type' => 'blogs',
        'orderby' => $orderby,
        'no_found_rows' => true,
    );
    if ( $blog_id )
        $args['post__in'] = array( $blog_id );
 
    $query = new WP_Query( $args  );
 
    $blogs = '';
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) : $query->the_post();
            $post_id = get_the_ID();
            $blog_data = get_post_meta( $post_id, '_blog', true );
            $client_name = ( empty( $blog_data['client_name'] ) ) ? '' : $blog_data['client_name'];
            $source = ( empty( $blog_data['source'] ) ) ? '' : ' - ' . $blog_data['source'];
            $link = ( empty( $blog_data['link'] ) ) ? '' : $blog_data['link'];
            $cite = ( $link ) ? '<a href="' . esc_url( $link ) . '" target="_blank">' . $client_name . $source . '</a>' : $client_name . $source;
 
            $testimonials .= '<aside class="blog">';
            $testimonials .= '<span class="quote">&ldquo;</span>';
            $testimonials .= '<div class="entry-content">';
            $testimonials .= '<p class="blog-text">' . get_the_content() . '<span></span></p>';
            $testimonials .= '<p class="blog-client-name"><cite>' . $cite . '</cite>';
            $testimonials .= '</div>';
            $testimonials .= '</aside>';
 
        endwhile;
        wp_reset_postdata();
    }
 
    return $blogs;
}

add_shortcode( 'get_blogs_data_SC', 'get_blogs_data' );



	/* ****************** Prpduct Category list ******************** */

	add_shortcode( 'get_me_list_of_SC', 'get_me_list_of' );
	function get_me_list_of(){
		$orderby = 'name';
	$order = 'asc';
	$hide_empty = false ;
	$cat_args = array(
	    'orderby'    => $orderby,
	    'order'      => $order,
	    'hide_empty' => $hide_empty,
	    'parent' => 0
	);



/*

// **********************
$orderby = 'name';
		$order = 'asc';
		$hide_empty = false ;
		$cat_args = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'parent' => 0
		);
	 
	$product_categories = get_terms( 'product_cat', $cat_args );
	 //echo "<pre>";
	 //print_r($product_categories);
	 //echo "</pre>";
	if( !empty($product_categories) ){
	    echo '
	 <div class="prodcut-category-section">
	 <h3 class="product-cat-head">Product Category</h3>
	<ul class="prodcut-category-list">';
	    foreach ($product_categories as $key => $category) {
	        echo '
	 
	<li class="prodcut-category-list-items" style="background-image:url('.$image.')">';

	$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
	$image = wp_get_attachment_url( $thumbnail_id );
	$taxonomy = $category->taxonomy;
	
	$temp = $category->term_id;
	//print_r($temp);
	 $show_hide = get_field( 'show_hide', $taxonomy . '_' . $temp );
	print_r($show_hide);
	
			echo '<a id="'.$category->term_id.'" href="'.get_term_link($category).'" >';
	        
	       // echo '<img class="category-img" id="img_'.$temp.'" src="'.$image.'">';
	        echo '<span>- '.$category->name.'</span>';
			echo '</a>';
	        echo '</li>';
	    }
	    echo '</ul>
	 </div>
	 
	';


	//***************************	
	 $taxonomy     = 'product_cat';
  $orderby      = 'name';  
  $show_count   = 0;      // 1 for yes, 0 for no
  $pad_counts   = 0;      // 1 for yes, 0 for no
  $hierarchical = 1;      // 1 for yes, 0 for no  
  $title        = '';  
  $empty        = 0;
  

  $args = array(
         'taxonomy'     => $taxonomy,
         'orderby'      => $orderby,
         'show_count'   => $show_count,
         'pad_counts'   => $pad_counts,
         'hierarchical' => $hierarchical,
         'title_li'     => $title,
         'hide_empty'   => $empty
  
  );
 $all_categories = get_categories( $args );

 echo "<pre>";
 print_r($all_categories);
 echo "</pre>";

 $cat_data = get_option('show_hide');
 echo "<pre>";
 print_r($cat_data);
 echo "</pre>";
*/

	$product_categories = get_terms( 'product_cat', $cat_args );

	if( !empty($product_categories) ){
	    echo '
	 <div class="prodcut-category-section">
	 <h3 class="product-cat-head">Product Category</h3>
	<ul class="prodcut-category-list">';
	    foreach ($product_categories as $key => $category) {
	        echo '
	 
	<li class="prodcut-category-list-items">';

	$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
	$image = wp_get_attachment_url( $thumbnail_id );
	        echo '<a id="'.$category->term_id.'" href="'.get_term_link($category).'" ><span>';
	        echo $category->name;
	        echo '</span><img class="category-img" id="img_'.$category->term_id.'" src="'.$image.'">';
	        echo '</a>';
	        echo '</li>';
	    }
	    echo '</ul>
	 </div>
	 
	';
	}
}


/**
* Custom feature image
*/

/*
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


// custom product link for product box
add_filter( 'woocommerce_loop_product_link', 'custom_product_permalink_shop', 99, 2 );

function custom_product_permalink_shop( $link, $product ) {
  $this_product_id = $product->get_id();
  $link = '/customize/?pid='.$this_product_id;
  return $link;
}
*/

/**
* Load init files for theme
*/
require zigcy_lite_THEME_DIR . '/inc/init.php';


function rc_woocommerce_recently_viewed_products( $atts, $content = null ) {

    // Get shortcode parameters
    extract(shortcode_atts(array(
        "per_page" => '5'
    ), $atts));

    // Get WooCommerce Global
    global $woocommerce;

    // Get recently viewed product cookies data
    $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
    $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

    // If no data, quit
    if ( empty( $viewed_products ) )
        return __( 'You have not viewed any product yet!', 'rc_wc_rvp' );

    // Create the object
    ob_start();

    // Get products per page
    if( !isset( $per_page ) ? $number = 5 : $number = $per_page )

    // Create query arguments array
    $query_args = array(
                    'posts_per_page' => $number, 
                    'no_found_rows'  => 1, 
                    'post_status'    => 'publish', 
                    'post_type'      => 'product', 
                    'post__in'       => $viewed_products, 
                    'orderby'        => 'rand'
                    );

    // Add meta_query to query args
    $query_args['meta_query'] = array();

    // Check products stock status
    $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();

    // Create a new query
    $r = new WP_Query($query_args);

    // If query return results
    if ( $r->have_posts() ) {

        $content = '<ul class="rc_wc_rvp_product_list_widget">';

        // Start the loop
        while ( $r->have_posts()) {
            $r->the_post();
            global $product;

            $content .= '<li>
                <a href="' . get_permalink() . '">
                    ' . ( has_post_thumbnail() ? get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ) : woocommerce_placeholder_img( 'shop_thumbnail' ) ) . ' ' . get_the_title() . '
                </a> ' . $product->get_price_html() . '
            </li>';
        }

        $content .= '</ul>';

    }

    // Get clean object
    $content .= ob_get_clean();

    // Return whole content
    return $content;
}

// Register the shortcode
add_shortcode("woocommerce_recently_viewed_products", "rc_woocommerce_recently_viewed_products");



add_action( 'woocommerce_before_shop_loop_item_title', 'bbloomer_new_badge_shop_page', 3 );
          
function bbloomer_new_badge_shop_page() {
   global $product;
   $newness_days = 30;
   $created = strtotime( $product->get_date_created() );
   if ( ( time() - ( 60 * 60 * 24 * $newness_days ) ) < $created ) {
      echo '<span class="itsnew onsale">' . esc_html__( 'New!', 'woocommerce' ) . '</span>';
   }
}


add_action('transition_post_status', 'action_product_add', 10, 3);
function action_product_add( $new_status, $old_status, $post ){
    if( 'publish' != $old_status && 'publish' != $new_status 
        && !empty($post->ID) && in_array( $post->post_type, array('product') ) ){

        // You can access to the post meta data directly
        $sku = get_post_meta( $post->ID, '_sku', true);

        // Or Get an instance of the product object (see below)
        $product = wc_get_product($post->ID);

        // Then you can use all WC_Product class and sub classes methods
        $price = $product->get_price(); // Get the product price

        // 1°) Get the product ID (You have it already)
        $product_id = $post->ID;
        // Or (compatibility with WC +3)
        $product_id = method_exists( $product, 'get_id' ) ? $product->get_id() : $product->id;

        // 2°) To get the name (the title)
        $name = $post->post_title;
        // Or
        $name = $product->get_title( );
    }
}

add_shortcode("action_product_add_SC", "action_product_add");



/**
 * @snippet       WooCommerce Product Reviews Shortcode
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.9
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_shortcode( 'product_reviews', 'bbloomer_product_reviews_shortcode' );
 
function bbloomer_product_reviews_shortcode( $atts ) {
    
   if ( empty( $atts ) ) return '';
 
   if ( ! isset( $atts['id'] ) ) return '';
       
   $comments = get_comments( 'post_id=' . $atts['id'] );
    
   if ( ! $comments ) return '';
    
   $html .= '<div class="woocommerce-tabs"><div id="reviews"><ol class="commentlist">';
    
   foreach ( $comments as $comment ) {   
      $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
      $html .= '<li class="review">';
      $html .= get_avatar( $comment, '60' );
      $html .= '<div class="comment-text">';
      if ( $rating ) $html .= wc_get_rating_html( $rating );
      $html .= '<p class="meta"><strong class="woocommerce-review__author">';
      $html .= get_comment_author( $comment );
      $html .= '</strong></p>';
      $html .= '<div class="description">';
      $html .= $comment->comment_content;
      $html .= '</div></div>';
      $html .= '</li>';
   }
    
   $html .= '</ol></div></div>';
    
   return $html;
}



//



/* 
******************* Distcription :- Creating Custom Advertisement Post Type *****************
**************************** Developer Name :- Vickey ******************************
****************************** Date :- 11-06-2020 **********************************
*/


/* ************ Blog Custom Post Type ************ */
add_action( 'init', 'advertisements_post_type' );
function advertisements_post_type() {
    $labels = array(
        'name' => __( 'Advertisements' ),
        'singular_name' => __( 'Advertisement' ),
        'add_new' => __( 'Add New' ),
        'add_new_item' => __( 'Add New Advertisement' ),
        'edit_item' => __(  'Edit Advertisement' ),
        'new_item' => __( 'New Advertisement' ),
        'all_items'          => __( 'All Advertisement' ),
        'view_item' => __( 'View Advertisement' ),
        'search_items' => __( 'Search Advertisements' ),
        'not_found' =>  __( 'No Advertisements found' ),
        'not_found_in_trash' => __( 'No Advertisements in the trash' ),
        'featured_image'     => 'Poster',
        'set_featured_image' => 'Add Poster'

    );
     register_post_type( 'Advertisements', array(
        'labels' => $labels,
        'description'       => 'Holds our Advertisement Pop-up post specific data',
        'public' => true,
        'menu_position' => 10,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
        'has_archive' => true,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,        
        'query_var' => true,
                // 'register_meta_box_cb' => 'advertisements_meta_boxes', // Callback function for custom metaboxes
    ) );
}

/* *********** Adding a Metabox ************** */
function advertisements_meta_boxes() {
    add_meta_box( 'advertisements_form', 'Advertisement Details', 'advertisements_form', 'advertisements', 'normal', 'high' );
}
 
function advertisements_form() {
    $post_id = get_the_ID();
    $advertisement_data = get_post_meta( $post_id, '_advertisement', true );
    // $client_name = ( empty( $blog_data['client_name'] ) ) ? '' : $blog_data['client_name'];
    // $source = ( empty( $blog_data['source'] ) ) ? '' : $blog_data['source'];
    // $link = ( empty( $blog_data['link'] ) ) ? '' : $blog_data['link'];
 
    // wp_nonce_field( 'advertisements', 'advertisements' );
    ?>
<!--     <p>
        <label>Client's Name (optional)</label><br />
        <input type="text" value="<?php echo $client_name; ?>" name="blog[client_name]" size="40" />
    </p>
    <p>
        <label>Business/Site Name (optional)</label><br />
        <input type="text" value="<?php echo $source; ?>" name="blog[source]" size="40" />
    </p>
    <p>
        <label>Link (optional)</label><br />
        <input type="text" value="<?php echo $link; ?>" name="blog[link]" size="40" />
    </p>
-->
    <?php
}

/* ************** Saving the Custom Meta ************** */
add_action( 'save_post', 'advertisements_save_post' );
function advertisements_save_post( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
 
    if ( ! empty( $_POST['advertisements'] ) && ! wp_verify_nonce( $_POST['advertisements'], 'advertisements' ) )
        return;
 
    if ( ! empty( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return;
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;
    }
 
    if ( ! wp_is_post_revision( $post_id ) && 'advertisements' == get_post_type( $post_id ) ) {
        remove_action( 'save_post', 'advertisements_save_post' );
 
        wp_update_post( array(
            'ID' => $post_id,
            // 'post_title' => 'Advertisement - ' . $post_id
        ) );
 
        add_action( 'save_post', 'advertisements_save_post' );
    }
 
/*    if ( ! empty( $_POST['blog'] ) ) {
        $blog_data['client_name'] = ( empty( $_POST['blog']['client_name'] ) ) ? '' : sanitize_text_field( $_POST['blog']['client_name'] );
        $blog_data['source'] = ( empty( $_POST['blog']['source'] ) ) ? '' : sanitize_text_field( $_POST['blog']['source'] );
        $blog_data['link'] = ( empty( $_POST['blog']['link'] ) ) ? '' : esc_url( $_POST['blog']['link'] );
 
        update_post_meta( $post_id, '_blog', $blog_data );
    }
    */
     else {
        delete_post_meta( $post_id, '_advertisement' );
    }
}

/* *********** Customizing the List View ********************/
add_filter( 'manage_edit-advertisements_columns', 'advertisements_edit_columns' );
function advertisements_edit_columns( $columns ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => 'Title',
        'Advertisement' => 'Advertisement',
        // 'blog-client-name' => 'Client\'s Name',
        // 'blog-source' => 'Business/Site',
        // 'blog-link' => 'Link',
        'author' => 'Posted by',
        'date' => 'Date'
    );
 
    return $columns;
}
 
