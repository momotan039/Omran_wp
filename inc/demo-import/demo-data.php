<?php
/**
 * Demo Data Definitions
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get demo data for a specific preset
 * 
 * @param string $preset Preset name (industrial, food, tech)
 * @return array
 */
function alomran_get_demo_data($preset = 'industrial') {
    $demos = array(
        'industrial' => array(
            'name' => 'Industrial',
            'colors' => array(
                'primary' => '#2c5530',
                'secondary' => '#4a7c59',
                'accent' => '#f97316', // Optimized vibrant orange
            ),
            'font_family' => 'cairo',
            'font_weight' => '400',
            'header_style' => 'default',
            'footer_style' => 'default',
            'container_width' => 'standard',
            'content_layout' => 'boxed',
        ),
        'food' => array(
            'name' => 'Food & Beverage',
            'colors' => array(
                'primary' => '#dc2626',
                'secondary' => '#f97316',
                'accent' => '#facc15', // Optimized bright yellow
            ),
            'font_family' => 'tajawal',
            'font_weight' => '400',
            'header_style' => 'transparent',
            'footer_style' => 'dark',
            'container_width' => 'wide',
            'content_layout' => 'fullwidth',
        ),
        'tech' => array(
            'name' => 'Technology',
            'colors' => array(
                'primary' => '#1e40af',
                'secondary' => '#3b82f6',
                'accent' => '#22d3ee', // Optimized bright cyan
            ),
            'font_family' => 'changa',
            'font_weight' => '600',
            'header_style' => 'minimal',
            'footer_style' => 'dark',
            'container_width' => 'standard',
            'content_layout' => 'boxed',
        ),
    );
    
    return isset($demos[$preset]) ? $demos[$preset] : $demos['industrial'];
}

/**
 * Import demo data for a preset
 * 
 * @param string $preset Preset name
 * @return array Result with success status and message
 */
function alomran_import_demo_data($preset = 'industrial') {
    if (!current_user_can('manage_options')) {
        return array('success' => false, 'message' => 'غير مصرح');
    }
    
    $demo_data = alomran_get_demo_data($preset);
    
    if (!class_exists('Redux')) {
        return array('success' => false, 'message' => 'Redux Framework غير مثبت');
    }
    
    $opt_name = 'alomran_options';
    
    // Get current options
    $current_options = get_option($opt_name, array());
    
    // Update theme preset
    $current_options['theme_preset'] = $preset;
    
    // Update colors
    $current_options['preset_' . $preset . '_primary'] = $demo_data['colors']['primary'];
    $current_options['preset_' . $preset . '_secondary'] = $demo_data['colors']['secondary'];
    $current_options['preset_' . $preset . '_accent'] = $demo_data['colors']['accent'];
    
    // Update typography
    $current_options['preset_font_family'] = $demo_data['font_family'];
    $current_options['preset_font_weight'] = $demo_data['font_weight'];
    
    // Update header/footer
    $current_options['preset_header_style'] = $demo_data['header_style'];
    $current_options['preset_footer_style'] = $demo_data['footer_style'];
    
    // Update layout
    $current_options['preset_container_width'] = $demo_data['container_width'];
    $current_options['preset_content_layout'] = $demo_data['content_layout'];
    
    // Save options
    update_option($opt_name, $current_options);
    
    // Clear any caches
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush();
    }
    
    return array(
        'success' => true,
        'message' => sprintf('تم استيراد بيانات القالب "%s" بنجاح', $demo_data['name'])
    );
}

