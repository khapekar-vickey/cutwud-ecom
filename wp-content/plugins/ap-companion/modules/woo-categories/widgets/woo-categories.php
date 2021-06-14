<?php
namespace ApCompanion\Modules\WooCategories\Widgets;

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

class Woo_Categories extends Widget_Base {

	public function get_name() {
		return 'ap-woo-categories';
	}

	public function get_title() {
		return  esc_html__( 'Woo Categories - Menu', 'ap-companion' );
	}

	public function get_icon() {
		return 'ap-ea-icons ap-woo-categories';
	}

	public function get_categories() {
		return [ 'ap-elements' ];
	}

	
	protected function _register_controls() {


        $this->start_controls_section(
            'ap_layout_option',
            [
                'label' => esc_html__( 'Title Options', 'ap-companion' )
            ]
        );

        $this->add_control(
            'ap_woo_cat_title', [
                'label'         => esc_html__( 'Item Label', 'ap-companion' ),
                'default'       => esc_html__('Categories','ap-companion'),
                'type'          => Controls_Manager::TEXT,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_controls',
            [
                'label' => esc_html__( 'Categories Options', 'ap-companion' )
            ]
        );
        

        $this->add_control(
            'ap_multiple_cat_data',
            [
                'type'      => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'fields' => [
                    [
                        'name'          => 'ap_multiple_icon',
                        'label'         => esc_html__( 'Icon', 'ap-companion' ),
                        'type'          => Controls_Manager::ICONS,
                        
                    ],
                            
                    [
                        'name'          => 'ap_woo_cat',
                        'label'         => esc_html__( 'Product Category', 'ap-companion' ),
                        'type'          => Controls_Manager::SELECT,
                        'options'       => ap_get_product_categories()
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
                'label' => esc_html__( 'General Styles', 'ap-companion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        
        $this->add_control(
            'menu_name_color',
            [
                'label'     => esc_html__( 'Menu Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ap-woo-categories .menu-title .text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'menu_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ap-woo-categories .menu-title .text' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'menu_icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ap-woo-categories .menu-title .icon-wrapp span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'name_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-woo-categories .menu-title .text',
                
            ]
        );

        $this->add_control(
            'item_color',
            [
                'label'     => esc_html__( 'Item Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .ap-woo-categories .menus-wrapp .item-wrapper .cat-name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'item_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-woo-categories .menus-wrapp .item-wrapper .cat-name a',
                
            ]
        );


        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__( 'Icon Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .ap-woo-categories .menus-wrapp .item-wrapper .icon-wrapp i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ap-woo-categories .menus-wrapp .item-wrapper .icon-wrapp svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'ap-companion' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .ap-woo-categories .menus-wrapp svg' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ap-woo-categories .menus-wrapp .item-wrapper .icon-wrapp i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();//end for styling tab



    }

    protected function render() {
        $settings         	= $this->get_settings_for_display();
        $ap_woo_cat_title   = $settings['ap_woo_cat_title'];

        $this->add_render_attribute( 'ap-companion-attr', 'class', 'ap-woo-categories' );
        ?>
        <div <?php echo $this->get_render_attribute_string('ap-companion-attr')?> >
            <div class="menu-title">
                <div class="icon-wrapp">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="text"><?php echo esc_html($ap_woo_cat_title); ?></div>
            </div>
            <ul class="menus-wrapp">
                <?php
                foreach( $settings['ap_multiple_cat_data'] as $item ){

                   $ap_multiple_icon    = $item['ap_multiple_icon'];
                   $ap_woo_cat          = $item['ap_woo_cat'];
                   $link                = get_category_link( $ap_woo_cat);
                   
                 

                   ?>
                   <li class="item-wrapper">
                        <?php if( !empty($ap_multiple_icon['value'])  ){ ?>
                            <span class="icon-wrapp">
                                <?php Icons_Manager::render_icon( $ap_multiple_icon ); ?>
                            </span>
                        <?php } ?>
                       <div class="cat-name">

                        <?php if( $term = get_term_by( 'id', $ap_woo_cat, 'product_cat' ) ){ ?>
                            <a href="<?php echo esc_url($link)?>"><?php echo esc_html($term->name);  ?></a>
                        <?php } ?>
                            
                        </div>   
                   </li>
                   <?php 
                }
                ?>
            </ul>
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