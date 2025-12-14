<?php
/**
 * Core System Loader
 * 
 * Initializes all core systems
 * 
 * @package AlOmran
 * @subpackage Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load core classes
require_once ALOMRAN_THEME_DIR . '/core/classes/class-preset-loader.php';
require_once ALOMRAN_THEME_DIR . '/core/classes/class-redux-loader.php';
require_once ALOMRAN_THEME_DIR . '/core/classes/class-section-loader.php';
require_once ALOMRAN_THEME_DIR . '/core/classes/class-demo-importer.php';
require_once ALOMRAN_THEME_DIR . '/core/classes/class-admin-notices.php';

/**
 * Initialize core systems
 */
function alomran_core_init() {
    // Initialize preset loader
    AlOmran_Preset_Loader::init();
    
    // Initialize Redux loader (admin only)
    AlOmran_Redux_Loader::init();
    
    // Initialize section loader
    AlOmran_Section_Loader::init();
    
    // Initialize demo importer
    AlOmran_Demo_Importer::init();
    
    // Initialize admin notices
    AlOmran_Admin_Notices::init();
}
add_action('after_setup_theme', 'alomran_core_init', 1);

