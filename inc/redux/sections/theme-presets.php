<?php
/**
 * Theme Presets / Layout Selector Section
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => 'قوالب التصميم',
    'id'         => 'theme_presets',
    'icon'       => 'el el-brush',
    'desc'       => 'اختر قالب التصميم المناسب لصناعتك',
    'fields' => array(
        array(
            'id'       => 'theme_preset',
            'type'     => 'image_select',
            'title'    => 'اختر قالب التصميم',
            'subtitle' => 'اختر القالب الذي يناسب صناعتك',
            'options'  => array(
                'industrial' => array(
                    'alt' => 'Industrial',
                    'img' => get_template_directory_uri() . '/assets/images/presets/industrial.jpg',
                ),
                'food' => array(
                    'alt' => 'Food & Beverage',
                    'img' => get_template_directory_uri() . '/assets/images/presets/food.jpg',
                ),
                'tech' => array(
                    'alt' => 'Technology',
                    'img' => get_template_directory_uri() . '/assets/images/presets/tech.jpg',
                ),
            ),
            'default'  => 'industrial',
        ),
        
        // Industrial Preset Colors
        array(
            'id'       => 'preset_industrial_colors',
            'type'     => 'section',
            'title'    => 'ألوان القالب الصناعي',
            'indent'   => true,
            'required' => array('theme_preset', '=', 'industrial'),
        ),
        array(
            'id'       => 'preset_industrial_primary',
            'type'     => 'color',
            'title'    => 'اللون الأساسي',
            'default'  => '#2c5530',
            'validate' => 'color',
            'required' => array('theme_preset', '=', 'industrial'),
        ),
        array(
            'id'       => 'preset_industrial_secondary',
            'type'     => 'color',
            'title'    => 'اللون الثانوي',
            'default'  => '#4a7c59',
            'validate' => 'color',
            'required' => array('theme_preset', '=', 'industrial'),
        ),
        array(
            'id'       => 'preset_industrial_accent',
            'type'     => 'color',
            'title'    => 'لون التمييز',
            'default'  => '#f59e0b',
            'validate' => 'color',
            'required' => array('theme_preset', '=', 'industrial'),
        ),
        
        // Food Preset Colors
        array(
            'id'       => 'preset_food_colors',
            'type'     => 'section',
            'title'    => 'ألوان قالب الطعام والمشروبات',
            'indent'   => true,
            'required' => array('theme_preset', '=', 'food'),
        ),
        array(
            'id'       => 'preset_food_primary',
            'type'     => 'color',
            'title'    => 'اللون الأساسي',
            'default'  => '#dc2626',
            'validate' => 'color',
            'required' => array('theme_preset', '=', 'food'),
        ),
        array(
            'id'       => 'preset_food_secondary',
            'type'     => 'color',
            'title'    => 'اللون الثانوي',
            'default'  => '#f97316',
            'validate' => 'color',
            'required' => array('theme_preset', '=', 'food'),
        ),
        array(
            'id'       => 'preset_food_accent',
            'type'     => 'color',
            'title'    => 'لون التمييز',
            'default'  => '#fbbf24',
            'validate' => 'color',
            'required' => array('theme_preset', '=', 'food'),
        ),
        
        // Tech Preset Colors
        array(
            'id'       => 'preset_tech_colors',
            'type'     => 'section',
            'title'    => 'ألوان قالب التكنولوجيا',
            'indent'   => true,
            'required' => array('theme_preset', '=', 'tech'),
        ),
        array(
            'id'       => 'preset_tech_primary',
            'type'     => 'color',
            'title'    => 'اللون الأساسي',
            'default'  => '#1e40af',
            'validate' => 'color',
            'required' => array('theme_preset', '=', 'tech'),
        ),
        array(
            'id'       => 'preset_tech_secondary',
            'type'     => 'color',
            'title'    => 'اللون الثانوي',
            'default'  => '#3b82f6',
            'validate' => 'color',
            'required' => array('theme_preset', '=', 'tech'),
        ),
        array(
            'id'       => 'preset_tech_accent',
            'type'     => 'color',
            'title'    => 'لون التمييز',
            'default'  => '#06b6d4',
            'validate' => 'color',
            'required' => array('theme_preset', '=', 'tech'),
        ),
        
        // Typography Settings
        array(
            'id'       => 'preset_typography_section',
            'type'     => 'section',
            'title'    => 'إعدادات الخطوط',
            'indent'   => true,
        ),
        array(
            'id'       => 'preset_font_family',
            'type'     => 'select',
            'title'    => 'عائلة الخط',
            'options'  => array(
                'cairo'     => 'Cairo (افتراضي)',
                'tajawal'   => 'Tajawal',
                'almarai'   => 'Almarai',
                'changa'    => 'Changa',
                'amiri'     => 'Amiri',
            ),
            'default'  => 'cairo',
        ),
        array(
            'id'       => 'preset_font_weight',
            'type'     => 'select',
            'title'    => 'سمك الخط',
            'options'  => array(
                '300' => 'خفيف',
                '400' => 'عادي',
                '600' => 'متوسط',
                '700' => 'غامق',
                '900' => 'غامق جداً',
            ),
            'default'  => '400',
        ),
        
        // Header Style
        array(
            'id'       => 'preset_header_section',
            'type'     => 'section',
            'title'    => 'نمط الهيدر',
            'indent'   => true,
        ),
        array(
            'id'       => 'preset_header_style',
            'type'     => 'select',
            'title'    => 'نمط الهيدر',
            'options'  => array(
                'default'   => 'افتراضي (ثابت)',
                'transparent' => 'شفاف',
                'minimal'   => 'بسيط',
                'centered'  => 'مركزي',
            ),
            'default'  => 'default',
        ),
        array(
            'id'       => 'preset_header_sticky',
            'type'     => 'switch',
            'title'    => 'هيدر ثابت عند التمرير',
            'default'  => true,
        ),
        
        // Footer Style
        array(
            'id'       => 'preset_footer_section',
            'type'     => 'section',
            'title'    => 'نمط الفوتر',
            'indent'   => true,
        ),
        array(
            'id'       => 'preset_footer_style',
            'type'     => 'select',
            'title'    => 'نمط الفوتر',
            'options'  => array(
                'default'   => 'افتراضي',
                'minimal'   => 'بسيط',
                'centered'  => 'مركزي',
                'dark'      => 'داكن',
            ),
            'default'  => 'default',
        ),
        
        // Layout Structure
        array(
            'id'       => 'preset_layout_section',
            'type'     => 'section',
            'title'    => 'هيكل التخطيط',
            'indent'   => true,
        ),
        array(
            'id'       => 'preset_container_width',
            'type'     => 'select',
            'title'    => 'عرض الحاوية',
            'options'  => array(
                'full'      => 'كامل العرض',
                'wide'      => 'واسع (1400px)',
                'standard'  => 'قياسي (1200px)',
                'narrow'    => 'ضيق (960px)',
            ),
            'default'  => 'standard',
        ),
        array(
            'id'       => 'preset_content_layout',
            'type'     => 'select',
            'title'    => 'تخطيط المحتوى',
            'options'  => array(
                'boxed'     => 'محدد',
                'fullwidth' => 'كامل العرض',
            ),
            'default'  => 'boxed',
        ),
    ),
));

