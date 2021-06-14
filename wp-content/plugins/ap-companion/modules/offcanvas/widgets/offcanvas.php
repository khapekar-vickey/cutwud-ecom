<?php
namespace ApCompanion\Modules\Offcanvas\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Offcanvas Widget
 * @since 1.2.0
 */
class Offcanvas extends Widget_Base {

	public function get_name() {
		return 'ap-offcanvas';
	}

	public function get_title() {
		return  esc_html__( 'Offcanvas', 'ap-companion' );
	}

	public function get_icon() {
		return 'ap-ea-icons ap-offcanvas';
	}

	public function get_categories() {
		return [ 'ap-elements' ];
	}

	public function get_script_depends() {
        return [ 'ap-frontend'];
    }

	

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'ap-companion' ),
			]
		);

	

		$this->add_control(
			'source',
			[
				'label'   => esc_html__( 'Select Source', 'ap-companion' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sidebar',
				'options' => [
					'sidebar'   => esc_html__( 'Sidebar', 'ap-companion' ),
					'elementor' => esc_html__( 'Elementor Template', 'ap-companion' )
				],				
			]
		);

        $this->add_control(
            'template_id',
            [
                'label'       => __( 'Choose Template', 'ap-companion' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => '0',
                'options'     => ap_companion_get_elementor_templates(),
                'label_block' => 'true',
                'condition'   => ['source' => 'elementor'],
            ]
        );

        $this->add_control(
            'sidebars',
            [
                'label'       => esc_html__( 'Choose Sidebar', 'ap-companion' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => '0',
                'options'     => ap_companion_sidebar_options(),
                'label_block' => 'true',
                'condition'   => ['source' => 'sidebar'],
            ]
        );

        

		$this->add_responsive_control(
			'offcanvas_width',
			[
				'label'      => esc_html__( 'Width', 'ap-companion' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 240,
						'max' => 1200,
					],
					'vw' => [
						'min' => 10,
						'max' => 100,
					]
				],
				'selectors' => [
					'#ap-offcanvas-{{ID}}.ap-offcanvas .ap-offcanvas-bar' => 'width: {{SIZE}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'custom_content_before_switcher',
			[
				'label' => esc_html__( 'Custom Content Before', 'ap-companion' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'custom_content_after_switcher',
			[
				'label' => esc_html__( 'Custom Content After', 'ap-companion' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		


		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_custom_before',
			[
				'label'     => esc_html__( 'Custom Content Before', 'ap-companion' ),
				'condition' => [
					'custom_content_before_switcher' => 'yes',
				]
			]
		);

		$this->add_control(
			'custom_content_before',
			[
				'label'   => esc_html__( 'Custom Content Before', 'ap-companion' ),
				'type'    => Controls_Manager::WYSIWYG,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'Custom content before your offcanvas.', 'ap-companion' ),
			]
		);
		
		$this->end_controls_section();


		$this->start_controls_section(
			'section_content_custom_after',
			[
				'label'     => esc_html__( 'Custom Content After', 'ap-companion' ),
				'condition' => [
					'custom_content_after_switcher' => 'yes',
				]
			]
		);


		$this->add_control(
			'custom_content_after',
			[
				'label'   => esc_html__( 'Custom Content After', 'ap-companion' ),
				'type'    => Controls_Manager::WYSIWYG,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'Custom content after your offcanvas.', 'ap-companion' ),
			]
		);
		
		$this->end_controls_section();


		$this->start_controls_section(
			'section_content_offcanvas_button',
			[
				'label' => esc_html__( 'Button', 'ap-companion' ),
				
			]
		);

	

		$this->add_responsive_control(
			'button_align',
			[
				'label'   => esc_html__( 'Button Alignment', 'ap-companion' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'ap-companion' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default'      => 'left',
			]
		);

		$this->add_responsive_control(
			'button_offset',
			[
				'label' => esc_html__( 'Offset', 'ap-companion' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -150,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ap-offcanvas-button' => 'transform: translateX({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'size',
			[
				'label'   => __( 'Size', 'ap-companion' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => [
			        'xs' => esc_html__( 'Extra Small', 'ap-companion' ),
			        'sm' => esc_html__( 'Small', 'ap-companion' ),
			        'md' => esc_html__( 'Medium', 'ap-companion' ),
			        'lg' => esc_html__( 'Large', 'ap-companion' ),
			        'xl' => esc_html__( 'Extra Large', 'ap-companion' ),
			    ]
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label'       => esc_html__( 'Button Icon', 'ap-companion' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'default'     => 'fa fa-bars',
			]
		);

		

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_offcanvas_content',
			[
				'label' => esc_html__( 'Offcanvas', 'ap-companion' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'offcanvas_content_color',
			[
				'label'     => esc_html__( 'Text Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#ap-offcanvas-{{ID}}.ap-offcanvas .ap-offcanvas-bar *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_link_color',
			[
				'label'     => esc_html__( 'Link Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#ap-offcanvas-{{ID}}.ap-offcanvas .ap-offcanvas-bar a'   => 'color: {{VALUE}};',
					'#ap-offcanvas-{{ID}}.ap-offcanvas .ap-offcanvas-bar a *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_link_hover_color',
			[
				'label'     => esc_html__( 'Link Hover Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#ap-offcanvas-{{ID}}.ap-offcanvas .ap-offcanvas-bar a:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'offcanvas_content_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#ap-offcanvas-{{ID}}.ap-offcanvas .ap-offcanvas-bar' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'offcanvas_content_shadow',
				'selector'  => '#ap-offcanvas-{{ID}}.ap-offcanvas > div',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'offcanvas_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'ap-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#ap-offcanvas-{{ID}}.ap-offcanvas .ap-offcanvas-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_offcanvas_widget',
			[
				'label'     => esc_html__( 'Widget', 'ap-companion' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'source' => 'sidebar',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'offcanvas_widget_border',
				'label'       => esc_html__( 'Border', 'ap-companion' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#ap-offcanvas-{{ID}}.ap-offcanvas .ap-offcanvas-bar .widget',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'widget_border_radius',
			[
				'label'      => esc_html__( 'Radius', 'ap-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'#ap-offcanvas-{{ID}}.ap-offcanvas .ap-offcanvas-bar .widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'offcanvas_widget_padding',
			[
				'label'      => esc_html__( 'Padding', 'ap-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#ap-offcanvas-{{ID}}.ap-offcanvas .ap-offcanvas-bar .widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'offcanvas_vertical_spacing',
			[
				'label'     => esc_html__( 'Vertical Spacing', 'ap-companion' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'#ap-offcanvas-{{ID}}.ap-offcanvas .ap-offcanvas-bar .widget:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_offcanvas_button',
			[
				'label' => esc_html__( 'Button', 'ap-companion' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				
			]
		);

		$this->start_controls_tabs( 'tabs_offcanvas_button_style' );

		$this->start_controls_tab(
			'tab_offcanvas_button_normal',
			[
				'label' => esc_html__( 'Normal', 'ap-companion' ),
			]
		);

		
		$this->add_control(
			'offcanvas_button_color',
			[
				'label'     => esc_html__( 'Button Text Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-offcanvas-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_button_background_color',
			[
				'label'     => esc_html__( 'Button Background Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-offcanvas-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'offcanvas_button_shadow',
				'selector'  => '{{WRAPPER}} .ap-offcanvas-button',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'offcanvas_button_border',
				'label'       => esc_html__( 'Border', 'ap-companion' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .ap-offcanvas-button',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'offcanvas_button_border_radius',
			[
				'label'      => esc_html__( 'Radius', 'ap-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ap-offcanvas-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'ap-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ap-offcanvas-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'offcanvas_button_typography',
				'label'     => esc_html__( 'Typography', 'ap-companion' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .ap-offcanvas-button',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_offcanvas_button_hover',
			[
				'label' => esc_html__( 'Hover', 'ap-companion' ),
			]
		);

		$this->add_control(
			'offcanvas_button_hover_color',
			[
				'label'     => esc_html__( 'Button Text Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-offcanvas-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_button_background_hover_color',
			[
				'label'     => esc_html__( 'Button Background Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ap-offcanvas-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_button_hover_border_color',
			[
				'label'     => esc_html__( 'Button Border Color', 'ap-companion' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'offcanvas_button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ap-offcanvas-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Button Animation', 'ap-companion' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = 'ap-offcanvas-' . $this->get_id();

		$this->add_render_attribute( 'offcanvas', 'class', 'ap-offcanvas' );
		$this->add_render_attribute( 'offcanvas', 'id', $id );
        $this->add_render_attribute(
        	[
        		'offcanvas' => [
        			'data-settings' => [
        				wp_json_encode(array_filter([
							'id'      =>  $id,
							'layout'  => 'default',
        		        ]))
        			]
        		]
        	]
        );
		

		?>

		
		<?php $this->render_button(); ?>

		
	    <div <?php echo $this->get_render_attribute_string( 'offcanvas' ); ?>>
	        <div class="ap-offcanvas-bar">
				
				
        		<button class="ap-offcanvas-close" type="button" ap-close>
        			<svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon"><line fill="none"  stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line><line fill="none" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line></svg>
        		</button>
	        

	        	
				<?php if ($settings['custom_content_before_switcher'] or $settings['custom_content_after_switcher'] or !empty( $settings['source'] )) : ?>
		        	<?php if ($settings['custom_content_before_switcher'] === 'yes' and !empty($settings['custom_content_before'])) : ?>
		        	<div class="ap-offcanvas-custom-content-before widget">
		            	<?php echo wp_kses_post($settings['custom_content_before']); ?>		        		
		        	</div>
		        	<?php endif; ?>

		            <?php 
		            	if ( 'sidebar' == $settings['source'] and !empty( $settings['sidebars'] ) ) {
		            		dynamic_sidebar( $settings['sidebars'] );
		            	} elseif ('elementor' == $settings['source'] and !empty( $settings['template_id'] )) {
		            		echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($settings['template_id']);
		            	}
		            ?>

	            	<?php if ($settings['custom_content_after_switcher'] === 'yes' and !empty($settings['custom_content_after'])) : ?>
	            	<div class="ap-offcanvas-custom-content-after widget">
	                	<?php echo wp_kses_post($settings['custom_content_after']); ?>		        		
	            	</div>
	            	<?php endif; ?>
	            <?php else: ?>
					<div class="ap-offcanvas-custom-content-after widget">
						<div class="ap-alert-warning" ap-alert><?php esc_html_e('Ops you don\'t select or enter any content! Add your offcanvas content from editor.', 'ap-companion'); ?></div>
					</div>
	            <?php endif; ?>
	        </div>
	    </div>

		<?php
	}

	protected function render_button() {
		$settings = $this->get_settings_for_display();
		$id       = 'ap-offcanvas-' . $this->get_id();

	

		$this->add_render_attribute( 'button', 'class', ['ap-offcanvas-button', 'elementor-button'] );

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		$this->add_render_attribute( 'button', 'ap-toggle', 'target: #' . esc_attr($id) );
		$this->add_render_attribute( 'button', 'href', 'javascript:void(0)' );

		$this->add_render_attribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );
		$this->add_render_attribute( 'icon-align', 'class', 'ap-offcanvas-button-icon elementor-button-icon' );

		$this->add_render_attribute( 'text', 'class', 'elementor-button-text' );

		?>

		<div class="ap-offcanvas-button-wrapper">
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?> >
			
				<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
					<?php if ( ! empty( $settings['button_icon'] ) ) : ?>
					<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
						<i class="<?php echo esc_attr( $settings['button_icon'] ); ?>" aria-hidden="true"></i>
					</span>
					<?php endif; ?>
					
				</span>

			</a>
		</div>
		<?php
	}
}
