<?php
namespace ApCompanion\Modules\BlogGrid\Widgets;

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

class Blog_Grid extends Widget_Base {

	public function get_name() {
		return 'ap-blog-grid';
	}

	public function get_title() {
		return  esc_html__( 'Blog Grid', 'ap-companion' );
	}

	public function get_icon() {
		return 'ap-ea-icons ap-blog-grid';
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
        * Large Image Tile
        */
        $this->start_controls_section(
            'large_section_content_heading',
            [
                'label' => esc_html__( 'Large Image Settings', 'ap-companion' ),
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
        * Medium Image Tile
        */
        $this->start_controls_section(
            'med_section_content_heading',
            [
                'label' => esc_html__( 'Medium Image Settings', 'ap-companion' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'              => 'image_size_med',
                'label'             => esc_html__( 'Image Size', 'ap-companion' ),
                'default'           => 'large',
                'separator'         => 'before',
            ]
        );

        $this->end_controls_section();

        /**
        * Small Image Tile
        */
        $this->start_controls_section(
            'sm_section_content_heading',
            [
                'label' => esc_html__( 'Small Image Settings', 'ap-companion' ),
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
                'label' => esc_html__( 'Large Image', 'ap-companion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        //title
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .lg-img .content-wrapp .post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .lg-img .content-wrapp .post-title a',
                
            ]
        );

        $this->add_control(
            'meta_lg_color',
            [
                'label'     => esc_html__( 'Post Meta Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .lg-img .content-wrapp .post-meta a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .lg-img .content-wrapp .post-date' => 'color: {{VALUE}};',
                ],
                'separator'  => 'before',
            ]
        );



        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'meta_lg_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .lg-img .content-wrapp .post-meta a,{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .lg-img .content-wrapp .post-date',
                
            ]
        );

        $this->add_control(
            'cat_lg_color',
            [
                'label'     => esc_html__( 'Category Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .lg-img .content-wrapp .cat-links a' => 'color: {{VALUE}};'
                ],
                'separator'  => 'before',
            ]
        );



        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cat_lg_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .lg-img .content-wrapp .cat-links a',
                
            ]
        );


        $this->end_controls_section();

        /**
        * Medium Image styles
        */
        $this->start_controls_section(
            'section_general_style_md',
            [
                'label' => esc_html__( 'Medium Image', 'ap-companion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        //title
        $this->add_control(
            'title_color_md',
            [
                'label'     => esc_html__( 'Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .md-img .content-wrapp .post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography_md',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .md-img .content-wrapp .post-title a',
                
            ]
        );

        $this->add_control(
            'meta_md_color',
            [
                'label'     => esc_html__( 'Post Meta Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .md-img .content-wrapp .post-meta a' => 'color: 
                    {{VALUE}};',
                    '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .md-img .content-wrapp .post-date' => 'color: {{VALUE}};',
                ],
                'separator'  => 'before',
            ]
        );



        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'meta_md_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .md-img .content-wrapp .post-meta a,{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .md-img .content-wrapp .post-date',
                
            ]
        );

        $this->add_control(
            'cat_md_color',
            [
                'label'     => esc_html__( 'Category Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .md-img .content-wrapp .cat-links a' => 'color: 
                    {{VALUE}};',
                ],
                'separator'  => 'before',
            ]
        );



        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cat_md_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .md-img .content-wrapp .cat-links a',
                
            ]
        );
    
        $this->end_controls_section();


        /**
        * Small Image styles
        */
        $this->start_controls_section(
            'section_general_style_sm',
            [
                'label' => esc_html__( 'Small Image', 'ap-companion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        //title
        $this->add_control(
            'title_color_sm',
            [
                'label'     => esc_html__( 'Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .sm-img .content-wrapp .post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography_sm',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .sm-img .content-wrapp .post-title a',
                
            ]
        );

        $this->add_control(
            'meta_sm_color',
            [
                'label'     => esc_html__( 'Post Meta Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .sm-img .content-wrapp .post-meta a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .sm-img .content-wrapp .post-date' => 'color: {{VALUE}};',
                ],
                'separator'  => 'before',
            ]
        );



        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'meta_sm_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .sm-img .content-wrapp .post-meta a,{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .sm-img .content-wrapp .post-date',
                
            ]
        );

        $this->add_control(
            'cat_sm_color',
            [
                'label'     => esc_html__( 'Category Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .sm-img .content-wrapp .cat-links a' => 'color: {{VALUE}};',
                ],
                'separator'  => 'before',
            ]
        );



        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cat_sm_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .ap-blog-grid-main-wrapp .blog-inner-wrapp .sm-img .content-wrapp .cat-links a',
                
            ]
        );

    
        $this->end_controls_section();//end for styling tab

		
	}

