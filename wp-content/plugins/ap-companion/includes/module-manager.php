<?php

namespace ApCompanion;

if ( !defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

if ( !function_exists( 'is_plugin_active' ) ) {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

final class Modules_Manager {

    
    private function require_files() {
        include_once( AP_COMPANION_PATH . 'base/module_base.php' );
    }

    public function register_modules() {
        
        $modules = [
            'blog-post',
            'blog-slider',
            'slider',
            'slider2',
            'testimonials',
            'blog-grid',
            'blog-module1',
            'blog-module2',
            'blog-module3',
            'author-info',
            'elementor',
            'navbar',
            'site-logo',
            'header-icons',
            'team',
            'ytvideosl',
            'services',
            'offcanvas',
            'price-list',
            'feature-info'
        ];

        if ( class_exists('woocommerce') ) {
            $modules[] = 'woo-product-grid';
            $modules[] = 'woo-product-lists';
            $modules[] = 'woo-category-counter';
            $modules[] = 'woo-categories';
            $modules[] = 'woo-product-search';
            $modules[] = 'jewellery-trending';
            $modules[] = 'jewellery-slider';

        }

        

        

        foreach ( $modules as $module ) {
           
            $class_name = str_replace( '-', ' ', $module );
            $class_name = str_replace( ' ', '', ucwords( $class_name ) );
            $class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\Module';

            $class_name::instance();
        }
    }

    public function __construct() {
        $this->require_files();
        $this->register_modules();
        add_action('ap_comp_register_modules',array($this,'register_modules'),10 );
    }

}

if ( !function_exists( 'ap_module_manager' ) ) {

    /**
     * Returns an instance of the plugin class.
     * @since  1.0.0
     * @return object
     */
    function ap_module_manager() {
        return new Modules_Manager();
    }

}
ap_module_manager();
