<?php
/**
 * Core Theme Setup
 * 
 * Theme defaults, supports, and basic configuration.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Configure theme defaults and register supports.
 * 
 * @hook after_setup_theme
 */
function omran_core_theme_setup() {
    // Theme supports
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo');
    add_theme_support('customize-selective-refresh-widgets');

    // Register navigation menus
    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'alomran'),
            'footer'  => __('Footer Menu', 'alomran'),
        )
    );

    // Register image sizes
    add_image_size('product-thumbnail', 400, 400, true);
    add_image_size('product-large', 800, 800, true);
    add_image_size('news-thumbnail', 800, 400, true);
    
    /**
     * Allow presets to register additional image sizes
     * 
     * @since 1.0.0
     */
    do_action('omran_core_image_sizes');
}
add_action('after_setup_theme', 'omran_core_theme_setup');

/**
 * Set the content width based on the theme's design.
 * 
 * @hook after_setup_theme
 */
function omran_core_set_content_width() {
    /**
     * Filter the content width.
     * 
     * @since 1.0.0
     * 
     * @param int $content_width Content width in pixels.
     */
    $GLOBALS['content_width'] = apply_filters('omran_core_content_width', 1200);
}
add_action('after_setup_theme', 'omran_core_set_content_width', 0);

/**
 * Add preset-based body classes
 * 
 * @param array $classes Body classes.
 * @return array Modified body classes.
 * 
 * @hook body_class
 */
function omran_core_add_preset_body_classes($classes) {
    $preset = omran_core_get_theme_preset();
    $header_style = omran_core_get_header_style();
    $footer_style = omran_core_get_footer_style();
    $content_layout = omran_core_get_option('preset_content_layout', 'boxed');
    
    // Preset class
    $classes[] = 'preset-' . esc_attr($preset);
    
    // Header style class
    $classes[] = 'header-' . esc_attr($header_style);
    if (omran_core_is_header_sticky()) {
        $classes[] = 'header-sticky';
    }
    
    // Footer style class
    $classes[] = 'footer-' . esc_attr($footer_style);
    
    // Content layout class
    $classes[] = 'layout-' . esc_attr($content_layout);
    
    /**
     * Filter body classes added by core.
     * 
     * @since 1.0.0
     * 
     * @param array $classes Body classes.
     * @param string $preset Current theme preset.
     * @param string $header_style Current header style.
     * @param string $footer_style Current footer style.
     */
    $classes = apply_filters('omran_core_body_classes', $classes, $preset, $header_style, $footer_style);
    
    return $classes;
}
add_filter('body_class', 'omran_core_add_preset_body_classes');

