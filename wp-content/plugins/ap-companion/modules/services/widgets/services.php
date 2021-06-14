<?php
namespace ApCompanion\Modules\Services\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;


use ApCompanion\Group_Control_Query;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Services extends Widget_Base {

	public function get_name() {
		return 'ap-services';
	}

	public function get_title() {
		return  esc_html__( 'Services', 'ap-companion' );
	}

	public function get_icon() {
		return 'ap-ea-icons ap-services';
	}

	public function get_categories() {
		return [ 'ap-elements' ];
	}

	
	protected function _register_controls() {

        $this->start_controls_section(
            'ap_layout_option',
            [
                'label' => esc_html__( 'Services Layout', 'ap-companion' )
            ]
        );

        $this->add_control(
            'ap_multiple_layout', [
                'label'         => esc_html__( 'Layout', 'ap-companion' ),
                'default' => 'default',
                'type'          => Controls_Manager::SELECT,
                'options' => [
                    'default' => esc_html__('Default', 'ap-companion'),
                    'layout2' => esc_html__('Layout 2', 'ap-companion'),
                    'layout3' => esc_html__('Layout 3', 'ap-companion'),
                    'layout4' => esc_html__('Layout 4', 'ap-companion'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_controls',
            [
                'label' => esc_html__( 'Services Options', 'ap-companion' )
            ]
        );
        

        $this->add_control(
            'ap_multiple_test_data',
            [
                'type'      => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'fields' => [
                    [
                        'name'          => 'ap_multiple_img',
                        'label'         => esc_html__( 'Image', 'ap-companion' ),
                        'type'          => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'name'          => 'ap_multiple_services_title',
                        'label'         => esc_html__( 'Name', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXT,
                    ],
                     [
                        'name'          => 'ap_multiple_icon_select',
                        'label'         => esc_html__( 'Icon Type', 'ap-companion' ),
                        'type'          => Controls_Manager::SELECT,
                        'options' => [
                            'icon' => esc_html__('Icon', 'ap-companion'),
                            'img' => esc_html__('Image', 'ap-companion'),
                        ],
                        'default' => 'icon',
                    ],
                    [
                        'name'          => 'ap_multiple_icon_img',
                        'label'         => esc_html__( 'Icon Image', 'ap-companion' ),
                        'type'          => Controls_Manager::MEDIA,
                        'condition' => [
                            'ap_multiple_icon_select' => 'img'
                        ],
                    ],
                    [
                        'name'          => 'ap_multiple_icon',
                        'label'         => esc_html__( 'Icon', 'ap-companion' ),
                        'type'          => Controls_Manager::ICONS,
                        'condition' => [
                            'ap_multiple_icon_select' => 'icon'
                        ],
                    ],
                    [
                        'name'          => 'ap_multiple_desc',
                        'label'         => esc_html__( 'Description', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXTAREA,
                    ],
                    [
                        'name'          => 'ap_multiple_readmore_link',
                        'label'         => esc_html__( 'Read More Link', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXT,
                    ],
                    [
                        'name'          => 'ap_multiple_readmore_text',
                        'label'         => esc_html__( 'Read More Text', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXT,
                    ],
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'ap_slider_option',
            [
                'label' => esc_html__( 'Slider Options', 'ap-companion' )
            ]
        );

        $this->add_control(
            'ap_slider_count', [

                'label'         => esc_html__( 'No. Of Slides', 'ap-companion' ),
                'default'       => 4,
                'type'          => Controls_Manager::NUMBER,
                'min'           => 1
            ]
        );

        $this->end_controls_section();

        
        /**
        * Styling tab
        */
        $this->start_controls_section(
            'section_general_style',
            [
                'label' => esc_html__( 'General Styles', 'ap-companion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        //slider title
        $this->add_control(
            'name_color',
            [
                'label'     => esc_html__( 'Name Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .inner-wrapp .sl-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'name_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .inner-wrapp .sl-title a',
                
            ]
        );

        $this->add_control(
            'desi_color',
            [
                'label'     => esc_html__( 'icon Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .inner-wrapp .icon-wrapp' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__( 'Description Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .inner-wrapp .desc-wrapp' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'desc_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .inner-wrapp .desc-wrapp',
                
            ]
        );

        $this->add_control(
            'linktext_color',
            [
                'label'     => esc_html__( 'Readmore Text Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .inner-wrapp .read-more-link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'linktext_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .inner-wrapp .read-more-link',
                
            ]
        );


        $this->end_controls_section();//end for styling tab



    }

    protected function render() {
      $settings         	= $this->get_settings_for_display();
      $ap_multiple_layout   = $settings['ap_multiple_layout'];
      $ap_slider_count      = $settings['ap_slider_count'];

      $this->add_render_attribute( 'ap-companion-attr', 'class', 'ap-companion-services' );
      $this->add_render_attribute( 'ap-companion-attr', 'class', $ap_multiple_layout );
      ?>
      <div <?php echo $this->get_render_attribute_string('ap-companion-attr')?> >

        <div class="slider-wrapp" data-count="<?php echo absint($ap_slider_count);?>">
            
            <?php foreach( $settings['ap_multiple_test_data'] as $item ){

                $ap_multiple_img                = $item['ap_multiple_img'];
                $ap_multiple_services_title     = $item['ap_multiple_services_title'];
                $ap_multiple_icon               = $item['ap_multiple_icon'];
                $ap_multiple_icon_img           = $item['ap_multiple_icon_img'];
                $ap_multiple_desc               = $item['ap_multiple_desc'];
                $ap_multiple_readmore_link      = $item['ap_multiple_readmore_link'];
                $ap_multiple_readmore_text      = $item['ap_multiple_readmore_text'];
                $ap_multiple_icon_select        = $item['ap_multiple_icon_select'];
                $image_id                       = $ap_multiple_icon_img['id'];
                $image_alt                      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                
                ?>
                <div class="inner-wrapp">
                    <div class="services-single-wrapp">
                        <div class="services-img-icon">
                            <?php if(!empty($ap_multiple_img['url'])){ ?>
                                <img src="<?php echo esc_url($ap_multiple_img['url']);?>" >
                            <?php } ?>
                            <?php if( !empty($ap_multiple_icon['value']) && ($ap_multiple_icon_select == 'icon') ){ ?>
                                <a target="_blank" href="<?php echo esc_attr($ap_multiple_readmore_link);?>">
                                    <div class="icon-wrapp">
                                        <?php Icons_Manager::render_icon( $ap_multiple_icon ); ?>
                                    </div>
                                </a>
                            <?php }elseif( $ap_multiple_icon_img['url'] && $ap_multiple_icon_select == 'img' ){ ?>
                                    <a target="_blank" href="<?php echo esc_attr($ap_multiple_readmore_link);?>">
                                        <div class="icon-wrapp">
                                            <img src="<?php echo esc_url($ap_multiple_icon_img['url'])?>" alt="<?php echo esc_attr($image_alt)?>">
                                        </div>
                                    </a>
                            <?php } ?>
                        </div>
                        <div class="contents-wrapp">
                            <?php if(!empty($ap_multiple_services_title)){ ?>
                                <h2 class="sl-title">
                                    <a class="read-more-link" href="<?php echo esc_attr($ap_multiple_readmore_link);?>">
                                        <?php echo wp_kses_post($ap_multiple_services_title); ?>
                                    </a>
                                </h2>
                            <?php } ?>
                            <?php if(!empty($ap_multiple_desc)){ ?>
                                <div class="desc-wrapp">
                                    <?php echo esc_html($ap_multiple_desc); ?>
                                </div>
                            <?php } ?>
                            <?php if(!empty($ap_multiple_readmore_text)){ ?>
                                <a class="read-more-link" href="<?php echo esc_attr($ap_multiple_readmore_link);?>">
                                    <?php echo esc_html($ap_multiple_readmore_text); ?>
                                </a>
                            <?php } ?>
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