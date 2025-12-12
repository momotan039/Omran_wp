<?php
/**
 * Core Taxonomies Registration
 * 
 * All custom taxonomies are registered here with hooks for preset customization.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Fix WordPress core issue: Ensure post type objects have required properties
 * before WordPress core tries to access them in taxonomy.php
 * 
 * @param string $post_type_name Post type name.
 * @param array  $args Post type arguments.
 * 
 * @hook registered_post_type (priority 5)
 */
function omran_core_fix_post_type_objects($post_type_name, $args) {
    // Only fix our custom post types
    if (!in_array($post_type_name, array('product', 'news'), true)) {
        return;
    }
    
    // Get the registered post type object
    $post_type_object = get_post_type_object($post_type_name);
    
    if (!$post_type_object || !is_object($post_type_object)) {
        return;
    }
    
    // Add missing properties that WordPress core expects in taxonomy.php
    if (!isset($post_type_object->taxonomy)) {
        $post_type_object->taxonomy = array();
    }
    
    if (!isset($post_type_object->slug)) {
        $post_type_object->slug = $post_type_name;
    }
    
    if (!isset($post_type_object->query_var)) {
        $post_type_object->query_var = isset($args['query_var']) ? $args['query_var'] : true;
    }
}
add_action('registered_post_type', 'omran_core_fix_post_type_objects', 5, 2);

/**
 * Fix post type object properties
 *
 * @param string $post_type_name Post type name.
 */
function omran_core_fix_post_type_properties($post_type_name) {
    if (!post_type_exists($post_type_name)) {
        return;
    }
    
    $post_type_object = get_post_type_object($post_type_name);
    if (!$post_type_object || !is_object($post_type_object)) {
        return;
    }
    
    if (!isset($post_type_object->taxonomy)) {
        $post_type_object->taxonomy = array();
    }
    if (!isset($post_type_object->slug)) {
        $post_type_object->slug = $post_type_name;
    }
    if (!isset($post_type_object->query_var) || $post_type_object->query_var === false) {
        $post_type_object->query_var = true;
    }
}

/**
 * Additional fix: Ensure properties are set on init hook
 * This catches cases where WordPress core accesses the object before registered_post_type fires
 * 
 * @hook init (priority 15)
 */
add_action('init', function() {
    foreach (array('product', 'news') as $post_type_name) {
        omran_core_fix_post_type_properties($post_type_name);
    }
}, 15); // Run after post types (10) but before taxonomies (20+)

/**
 * Get taxonomy labels for a given taxonomy
 *
 * @param string $singular Singular name.
 * @param string $plural   Plural name.
 * @return array Labels array.
 */
function omran_core_get_taxonomy_labels($singular, $plural) {
    /**
     * Filter taxonomy labels.
     * 
     * @since 1.0.0
     * 
     * @param array  $labels Labels array.
     * @param string $singular Singular name.
     * @param string $plural Plural name.
     */
    return apply_filters('omran_core_taxonomy_labels', array(
        'name'              => $plural,
        'singular_name'     => $singular,
        'search_items'      => __('البحث في الفئات', 'alomran'),
        'all_items'         => __('جميع الفئات', 'alomran'),
        'edit_item'         => __('تعديل الفئة', 'alomran'),
        'update_item'       => __('تحديث الفئة', 'alomran'),
        'add_new_item'      => __('إضافة فئة جديدة', 'alomran'),
        'new_item_name'     => __('اسم الفئة الجديدة', 'alomran'),
        'parent_item'       => __('الفئة الرئيسية', 'alomran'),
        'parent_item_colon' => __('الفئة الرئيسية:', 'alomran'),
    ), $singular, $plural);
}

/**
 * Get taxonomy arguments
 *
 * @param string $slug Rewrite slug.
 * @return array Taxonomy arguments.
 */
function omran_core_get_taxonomy_args($slug) {
    /**
     * Filter taxonomy arguments.
     * 
     * @since 1.0.0
     * 
     * @param array  $args Taxonomy arguments.
     * @param string $slug Rewrite slug.
     */
    return apply_filters('omran_core_taxonomy_args', array(
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => $slug),
        'show_in_rest'      => true,
    ), $slug);
}

/**
 * Register a single taxonomy
 *
 * @param string $taxonomy_name Taxonomy name.
 * @param string $post_type     Post type name.
 * @param string $singular      Singular label.
 * @param string $plural        Plural label.
 * @param string $slug          Rewrite slug.
 */
function omran_core_register_single_taxonomy($taxonomy_name, $post_type, $singular, $plural, $slug) {
    if (taxonomy_exists($taxonomy_name)) {
        return;
    }
    
    if (!post_type_exists($post_type)) {
        return;
    }
    
    $post_type_object = get_post_type_object($post_type);
    if (!$post_type_object || !is_object($post_type_object) || !isset($post_type_object->name)) {
        return;
    }
    
    /**
     * Filter single taxonomy arguments before registration.
     * 
     * @since 1.0.0
     * 
     * @param array  $args Taxonomy arguments.
     * @param string $taxonomy_name Taxonomy name.
     * @param string $post_type Post type name.
     */
    $args = apply_filters('omran_core_single_taxonomy_args', array_merge(
        array('labels' => omran_core_get_taxonomy_labels($singular, $plural)),
        omran_core_get_taxonomy_args($slug)
    ), $taxonomy_name, $post_type);
    
    register_taxonomy($taxonomy_name, $post_type, $args);
}

/**
 * Register custom taxonomies.
 * 
 * Note: This runs after post types are registered (priority 20)
 * 
 * @hook wp_loaded (priority 5)
 * @hook init (priority 999)
 */
function omran_core_register_taxonomies() {
    // Ensure post types are registered first
    if (!post_type_exists('product') || !post_type_exists('news')) {
        return;
    }
    
    // Verify post type objects exist and are valid
    $product_post_type = get_post_type_object('product');
    $news_post_type = get_post_type_object('news');
    
    if (!$product_post_type || !$news_post_type || 
        !is_object($product_post_type) || !is_object($news_post_type) ||
        !isset($product_post_type->name) || !isset($news_post_type->name)) {
        return;
    }
    
    // Suppress warnings during taxonomy registration
    $error_level = error_reporting();
    error_reporting($error_level & ~E_WARNING);
    
    // Register product category taxonomy
    omran_core_register_single_taxonomy(
        'product_category',
        'product',
        __('فئة المنتج', 'alomran'),
        __('فئات المنتجات', 'alomran'),
        'product-category'
    );
    
    // Register news category taxonomy
    omran_core_register_single_taxonomy(
        'news_category',
        'news',
        __('فئة الأخبار', 'alomran'),
        __('فئات الأخبار', 'alomran'),
        'news-category'
    );
    
    // Restore error reporting
    error_reporting($error_level);
    
    /**
     * Action fired after all taxonomies are registered.
     * 
     * @since 1.0.0
     */
    do_action('omran_core_taxonomies_registered');
}

// Register taxonomies on wp_loaded hook (runs after init)
add_action('wp_loaded', 'omran_core_register_taxonomies', 5);

// Fallback: Also register on init with high priority
add_action('init', 'omran_core_register_taxonomies', 999);

