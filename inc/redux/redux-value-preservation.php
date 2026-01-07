<?php
/**
 * Redux Value Preservation
 * Preserves Redux field values when sections are disabled
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Preserve Redux field values when sections are disabled
 * This prevents Redux from deleting values when required fields become hidden
 */
function alomran_preserve_redux_values($options, $changed_values) {
    $opt_name = 'alomran_options';
    $current_options = get_option($opt_name, array());
    
    // Get critical fields from helper
    $preserve_fields = alomran_get_critical_redux_fields();
    
    // Preserve existing values if they exist and are not empty
    foreach ($preserve_fields as $field) {
        if (isset($current_options[$field]) && !empty($current_options[$field])) {
            // Only preserve if the new value is empty or doesn't exist
            if (!isset($options[$field]) || empty($options[$field])) {
                $options[$field] = $current_options[$field];
            }
        }
    }
    
    return $options;
}
add_filter('redux/options/alomran_options/validate', 'alomran_preserve_redux_values', 10, 2);

/**
 * Restore deleted values after Redux save
 * This ensures values are not permanently lost when sections are disabled
 * IMPORTANT: Use a flag to prevent infinite loops
 */
function alomran_restore_redux_values_after_save() {
    static $restoring = false;
    if ($restoring) {
        return;
    }
    
    $opt_name = 'alomran_options';
    $current_options = get_option($opt_name, array());
    
    // Backup of values before save (stored in transient)
    $backup = get_transient('alomran_redux_backup');
    
    if ($backup && is_array($backup)) {
        $needs_update = false;
        
        // Get critical fields from helper
        $preserve_fields = alomran_get_critical_redux_fields();
        
        // Restore values that were deleted
        foreach ($preserve_fields as $field) {
            // If backup has value but current doesn't, restore it
            if (isset($backup[$field]) && !empty($backup[$field])) {
                if (!isset($current_options[$field]) || empty($current_options[$field])) {
                    $current_options[$field] = $backup[$field];
                    $needs_update = true;
                }
            }
        }
        
        // Update options if needed
        if ($needs_update) {
            $restoring = true;
            update_option($opt_name, $current_options, false);
            // Clear Redux cache
            delete_transient('redux-' . $opt_name);
            $restoring = false;
        }
        
        // Clear backup after use
        delete_transient('alomran_redux_backup');
    }
}
add_action('redux/options/alomran_options/saved', 'alomran_restore_redux_values_after_save', 20);

/**
 * Create backup before Redux save
 */
function alomran_backup_redux_values_before_save() {
    $opt_name = 'alomran_options';
    $current_options = get_option($opt_name, array());
    
    // Create backup (store for 1 hour)
    set_transient('alomran_redux_backup', $current_options, HOUR_IN_SECONDS);
    
    // Always preserve theme_preset value before any save/reset operation
    if (isset($current_options['theme_preset']) && !empty($current_options['theme_preset'])) {
        set_transient('alomran_preset_backup', $current_options['theme_preset'], HOUR_IN_SECONDS);
    } else {
        // If no preset is set, try to get it from active preset
        if (class_exists('AlOmran_Preset_Loader')) {
            $active_preset = AlOmran_Preset_Loader::get_active_preset();
            if (in_array($active_preset, array('industrial', 'food', 'tech'), true)) {
                set_transient('alomran_preset_backup', $active_preset, HOUR_IN_SECONDS);
            }
        }
    }
}
add_action('redux/options/alomran_options/before_save', 'alomran_backup_redux_values_before_save', 10);

