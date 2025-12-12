<?php
/**
 * Bootstrap theme includes.
 * 
 * This file now loads the Core Theme Layer from /core directory.
 * All shared logic, CPTs, taxonomies, helpers, ACF, and Redux are loaded from core.
 * 
 * @package AlOmran
 * @version 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants (for backward compatibility)
define('ALOMRAN_THEME_VERSION', wp_get_theme()->get('Version'));
define('ALOMRAN_THEME_DIR', get_template_directory());
define('ALOMRAN_THEME_URI', get_template_directory_uri());

// Load Core Theme Layer
$core_loader = ALOMRAN_THEME_DIR . '/core/core-loader.php';
if (file_exists($core_loader)) {
    require_once $core_loader;
}

// Load compatibility layer (maps old function names to new core functions)
$compatibility = ALOMRAN_THEME_DIR . '/core/functions/compatibility.php';
if (file_exists($compatibility)) {
    require_once $compatibility;
}

// Load legacy files for backward compatibility (if they exist)
// These will be gradually phased out as templates are updated
// Note: menu-walker.php and translation.php are now loaded from core
$legacy_includes = array(
    'inc/redux-blocker.php',    // ULTIMATE Redux blocker - MUST load first
    'inc/assets.php',
    // 'inc/menu-walker.php',   // Now loaded from core/functions/menu-walker.php
    // 'inc/translation.php',   // Now loaded from core/functions/translation.php
);

foreach ($legacy_includes as $file) {
    $filepath = ALOMRAN_THEME_DIR . '/' . $file;
    if (file_exists($filepath)) {
        require_once $filepath;
    }
}

