<?php
/**
 * Example: Food & Beverage Preset
 * 
 * This is an example preset implementation showing how to customize
 * the core theme for a Food & Beverage industry.
 * 
 * To use this preset:
 * 1. Copy this file to your child theme's functions.php
 * 2. Or create a mu-plugin that includes this file
 * 3. Customize the values as needed
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
 * Customize body classes for Food & Beverage preset
 */
add_filter('omran_core_body_classes', function($classes, $preset, $header_style, $footer_style) {
    if ($preset === 'food-beverage') {
        $classes[] = 'preset-food-beverage';
        $classes[] = 'food-industry';
    }
    return $classes;
}, 10, 4);

/**
 * Customize Hero section for Food & Beverage
 */
add_filter('omran_core_hero_data', function($data) {
    // Override hero title for food industry
    $data['title'] = __('Discover Our Premium Food Solutions', 'alomran');
    $data['subtitle'] = __('Quality ingredients, exceptional taste', 'alomran');
    return $data;
});

/**
 * Customize Products section for Food & Beverage
 */
add_filter('omran_core_products_data', function($data) {
    $data['title'] = __('Our Food Products', 'alomran');
    // Add food-specific options
    $data['show_ingredients'] = true;
    $data['show_nutrition'] = true;
    return $data;
});

/**
 * Customize Products query to show food products
 */
add_filter('omran_core_products_query_args', function($args) {
    // Filter by food industry type
    $args['meta_query'] = array(
        array(
            'key' => 'industry_type',
            'value' => 'food',
            'compare' => '='
        )
    );
    return $args;
});

/**
 * Override section templates for Food & Beverage
 */
add_filter('omran_core_section_template', function($template, $section) {
    // Use food-specific templates if they exist
    $food_template = 'template-parts/sections/food-' . $section;
    if (locate_template($food_template . '.php')) {
        return $food_template;
    }
    return $template;
}, 10, 2);

/**
 * Enqueue Food & Beverage preset styles
 */
add_action('wp_enqueue_scripts', function() {
    $preset_css = get_template_directory_uri() . '/presets/food-beverage/assets/css/preset.css';
    if (file_exists(get_template_directory() . '/presets/food-beverage/assets/css/preset.css')) {
        wp_enqueue_style(
            'preset-food-beverage',
            $preset_css,
            array('alomran-tailwind'),
            '1.0.0'
        );
    }
}, 20);

/**
 * Customize header for Food & Beverage
 */
add_filter('omran_core_header_template', function($template, $style) {
    // Use transparent header for food preset
    if (omran_core_get_theme_preset() === 'food-beverage') {
        return 'template-parts/header/header-transparent';
    }
    return $template;
}, 10, 2);

/**
 * Add custom JavaScript for Food & Beverage preset
 */
add_action('wp_enqueue_scripts', function() {
    $preset_js = get_template_directory_uri() . '/presets/food-beverage/assets/js/preset.js';
    if (file_exists(get_template_directory() . '/presets/food-beverage/assets/js/preset.js')) {
        wp_enqueue_script(
            'preset-food-beverage',
            $preset_js,
            array('jquery'),
            '1.0.0',
            true
        );
    }
}, 20);

/**
 * Example: Customize testimonial display for food industry
 */
add_filter('omran_core_testimonials_data', function($data) {
    // Show more testimonials for food industry
    $data['count'] = 4;
    $data['title'] = __('What Our Customers Say', 'alomran');
    return $data;
});

/**
 * Example: Add custom section for food preset
 */
add_action('omran_core_after_section', function($section) {
    if ($section === 'products' && omran_core_get_theme_preset() === 'food-beverage') {
        // Add nutrition info section after products
        get_template_part('template-parts/sections/food-nutrition');
    }
});

