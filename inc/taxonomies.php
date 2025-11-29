<?php
/**
 * Register theme taxonomies.
 *
 * @package AlOmran
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
 */
function alomran_fix_post_type_objects($post_type_name, $args) {
    // Only fix our custom post types
    if (!in_array($post_type_name, array('product', 'news'))) {
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
add_action('registered_post_type', 'alomran_fix_post_type_objects', 5, 2);

/**
 * Fix post type object properties
 *
 * @param string $post_type_name Post type name.
 */
function alomran_fix_post_type_properties($post_type_name) {
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
 */
add_action('init', function() {
    foreach (array('product', 'news') as $post_type_name) {
        alomran_fix_post_type_properties($post_type_name);
    }
}, 15); // Run after post types (10) but before taxonomies (20+)

/**
 * Get taxonomy labels for a given taxonomy
 *
 * @param string $singular Singular name.
 * @param string $plural   Plural name.
 * @return array Labels array.
 */
function alomran_get_taxonomy_labels($singular, $plural) {
    return array(
        'name'              => $plural,
        'singular_name'     => $singular,
        'search_items'      => 'البحث في الفئات',
        'all_items'         => 'جميع الفئات',
        'edit_item'         => 'تعديل الفئة',
        'update_item'       => 'تحديث الفئة',
        'add_new_item'      => 'إضافة فئة جديدة',
        'new_item_name'     => 'اسم الفئة الجديدة',
        'parent_item'       => 'الفئة الرئيسية',
        'parent_item_colon' => 'الفئة الرئيسية:',
    );
}

/**
 * Get taxonomy arguments
 *
 * @param string $slug Rewrite slug.
 * @return array Taxonomy arguments.
 */
function alomran_get_taxonomy_args($slug) {
    return array(
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => $slug),
        'show_in_rest'      => true,
    );
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
function alomran_register_single_taxonomy($taxonomy_name, $post_type, $singular, $plural, $slug) {
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
    
    register_taxonomy(
        $taxonomy_name,
        $post_type,
        array_merge(
            array('labels' => alomran_get_taxonomy_labels($singular, $plural)),
            alomran_get_taxonomy_args($slug)
        )
    );
}

/**
 * Register custom taxonomies.
 * 
 * Note: This runs after post types are registered (priority 20)
 */
function alomran_register_taxonomies() {
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
    
    // Register taxonomies
    alomran_register_single_taxonomy(
        'product_category',
        'product',
        'فئة المنتج',
        'فئات المنتجات',
        'product-category'
    );
    
    alomran_register_single_taxonomy(
        'news_category',
        'news',
        'فئة الأخبار',
        'فئات الأخبار',
        'news-category'
    );
    
    // Restore error reporting
    error_reporting($error_level);
}

// Register taxonomies on wp_loaded hook (runs after init)
add_action('wp_loaded', 'alomran_register_taxonomies', 5);

// Fallback: Also register on init with high priority
add_action('init', 'alomran_register_taxonomies', 999);
