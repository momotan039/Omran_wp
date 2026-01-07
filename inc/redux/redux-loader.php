<?php
/**
 * Redux Module Loader
 * Centralized loader for all Redux modules with dependency management
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load Redux modules in correct order
 * Ensures dependencies are loaded before modules that need them
 */
function alomran_load_redux_modules() {
    $redux_dir = ALOMRAN_THEME_DIR . '/inc/redux/';
    
    // Define modules with their dependencies
    $modules = array(
        // Group 1: Configuration & Defaults (no dependencies)
        array(
            'file' => 'redux-section-config.php',
            'group' => 1,
            'description' => 'Section configuration - single source of truth',
        ),
        array(
            'file' => 'redux-repeater-defaults.php',
            'group' => 1,
            'description' => 'Repeater default values',
        ),
        
        // Group 2: Helper functions (depend on config)
        array(
            'file' => 'redux-reset-helpers.php',
            'group' => 2,
            'description' => 'Reset operation helper functions',
        ),
        
        // Group 3: Handlers (depend on helpers and config)
        array(
            'file' => 'redux-reset-handlers.php',
            'group' => 3,
            'description' => 'Reset operation handlers',
        ),
        array(
            'file' => 'redux-preset-preservation.php',
            'group' => 3,
            'description' => 'Preset preservation handlers',
        ),
        array(
            'file' => 'redux-value-preservation.php',
            'group' => 3,
            'description' => 'Value preservation handlers',
        ),
        
        // Group 4: Translations & UI (can load independently)
        array(
            'file' => 'redux-translations.php',
            'group' => 4,
            'description' => 'Arabic translations and JS handlers',
        ),
        
        // Group 5: Frontend protection (must load last)
        array(
            'file' => 'redux-frontend-protection.php',
            'group' => 5,
            'description' => 'Frontend protection - blocks Redux on client pages',
        ),
    );
    
    // Load modules by group
    $loaded_groups = array();
    foreach ($modules as $module) {
        $group = $module['group'];
        
        // Only load if group hasn't been loaded yet (for safety)
        if (!in_array($group, $loaded_groups)) {
            $loaded_groups[] = $group;
        }
        
        $file_path = $redux_dir . $module['file'];
        if (file_exists($file_path)) {
            require_once $file_path;
        }
    }
}

