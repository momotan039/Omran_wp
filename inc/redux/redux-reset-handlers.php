<?php
/**
 * Redux Reset Handlers
 * Handles all reset operations for repeater fields
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Backup user repeater data before reset
 * Saves current user data to transient for potential recovery
 */
function alomran_backup_repeater_data_before_reset() {
    $reset_info = alomran_detect_reset_operation();
    
    // Only backup on reset operations
    if (!$reset_info['is_section_reset'] && !$reset_info['is_reset_all']) {
        return;
    }
    
    // Get current options
    $current_options = get_option('alomran_options', array());
    
    // Get unified section configuration
    $section_to_field = alomran_get_tech_section_to_field_map();
    
    // Get all repeater field IDs
    $all_repeater_fields = array_values($section_to_field);
    
    // Backup data
    $backup_data = array();
    
    if ($reset_info['is_section_reset'] && !empty($reset_info['reset_section']) && isset($section_to_field[$reset_info['reset_section']])) {
        // Backup single section
        $field_id = $section_to_field[$reset_info['reset_section']];
        if (isset($current_options[$field_id]) && !empty($current_options[$field_id])) {
            $backup_data[$field_id] = $current_options[$field_id];
        }
    } elseif ($reset_info['is_reset_all']) {
        // Backup all repeater fields
        foreach ($all_repeater_fields as $field_id) {
            if (isset($current_options[$field_id]) && !empty($current_options[$field_id])) {
                $backup_data[$field_id] = $current_options[$field_id];
            }
        }
    }
    
    // Save backup to transient (store for 24 hours)
    if (!empty($backup_data)) {
        set_transient('alomran_repeater_backup_' . time(), $backup_data, DAY_IN_SECONDS);
        // Also save with section ID for easy retrieval
        if ($reset_info['is_section_reset'] && !empty($reset_info['reset_section'])) {
            set_transient('alomran_repeater_backup_section_' . $reset_info['reset_section'], $backup_data, DAY_IN_SECONDS);
        }
    }
}
add_action('redux/options/alomran_options/before_save', 'alomran_backup_repeater_data_before_reset', 5);

/**
 * Restore repeater defaults when section is reset or reset all
 * This ensures that repeater fields are restored to defaults when user clicks Reset Section or Reset All
 */
function alomran_restore_repeater_defaults_on_section_reset($options) {
    // Check if $options is an array (not Redux_Panel object)
    if (!is_array($options)) {
        return $options;
    }
    
    $reset_info = alomran_detect_reset_operation();
    
    // CRITICAL: If this is NOT a reset operation, return options as-is
    // Each section is independent - Redux will handle saving only what's in POST
    if (!$reset_info['is_section_reset'] && !$reset_info['is_reset_all']) {
        return $options;
    }
    
    // Get unified section configuration
    $section_to_field = alomran_get_tech_section_to_field_map();
    
    // Get all repeater field IDs for reset all
    $all_repeater_fields = array_values($section_to_field);
    
    // Get default values
    $defaults = alomran_get_tech_repeater_defaults();
    
    // Process section reset - restore defaults for single section ONLY
    // CRITICAL: Each section is independent - we only modify the section being reset
    // Redux will automatically preserve other sections from database
    if ($reset_info['is_section_reset'] && !empty($reset_info['reset_section'])) {
        if (isset($section_to_field[$reset_info['reset_section']])) {
            $field_id = $section_to_field[$reset_info['reset_section']];
            
            // Set to defaults or empty array for THIS section ONLY
            if (isset($defaults[$field_id]) && !empty($defaults[$field_id])) {
                $options[$field_id] = $defaults[$field_id];
            } else {
                $options[$field_id] = array();
            }
            
            // Remove from POST data to prevent Redux from re-saving old data
            alomran_remove_field_from_post($field_id);
        }
    }
    
    // Process reset all - restore defaults for all repeater fields
    if ($reset_info['is_reset_all']) {
        foreach ($all_repeater_fields as $field_id) {
            // Restore default values if available, otherwise set to empty array
            if (isset($defaults[$field_id])) {
                $options[$field_id] = $defaults[$field_id];
            } else {
                $options[$field_id] = array();
            }
        }
    }
    
    return $options;
}
add_filter('redux/options/alomran_options/validate', 'alomran_restore_repeater_defaults_on_section_reset', 1, 1);

/**
 * Handle section reset using Redux's reset hook
 * This is more reliable than checking POST/GET data
 */
