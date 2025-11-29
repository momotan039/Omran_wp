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

$alomran_includes = array(
    // Core Setup
    'inc/setup.php',
    'inc/assets.php',
    'inc/menu-walker.php',
    
    // Helpers (modular)
    'inc/helpers/helpers-company.php',
    'inc/helpers/helpers-content.php',
    'inc/helpers/helpers-products.php',
    'inc/helpers/helpers-url.php',
    'inc/helpers/helpers-archive.php',
    'inc/helpers/helpers-contact.php',
    
    // Custom Post Types & Taxonomies
    'inc/cpt.php',
    'inc/taxonomies.php',
    'inc/acf.php',
    
    // Media Management
    'inc/product-media.php',
    'inc/news-media.php',
    
    // Contact & AJAX
    'inc/contact-messages.php',
    'inc/ajax.php',
    
    // SEO
    'inc/seo/seo-core.php',
    'inc/seo/seo-schema.php',
    'inc/seo/seo-sitemap.php',
    
    // Redux
    'inc/redux/redux-helpers.php',
    'inc/redux/redux-config.php',
);

foreach ($alomran_includes as $file) {
    $filepath = ALOMRAN_THEME_DIR . '/' . $file;
    if (file_exists($filepath)) {
        require_once $filepath;
    }
}

