<?php

// Get all Authors
if ( !function_exists( 'ap_get_auhtors' ) ) {

    function ap_get_auhtors() {

        $options = array();

        $users = get_users();

        foreach ( $users as $user ) {
            $options[ $user->ID ] = $user->display_name;
        }

        return $options;
    }

}


if ( !function_exists( 'ap_get_tags' ) ) {

    function ap_get_tags() {

        $options = array();

        $tags = get_tags();

        foreach ( $tags as $tag ) {
            $options[ $tag->term_id ] = $tag->name;
        }

        return $options;
    }

}

// Get all Posts
if ( !function_exists( 'ap_get_posts' ) ) {

    function ap_get_posts() {

        $post_list = get_posts( array(
            'post_type' => 'post',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => -1,
        ) );

        $posts = array();

        if ( !empty( $post_list ) && !is_wp_error( $post_list ) ) {
            foreach ( $post_list as $post ) {
                $posts[ $post->ID ] = $post->post_title;
            }
        }

        return $posts;
    }

}





if ( !function_exists( 'is_plugin_active' ) ) {
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if ( class_exists( 'WooCommerce' ) || is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

    // Get all Products
    if ( !function_exists( 'ap_get_products' ) ) {

        function ap_get_products() {

            $post_list = get_posts( array(
                'post_type' => 'product',
                'orderby' => 'date',
                'order' => 'DESC',
                'posts_per_page' => -1,
            ) );

            $posts = array();

            if ( !empty( $post_list ) && !is_wp_error( $post_list ) ) {
                foreach ( $post_list as $post ) {
                    $posts[ $post->ID ] = $post->post_title;
                }
            }

            return $posts;
        }

    }

    // Woocommerce - Get product categories
    if ( !function_exists( 'ap_get_product_categories' ) ) {

        function ap_get_product_categories() {

            $options = array();

            $terms = get_terms( array(
                'taxonomy' => 'product_cat',
                'hide_empty' => true,
            ) );

            if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
                foreach ( $terms as $term ) {
                    $options[ $term->term_id ] = $term->name;
                }
            }

            return $options;
        }

    }

    // WooCommerce - Get product tags
    if ( !function_exists( 'ap_product_get_tags' ) ) {

        function ap_product_get_tags() {

            $options = array();

            $tags = get_terms( 'product_tag' );

            if ( !empty( $tags ) && !is_wp_error( $tags ) ) {
                foreach ( $tags as $tag ) {
                    $options[ $tag->term_id ] = $tag->name;
                }
            }

            return $options;
        }

    }
}






/**
* Queries for the elements
*
*/
if( ! function_exists('ap_ea_query')){
    function ap_ea_query( $settings, $first_id = '',$post_per_page = 4 ){


        $post_type      = $settings['posts_post_type'];
        $category       = '';
        $tags           = '';
        $exclude_posts  = '';
        $post_formats   = '';
        if ( current_theme_supports( 'post-formats' ) ) {
            $post_formats   = $settings['posts_post_format_ids'];
        }

        if ( !empty( $post_formats) ) {
            $post_formats[] = implode( ",", $post_formats );
        }
        

        if( 'post' == $post_type ){

            $category       = $settings['posts_category_ids'];
            $tags           = $settings['posts_post_tag_ids'];
            $exclude_posts  = $settings['posts_exclude_posts'];

        }elseif( 'product' == $post_type ){

          $category         = $settings['posts_product_cat_ids'];  
          $exclude_posts    = $settings['posts_exclude_posts'];

      }

        //Categories
      $post_cat = '';
      $post_cats = $category;
      if ( ! empty( $category) ){
        asort($category);    
    }

    if ( !empty( $post_cats) ) {
        $post_cat = implode( ",", $post_cats );
    }


    if( !empty($first_id)){
        $post_cat = $category[0];
    }


        // Post Authors
    $post_author = '';
    $post_authors = $settings['posts_authors'];
    if ( !empty( $post_authors) ) {
        $post_author = implode( ",", $post_authors );
    }

    if( $post_formats ){

        $args = array(
            'post_type'             => $post_type,
            'post__in'              => '',
            'cat'                   => $post_cat,
            'author'                => $post_author,
            'tag__in'               => $tags,
            'orderby'               => $settings['posts_orderby'],
            'order'                 => $settings['posts_order'],
            'post__not_in'          => $exclude_posts,
            'offset'                => $settings['posts_offset'],
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $post_per_page,
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_format',
                    'field'    => 'slug',
                    'terms'    => $post_formats,
                    'operator' => 'IN',
                ),
            ),
        );

    }else{

        $args = array(
            'post_status'           => array( 'publish' ),
            'post_type'             => $post_type,
            'post__in'              => '',
            'cat'                   => $post_cat,
            'author'                => $post_author,
            'tag__in'               => $tags,
            'orderby'               => $settings['posts_orderby'],
            'order'                 => $settings['posts_order'],
            'post__not_in'          => $exclude_posts,
            'offset'                => $settings['posts_offset'],
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $post_per_page
        );
    }

    if( 'product' == $post_type ){

        $args = array(
            'post_type'             => 'product',
            'post__in'              => '',
            'orderby'               => $settings['posts_orderby'],
            'order'                 => $settings['posts_order'],
            'author'                => $post_author,
            'posts_per_page'        => $post_per_page,
            'post__not_in'          => $exclude_posts,
            'offset'                => $settings['posts_offset'],

        );

        if( $post_cat ){
           $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $post_cat
            )
        );
       }
   }


   return $args;

}
}


