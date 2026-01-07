<?php
/**
 * Test Import Script
 * 
 * Run this file directly to test the import functions
 * Usage: Access via browser or WP-CLI
 * 
 * @package AlOmran
 */

// Load WordPress
if (!defined('ABSPATH')) {
    // Try to find wp-load.php
    $wp_load_paths = array(
        __DIR__ . '/../../../../../../wp-load.php',
        __DIR__ . '/../../../../../wp-load.php',
        __DIR__ . '/../../../../wp-load.php',
    );
    
    $wp_loaded = false;
    foreach ($wp_load_paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            $wp_loaded = true;
            break;
        }
    }
    
    if (!$wp_loaded) {
        die('WordPress not found. Please run this from WordPress admin or ensure wp-load.php is accessible.');
    }
}

// Check permissions
if (!current_user_can('manage_options')) {
    die('You do not have permission to run this script.');
}

// Load content.php
$content_file = __DIR__ . '/content.php';
if (!file_exists($content_file)) {
    die('content.php file not found at: ' . $content_file);
}

require_once $content_file;

// Check if function exists
if (!function_exists('omran_demo_generate_content')) {
    die('Function omran_demo_generate_content not found. Check content.php file.');
}

// Check post types
echo "<h2>Checking Post Types</h2>";
$post_types = array('product', 'news', 'testimonial', 'faq');
foreach ($post_types as $pt) {
    $exists = post_type_exists($pt);
    echo "<p>Post Type '$pt': " . ($exists ? '✓ Registered' : '✗ NOT Registered') . "</p>";
}

// Check taxonomies
echo "<h2>Checking Taxonomies</h2>";
$taxonomies = array('product_category', 'news_category');
foreach ($taxonomies as $tax) {
    $exists = taxonomy_exists($tax);
    echo "<p>Taxonomy '$tax': " . ($exists ? '✓ Registered' : '✗ NOT Registered') . "</p>";
}

// Run import
echo "<h2>Running Import</h2>";
echo "<p>Starting import...</p>";

// Import content first
$results = omran_demo_generate_content(false);

echo "<h3>Content Import Results:</h3>";
echo "<pre>";
print_r($results);
echo "</pre>";

if (!empty($results['errors'])) {
    echo "<h3>Content Import Errors:</h3>";
    echo "<ul>";
    foreach ($results['errors'] as $error) {
        echo "<li>" . esc_html($error) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color: green;'><strong>✓ Content import completed successfully!</strong></p>";
}

// Import menus after content (always overwrite)
echo "<h2>Importing Menus</h2>";
echo "<p>Starting menu import...</p>";

if (function_exists('omran_demo_create_menus')) {
    $menu_results = omran_demo_create_menus(true); // Always overwrite
    
    echo "<h3>Menu Import Results:</h3>";
    echo "<pre>";
    print_r($menu_results);
    echo "</pre>";
    
    if (!empty($menu_results['errors'])) {
        echo "<h3>Menu Import Errors:</h3>";
        echo "<ul>";
        foreach ($menu_results['errors'] as $error) {
            echo "<li>" . esc_html($error) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color: green;'><strong>✓ Menu import completed successfully! " . 
             (isset($menu_results['count']) ? "(" . $menu_results['count'] . " menus)" : "") . 
             "</strong></p>";
    }
} else {
    echo "<p style='color: orange;'><strong>⚠ Function omran_demo_create_menus not found. Menus will not be imported.</strong></p>";
}

// Final summary
echo "<h2>Import Summary</h2>";
echo "<p style='color: green; font-size: 18px;'><strong>✓ All imports completed!</strong></p>";
echo "<ul>";
if (isset($results['pages'])) {
    echo "<li>Pages: " . $results['pages'] . "</li>";
}
if (isset($results['products'])) {
    echo "<li>Products: " . $results['products'] . "</li>";
}
if (isset($results['news'])) {
    echo "<li>News: " . $results['news'] . "</li>";
}
if (isset($results['testimonials'])) {
    echo "<li>Testimonials: " . $results['testimonials'] . "</li>";
}
if (isset($results['faqs'])) {
    echo "<li>FAQs: " . $results['faqs'] . "</li>";
}
if (isset($menu_results['count'])) {
    echo "<li>Menus: " . $menu_results['count'] . "</li>";
}
echo "</ul>";

