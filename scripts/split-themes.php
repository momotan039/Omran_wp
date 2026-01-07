<?php
/**
 * Theme Splitter Script
 * 
 * This script splits the current multi-preset theme into 3 separate WordPress themes
 * 
 * Usage: php scripts/split-themes.php
 * 
 * @package AlOmran
 */

// Prevent direct access
if (php_sapi_name() !== 'cli') {
    die('This script can only be run from command line.');
}

// Set base paths
$source_theme_dir = dirname(__DIR__);
$target_base_dir = dirname($source_theme_dir);
$themes = array('industrial', 'food', 'tech');

// Colors for output
$colors = array(
    'reset' => "\033[0m",
    'green' => "\033[32m",
    'yellow' => "\033[33m",
    'red' => "\033[31m",
    'blue' => "\033[34m",
);

function log_message($message, $color = 'reset') {
    global $colors;
    echo $colors[$color] . $message . $colors['reset'] . "\n";
}

function copy_directory($source, $dest, $exclude = array()) {
    if (!is_dir($source)) {
        return false;
    }
    
    if (!is_dir($dest)) {
        mkdir($dest, 0755, true);
    }
    
    $files = scandir($source);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        
        if (in_array($file, $exclude)) {
            continue;
        }
        
        $source_path = $source . '/' . $file;
        $dest_path = $dest . '/' . $file;
        
        if (is_dir($source_path)) {
            copy_directory($source_path, $dest_path, $exclude);
        } else {
            copy($source_path, $dest_path);
        }
    }
    
    return true;
}

function create_theme_structure($theme_name, $source_dir, $target_dir) {
    log_message("Creating theme structure for: $theme_name", 'blue');
    
    // Create theme directory
    $theme_dir = $target_dir . '/alomran-' . $theme_name;
    if (!is_dir($theme_dir)) {
        mkdir($theme_dir, 0755, true);
    }
    
    // Copy core files
    $core_files = array('index.php', '404.php', 'header.php', 'footer.php', 'style.css');
    foreach ($core_files as $file) {
        if (file_exists($source_dir . '/' . $file)) {
            copy($source_dir . '/' . $file, $theme_dir . '/' . $file);
            log_message("  ✓ Copied $file", 'green');
        }
    }
    
    // Copy shared directories
    $shared_dirs = array(
        'inc/helpers',
        'inc/seo',
        'inc/widgets',
        'assets/js/modules',
    );
    
    foreach ($shared_dirs as $dir) {
        $source_path = $source_dir . '/' . $dir;
        $dest_path = $theme_dir . '/' . $dir;
        if (is_dir($source_path)) {
            copy_directory($source_path, $dest_path);
            log_message("  ✓ Copied $dir", 'green');
        }
    }
    
    // Copy shared files
    $shared_files = array(
        'inc/setup.php',
        'inc/assets.php',
        'inc/translation.php',
        'inc/menu-walker.php',
        'inc/redux-blocker.php',
        'inc/cpt-common.php',
        'assets/css/custom.css',
        'assets/css/loader.css',
        'assets/js/main.js',
    );
    
    foreach ($shared_files as $file) {
        $source_path = $source_dir . '/' . $file;
        $dest_path = $theme_dir . '/' . $file;
        if (file_exists($source_path)) {
            $dest_dir = dirname($dest_path);
            if (!is_dir($dest_dir)) {
                mkdir($dest_dir, 0755, true);
            }
            copy($source_path, $dest_path);
            log_message("  ✓ Copied $file", 'green');
        }
    }
    
    // Copy preset-specific files
    $preset_dir = $source_dir . '/presets/' . $theme_name;
    if (is_dir($preset_dir)) {
        // Copy templates
        if (is_dir($preset_dir . '/templates')) {
            $template_files = glob($preset_dir . '/templates/*.php');
            foreach ($template_files as $template) {
                $filename = basename($template);
                copy($template, $theme_dir . '/' . $filename);
                log_message("  ✓ Copied template: $filename", 'green');
            }
        }
        
        // Copy template-parts
        if (is_dir($preset_dir . '/template-parts')) {
            copy_directory($preset_dir . '/template-parts', $theme_dir . '/template-parts');
            log_message("  ✓ Copied template-parts", 'green');
        }
        
        // Copy preset assets
        if (is_dir($preset_dir . '/assets')) {
            copy_directory($preset_dir . '/assets', $theme_dir . '/assets/preset');
            log_message("  ✓ Copied preset assets", 'green');
        }
        
        // Copy preset-specific inc files
        if (file_exists($preset_dir . '/cpt.php')) {
            copy($preset_dir . '/cpt.php', $theme_dir . '/inc/cpt.php');
            log_message("  ✓ Copied cpt.php", 'green');
        }
        
        if (file_exists($preset_dir . '/taxonomies.php')) {
            copy($preset_dir . '/taxonomies.php', $theme_dir . '/inc/taxonomies.php');
            log_message("  ✓ Copied taxonomies.php", 'green');
        }
        
        // Copy demo content
        if (is_dir($preset_dir . '/demo')) {
            copy_directory($preset_dir . '/demo', $theme_dir . '/demo');
            log_message("  ✓ Copied demo content", 'green');
        }
        
        // Copy admin files (for food preset)
        if (is_dir($preset_dir . '/admin')) {
            copy_directory($preset_dir . '/admin', $theme_dir . '/inc/admin');
            log_message("  ✓ Copied admin files", 'green');
        }
    }
    
    // Copy Redux files
    copy_directory($source_dir . '/inc/redux', $theme_dir . '/inc/redux', array('redux-sections.php'));
    
    // Copy preset-specific Redux sections
    if (file_exists($preset_dir . '/redux-sections.php')) {
        copy($preset_dir . '/redux-sections.php', $theme_dir . '/inc/redux/redux-sections.php');
        log_message("  ✓ Copied redux-sections.php", 'green');
    }
    
    if (file_exists($preset_dir . '/redux-config.php')) {
        copy($preset_dir . '/redux-config.php', $theme_dir . '/inc/redux/redux-config.php');
        log_message("  ✓ Copied redux-config.php", 'green');
    }
    
    if (file_exists($preset_dir . '/redux.json')) {
        copy($preset_dir . '/redux.json', $theme_dir . '/inc/redux/redux.json');
        log_message("  ✓ Copied redux.json", 'green');
    }
    
    // Copy ACF files if needed
    if ($theme_name === 'food' && file_exists($source_dir . '/inc/acf-food.php')) {
        copy($source_dir . '/inc/acf-food.php', $theme_dir . '/inc/acf.php');
        log_message("  ✓ Copied acf.php (from acf-food.php)", 'green');
    } elseif (file_exists($source_dir . '/inc/acf.php')) {
        copy($source_dir . '/inc/acf.php', $theme_dir . '/inc/acf.php');
        log_message("  ✓ Copied acf.php", 'green');
    }
    
    log_message("Theme structure created: $theme_dir", 'green');
    
    return $theme_dir;
}

