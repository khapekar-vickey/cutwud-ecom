<?php
namespace ApCompanion\Modules\Testimonials\Widgets;

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

class Testimonials extends Widget_Base {

	public function get_name() {
		return 'ap-testimonials';
	}

	public function get_title() {
		return  esc_html__( 'Testimonials', 'ap-companion' );
	}

	public function get_icon() {
		return 'ap-ea-icons ap-testimonials';
	}

	public function get_categories() {
		return [ 'ap-elements' ];
	}

	
	protected function _register_controls() {

        $this->start_controls_section(
            'ap_layout_option',
            [
                'label' => esc_html__( 'Testimonial Layout', 'ap-companion' )
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
                    'layout5' => esc_html__('Layout 5', 'ap-companion'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_controls',
            [
                'label' => esc_html__( 'Testimonial Options', 'ap-companion' )
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
                        'name'          => 'ap_multiple_test_title',
                        'label'         => esc_html__( 'Name', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXT,
                    ],
                    [
                        'name'          => 'ap_multiple_designation',
                        'label'         => esc_html__( 'Designation', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXT,
                    ],                    
                    [
                        'name'          => 'ap_multiple_desc',
                        'label'         => esc_html__( 'Description', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXTAREA,
                    ],

                ],
                // 'default' => [
                //     [ 'ap_multiple_test_title' => 'Testimonial Title' ],
                // ],
                // 'title_field' => '{{{ ap_multiple_test_title }}}',
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
                    '{{WRAPPER}} .inner-wrapp .sl-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'name_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .inner-wrapp .sl-title',
                
            ]
        );

        $this->add_control(
            'desi_color',
            [
                'label'     => esc_html__( 'Designation Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .inner-wrapp .designation-wrapp' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'desi_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .inner-wrapp .designation-wrapp',
                
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


        $this->end_controls_section();//end for styling tab



    }

    protected function render() {
        $settings         	= $this->get_settings_for_display();
        $ap_multiple_layout   = $settings['ap_multiple_layout'];

        $this->add_render_attribute( 'ap-companion-attr', 'class', 'ap-companion-testimonials' );
        $this->add_render_attribute( 'ap-companion-attr', 'class', $ap_multiple_layout );
        ?>
        <div <?php echo $this->get_render_attribute_string('ap-companion-attr')?> >
            <div class="slider-wrapp">
                <?php
                foreach( $settings['ap_multiple_test_data'] as $item ){
                    if( $ap_multiple_layout == 'layout2' ){
                        $this->testimonial_layout_two($item);
                    }elseif( $ap_multiple_layout == 'layout3' ){
                        $this->testimonial_layout_three($item);
                    }elseif( $ap_multiple_layout == 'layout4' ){
                        $this->testimonial_layout_four($item);
                    }elseif( $ap_multiple_layout == 'layout5' ){
                        $this->testimonial_layout_three($item);
                    }else{
                        $this->testimonial_layout_one($item);
                    }
                }
                ?>
            </div>
        </div>
        <?php 	
    }

    /**
    * Default layout
    */
    protected function testimonial_layout_one($item){

        $ap_multiple_img            = $item['ap_multiple_img'];
        $ap_multiple_test_title     = $item['ap_multiple_test_title'];
        $ap_multiple_designation    = $item['ap_multiple_designation'];
        $ap_multiple_desc           = $item['ap_multiple_desc'];
        ?>
        <div class="inner-wrapp">
            <?php
            if(!empty($ap_multiple_img['url'])){ ?>
                <img src="<?php echo esc_url($ap_multiple_img['url']);?>" />
            <?php } ?>
            <div class="contents-wrapp">
                <?php if(!empty($ap_multiple_test_title)){ ?>
                    <h2 class="sl-title">
                        <?php echo wp_kses_post($ap_multiple_test_title); ?>
                    </h2>
                <?php }
                if(!empty($ap_multiple_designation)){
                    ?>
                    <div class="designation-wrapp">
                        <?php echo wp_kses_post($ap_multiple_designation); ?>
                    </div>
                    <?php
                }
                if(!empty($ap_multiple_desc)){ ?>
                    <div class="desc-wrapp">
                        <?php echo esc_html($ap_multiple_desc); ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }

    /**
    * layout 2
    */
    protected function testimonial_layout_two($item){

        $ap_multiple_img            = $item['ap_multiple_img'];
        $ap_multiple_test_title     = $item['ap_multiple_test_title'];
        $ap_multiple_designation    = $item['ap_multiple_designation'];
        $ap_multiple_desc           = $item['ap_multiple_desc'];
        ?>
        <div class="inner-wrapp">
            <div class="img-tit-wrap">
                <?php
                if(!empty($ap_multiple_img['url'])){ ?>
                    <img src="<?php echo esc_url($ap_multiple_img['url']);?>" >
                    <?php 
                }
                ?>
                <div class="tit-desc">
                    <?php
                    if(!empty($ap_multiple_test_title)){ ?>
                        <h2 class="sl-title">
                            <?php echo wp_kses_post($ap_multiple_test_title); ?>
                        </h2>
                    <?php }
                    if(!empty($ap_multiple_designation)){ ?>
                        <div class="designation-wrapp">
                            <?php echo wp_kses_post($ap_multiple_designation); ?>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
            <div class="contents-wrapp">
                <?php
                if(!empty($ap_multiple_desc)){ ?>
                    <div class="desc-wrapp">
                        <?php echo esc_html($ap_multiple_desc); ?>
                    </div>
                    <?php
                } ?>
            </div>
        </div>
        <?php
    }

    /**
    * 3 layout
    */
    protected function testimonial_layout_three($item){

        $ap_multiple_img            = $item['ap_multiple_img'];
        $ap_multiple_test_title     = $item['ap_multiple_test_title'];
        $ap_multiple_designation    = $item['ap_multiple_designation'];
        $ap_multiple_desc           = $item['ap_multiple_desc'];

        $settings           = $this->get_settings_for_display();
        $ap_multiple_layout   = $settings['ap_multiple_layout'];
        ?>
        <div class="inner-wrapp">
            <?php
            if(!empty($ap_multiple_desc)){ ?>
                <div class="desc-wrapp">
                    <?php if($ap_multiple_layout=='layout3'){ ?>
                        <div class="svg-wrapp">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="508.044px" height="508.044px" viewBox="0 0 508.044 508.044" style="enable-background:new 0 0 508.044 508.044;" xml:space="preserve"><g><g><path d="M0.108,352.536c0,66.794,54.144,120.938,120.937,120.938c66.794,0,120.938-54.144,120.938-120.938s-54.144-120.937-120.938-120.937c-13.727,0-26.867,2.393-39.168,6.61C109.093,82.118,230.814-18.543,117.979,64.303C-7.138,156.17-0.026,348.84,0.114,352.371C0.114,352.426,0.108,352.475,0.108,352.536z"/><path d="M266.169,352.536c0,66.794,54.144,120.938,120.938,120.938s120.938-54.144,120.938-120.938S453.9,231.599,387.106,231.599c-13.728,0-26.867,2.393-39.168,6.61C375.154,82.118,496.875-18.543,384.04,64.303C258.923,156.17,266.034,348.84,266.175,352.371C266.175,352.426,266.169,352.475,266.169,352.536z"/></g></g></svg>
                        </div>
                    <?php } ?>
                    <div class="text-wrapp">
                        <?php echo esc_html($ap_multiple_desc); ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="contents-wrapp">
                <?php
                if(!empty($ap_multiple_img['url'])){ ?>
                    <img src="<?php echo esc_url($ap_multiple_img['url']);?>" alt="" />
                <?php }
                ?>
                <div class="title-desc-wrap">
                    <?php
                    if(!empty($ap_multiple_test_title)){ ?>
                        <h2 class="sl-title">
                            <?php echo wp_kses_post($ap_multiple_test_title); ?>
                        </h2>
                    <?php }
                    if(!empty($ap_multiple_designation)){
                        ?>
                        <div class="designation-wrapp">
                            <?php echo wp_kses_post($ap_multiple_designation); ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }

    /**
    * 4 layout
    */
    protected function testimonial_layout_four($item){

        $ap_multiple_img            = $item['ap_multiple_img'];
        $ap_multiple_test_title     = $item['ap_multiple_test_title'];
        $ap_multiple_designation    = $item['ap_multiple_designation'];
        $ap_multiple_desc           = $item['ap_multiple_desc'];
        ?>
        <div class="inner-wrapp">
            <?php
            if(!empty($ap_multiple_img['url'])){
                ?>
                <img src="<?php echo esc_url($ap_multiple_img['url']);?>" >
                <?php 
            }
            ?>
            <div class="contents-wrapp">
                <?php
                if(!empty($ap_multiple_desc)){ ?>
                    <div class="desc-wrapp">
                        <?php echo esc_html($ap_multiple_desc); ?>
                    </div>
                    <?php
                }
                if(!empty($ap_multiple_test_title)){ ?>
                    <h2 class="sl-title">
                        <?php echo wp_kses_post($ap_multiple_test_title); ?>
                    </h2>
                <?php }
                if(!empty($ap_multiple_designation)){
                    ?>
                    <div class="designation-wrapp">
                        <?php echo wp_kses_post($ap_multiple_designation); ?>
                    </div>
                    <?php
                }
                ?>
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