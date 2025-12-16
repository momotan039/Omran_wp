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
 * 
 * Add your custom taxonomies here for the Food preset
 * Example:
 * 
 * alomran_register_taxonomy('menu_category', 'menu_item', 'فئة القائمة', 'فئات القوائم', 'menu-category');
 */
function alomran_food_register_taxonomies() {
    // Add your Food preset taxonomies here
    // Example:
    // alomran_register_taxonomy('menu_category', 'menu_item', 'فئة القائمة', 'فئات القوائم', 'menu-category');
}
add_action('init', 'alomran_food_register_taxonomies', 20);

