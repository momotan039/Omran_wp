<?php
/**
 * Tech Preset - Footer Configuration
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
    'title'      => __('إعدادات الفوتر', 'alomran'),
    'id'         => 'tech_footer_settings',
    'subsection' => true,
    'parent'     => 'tech_general_sections',
    'icon'       => 'el el-arrow-down',
    'desc'       => __('إعدادات تذييل الموقع - الوصف، حقوق النشر، والقوائم', 'alomran'),
    'fields'     => array(
        // Divider: المحتوى
        array(
            'id'       => 'tech_footer_content_divider',
            'type'     => 'divide',
            'title'    => __('المحتوى', 'alomran'),
        ),
        
        array(
            'id'       => 'tech_footer_description',
            'type'     => 'textarea',
            'title'    => __('وصف الفوتر', 'alomran'),
            'subtitle' => __('وصف مختصر يظهر تحت شعار الموقع في الفوتر', 'alomran'),
            'default'  => 'المنصة التقنية الأولى في العالم العربي لإدارة الأعمال والمشاريع بكفاءة ذكاء اصطناعي متطور.',
        ),
        array(
            'id'       => 'tech_footer_copyright',
            'type'     => 'text',
            'title'    => __('نص حقوق النشر', 'alomran'),
            'subtitle' => __('نص حقوق النشر الذي يظهر في أسفل الفوتر', 'alomran'),
            'default'  => '© 2024 إتقان SaaS. جميع الحقوق محفوظة.',
        ),
        
        // Divider: القوائم
        array(
            'id'       => 'tech_footer_menus_divider',
            'type'     => 'divide',
            'title'    => __('القوائم', 'alomran'),
        ),
        
        array(
            'id'       => 'tech_footer_menu_info',
            'type'     => 'info',
            'title'    => __('قوائم الفوتر', 'alomran'),
            'style'    => 'info',
            'desc'     => __('لإدارة قوائم الفوتر، اذهب إلى: المظهر > القوائم. أنشئ قائمة جديدة أو استخدم قائمة موجودة وحدد موقعها كـ "Footer Menu". يمكنك إضافة عناصر رئيسية وفرعية للقائمة.', 'alomran'),
        ),
    ),
));


