<?php
/**
 * Programmatically register ACF field groups.
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

if (function_exists('acf_add_local_field_group')) {
    /**
     * Register ACF fields if the plugin is active.
     */
    function alomran_register_acf_fields() {

        $acf_group_callback = 'acf_add_local_field_group';

        call_user_func(
            $acf_group_callback,
            array(
            'key'    => 'group_product_fields',
            'title'  => 'Product Fields',
            'fields' => array(
                array(
                    'key'     => 'field_product_short_description',
                    'label'   => 'Short Description',
                    'name'    => 'short_description',
                    'type'    => 'textarea',
                    'required'=> 1,
                ),
                array(
                    'key'          => 'field_product_price',
                    'label'        => 'Price',
                    'name'         => 'price',
                    'type'         => 'text',
                    'default_value'=> 'تواصل للسعر',
                ),
                array(
                    'key'     => 'field_product_category_enum',
                    'label'   => 'Product Category',
                    'name'    => 'product_category_enum',
                    'type'    => 'select',
                    'choices' => array(
                        'DRAIN_GRILLS'   => 'مصافي وجريلات',
                        'GREASE_TRAPS'   => 'مصائد شحوم',
                        'WATER_TREATMENT'=> 'معالجة مياه',
                    ),
                    'required' => 1,
                ),
                array(
                    'key'       => 'field_product_features',
                    'label'     => 'Features',
                    'name'      => 'features',
                    'type'      => 'repeater',
                    'sub_fields'=> array(
                        array(
                            'key'   => 'field_feature_text',
                            'label' => 'Feature Text',
                            'name'  => 'feature_text',
                            'type'  => 'text',
                        ),
                    ),
                ),
                array(
                    'key'       => 'field_product_specs',
                    'label'     => 'Specifications',
                    'name'      => 'specs',
                    'type'      => 'repeater',
                    'sub_fields'=> array(
                        array(
                            'key'   => 'field_spec_label',
                            'label' => 'Label',
                            'name'  => 'label',
                            'type'  => 'text',
                        ),
                        array(
                            'key'   => 'field_spec_value',
                            'label' => 'Value',
                            'name'  => 'value',
                            'type'  => 'text',
                        ),
                    ),
                ),
                array(
                    'key'          => 'field_product_is_featured',
                    'label'        => 'Is Featured',
                    'name'         => 'is_featured',
                    'type'         => 'true_false',
                    'default_value'=> 0,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'product',
                    ),
                ),
            ),
        )
        );

        call_user_func(
            $acf_group_callback,
            array(
            'key'    => 'group_news_fields',
            'title'  => 'News Fields',
            'fields' => array(
                array(
                    'key'   => 'field_news_summary',
                    'label' => 'Summary',
                    'name'  => 'summary',
                    'type'  => 'textarea',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'news',
                    ),
                ),
            ),
        )
        );

        call_user_func(
            $acf_group_callback,
            array(
            'key'    => 'group_testimonial_fields',
            'title'  => 'Testimonial Fields',
            'fields' => array(
                array(
                    'key'   => 'field_testimonial_role',
                    'label' => 'Role',
                    'name'  => 'role',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_testimonial_company',
                    'label' => 'Company',
                    'name'  => 'company',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_testimonial_content',
                    'label' => 'Content',
                    'name'  => 'content',
                    'type'  => 'textarea',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'testimonial',
                    ),
                ),
            ),
        )
        );
    }
    add_action('acf/init', 'alomran_register_acf_fields');
}

