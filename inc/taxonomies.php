<?php
/**
 * Food Theme - Taxonomies
 * 
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Food theme taxonomies
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
add_action('init', 'alomran_food_register_taxonomies', 15);

