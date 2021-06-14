<?php
namespace ApCompanion\Modules\Elementor;

use Elementor;
use Elementor\Elementor_Base;
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use ApCompanion;
use ApCompanion\Plugin;
use ApCompanion\Base\Module_Base;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public $sections_data = [];

	public function __construct() {
		parent::__construct();
		$this->add_actions();
	}

	public function get_name() {
		return 'ap-elementor';
	}


	public function register_controls_sticky($section, $section_id, $args) {

		static $layout_sections = [ 'section_advanced'];

		if ( ! in_array( $section_id, $layout_sections ) ) { return; }
		

		$section->start_controls_section(
			'section_sticky_controls',
			[
				'label' => __( 'Sticky', 'ap-companion' ),
				'tab' => Controls_Manager::TAB_ADVANCED,
			]
		);


		$section->add_control(
			'section_sticky_on',
			[
				'label'        => esc_html__( 'Enable Sticky', 'ap-companion' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'description'  => esc_html__( 'Enable this to set sticky feature.', 'ap-companion' ),
			]
		);

	


		$section->end_controls_section();

	}


	protected function add_actions() {

		add_action( 'elementor/element/after_section_end', [ $this, 'register_controls_sticky' ], 10, 3 );
		add_action( 'elementor/frontend/section/before_render', [ $this, 'sticky_before_render' ], 10, 1 );
		add_action( 'elementor/frontend/column/before_render', [ $this, 'sticky_before_render' ], 10, 1 );
		add_action( 'elementor/frontend/widget/before_render', [ $this, 'sticky_before_render' ], 10, 1 );

	}

	public function sticky_before_render($section) {    		
		$settings = $section->get_settings();
		if( !empty($settings[ 'section_sticky_on' ]) == 'yes' ) {
			
			
			if ( !empty($settings[ 'section_sticky_on' ] == 'yes' ) ) {
				$sticky_option = 'ap-sticky-bar';
			}
			
			$section->add_render_attribute( '_wrapper', 'class', $sticky_option );
		}
	}

}