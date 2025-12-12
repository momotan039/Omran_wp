<?php
/**
 * Food & Beverage Preset Functions
 * 
 * Custom functions and hooks for the Food & Beverage preset.
 * 
 * @package AlOmran_Preset_Food
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Set the preset identifier
 */
add_filter('omran_core_theme_preset', function() {
    return 'food-beverage';
});

/**
 * Customize section data for Food & Beverage preset
 */
add_filter('omran_core_section_data', function($data, $section) {
    $config = omran_core_get_active_preset_config();
    
    if (!$config || $config['id'] !== 'food-beverage') {
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
 * Customize products query for food industry
 */
add_filter('omran_core_products_query_args', function($args) {
    $preset = omran_core_get_theme_preset();
    
    if ($preset === 'food-beverage') {
        // Filter by food industry type
        if (!isset($args['meta_query'])) {
            $args['meta_query'] = array();
        }
        $args['meta_query'][] = array(
            'key' => 'industry_type',
            'value' => 'food',
            'compare' => '='
        );
    }
    
    return $args;
});

/**
 * Add Food & Beverage-specific body classes
 */
add_filter('omran_core_body_classes', function($classes, $preset, $header_style, $footer_style) {
    if ($preset === 'food-beverage' || $preset === 'food') {
        $classes[] = 'preset-food-beverage';
        $classes[] = 'food-industry';
    }
    return $classes;
}, 10, 4);

