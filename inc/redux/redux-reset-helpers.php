<?php
/**
 * Redux Reset Helpers
 * Shared helper functions for reset operations
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if this is a reset operation
 * Checks multiple sources for reset indicators
 * 
 * @return array Array with 'is_reset', 'is_section_reset', 'is_reset_all', 'reset_section'
 */
function alomran_detect_reset_operation() {
    $result = array(
        'is_reset' => false,
        'is_section_reset' => false,
        'is_reset_all' => false,
        'reset_section' => '',
    );
    
    // Check if data is URL-encoded in POST['data']
    $parsed_data = array();
    if (isset($_POST['data']) && !empty($_POST['data'])) {
        parse_str($_POST['data'], $parsed_data);
    }
    
    // Check Redux's defaults-section parameter (most important!)
    if (isset($parsed_data['alomran_options']['defaults-section']) && !empty($parsed_data['alomran_options']['defaults-section'])) {
        $result['is_section_reset'] = true;
        $result['is_reset'] = true;
        
        // Try to get section ID from redux-section (tab number)
        if (isset($parsed_data['alomran_options']['redux-section']) && !empty($parsed_data['alomran_options']['redux-section'])) {
            $tab_number = intval($parsed_data['alomran_options']['redux-section']);
            $tab_to_section = alomran_get_tech_tab_to_section_map();
            
            if (isset($tab_to_section[$tab_number])) {
                $result['reset_section'] = $tab_to_section[$tab_number];
            }
        }
    }
    // Also check in direct POST
    elseif (isset($_POST['alomran_options']['defaults-section']) && !empty($_POST['alomran_options']['defaults-section'])) {
        $result['is_section_reset'] = true;
        $result['is_reset'] = true;
        
        if (isset($_POST['alomran_options']['redux-section']) && !empty($_POST['alomran_options']['redux-section'])) {
            $tab_number = intval($_POST['alomran_options']['redux-section']);
            $tab_to_section = alomran_get_tech_tab_to_section_map();
            
            if (isset($tab_to_section[$tab_number])) {
                $result['reset_section'] = $tab_to_section[$tab_number];
            }
        }
    }
    
    // Check JavaScript-set values (for homepage subsections and other sections)
    // This is the PRIMARY method for homepage subsections
    $reset_section_sources = array(
        $_POST['redux-reset-section'] ?? '',
        $_COOKIE['redux_reset_section'] ?? '',
        $_POST['redux_reset_section'] ?? '',
        $_POST['redux-reset-section-id'] ?? '',
        $_GET['redux-reset-section'] ?? '',
        $_REQUEST['redux-reset-section'] ?? '',
    );
    
    if (empty($result['reset_section'])) {
        foreach ($reset_section_sources as $source) {
            if (!empty($source)) {
                $result['is_section_reset'] = true;
                $result['is_reset'] = true;
                $result['reset_section'] = sanitize_text_field($source);
                break;
            }
        }
    }
    
    // Check URL parameters (Redux sometimes uses this)
    if (empty($result['reset_section']) && isset($_GET['section']) && isset($_GET['redux-reset']) && $_GET['redux-reset'] === '1') {
        $result['is_section_reset'] = true;
        $result['is_reset'] = true;
        $result['reset_section'] = sanitize_text_field($_GET['section']);
    }
    
    // Check if this is a reset all operation
    if (isset($_POST['redux-reset']) || 
        (isset($_GET['reset']) && $_GET['reset'] === 'all') ||
        (isset($_REQUEST['redux-reset']) && $_REQUEST['redux-reset'] === 'all') ||
        (isset($_GET['redux-reset']) && $_GET['redux-reset'] === 'all')) {
        $result['is_reset_all'] = true;
        $result['is_reset'] = true;
    }
    
    return $result;
}

/**
 * Get section ID from homepage tab number
 * 
 * @param int $tab_number Tab number from URL or POST
 * @return string|null Section ID or null if not found
 */