function update_style_css($theme_dir, $theme_name, $theme_info) {
    $style_file = $theme_dir . '/style.css';
    if (!file_exists($style_file)) {
        return false;
    }
    
    $content = file_get_contents($style_file);
    
    // Update theme name
    $theme_display_name = ucfirst($theme_name);
    $content = preg_replace('/Theme Name:.*/', "Theme Name: Al-Omran $theme_display_name", $content);
    
    // Update description
    $description = $theme_info['description'] ?? "Custom WordPress theme for $theme_display_name businesses.";
    $content = preg_replace('/Description:.*/', "Description: $description", $content);
    
    file_put_contents($style_file, $content);
    log_message("  ✓ Updated style.css", 'green');
    
    return true;
}

function create_functions_php($theme_dir, $theme_name, $source_dir) {
    $functions_file = $theme_dir . '/functions.php';
    
    // Read template
    $template = <<<'PHP'
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

// Core Setup
require_once ALOMRAN_THEME_DIR . '/inc/setup.php';
require_once ALOMRAN_THEME_DIR . '/inc/redux-blocker.php';
require_once ALOMRAN_THEME_DIR . '/inc/assets.php';
require_once ALOMRAN_THEME_DIR . '/inc/menu-walker.php';
require_once ALOMRAN_THEME_DIR . '/inc/translation.php';

// Helpers
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-company.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-content.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-products.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-url.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-archive.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-contact.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-ads.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-content-display.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-taxonomies.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-redux-repeater.php';

// Custom Post Types & Taxonomies
require_once ALOMRAN_THEME_DIR . '/inc/cpt-common.php';
if (file_exists(ALOMRAN_THEME_DIR . '/inc/cpt.php')) {
    require_once ALOMRAN_THEME_DIR . '/inc/cpt.php';
}
if (file_exists(ALOMRAN_THEME_DIR . '/inc/taxonomies.php')) {
    require_once ALOMRAN_THEME_DIR . '/inc/taxonomies.php';
}

// ACF
if (file_exists(ALOMRAN_THEME_DIR . '/inc/acf.php')) {
    require_once ALOMRAN_THEME_DIR . '/inc/acf.php';
}

// Media Management
require_once ALOMRAN_THEME_DIR . '/inc/product-media.php';
require_once ALOMRAN_THEME_DIR . '/inc/news-media.php';

// Contact & AJAX
require_once ALOMRAN_THEME_DIR . '/inc/contact-messages.php';
require_once ALOMRAN_THEME_DIR . '/inc/demo-requests.php';
require_once ALOMRAN_THEME_DIR . '/inc/ajax.php';

// Admin (if exists)
if (is_dir(ALOMRAN_THEME_DIR . '/inc/admin')) {
    $admin_files = glob(ALOMRAN_THEME_DIR . '/inc/admin/*.php');
    foreach ($admin_files as $file) {
        require_once $file;
    }
}

// SEO
require_once ALOMRAN_THEME_DIR . '/inc/seo/seo-helpers.php';
require_once ALOMRAN_THEME_DIR . '/inc/seo/seo-core.php';
require_once ALOMRAN_THEME_DIR . '/inc/seo/seo-schema.php';
require_once ALOMRAN_THEME_DIR . '/inc/seo/seo-sitemap.php';
require_once ALOMRAN_THEME_DIR . '/inc/seo/seo-images.php';
require_once ALOMRAN_THEME_DIR . '/inc/seo/seo-accessibility.php';
require_once ALOMRAN_THEME_DIR . '/inc/seo/seo-enhancements.php';

// Redux
require_once ALOMRAN_THEME_DIR . '/inc/redux/redux-helpers-core.php';
require_once ALOMRAN_THEME_DIR . '/inc/redux/redux-helpers.php';
require_once ALOMRAN_THEME_DIR . '/inc/redux/redux-config.php';

// Demo Import & Setup Wizard
require_once ALOMRAN_THEME_DIR . '/inc/demo-import/demo-data.php';
require_once ALOMRAN_THEME_DIR . '/inc/demo-import/setup-wizard.php';
require_once ALOMRAN_THEME_DIR . '/inc/demo-import/admin-ui.php';

// Widgets
require_once ALOMRAN_THEME_DIR . '/inc/widgets/ads-widget.php';
require_once ALOMRAN_THEME_DIR . '/inc/widgets/hero-widget.php';
require_once ALOMRAN_THEME_DIR . '/inc/widgets/spec-table-widget.php';
require_once ALOMRAN_THEME_DIR . '/inc/widgets/download-box-widget.php';
require_once ALOMRAN_THEME_DIR . '/inc/widgets/gallery-widget.php';
require_once ALOMRAN_THEME_DIR . '/inc/widgets/testimonials-widget.php';
require_once ALOMRAN_THEME_DIR . '/inc/widgets/projects-slider-widget.php';
require_once ALOMRAN_THEME_DIR . '/inc/widgets/clients-grid-widget.php';
PHP;
    
    file_put_contents($functions_file, $template);
    log_message("  ✓ Created functions.php", 'green');
    
    return true;
}

