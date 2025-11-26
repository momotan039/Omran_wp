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
 * Register custom taxonomies.
 */
function alomran_register_taxonomies() {
    register_taxonomy(
        'product_category',
        'product',
        array(
            'labels' => array(
                'name'          => __('Product Categories', 'alomran'),
                'singular_name' => __('Product Category', 'alomran'),
                'search_items'  => __('Search Categories', 'alomran'),
                'all_items'     => __('All Categories', 'alomran'),
                'edit_item'     => __('Edit Category', 'alomran'),
                'update_item'   => __('Update Category', 'alomran'),
                'add_new_item'  => __('Add New Category', 'alomran'),
                'new_item_name' => __('New Category Name', 'alomran'),
            ),
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'product-category'),
            'show_in_rest'      => true,
        )
    );

    register_taxonomy(
        'news_category',
        'news',
        array(
            'labels' => array(
                'name'          => __('News Categories', 'alomran'),
                'singular_name' => __('News Category', 'alomran'),
            ),
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'news-category'),
            'show_in_rest'      => true,
        )
    );
}
add_action('init', 'alomran_register_taxonomies');

