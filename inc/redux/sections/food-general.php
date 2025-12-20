<?php
/**
 * Food Preset - General Settings Main Section
 * 
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Redux')) {
    return;
}

$opt_name = 'alomran_options';

// Main General Settings Section
Redux::setSection($opt_name, array(
    'title'  => __('إعدادات عامة', 'alomran'),
    'id'     => 'food_general_sections',
    'icon'   => 'el el-cog',
    'desc'   => __('الإعدادات العامة للموقع', 'alomran'),
));

// Header Settings Subsection
Redux::setSection($opt_name, array(
    'title'      => __('الهيدر', 'alomran'),
    'id'         => 'food_header_section',
    'subsection' => true,
    'parent'     => 'food_general_sections',
    'icon'       => 'el el-arrow-up',
    'desc'       => __('إعدادات شاملة للهيدر - تخصيص كامل', 'alomran'),
    'fields'     => array(
        // ============================================
        // الإعدادات العامة
        // ============================================
        array(
            'id'       => 'food_header_general_section',
            'type'     => 'section',
            'title'    => __('الإعدادات العامة', 'alomran'),
            'indent'   => true,
        ),
        array(
            'id'       => 'food_header_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل الهيدر', 'alomran'),
            'subtitle' => __('إظهار أو إخفاء الهيدر', 'alomran'),
            'default'  => true,
            'on'       => __('مفعل', 'alomran'),
            'off'      => __('معطل', 'alomran'),
        ),
        array(
            'id'       => 'food_header_sticky',
            'type'     => 'switch',
            'title'    => __('هيدر ثابت', 'alomran'),
            'subtitle' => __('إبقاء الهيدر ثابتاً عند التمرير', 'alomran'),
            'default'  => true,
            'required' => array('food_header_enable', '=', true),
        ),
        array(
            'id'       => 'food_header_transparent',
            'type'     => 'switch',
            'title'    => __('هيدر شفاف', 'alomran'),
            'subtitle' => __('جعل الهيدر شفافاً على الصفحة الرئيسية', 'alomran'),
            'default'  => true,
            'required' => array('food_header_enable', '=', true),
        ),
        
        // ============================================
        // الشعار
        // ============================================
        array(
            'id'       => 'food_header_logo_section',
            'type'     => 'section',
            'title'    => __('الشعار', 'alomran'),
            'indent'   => true,
        ),
        array(
            'id'       => 'food_header_logo_type',
            'type'     => 'button_set',
            'title'    => __('نوع الشعار', 'alomran'),
            'subtitle' => __('اختر بين صورة لوغو أو نص', 'alomran'),
            'options'  => array(
                'text'  => __('نص', 'alomran'),
                'image' => __('صورة', 'alomran'),
            ),
            'default'  => 'text',
            'required' => array('food_header_enable', '=', true),
        ),
        array(
            'id'       => 'food_header_logo_image',
            'type'     => 'media',
            'title'    => __('صورة الشعار', 'alomran'),
            'subtitle' => __('قم برفع صورة الشعار (يفضل PNG مع خلفية شفافة)', 'alomran'),
            'default'  => '',
            'required' => array(
                array('food_header_enable', '=', true),
                array('food_header_logo_type', '=', 'image'),
            ),
        ),
        array(
            'id'       => 'food_header_logo_image_width',
            'type'     => 'slider',
            'title'    => __('عرض صورة الشعار', 'alomran'),
            'subtitle' => __('عرض صورة الشعار بالبكسل', 'alomran'),
            'default'  => 150,
            'min'      => 50,
            'max'      => 300,
            'step'     => 10,
            'required' => array(
                array('food_header_enable', '=', true),
                array('food_header_logo_type', '=', 'image'),
            ),
        ),
        array(
            'id'       => 'food_app_name_ar',
            'type'     => 'text',
            'title'    => __('اسم التطبيق (عربي)', 'alomran'),
            'subtitle' => __('الاسم الذي سيظهر في الشعار والفوتر', 'alomran'),
            'default'  => 'الجوهرة',
            'required' => array('food_header_enable', '=', true),
        ),
        array(
            'id'       => 'food_app_name_en',
            'type'     => 'text',
            'title'    => __('اسم التطبيق (إنجليزي)', 'alomran'),
            'subtitle' => __('الاسم الإنجليزي الذي سيظهر تحت الشعار', 'alomran'),
            'default'  => 'Al-Jawhara',
            'required' => array(
                array('food_header_enable', '=', true),
                array('food_header_logo_type', '=', 'text'),
            ),
        ),
        array(
            'id'       => 'food_header_logo_size',
            'type'     => 'slider',
            'title'    => __('حجم الشعار', 'alomran'),
            'subtitle' => __('حجم نص الشعار بالبكسل', 'alomran'),
            'default'  => 36,
            'min'      => 20,
            'max'      => 60,
            'step'     => 2,
            'required' => array(
                array('food_header_enable', '=', true),
                array('food_header_logo_type', '=', 'text'),
            ),
        ),
        
        // ============================================
        // القائمة
        // ============================================
        array(
            'id'       => 'food_header_menu_section',
            'type'     => 'section',
            'title'    => __('القائمة', 'alomran'),
            'indent'   => true,
        ),
        array(
            'id'       => 'food_header_show_menu',
            'type'     => 'switch',
            'title'    => __('إظهار القائمة', 'alomran'),
            'subtitle' => __('إظهار أو إخفاء روابط القائمة في الهيدر', 'alomran'),
            'default'  => true,
            'required' => array('food_header_enable', '=', true),
        ),
        array(
            'id'       => 'food_header_menu_font_size',
            'type'     => 'slider',
            'title'    => __('حجم خط القائمة', 'alomran'),
            'subtitle' => __('حجم خط روابط القائمة بالبكسل', 'alomran'),
            'default'  => 12,
            'min'      => 10,
            'max'      => 18,
            'step'     => 1,
            'required' => array(
                array('food_header_enable', '=', true),
                array('food_header_show_menu', '=', true),
            ),
        ),
        array(
            'id'       => 'food_header_menu_spacing',
            'type'     => 'slider',
            'title'    => __('المسافة بين الروابط', 'alomran'),
            'subtitle' => __('المسافة بين روابط القائمة بالبكسل', 'alomran'),
            'default'  => 40,
            'min'      => 20,
            'max'      => 80,
            'step'     => 5,
            'required' => array(
                array('food_header_enable', '=', true),
                array('food_header_show_menu', '=', true),
            ),
        ),
        
        // ============================================
        // زر الحجز
        // ============================================
        array(
            'id'       => 'food_header_button_section',
            'type'     => 'section',
            'title'    => __('زر الحجز', 'alomran'),
            'indent'   => true,
        ),
        array(
            'id'       => 'food_header_show_reservation_button',
            'type'     => 'switch',
            'title'    => __('إظهار زر الحجز', 'alomran'),
            'subtitle' => __('إظهار أو إخفاء زر "احجز الآن" في الهيدر', 'alomran'),
            'default'  => true,
            'required' => array('food_header_enable', '=', true),
        ),
        array(
            'id'       => 'food_header_reservation_button_text',
            'type'     => 'text',
            'title'    => __('نص زر الحجز', 'alomran'),
            'subtitle' => __('النص الذي سيظهر على زر الحجز', 'alomran'),
            'default'  => 'احجز الآن',
            'required' => array(
                array('food_header_enable', '=', true),
                array('food_header_show_reservation_button', '=', true),
            ),
        ),
        array(
            'id'       => 'food_header_reservation_button_link_type',
            'type'     => 'select',
            'title'    => __('رابط زر الحجز', 'alomran'),
            'subtitle' => __('اختر صفحة من القالب أو رابط مخصص', 'alomran'),
            'options'  => alomran_get_preset_pages_options(),
            'default'  => 'reservations',
            'required' => array(
                array('food_header_enable', '=', true),
                array('food_header_show_reservation_button', '=', true),
            ),
        ),
        array(
            'id'       => 'food_header_reservation_button_link_custom',
            'type'     => 'text',
            'title'    => __('رابط مخصص لزر الحجز', 'alomran'),
            'subtitle' => __('أدخل رابط خارجي أو hash (مثل: #section أو https://example.com)', 'alomran'),
            'default'  => '',
            'required' => array(
                array('food_header_enable', '=', true),
                array('food_header_show_reservation_button', '=', true),
                array('food_header_reservation_button_link_type', '=', 'custom'),
            ),
        ),
        
        // ============================================
        // التصميم والمظهر
        // ============================================
        array(
            'id'       => 'food_header_design_section',
            'type'     => 'section',
            'title'    => __('التصميم والمظهر', 'alomran'),
            'indent'   => true,
        ),
        array(
            'id'       => 'food_header_padding',
            'type'     => 'slider',
            'title'    => __('المسافة الداخلية', 'alomran'),
            'subtitle' => __('المسافة الداخلية للهيدر بالبكسل', 'alomran'),
            'default'  => 16,
            'min'      => 8,
            'max'      => 40,
            'step'     => 2,
            'required' => array('food_header_enable', '=', true),
        ),
        array(
            'id'       => 'food_header_border_radius',
            'type'     => 'slider',
            'title'    => __('زوايا دائرية', 'alomran'),
            'subtitle' => __('درجة استدارة زوايا الهيدر بالبكسل', 'alomran'),
            'default'  => 9999,
            'min'      => 0,
            'max'      => 50,
            'step'     => 5,
            'required' => array('food_header_enable', '=', true),
        ),
        array(
            'id'       => 'food_header_background_opacity',
            'type'     => 'slider',
            'title'    => __('شفافية الخلفية', 'alomran'),
            'subtitle' => __('شفافية خلفية الهيدر عند التمرير (0 = شفاف تماماً، 100 = معتم)', 'alomran'),
            'default'  => 95,
            'min'      => 0,
            'max'      => 100,
            'step'     => 5,
            'required' => array('food_header_enable', '=', true),
        ),
    ),
));

