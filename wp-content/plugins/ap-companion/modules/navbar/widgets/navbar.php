<?php
namespace ApCompanion\Modules\Navbar\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Navbar extends Widget_Base {

	public function get_name() {
		return 'ap-navbar';
	}

	public function get_title() {
		return esc_html__( 'Navbar', 'ap-companion' );
	}

	public function get_icon() {
		return 'ap-ea-icons ap-navbar';
	}

	public function get_categories() {
		return [ 'ap-elements' ];
	}


	protected function _register_controls() {
		
		$this->start_controls_section(
			'section_navbar_content',
			[
				'label' => esc_html__( 'Navbar', 'ap-companion' ),
			]
		);

		$this->add_control(
			'navbar',
			[
				'label'   => esc_html__( 'Select Menu', 'ap-companion' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ap_get_menus(),
				'default' => 0,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'ap-companion' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'ap-companion' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ap-companion' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'  => [
						'title' => esc_html__( 'Right', 'ap-companion' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-container > ul' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .ap-mobile-nav-wrapper' => 'justify-content: {{VALUE}};',
					
				],
			]
		);

		$this->add_responsive_control(
			'menu_offset',
			[
				'label' => esc_html__( 'Offset', 'ap-companion' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -150,
						'max' => 150,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ap-navbar-nav' => 'transform: translateX({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Padding', 'ap-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ap-navbar-wrapper .ap-navbar-container.ap-navbar ul.ap-navbar-nav li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'menu_height',
			[
				'label' => esc_html__( 'Menu Height', 'ap-companion' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 150,
					],
				],
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .ap-navbar-wrapper .ap-navbar-container.ap-navbar ul.ap-navbar-nav li a' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'menu_parent_arrow',
			[
				'label'        => __( 'Parent Indicator', 'ap-companion' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'ap-navbar-parent-indicator-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'dropdown_content',
			[
				'label' => esc_html__( 'Dropdown', 'ap-companion' ),
			]
		);

		$this->add_responsive_control(
			'dropdown_align',
			[
				'label'     => esc_html__( 'Dropdown Alignment', 'ap-companion' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ap-companion' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ap-companion' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ap-companion' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_link_align',
			[
				'label'   => esc_html__( 'Item Alignment', 'ap-companion' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'ap-companion' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ap-companion' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ap-companion' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-dropdown-nav > li > a' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dropdown_padding',
			[
				'label'      => esc_html__( 'Dropdown Padding', 'ap-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ap-navbar-dropdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_width',
			[
				'label' => esc_html__( 'Dropdown Width', 'ap-companion' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 150,
						'max' => 350,
					],
				],
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .ap-navbar-dropdown' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'dropdown_additional',
			[
				'label' => esc_html__( 'Additional', 'ap-companion' ),
			]
		);

		$this->add_control(
			'dropdown_delay_show',
			[
				'label' => esc_html__( 'Delay Show', 'ap-companion' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
			]
		);

		$this->add_control(
			'dropdown_delay_hide',
			[
				'label' => esc_html__( 'Delay Hide', 'ap-companion' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
				'default' => ['size' => 800],
			]
		);

		$this->add_control(
			'dropdown_duration',
			[
				'label' => esc_html__( 'Dropdown Duration', 'ap-companion' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
				'default' => ['size' => 200],
			]
		);

		$this->add_control(
			'dropdown_offset',
			[
				'label' => esc_html__( 'Dropdown Offset', 'ap-companion' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_style',
			[
				'label' => esc_html__( 'Navbar', 'ap-companion' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->start_controls_tabs( 'menu_link_styles' );

		$this->start_controls_tab( 'menu_link_normal', [ 'label' => esc_html__( 'Normal', 'ap-companion' ) ] );

		$this->add_control(
			'menu_link_color',
			[
				'label'     => esc_html__( 'Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-wrapper .ap-navbar-container.ap-navbar ul.ap-navbar-nav li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_link_background',
			[
				'label'     => esc_html__( 'Background', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-wrapper .ap-navbar-container.ap-navbar ul.ap-navbar-nav li a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'menu_spacing',
			[
				'label' => esc_html__( 'Gap', 'ap-companion' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 25,
					],
				],
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .ap-navbar-nav' => 'margin-left: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ap-navbar-nav > li' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'menu_border',
				'label'    => esc_html__( 'Border', 'ap-companion' ),
				'default'  => '1px',
				'selector' => '{{WRAPPER}} .ap-navbar-wrapper .ap-navbar-container.ap-navbar ul.ap-navbar-nav li a',
			]
		);

		$this->add_control(
			'menu_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ap-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ap-navbar-wrapper .ap-navbar-container.ap-navbar ul.ap-navbar-nav li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'menu_typography_normal',
				'label'    => esc_html__( 'Typography', 'ap-companion' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ap-navbar-wrapper .ap-navbar-container.ap-navbar ul.ap-navbar-nav li a',
			]
		);

		$this->add_control(
			'menu_parent_arrow_color',
			[
				'label'     => esc_html__( 'Parent Indicator Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.ap-navbar-parent-indicator-yes .ap-navbar-nav > li.ap-parent a:after' => 'color: {{VALUE}};',
				],
				'condition' => ['menu_parent_arrow' => 'yes'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'menu_link_hover', [ 'label' => esc_html__( 'Hover', 'ap-companion' ) ] );

		$this->add_control(
			'navbar_hover_style_color',
			[
				'label'     => esc_html__( 'Style Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-nav > li:hover > a:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .ap-navbar-nav > li:hover > a:after'  => 'background-color: {{VALUE}};',
				],
				
			]
		);

		$this->add_control(
			'menu_link_color_hover',
			[
				'label'     => esc_html__( 'Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-wrapper .ap-navbar-container.ap-navbar ul.ap-navbar-nav li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_background_hover',
			[
				'label'     => esc_html__( 'Background Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-wrapper .ap-navbar-container.ap-navbar ul.ap-navbar-nav li a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-wrapper .ap-navbar-container.ap-navbar ul.ap-navbar-nav li a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_border_radius_hover',
			[
				'label'      => esc_html__( 'Border Radius', 'ap-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ap-navbar-wrapper .ap-navbar-container.ap-navbar ul.ap-navbar-nav li a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'menu_typography_hover',
				'label'    => esc_html__( 'Typography', 'ap-companion' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ap-navbar-wrapper .ap-navbar-container.ap-navbar ul.ap-navbar-nav li a:hover',
			]
		);

		$this->add_control(
			'menu_parent_arrow_color_hover',
			[
				'label'     => esc_html__( 'Parent Indicator Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.ap-navbar-parent-indicator-yes .ap-navbar-nav > li.ap-parent a:hover::after' => 'color: {{VALUE}};',
				],
				'condition' => ['menu_parent_arrow' => 'yes'],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab( 'menu_link_active', [ 'label' => esc_html__( 'Active', 'ap-companion' ) ] );

		$this->add_control(
			'navbar_active_style_color',
			[
				'label'     => esc_html__( 'Style Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-nav > li.ap-active > a:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .ap-navbar-nav > li.ap-active > a:after'  => 'background-color: {{VALUE}};',
				],
				
			]
		);

		$this->add_control(
			'menu_hover_color_active',
			[
				'label'     => esc_html__( 'Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-nav > li.ap-active > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_hover_background_color_active',
			[
				'label'     => esc_html__( 'Background', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-nav > li.ap-active > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'menu_border_active',
				'label'    => esc_html__( 'Border', 'ap-companion' ),
				'default'  => '1px',
				'selector' => '{{WRAPPER}} .ap-navbar-nav > li.ap-active > a',
			]
		);

		$this->add_control(
			'menu_border_radius_active',
			[
				'label'      => esc_html__( 'Border Radius', 'ap-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ap-navbar-nav > li.ap-active > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'menu_typography_active',
				'label'    => esc_html__( 'Typography', 'ap-companion' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ap-navbar-nav > li.ap-active > a',
			]
		);

		$this->add_control(
			'menu_parent_arrow_color_active',
			[
				'label'     => esc_html__( 'Parent Indicator Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.ap-navbar-parent-indicator-yes .ap-navbar-nav > li.ap-parent.ap-active a:after' => 'color: {{VALUE}};',
				],
				'condition' => ['menu_parent_arrow' => 'yes'],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'dropdown_color',
			[
				'label' => esc_html__( 'Dropdown', 'ap-companion' ),
				'type'  => Controls_Manager::SECTION,
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'dropdown_background',
			[
				'label'     => esc_html__( 'Dropdown Background', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-dropdown' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'dropdown_link_styles' );

		$this->start_controls_tab( 'dropdown_link_normal', [ 'label' => esc_html__( 'Normal', 'ap-companion' ) ] );

		$this->add_control(
			'dropdown_link_color',
			[
				'label'     => esc_html__( 'Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-dropdown-nav > li > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dropdown_link_background',
			[
				'label'     => esc_html__( 'Background', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-dropdown-nav > li > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_link_spacing',
			[
				'label' => esc_html__( 'Gap', 'ap-companion' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 25,
					],
				],
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .ap-navbar-dropdown-nav > li + li' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dropdown_link_padding',
			[
				'label'      => esc_html__( 'Padding', 'ap-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ap-navbar-dropdown-nav > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'dropdown_link_border',
				'label'    => esc_html__( 'Border', 'ap-companion' ),
				'default'  => '1px',
				'selector' => '{{WRAPPER}} .ap-navbar-dropdown-nav > li > a',
			]
		);

		$this->add_control(
			'dropdown_link_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ap-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ap-navbar-dropdown-nav > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'dropdown_link_typography',
				'label'    => esc_html__( 'Typography', 'ap-companion' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ap-navbar-dropdown-nav > li > a',
			]
		);

		$this->add_control(
			'dropdown_parent_arrow_color',
			[
				'label'     => esc_html__( 'Parent Indicator Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.ap-navbar-parent-indicator-yes .ap-navbar-dropdown-nav > li.ap-parent a:after' => 'color: {{VALUE}};',
				],
				'condition' => ['menu_parent_arrow' => 'yes'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'dropdown_link_hover', [ 'label' => esc_html__( 'Hover', 'ap-companion' ) ] );

		$this->add_control(
			'dropdown_link_hover_color',
			[
				'label'     => esc_html__( 'Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-dropdown-nav > li > a:hover' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'dropdown_link_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-dropdown-nav > li > a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dropdown_border_hover_color',
			[
				'label'     => esc_html__( 'Border Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-navbar-dropdown-nav > li > a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dropdown_radius_hover',
			[
				'label'      => esc_html__( 'Border Radius', 'ap-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ap-navbar-dropdown-nav > li > a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'dropdown_typography_hover',
				'label'    => esc_html__( 'Typography', 'ap-companion' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ap-navbar-dropdown-nav > li > a:hover',
			]
		);

		$this->add_control(
			'dropdown_parent_arrow_color_hover',
			[
				'label'     => esc_html__( 'Parent Indicator Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.ap-navbar-parent-indicator-yes .ap-navbar-dropdown-nav > li.ap-parent a:hover::after' => 'color: {{VALUE}};',
				],
				'condition' => ['menu_parent_arrow' => 'yes'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'dropdown_link_active', [ 'label' => esc_html__( 'Active', 'ap-companion' ) ] );

			$this->add_control(
				'dropdown_active_color',
				[
					'label'     => esc_html__( 'Color', 'ap-companion' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ap-navbar-dropdown-nav > li.ap-active > a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'dropdown_active_bg_color',
				[
					'label'     => esc_html__( 'Background', 'ap-companion' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ap-navbar-dropdown-nav > li.ap-active > a' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'dropdown_active_border',
					'label'    => esc_html__( 'Border', 'ap-companion' ),
					'default'  => '1px',
					'selector' => '{{WRAPPER}} .ap-navbar-dropdown-nav > li.ap-active > a',
				]
			);

			$this->add_control(
				'dropdown_active_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'ap-companion' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .ap-navbar-dropdown-nav > li.ap-active > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'dropdown_typography_active',
					'label'    => esc_html__( 'Typography', 'ap-companion' ),
					'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .ap-navbar-dropdown-nav > li.ap-active > a',
				]
			);

			$this->add_control(
				'dropdown_parent_arrow_color_active',
				[
					'label'     => esc_html__( 'Parent Indicator Color', 'ap-companion' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.ap-navbar-parent-indicator-yes .ap-navbar-dropdown-nav > li.ap-parent.ap-active a:after' => 'color: {{VALUE}};',
					],
					'condition' => ['menu_parent_arrow' => 'yes'],
				]
			);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();
		$id       = 'ap-navbar-' . $this->get_id();
		$nav_menu = ! empty( $settings['navbar'] ) ? wp_get_nav_menu_object( $settings['navbar'] ) : false;

		if ( ! $nav_menu ) {
			return;
		}

		$nav_menu_args = array(
			'fallback_cb'    => false,
			'container'      => false,
			'menu_id'        => 'ap-navmenu',
			'menu_class'     => 'ap-navbar-nav',
			'theme_location' => 'default_navmenu',
			'menu'           => $nav_menu,
			'echo'           => true,
			'depth'          => 0,
			
		);

		$this->add_render_attribute(
			[
				'navbar-attr' => [
					'class' => [
						'ap-navbar-container',
						'ap-navbar'
					],
					
				]
			]
		);

		?>
		<div id="<?php echo esc_attr($id); ?>" class="ap-navbar-wrapper">
			<nav <?php echo $this->get_render_attribute_string( 'navbar-attr' ); ?>>
				<?php wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $settings ) ); ?>
			</nav>

			<div class="ap-mobile-nav-wrapper">
				<div class="ap-nav-toggle">
					  <div class="ap-nav-icon"><span></span></div>
				</div>
				<div class="side-nav ap-side-mobile-nav" id="ap-mob-side-nav">
					<?php wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $settings ) ); ?>
				</div>
			</div>
		</div>
		<?php
	}
}