<?php
namespace ApCompanion\Modules\WooProductLists\Widgets;

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

class Woo_Product_Lists extends Widget_Base {

    public function get_name() {
        return 'ap-woo-product-List';
    }

    public function get_title() {
        return  esc_html__( 'WooProduct List', 'ap-companion' );
    }

    public function get_icon() {
        return 'ap-ea-icons ap-woo-product-list';
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
            'no_of_post',
            [
                'label'         => esc_html__( 'Number Of Products', 'ap-companion' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 4
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

        $this->add_control(
            'pcat',
            [
                'label'         => esc_html__( 'Product Category', 'ap-companion' ),
                'type'          => Controls_Manager::SELECT,
                'options'       => ap_get_product_categories()
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
                    '{{WRAPPER}} .content-wrapp .woocommerce-loop-product__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .content-wrapp .woocommerce-loop-product__title',
                
            ]
        );

        $this->add_control(
            'cat_color',
            [
                'label'     => esc_html__( 'Category Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .content-wrapp .product-cat' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cat_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .content-wrapp .product-cat',
                
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => esc_html__( 'Price Color', 'ap-companion' ),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .content-wrapp .woocommerce-Price-amount' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'price_typography',
                'label'     => esc_html__( 'Typography', 'ap-companion' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .content-wrapp .woocommerce-Price-amount',
                
            ]
        );

        


        $this->end_controls_section();


    }

    protected function render() {
      $settings             = $this->get_settings_for_display();
      $no_of_post           = $settings['no_of_post'];
      $pcat                 = $settings['pcat'];

     

      $this->add_render_attribute( 'ap-attr', 'class', 'ap-woo-product-lists ' );

      ?>
      <div <?php echo $this->get_render_attribute_string('ap-attr')?> >
       
        <?php if ( $pcat ) : ?>
        <?php
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $no_of_post,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $pcat
                )
            )
        );

        $query = new \WP_Query( $args );
        ?>

        <?php if ( $query->have_posts() ) : ?>
            <div class="ap-product-wrapp woocommerce">
                <ul class="smpc-inner-catposts-wrapper products columns-4">
                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                        <li>
                            <div class="product-img">
                                <?php woocommerce_template_loop_product_link_open(); ?>
                                <?php woocommerce_template_loop_product_thumbnail(); ?>
                                <div class="icon"></div>
                                <?php woocommerce_template_loop_product_link_close(); ?>
                                
                            </div>
                            <div class="content-wrapp">
                                <?php woocommerce_template_loop_product_link_open(); ?>
                                <?php woocommerce_template_loop_product_title(); ?>
                                <?php woocommerce_template_loop_product_link_close(); ?>
                                <?php $terms = get_the_terms( get_the_id(), 'product_cat' ); ?>
                                <p class="product-cat"><?php echo $terms[0]->name; ?></p>
                                

                                <?php woocommerce_template_loop_price(); ?>
                            </div>
                        </li>

                    <?php endwhile; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    <?php else : ?>
        <?php esc_html_e( 'No Category Selected', 'vc-mega-addons' ); ?>
    <?php endif; ?>
    

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