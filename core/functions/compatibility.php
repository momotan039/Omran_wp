<?php
/**
 * Backward Compatibility Layer
 * 
 * Maps old function names to new core functions for backward compatibility.
 * This ensures existing templates and code continue to work.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Backward compatibility: Map old function names to new core functions
 */

// Redux Options
if (!function_exists('alomran_get_option')) {
    function alomran_get_option($option, $default = '') {
        return omran_core_get_option($option, $default);
    }
}

if (!function_exists('alomran_get_ordered_sections')) {
    function alomran_get_ordered_sections() {
        return omran_core_get_ordered_sections();
    }
}

if (!function_exists('alomran_is_section_enabled')) {
    function alomran_is_section_enabled($section) {
        return omran_core_is_section_enabled($section);
    }
}

if (!function_exists('alomran_get_ordered_about_sections')) {
    function alomran_get_ordered_about_sections() {
        return omran_core_get_ordered_about_sections();
    }
}

if (!function_exists('alomran_get_section_data')) {
    function alomran_get_section_data($section) {
        return omran_core_get_section_data($section);
    }
}

// Note: Theme preset functions (alomran_get_theme_preset, alomran_get_header_style, etc.)
// are loaded from helpers-presets.php and keep their original names.
// They don't need compatibility mapping since they weren't renamed to omran_core_*.
// The omran_core_* versions are defined in core-constants.php for core use.

// Parser Functions
if (!function_exists('alomran_parse_risks_items')) {
    function alomran_parse_risks_items($textarea) {
        return omran_core_parse_risks_items($textarea);
    }
}

if (!function_exists('alomran_parse_sectors_items')) {
    function alomran_parse_sectors_items($textarea) {
        return omran_core_parse_sectors_items($textarea);
    }
}

if (!function_exists('alomran_parse_stainless_items')) {
    function alomran_parse_stainless_items($textarea) {
        return omran_core_parse_stainless_items($textarea);
    }
}

// Note: Helper functions like alomran_format_url() are loaded from helpers-url.php
// and other helper files. They don't need compatibility mapping since they keep
// their original names. Only functions that were renamed to omran_core_* need
// compatibility mappings here.

