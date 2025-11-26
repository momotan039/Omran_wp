<?php
/**
 * Redux Framework Configuration
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

// Check if Redux Framework is installed
if (!class_exists('ReduxFramework')) {
    return;
}

/**
 * Initialize Redux Framework
 */
function alomran_redux_init() {
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
        'menu_icon'                 => '',
        'last_tab'                  => '',
        'page_icon'                 => 'icon-themes',
        'save_defaults'             => true,
        'default_show'              => false,
        'default_mark'              => '',
        'show_import_export'        => true,
        'transient_time'            => 60 * MINUTE_IN_SECONDS,
        'output'                    => false,
        'output_tag'                => false,
        'database'                  => '',
        'use_cdn'                   => true,
        'dev_mode'                  => false,
        'system_info'               => false,
    );

    Redux::setArgs($opt_name, $args);

    $sections_dir = ALOMRAN_THEME_DIR . '/inc/redux/sections/';
    $section_files = array(
        'general.php',
        'hero.php',
        'risks.php',
        'sectors.php',
        'products.php',
        'stainless.php',
        'testimonials.php',
        'sections-order.php',
    );

    foreach ($section_files as $file) {
        $file_path = $sections_dir . $file;
        if (file_exists($file_path)) {
            require_once $file_path;
        }
    }
}
add_action('redux/loaded', 'alomran_redux_init');

