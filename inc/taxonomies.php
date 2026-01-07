<?php
/**
 * Industrial Theme - Taxonomies
 * 
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Industrial theme taxonomies
 */
function alomran_industrial_register_taxonomies() {
    // Ensure post types are registered first
    if (!post_type_exists('product') || !post_type_exists('news')) {
        return;
    }
    
    // Register product categories
    alomran_register_taxonomy(
        'product_category',
        'product',
        'فئة المنتج',
        'فئات المنتجات',
        'product-category'
    );
    
    // Register news categories
    alomran_register_taxonomy(
        'news_category',
        'news',
        'فئة الأخبار',
        'فئات الأخبار',
        'news-category'
    );
}
add_action('init', 'alomran_industrial_register_taxonomies', 20);

