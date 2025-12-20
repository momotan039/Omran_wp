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
    // SEO Support
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style'));
    
    // Post Thumbnails with responsive images
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('customize-selective-refresh-widgets');

    register_nav_menus(
        array(
            'primary' => __('القائمة الرئيسية', 'alomran'),
            'footer'  => __('قائمة التذييل', 'alomran'),
        )
    );

    add_image_size('product-thumbnail', 400, 400, true);
    add_image_size('product-large', 800, 800, true);
    add_image_size('news-thumbnail', 800, 400, true);
}
add_action('after_setup_theme', 'alomran_theme_setup');

/**
 * Register page templates from active preset
 * 
 * WordPress only discovers page templates in the theme root or direct subdirectories.
 * This function adds templates from presets/{preset}/templates/ to the available templates.
 */
function alomran_register_preset_page_templates($templates) {
    // Get active preset
    $preset = AlOmran_Preset_Loader::get_active_preset();
    $preset_dir = AlOmran_Preset_Loader::get_preset_dir($preset);
    
    if (!$preset_dir) {
        return $templates;
    }
    
    $templates_dir = $preset_dir . '/templates';
    if (!file_exists($templates_dir) || !is_dir($templates_dir)) {
        return $templates;
    }
    
    // Scan for page templates (files starting with 'page-')
    $template_files = glob($templates_dir . '/page-*.php');
    
    if ($template_files) {
        foreach ($template_files as $template_file) {
            $template_name = basename($template_file);
            
            // Get template header info
            $template_data = get_file_data($template_file, array(
                'Template Name' => 'Template Name',
                'Description' => 'Description'
            ));
            
            $template_label = !empty($template_data['Template Name']) 
                ? $template_data['Template Name'] 
                : ucfirst(str_replace(array('page-', '.php'), '', $template_name));
            
            // Use relative path from theme directory
            $template_path = 'presets/' . $preset . '/templates/' . $template_name;
            
            $templates[$template_path] = $template_label;
        }
    }
    
    return $templates;
}
add_filter('theme_page_templates', 'alomran_register_preset_page_templates');

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

