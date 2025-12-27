<?php
/**
 * Tech Preset - Hero Section Configuration
 * 
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Redux')) {
    return;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => __('قسم البطل', 'alomran'),
    'id'         => 'tech_hero_section',
    'subsection' => true,
    'parent'     => 'tech_homepage_sections',
    'icon'       => 'el el-picture',
    'desc'       => __('إعدادات قسم البطل الرئيسي في الصفحة الرئيسية', 'alomran'),
    'fields'     => array(
        // Enable/Disable
        array(
            'id'       => 'tech_hero_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل قسم البطل', 'alomran'),
            'subtitle' => __('عرض/إخفاء قسم البطل من الصفحة الرئيسية', 'alomran'),
            'default'  => true,
        ),
        
        // Divider: المحتوى
        array(
            'id'       => 'tech_hero_content_divider',
            'type'     => 'divide',
            'title'    => __('المحتوى', 'alomran'),
        ),
        
        array(
            'id'       => 'tech_hero_badge',
            'type'     => 'text',
            'title'    => __('الشارة (Badge)', 'alomran'),
            'subtitle' => __('نص الشارة التي تظهر أعلى العنوان (اختياري)', 'alomran'),
            'default'  => 'جديد: الربط المباشر مع منصات "زد" و "سلة" و "تطوير"',
            'required' => array('tech_hero_enable', '=', true),
        ),
        array(
            'id'       => 'tech_hero_title',
            'type'     => 'text',
            'title'    => __('العنوان الرئيسي', 'alomran'),
            'subtitle' => __('العنوان الرئيسي للقسم (سيتم حفظه حتى عند التعطيل)', 'alomran'),
            'default'  => 'اربط تقنياتك وأتمت عملك',
        ),
        array(
            'id'       => 'tech_hero_title_highlight',
            'type'     => 'text',
            'title'    => __('جزء العنوان المميز', 'alomran'),
            'subtitle' => __('الكلمة أو الجملة التي ستظهر باللون الأزرق المتدرج', 'alomran'),
            'default'  => 'في 5 ثوانٍ فقط',
            'required' => array('tech_hero_enable', '=', true),
        ),
        array(
            'id'       => 'tech_hero_description',
            'type'     => 'textarea',
            'title'    => __('الوصف', 'alomran'),
            'subtitle' => __('وصف مختصر يظهر تحت العنوان', 'alomran'),
            'default'  => 'محرك الأتمتة الأول للشركات التقنية في المنطقة. وفر أسابيع من التطوير البرمجي وابدأ التوسع اليوم.',
            'required' => array('tech_hero_enable', '=', true),
        ),
        
        // Divider: الوسائط
        array(
            'id'       => 'tech_hero_media_divider',
            'type'     => 'divide',
            'title'    => __('الوسائط', 'alomran'),
        ),
        
        array(
            'id'       => 'tech_hero_image',
            'type'     => 'media',
            'title'    => __('صورة لوحة التحكم', 'alomran'),
            'subtitle' => __('صورة معاينة لوحة التحكم التي تظهر في قسم البطل (اختياري)', 'alomran'),
        ),
        
        // Divider: الأزرار
        array(
            'id'       => 'tech_hero_buttons_divider',
            'type'     => 'divide',
            'title'    => __('الأزرار', 'alomran'),
        ),
        
        array(
            'id'       => 'tech_hero_primary_button_text',
            'type'     => 'text',
            'title'    => __('نص الزر الأساسي', 'alomran'),
            'subtitle' => __('النص الذي يظهر على الزر الأساسي', 'alomran'),
            'default'  => 'ابدأ مجاناً',
            'required' => array('tech_hero_enable', '=', true),
        ),
        array(
            'id'       => 'tech_hero_primary_button_link_type',
            'type'     => 'select',
            'title'    => __('نوع رابط الزر الأساسي', 'alomran'),
            'subtitle' => __('اختر صفحة من القالب أو رابط مخصص', 'alomran'),
            'options'  => alomran_get_preset_pages_options(),
            'default'  => 'register',
            'required' => array('tech_hero_enable', '=', true),
        ),
        array(
            'id'       => 'tech_hero_primary_button_link_custom',
            'type'     => 'text',
            'title'    => __('رابط مخصص للزر الأساسي', 'alomran'),
            'subtitle' => __('أدخل رابط خارجي (https://) أو hash (#section) - يظهر فقط عند اختيار "رابط مخصص"', 'alomran'),
            'default'  => '',
            'required' => array(
                array('tech_hero_enable', '=', true),
                array('tech_hero_primary_button_link_type', '=', 'custom'),
            ),
        ),
        array(
            'id'       => 'tech_hero_secondary_button_text',
            'type'     => 'text',
            'title'    => __('نص الزر الثانوي', 'alomran'),
            'subtitle' => __('النص الذي يظهر على الزر الثانوي', 'alomran'),
            'default'  => 'شاهد العرض',
            'required' => array('tech_hero_enable', '=', true),
        ),
        array(
            'id'       => 'tech_hero_secondary_button_link_type',
            'type'     => 'select',
            'title'    => __('نوع رابط الزر الثانوي', 'alomran'),
            'subtitle' => __('اختر صفحة من القالب أو رابط مخصص', 'alomran'),
            'options'  => alomran_get_preset_pages_options(),
            'default'  => 'features',
            'required' => array('tech_hero_enable', '=', true),
        ),
        array(
            'id'       => 'tech_hero_secondary_button_link_custom',
            'type'     => 'text',
            'title'    => __('رابط مخصص للزر الثانوي', 'alomran'),
            'subtitle' => __('أدخل رابط خارجي (https://) أو hash (#section) - يظهر فقط عند اختيار "رابط مخصص"', 'alomran'),
            'default'  => '',
            'required' => array(
                array('tech_hero_enable', '=', true),
                array('tech_hero_secondary_button_link_type', '=', 'custom'),
            ),
        ),
    ),
));

