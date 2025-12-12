<?php
/**
 * Industrial Preset Configuration
 * 
 * @package AlOmran_Preset_Industrial
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

return array(
    'id'          => 'industrial',
    'name'        => __('Industrial', 'alomran'),
    'description' => __('Professional industrial theme with green and orange accents, perfect for manufacturing and engineering companies.', 'alomran'),
    'version'     => '1.0.0',
    
    // Color Palette
    'colors' => array(
        'primary'    => '#2c5530',
        'secondary'  => '#4a7c59',
        'accent'     => '#f97316',
        'background' => '#ffffff',
        'text'       => '#1f2937',
        'text_light' => '#6b7280',
        'gray_50'    => '#f9fafb',
        'gray_100'   => '#f3f4f6',
        'gray_200'   => '#e5e7eb',
        'gray_300'   => '#d1d5db',
        'gray_400'   => '#9ca3af',
        'gray_500'   => '#6b7280',
        'gray_600'   => '#4b5563',
        'gray_700'   => '#374151',
        'gray_800'   => '#1f2937',
        'gray_900'   => '#111827',
    ),
    
    // Typography
    'typography' => array(
        'font_family'     => 'Cairo',
        'font_weight'     => '400',
        'heading_weight' => '700',
        'body_size'       => '16px',
        'heading_scale'  => 1.25,
    ),
    
    // Layout Settings
    'layout' => array(
        'container_width' => 'standard', // full, wide, standard, narrow
        'content_layout'  => 'boxed',    // boxed, fullwidth
        'header_style'    => 'default',  // default, transparent, minimal, centered
        'footer_style'    => 'default',  // default, dark, minimal, centered
        'header_sticky'   => true,
        'sidebar_position' => 'none',    // left, right, none
    ),
    
    // Component Styles
    'components' => array(
        'button_radius'    => '0.5rem',
        'card_radius'      => '0.5rem',
        'card_shadow'      => '0 1px 3px rgba(0, 0, 0, 0.1)',
        'section_spacing'  => '4rem',
        'animation_speed'  => 'normal',
    ),
    
    // Template Overrides
    'templates' => array(
        // 'header' => 'presets/industrial/template-parts/header.php',
        // 'footer' => 'presets/industrial/template-parts/footer.php',
        // 'hero'   => 'presets/industrial/template-parts/sections/section-hero.php',
    ),
    
    // CSS Files
    'styles' => array(
        'main' => 'presets/industrial/assets/css/preset.css',
    ),
    
    // JavaScript Files
    'scripts' => array(
        // 'main' => 'presets/industrial/assets/js/preset.js',
    ),
    
    // Section Defaults
    'sections' => array(
        'hero' => array(
            'title'       => __('جودة تدوم.. لمستقبل أنقى', 'alomran'),
            'subtitle'    => __('في كل قطرة ومشروع', 'alomran'),
            'badge'       => __('الرائدون في مصر', 'alomran'),
        ),
        'products' => array(
            'title' => __('منتجات مختارة', 'alomran'),
        ),
    ),
    
    // Features
    'features' => array(
        'show_breadcrumbs'     => true,
        'show_related_products' => true,
        'show_share_buttons'    => true,
        'show_author_info'      => false,
    ),
);

