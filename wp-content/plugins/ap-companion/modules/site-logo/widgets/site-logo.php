<?php
namespace ApCompanion\Modules\SiteLogo\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



class Site_Logo extends Widget_Base {

	public function get_name() {
		return 'ap-site-logo';
	}

	public function get_title() {
		return __( 'Site Logo', 'ap-companion' );
	}

	public function get_icon() {
		return 'ap-ea-icons ap-site-logo';
	}

	public function get_categories() {
		return [ 'ap-elements' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Site Logo', 'ap-companion' ),
			]
		);

		$this->add_control(
			'display_type',
			[
				'label' => __( 'Display Type', 'ap-companion' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'logo' => esc_html__('Site Logo','ap-companion'),
					'tagline' 	=> esc_html__('Site Title & Tagline','ap-companion'),
					
				],
				'default' => 'site-logo',
			]
		);

		$this->add_control(
			'html_tag',
			[
				'label' => __( 'HTML Tag', 'ap-companion' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p' => 'p',
					'div' => 'div',
					'span' => 'span',
				],
				'default' => 'div',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'ap-companion' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'ap-companion' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'ap-companion' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'ap-companion' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'ap-companion' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_to',
			[
				'label' => __( 'Link to', 'ap-companion' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => __( 'None', 'ap-companion' ),
					'home' => __( 'Home URL', 'ap-companion' ),
					'custom' => __( 'Custom URL', 'ap-companion' ),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'ap-companion' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'ap-companion' ),
				'condition' => [
					'link_to' => 'custom',
				],
				'default' => [
					'url' => '',
				],
				'show_label' => false,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Site Logo', 'ap-companion' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'space',
			[
				'label' => __( 'Size (%)', 'ap-companion' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ap-site-logo img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'display_type' => 'logo',
				],
				
			]
		);

		$this->add_control(
			'opacity',
			[
				'label' => __( 'Opacity (%)', 'ap-companion' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ap-site-logo img' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'display_type' => 'logo',
				],
			]
		);

		$this->add_control(
			'angle',
			[
				'label' => __( 'Angle (deg)', 'ap-companion' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default' => [
					'unit' => 'deg',
					'size' => 0,
				],
				'range' => [
					'deg' => [
						'max' => 360,
						'min' => -360,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ap-site-logo img' => '-webkit-transform: rotate({{SIZE}}deg); -moz-transform: rotate({{SIZE}}deg); -ms-transform: rotate({{SIZE}}deg); -o-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
				],
				'condition' => [
					'display_type' => 'logo',
				],
			]
		);

	

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'label' => __( 'Image Border', 'ap-companion' ),
				'selector' => '{{WRAPPER}} .ap-site-logo img',
				'condition' => [
					'display_type' => 'logo',
				],
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'ap-companion' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ap-site-logo img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'display_type' => 'logo',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .ap-site-logo img',
				'condition' => [
					'display_type' => 'logo',
				],
			]
		);

		$this->add_control(
            'site_title_color',
            [
                'label'     => esc_html__( 'Site Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .ap-site-branding .ap-site-logo a' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
					'display_type' => 'tagline',
				],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'site_title_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-site-branding .ap-site-logo a',
                'condition' => [
					'display_type' => 'tagline',
				],
            ]
        );

        $this->add_control(
            'site_tagline_color',
            [
                'label'     => esc_html__( 'Tagline Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .ap-site-branding p' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
					'display_type' => 'tagline',
				],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'site_tagline_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-site-branding p',
                'condition' => [
					'display_type' => 'tagline',
				],
            ]
        );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();

		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$image 			= $custom_logo_id ? wp_get_attachment_image( $custom_logo_id , 'full' ) : '';
		$logo 			= has_custom_logo() ? $image : '';
		$display_type 	= $settings['display_type'];

		if ( empty( $logo || get_bloginfo( 'name' ) ) )
			return;

		switch ( $settings['link_to'] ) {
			case 'custom' :
				if ( ! empty( $settings['link']['url'] ) ) {
					$link = esc_url( $settings['link']['url'] );
				} else {
					$link = false;
				}
				break;

			case 'home' :
				$link = esc_url( get_home_url() );
				break;

			case 'none' :
			default:
				$link = false;
				break;
		}
		$target = $settings['link']['is_external'] ? 'target="_blank"' : '';

		$html = '<div class="ap-site-branding">';
		$html .= sprintf( '<%1$s class="ap-site-logo">', $settings['html_tag'] );
		if ( $link && $display_type == 'logo' ) {
			$html .= sprintf( '<a href="%1$s" %2$s>%3$s</a>', $link, $target, $logo );
			$html .= sprintf( '</%s>', $settings['html_tag'] );
		} else if($link && $display_type == 'tagline' ){
			$html .= sprintf( '<a href="%1$s" %2$s>%3$s</a>', $link, $target, get_bloginfo('name') );
			$html .= sprintf( '</%s>', $settings['html_tag'] );
			$html .= sprintf( '<p>%1$s</p>', get_bloginfo( 'description', 'display' ) );
		} elseif( ($settings['link_to'] == 'none') && $display_type == 'tagline' ){
			$html .= sprintf( '<a href="%1$s" %2$s>%3$s</a>', $link, $target, get_bloginfo('name') );
			$html .= sprintf( '</%s>', $settings['html_tag'] );
			$html .= sprintf( '<p>%1$s</p>', get_bloginfo( 'description', 'display' ) );
		} elseif( ($settings['link_to'] == 'none') && $display_type == 'logo' ){
			$html .= $logo;
			$html .= sprintf( '</%s>', $settings['html_tag'] );
		} else {
			$html .= $logo;
			$html .= sprintf( '</%s>', $settings['html_tag'] );
		}
		
		$html .= '</div>';

		echo $html;
	}

	 /**
     * Render widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @access protected
     */
	protected function _content_template() {

	}

}