function alomran_get_homepage_section_from_tab($tab_number) {
    $tab_to_section = alomran_get_tech_homepage_tab_to_section_map();
    return isset($tab_to_section[$tab_number]) ? $tab_to_section[$tab_number] : null;
}

/**
 * Detect homepage section from POST data and tab
 * 
 * @param array $parsed_data Parsed POST data
 * @param int|null $current_tab Current tab number
 * @return string|null Section ID or null if not found
 */
function alomran_detect_homepage_section_from_post($parsed_data, $current_tab = null) {
    if (!isset($parsed_data['alomran_options']['defaults-section'])) {
        return null;
    }
    
    $homepage_sections = alomran_get_tech_homepage_sections();
    $field_to_section = alomran_get_tech_field_to_section_map();
    
    // First, try to match by tab number (most reliable when tab is known)
    if ($current_tab) {
        $candidate_section = alomran_get_homepage_section_from_tab($current_tab);
        if ($candidate_section) {
            $candidate_field = isset($homepage_sections[$candidate_section]) ? $homepage_sections[$candidate_section]['field_id'] : null;
            
            // Verify that this field exists in POST data
            if ($candidate_field && isset($parsed_data['alomran_options'][$candidate_field])) {
                return $candidate_section;
            }
        }
    }
    
    // Fallback: Check all fields and find the best match
    $best_match = null;
    $best_match_score = 999; // Lower is better
    
    foreach ($homepage_sections as $section_id => $section_data) {
        $field_id = $section_data['field_id'];
        if (isset($parsed_data['alomran_options'][$field_id])) {
            $field_data = $parsed_data['alomran_options'][$field_id];
            
            // Count how many items are in this repeater field
            $item_count = 0;
            if (is_array($field_data)) {
                if (isset($field_data['redux_repeater_data']) && is_array($field_data['redux_repeater_data'])) {
                    $item_count = count($field_data['redux_repeater_data']);
                } else {
                    foreach ($field_data as $key => $value) {
                        if (is_array($value) && isset($value[0])) {
                            $item_count = count($value);
                            break;
                        }
                    }
                }
            }
            
            // Priority boost based on tab
            $priority_boost = 0;
            if ($current_tab === 4 && $section_id === 'tech_features_preview_section') {
                $priority_boost = 20;
            } elseif ($current_tab === 5 && $section_id === 'tech_stats_section') {
                $priority_boost = 20;
            } elseif ($current_tab === 6 && $section_id === 'tech_testimonials_section') {
                $priority_boost = 20;
            }
            
            $score = $item_count - $priority_boost;
            
            if ($score < $best_match_score) {
                $best_match = $section_id;
                $best_match_score = $score;
            }
        }
    }
    
    return $best_match;
}

/**
 * Clear Redux caches
 */
function alomran_clear_redux_caches() {
    delete_transient('redux-alomran_options');
    wp_cache_delete('alomran_options', 'options');
    wp_cache_delete('alloptions', 'options');
}

/**
 * Remove field from POST data
 * 
 * @param string $field_id Field ID to remove
 */
function alomran_remove_field_from_post($field_id) {
    // Remove from POST data string
    if (isset($_POST['data']) && !empty($_POST['data'])) {
        parse_str($_POST['data'], $post_data);
        if (isset($post_data['alomran_options'][$field_id])) {
            unset($post_data['alomran_options'][$field_id]);
            $_POST['data'] = http_build_query($post_data);
        }
    }
    
    // Also remove from direct POST array
    if (isset($_POST['alomran_options'][$field_id])) {
        unset($_POST['alomran_options'][$field_id]);
    }
}

/**
 * Clear reset section cookie
 */
function alomran_clear_reset_section_cookie() {
    if (isset($_COOKIE['redux_reset_section'])) {
        setcookie('redux_reset_section', '', time() - 3600, '/');
        unset($_COOKIE['redux_reset_section']);
    }
}

