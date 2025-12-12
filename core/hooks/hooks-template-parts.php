<?php
/**
 * Template Parts Hooks
 * 
 * Hooks for template parts to allow preset overrides.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get header template part
 * 
 * @param string $style Header style identifier.
 * @return string Template path.
 * 
 * @hook omran_core_header_template
 */
function omran_core_get_header_template($style = '') {
    if (empty($style)) {
        $style = omran_core_get_header_style();
    }
    
    $template = 'template-parts/header/header-' . $style;
    
    /**
     * Filter header template path.
     * 
     * @since 1.0.0
     * 
     * @param string $template Template path.
     * @param string $style Header style identifier.
     */
    return apply_filters('omran_core_header_template', $template, $style);
}

/**
 * Get footer template part
 * 
 * @param string $style Footer style identifier.
 * @return string Template path.
 * 
 * @hook omran_core_footer_template
 */
function omran_core_get_footer_template($style = '') {
    if (empty($style)) {
        $style = omran_core_get_footer_style();
    }
    
    $template = 'template-parts/footer/footer-' . $style;
    
    /**
     * Filter footer template path.
     * 
     * @since 1.0.0
     * 
     * @param string $template Template path.
     * @param string $style Footer style identifier.
     */
    return apply_filters('omran_core_footer_template', $template, $style);
}

/**
 * Filter header classes
 * 
 * @param array  $classes CSS classes.
 * @param string $style Header style.
 * @return array Modified classes.
 * 
 * @hook omran_core_header_classes
 */
function omran_core_filter_header_classes($classes, $style) {
    return apply_filters('omran_core_header_classes', $classes, $style);
}

/**
 * Filter footer classes
 * 
 * @param array  $classes CSS classes.
 * @param string $style Footer style.
 * @return array Modified classes.
 * 
 * @hook omran_core_footer_classes
 */
function omran_core_filter_footer_classes($classes, $style) {
    return apply_filters('omran_core_footer_classes', $classes, $style);
}

/**
 * Action fired before header output
 * 
 * @hook omran_core_before_header
 */
function omran_core_before_header() {
    do_action('omran_core_before_header');
}

/**
 * Action fired after header output
 * 
 * @hook omran_core_after_header
 */
function omran_core_after_header() {
    do_action('omran_core_after_header');
}

/**
 * Action fired before footer output
 * 
 * @hook omran_core_before_footer
 */
function omran_core_before_footer() {
    do_action('omran_core_before_footer');
}

/**
 * Action fired after footer output
 * 
 * @hook omran_core_after_footer
 */
function omran_core_after_footer() {
    do_action('omran_core_after_footer');
}