// Theme info
$theme_info = array(
    'industrial' => array(
        'description' => 'Custom WordPress theme for manufacturing and industrial companies specializing in stainless steel drainage systems, grease traps, and water treatment solutions.',
    ),
    'food' => array(
        'description' => 'Custom WordPress theme for restaurants, cafes, and food businesses with reservation system and menu management.',
    ),
    'tech' => array(
        'description' => 'Custom WordPress theme for technology companies and SaaS businesses with modern design and advanced features.',
    ),
);

// Main execution
log_message("Starting theme split process...", 'yellow');
log_message("Source: $source_theme_dir", 'blue');
log_message("Target: $target_base_dir", 'blue');
log_message("", 'reset');

foreach ($themes as $theme) {
    log_message("Processing theme: $theme", 'yellow');
    log_message("========================================", 'yellow');
    
    $theme_dir = create_theme_structure($theme, $source_theme_dir, $target_base_dir);
    
    if ($theme_dir) {
        update_style_css($theme_dir, $theme, $theme_info[$theme]);
        create_functions_php($theme_dir, $theme, $source_theme_dir);
        log_message("✓ Theme '$theme' created successfully!", 'green');
    } else {
        log_message("✗ Failed to create theme '$theme'", 'red');
    }
    
    log_message("", 'reset');
}

log_message("Theme split process completed!", 'green');
log_message("Themes created in: $target_base_dir", 'blue');

