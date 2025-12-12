<?php
/**
 * Redux Framework Configuration
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

// CRITICAL: Prevent Redux from loading on frontend
// Only allow Redux in admin panel - this is the FIRST check
// Check multiple ways to detect admin
$is_admin_page = is_admin() || 
                 (defined('WP_ADMIN') && WP_ADMIN) ||
                 (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/wp-admin/') !== false) ||
                 (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/wp-login.php') !== false) ||
                 (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'admin-ajax.php') !== false && isset($_GET['action']) && strpos($_GET['action'], 'redux') !== false);

if (!$is_admin_page) {
    return; // Don't even check for Redux on frontend - exit immediately
}

// Check if Redux Framework is installed
// Try both class names for compatibility
if (!class_exists('ReduxFramework') && !class_exists('Redux')) {
    return;
}

/**
 * Initialize Redux Framework
 * IMPORTANT: Only initialize in admin - prevent frontend loading
 * 
 * @package AlOmran_Core
 */
function omran_core_redux_init() {
    // CRITICAL: Only initialize Redux in admin - NEVER on frontend
    // This prevents Redux from loading any CSS/JS on client pages
    if (!is_admin()) {
        return; // Prevent Redux from initializing on frontend completely
    }
    
    // Double check Redux is available
    if (!class_exists('Redux')) {
        return;
    }
    
    $opt_name = 'alomran_options';
    
    $args = array(
        'opt_name'                  => $opt_name,
        'display_name'              => 'إعدادات الموقع',
        'display_version'           => defined('ALOMRAN_THEME_VERSION') ? ALOMRAN_THEME_VERSION : OMRAN_CORE_VERSION,
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

    try {
        if (class_exists('Redux')) {
            call_user_func(array('Redux', 'setArgs'), $opt_name, $args);
        }
    } catch (Exception $e) {
        // Redux not ready yet, try again later
        add_action('admin_init', 'alomran_redux_init', 1);
        return;
    }

    $sections_dir = OMRAN_CORE_DIR . '/redux/sections/';
    $section_files = array(
        'header-logo.php',   // Header logo settings
        'homepage.php',      // Main section for homepage
        'hero.php',
        'risks.php',
        'sectors.php',
        'products.php',
        'stainless.php',
        'testimonials.php',
        'sections-order.php',
        'company.php',       // Main section for company page
        'about-page.php',    // Main section for about page
        'about-header.php',
        'about-content.php',
        'about-vision-mission.php',
        'about-stats.php',
        'about-order.php',
        'general.php',
        'contact-page.php',
        'footer.php',
        'ads.php',              // Ads / Monetization system
        'theme-presets.php',    // Theme presets / Layout selector (legacy)
        'theme-style.php',     // Theme Style panel with dynamic switching
        'content-display.php',  // Content display flexibility
    );

    foreach ($section_files as $file) {
        $file_path = $sections_dir . $file;
        if (file_exists($file_path)) {
            require_once $file_path;
        }
    }
}
add_action('redux/loaded', 'omran_core_redux_init');

// Backward compatibility
if (!function_exists('alomran_redux_init')) {
    function alomran_redux_init() {
        omran_core_redux_init();
    }
}

/**
 * ULTRA-AGGRESSIVE frontend protection: Block Redux completely on frontend
 * This ensures Redux NEVER loads on client pages, only in admin
 */
if (!is_admin()) {
    // Block ALL Redux filters at the earliest possible moment
    add_filter('redux/options/alomran_options/output', '__return_false', 1);
    add_filter('redux/options/alomran_options/output_tag', '__return_false', 1);
    add_filter('redux/options/alomran_options/compiler', '__return_false', 1);
    add_filter('redux/options/alomran_options/enqueue', '__return_false', 1);
    add_filter('redux/enqueue', '__return_false', 1);
    add_filter('redux/register', '__return_false', 1);
    add_filter('redux/output', '__return_false', 1);
    add_filter('redux/output_tag', '__return_false', 1);
    add_filter('redux/compiler', '__return_false', 1);
    add_filter('redux/output/enable', '__return_false', 1);
    
    // Also block at maximum priority as backup
    add_filter('redux/options/alomran_options/output', '__return_false', 99999);
    add_filter('redux/options/alomran_options/output_tag', '__return_false', 99999);
    add_filter('redux/options/alomran_options/compiler', '__return_false', 99999);
    add_filter('redux/options/alomran_options/enqueue', '__return_false', 99999);
    add_filter('redux/enqueue', '__return_false', 99999);
    add_filter('redux/output/enable', '__return_false', 99999);
    
    // Prevent Redux from hooking into frontend at multiple priorities
    $priorities = array(1, 10, 50, 100, 999, 9999);
    foreach ($priorities as $priority) {
        add_action('init', function() use ($priority) {
            remove_action('wp_head', 'redux_output_css', $priority);
            remove_action('wp_footer', 'redux_output_css', $priority);
            remove_action('wp_enqueue_scripts', 'redux_output_css', $priority);
            remove_action('wp_enqueue_scripts', 'redux_enqueue', $priority);
        }, 1);
    }
}

