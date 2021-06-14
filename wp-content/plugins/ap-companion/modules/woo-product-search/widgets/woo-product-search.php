<?php
namespace ApCompanion\Modules\WooProductSearch\Widgets;

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

class Woo_Product_Search extends Widget_Base {

    public function get_name() {
        return 'ap-woo-product-search';
    }

    public function get_title() {
        return  esc_html__( 'WooProduct Search', 'ap-companion' );
    }

    public function get_icon() {
        return 'ap-ea-icons ap-woo-product-search';
    }

    public function get_categories() {
        return [ 'ap-elements' ];
    }

    

    protected function _register_controls() {   
        $this->start_controls_section(
            'section_content_heading',
            [
                'label' => esc_html__( 'Search Options', 'ap-companion' ),
            ]
        );

        
        $this->add_control(
            'search_placeholder',
            [
                'label'         => esc_html__( 'Search Placeholder Text', 'ap-companion' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Search Products Here','ap-companion'),
            ]
        );

        $this->add_control(
            'cat_text',
            [
                'label'         => esc_html__( 'All Categories Text', 'ap-companion' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('All Categories','ap-companion'),
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
      $settings             = $this->get_settings_for_display();
      $search_placeholder   = $settings['search_placeholder'];
      $cat_text             = $settings['cat_text'];

     
      $this->add_render_attribute( 'ap-attr', 'class', 'ap-woo-product-search' );

      ?>
      <div <?php echo $this->get_render_attribute_string('ap-attr')?> >
       <?php 
      
            $args = array(
                'number'     => '',
                'orderby'    => 'name',
                'order'      => 'ASC',
                'hide_empty' => true
            );
            $product_categories = get_terms( 'product_cat', $args ); 
            $categories_show = '<option value="0">'.esc_html__('All Categories','ap-companion').'</option>';
            $check = '';
            if(is_search()){
                if(isset($_GET['term']) && $_GET['term']!=''){
                    $check = $_GET['term']; 
                }
            }
            $checked = '';
            
            $categories_show .= '<optgroup class="sm-advance-search" label="'.$cat_text.'">';
            foreach($product_categories as $category){
                if(isset($category->slug)){
                    if(trim($category->slug) == trim($check)){
                        $checked = 'selected="selected"';
                    }
                    $categories_show  .= '<option '.$checked.' value="'.$category->slug.'">'.$category->name.'</option>';
                    $checked = '';
                }
            }
            $categories_show .= '</optgroup>';
            $form = '<form role="search" method="get" id="searchform"  action="' . esc_url( home_url( '/'  ) ) . '">
                        
                         <div class="sm_search_form">
                             <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' .$search_placeholder. '" autocomplete="off"/>
                              <div class="sm_search_wrap">
                                <select class="sm_search_product false" name="term">'.$categories_show.'</select>
                             </div>
                             <button type="submit" id="searchsubmit">
                             <i class="fa fa-search"></i></button>
                             <input type="hidden" name="post_type" value="product" />
                             <input type="hidden" name="taxonomy" value="product_cat" />
                         </div>

                    </form>';           
            echo $form;
        ?>

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