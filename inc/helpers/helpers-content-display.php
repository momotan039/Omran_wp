<?php
/**
 * Content Display Helper Functions
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get archive view type (grid or list)
 * 
 * @param string $post_type Post type (product, news, etc.)
 * @return string
 */
function alomran_get_archive_view($post_type = 'product') {
    $option_key = $post_type . '_archive_view';
    return alomran_get_option($option_key, 'grid');
}

/**
 * Get archive columns count
 * 
 * @param string $post_type Post type
 * @return int
 */
function alomran_get_archive_columns($post_type = 'product') {
    $option_key = $post_type . '_archive_columns';
    $columns = alomran_get_option($option_key, '3');
    return absint($columns);
}

/**
 * Get archive grid class
 * 
 * @param string $post_type Post type
 * @return string
 */
function alomran_get_archive_grid_class($post_type = 'product') {
    $view = alomran_get_archive_view($post_type);
    
    if ($view === 'list') {
        return 'grid-cols-1';
    }
    
    $columns = alomran_get_archive_columns($post_type);
    return 'grid-cols-1 md:grid-cols-' . $columns;
}

/**
 * Check if breadcrumbs should be shown
 * 
 * @return bool
 */
function alomran_show_breadcrumbs() {
    return alomran_get_option('show_breadcrumbs', true);
}

/**
 * Check if related products should be shown
 * 
 * @return bool
 */
function alomran_show_related_products() {
    return alomran_get_option('show_related_products', true);
}

/**
 * Check if related news should be shown
 * 
 * @return bool
 */
function alomran_show_related_news() {
    return alomran_get_option('show_related_news', true);
}

/**
 * Check if share buttons should be shown
 * 
 * @return bool
 */
function alomran_show_share_buttons() {
    return alomran_get_option('show_share_buttons', true);
}

/**
 * Check if author info should be shown
 * 
 * @return bool
 */
function alomran_show_author_info() {
    return alomran_get_option('show_author_info', false);
}

/**
 * Check if post date should be shown
 * 
 * @return bool
 */
function alomran_show_post_date() {
    return alomran_get_option('show_post_date', true);
}

