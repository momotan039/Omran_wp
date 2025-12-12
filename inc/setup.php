<?php
/**
 * Theme setup tasks.
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Configure theme defaults and register supports.
 */
function alomran_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo');
    add_theme_support('customize-selective-refresh-widgets');

    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'alomran'),
            'footer'  => __('Footer Menu', 'alomran'),
        )
    );

    add_image_size('product-thumbnail', 400, 400, true);
    add_image_size('product-large', 800, 800, true);
    add_image_size('news-thumbnail', 800, 400, true);
}
add_action('after_setup_theme', 'alomran_theme_setup');

/**
 * Set the content width based on the theme's design.
 */
function alomran_set_content_width() {
    $GLOBALS['content_width'] = 1200;
}
add_action('after_setup_theme', 'alomran_set_content_width', 0);

/**
 * Add preset-based body classes
 */
function alomran_add_preset_body_classes($classes) {
    $preset = alomran_get_theme_preset();
    $header_style = alomran_get_header_style();
    $footer_style = alomran_get_footer_style();
    $content_layout = alomran_get_option('preset_content_layout', 'boxed');
    
    // Preset class
    $classes[] = 'preset-' . esc_attr($preset);
    
    // Header style class
    $classes[] = 'header-' . esc_attr($header_style);
    if (alomran_is_header_sticky()) {
        $classes[] = 'header-sticky';
    }
    
    // Footer style class
    $classes[] = 'footer-' . esc_attr($footer_style);
    
    // Content layout class
    $classes[] = 'layout-' . esc_attr($content_layout);
    
    return $classes;
}
add_filter('body_class', 'alomran_add_preset_body_classes');

