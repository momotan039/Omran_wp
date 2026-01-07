<?php
/**
 * Common Template Helpers
 * DRY: Reusable helper functions for page templates
 *
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load common template components
 * DRY: Single function to load all common components
 * 
 * @return bool True if components loaded, false otherwise
 */
function omran_load_common_components() {
    $preset_dir = AlOmran_Preset_Loader::get_preset_dir('industrial');
    
    if (!$preset_dir) {
        return false;
    }
    
    $components_dir = $preset_dir . '/template-parts/common/';
    
    // Load components if they exist
    $components = array(
        'page-header.php',
        'page-content.php',
        'archive-header.php',
        'archive-loop.php',
        'single-header.php',
        'single-content.php',
        'section-loader.php', // Section loading helper
    );
    
    foreach ($components as $component) {
        $file = $components_dir . $component;
        if (file_exists($file)) {
            require_once $file;
        }
    }
    
    return true;
}

