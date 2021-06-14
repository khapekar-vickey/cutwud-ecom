<?php
namespace ApCompanion\Modules\BlogModule2\Widgets;

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

class Blog_Module2 extends Widget_Base {

    public function get_name() {
        return 'ap-blog-module2';
    }

    public function get_title() {
        return  esc_html__( 'Blog Module 2', 'ap-companion' );
    }

    public function get_icon() {
        return 'ap-ea-icons ap-blog-module2';
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
        * Featured Image settings
        */
        $this->start_controls_section(
            'section_featured_block',
            [
                'label' => esc_html__( 'Featured Image Settings', 'ap-companion' ),
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label'       => esc_html__( 'Excerpt Length', 'ap-companion' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 200
            ]
        );


        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'              => 'image_size_large',
                'label'             => esc_html__( 'Image Size', 'ap-companion' ),
                'default'           => 'large',
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
            'section_general_style_lg',
            [
                'label' => esc_html__( 'Large Image Style', 'ap-companion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // title
        $this->add_control(
            'title_color_lg',
            [
                'label'     => esc_html__( 'Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .module-inner-wrapp .featured-content-wrapp .item-wrapp .post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography_lg',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .module-inner-wrapp .featured-content-wrapp .item-wrapp .post-title a',
                
            ]
        );

        $this->add_control(
            'cat_color_lg',
            [
                'label'     => esc_html__( 'Category Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .module-inner-wrapp .featured-content-wrapp .item-wrapp .post-thumb-wrapp .cat-links a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cat_typography_lg',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .module-inner-wrapp .featured-content-wrapp .item-wrapp .post-thumb-wrapp .cat-links a',
                
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
                    '{{WRAPPER}} .module-inner-wrapp .featured-content-wrapp .item-wrapp .content-wrapp .post-meta a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .module-inner-wrapp .featured-content-wrapp .item-wrapp .content-wrapp .post-date' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .module-inner-wrapp .featured-content-wrapp .item-wrapp .content-wrapp .post-date:before' => 'background-color: {{VALUE}};',
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

    
        $this->end_controls_section();//end for styling tab for large image

        /**
        * Small Images styles
        */
        $this->start_controls_section(
            'section_general_style',
            [
                'label' => esc_html__( 'Small Images Styles', 'ap-companion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .module-inner-wrapp .sm-content-wrapp .item-wrapp .content-wrapp .post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .module-inner-wrapp .sm-content-wrapp .item-wrapp .content-wrapp .post-title a',
                
            ]
        );

        $this->add_control(
            'cat_color',
            [
                'label'     => esc_html__( 'Category Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .module-inner-wrapp .sm-content-wrapp .item-wrapp .content-wrapp .cat-links a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cat_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .module-inner-wrapp .sm-content-wrapp .item-wrapp .content-wrapp .cat-links a',
                
            ]
        );


        $this->add_control(
            'meta_color_sm',
            [
                'label'     => esc_html__( 'Post Meta Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator'  => 'before',
                'selectors' => [
                    '{{WRAPPER}} .module-inner-wrapp .sm-content-wrapp .item-wrapp .content-wrapp .post-date' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'meta_typography_sm',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .module-inner-wrapp .sm-content-wrapp .item-wrapp .content-wrapp .post-date',
                
            ]
        );

    
        $this->end_controls_section();//end for styling tab
        
    }

    protected function render() {
        $settings           = $this->get_settings_for_display();
        $posts_category_ids = $settings['posts_category_ids'];
        $no_of_post         = 4;
        $excerpt_length     = $settings['excerpt_length'];
        
        $this->add_render_attribute( 'ap-attr', 'class', 'ap-blog-module2 ' );
        
    ?>
    <div <?php echo $this->get_render_attribute_string('ap-attr')?> >
    <div class="module-inner-wrapp">
    <?php 
    $args = ap_ea_query($settings, $first_id = '',$no_of_post);
    $featured_posts = new \WP_Query( $args ); 
    $counter = 0;
    if ( $featured_posts->have_posts() ) : while ($featured_posts->have_posts()) : $featured_posts->the_post();
        $counter++;
        if( $counter == 1 ){
            $this->get_featured_module_contents($counter);    
        }else{
            $this->get_current_module_contents_sm($counter);    
        }
        
    endwhile; endif; wp_reset_postdata();
    ?>
    </div>
    </div>
    <?php   

    }

    protected function get_current_loop_img($counter){
        $settings           = $this->get_settings();
        
        if( $counter == 1 ){
            $img_sz = 'image_size_large';
        }else{
            $img_sz = 'image_size_small';
        }

        $image_alt = '';
        if ( has_post_thumbnail() ) {
            $image_id   = get_post_thumbnail_id( get_the_ID() );
            $thumb_url  = Group_Control_Image_Size::get_attachment_image_src( $image_id, $img_sz, $settings );
            $image_alt  = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
            
        } else {
            if ( $settings['fallback_image'] == 'placeholder' ) {
                $thumb_url = Utils::get_placeholder_image_src();
            } elseif ( $settings['fallback_image'] == 'custom' && !empty( $settings['fallback_image_custom']['url'] ) ) {

                $custom_image_id = $settings['fallback_image_custom']['id'];
                $thumb_url = Group_Control_Image_Size::get_attachment_image_src( $custom_image_id, $img_sz, $settings );
                
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
            <?php if( $counter == 1 ){ ?>
                <?php do_action('ap_ea_single_cat'); ?>
            <?php } ?>
        </div>

    <?php }

    /**
    * Post contents for featured block image
    */
    protected function get_featured_module_contents($counter){
        $settings           = $this->get_settings();
        $excerpt_length     = $settings['excerpt_length'];
        $posted_on          = get_the_date();
        
        ?>
        <div class="block-content-wrapp featured-content-wrapp">
            <div class="item-wrapp">
                <?php $this->get_current_loop_img($counter); ?>
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
        </div>
    <?php }

    /**
    * Small image control
    */
    protected function get_current_module_contents_sm($counter){
        $settings           = $this->get_settings();
        $posted_on          = get_the_date();

        if( $counter == 2 ){
            echo '<div class="block-content-wrapp sm-content-wrapp">';
        }
        ?>
        
            <div class="item-wrapp">
                <?php $this->get_current_loop_img($counter); ?>
                <div class="content-wrapp">
                    <?php do_action('ap_ea_single_cat'); ?>
                    <h2 class="post-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    <div class="post-meta">
                        <span class="post-date"><?php echo esc_html($posted_on); ?></span>
                    </div>
                </div>
            </div>
    <?php 
        if( $counter == 4 ){
            echo '</div>';
        }

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