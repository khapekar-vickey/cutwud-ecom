<?php
namespace ApCompanion\Modules\Slider2\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

use ApCompanion\Group_Control_Query;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Slider2 extends Widget_Base {

	public function get_name() {
		return 'ap-slider2';
	}

	public function get_title() {
		return  esc_html__( 'Slider 2', 'ap-companion' );
	}

	public function get_icon() {
		return 'ap-ea-icons ap-ea-sl2';
	}

	public function get_categories() {
		return [ 'ap-elements' ];
	}

	
	protected function _register_controls() {

        $this->start_controls_section(
            'slider_controls',
            [
                'label' => esc_html__( 'Slider Options', 'ap-companion' )
            ]
        );

        $this->add_control(
            'ap_multiple_slider_data',
            [
                'type'      => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => [
                    [ 'ap_multiple_img_title' => 'Slider Title' ],
                   
                ],
                'fields' => [
                    [
                        'name'          => 'ap_multiple_img',
                        'label'         => esc_html__( 'Slider Image', 'ap-companion' ),
                        'type'          => Controls_Manager::MEDIA,
                        'default' => [
                                'url' => \Elementor\Utils::get_placeholder_image_src(),
                            ],
                    ],
                    [
                        'name'          => 'ap_multiple_img_desc',
                        'label'         => esc_html__( 'Subtitle', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXT,
                    ],
                    [
                        'name'          => 'ap_multiple_img_title',
                        'label'         => esc_html__( 'Title', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXT,
                    ],
                    
                    [
                        'name'          => 'ap_multiple_btn_label',
                        'label'         => esc_html__( 'Button Label', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXT,
                    ],
                    [
                        'name'          => 'ap_multiple_img_url',
                        'label'         => esc_html__( 'URL', 'ap-companion' ),
                        'type'          => Controls_Manager::URL,
                    ],
              
                  
                ],
                'title_field' => '{{ap_multiple_img_title}}',
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
			'section_content_heading',
			[
				'label' => esc_html__( 'Slider Settings', 'ap-companion' ),
			]
		);

       

		$this->add_control(
			'arrow',
			[
				'label'       => esc_html__( 'Show Arrow', 'ap-companion' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

        $this->add_control(
            'pager',
            [
                'label'       => esc_html__( 'Show Pager', 'ap-companion' ),
                'type'        => Controls_Manager::SWITCHER,
            ]
        );

		$this->end_controls_section();

        
        //styling tab
        $this->start_controls_section(
            'section_general_style',
            [
                'label' => esc_html__( 'General Styles', 'ap-companion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

         $this->add_control(
            'overlay_color',
            [
                'label'     => esc_html__( 'Overlay Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .inner-wrapp .img-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        //slider title
        $this->add_control(
            'sub_title_color',
            [
                'label'     => esc_html__( 'Sub Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .inner-wrapp .contents-wrapp .inner-wrapp .subtitle-wrapp' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'sub_title_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .inner-wrapp .contents-wrapp .inner-wrapp .subtitle-wrapp',
                
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .inner-wrapp .contents-wrapp .sl-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .inner-wrapp .contents-wrapp .sl-title',
                
            ]
        );


        $this->add_control(
            'btn_link_style_title',
            [
                'label'     => esc_html__( 'Button Styles', 'ap-companion' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        //slider button normal
        $this->start_controls_tabs('tabs_style_btn');

        $this->start_controls_tab(
            'tab_style_normal',
            [
                'label' => esc_html__('Normal', 'punte-el-addons'),
            ]
        );

        
        $this->add_control(
            'button_link_color',
            [
                'label'     => esc_html__( 'Link Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.slider-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.slider-btn' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_style_hover',
            [
                'label' => esc_html__('Hover', 'punte-el-addons')
            ]
        );
         $this->add_control(
            'button_link_color_hover',
            [
                'label'     => esc_html__( 'Link Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.slider-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label'     => esc_html__( 'Background Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.slider-btn:hover' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btn_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} a.slider-btn',
            ]
        );


        $this->end_controls_section();//end for styling tab


		
	}

	protected function render() {
		$settings         	= $this->get_settings_for_display();
        $arrow              = $settings['arrow'];
        $pager              = $settings['pager'];
		
		$this->add_render_attribute( 'ap-companion-attr', 'class', 'ap-companion-slider2 ' );
	?>
	<div <?php echo $this->get_render_attribute_string('ap-companion-attr')?> >
	
        <div class="slider-wrapp" data-arrow="<?php echo esc_attr($arrow)?>" data-pager="<?php echo esc_attr($pager)?>">
            <?php foreach( $settings['ap_multiple_slider_data'] as $item ){
                
                $ap_multiple_img        = $item['ap_multiple_img'];
                $ap_multiple_img_title  = $item['ap_multiple_img_title'];
                $ap_multiple_img_desc   = $item['ap_multiple_img_desc'];
                $ap_multiple_btn_label  = $item['ap_multiple_btn_label'];
                $ap_multiple_img_url    = $item['ap_multiple_img_url'];

                if ( ! empty( $ap_multiple_img_url['url'] ) ) {
                    $this->add_render_attribute( 'url', 'href', $ap_multiple_img_url['url'] );

                    if ( $ap_multiple_img_url['is_external'] ) {
                        $this->add_render_attribute( 'url', 'target', '_blank' );
                    }

                    if ( ! empty( $ap_multiple_img_url['nofollow'] ) ) {
                        $this->add_render_attribute( 'url', 'rel', 'nofollow' );
                    }

                    $this->add_render_attribute( 'url', 'class', 'slider-btn' );

                }
                
                ?>
                <div class="inner-wrapp">
                    <img src="<?php echo esc_url($ap_multiple_img['url']);?>" >
                    <div class="img-overlay"></div>
                    <div class="contents-wrapp">
                        <div class="inner-wrapp">
                            <div class="subtitle-wrapp">
                                <?php echo wp_kses_post($ap_multiple_img_desc); ?>
                            </div>
                            <h2 class="sl-title">
                                <?php echo wp_kses_post($ap_multiple_img_title); ?>
                            </h2>
                            
                            <a <?php echo $this->get_render_attribute_string('url')?> >
                                <?php echo esc_html($ap_multiple_btn_label); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>

	</div>
	<?php 	
	}

	/**
	 * Render widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @access protected
	 */
    protected function _content_template() {}

}