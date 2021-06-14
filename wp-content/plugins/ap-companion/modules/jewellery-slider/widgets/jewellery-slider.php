<?php
namespace ApCompanion\Modules\JewellerySlider\Widgets;

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

class Jewellery_Slider extends Widget_Base {

    public function get_name() {
        return 'ap-jewellery-slider-product';
    }

    public function get_title() {
        return  esc_html__( 'Jewellery Slider Product', 'ap-companion' );
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

          $this->start_controls_section(
            'section_general_style',
            [
                'label' => esc_html__( 'General Styles', 'ap-companion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pro_title_color',
            [
                'label'     => esc_html__( 'Product Title Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} h2.woocommerce-loop-product__title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'pro_title_typography',
                'label'     => esc_html__( ' Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} h2.woocommerce-loop-product__title a',
                
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => esc_html__( 'Price Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} li.product.type-product span.price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'price_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} li.product.type-product span.price',
                
            ]
        );

        $this->add_control(
            'add_to_cart_color',
            [
                'label'     => esc_html__( 'Add to Cart Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .sml-add-to-cart-wrap a.add_to_cart_button.button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'add_to_cart_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .sml-add-to-cart-wrap a.add_to_cart_button.button',
                
            ]
        );

        $this->add_control(
            'add_to_cart_hover_color',
            [
                'label'     => esc_html__( 'Add to Cart Hover Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .type-product a.add_to_cart_button.button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'add_to_cart_hover_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .type-product a.add_to_cart_button.button:hover',
                
            ]
        );

        $this->end_controls_section();//end for styling tab

    }

    protected function render() {
      $settings             = $this->get_settings_for_display();
      $product_categories = $settings['product_categories'];
      $no_of_product        = $settings['no_of_product'];

      $this->add_render_attribute( 'ap-attr', 'class', 'ap-jew-trending-slider-main-wrapp ' ); ?>
        
        <div <?php echo $this->get_render_attribute_string('ap-attr')?> >
        <?php 
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
                    $prod_cats_slider_query = new \WP_Query( $args ); ?>

                    <div class="sml-jewellery-wrap">
                        <?php 
                        if( $prod_cats_slider_query->have_posts() ) { ?>
                        <div class="sml-jewell-products products">
                            <div class="woocommerce">
                            <ul class="products-wrapp">

                                <?php while ( $prod_cats_slider_query->have_posts() ) : $prod_cats_slider_query->the_post(); 
                                    
                                wc_get_template_part( 'content', 'product' );

                                endwhile; ?>
                            </ul>
                            </div>
                        </div>
                        <?php  } wp_reset_postdata();   ?> 
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