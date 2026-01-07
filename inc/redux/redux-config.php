<?php
/**
 * Redux Framework Configuration
 * Main configuration file - loads all Redux modules
 * 
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

// CRITICAL: Prevent Redux from loading on frontend
// Only allow Redux in admin panel - this is the FIRST check
$is_admin_page = is_admin() || 
                 (defined('WP_ADMIN') && WP_ADMIN) ||
                 (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/wp-admin/') !== false) ||
                 (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/wp-login.php') !== false) ||
                 (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'admin-ajax.php') !== false && isset($_GET['action']) && strpos($_GET['action'], 'redux') !== false);

if (!$is_admin_page) {
    return; // Don't even check for Redux on frontend - exit immediately
}

// Check if Redux Framework is installed
if (!class_exists('ReduxFramework') && !class_exists('Redux')) {
    return;
}

// Load Redux modules using centralized loader
require_once ALOMRAN_THEME_DIR . '/inc/redux/redux-loader.php';
alomran_load_redux_modules();

/**
 * Initialize Redux Framework
 * IMPORTANT: Only initialize in admin - prevent frontend loading
 */
function alomran_redux_init() {
    // CRITICAL: Only initialize Redux in admin - NEVER on frontend
    if (!is_admin()) {
        return;
    }
    
    // Double check Redux is available
    if (!class_exists('Redux')) {
        return;
    }
    
    $opt_name = 'alomran_options';
    
    $args = array(
        'opt_name'                  => $opt_name,
        'display_name'              => 'إعدادات الموقع',
        'display_version'           => ALOMRAN_THEME_VERSION,
        'menu_type'                 => 'menu',
        'allow_sub_menu'            => true,
        'menu_title'                => 'إعدادات الموقع',
        'page_title'                => 'إعدادات الموقع',
        'admin_bar_priority'        => 50,
        'page_priority'             => 50,
        'page_slug'                 => 'alomran-options',
        'page_permissions'          => 'manage_options',
        'menu_icon'                 => 'dashicons-admin-settings',
        'last_tab'                  => '',
        'page_icon'                 => 'icon-themes',
        'save_defaults'             => true,
        'default_show'              => false,
        'default_mark'              => '',
        'show_import_export'        => true,
        'transient_time'            => 60 * MINUTE_IN_SECONDS,
        'output'                    => false,  // Disable frontend CSS output
        'output_tag'                => false,  // Disable frontend CSS output
        'database'                  => '',
        'use_cdn'                   => true,
        'dev_mode'                  => false,
        'system_info'               => false,
    );
    
    // Add Arabic translations for Redux interface strings
    add_filter('redux/options/' . $opt_name . '/localize', 'alomran_redux_arabic_translations', 10, 1);

    try {
        if (class_exists('Redux')) {
            call_user_func(array('Redux', 'setArgs'), $opt_name, $args);
        }
    } catch (Exception $e) {
        // Redux not ready yet, try again later
        add_action('admin_init', 'alomran_redux_init', 1);
        return;
    }

    // Load Redux sections directly (no preset system)
    $sections_dir = ALOMRAN_THEME_DIR . '/inc/redux/sections/';
    $redux_sections_file = ALOMRAN_THEME_DIR . '/inc/redux/redux-sections.php';
    
    $section_files = array();
    
    // Load theme sections
    if (file_exists($redux_sections_file)) {
        $section_files = require $redux_sections_file;
        if (!is_array($section_files)) {
            $section_files = array();
        }
    }

    // Load sections
    foreach ($section_files as $file) {
        $file_path = $sections_dir . $file;
        if (file_exists($file_path)) {
            require_once $file_path;
        }
    }
}
add_action('redux/loaded', 'alomran_redux_init');

