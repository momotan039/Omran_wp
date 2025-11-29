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

        acf_add_local_field_group(
            array(
            'key'    => 'group_product_fields',
            'title'  => 'حقول المنتج',
            'fields' => array(
                array(
                    'key'           => 'field_product_short_description',
                    'label'         => 'الوصف القصير',
                    'name'          => 'short_description',
                    'type'          => 'textarea',
                    'required'      => 1,
                    'rows'          => 3,
                    'placeholder'   => 'أدخل وصفاً قصيراً للمنتج',
                ),
                array(
                    'key'           => 'field_product_price',
                    'label'         => 'السعر',
                    'name'          => 'price',
                    'type'          => 'text',
                    'default_value' => 'تواصل للسعر',
                    'placeholder'   => 'السعر أو "تواصل للسعر"',
                ),
                array(
                    'key'           => 'field_product_features',
                    'label'         => 'المميزات',
                    'name'          => 'features',
                    'type'          => 'textarea',
                    'rows'          => 6,
                    'placeholder'   => 'أدخل كل ميزة في سطر منفصل' . "\n" . 'مثال:' . "\n" . 'مقاومة للصدأ (SS304)' . "\n" . 'سلة مخلفات داخلية' . "\n" . 'تصميم مانع للروائح',
                    'instructions'  => 'أدخل كل ميزة في سطر منفصل. كل سطر سيظهر كقائمة منفصلة.',
                ),
                array(
                    'key'           => 'field_product_specs',
                    'label'         => 'المواصفات',
                    'name'          => 'specs',
                    'type'          => 'textarea',
                    'rows'          => 8,
                    'placeholder'   => 'أدخل كل مواصفة بصيغة: التسمية: القيمة' . "\n" . 'مثال:' . "\n" . 'المادة: Stainless Steel 304' . "\n" . 'الأبعاد: 30x30 سم' . "\n" . 'الغطاء: 2 مم' . "\n" . 'البدن: 1.5 مم',
                    'instructions'  => 'أدخل كل مواصفة بصيغة: التسمية: القيمة (كل مواصفة في سطر منفصل)',
                ),
                array(
                    'key'           => 'field_product_is_featured',
                    'label'         => 'منتج مميز',
                    'name'          => 'is_featured',
                    'type'          => 'true_false',
                    'default_value' => 0,
                    'ui'            => 1,
                    'ui_on_text'    => 'نعم',
                    'ui_off_text'   => 'لا',
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
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'       => '',
            'active'                => true,
            'description'           => 'حقول مخصصة للمنتجات',
        )
        );


        acf_add_local_field_group(
            array(
            'key'    => 'group_testimonial_fields',
            'title'  => 'حقول الشهادات',
            'fields' => array(
                array(
                    'key'         => 'field_testimonial_role',
                    'label'       => 'المنصب',
                    'name'        => 'role',
                    'type'        => 'text',
                    'placeholder' => 'مثال: مدير المشتريات',
                ),
                array(
                    'key'         => 'field_testimonial_company',
                    'label'       => 'الشركة',
                    'name'        => 'company',
                    'type'        => 'text',
                    'placeholder' => 'اسم الشركة',
                ),
                array(
                    'key'         => 'field_testimonial_content',
                    'label'       => 'محتوى الشهادة',
                    'name'        => 'content',
                    'type'        => 'textarea',
                    'rows'        => 5,
                    'placeholder' => 'أدخل نص الشهادة',
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
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'       => '',
            'active'                => true,
            'description'           => 'حقول مخصصة للشهادات',
        )
        );
    }
    // Register fields on both acf/init and init hooks for better compatibility
    add_action('acf/init', 'alomran_register_acf_fields');
    add_action('init', 'alomran_register_acf_fields', 20);
}

