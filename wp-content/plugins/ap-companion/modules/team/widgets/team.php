<?php
namespace ApCompanion\Modules\Team\Widgets;

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

class Team extends Widget_Base {

	public function get_name() {
		return 'ap-team';
	}

	public function get_title() {
		return  esc_html__( 'Team', 'ap-companion' );
	}

	public function get_icon() {
		return 'ap-ea-icons ap-team';
	}

	public function get_categories() {
		return [ 'ap-elements' ];
	}

	
	protected function _register_controls() {

        $this->start_controls_section(
            'ap_layout_option',
            [
                'label' => esc_html__( 'Team Layout', 'ap-companion' )
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
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_controls',
            [
                'label' => esc_html__( 'Team Options', 'ap-companion' )
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
                        'name'          => 'ap_multiple_team_title',
                        'label'         => esc_html__( 'Name', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXT,
                    ],
                    [
                        'name'          => 'ap_multiple_designation',
                        'label'         => esc_html__( 'Designation', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXT,
                    ],
                    [
                        'name'          => 'ap_multiple_phone',
                        'label'         => esc_html__( 'Phone', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXT,
                    ],
                    [
                        'name'          => 'ap_multiple_email',
                        'label'         => esc_html__( 'Email', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXT,
                    ],                    
                    [
                        'name'          => 'ap_multiple_desc',
                        'label'         => esc_html__( 'Description', 'ap-companion' ),
                        'type'          => Controls_Manager::TEXTAREA,
                    ],

                ],
                // 'default' => [
                //     [ 'ap_multiple_team_title' => 'Team Title' ],
                // ],
                // 'title_field' => '{{{ ap_multiple_team_title }}}',
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
            'phone_color',
            [
                'label'     => esc_html__( 'Phone Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .inner-wrapp .phone-wrapp' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'phone_typography',
                'label'     => esc_html__( 'Phone Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .inner-wrapp .phone-wrapp',
                
            ]
        );

        $this->add_control(
            'email_color',
            [
                'label'     => esc_html__( 'Email Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .inner-wrapp .email-wrapp' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'email_typography',
                'label'     => esc_html__( 'Email Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .inner-wrapp .email-wrapp',
                
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
      $ap_multiple_layout           = $settings['ap_multiple_layout'];

      $this->add_render_attribute( 'ap-companion-attr', 'class', 'ap-companion-team' );
      $this->add_render_attribute( 'ap-companion-attr', 'class', $ap_multiple_layout );
      ?>
      <div <?php echo $this->get_render_attribute_string('ap-companion-attr')?> >

        <div class="slider-wrapp">
            <?php foreach( $settings['ap_multiple_test_data'] as $item ){

                $ap_multiple_img            = $item['ap_multiple_img'];
                $ap_multiple_team_title     = $item['ap_multiple_team_title'];
                $ap_multiple_designation    = $item['ap_multiple_designation'];
                $ap_multiple_phone    = $item['ap_multiple_phone'];
                $ap_multiple_email    = $item['ap_multiple_email'];
                $ap_multiple_desc           = $item['ap_multiple_desc'];
                
                ?>
                <div class="inner-wrapp">
                    <div class="team-single-wrapp">
                        <?php if(!empty($ap_multiple_img['url'])){ ?>
                            <img src="<?php echo esc_url($ap_multiple_img['url']);?>" >
                        <?php } ?>
                        <div class="contents-wrapp">
                            <?php if(!empty($ap_multiple_team_title)){ ?>
                                <h2 class="sl-title">
                                    <?php echo wp_kses_post($ap_multiple_team_title); ?>
                                </h2>
                            <?php } ?>
                            <?php if(!empty($ap_multiple_designation)){ ?>
                                <div class="designation-wrapp">
                                    <?php echo wp_kses_post($ap_multiple_designation); ?>
                                </div>
                            <?php } ?>
                            <?php
                            if('layout2'==$ap_multiple_layout){ echo '<div class="contact-wrap">';}
                            if(!empty($ap_multiple_phone)){ ?>
                                <div class="phone-wrapp">
                                    <?php echo wp_kses_post($ap_multiple_phone); ?>
                                </div>
                            <?php } ?>
                            <?php if(!empty($ap_multiple_email)){ ?>
                                <div class="email-wrapp">
                                    <?php echo wp_kses_post($ap_multiple_email); ?>
                                </div>
                            <?php }
                            if('layout2'==$ap_multiple_layout){ echo '</div>';}
                            ?>
                            <?php if(!empty($ap_multiple_desc)){ ?>
                                <div class="desc-wrapp">
                                    <?php echo esc_html($ap_multiple_desc); ?>
                                </div>
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