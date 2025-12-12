<?php
/**
 * Core Hooks System
 * 
 * Provides hooks and filters for theme presets to override core functionality
 * without modifying core files.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get ordered sections for homepage
 * 
 * @return array Ordered sections array (section_id => section_name).
 * 
 * @hook omran_core_ordered_sections
 */
function omran_core_get_ordered_sections() {
    $order = omran_core_get_option('sections_order', array());
    if (empty($order) || !isset($order['enabled'])) {
        $default_sections = array(
            'hero' => 'hero',
            'risks' => 'risks',
            'sectors' => 'sectors',
            'products' => 'products',
            'stainless' => 'stainless',
            'testimonials' => 'testimonials'
        );
        
        /**
         * Filter default sections order.
         * 
         * @since 1.0.0
         * 
         * @param array $sections Default sections array.
         */
        return apply_filters('omran_core_default_sections', $default_sections);
    }
    
    /**
     * Filter ordered sections.
     * 
     * @since 1.0.0
     * 
     * @param array $sections Ordered sections array.
     */
    return apply_filters('omran_core_ordered_sections', $order['enabled']);
}

/**
 * Check if a section is enabled
 * 
 * @param string $section Section identifier.
 * @return bool True if section is enabled.
 * 
 * @hook omran_core_section_enabled
 */
function omran_core_is_section_enabled($section) {
    $enabled = omran_core_get_option($section . '_enable', true);
    
    /**
     * Filter whether a section is enabled.
     * 
     * @since 1.0.0
     * 
     * @param bool   $enabled Whether section is enabled.
     * @param string $section Section identifier.
     */
    return apply_filters('omran_core_section_enabled', $enabled, $section);
}

/**
 * Get ordered about page sections
 * 
 * @return array Ordered about sections array.
 * 
 * @hook omran_core_ordered_about_sections
 */
function omran_core_get_ordered_about_sections() {
    $order = omran_core_get_option('about_sections_order', array());
    if (empty($order) || !isset($order['enabled'])) {
        $default_sections = array(
            'header' => 'header',
            'content' => 'content',
            'vision_mission' => 'vision_mission',
            'stats' => 'stats'
        );
        
        /**
         * Filter default about sections order.
         * 
         * @since 1.0.0
         * 
         * @param array $sections Default about sections array.
         */
        return apply_filters('omran_core_default_about_sections', $default_sections);
    }
    
    /**
     * Filter ordered about sections.
     * 
     * @since 1.0.0
     * 
     * @param array $sections Ordered about sections array.
     */
    return apply_filters('omran_core_ordered_about_sections', $order['enabled']);
}

/**
 * Get section data
 * 
 * @param string $section Section identifier.
 * @return array Section data array.
 * 
 * @hook omran_core_section_data
 */
function omran_core_get_section_data($section) {
    /**
     * Allow presets to provide section data before core processing.
     * 
     * @since 1.0.0
     * 
     * @param null|array $data Section data (null to use core).
     * @param string     $section Section identifier.
     */
    $data = apply_filters('omran_core_section_data_pre', null, $section);
    
    if (null !== $data) {
        return $data;
    }
    
    // Load core section data
    require_once OMRAN_CORE_DIR . '/redux/section-data.php';
    $data = omran_core_load_section_data($section);
    
    /**
     * Filter section data after core processing.
     * 
     * @since 1.0.0
     * 
     * @param array  $data Section data array.
     * @param string $section Section identifier.
     */
    return apply_filters('omran_core_section_data', $data, $section);
}

/**
 * Get section template path
 * 
 * @param string $section Section identifier.
 * @return string Template path.
 * 
 * @hook omran_core_section_template
 */
function omran_core_get_section_template($section) {
    $template = 'template-parts/sections/section-' . $section;
    
    /**
     * Filter section template path.
     * 
     * @since 1.0.0
     * 
     * @param string $template Template path.
     * @param string $section Section identifier.
     */
    return apply_filters('omran_core_section_template', $template, $section);
}

