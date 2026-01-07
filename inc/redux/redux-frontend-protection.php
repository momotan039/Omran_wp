<?php
/**
 * Redux Frontend Protection
 * Blocks Redux completely on frontend, only allows in admin
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ULTRA-AGGRESSIVE frontend protection: Block Redux completely on frontend
 * This ensures Redux NEVER loads on client pages, only in admin
 */
if (!is_admin()) {
    // Block ALL Redux filters at the earliest possible moment
    add_filter('redux/options/alomran_options/output', '__return_false', 1);
    add_filter('redux/options/alomran_options/output_tag', '__return_false', 1);
    add_filter('redux/options/alomran_options/compiler', '__return_false', 1);
    add_filter('redux/options/alomran_options/enqueue', '__return_false', 1);
    add_filter('redux/enqueue', '__return_false', 1);
    add_filter('redux/register', '__return_false', 1);
    add_filter('redux/output', '__return_false', 1);
    add_filter('redux/output_tag', '__return_false', 1);
    add_filter('redux/compiler', '__return_false', 1);
    add_filter('redux/output/enable', '__return_false', 1);
    
    // Also block at maximum priority as backup
    add_filter('redux/options/alomran_options/output', '__return_false', 99999);
    add_filter('redux/options/alomran_options/output_tag', '__return_false', 99999);
    add_filter('redux/options/alomran_options/compiler', '__return_false', 99999);
    add_filter('redux/options/alomran_options/enqueue', '__return_false', 99999);
    add_filter('redux/enqueue', '__return_false', 99999);
    add_filter('redux/output/enable', '__return_false', 99999);
    
    // Prevent Redux from hooking into frontend at multiple priorities
    $priorities = array(1, 10, 50, 100, 999, 9999);
    foreach ($priorities as $priority) {
        add_action('init', function() use ($priority) {
            remove_action('wp_head', 'redux_output_css', $priority);
            remove_action('wp_footer', 'redux_output_css', $priority);
            remove_action('wp_enqueue_scripts', 'redux_output_css', $priority);
            remove_action('wp_enqueue_scripts', 'redux_enqueue', $priority);
        }, 1);
    }
}

