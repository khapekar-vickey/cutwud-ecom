<?php
namespace ApCompanion\Modules\FeatureInfo\Widgets;

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

class Feature_Info extends Widget_Base {

    public function get_name() {
        return 'ap-features-info';
    }

    public function get_title() {
        return  esc_html__( 'Feature Info', 'ap-companion' );
    }

    public function get_icon() {
        return 'ap-ea-icons ap-ea-features';
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
            'feature_img',
            [
                'label'       => esc_html__( 'Add Image', 'ap-companion' ),
                'type'        => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'image_title',
            [
                'label'       => esc_html__( 'Image Title', 'ap-companion' ),
                'type'        => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'image_sub_title',
            [
                'label'       => esc_html__( 'Image Subtitle', 'ap-companion' ),
                'type'        => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'image_desc',
            [
                'label'       => esc_html__( 'Image Description', 'ap-companion' ),
                'type'        => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'feat_btn_title',
            [
                'label'       => esc_html__( 'Button Title', 'ap-companion' ),
                'type'        => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'feat_btn_link',
            [
                'label'       => esc_html__( 'Button Link', 'ap-companion' ),
                'type'        => Controls_Manager::URL,
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
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .feat-mod-inner-wrapp .feat-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__( 'Title Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .feat-mod-inner-wrapp .feat-title',
                
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label'     => esc_html__( 'SubTitle Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .feat-mod-inner-wrapp .img-sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'subtitle_typography',
                'label'     => esc_html__( ' Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .feat-mod-inner-wrapp .img-sub-title',
                
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__( 'Description Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .feat-mod-inner-wrapp .img-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'desc_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .feat-mod-inner-wrapp .img-description',
                
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => esc_html__( 'Button Text Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .feat-mod-inner-wrapp a.bt-link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label'     => esc_html__( 'Button Hover Text Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .feat-mod-inner-wrapp a.bt-link:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_text_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .feat-mod-inner-wrapp a.bt-link, .feat-mod-inner-wrapp a.bt-link:hover',
                
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .feat-mod-inner-wrapp a.bt-link' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label'     => esc_html__( 'Button Background Hover Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .feat-mod-inner-wrapp a.bt-link:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();//end for styling tab



        
    }

    protected function render() {
        $settings             = $this->get_settings_for_display();
        $feature_img          = $settings['feature_img'];
        $image_title          = $settings['image_title'];
        $image_sub_title      = $settings['image_sub_title'];
        $image_desc           = $settings['image_desc'];
        $feat_btn_title       = $settings['feat_btn_title'];
        $feat_btn_link        = $settings['feat_btn_link'];

        $this->add_render_attribute( 'ap-attr', 'class', 'ap-feature-info ' );
        
    ?>
    <div <?php echo $this->get_render_attribute_string('ap-attr')?> >
    <div class="feat-mod-inner-wrapp">
        <div class="img-wrapper">
            <?php if( $feature_img['url'] ){ ?>
            <div class="author-img">
                <?php 
                $image_alt  = get_post_meta( $feature_img['id'], '_wp_attachment_image_alt', true );
                 ?>
                <img src="<?php echo esc_url($feature_img['url']);?>" alt="<?php echo esc_attr($image_alt);?>">
            </div>
            <?php } ?>
        </div>
        <div class="content-wrapper">
            <div class="feat-title">
                <?php echo esc_html($image_title); ?>
            </div>
            <div class="img-sub-title">
                <?php echo esc_html($image_sub_title); ?>
            </div>
            <div class="img-description">
                <?php echo esc_html($image_desc); ?>
            </div>
           <div class="ap-feat-button">
            <?php if($feat_btn_link['url']){ ?>
            <a href="<?php echo esc_url($feat_btn_link['url']); ?>" class="bt-link">
                <span class = "ap-button-text-wrapper">
                    <span class = "ap-button-text">
                        <?php echo esc_attr($feat_btn_title); ?>
                    </span>
                </span>
            </a>
            <?php } ?>
          
    </div>
        </div>
        
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