<?php
/**
 * Section-Specific Hooks
 * 
 * Hooks for individual sections to allow preset customization.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Hero Section Hooks
 */

/**
 * Filter hero section data
 * 
 * @param array $data Hero section data.
 * @return array Modified hero data.
 * 
 * @hook omran_core_hero_data
 */
function omran_core_filter_hero_data($data) {
    return apply_filters('omran_core_hero_data', $data);
}

/**
 * Filter hero section template
 * 
 * @param string $template Template path.
 * @return string Modified template path.
 * 
 * @hook omran_core_hero_template
 */
function omran_core_filter_hero_template($template) {
    return apply_filters('omran_core_hero_template', $template);
}

/**
 * Products Section Hooks
 */

/**
 * Filter products section data
 * 
 * @param array $data Products section data.
 * @return array Modified products data.
 * 
 * @hook omran_core_products_data
 */
function omran_core_filter_products_data($data) {
    return apply_filters('omran_core_products_data', $data);
}

/**
 * Filter products query args
 * 
 * @param array $args WP_Query arguments.
 * @return array Modified query args.
 * 
 * @hook omran_core_products_query_args
 */
function omran_core_filter_products_query_args($args) {
    return apply_filters('omran_core_products_query_args', $args);
}

/**
 * Testimonials Section Hooks
 */

/**
 * Filter testimonials section data
 * 
 * @param array $data Testimonials section data.
 * @return array Modified testimonials data.
 * 
 * @hook omran_core_testimonials_data
 */
function omran_core_filter_testimonials_data($data) {
    return apply_filters('omran_core_testimonials_data', $data);
}

/**
 * Filter testimonials query args
 * 
 * @param array $args WP_Query arguments.
 * @return array Modified query args.
 * 
 * @hook omran_core_testimonials_query_args
 */
function omran_core_filter_testimonials_query_args($args) {
    return apply_filters('omran_core_testimonials_query_args', $args);
}

/**
 * Generic Section Hooks
 */

/**
 * Action fired before section output
 * 
 * @param string $section Section identifier.
 * 
 * @hook omran_core_before_section
 */
function omran_core_before_section($section) {
    do_action('omran_core_before_section', $section);
}

/**
 * Action fired after section output
 * 
 * @param string $section Section identifier.
 * 
 * @hook omran_core_after_section
 */
function omran_core_after_section($section) {
    do_action('omran_core_after_section', $section);
}

/**
 * Filter section wrapper classes
 * 
 * @param array  $classes CSS classes.
 * @param string $section Section identifier.
 * @return array Modified classes.
 * 
 * @hook omran_core_section_wrapper_classes
 */
function omran_core_filter_section_wrapper_classes($classes, $section) {
    return apply_filters('omran_core_section_wrapper_classes', $classes, $section);
}

