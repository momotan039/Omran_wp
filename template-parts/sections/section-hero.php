<?php
/**
 * Hero Section - Core Logic Only
 * 
 * This file contains only the logic for the hero section.
 * Layout/HTML is loaded from preset-specific layout files.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get section data
$data = alomran_get_section_data('hero');
if (!$data['enable']) {
    return;
}

// Prepare data for layout
$hero_data = array(
    'enable' => $data['enable'],
    'badge' => isset($data['badge']) ? $data['badge'] : '',
    'title' => isset($data['title']) ? $data['title'] : '',
    'subtitle' => isset($data['subtitle']) ? $data['subtitle'] : '',
    'description' => isset($data['description']) ? $data['description'] : '',
    'button1' => array(
        'text' => isset($data['button1']['text']) ? $data['button1']['text'] : '',
        'url' => isset($data['button1']['url']) ? $data['button1']['url'] : '',
    ),
    'button2' => array(
        'text' => isset($data['button2']['text']) ? $data['button2']['text'] : '',
        'url' => isset($data['button2']['url']) ? $data['button2']['url'] : '',
    ),
    'background' => array(
        'url' => !empty($data['background']['url']) ? $data['background']['url'] : 'https://picsum.photos/id/195/1920/1080',
    ),
    'show_seal' => isset($data['show_seal']) ? $data['show_seal'] : true,
);

/**
 * Filter hero section data before rendering.
 * 
 * @since 1.0.0
 * 
 * @param array $hero_data Hero section data.
 */
$hero_data = apply_filters('omran_core_hero_data', $hero_data);

// Load preset-specific layout
$layout_path = omran_core_locate_preset_template_part('sections/section-hero', 'hero');
if (!$layout_path) {
    // Fallback to default layout
    $layout_path = get_template_directory() . '/template-parts/layouts/hero-default.php';
}

if (file_exists($layout_path)) {
    include $layout_path;
} else {
    // Minimal fallback
    echo '<!-- Hero section layout not found -->';
}
