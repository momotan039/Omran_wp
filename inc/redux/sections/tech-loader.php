<?php
/**
 * Tech Preset - Page Loader Settings
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

// Page Loader Section
Redux::setSection($opt_name, array(
    'title'      => __('إعدادات شاشة التحميل', 'alomran'),
    'id'         => 'tech_loader_section',
    'subsection' => true,
    'parent'     => 'tech_general_sections',
    'icon'       => 'el el-time',
    'desc'       => __('تخصيص شاشة التحميل التي تظهر عند فتح الموقع', 'alomran'),
    'fields'     => array(
        // Enable/Disable Loader
        array(
            'id'       => 'tech_loader_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل شاشة التحميل', 'alomran'),
            'subtitle' => __('عرض شاشة التحميل عند فتح الموقع', 'alomran'),
            'default'  => true,
        ),
        
        // Loader Style
        array(
            'id'       => 'tech_loader_style',
            'type'     => 'button_set',
            'title'    => __('نمط شاشة التحميل', 'alomran'),
            'subtitle' => __('اختر النمط المفضل', 'alomran'),
            'options'  => array(
                'default' => __('افتراضي', 'alomran'),
                'minimal' => __('بسيط', 'alomran'),
                'modern' => __('عصري', 'alomran'),
            ),
            'default'  => 'default',
            'required' => array('tech_loader_enable', '=', true),
        ),
        
        // Loader Text
        array(
            'id'       => 'tech_loader_text',
            'type'     => 'text',
            'title'    => __('نص التحميل', 'alomran'),
            'subtitle' => __('النص الذي يظهر في شاشة التحميل', 'alomran'),
            'default'  => 'جاري التحميل',
            'required' => array('tech_loader_enable', '=', true),
        ),
        
        // Loader Logo/Icon
        array(
            'id'       => 'tech_loader_logo_type',
            'type'     => 'button_set',
            'title'    => __('نوع الشعار', 'alomran'),
            'subtitle' => __('اختر نوع الشعار في شاشة التحميل', 'alomran'),
            'options'  => array(
                'text'    => __('نص (أول حرف)', 'alomran'),
                'image'   => __('صورة', 'alomran'),
                'none'    => __('بدون شعار', 'alomran'),
            ),
            'default'  => 'text',
            'required' => array('tech_loader_enable', '=', true),
        ),
        
        array(
            'id'       => 'tech_loader_logo_image',
            'type'     => 'media',
            'title'    => __('صورة الشعار', 'alomran'),
            'subtitle' => __('اختر صورة الشعار لشاشة التحميل', 'alomran'),
            'required' => array(
                array('tech_loader_enable', '=', true),
                array('tech_loader_logo_type', '=', 'image'),
            ),
        ),
        
        // Loader Colors
        array(
            'id'       => 'tech_loader_primary_color',
            'type'     => 'color',
            'title'    => __('اللون الأساسي', 'alomran'),
            'subtitle' => __('اللون الأساسي لشاشة التحميل', 'alomran'),
            'default'  => '#2563eb',
            'validate' => 'color',
            'required' => array('tech_loader_enable', '=', true),
        ),
        
        array(
            'id'       => 'tech_loader_secondary_color',
            'type'     => 'color',
            'title'    => __('اللون الثانوي', 'alomran'),
            'subtitle' => __('اللون الثانوي لشاشة التحميل', 'alomran'),
            'default'  => '#6366f1',
            'validate' => 'color',
            'required' => array('tech_loader_enable', '=', true),
        ),
        
        array(
            'id'       => 'tech_loader_bg_color',
            'type'     => 'color',
            'title'    => __('لون الخلفية', 'alomran'),
            'subtitle' => __('لون خلفية شاشة التحميل', 'alomran'),
            'default'  => '#f8fafc',
            'validate' => 'color',
            'required' => array('tech_loader_enable', '=', true),
        ),
        
        // Loader Timing
        array(
            'id'            => 'tech_loader_min_time',
            'type'          => 'slider',
            'title'         => __('الحد الأدنى لوقت العرض (بالثواني)', 'alomran'),
            'subtitle'      => __('الحد الأدنى لوقت عرض شاشة التحميل', 'alomran'),
            'desc'          => __('لضمان تجربة سلسة، سيتم عرض الشاشة على الأقل لهذا الوقت', 'alomran'),
            'default'       => 0.8,
            'min'           => 0.1,
            'step'          => 0.1,
            'max'           => 5,
            'resolution'    => 0.1,
            'display_value' => 'text',
            'required'      => array('tech_loader_enable', '=', true),
        ),
        
        // Show Progress Bar
        array(
            'id'       => 'tech_loader_show_progress',
            'type'     => 'switch',
            'title'    => __('عرض شريط التقدم', 'alomran'),
            'subtitle' => __('عرض شريط التقدم في شاشة التحميل', 'alomran'),
            'default'  => true,
            'required' => array('tech_loader_enable', '=', true),
        ),
        
        // Show Spinner
        array(
            'id'       => 'tech_loader_show_spinner',
            'type'     => 'switch',
            'title'    => __('عرض المؤشر الدائري', 'alomran'),
            'subtitle' => __('عرض المؤشر الدائري في شاشة التحميل', 'alomran'),
            'default'  => true,
            'required' => array('tech_loader_enable', '=', true),
        ),
        
        // Show Dots Animation
        array(
            'id'       => 'tech_loader_show_dots',
            'type'     => 'switch',
            'title'    => __('عرض النقاط المتحركة', 'alomran'),
            'subtitle' => __('عرض النقاط المتحركة بجانب النص', 'alomran'),
            'default'  => true,
            'required' => array('tech_loader_enable', '=', true),
        ),
    ),
));

