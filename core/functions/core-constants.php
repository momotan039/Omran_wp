<?php
/**
 * Core Constants and Definitions
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get theme preset
 * 
 * @return string Current theme preset.
 */
function omran_core_get_theme_preset() {
    /**
     * Filter the current theme preset.
     * 
     * @since 1.0.0
     * 
     * @param string $preset Theme preset identifier.
     */
    return apply_filters('omran_core_theme_preset', omran_core_get_option('theme_preset', 'industrial'));
}

/**
 * Get header style
 * 
 * @return string Header style identifier.
 */
function omran_core_get_header_style() {
    /**
     * Filter the header style.
     * 
     * @since 1.0.0
     * 
     * @param string $style Header style identifier.
     */
    return apply_filters('omran_core_header_style', omran_core_get_option('header_style', 'default'));
}

/**
 * Get footer style
 * 
 * @return string Footer style identifier.
 */
function omran_core_get_footer_style() {
    /**
     * Filter the footer style.
     * 
     * @since 1.0.0
     * 
     * @param string $style Footer style identifier.
     */
    return apply_filters('omran_core_footer_style', omran_core_get_option('footer_style', 'default'));
}

/**
 * Check if header is sticky
 * 
 * @return bool True if header is sticky.
 */
function omran_core_is_header_sticky() {
    /**
     * Filter whether header is sticky.
     * 
     * @since 1.0.0
     * 
     * @param bool $is_sticky Whether header is sticky.
     */
    return apply_filters('omran_core_is_header_sticky', omran_core_get_option('header_sticky', true));
}

/**
 * Get Redux option value
 * 
 * @param string $option Option key.
 * @param mixed  $default Default value.
 * @return mixed Option value.
 */
function omran_core_get_option($option, $default = '') {
    // On frontend, Redux should not be loaded, so get from database directly
    if (!is_admin() && !class_exists('Redux')) {
        $options = get_option('alomran_options', array());
        return isset($options[$option]) ? $options[$option] : $default;
    }
    
    // In admin, use Redux if available
    if (class_exists('Redux')) {
        return Redux::get_option('alomran_options', $option, $default);
    }
    
    // Fallback to database
    $options = get_option('alomran_options', array());
    return isset($options[$option]) ? $options[$option] : $default;
}

