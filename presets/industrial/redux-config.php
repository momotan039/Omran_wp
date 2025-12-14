<?php
/**
 * Industrial Preset Redux Configuration
 * 
 * Header and Footer settings for Industrial preset
 * 
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

// Only load in admin and if Redux is available
if (!is_admin() || !class_exists('Redux')) {
    return;
}

$opt_name = 'alomran_options';

// Header & Logo Settings Section - Unified
if (class_exists('Redux')) {
    /** @phpstan-ignore-next-line */
    Redux::setSection($opt_name, array(
        'title'      => __('الهيدر والشعار', 'alomran'),
        'id'         => 'header_logo_settings',
        'subsection' => false,
        'icon'       => 'el el-arrow-up',
        'desc'       => __('تخصيص مظهر الهيدر والشعار والألوان', 'alomran'),
        'fields'     => array(
            // ============================================
            // الشعار
            // ============================================
            array(
                'id'       => 'logo_main_section',
                'type'     => 'section',
                'title'    => __('الشعار', 'alomran'),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_logo',
                'type'     => 'media',
                'title'    => __('صورة الشعار', 'alomran'),
                'subtitle' => __('قم برفع صورة الشعار الرئيسية (اتركه فارغاً لاستخدام أيقونة الشعار من الإعدادات العامة)', 'alomran'),
                'default'  => '',
            ),
            array(
                'id'       => 'header_logo_width',
                'type'     => 'slider',
                'title'    => __('عرض الشعار', 'alomran'),
                'subtitle' => __('اضبط عرض الشعار بالبكسل', 'alomran'),
                'default'  => 150,
                'min'      => 50,
                'max'      => 300,
                'step'     => 10,
                'validate' => 'numeric',
            ),
            array(
                'id'       => 'header_logo_height',
                'type'     => 'slider',
                'title'    => __('ارتفاع الشعار', 'alomran'),
                'subtitle' => __('اضبط ارتفاع الشعار بالبكسل', 'alomran'),
                'default'  => 60,
                'min'      => 30,
                'max'      => 150,
                'step'     => 5,
                'validate' => 'numeric',
            ),
            array(
                'id'       => 'header_logo_show_title',
                'type'     => 'switch',
                'title'    => __('إظهار العنوان', 'alomran'),
                'subtitle' => __('إظهار أو إخفاء العنوان بجانب الشعار', 'alomran'),
                'default'  => true,
                'on'       => __('إظهار', 'alomran'),
                'off'      => __('إخفاء', 'alomran'),
            ),
            array(
                'id'       => 'header_logo_title',
                'type'     => 'text',
                'title'    => __('عنوان الشعار', 'alomran'),
                'subtitle' => __('أدخل العنوان الذي سيظهر بجانب الشعار (اتركه فارغاً لاستخدام اسم الشركة من الإعدادات العامة - نفس القيمة في الـ Loader)', 'alomran'),
                'default'  => '',
                'required' => array('header_logo_show_title', '=', true),
            ),
            array(
                'id'       => 'header_logo_show_subtitle',
                'type'     => 'switch',
                'title'    => __('إظهار العنوان الثانوي', 'alomran'),
                'subtitle' => __('إظهار أو إخفاء العنوان الثانوي تحت العنوان', 'alomran'),
                'default'  => true,
                'on'       => __('إظهار', 'alomran'),
                'off'      => __('إخفاء', 'alomran'),
            ),
            array(
                'id'       => 'header_logo_subtitle',
                'type'     => 'text',
                'title'    => __('العنوان الثانوي', 'alomran'),
                'subtitle' => __('أدخل العنوان الثانوي الذي سيظهر تحت العنوان (اتركه فارغاً لاستخدام شعار الشركة من الإعدادات العامة - نفس القيمة في الـ Loader)', 'alomran'),
                'default'  => '',
                'required' => array('header_logo_show_subtitle', '=', true),
            ),
            
            // ============================================
            // ألوان الهيدر
            // ============================================
            array(
                'id'       => 'header_colors_section',
                'type'     => 'section',
                'title'    => __('ألوان الهيدر', 'alomran'),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_bg_color',
                'type'     => 'color',
                'title'    => __('لون الخلفية', 'alomran'),
                'subtitle' => __('لون خلفية الهيدر', 'alomran'),
                'default'  => '',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'header_text_color',
                'type'     => 'color',
                'title'    => __('لون النص', 'alomran'),
                'subtitle' => __('لون النص العام في الهيدر', 'alomran'),
                'default'  => '',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'header_link_color',
                'type'     => 'color',
                'title'    => __('لون روابط القائمة', 'alomran'),
                'subtitle' => __('لون روابط القائمة في الهيدر', 'alomran'),
                'default'  => '',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'header_link_hover_color',
                'type'     => 'color',
                'title'    => __('لون روابط القائمة عند التمرير', 'alomran'),
                'subtitle' => __('لون روابط القائمة عند تمرير الماوس', 'alomran'),
                'default'  => '',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'header_border_color',
                'type'     => 'color',
                'title'    => __('لون الحدود', 'alomran'),
                'subtitle' => __('لون الحدود السفلية للهيدر', 'alomran'),
                'default'  => '',
                'validate' => 'color',
                'transparent' => false,
            ),
        ),
    ));
}
