<?php
/**
 * Template Parts Loader
 * 
 * Handles loading of template parts with preset-specific layout support.
 * Separates core logic from visual presentation.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load a template part with preset layout support
 * 
 * @param string $template_name Template name (e.g., 'sections/section-hero').
 * @param array  $args Optional. Arguments to pass to template.
 * @param bool   $require_once Optional. Whether to require_once or require.
 * @return string|false Template content or false on failure.
 */
function omran_core_get_template_part($template_name, $args = array(), $require_once = true) {
    /**
     * Filter template part arguments before loading.
     * 
     * @since 1.0.0
     * 
     * @param array  $args Template arguments.
     * @param string $template_name Template name.
     */
    $args = apply_filters('omran_core_template_part_args', $args, $template_name);
    
    // Extract section name from template path
    $section_name = basename($template_name, '.php');
    if (strpos($section_name, 'section-') === 0) {
        $section_name = str_replace('section-', '', $section_name);
    }
    
    // Get preset-specific layout path
    $preset_layout = omran_core_locate_preset_template_part($template_name, $section_name);
    
    // Get core template path
    $core_template = get_template_directory() . '/' . $template_name . '.php';
    
    // Use preset layout if available, otherwise use core template
    $template_path = $preset_layout ? $preset_layout : $core_template;
    
    /**
     * Filter template part path before loading.
     * 
     * @since 1.0.0
     * 
     * @param string $template_path Template file path.
     * @param string $template_name Template name.
     * @param array  $args Template arguments.
     */
    $template_path = apply_filters('omran_core_template_part_path', $template_path, $template_name, $args);
    
    if (!file_exists($template_path)) {
        return false;
    }
    
    // Extract variables from args
    if (!empty($args) && is_array($args)) {
        extract($args, EXTR_SKIP);
    }
    
    // Start output buffering
    ob_start();
    
    if ($require_once) {
        require_once $template_path;
    } else {
        require $template_path;
    }
    
    $content = ob_get_clean();
    
    /**
     * Filter template part content after loading.
     * 
     * @since 1.0.0
     * 
     * @param string $content Template content.
     * @param string $template_name Template name.
     * @param array  $args Template arguments.
     */
    return apply_filters('omran_core_template_part_content', $content, $template_name, $args);
}

/**
 * Locate preset-specific template part
 * 
 * @param string $template_name Template name.
 * @param string $section_name Section name (extracted from template).
 * @return string|false Template path or false if not found.
 */
function omran_core_locate_preset_template_part($template_name, $section_name = '') {
    $preset_id = omran_core_get_theme_preset();
    
    if (empty($section_name)) {
        // Extract section name from template path
        $section_name = basename($template_name, '.php');
        if (strpos($section_name, 'section-') === 0) {
            $section_name = str_replace('section-', '', $section_name);
        }
    }
    
    // Search order:
    // 1. Check preset template-parts directory (exact match)
    $preset_template = get_template_directory() . '/presets/' . $preset_id . '/template-parts/' . $template_name . '.php';
    if (file_exists($preset_template)) {
        return $preset_template;
    }
    
    // 2. Check preset sections directory
    $preset_section = get_template_directory() . '/presets/' . $preset_id . '/template-parts/sections/section-' . $section_name . '.php';
    if (file_exists($preset_section)) {
        return $preset_section;
    }
    
    // 3. Check preset layout directory (preferred location)
    $preset_layout = get_template_directory() . '/presets/' . $preset_id . '/layouts/' . $section_name . '.php';
    if (file_exists($preset_layout)) {
        return $preset_layout;
    }
    
    /**
     * Filter preset template part location.
     * 
     * @since 1.0.0
     * 
     * @param string|false $template_path Template path or false.
     * @param string       $template_name Template name.
     * @param string       $section_name Section name.
     * @param string       $preset_id Preset identifier.
     */
    return apply_filters('omran_core_locate_preset_template_part', false, $template_name, $section_name, $preset_id);
}

/**
 * Render a template part with preset layout support
 * 
 * @param string $template_name Template name.
 * @param array  $args Optional. Arguments to pass to template.
 */
function omran_core_render_template_part($template_name, $args = array()) {
    $content = omran_core_get_template_part($template_name, $args);
    
    if ($content !== false) {
        echo $content;
    }
}

/**
 * Get section layout wrapper classes
 * 
 * @param string $section_name Section identifier.
 * @return string CSS classes.
 */
function omran_core_get_section_classes($section_name) {
    $preset_id = omran_core_get_theme_preset();
    $classes = array(
        'omran-section',
        'section-' . $section_name,
        'preset-' . $preset_id,
    );
    
    /**
     * Filter section wrapper classes.
     * 
     * @since 1.0.0
     * 
     * @param array  $classes CSS classes.
     * @param string $section_name Section identifier.
     * @param string $preset_id Active preset identifier.
     */
    $classes = apply_filters('omran_core_section_classes', $classes, $section_name, $preset_id);
    
    return implode(' ', array_map('esc_attr', $classes));
}

/**
 * Get section wrapper attributes
 * 
 * @param string $section_name Section identifier.
 * @return string HTML attributes.
 */
function omran_core_get_section_attributes($section_name) {
    $attributes = array(
        'class' => omran_core_get_section_classes($section_name),
        'data-section' => $section_name,
        'data-preset' => omran_core_get_theme_preset(),
    );
    
    /**
     * Filter section wrapper attributes.
     * 
     * @since 1.0.0
     * 
     * @param array  $attributes HTML attributes.
     * @param string $section_name Section identifier.
     */
    $attributes = apply_filters('omran_core_section_attributes', $attributes, $section_name);
    
    $output = '';
    foreach ($attributes as $key => $value) {
        $output .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
    }
    
    return $output;
}

