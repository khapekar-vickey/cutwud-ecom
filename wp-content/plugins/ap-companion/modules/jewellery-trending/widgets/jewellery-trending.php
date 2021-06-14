<?php
namespace ApCompanion\Modules\JewelleryTrending\Widgets;

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

//use ApCompanion\Group_Control_Query;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Jewellery_Trending extends Widget_Base {

	public function get_name() {
		return 'ap-jewellery-trending-product';
	}

	public function get_title() {
		return  esc_html__( 'Jewellery Trending Product', 'ap-companion' );
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

        //post categories
        $this->add_control(
            'product_categories',
            [
                'label'             => esc_html__( 'Choose Categories', 'bingle-ea' ),
                'type'              => Controls_Manager::SELECT2,
                'label_block'       => true,
                'options'           => ap_get_product_categories(),
                
            ]
        );

		$this->add_control(
			'no_of_product',
			[
				'label'         => esc_html__( 'Number Of Products', 'ap-companion' ),
				'type'          => Controls_Manager::NUMBER,
                'default'       => 3
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
            'cat_color',
            [
                'label'     => esc_html__( 'Categories Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .jewell-trend-prod-cat-info h4.prod-cat' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cat_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .jewell-trend-prod-cat-info h4.prod-cat',
                
            ]
        );

        $this->add_control(
            'pro_title_color',
            [
                'label'     => esc_html__( 'Product Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .woocommerce ul.products li.product a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'pro_title_typography',
                'label'     => esc_html__( ' Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .woocommerce ul.products li.product a',
                
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => esc_html__( 'Price Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .woocommerce ul.products li.product .price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'price_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .woocommerce ul.products li.product .price',
                
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => esc_html__( 'Button Text Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .store-mart-lite-jewell-woo-wrap ul.products li.product .button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label'     => esc_html__( 'Button Hover Text Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .store-mart-lite-jewell-woo-wrap ul.products li.product .button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_text_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .store-mart-lite-jewell-woo-wrap ul.products li.product .button:hover,.store-mart-lite-jewell-woo-wrap ul.products li.product .button',
                
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label'     => esc_html__( 'Button Background Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .store-mart-lite-jewell-woo-wrap ul.products li.product .button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label'     => esc_html__( 'Button Background Hover Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .store-mart-lite-jewell-woo-wrap ul.products li.product .button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();//end for styling tab



    }

    protected function render() {
      $settings         	= $this->get_settings_for_display();
      $product_categories = $settings['product_categories'];
      $no_of_product 		= $settings['no_of_product'];

      $this->add_render_attribute( 'ap-attr', 'class', 'ap-jew-trending-product-main-wrapp ' );
       if(($product_categories) ){
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => $no_of_product,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'term_id',
                                'terms' => $product_categories
                            )
                        )
                    );

                    $feat_prod_cats_query = new \WP_Query( $args );

                    if( $feat_prod_cats_query->have_posts() ) { ?>
                    <div class="store-mart-lite-jewell-woo-wrap">
                    <div class="woocommerce">
                        <ul class="products columns-3">
                         <?php 
                         while( $feat_prod_cats_query->have_posts() ) { 
                            $feat_prod_cats_query->the_post();

                            $term = get_term_by('id',$product_categories, 'product_cat', 'category'); 
                            ?>                            
                            <li class="product">
                                <div class="jewll-trend-prod-detail-wrap">
                                    <div class="latest-product-image">
                                        <?php woocommerce_template_loop_product_thumbnail(); ?>
                                    </div>
                                    <div class="jewell-trend-prod-cat-info">
                                        <h4 class="prod-cat">
                                            <?php 
                                            if(!is_wp_error($term)){
                                                if($term!=null){
                                                    echo $term->name;
                                                }
                                            }
                                            ?>
                                        </h4>
                                       <h2 class="prod-title">   
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                        </h2>
                                        <?php woocommerce_template_loop_rating();  ?>
                                        <div class="product-price">
                                            <?php woocommerce_template_loop_price(); ?>
                                            <div class="sml-latest-prod-add-to-cart">
                                                <?php woocommerce_template_loop_add_to_cart(); ?>    
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                            </li>
                    <?php  }?>
                    
                    <?php  } wp_reset_postdata();   ?> 
                </ul>
                </div>
            </div>
            <?php 
        }else{?>
        <div class="no-product"><?php esc_html_e('No Category Selected','zigcy-lite'); ?> </div>
        <?php }
      ?>
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