function alomran_handle_redux_section_reset($options) {
    $reset_info = alomran_detect_reset_operation();
    
    // Get unified section configuration
    $section_to_field = alomran_get_tech_section_to_field_map();
    
    // Get default values
    $defaults = alomran_get_tech_repeater_defaults();
    
    // If we have a section ID, restore its defaults
    if (!empty($reset_info['reset_section']) && isset($section_to_field[$reset_info['reset_section']])) {
        $field_id = $section_to_field[$reset_info['reset_section']];
        
        // Restore default values if available, otherwise set to empty array
        if (isset($defaults[$field_id])) {
            $options[$field_id] = $defaults[$field_id];
        } else {
            $options[$field_id] = array();
        }
    }
    
    return $options;
}
add_action('redux/options/alomran_options/reset', 'alomran_handle_redux_section_reset', 10, 1);

/**
 * ULTRA-FAST: Force delete repeater data immediately after section reset
 * This runs on EVERY page load in admin to catch reset operations
 */
function alomran_ultra_fast_reset_repeater() {
    // Only in admin
    if (!is_admin()) {
        return;
    }
    
    // Check if data is URL-encoded in POST['data']
    $parsed_data = array();
    if (isset($_POST['data']) && !empty($_POST['data'])) {
        parse_str($_POST['data'], $parsed_data);
    }
    
    $reset_info = alomran_detect_reset_operation();
    
    // If this is NOT a reset operation, handle normal save
    // Remove homepage repeater fields that are NOT being modified
    if (!$reset_info['is_reset']) {
        // Check if this is a Redux AJAX save request
        $is_ajax_save = isset($_POST['action']) && $_POST['action'] === 'alomran_options_ajax_save';
        
        if ($is_ajax_save || isset($parsed_data['alomran_options'])) {
            // Get homepage sections
            $homepage_sections = alomran_get_tech_homepage_sections();
            
            // Get current tab from URL or POST
            $current_tab = null;
            if (isset($_GET['tab']) && !empty($_GET['tab'])) {
                $current_tab = intval($_GET['tab']);
            } elseif (isset($parsed_data['alomran_options']['redux-section']) && !empty($parsed_data['alomran_options']['redux-section'])) {
                $current_tab = intval($parsed_data['alomran_options']['redux-section']);
            } elseif (isset($_POST['alomran_options']['redux-section']) && !empty($_POST['alomran_options']['redux-section'])) {
                $current_tab = intval($_POST['alomran_options']['redux-section']);
            }
            
            // Determine which section is being saved
            $current_section = alomran_get_homepage_section_from_tab($current_tab);
            
            if ($current_section) {
                // Remove homepage repeater fields that are NOT in the current section
                $removed_any = false;
                foreach ($homepage_sections as $section_id => $section_data) {
                    $field_id = $section_data['field_id'];
                    
                    // Skip if this is the current section being saved
                    if ($current_section === $section_id) {
                        continue;
                    }
                    
                    // Remove from parsed POST data
                    if (isset($parsed_data['alomran_options'][$field_id])) {
                        unset($parsed_data['alomran_options'][$field_id]);
                        $removed_any = true;
                    }
                    
                    // Also remove from direct POST array (Redux uses this directly)
                    if (isset($_POST['alomran_options'][$field_id])) {
                        unset($_POST['alomran_options'][$field_id]);
                        $removed_any = true;
                    }
                }
                
                // Rebuild POST data string if we removed any fields
                if ($removed_any && isset($_POST['data']) && !empty($_POST['data'])) {
                    $_POST['data'] = http_build_query($parsed_data);
                }
            }
        }
        
        // Exit - don't process reset logic
        return;
    }
    
    // If this is a reset operation, continue with reset logic
    $section_to_field = alomran_get_tech_section_to_field_map();
    
    // Get section ID from ALL possible sources
    $reset_section = $reset_info['reset_section'];
    
    // For homepage subsections, detect from field IDs in POST data
    if (empty($reset_section) && isset($parsed_data['alomran_options']['defaults-section'])) {
        // Get current tab from URL or POST
        $current_tab = null;
        if (isset($_GET['tab']) && !empty($_GET['tab'])) {
            $current_tab = intval($_GET['tab']);
        } elseif (isset($parsed_data['alomran_options']['redux-section']) && !empty($parsed_data['alomran_options']['redux-section'])) {
            $current_tab = intval($parsed_data['alomran_options']['redux-section']);
        }
        
        $reset_section = alomran_detect_homepage_section_from_post($parsed_data, $current_tab);
    }
    
    // If we found a section to reset
    if (!empty($reset_section) && isset($section_to_field[$reset_section])) {
        $field_id = $section_to_field[$reset_section];
        $defaults = alomran_get_tech_repeater_defaults();
        
        // Get current options DIRECTLY from database
        global $wpdb;
        $options_raw = $wpdb->get_var("SELECT option_value FROM {$wpdb->options} WHERE option_name = 'alomran_options'");
        $current_options = maybe_unserialize($options_raw);
        if (!is_array($current_options)) {
            $current_options = array();
        }
        
        // FORCE DELETE - set to empty array or defaults
        // IMPORTANT: Always use defaults if available, regardless of current value
        if (isset($defaults[$field_id]) && !empty($defaults[$field_id])) {
            // Ensure defaults are in correct format (array of arrays for repeater)
            $default_value = $defaults[$field_id];
            if (is_array($default_value) && !empty($default_value)) {
                $current_options[$field_id] = $default_value;
            } else {
                $current_options[$field_id] = array();
            }
        } else {
            $current_options[$field_id] = array();
        }
        
        // CRITICAL: Remove data from POST to prevent Redux from saving it again
        alomran_remove_field_from_post($field_id);
        
        // Update DIRECTLY in database (bypass all hooks)
        $wpdb->update(
            $wpdb->options,
            array('option_value' => maybe_serialize($current_options)),
            array('option_name' => 'alomran_options'),
            array('%s'),
            array('%s')
        );
        
        // Clear ALL caches
        alomran_clear_redux_caches();
        
        // Clear cookie
        alomran_clear_reset_section_cookie();
    }
}
add_action('admin_init', 'alomran_ultra_fast_reset_repeater', 1);

