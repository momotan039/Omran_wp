<?php
/**
 * Food & Beverage Preset Configuration
 * 
 * @package AlOmran_Preset_Food
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

return array(
    'id'          => 'food-beverage',
    'name'        => __('Food & Beverage', 'alomran'),
    'description' => __('Vibrant food industry theme with red, orange, and yellow accents, perfect for restaurants, food manufacturers, and beverage companies.', 'alomran'),
    'version'     => '1.0.0',
    
    // Color Palette
    'colors' => array(
        'primary'    => '#dc2626',
        'secondary'  => '#f97316',
        'accent'     => '#facc15',
        'background' => '#ffffff',
        'text'       => '#1f2937',
        'text_light' => '#6b7280',
        'gray_50'    => '#fef2f2',
        'gray_100'   => '#fee2e2',
        'gray_200'   => '#fecaca',
        'gray_300'   => '#fca5a5',
        'gray_400'   => '#f87171',
        'gray_500'   => '#ef4444',
        'gray_600'   => '#dc2626',
        'gray_700'   => '#b91c1c',
        'gray_800'   => '#991b1b',
        'gray_900'   => '#7f1d1d',
    ),
    
    // Typography
    'typography' => array(
        'font_family'     => 'Tajawal',
        'font_weight'     => '400',
        'heading_weight'  => '700',
        'body_size'       => '16px',
        'heading_scale'   => 1.3,
    ),
    
    // Layout Settings
    'layout' => array(
        'container_width' => 'wide',
        'content_layout'  => 'fullwidth',
        'header_style'    => 'transparent',
        'footer_style'    => 'dark',
        'header_sticky'   => true,
        'sidebar_position' => 'none',
    ),
    
    // Component Styles
    'components' => array(
        'button_radius'    => '0.75rem',
        'card_radius'      => '0.75rem',
        'card_shadow'      => '0 4px 6px rgba(220, 38, 38, 0.1)',
        'section_spacing'  => '5rem',
        'animation_speed'  => 'fast',
    ),
    
    // Template Overrides
    'templates' => array(
        // 'header' => 'presets/food-beverage/template-parts/header.php',
        // 'hero'   => 'presets/food-beverage/template-parts/sections/section-hero.php',
    ),
    
    // CSS Files
    'styles' => array(
        'main' => 'presets/food-beverage/assets/css/preset.css',
    ),
    
    // JavaScript Files
    'scripts' => array(
        // 'main' => 'presets/food-beverage/assets/js/preset.js',
    ),
    
    // Section Defaults
    'sections' => array(
        'hero' => array(
            'title'       => __('Discover Our Premium Food Solutions', 'alomran'),
            'subtitle'    => __('Quality ingredients, exceptional taste', 'alomran'),
            'badge'       => __('Fresh & Natural', 'alomran'),
        ),
        'products' => array(
            'title' => __('Our Food Products', 'alomran'),
            'show_ingredients' => true,
            'show_nutrition'   => true,
        ),
    ),
    
    // Features
    'features' => array(
        'show_breadcrumbs'      => true,
        'show_related_products' => true,
        'show_share_buttons'    => true,
        'show_author_info'      => false,
        'show_ingredients'      => true,
        'show_nutrition_facts'  => true,
    ),
);

