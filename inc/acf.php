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
                // Basic Fields
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
                    'key'           => 'field_product_is_featured',
                    'label'         => 'منتج مميز',
                    'name'          => 'is_featured',
                    'type'          => 'true_false',
                    'default_value' => 0,
                    'ui'            => 1,
                    'ui_on_text'    => 'نعم',
                    'ui_off_text'   => 'لا',
                ),
                
                // Industry Type
                array(
                    'key'           => 'field_product_industry_type',
                    'label'         => 'نوع الصناعة',
                    'name'          => 'industry_type',
                    'type'          => 'select',
                    'choices'       => array(
                        'industrial'    => 'صناعي',
                        'food'          => 'طعام ومشروبات',
                        'tech'          => 'تكنولوجيا',
                        'general'       => 'عام',
                    ),
                    'default_value' => 'general',
                    'allow_null'    => 0,
                    'multiple'      => 0,
                    'ui'            => 1,
                    'instructions'  => 'اختر نوع الصناعة لعرض الحقول المناسبة',
                ),
                
                // Technical Specifications (Repeater)
                array(
                    'key'           => 'field_product_technical_specs',
                    'label'         => 'المواصفات الفنية',
                    'name'          => 'technical_specs',
                    'type'          => 'repeater',
                    'layout'        => 'table',
                    'button_label'  => 'إضافة مواصفة',
                    'sub_fields'    => array(
                        array(
                            'key'       => 'field_spec_label',
                            'label'     => 'التسمية',
                            'name'      => 'label',
                            'type'      => 'text',
                            'required'  => 1,
                        ),
                        array(
                            'key'       => 'field_spec_value',
                            'label'     => 'القيمة',
                            'name'      => 'value',
                            'type'      => 'text',
                            'required'  => 1,
                        ),
                    ),
                    'conditional_logic' => array(
                        array(
                            array(
                                'field'    => 'field_product_industry_type',
                                'operator' => '!=',
                                'value'    => 'food',
                            ),
                        ),
                    ),
                ),
                
                // Legacy Specs Field (for backward compatibility)
                array(
                    'key'           => 'field_product_specs',
                    'label'         => 'المواصفات (نص)',
                    'name'          => 'specs',
                    'type'          => 'textarea',
                    'rows'          => 8,
                    'placeholder'   => 'أدخل كل مواصفة بصيغة: التسمية: القيمة' . "\n" . 'مثال:' . "\n" . 'المادة: Stainless Steel 304' . "\n" . 'الأبعاد: 30x30 سم',
                    'instructions'  => 'أدخل كل مواصفة بصيغة: التسمية: القيمة (كل مواصفة في سطر منفصل). يمكن استخدام هذا الحقل أو المواصفات الفنية أعلاه.',
                ),
                
                // Ingredients (Food Industry)
                array(
                    'key'           => 'field_product_ingredients',
                    'label'         => 'المكونات',
                    'name'          => 'ingredients',
                    'type'          => 'repeater',
                    'layout'        => 'table',
                    'button_label'  => 'إضافة مكون',
                    'sub_fields'    => array(
                        array(
                            'key'       => 'field_ingredient_name',
                            'label'     => 'اسم المكون',
                            'name'      => 'name',
                            'type'      => 'text',
                            'required'  => 1,
                        ),
                        array(
                            'key'       => 'field_ingredient_percentage',
                            'label'     => 'النسبة (%)',
                            'name'      => 'percentage',
                            'type'      => 'number',
                            'min'       => 0,
                            'max'       => 100,
                            'step'      => 0.1,
                        ),
                    ),
                    'conditional_logic' => array(
                        array(
                            array(
                                'field'    => 'field_product_industry_type',
                                'operator' => '==',
                                'value'    => 'food',
                            ),
                        ),
                    ),
                ),
                
                // Dimensions
                array(
                    'key'           => 'field_product_dimensions',
                    'label'         => 'الأبعاد',
                    'name'          => 'dimensions',
                    'type'          => 'group',
                    'layout'        => 'block',
                    'sub_fields'    => array(
                        array(
                            'key'       => 'field_dimension_length',
                            'label'     => 'الطول',
                            'name'      => 'length',
                            'type'      => 'text',
                            'placeholder' => 'مثال: 30 سم',
                        ),
                        array(
                            'key'       => 'field_dimension_width',
                            'label'     => 'العرض',
                            'name'      => 'width',
                            'type'      => 'text',
                            'placeholder' => 'مثال: 30 سم',
                        ),
                        array(
                            'key'       => 'field_dimension_height',
                            'label'     => 'الارتفاع',
                            'name'      => 'height',
                            'type'      => 'text',
                            'placeholder' => 'مثال: 20 سم',
                        ),
                        array(
                            'key'       => 'field_dimension_weight',
                            'label'     => 'الوزن',
                            'name'      => 'weight',
                            'type'      => 'text',
                            'placeholder' => 'مثال: 5 كجم',
                        ),
                        array(
                            'key'       => 'field_dimension_unit',
                            'label'     => 'وحدة القياس',
                            'name'      => 'unit',
                            'type'      => 'select',
                            'choices'   => array(
                                'cm'        => 'سم',
                                'm'         => 'متر',
                                'inch'      => 'بوصة',
                                'ft'        => 'قدم',
                            ),
                            'default_value' => 'cm',
                        ),
                    ),
                ),
                
                // Certifications
                array(
                    'key'           => 'field_product_certifications',
                    'label'         => 'الشهادات والاعتمادات',
                    'name'          => 'certifications',
                    'type'          => 'repeater',
                    'layout'        => 'block',
                    'button_label'  => 'إضافة شهادة',
                    'sub_fields'    => array(
                        array(
                            'key'       => 'field_cert_name',
                            'label'     => 'اسم الشهادة',
                            'name'      => 'name',
                            'type'      => 'text',
                            'required'  => 1,
                            'placeholder' => 'مثال: ISO 9001',
                        ),
                        array(
                            'key'       => 'field_cert_organization',
                            'label'     => 'الجهة المانحة',
                            'name'      => 'organization',
                            'type'      => 'text',
                            'placeholder' => 'مثال: ISO',
                        ),
                        array(
                            'key'       => 'field_cert_number',
                            'label'     => 'رقم الشهادة',
                            'name'      => 'number',
                            'type'      => 'text',
                            'placeholder' => 'مثال: ISO-9001-2015',
                        ),
                        array(
                            'key'       => 'field_cert_file',
                            'label'     => 'ملف الشهادة',
                            'name'      => 'file',
                            'type'      => 'file',
                            'return_format' => 'array',
                        ),
                    ),
                ),
                
                // Videos
                array(
                    'key'           => 'field_product_videos',
                    'label'         => 'مقاطع الفيديو',
                    'name'          => 'videos',
                    'type'          => 'repeater',
                    'layout'        => 'block',
                    'button_label'  => 'إضافة فيديو',
                    'sub_fields'    => array(
                        array(
                            'key'       => 'field_video_url',
                            'label'     => 'رابط الفيديو',
                            'name'      => 'url',
                            'type'      => 'url',
                            'required'  => 1,
                            'placeholder' => 'YouTube, Vimeo, أو رابط مباشر',
                            'instructions' => 'أدخل رابط YouTube أو Vimeo أو رابط مباشر للفيديو',
                        ),
                        array(
                            'key'       => 'field_video_title',
                            'label'     => 'عنوان الفيديو',
                            'name'      => 'title',
                            'type'      => 'text',
                            'placeholder' => 'عنوان اختياري للفيديو',
                        ),
                        array(
                            'key'       => 'field_video_thumbnail',
                            'label'     => 'صورة مصغرة',
                            'name'      => 'thumbnail',
                            'type'      => 'image',
                            'return_format' => 'array',
                        ),
                    ),
                ),
                
                // Downloads
                array(
                    'key'           => 'field_product_downloads',
                    'label'         => 'الملفات القابلة للتحميل',
                    'name'          => 'downloads',
                    'type'          => 'repeater',
                    'layout'        => 'block',
                    'button_label'  => 'إضافة ملف',
                    'sub_fields'    => array(
                        array(
                            'key'       => 'field_download_file',
                            'label'     => 'الملف',
                            'name'      => 'file',
                            'type'      => 'file',
                            'required'  => 1,
                            'return_format' => 'array',
                        ),
                        array(
                            'key'       => 'field_download_title',
                            'label'     => 'عنوان الملف',
                            'name'      => 'title',
                            'type'      => 'text',
                            'required'  => 1,
                            'placeholder' => 'مثال: كتالوج المنتج',
                        ),
                        array(
                            'key'       => 'field_download_description',
                            'label'     => 'وصف الملف',
                            'name'      => 'description',
                            'type'      => 'textarea',
                            'rows'      => 2,
                            'placeholder' => 'وصف اختياري للملف',
                        ),
                    ),
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

