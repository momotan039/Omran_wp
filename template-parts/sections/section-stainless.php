<?php
/**
 * Stainless Section - Core Logic Only
 * 
 * This file contains only the logic for the stainless section.
 * Layout/HTML is loaded from preset-specific layout files.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get section data
$data = alomran_get_section_data('stainless');
if (!$data['enable'] || empty($data['items'])) {
    return;
}

// Prepare data for layout
$stainless_data = array(
    'enable' => $data['enable'],
    'title' => isset($data['title']) ? $data['title'] : '',
    'subtitle' => isset($data['subtitle']) ? $data['subtitle'] : '',
    'items' => $data['items'],
);

/**
 * Filter stainless section data before rendering.
 * 
 * @since 1.0.0
 * 
 * @param array $stainless_data Stainless section data.
 */
$stainless_data = apply_filters('omran_core_stainless_data', $stainless_data);

// Load preset-specific layout
$layout_path = omran_core_locate_preset_template_part('sections/section-stainless', 'stainless');
if (!$layout_path) {
    // Fallback to default layout
    $layout_path = get_template_directory() . '/template-parts/layouts/stainless-default.php';
}

if (file_exists($layout_path)) {
    include $layout_path;
} else {
    // Minimal fallback
    echo '<!-- Stainless section layout not found -->';
}
