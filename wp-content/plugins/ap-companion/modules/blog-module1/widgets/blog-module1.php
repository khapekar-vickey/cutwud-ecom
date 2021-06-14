<?php
namespace ApCompanion\Modules\BlogModule1\Widgets;

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

class Blog_Module1 extends Widget_Base {

    public function get_name() {
        return 'ap-blog-module1';
    }

    public function get_title() {
        return  esc_html__( 'Blog Module 1', 'ap-companion' );
    }

    public function get_icon() {
        return 'ap-ea-icons ap-blog-module1';
    }

    public function get_categories() {
        return [ 'ap-elements' ];
    }

    

    protected function _register_controls() {   
        $this->start_controls_section(
            'section_content_heading',
            [
                'label' => esc_html__( 'Layouts', 'ap-companion' ),
            ]
        );

        

        
        $this->add_control(
            'excerpt_length',
            [
                'label'       => esc_html__( 'Excerpt Length', 'ap-companion' ),
                'type'        => Controls_Manager::NUMBER,
            ]
        );

        $this->add_control(
            'no_of_post',
            [
                'label'         => esc_html__( 'Number Of Posts', 'ap-companion' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 3
            ]
        );

        $this->add_control(
            'no_of_col',
            [
                'label'         => esc_html__( 'Number Of Columns', 'ap-companion' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 4,
                'min'           => 1,
                'max'           => 4
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'              => 'image_size_small',
                'label'             => esc_html__( 'Image Size', 'ap-companion' ),
                'default'           => 'large',
            ]
        );

        $this->add_control(
                'fallback_image', [
            'label' => esc_html__('Fallback Image', 'ap-companion'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '' => esc_html__('None', 'ap-companion'),
                'placeholder' => esc_html__('Placeholder', 'ap-companion'),
                'custom' => esc_html__('Custom', 'ap-companion'),
            ],
            'default' => '',
            'separator' => 'before',
            'label_block' => true
                ]
        );

        $this->add_control(
                'fallback_image_custom', [
            'label' => esc_html__('Fallback Image Custom', 'ap-companion'),
            'type' => Controls_Manager::MEDIA,
            'condition' => [
                'fallback_image' => 'custom'
            ],
            'label_block' => true
                ]
        );
        

        $this->end_controls_section();
        

        /**
         * Content Tab: Query
         */
        $this->start_controls_section(
            'section_post_query',
            [
                'label'             => esc_html__( 'Query', 'ap-companion' ),
            ]
        );
        $this->add_group_control(
                Group_Control_Query::get_type(), [
            'name' => 'posts',
            'label' => esc_html__( 'Posts', 'ap-companion' ),
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

        // title
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .post-title a',
                
            ]
        );

        $this->add_control(
            'cat_color',
            [
                'label'     => esc_html__( 'Category Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .item-wrapp .post-thumb-wrapp .cat-links a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cat_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .item-wrapp .post-thumb-wrapp .cat-links a',
                
            ]
        );


        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__( 'Description Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .item-wrapp .post-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'desc_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .item-wrapp .post-excerpt',
                
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label'     => esc_html__( 'Post Meta Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .item-wrapp .content-wrapp .post-meta a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .item-wrapp .content-wrapp .post-date' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .item-wrapp .content-wrapp .post-date::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'meta_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .item-wrapp .content-wrapp .post-meta a,{{WRAPPER}} .item-wrapp .content-wrapp .post-date',
                
            ]
        );

    
        $this->end_controls_section();//end for styling tab

        
    }

    protected function render() {
        $settings           = $this->get_settings_for_display();
        $posts_category_ids = $settings['posts_category_ids'];
        $no_of_post         = $settings['no_of_post'];
        $excerpt_length     = $settings['excerpt_length'];
        $no_of_col          = $settings['no_of_col'];
        
        $this->add_render_attribute( 'ap-attr', 'class', 'ap-blog-module1 ' );
        
    ?>
    <div <?php echo $this->get_render_attribute_string('ap-attr')?> >
    <div class="module-inner-wrapp col-<?php echo esc_attr($no_of_col);?>">
    <?php 
    $args = ap_ea_query($settings, $first_id = '',$no_of_post);
    $featured_posts = new \WP_Query( $args ); 
    
    if ( $featured_posts->have_posts() ) : while ($featured_posts->have_posts()) : $featured_posts->the_post();
        
        if( $no_of_col == 1 ){
            $this->get_current_module_contents_col1();    
        }else{
            $this->get_current_module_contents();    
        }
        
    endwhile; endif; wp_reset_postdata();
    ?>
    </div>
    </div>
    <?php   

    }

    protected function get_current_loop_img(){
        $settings           = $this->get_settings();
        
        $image_alt = '';
        if ( has_post_thumbnail() ) {
            $image_id   = get_post_thumbnail_id( get_the_ID() );
            $thumb_url  = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'image_size_small', $settings );
            $image_alt  = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
            
        } else {
            if ( $settings['fallback_image'] == 'placeholder' ) {
                $thumb_url = Utils::get_placeholder_image_src();
            } elseif ( $settings['fallback_image'] == 'custom' && !empty( $settings['fallback_image_custom']['url'] ) ) {

                $custom_image_id = $settings['fallback_image_custom']['id'];
                $thumb_url = Group_Control_Image_Size::get_attachment_image_src( $custom_image_id, 'image_size_small', $settings );
                
            } else {
                $thumb_url = '';
            }
        }

        
        if(empty($thumb_url)){
            return;
        }
        ?>
        <div class="post-thumb-wrapp">
            <a href="<?php the_permalink()?>">
                <img src="<?php echo esc_url($thumb_url)?>" alt="<?php echo esc_attr($image_alt); ?>">
            </a>
            <?php do_action('ap_ea_single_cat'); ?>
        </div>

    <?php }

    /**
    * Post contents control function
    */
    protected function get_current_module_contents(){
        $settings           = $this->get_settings();
        $excerpt_length     = $settings['excerpt_length'];
        $posted_on          = get_the_date();
        
        ?>
            <div class="item-wrapp">
                <?php $this->get_current_loop_img(); ?>
                <div class="content-wrapp">
                    <h2 class="post-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    <?php if($excerpt_length){ ?>
                        <div class="post-content">
                            <?php ap_ea_get_excerpt_content($excerpt_length) ?>
                        </div>
                    <?php } ?>
                    <div class="post-meta">
                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="post-author">
                            <?php echo esc_html( get_the_author() ); ?>
                        </a>
                        <span class="post-date"><?php echo esc_html($posted_on); ?></span>
                    </div>
                </div>
            </div>
    <?php }

    /**
    * Layout for col-1
    */
    protected function get_current_module_contents_col1(){
        $settings           = $this->get_settings();
        $excerpt_length     = $settings['excerpt_length'];
        $posted_on          = get_the_date();
        $no_of_col          = $settings['no_of_col'];
        
        ?>
            <div class="item-wrapp">
                <?php $this->get_current_loop_img(); ?>
                <div class="content-wrapp">
                    <div class="left-content">
                        <h2 class="post-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                         <div class="post-meta">
                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="post-author">
                                <?php echo esc_html( get_the_author() ); ?>
                            </a>
                            <span class="post-date"><?php echo esc_html($posted_on); ?></span>
                        </div>
                    </div>
                    <?php if($excerpt_length){ ?>
                        <div class="post-content">
                            <?php ap_ea_get_excerpt_content($excerpt_length) ?>
                        </div>
                    <?php } ?>
                   
                </div>
            </div>
    <?php }

   

   

    /**
     * Render widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @access protected
     */
    protected function _content_template() {}

}