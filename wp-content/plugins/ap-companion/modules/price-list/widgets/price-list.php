<?php
namespace ApCompanion\Modules\PriceList\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

use ApCompanion\Group_Control_Query;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Price_List extends Widget_Base {

    public function get_name() {
        return 'ap-price-list';
    }

    public function get_title() {
        return  esc_html__( 'Price List', 'ap-companion' );
    }

    public function get_icon() {
        return 'ap-ea-icons ap-price-list';
    }

    public function get_categories() {
        return [ 'ap-elements' ];
    }

    

    protected function _register_controls() {   

        $this->start_controls_section(
            'section_content_heading',
            [
                'label' => esc_html__( 'General Settings', 'ap-companion' ),
            ]
        );
        
      
        $this->add_control(
            'ap_multiple_price_data',
            [
                'type'      => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'fields' => [
                
                    [
                        'name'          => 'ap_price_title',
                        'label'         => esc_html__( 'Title', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXT,
                    ],
                 
                    [
                        'name'          => 'ap_desc',
                        'label'         => esc_html__( 'Description', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXTAREA,
                    ],

                    [
                        'name'          => 'ap_price',
                        'label'         => esc_html__( 'Price', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXT,
                    ],
                   
                ],
            ]
        );

        $this->end_controls_section();


     

        /**
        * Styling tab
        */
        $this->start_controls_section(
            'section_general_style',
            [
                'label' => esc_html__( 'Pricing Styles', 'ap-companion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ap-pricing-lists .text-wrapp h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-pricing-lists .text-wrapp h3',
                
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__( 'Description Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .ap-pricing-lists p.desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'desc_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-pricing-lists p.desc',
                
            ]
        );


        $this->add_control(
            'price_color',
            [
                'label'     => esc_html__( 'Price Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .ap-pricing-lists span.price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'price_typography_pl',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-pricing-lists span.price',
                
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'pricing_border',
                'label'    => esc_html__( 'Border', 'ap-companion' ),
                'separator'  => 'before',
                'selector' => '{{WRAPPER}} .ap-price-wrapp',
            ]
        );

        $this->add_responsive_control(
            'menu_offset',
            [
                'label' => esc_html__( 'Offset', 'ap-companion' ),
                'type'  => Controls_Manager::SLIDER,
                'separator'  => 'before',
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                    ],
                ],
                'size_units' => [ 'px' ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .ap-price-wrapp' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


       

        $this->end_controls_section();//end for main slide style

        

        
    }

    protected function render() {
        $settings           = $this->get_settings_for_display();
     
        
        
        $this->add_render_attribute( 'ap-attr', 'class', 'ap-pricing-lists ' );
        
    ?>
    <div <?php echo $this->get_render_attribute_string('ap-attr')?> >
        
        <?php foreach( $settings['ap_multiple_price_data'] as $item ){ 

            $ap_price_title = $item['ap_price_title'];
            $ap_desc        = $item['ap_desc'];
            $ap_price       = $item['ap_price'];
            ?>
            <div class="ap-price-wrapp clearfix">
                
                <div class="text-wrapp">
                    <h3><?php echo esc_html($ap_price_title); ?></h3>
                    <p class="desc"><?php echo wp_kses_post($ap_desc); ?></p>
                </div>    

                <span class="price">
                    <?php echo esc_html($ap_price); ?>
                </span>

            </div>

                
        <?php } ?>


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