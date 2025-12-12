<?php
/**
 * Sectors Section - Core Logic Only
 * 
 * This file contains only the logic for the sectors section.
 * Layout/HTML is loaded from preset-specific layout files.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get section data
$data = alomran_get_section_data('sectors');
if (!$data['enable'] || empty($data['items'])) {
    return;
}

// Prepare data for layout
$sectors_data = array(
    'enable' => $data['enable'],
    'title' => isset($data['title']) ? $data['title'] : '',
    'subtitle' => isset($data['subtitle']) ? $data['subtitle'] : '',
    'items' => $data['items'],
);

/**
 * Filter sectors section data before rendering.
 * 
 * @since 1.0.0
 * 
 * @param array $sectors_data Sectors section data.
 */
$sectors_data = apply_filters('omran_core_sectors_data', $sectors_data);

// Load preset-specific layout
$layout_path = omran_core_locate_preset_template_part('sections/section-sectors', 'sectors');
if (!$layout_path) {
    // Fallback to default layout
    $layout_path = get_template_directory() . '/template-parts/layouts/sectors-default.php';
}

if (file_exists($layout_path)) {
    include $layout_path;
} else {
    // Minimal fallback
    echo '<!-- Sectors section layout not found -->';
}
