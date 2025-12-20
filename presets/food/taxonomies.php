<?php
/**
 * Food Preset - Taxonomies
 * 
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Food preset taxonomies
 */
function alomran_food_register_taxonomies() {
    // Ensure menu_item post type is registered
    if (!post_type_exists('menu_item')) {
        return;
    }
    
    // Menu Category Taxonomy
    alomran_register_taxonomy(
        'menu_category',
        'menu_item',
        'فئة القائمة',
        'فئات القائمة',
        'menu-category'
    );
}

// Register on init hook (will also be called directly from preset registry)
add_action('init', 'alomran_food_register_taxonomies', 15);
