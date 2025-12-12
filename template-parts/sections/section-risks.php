<?php
/**
 * Risks Section - Core Logic Only
 * 
 * This file contains only the logic for the risks section.
 * Layout/HTML is loaded from preset-specific layout files.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get section data
$data = alomran_get_section_data('risks');
if (!$data['enable'] || empty($data['items'])) {
    return;
}

// Prepare data for layout
$risks_data = array(
    'enable' => $data['enable'],
    'title' => isset($data['title']) ? $data['title'] : '',
    'subtitle' => isset($data['subtitle']) ? $data['subtitle'] : '',
    'items' => $data['items'],
);

/**
 * Filter risks section data before rendering.
 * 
 * @since 1.0.0
 * 
 * @param array $risks_data Risks section data.
 */
$risks_data = apply_filters('omran_core_risks_data', $risks_data);

// Load preset-specific layout
$layout_path = omran_core_locate_preset_template_part('sections/section-risks', 'risks');
if (!$layout_path) {
    // Fallback to default layout
    $layout_path = get_template_directory() . '/template-parts/layouts/risks-default.php';
}

if (file_exists($layout_path)) {
    include $layout_path;
} else {
    // Minimal fallback
    echo '<!-- Risks section layout not found -->';
}
