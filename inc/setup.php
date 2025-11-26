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

