<?php
/**
 * Industrial Preset Functions
 * 
 * Custom functions and hooks for the Industrial preset.
 * 
 * @package AlOmran_Preset_Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Set the preset identifier
 */
add_filter('omran_core_theme_preset', function() {
    return 'industrial';
});

/**
 * Customize section data for Industrial preset
 */
add_filter('omran_core_section_data', function($data, $section) {
    $config = omran_core_get_active_preset_config();
    
    if (!$config || $config['id'] !== 'industrial') {
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
 * Add Industrial-specific body classes
 */
add_filter('omran_core_body_classes', function($classes, $preset, $header_style, $footer_style) {
    if ($preset === 'industrial') {
        $classes[] = 'preset-industrial';
        $classes[] = 'industrial-theme';
    }
    return $classes;
}, 10, 4);

