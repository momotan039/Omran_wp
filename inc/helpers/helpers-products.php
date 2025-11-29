<?php
/**
 * Product Helpers
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Parse features from textarea (ACF free compatible).
 * Converts line-separated text into array format.
 *
 * @param string|array $features Features field value.
 * @return array
 */
function alomran_parse_features($features) {
    // If already an array (from ACF Pro repeater), return as is
    if (is_array($features) && !empty($features) && isset($features[0]['feature_text'])) {
        return $features;
    }
    
    // If it's a string (from textarea), parse it
    if (is_string($features) && !empty($features)) {
        $lines = array_filter(array_map('trim', explode("\n", $features)));
        $parsed = array();
        foreach ($lines as $line) {
            if (!empty($line)) {
                $parsed[] = array('feature_text' => $line);
            }
        }
        return $parsed;
    }
    
    // If it's already an array of strings, convert it
    if (is_array($features) && !empty($features) && is_string($features[0])) {
        $parsed = array();
        foreach ($features as $feature) {
            if (!empty($feature)) {
                $parsed[] = array('feature_text' => $feature);
            }
        }
        return $parsed;
    }
    
    return array();
}

/**
 * Parse specifications from textarea (ACF free compatible).
 * Converts "Label: Value" format into array format.
 *
 * @param string|array $specs Specs field value.
 * @return array
 */
function alomran_parse_specs($specs) {
    // If already an array (from ACF Pro repeater), return as is
    if (is_array($specs) && !empty($specs) && isset($specs[0]['label'])) {
        return $specs;
    }
    
    // If it's a string (from textarea), parse it
    if (is_string($specs) && !empty($specs)) {
        $lines = array_filter(array_map('trim', explode("\n", $specs)));
        $parsed = array();
        foreach ($lines as $line) {
            if (!empty($line)) {
                // Check if line contains colon separator
                if (strpos($line, ':') !== false) {
                    $parts = explode(':', $line, 2);
                    $label = trim($parts[0]);
                    $value = isset($parts[1]) ? trim($parts[1]) : '';
                    if (!empty($label)) {
                        $parsed[] = array(
                            'label' => $label,
                            'value' => $value
                        );
                    }
                } else {
                    // If no colon, treat entire line as label with empty value
                    $parsed[] = array(
                        'label' => $line,
                        'value' => ''
                    );
                }
            }
        }
        return $parsed;
    }
    
    return array();
}

/**
 * Get product categories for display
 *
 * @param int $limit Maximum number of categories to return.
 * @return array Array of category objects.
 */
function alomran_get_product_categories($limit = 0) {
    // Ensure taxonomy exists before querying
    if (!taxonomy_exists('product_category')) {
        return array();
    }
    
    $args = array(
        'taxonomy'   => 'product_category',
        'hide_empty' => true,
        'orderby'    => 'count',
        'order'      => 'DESC',
    );
    
    if ($limit > 0) {
        $args['number'] = $limit;
    }
    
    $categories = get_terms($args);
    
    if (is_wp_error($categories) || empty($categories)) {
        return array();
    }
    
    return $categories;
}

/**
 * Get products query based on filters
 *
 * @param array $args {
 *     Optional. Query arguments.
 *     @type string $category_slug Category slug to filter by.
 *     @type string $search_term   Search term.
 *     @type int    $posts_per_page Number of posts per page. Default 12.
 *     @type int    $paged         Current page number.
 * }
 * @return WP_Query Products query object.
 */
function alomran_get_products_query($args = array()) {
    $defaults = array(
        'category_slug'  => '',
        'search_term'    => '',
        'posts_per_page' => 12,
        'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
    );
    
    $args = wp_parse_args($args, $defaults);
    
    $query_args = array(
        'post_type'      => 'product',
        'posts_per_page' => $args['posts_per_page'],
        'paged'          => $args['paged'],
    );
    
    // Add taxonomy filter if category is provided
    if (!empty($args['category_slug']) && taxonomy_exists('product_category')) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => 'product_category',
                'field'    => 'slug',
                'terms'    => $args['category_slug'],
            ),
        );
    }
    
    // Add search if term is provided
    if (!empty($args['search_term'])) {
        $query_args['s'] = $args['search_term'];
    }
    
    return new WP_Query($query_args);
}

