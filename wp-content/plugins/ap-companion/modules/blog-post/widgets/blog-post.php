<?php
namespace ApCompanion\Modules\BlogPost\Widgets;

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

class Blog_Post extends Widget_Base {

	public function get_name() {
		return 'ap-blog-post';
	}

	public function get_title() {
		return  esc_html__( 'Blog Posts', 'ap-companion' );
	}

	public function get_icon() {
		return 'ap-ea-icons ap-blog-post';
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
			'layouts',
			[
				'label'       	=> esc_html__( 'Layout', 'ap-companion' ),
				'type'        	=> Controls_Manager::SELECT,
				'default'		=> 'style1',
				'options' 		=> [
					'style1'  	=> esc_html__( 'Style 1', 'ap-companion' ),
					'style2' 	=> esc_html__( 'Style 2', 'ap-companion' ),
					'style3' 	=> esc_html__( 'Style 3', 'ap-companion' ),
                    'style4'    => esc_html__( 'Style 4', 'ap-companion' ),
                    'style5'    => esc_html__( 'Style 5', 'ap-companion' ),
                    'style6'    => esc_html__( 'Style 6', 'ap-companion' ),
                    'style7'    => esc_html__( 'Style 7', 'ap-companion' ),
                    'style8'    => esc_html__( 'Style 8', 'ap-companion' ),
                    'style9'    => esc_html__( 'Style 9', 'ap-companion' ),
                ],
            ]
        );

		
		$this->add_control(
			'excerpt_length',
			[
				'label'       => esc_html__( 'Excerpt Length', 'ap-companion' ),
				'type'        => Controls_Manager::NUMBER,
                'default'     => 100
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


        //styling tab
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
                    '{{WRAPPER}} h2.post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} h2.post-title a',
                
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__( 'Description Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .item-wrapp .content-wrapp .post-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'desc_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .item-wrapp .content-wrapp .post-excerpt',
                
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label'     => esc_html__( 'Button/Read More Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'condition' => [
                    'layouts!' => 'style2',
                ],
                'selectors' => [
                    '{{WRAPPER}} .item-wrapp .content-wrapp .btn-read-more' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btn_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'condition' => [
                    'layouts!' => 'style2',
                ],
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .item-wrapp .content-wrapp .btn-read-more',
                
            ]
        );


        $this->add_control(
            'date_color',
            [
                'label'     => esc_html__( 'Date Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'condition' => [
                    'layouts!' => 'style1',
                ],
                'selectors' => [
                    '{{WRAPPER}} .item-wrapp .blog-date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'date_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'condition' => [
                    'layouts!' => 'style1',
                ],
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .item-wrapp .blog-date',
                
            ]
        );


        $this->end_controls_section();


    }

    protected function render() {
      $settings         	= $this->get_settings_for_display();
      $posts_category_ids = $settings['posts_category_ids'];
      $no_of_post 		= $settings['no_of_post'];
      $layouts 			= $settings['layouts'];
      $excerpt_length 	= $settings['excerpt_length'];

      $this->add_render_attribute( 'ap-attr', 'class', 'ap-blog-post-main-wrapp '.$layouts );

      ?>
      <div <?php echo $this->get_render_attribute_string('ap-attr')?> >
         <?php 
         $args = ap_ea_query($settings, $first_id = '',$no_of_post);
         $featured_posts = new \WP_Query( $args ); 
         $count = 0;
         if ( $featured_posts->have_posts() ) : while ($featured_posts->have_posts()) : $featured_posts->the_post();
            $count ++;

            if( $layouts == 'style1' ){
                $this->blog_grid_layout_one();
            }elseif( $layouts == 'style2' ){
                $this->blog_grid_layout_two();
            }elseif( $layouts == 'style3' ){
                $this->blog_grid_layout_three();   
            }elseif( $layouts == 'style4' ){
                $this->blog_grid_layout_four();   
            }elseif( $layouts == 'style5' ){
                $this->blog_grid_layout_five();   
            }elseif( $layouts == 'style6' ){
                $this->blog_grid_layout_six();   
            }elseif( $layouts == 'style7' ){
                $this->blog_grid_layout_seven();   
            }elseif( $layouts == 'style8' ){
                $this->blog_grid_layout_eight();   
            }elseif( $layouts == 'style9' ){
                if($count==2){ echo '<div class="bottom-posts">';}
                $this->blog_grid_layout_nine($count);
                if($count==$no_of_post){ echo '</div>';}
            }

        endwhile; endif; wp_reset_postdata();
        ?>
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
    </div>

<?php }

    /**
    * alternate list layout
    * Layout One
    */
    protected function blog_grid_layout_one(){
        $settings           = $this->get_settings();
        $excerpt_length     = $settings['excerpt_length'];
        ?>
        <div class="item-wrapp">
            <?php $this->get_current_loop_img(); ?>
            <div class="content-wrapp">
                <h2 class="post-title">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <div class="post-content">
                    <?php ap_ea_get_excerpt_content($excerpt_length) ?>
                </div>
                <a href="<?php the_permalink() ?>" class="btn-read-more"><?php esc_html_e('Read More','ap-companion'); ?></a>
            </div>
        </div>
    <?php }

    /**
    * Blog Layout 2
    */
    protected function blog_grid_layout_two(){
        $settings           = $this->get_settings();
        $excerpt_length     = $settings['excerpt_length'];
        $posted_on          = get_the_date();
        ?>
        <div class="item-wrapp">
            <?php $this->get_current_loop_img(); ?>
            <div class="content-wrapp">
                <div class="blog-date"><?php echo esc_html($posted_on); ?></div>
                <h2 class="post-title">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <div class="post-content">
                    <?php ap_ea_get_excerpt_content($excerpt_length) ?>
                </div>
            </div>
        </div>
    <?php }

    /**
    * Blog Layout 3
    */
    protected function blog_grid_layout_three(){
        $settings           = $this->get_settings();
        $excerpt_length     = $settings['excerpt_length'];
        $posted_on          = get_the_date();
        ?>
        <div class="item-wrapp">
            <?php $this->get_current_loop_img(); ?>
            <div class="content-wrapp">
                <div class="blog-date"><?php echo esc_html($posted_on); ?></div>
                <h2 class="post-title">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <div class="post-content">
                    <?php ap_ea_get_excerpt_content($excerpt_length) ?>
                </div>
                <a href="<?php the_permalink() ?>" class="btn-read-more"><?php esc_html_e('Read More','ap-companion'); ?></a>
            </div>
        </div>
    <?php }

    /**
    * Blog Layout 4
    */
    protected function blog_grid_layout_four(){
        $settings           = $this->get_settings();
        $excerpt_length     = $settings['excerpt_length'];
        $posted_on          = get_the_date();
        ?>
        <div class="item-wrapp">
            <?php $this->get_current_loop_img(); ?>
            <div class="content-wrapp">
                <div class="blog-date"><?php echo esc_html($posted_on); ?></div>
                <h2 class="post-title">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <a href="<?php the_permalink() ?>" class="btn-read-more"><?php esc_html_e('Read More','ap-companion'); ?></a>
            </div>
        </div>
    <?php }

    /**
    * Blog Layout 5
    */
    protected function blog_grid_layout_five(){
        $settings           = $this->get_settings();
        $excerpt_length     = $settings['excerpt_length'];
        $posted_on_day          = get_the_date('d');
        $posted_on          = get_the_date('M, Y');
        ?>
        <div class="item-wrapp">
            <div class="blog-date">
                <span class="date-day"><?php echo esc_html($posted_on_day); ?></span>
                <span class="date-my"><?php echo esc_html($posted_on); ?></span>
            </div>
            <div class="content-wrapp">
                <h2 class="post-title">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <div class="post-content">
                    <?php ap_ea_get_excerpt_content($excerpt_length) ?>
                </div>
                <a href="<?php the_permalink() ?>" class="btn-read-more"><?php esc_html_e('Read More','ap-companion'); ?></a>
            </div>
        </div>
    <?php }

    /**
    * Blog Layout 6
    */
    protected function blog_grid_layout_six(){
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
                <div class="post-content">
                    <?php ap_ea_get_excerpt_content($excerpt_length) ?>
                </div>
                <a href="<?php the_permalink() ?>" class="btn-read-more"><?php esc_html_e('Read More','ap-companion'); ?></a>
            </div>
        </div>
    <?php }

    /**
    * Blog Layout 7
    */
    protected function blog_grid_layout_seven(){
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
                <a href="<?php the_permalink() ?>" class="btn-read-more"><?php esc_html_e('Read More','ap-companion'); ?></a>
            </div>
        </div>
    <?php }

    /**
    * Blog Layout 8
    */
    protected function blog_grid_layout_eight(){
        $settings           = $this->get_settings();
        $excerpt_length     = $settings['excerpt_length'];
        $posted_on          = get_the_date('d M Y');
        ?>
        <div class="item-wrapp">
            <?php $this->get_current_loop_img(); ?>
            <div class="content-wrapp">
                <div class="inner-content-wrap">
                    <?php 
                    $categories = get_the_category();
                    if ( ! empty( $categories ) ) {
                        echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                    }
                    ?>
                    <h2 class="post-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    <div class="blog-date"><?php echo esc_html($posted_on); ?></div>
                </div>
                <a href="<?php the_permalink() ?>" class="btn-read-more"><?php esc_html_e('Read More','ap-companion'); ?></a>
            </div>
        </div>
    <?php }

    /**
    * Blog Layout 9
    */
    protected function blog_grid_layout_nine($count){
        $settings           = $this->get_settings();
        $excerpt_length     = $settings['excerpt_length'];
        $posted_on          = get_the_date('d M Y');
        if($count==1){
            ?>
            <div class="top-post">
                <div class="item-wrapp first-big-post">
                    <?php $this->get_current_loop_img(); ?>
                    <div class="content-wrapp">
                        <?php 
                        $categories = get_the_category();
                        if ( ! empty( $categories ) ) {
                            echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                        }
                        ?>
                        <h2 class="post-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        <div class="blog-date"><?php echo esc_html($posted_on); ?></div>
                    </div>
                </div>
            </div>
            <?php
        }else{
            ?>
            <div class="item-wrapp">
                <?php $this->get_current_loop_img(); ?>
                <div class="content-wrapp">
                    <h2 class="post-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    <div class="blog-date"><?php echo esc_html($posted_on); ?></div>
                </div>
            </div>
            <?php
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