/**
 * Ensure repeater defaults are restored after section reset or reset all
 * This hook runs after option is updated in database
 * IMPORTANT: Use a flag to prevent infinite loops
 * Only process on section reset operations or reset all, not normal saves
 */
function alomran_ensure_repeater_defaults_restored_after_section_reset($old_value, $value) {
    // Prevent infinite loop
    static $restoring = false;
    if ($restoring) {
        return;
    }
    
    // Only run for alomran_options
    if (!is_array($value)) {
        return;
    }
    
    $reset_info = alomran_detect_reset_operation();
    
    // Only process on section reset or reset all, not on normal save
    if (!$reset_info['is_section_reset'] && !$reset_info['is_reset_all']) {
        return;
    }
    
    // Get unified section configuration
    $section_to_field = alomran_get_tech_section_to_field_map();
    
    // Get default values
    $defaults = alomran_get_tech_repeater_defaults();
    
    // Process section reset - ensure defaults are restored
    // Each section is handled separately
    if ($reset_info['is_section_reset'] && !empty($reset_info['reset_section']) && isset($section_to_field[$reset_info['reset_section']])) {
        $field_id = $section_to_field[$reset_info['reset_section']];
        
        $restoring = true;
        
        // Always set to empty array (don't check - just do it)
        // Restore default values if available, otherwise set to empty array
        if (isset($defaults[$field_id]) && !empty($defaults[$field_id])) {
            $value[$field_id] = $defaults[$field_id];
        } else {
            $value[$field_id] = array();
        }
        
        // Use update_option with autoload=false to prevent triggering hooks
        update_option('alomran_options', $value, false);
        
        // Clear Redux cache
        alomran_clear_redux_caches();
        
        // Clear cookie after use
        alomran_clear_reset_section_cookie();
        
        $restoring = false;
    }
    
    // Process reset all - ensure defaults are restored for all fields
    if ($reset_info['is_reset_all']) {
        $all_repeater_fields = array_values($section_to_field);
        $needs_update = false;
        
        foreach ($all_repeater_fields as $field_id) {
            // Check if field needs default values restored
            if (isset($defaults[$field_id])) {
                // Field has defaults - check if current value matches defaults
                if (!isset($value[$field_id]) || $value[$field_id] !== $defaults[$field_id]) {
                    $value[$field_id] = $defaults[$field_id];
                    $needs_update = true;
                }
            } else {
                // Field has no defaults - ensure it's empty array
                if (isset($value[$field_id]) && !empty($value[$field_id])) {
                    $value[$field_id] = array();
                    $needs_update = true;
                }
            }
        }
        
        // Update options if any fields were restored
        if ($needs_update) {
            $restoring = true;
            
            // Use update_option with autoload=false to prevent triggering hooks
            update_option('alomran_options', $value, false);
            
            // Clear Redux cache
            alomran_clear_redux_caches();
            
            $restoring = false;
        }
    }
}
add_action('update_option_alomran_options', 'alomran_ensure_repeater_defaults_restored_after_section_reset', 10, 2);

