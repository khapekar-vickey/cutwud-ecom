<?php

namespace ApCompanion;

if ( !defined( 'ABSPATH' ) )
    exit();

class ApWidgetLoader {

    private static $instance = null;

    /**
     * Initialize integration hooks
     *
     * @return void
     */
    public function __construct() {
        spl_autoload_register( [ $this, 'autoload' ] );

        $this->includes();
        // Elementor hooks
        $this->add_actions();
        
    }

    function add_elementor_widget_categories() {

        $groups = array(
            'ap-elements'           => esc_html__( 'AP Elements', 'ap-companion' )
        );

        foreach ( $groups as $key => $value )
        {
            \Elementor\Plugin::$instance->elements_manager->add_category( $key, [ 'title' => $value ], 1 );
        }

    }

   
    private function includes() {
        require_once AP_COMPANION_PATH . 'includes/module-manager.php';
    }

    /**
     * Autoload Classes
     */
    public function autoload( $class ) {
        if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
            return;
        }

        $has_class_alias = isset( $this->classes_aliases[ $class ] );

        
        if ( $has_class_alias ) {
            $class_alias_name = $this->classes_aliases[ $class ];
            $class_to_load = $class_alias_name;
        } else {
            $class_to_load = $class;
        }

        if ( !class_exists( $class_to_load ) ) {

            $filename = strtolower(
                    preg_replace(
                            [ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ], [ '', '$1-$2', '-', DIRECTORY_SEPARATOR ], $class_to_load
                    )
            );

            $filename = AP_COMPANION_PATH . $filename . '.php';

            if ( is_readable( $filename ) ) {
                include( $filename );
            }
        }

        if ( $has_class_alias ) {
            class_alias( $class_alias_name, $class );
        }
    }

    /**
     * Add Actions
     *
     * @access private
     */
    public function add_actions() {
        add_action( 'elementor/init', [ $this, 'add_elementor_widget_categories' ] );

        // Fires after Elementor controls are registered.
        add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );

        //FrontEnd Scripts
        add_action( 'elementor/frontend/before_register_scripts', [ $this, 'register_frontend_scripts' ] );
        add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_frontend_scripts' ] );

        //FrontEnd Styles
        add_action( 'elementor/frontend/before_register_styles', [ $this, 'register_frontend_styles' ] );
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_frontend_styles' ] );

        //Editor Scripts
        add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );

        //Editor Style
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );

        //Fires after Elementor preview styles are enqueued.
        add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_preview_styles' ] );
    }

    /**
     * Register Controls
     * @since 1.0.0
     * @access public
     */
    public function register_controls() {
        require_once AP_COMPANION_PATH . 'includes/controls/groups/group-control-query.php';
        // Register Group
        \Elementor\Plugin::instance()->controls_manager->add_group_control( 'ap-query', new Group_Control_Query() );
    }

    /**
     * Register Frontend Scripts
     * @since 1.0.0
     * @access public
     */
    public function register_frontend_scripts() {
        
    }

    /**
     * Enqueue Frontend Scripts
     * @since 1.0.0
     * @access public
     */
    public function enqueue_frontend_scripts() {

        $direction_suffix   = is_rtl() ? '.rtl' : '';
        $suffix             = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
        $lib_js             = AP_COMPANION_URL . 'assets/lib/';

        wp_enqueue_script('jquery-mmenu',$lib_js .'mmenu/jquery.mmenu.all.min.js',[],AP_COMPANION_VERSION);
        wp_enqueue_script('jquery-sticky-sidebar',$lib_js .'jquery.sticky-sidebar.min.js',[],AP_COMPANION_VERSION);
        wp_enqueue_script('youtube-api',$lib_js .'iframe-api.js',[],AP_COMPANION_VERSION);
        wp_enqueue_script( 'slick', $lib_js . 'slick/slick'.$suffix.'.js', [], AP_COMPANION_VERSION );
        wp_enqueue_script( 'ap-frontend', AP_COMPANION_URL . 'assets/js/frontend.js', [], AP_COMPANION_VERSION );
    }

    /**
     * Register Frontend Styles
     * @since 1.0.0
     * @access public
     */
    public function register_frontend_styles() {
        
    }

    /**
     * Enqueue Frontend Styles
     * @since 1.0.0
     * @access public
     */
    public function enqueue_frontend_styles() {

        $lib_js             = AP_COMPANION_URL . 'assets/lib/';

        wp_enqueue_style( 'jquery-mmenu', $lib_js . 'mmenu/jquery.mmenu.all.css', [], AP_COMPANION_VERSION );    
        wp_enqueue_style( 'slick', $lib_js . 'slick/slick.css', [], AP_COMPANION_VERSION );
        wp_enqueue_style( 'slick-theme', $lib_js . 'slick/slick-theme.css', [], AP_COMPANION_VERSION );
        wp_enqueue_style( 'linearicons', $lib_js . 'linearicons/style.css', [], AP_COMPANION_VERSION );
        wp_enqueue_style( 'ap-frontend', AP_COMPANION_URL . 'assets/css/frontend.css', ['dashicons'], AP_COMPANION_VERSION );

    }

    /**
     * Enqueue Editor Scripts
     * @since 1.0.0
     * @access public
     */
    public function enqueue_editor_scripts() {
        
    }

    /**
     * Enqueue Editor Styles
     * @since 1.0.0
     * @access public
     */
    public function enqueue_editor_styles() {
        $css_dir = AP_COMPANION_URL . 'assets/css/';
        
        wp_enqueue_style( 'ap-editor-styles', $css_dir . 'editor-styles.css', [], AP_COMPANION_VERSION );
    }

    /**
     * Preview Styles
     * @since 1.0.0
     * @access public
     */
    public function enqueue_preview_styles() {
        
    }

    /**
     * Creates and returns an instance of the class
     * @since 1.0.0
     * @access public
     * return object
     */
    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

}

if ( !function_exists( 'ap_widget_loader' ) ) {

    /**
     * Returns an instance of the plugin class.
     * @since  1.0.0
     * @return object
     */
    function ap_widget_loader() {
        return ApWidgetLoader::get_instance();
    }

}
ap_widget_loader();