/**
* Post title excerpt
*/
if( ! function_exists( 'ap_ea_title_excerpt' ) ):
    function ap_ea_title_excerpt( $settings,$class='title-med' ) {
        if ( $settings['post_title'] == 'yes' ){

            $length = absint( $settings['title_excerpt_length'] );
            $title  = get_the_title();

            $limit_content = mb_substr( $title, 0 , $length );
            $title_length = strlen($title);
            if( $title_length > $length){
                $limit_content .= '...';
            }

            $content = $title;
            if( $length ){
                $content = $limit_content;
            }

            $final_content = '<h2 class="post-title '.esc_attr($class).'">';
            $final_content .= '<a href="'.get_the_permalink().'">';
            $final_content .= $content;
            $final_content .= '</a>';
            $final_content .= '</h2>';
            return $final_content;    
        }
    }
endif;


/**
 * Function for excerpt length
 */
if( ! function_exists( 'ap_ea_get_excerpt_content' ) ):
    function ap_ea_get_excerpt_content( $limit ) { ?>

        <div class="post-excerpt">
            <?php 
            if(has_excerpt()){
                $content    = get_the_excerpt();
            }else{
                $content    = get_the_content();
            }
            if( $limit ){
                $striped_contents   = strip_shortcodes( $content );
                $striped_content    = strip_tags( $striped_contents );
                $limit_content      = mb_substr( $striped_content, 0 , $limit );
                echo $limit_content;
            }else{
                echo $content;
            } ?>
        </div>
        <?php 
    }
endif;



/**
* Display post category
*/
add_action('ap_ea_single_cat','ap_ea_single_cat');
if( ! function_exists('ap_ea_single_cat') ){
    function ap_ea_single_cat(){
        $categories = get_the_category();

        if( empty($categories[0]) ){
            return;
        }

        $cat_link = get_category_link( $categories[0]->term_id );
        if ( ! empty( $categories ) ) {
            echo '<span class="cat-links">';
            echo '<a href="'.esc_url($cat_link).'">'.esc_html($categories[0]->name).'</a>';
            echo '</span>';
        }
    }
}

function ap_get_menus() {

    $menus = wp_get_nav_menus();
    $items = ['0' => esc_html__( 'Select Menu', 'ap-companion' ) ];
    foreach ( $menus as $menu ) {
        $items[ $menu->slug ] = $menu->name;
    }

    return $items;
}



if ( !function_exists( 'ap_companion_get_elementor_templates' ) ) {

    function ap_companion_get_elementor_templates() {
        $args = [
            'post_type' => 'elementor_library',
        ];

        $page_templates = get_posts( $args );

        $options = array();

        if ( !empty( $page_templates ) && !is_wp_error( $page_templates ) ) {
            $options['0'] = esc_html__('Select Template','ap-companion');
            foreach ( $page_templates as $post ) {
                $options[ $post->ID ] = $post->post_title;
            }
        }
        return $options;
    }

}


// display  sidebar widget area

if( ! function_exists('ap_companion_sidebar_options') ){

    function ap_companion_sidebar_options() {

        global $wp_registered_sidebars;
        $sidebar_options = [];

        if ( ! $wp_registered_sidebars ) {
            $sidebar_options['0'] = esc_html__( 'No sidebars were found', 'ap-companion' );
        } else {
            $sidebar_options['0'] = esc_html__( 'Select Sidebar', 'ap-companion' );

            foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
                $sidebar_options[ $sidebar_id ] = $sidebar['name'];
            }
        }

        return $sidebar_options;
    }
}