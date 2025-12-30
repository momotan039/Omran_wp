<?php
/**
 * Tech Preset - Features Page Configuration
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
    'title'      => __('صفحة المميزات', 'alomran'),
    'id'         => 'tech_features_page',
    'subsection' => true,
    'parent'     => 'tech_pages_sections',
    'icon'       => 'el el-star',
    'fields'     => array(
        array(
            'id'       => 'tech_features_page_title',
            'type'     => 'text',
            'title'    => __('عنوان الصفحة', 'alomran'),
            'default'  => 'بنية تحتية تنمو مع أعمالك',
        ),
        array(
            'id'       => 'tech_features_page_title_highlight',
            'type'     => 'text',
            'title'    => __('جزء العنوان المميز', 'alomran'),
            'default'  => 'تنمو مع أعمالك',
        ),
        array(
            'id'       => 'tech_features_categories',
            'type'     => 'repeater',
            'title'    => __('تصنيفات المميزات', 'alomran'),
            'subtitle' => __('أضف أو عدّل تصنيفات المميزات. كل تصنيف يحتوي على قائمة مميزات.', 'alomran'),
            'group_values' => true,
            'bind_title' => 'category_label',
            'item_name' => __('تصنيف', 'alomran'),
            'sortable' => true,
            'fields'   => array(
                array(
                    'id'       => 'category_id',
                    'type'     => 'text',
                    'title'    => __('معرف التصنيف', 'alomran'),
                    'subtitle' => __('معرف فريد للتصنيف (مثل: integration, automation). استخدم أحرف إنجليزية فقط.', 'alomran'),
                    'placeholder' => 'مثال: integration',
                    'default'  => '',
                ),
                array(
                    'id'       => 'category_label',
                    'type'     => 'text',
                    'title'    => __('اسم التصنيف', 'alomran'),
                    'subtitle' => __('اسم التصنيف الذي يظهر في التبويبات', 'alomran'),
                    'placeholder' => 'مثال: الربط البرمجي (API)',
                    'default'  => '',
                ),
                array(
                    'id'       => 'category_features',
                    'type'     => 'textarea',
                    'title'    => __('مميزات التصنيف', 'alomran'),
                    'subtitle' => __('أضف مميزات هذا التصنيف (سطر واحد لكل ميزة بالصيغة: العنوان | الوصف | الأيقونة)', 'alomran'),
                    'desc'     => __('<strong>مثال:</strong><br>SDKs جاهزة | مكتبات برمجية متكاملة لـ PHP, Python, Node.js. | 📦<br>Webhooks لحظية | استقبل إشعارات فورية عن حالة الشحنات والمدفوعات. | 🔌', 'alomran'),
                    'default'  => '',
                    'rows'     => 6,
                ),
            ),
        ),
    ),
));

