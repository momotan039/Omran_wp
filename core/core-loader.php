<?php
/**
 * Core Theme Layer Loader
 * 
 * This file bootstraps the core theme functionality, independent of design/layout.
 * All shared logic, CPTs, taxonomies, helpers, ACF, and Redux skeleton are loaded here.
 * 
 * @package AlOmran_Core
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define core constants
if (!defined('OMRAN_CORE_VERSION')) {
    define('OMRAN_CORE_VERSION', '1.0.0');
}
if (!defined('OMRAN_CORE_DIR')) {
    define('OMRAN_CORE_DIR', get_template_directory() . '/core');
}
if (!defined('OMRAN_CORE_URI')) {
    define('OMRAN_CORE_URI', get_template_directory_uri() . '/core');
}

/**
 * Core includes - Load all shared functionality
 */
$omran_core_includes = array(
    // Core setup and configuration
    'functions/core-setup.php',
    'functions/core-constants.php',
    
    // Compatibility layer (load early for backward compatibility)
    'functions/compatibility.php',
    
    // Hooks and filters system
    'hooks/hooks-core.php',
    'hooks/hooks-sections.php',
    'hooks/hooks-template-parts.php',
    
    // Post Types
    'post-types/post-types.php',
    
    // Taxonomies
    'taxonomies/taxonomies.php',
    
    // ACF Field Groups
    'acf/acf-fields.php',
    
    // Helper Functions (modular)
    'functions/helpers/helpers-company.php',
    'functions/helpers/helpers-content.php',
    'functions/helpers/helpers-products.php',
    'functions/helpers/helpers-url.php',
    'functions/helpers/helpers-archive.php',
    'functions/helpers/helpers-contact.php',
    'functions/helpers/helpers-ads.php',
    'functions/helpers/helpers-presets.php',
    'functions/helpers/helpers-content-display.php',
    
    // Media Management
    'functions/media-product.php',
    'functions/media-news.php',
    
    // Contact & AJAX
    'functions/contact-messages.php',
    'functions/ajax-handlers.php',
    
    // SEO
    'seo/seo-core.php',
    'seo/seo-schema.php',
    'seo/seo-sitemap.php',
    
    // Redux Framework (admin only)
    'redux/redux-helpers.php',
    'redux/redux-config.php',
    
    // Widgets
    'widgets/widgets-loader.php',
    
    // Demo Import & Setup Wizard
    'functions/demo-import/demo-data.php',
    'functions/demo-import/setup-wizard.php',
    
    // Additional core files
    'functions/menu-walker.php',
    'functions/translation.php',
    
    // Assets loader (loads CSS and JS)
    'functions/assets-loader.php',
    
    // Preset system loader
    'functions/preset-loader.php',
    
    // Preset switcher (AJAX handlers and dynamic updates)
    'functions/preset-switcher.php',
    
    // Template parts loader (preset layout support)
    'functions/template-parts-loader.php',
);

foreach ($omran_core_includes as $file) {
    $filepath = OMRAN_CORE_DIR . '/' . $file;
    if (file_exists($filepath)) {
        require_once $filepath;
    }
}

/**
 * Initialize core theme layer
 * 
 * @hook omran_core_init
 */
function omran_core_init() {
    /**
     * Fires when the core theme layer is initialized.
     * 
     * @since 1.0.0
     */
    do_action('omran_core_init');
}
add_action('after_setup_theme', 'omran_core_init', 5);

