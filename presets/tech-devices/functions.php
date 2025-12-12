<?php
/**
 * Tech & Devices Preset Functions
 * 
 * Custom functions and hooks for the Tech & Devices preset.
 * 
 * @package AlOmran_Preset_Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Set the preset identifier
 */
add_filter('omran_core_theme_preset', function() {
    return 'tech-devices';
});

/**
 * Customize section data for Tech & Devices preset
 */
add_filter('omran_core_section_data', function($data, $section) {
    $config = omran_core_get_active_preset_config();
    
    if (!$config || $config['id'] !== 'tech-devices') {
        return $data;
    }
    
    // Apply preset section defaults
    if (isset($config['sections'][$section])) {
        $defaults = $config['sections'][$section];
        foreach ($defaults as $key => $value) {
            if (!isset($data[$key]) || empty($data[$key])) {
                $data[$key] = $value;
            }
        }
    }
    
    return $data;
}, 10, 2);

/**
 * Customize products query for tech industry
 */
add_filter('omran_core_products_query_args', function($args) {
    $preset = omran_core_get_theme_preset();
    
    if ($preset === 'tech-devices' || $preset === 'tech') {
        // Filter by tech industry type
        if (!isset($args['meta_query'])) {
            $args['meta_query'] = array();
        }
        $args['meta_query'][] = array(
            'key' => 'industry_type',
            'value' => 'tech',
            'compare' => '='
        );
    }
    
    return $args;
});

/**
 * Add Tech & Devices-specific body classes
 */
add_filter('omran_core_body_classes', function($classes, $preset, $header_style, $footer_style) {
    if ($preset === 'tech-devices' || $preset === 'tech') {
        $classes[] = 'preset-tech-devices';
        $classes[] = 'tech-industry';
    }
    return $classes;
}, 10, 4);