	protected function render() {
		$settings         	= $this->get_settings_for_display();
		$posts_category_ids = $settings['posts_category_ids'];
		$no_of_post 		= 4;
		
		$this->add_render_attribute( 'ap-attr', 'class', 'ap-blog-grid-main-wrapp ' );
		
	?>
	<div <?php echo $this->get_render_attribute_string('ap-attr')?> >
    <div class="blog-inner-wrapp">
    	<?php 
        $args = ap_ea_query($settings, $first_id = '',$no_of_post);
        $featured_posts = new \WP_Query( $args ); 
        $total_posts =  $featured_posts->post_count;
        if( $total_posts < 4 ){ ?>
            <h2 class="post-warn"><?php esc_html_e('Please add 4 posts for this element.','ap-companion'); ?></h2>
        <?php 
        return;
        }
        $counter = 0;
        if ( $featured_posts->have_posts() ) : while ($featured_posts->have_posts()) : $featured_posts->the_post();
            $counter ++;



            $this->get_post_display_contents($counter);

        endwhile; endif; wp_reset_postdata();
        ?>
    </div>
	</div>
	<?php 	

	}



    protected function get_current_loop_img($counter){
        $settings           = $this->get_settings();

        if( $counter == 1 ){
            $imgsz = 'image_size_large';
        }elseif( $counter == 2 ){
            $imgsz = 'image_size_med';
        }else{
            $imgsz = 'image_size_small';
        }
        
        
        if ( has_post_thumbnail() ) {
            $image_id   = get_post_thumbnail_id( get_the_ID() );
            $thumb_url  = Group_Control_Image_Size::get_attachment_image_src( $image_id, $imgsz, $settings );
            
        } else {
            if ( $settings['fallback_image'] == 'placeholder' ) {
                $thumb_url = Utils::get_placeholder_image_src();
            } elseif ( $settings['fallback_image'] == 'custom' && !empty( $settings['fallback_image_custom']['url'] ) ) {

                $custom_image_id = $settings['fallback_image_custom']['id'];
                $thumb_url = Group_Control_Image_Size::get_attachment_image_src( $custom_image_id, $imgsz, $settings );
                
            } else {
                $thumb_url = '';
            }
        }

        
        if(empty($thumb_url)){
            return;
        }
        ?>
        <div class="post-thumb-wrapp">
            <div class="post-thumb-bg" style="background-image:url(<?php echo esc_url($thumb_url);?>)"></div>
            <div class="img-overlay">
                <a href="<?php the_permalink()?>"></a>
            </div>
        </div>

    <?php }

    /**
    * Post content
    * 
    */
    protected function get_post_display_contents($counter){
        $settings           = $this->get_settings();
        $posted_on          = get_the_date();

        
        if( $counter == 1 ){
            echo '<div class="block-wrapper right-wrapp lg-img">';
        }elseif( $counter == 2 ){
            echo '<div class="block-wrapper left-wrapp">';
            echo  '<div class="block-wrapper md-img">';
        }elseif($counter == 3 ){
            echo  '<div class="block-wrapper sm-img">';
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
                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="post-author">
                        <?php echo esc_html( get_the_author() ); ?>
                    </a>
                    <span class="post-date"><?php echo esc_html($posted_on); ?></span>
                </div>
               
            </div>
        </div>
    <?php 
        // close dynamically generated div
        if( ($counter == 1) || ($counter == 2) || ($counter == 4)){
            echo '</div>';
        }
        if( $counter == 4 ){
            echo '</div>';//left-wrapp closing
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