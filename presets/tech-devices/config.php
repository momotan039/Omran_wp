<?php
/**
 * Tech & Devices Preset Configuration
 * 
 * @package AlOmran_Preset_Tech
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

return array(
    'id'          => 'tech-devices',
    'name'        => __('Technology & Devices', 'alomran'),
    'description' => __('Modern tech theme with blue and cyan accents, perfect for technology companies, electronics manufacturers, and device retailers.', 'alomran'),
    'version'     => '1.0.0',
    
    // Color Palette
    'colors' => array(
        'primary'    => '#1e40af',
        'secondary'  => '#3b82f6',
        'accent'     => '#22d3ee',
        'background' => '#ffffff',
        'text'       => '#1f2937',
        'text_light' => '#6b7280',
        'gray_50'    => '#eff6ff',
        'gray_100'   => '#dbeafe',
        'gray_200'   => '#bfdbfe',
        'gray_300'   => '#93c5fd',
        'gray_400'   => '#60a5fa',
        'gray_500'   => '#3b82f6',
        'gray_600'   => '#2563eb',
        'gray_700'   => '#1d4ed8',
        'gray_800'   => '#1e40af',
        'gray_900'   => '#1e3a8a',
    ),
    
    // Typography
    'typography' => array(
        'font_family'     => 'Changa',
        'font_weight'     => '600',
        'heading_weight'  => '800',
        'body_size'       => '16px',
        'heading_scale'   => 1.2,
    ),
    
    // Layout Settings
    'layout' => array(
        'container_width' => 'standard',
        'content_layout'  => 'boxed',
        'header_style'    => 'minimal',
        'footer_style'    => 'dark',
        'header_sticky'   => true,
        'sidebar_position' => 'none',
    ),
    
    // Component Styles
    'components' => array(
        'button_radius'    => '0.375rem',
        'card_radius'      => '0.5rem',
        'card_shadow'      => '0 8px 24px rgba(34, 211, 238, 0.15)',
        'section_spacing'  => '4rem',
        'animation_speed'  => 'normal',
        'glass_effect'     => true,
    ),
    
    // Template Overrides
    'templates' => array(
        // 'header' => 'presets/tech-devices/template-parts/header.php',
        // 'hero'   => 'presets/tech-devices/template-parts/sections/section-hero.php',
    ),
    
    // CSS Files
    'styles' => array(
        'main' => 'presets/tech-devices/assets/css/preset.css',
    ),
    
    // JavaScript Files
    'scripts' => array(
        // 'main' => 'presets/tech-devices/assets/js/preset.js',
    ),
    
    // Section Defaults
    'sections' => array(
        'hero' => array(
            'title'       => __('Innovation Meets Excellence', 'alomran'),
            'subtitle'    => __('Cutting-edge technology solutions', 'alomran'),
            'badge'       => __('Tech Leaders', 'alomran'),
        ),
        'products' => array(
            'title' => __('Our Technology Products', 'alomran'),
            'show_specs' => true,
            'show_certifications' => true,
        ),
    ),
    
    // Features
    'features' => array(
        'show_breadcrumbs'      => true,
        'show_related_products' => true,
        'show_share_buttons'    => true,
        'show_author_info'      => false,
        'show_technical_specs'  => true,
        'show_certifications'   => true,
    ),
);

