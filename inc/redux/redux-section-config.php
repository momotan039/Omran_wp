<?php
/**
 * Redux Section Configuration
 * Unified configuration for all Tech preset repeater sections
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get unified section configuration for Tech preset
 * Returns array with section ID, field ID, tab number, and type for each section
 * This is the SINGLE SOURCE OF TRUTH for all section mappings
 * 
 * Structure:
 * [
 *   'section_id' => [
 *     'field_id' => 'repeater_field_id',
 *     'tab' => tab_number,  // Optional, for page sections only
 *     'type' => 'homepage' | 'page',  // Section type
 *     'group' => 'homepage' | 'pages'  // Group for organization
 *   ]
 * ]
 */
function alomran_get_tech_sections_config() {
    return array(
        // ============================================
        // Homepage Sections (tab 8, redux-section 3)
        // Each section is handled separately
        // ============================================
        'tech_features_preview_section' => array(
            'field_id' => 'tech_features_preview_items',
            'type' => 'homepage',
            'group' => 'homepage',
            'tab' => 8,  // Homepage tab
            'redux_section' => 3,  // Redux internal section number
        ),
        'tech_stats_section' => array(
            'field_id' => 'tech_stats_items',
            'type' => 'homepage',
            'group' => 'homepage',
            'tab' => 8,
            'redux_section' => 3,
        ),
        'tech_testimonials_section' => array(
            'field_id' => 'tech_testimonials_items',
            'type' => 'homepage',
            'group' => 'homepage',
            'tab' => 8,
            'redux_section' => 3,
        ),
        // ============================================
        // Page Sections (tabs 9-15)
        // ============================================
        'tech_features_page' => array(
            'field_id' => 'tech_features_categories',
            'type' => 'page',
            'group' => 'pages',
            'tab' => 9,
            'redux_section' => 9,
        ),
        'tech_pricing_page' => array(
            'field_id' => 'tech_pricing_plans',
            'type' => 'page',
            'group' => 'pages',
            'tab' => 10,
            'redux_section' => 10,
        ),
        'tech_use_cases_page' => array(
            'field_id' => 'tech_use_cases_items',
            'type' => 'page',
            'group' => 'pages',
            'tab' => 11,
            'redux_section' => 11,
        ),
        'tech_demo_page' => array(
            'field_id' => 'tech_demo_benefits',
            'type' => 'page',
            'group' => 'pages',
            'tab' => 10,  // Same tab as pricing (subsection)
            'redux_section' => 10,
        ),
    );
}

/**
 * Get section-to-field mapping (backward compatibility)
 * @deprecated Use alomran_get_tech_sections_config() instead
 */
function alomran_get_tech_section_to_field_map() {
    $config = alomran_get_tech_sections_config();
    $map = array();
    foreach ($config as $section_id => $section_data) {
        $map[$section_id] = $section_data['field_id'];
    }
    return $map;
}

/**
 * Get field-to-section mapping (for reverse lookup)
 */
function alomran_get_tech_field_to_section_map() {
    $config = alomran_get_tech_sections_config();
    $map = array();
    foreach ($config as $section_id => $section_data) {
        $map[$section_data['field_id']] = $section_id;
    }
    return $map;
}

/**
 * Get homepage sections only
 */
function alomran_get_tech_homepage_sections() {
    $config = alomran_get_tech_sections_config();
    $homepage = array();
    foreach ($config as $section_id => $section_data) {
        if ($section_data['type'] === 'homepage') {
            $homepage[$section_id] = $section_data;
        }
    }
    return $homepage;
}

/**
 * Get page sections only
 */
function alomran_get_tech_page_sections() {
    $config = alomran_get_tech_sections_config();
    $pages = array();
    foreach ($config as $section_id => $section_data) {
        if ($section_data['type'] === 'page') {
            $pages[$section_id] = $section_data;
        }
    }
    return $pages;
}

/**
 * Build tab-to-section mapping for page sections
 */
function alomran_get_tech_tab_to_section_map() {
    $config = alomran_get_tech_sections_config();
    $tab_to_section = array();
    foreach ($config as $section_id => $section_data) {
        if (isset($section_data['tab']) && isset($section_data['type']) && $section_data['type'] === 'page') {
            $tab = $section_data['tab'];
            // Handle multiple sections on same tab (like tech_demo_page on tab 10)
            if (!isset($tab_to_section[$tab])) {
                $tab_to_section[$tab] = $section_id;
            }
        }
    }
    return $tab_to_section;
}

/**
 * Get homepage tab-to-section mapping
 */
function alomran_get_tech_homepage_tab_to_section_map() {
    return array(
        4 => 'tech_features_preview_section',  // Tab 4 = Features Preview
        5 => 'tech_stats_section',              // Tab 5 = Stats
        6 => 'tech_testimonials_section',        // Tab 6 = Testimonials
    );
}

