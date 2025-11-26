<?php
/**
 * Register custom post types.
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register all theme CPTs.
 */
function alomran_register_post_types() {
    register_post_type(
        'product',
        array(
            'labels' => array(
                'name'               => __('Products', 'alomran'),
                'singular_name'      => __('Product', 'alomran'),
                'add_new'            => __('Add New Product', 'alomran'),
                'add_new_item'       => __('Add New Product', 'alomran'),
                'edit_item'          => __('Edit Product', 'alomran'),
                'new_item'           => __('New Product', 'alomran'),
                'view_item'          => __('View Product', 'alomran'),
                'search_items'       => __('Search Products', 'alomran'),
                'not_found'          => __('No products found', 'alomran'),
                'not_found_in_trash' => __('No products found in trash', 'alomran'),
            ),
            'public'       => true,
            'has_archive'  => true,
            'menu_icon'    => 'dashicons-products',
            'supports'     => array('title', 'editor', 'thumbnail', 'excerpt'),
            'rewrite'      => array('slug' => 'products'),
            'show_in_rest' => true,
        )
    );

    register_post_type(
        'news',
        array(
            'labels' => array(
                'name'               => __('News', 'alomran'),
                'singular_name'      => __('News Item', 'alomran'),
                'add_new'            => __('Add New News', 'alomran'),
                'add_new_item'       => __('Add New News Item', 'alomran'),
                'edit_item'          => __('Edit News Item', 'alomran'),
                'new_item'           => __('New News Item', 'alomran'),
                'view_item'          => __('View News Item', 'alomran'),
                'search_items'       => __('Search News', 'alomran'),
                'not_found'          => __('No news found', 'alomran'),
                'not_found_in_trash' => __('No news found in trash', 'alomran'),
            ),
            'public'       => true,
            'has_archive'  => true,
            'menu_icon'    => 'dashicons-megaphone',
            'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'author', 'date'),
            'rewrite'      => array('slug' => 'news'),
            'show_in_rest' => true,
        )
    );

    register_post_type(
        'testimonial',
        array(
            'labels' => array(
                'name'               => __('Testimonials', 'alomran'),
                'singular_name'      => __('Testimonial', 'alomran'),
                'add_new'            => __('Add New Testimonial', 'alomran'),
                'add_new_item'       => __('Add New Testimonial', 'alomran'),
                'edit_item'          => __('Edit Testimonial', 'alomran'),
                'new_item'           => __('New Testimonial', 'alomran'),
                'view_item'          => __('View Testimonial', 'alomran'),
                'search_items'       => __('Search Testimonials', 'alomran'),
                'not_found'          => __('No testimonials found', 'alomran'),
                'not_found_in_trash' => __('No testimonials found in trash', 'alomran'),
            ),
            'public'       => true,
            'has_archive'  => false,
            'menu_icon'    => 'dashicons-format-quote',
            'supports'     => array('title', 'editor', 'thumbnail'),
            'show_in_rest' => true,
        )
    );

    register_post_type(
        'faq',
        array(
            'labels' => array(
                'name'               => __('FAQs', 'alomran'),
                'singular_name'      => __('FAQ', 'alomran'),
                'add_new'            => __('Add New FAQ', 'alomran'),
                'add_new_item'       => __('Add New FAQ', 'alomran'),
                'edit_item'          => __('Edit FAQ', 'alomran'),
                'new_item'           => __('New FAQ', 'alomran'),
                'view_item'          => __('View FAQ', 'alomran'),
                'search_items'       => __('Search FAQs', 'alomran'),
                'not_found'          => __('No FAQs found', 'alomran'),
                'not_found_in_trash' => __('No FAQs found in trash', 'alomran'),
            ),
            'public'       => true,
            'has_archive'  => false,
            'menu_icon'    => 'dashicons-editor-help',
            'supports'     => array('title', 'editor'),
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'alomran_register_post_types');

