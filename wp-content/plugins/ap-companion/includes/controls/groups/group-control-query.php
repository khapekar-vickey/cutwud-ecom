<?php

namespace ApCompanion;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Group_Control_Query extends Group_Control_Base {

    protected static $fields;

    public static function get_type() {
        return 'ap-query';
    }


    protected function init_fields() {
        $fields = [];

        $fields['post_type'] = [
            'label' => _x('Source', 'Posts Query Control', 'ap-companion'),
            'type' => Controls_Manager::SELECT,
        ];

        return $fields;
    }

    protected function prepare_fields($fields) {

        

        $post_types = self::get_post_types();

        $fields['post_type']['options'] = $post_types;

        $fields['post_type']['default'] = 'post'; 

        $taxonomy_filter_args = [
            'show_in_nav_menus' => true,
        ];

        $taxonomies = get_taxonomies($taxonomy_filter_args, 'objects');
        
        foreach ($taxonomies as $taxonomy => $object) {
            $options = array();
            
            $terms = get_terms($taxonomy);

            foreach ($terms as $term) {
            
                if( $object->label == 'Formats' ){
                    $options['post-format-'.$term->name] = $term->name;
                }else{
                    $options[$term->term_id] = $term->name;
                }
            }
            
            $fields[$taxonomy . '_ids'] = [
                'label'         => $object->label,
                'type'          => Controls_Manager::SELECT2,
                'label_block'   => true,
                'multiple'      => true,
                'object_type'   => $taxonomy,
                'options'       => $options,
                'condition'     => [
                    'post_type' => $object->object_type,
                ],
            ];
        }
        
        $fields['authors'] = [
            'label'         => esc_html__('Authors', 'ap-companion'),
            'type'          => Controls_Manager::SELECT2,
            'label_block'   => true,
            'multiple'      => true,
            'options'       => ap_get_auhtors(),
            'condition'     => [
                'post_type' => 'post'
            ]
        ];

        $fields['exclude_posts'] = [
            'label'         => esc_html__('Exclude Posts', 'ap-companion'),
            'type'          => Controls_Manager::SELECT2,
            'label_block'   => true,
            'multiple'      => true,
            'options'       => ap_get_posts(),
            'condition'     => [
                'post_type' => 'post'
            ]
        ];
        
        $fields['orderby'] = [
            'label'         => esc_html__('Order By', 'ap-companion'),
            'type'          => Controls_Manager::SELECT,
            'options'       => [
                'date'          => esc_html__('Date', 'ap-companion'),
                'modified'      => esc_html__('Last Modified Date', 'ap-companion'),
                'rand'          => esc_html__('Rand', 'ap-companion'),
                'comment_count' => esc_html__('Comment Count', 'ap-companion'),
                'title'         => esc_html__('Title', 'ap-companion'),
                'ID'            => esc_html__('Post ID', 'ap-companion'),
                'author'        => esc_html__('Post Author', 'ap-companion'),
            ],
            'default' => 'date',
        ];

        $fields['order'] = [
            'label'     => esc_html__('Order', 'ap-companion'),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
                'DESC'  => esc_html__('Descending', 'ap-companion'),
                'ASC'   => esc_html__('Ascending', 'ap-companion'),
            ],
            'default'   => 'DESC',
        ];
        
        $fields['offset'] = [
            'label'     => esc_html__('Offset', 'ap-companion'),
            'type'      => Controls_Manager::NUMBER,
            'default'   => '',
        ];

        return parent::prepare_fields($fields);
    }

    private static function get_post_types() {
        $post_type_args = [
            'show_in_nav_menus' => true,
        ];
        
        $_post_types = get_post_types($post_type_args, 'objects');

        $post_types = [];

        foreach ($_post_types as $post_type => $object) {
            $post_types[$post_type] = $object->label;
        }

        return $post_types;
    }

    protected function get_default_options() {
        return [
            'popover' => false,
        ];
    }
}
