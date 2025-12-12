<?php
/**
 * Products Section - Core Logic Only
 * 
 * This file contains only the logic for the products section.
 * Layout/HTML is loaded from preset-specific layout files.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get section data
$data = alomran_get_section_data('products');
if (!$data['enable']) {
    return;
}

// Query featured products
$products_query = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => isset($data['count']) ? $data['count'] : 6,
    'meta_query' => array(
        array(
            'key' => 'is_featured',
            'value' => '1',
            'compare' => '='
        )
    )
));

if (!$products_query->have_posts()) {
    return;
}

// Prepare data for layout
$products_data = array(
    'enable' => $data['enable'],
    'title' => isset($data['title']) ? $data['title'] : '',
    'subtitle' => isset($data['subtitle']) ? $data['subtitle'] : '',
    'show_all_link' => isset($data['show_all_link']) ? $data['show_all_link'] : true,
    'all_link_url' => get_post_type_archive_link('product') ?: home_url('/products'),
    'query' => $products_query,
);

/**
 * Filter products section data before rendering.
 * 
 * @since 1.0.0
 * 
 * @param array $products_data Products section data.
 */
$products_data = apply_filters('omran_core_products_data', $products_data);

// Load preset-specific layout
$layout_path = omran_core_locate_preset_template_part('sections/section-products', 'products');
if (!$layout_path) {
    // Fallback to default layout
    $layout_path = get_template_directory() . '/template-parts/layouts/products-default.php';
}

if (file_exists($layout_path)) {
    include $layout_path;
} else {
    // Minimal fallback
    echo '<!-- Products section layout not found -->';
}
