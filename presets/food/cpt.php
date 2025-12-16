<?php
/**
 * Food Preset - Custom Post Types
 * 
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Food preset CPTs
 * 
 * Add your custom post types here for the Food preset
 * Example:
 * 
 * register_post_type('menu_item', array(...));
 * register_post_type('reservation', array(...));
 */
function alomran_food_register_post_types() {
    // Add your Food preset CPTs here
    // Example:
    // register_post_type('menu_item', array(...));
}
add_action('init', 'alomran_food_register_post_types', 10);

