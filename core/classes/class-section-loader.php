<?php
/**
 * Core Section Loader
 * 
 * Handles dynamic section template loading based on preset
 * 
 * @package AlOmran
 * @subpackage Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class AlOmran_Section_Loader {
    
    /**
     * Initialize section loader
     */
    public static function init() {
        // Filter section template paths
        add_filter('alomran_section_template', array(__CLASS__, 'filter_section_template'), 10, 2);
    }
    
    /**
     * Filter section template path
     * 
     * @param string $template_path Original template path
     * @param string $section_id Section ID
     * @return string
     */
    public static function filter_section_template($template_path, $section_id) {
        $preset = AlOmran_Preset_Loader::get_active_preset();
        
        // Try preset section template first
        $preset_template = AlOmran_Preset_Loader::locate_template('section-' . $section_id, 'sections');
        
        if ($preset_template) {
            return $preset_template;
        }
        
        // Fallback to core template
        $core_template = ALOMRAN_THEME_DIR . '/template-parts/sections/section-' . sanitize_file_name($section_id) . '.php';
        
        if (file_exists($core_template)) {
            return $core_template;
        }
        
        return $template_path;
    }
    
    /**
     * Load section template
     * 
     * @param string $section_id Section ID
     * @param array $args Optional arguments
     */
    public static function load_section($section_id, $args = array()) {
        $template_path = apply_filters('alomran_section_template', '', $section_id);
        
        if ($template_path && file_exists($template_path)) {
            extract($args);
            include $template_path;
        } else {
            // Fallback: try get_template_part
            $template_name = 'sections/section-' . sanitize_file_name($section_id);
            get_template_part($template_name);
        }
    }
    
    /**
     * Check if section is enabled
     * 
     * @param string $section_id Section ID
     * @return bool
     */
    public static function is_section_enabled($section_id) {
        // Use existing helper function
        if (function_exists('alomran_is_section_enabled')) {
            return alomran_is_section_enabled($section_id);
        }
        
        // Fallback: check Redux option
        $option_name = 'section_' . sanitize_key($section_id) . '_enabled';
        return alomran_get_option($option_name, true);
    }
    
    /**
     * Get ordered sections
     * 
     * @return array
     */
    public static function get_ordered_sections() {
        // Use existing helper function
        if (function_exists('alomran_get_ordered_sections')) {
            return alomran_get_ordered_sections();
        }
        
        // Fallback: default sections order
        return array(
            'hero' => __('Hero Section', 'alomran'),
            'risks' => __('Risks Section', 'alomran'),
            'sectors' => __('Sectors Section', 'alomran'),
            'products' => __('Products Section', 'alomran'),
            'stainless' => __('Stainless Section', 'alomran'),
            'testimonials' => __('Testimonials Section', 'alomran'),
        );
    }
}

