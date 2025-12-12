<?php
/**
 * Testimonials Section - Core Logic Only
 * 
 * This file contains only the logic for the testimonials section.
 * Layout/HTML is loaded from preset-specific layout files.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get section data
$data = alomran_get_section_data('testimonials');
if (!$data['enable']) {
    return;
}

// Query testimonials
$testimonials_query = new WP_Query(array(
    'post_type' => 'testimonial',
    'posts_per_page' => isset($data['count']) ? $data['count'] : 6,
));

if (!$testimonials_query->have_posts()) {
    return;
}

// Prepare data for layout
$testimonials_data = array(
    'enable' => $data['enable'],
    'title' => isset($data['title']) ? $data['title'] : '',
    'subtitle' => isset($data['subtitle']) ? $data['subtitle'] : '',
    'query' => $testimonials_query,
);

/**
 * Filter testimonials section data before rendering.
 * 
 * @since 1.0.0
 * 
 * @param array $testimonials_data Testimonials section data.
 */
$testimonials_data = apply_filters('omran_core_testimonials_data', $testimonials_data);

// Load preset-specific layout
$layout_path = omran_core_locate_preset_template_part('sections/section-testimonials', 'testimonials');
if (!$layout_path) {
    // Fallback to default layout
    $layout_path = get_template_directory() . '/template-parts/layouts/testimonials-default.php';
}

if (file_exists($layout_path)) {
    include $layout_path;
} else {
    // Minimal fallback
    echo '<!-- Testimonials section layout not found -->';
}
