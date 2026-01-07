<?php
/**
 * Redux Preset Preservation
 * Preserves theme_preset when resetting all options
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Preserve theme_preset when resetting all options
 * This ensures the active preset doesn't change when user clicks "Reset All"
 * BUT allows user to change it normally
 */
function alomran_preserve_theme_preset_on_reset($options) {
    // Check if $options is an array (not Redux_Panel object)
    if (!is_array($options)) {
        return $options;
    }
    
    // Only preserve if this is a reset operation, not a normal save
    $is_reset = false;
    
    // Check if this is a reset operation
    if (isset($_POST['redux-reset']) || 
        (isset($_GET['reset']) && $_GET['reset'] === 'all') ||
        (isset($_REQUEST['redux-reset']) && $_REQUEST['redux-reset'] === 'all')) {
        $is_reset = true;
    }
    
    // Only preserve on reset, not on normal save
    if ($is_reset) {
        $current_options = get_option('alomran_options', array());
        if (isset($current_options['theme_preset']) && in_array($current_options['theme_preset'], array('industrial', 'food', 'tech'), true)) {
            $options['theme_preset'] = $current_options['theme_preset'];
        }
    }
    
    return $options;
}
add_filter('redux/options/alomran_options/validate', 'alomran_preserve_theme_preset_on_reset', 1, 1);

/**
 * Restore theme_preset after reset if it was changed
 * This hook runs after option is updated in database
 * IMPORTANT: Use a flag to prevent infinite loops
 * Only restore on reset operations, not normal saves
 */
function alomran_restore_theme_preset_after_reset($old_value, $value) {
    // Prevent infinite loop
    static $restoring = false;
    if ($restoring) {
        return;
    }
    
    // Only run for alomran_options
    if (!is_array($value)) {
        return;
    }
    
    // Check if this is a reset operation
    $is_reset = false;
    if (isset($_POST['redux-reset']) || 
        (isset($_GET['reset']) && $_GET['reset'] === 'all') ||
        (isset($_REQUEST['redux-reset']) && $_REQUEST['redux-reset'] === 'all')) {
        $is_reset = true;
    }
    
    // Only restore on reset, not on normal save
    if (!$is_reset) {
        return;
    }
    
    // Get the preset that was saved before this update
    $preset_backup = get_transient('alomran_preset_backup');
    
    // Check if we need to restore
    $needs_restore = false;
    $restore_value = null;
    
    if ($preset_backup && in_array($preset_backup, array('industrial', 'food', 'tech'), true)) {
        if (!isset($value['theme_preset']) || $value['theme_preset'] !== $preset_backup) {
            $needs_restore = true;
            $restore_value = $preset_backup;
        }
    } elseif (isset($old_value['theme_preset']) && in_array($old_value['theme_preset'], array('industrial', 'food', 'tech'), true)) {
        if (!isset($value['theme_preset']) || $value['theme_preset'] !== $old_value['theme_preset']) {
            $needs_restore = true;
            $restore_value = $old_value['theme_preset'];
        }
    }
    
    // Restore if needed
    if ($needs_restore && $restore_value) {
        $restoring = true;
        $value['theme_preset'] = $restore_value;
        
        // Use update_option with autoload=false to prevent triggering hooks
        update_option('alomran_options', $value, false);
        
        // Clear Redux cache
        delete_transient('redux-alomran_options');
        
        // Clear backup after use
        if ($preset_backup) {
            delete_transient('alomran_preset_backup');
        }
        
        $restoring = false;
    }
}
add_action('update_option_alomran_options', 'alomran_restore_theme_preset_after_reset', 10, 2);

