<?php
namespace ApCompanion\Modules\AuthorInfo\Widgets;

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

class Author_Info extends Widget_Base {

    public function get_name() {
        return 'ap-author-info';
    }

    public function get_title() {
        return  esc_html__( 'Author Info', 'ap-companion' );
    }

    public function get_icon() {
        return 'ap-ea-icons ap-ea-author';
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
            'foreground_img',
            [
                'label'       => esc_html__( 'Foreground Image', 'ap-companion' ),
                'type'        => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'author_img',
            [
                'label'       => esc_html__( 'Author Image', 'ap-companion' ),
                'type'        => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'author_name',
            [
                'label'       => esc_html__( 'Author Name', 'ap-companion' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'John Doe'  
            ]
        );

        $this->add_control(
            'author_deg',
            [
                'label'       => esc_html__( 'Designation', 'ap-companion' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Instructor'  
            ]
        );

        $this->add_control(
            'author_desc',
            [
                'label'       => esc_html__( 'Description', 'ap-companion' ),
                'type'        => Controls_Manager::TEXTAREA,
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
            'name_color',
            [
                'label'     => esc_html__( 'Name Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .ap-author-info .module-inner-wrapp .content-wrapper .name-wrapp' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'name_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-author-info .module-inner-wrapp .content-wrapper .name-wrapp',
                
            ]
        );


        $this->add_control(
            'desi_color',
            [
                'label'     => esc_html__( 'Designation Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .ap-author-info .module-inner-wrapp .content-wrapper .designation' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'desi_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-author-info .module-inner-wrapp .content-wrapper .designation',
                
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__( 'Description Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .ap-author-info .module-inner-wrapp .content-wrapper .description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'desc_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-author-info .module-inner-wrapp .content-wrapper .description',
                
            ]
        );
    
        $this->end_controls_section();//end for styling tab



        
    }

    protected function render() {
        $settings           = $this->get_settings_for_display();
        $foreground_img     = $settings['foreground_img'];
        $author_img         = $settings['author_img'];
        $author_name        = $settings['author_name'];
        $author_deg         = $settings['author_deg'];
        $author_desc        = $settings['author_desc'];

        $this->add_render_attribute( 'ap-attr', 'class', 'ap-author-info ' );
        
    ?>
    <div <?php echo $this->get_render_attribute_string('ap-attr')?> >
    <div class="module-inner-wrapp">
        <div class="img-wrapper">
            <?php if( $foreground_img['url'] ){ ?>
            <div class="foreground-wrapp">
                <?php 
                $image_alt  = get_post_meta( $foreground_img['id'], '_wp_attachment_image_alt', true );
                 ?>
                <img src="<?php echo esc_url($foreground_img['url']);?>" alt="<?php echo esc_attr($image_alt);?>">
            </div>
            <?php } ?>

            <?php if( $author_img['url'] ){ ?>
            <div class="author-img">
                <?php 
                $image_alt  = get_post_meta( $author_img['id'], '_wp_attachment_image_alt', true );
                 ?>
                <img src="<?php echo esc_url($author_img['url']);?>" alt="<?php echo esc_attr($image_alt);?>">
            </div>
            <?php } ?>
        </div>
        <div class="content-wrapper">
            <div class="name-wrapp">
                <?php echo esc_html($author_name); ?>
            </div>
            <div class="designation">
                <?php echo esc_html($author_deg); ?>
            </div>
            <div class="description">
                <?php echo esc_html($author_desc); ?>
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