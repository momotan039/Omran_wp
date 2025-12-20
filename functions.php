<?php
/**
 * Bootstrap theme includes.
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

define('ALOMRAN_THEME_VERSION', wp_get_theme()->get('Version'));
define('ALOMRAN_THEME_DIR', get_template_directory());
define('ALOMRAN_THEME_URI', get_template_directory_uri());

// Load Core System First (before everything else)
require_once ALOMRAN_THEME_DIR . '/core/core-loader.php';

$alomran_includes = array(
    // Core Setup
    'inc/setup.php',
    'inc/redux-blocker.php',    // ULTIMATE Redux blocker - MUST load first
    'inc/assets.php',
    'inc/menu-walker.php',
    'inc/translation.php',      // Translation & Multi-language support
    
    // Helpers (modular)
    'inc/helpers/helpers-company.php',
    'inc/helpers/helpers-content.php',
    'inc/helpers/helpers-products.php',
    'inc/helpers/helpers-url.php',
    'inc/helpers/helpers-archive.php',
    'inc/helpers/helpers-contact.php',
    'inc/helpers/helpers-ads.php',
    'inc/helpers/helpers-presets.php',
    'inc/helpers/helpers-content-display.php',
    'inc/helpers/helpers-taxonomies.php',  // Taxonomy helper functions
    'inc/helpers/helpers-food.php',        // Food preset helper functions
    
    // Custom Post Types & Taxonomies
    'inc/cpt-common.php',  // Common CPTs (shared across all presets)
    'inc/acf.php',
    'inc/acf-food.php',    // ACF fields for Food preset
    
    // Media Management
    'inc/product-media.php',
    'inc/news-media.php',
    
    // Contact & AJAX
    'inc/contact-messages.php',
    'inc/ajax.php',
    
    // Food Preset Admin (only loads in admin)
    'presets/food/admin/reservations-admin.php',
    
    // SEO
    'inc/seo/seo-helpers.php',      // Helper functions (load first)
    'inc/seo/seo-core.php',
    'inc/seo/seo-schema.php',
    'inc/seo/seo-sitemap.php',
    'inc/seo/seo-images.php',
    'inc/seo/seo-accessibility.php',
    'inc/seo/seo-enhancements.php',
    
    // Redux - Load helpers first, then config (which has early exit for frontend)
    'inc/redux/redux-helpers-core.php',  // Core helper functions
    'inc/redux/redux-helpers.php',       // Additional helpers
    'inc/redux/redux-config.php',        // This file now exits early on frontend
    
    // Demo Import & Setup Wizard
    'inc/demo-import/demo-data.php',
    'inc/demo-import/setup-wizard.php',
    'inc/demo-import/admin-ui.php',
    
    // Preset Content Isolation
    'inc/preset-content-isolation.php',
    
    // Widgets
    'inc/widgets/ads-widget.php',
    'inc/widgets/hero-widget.php',
    'inc/widgets/spec-table-widget.php',
    'inc/widgets/download-box-widget.php',
    'inc/widgets/gallery-widget.php',
    'inc/widgets/testimonials-widget.php',
    'inc/widgets/projects-slider-widget.php',
    'inc/widgets/clients-grid-widget.php',
);

foreach ($alomran_includes as $file) {
    $filepath = ALOMRAN_THEME_DIR . '/' . $file;
    if (file_exists($filepath)) {
        // Only load admin files in admin area
        if (strpos($file, '/admin/') !== false && !is_admin()) {
            continue;
        }
        require_once $filepath;
    }
}

