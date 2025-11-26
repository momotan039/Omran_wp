<?php
/**
 * Enqueue theme assets.
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

function alomran_disable_redux_frontend_css() {
    if (!is_admin() && class_exists('Redux')) {
        remove_action('wp_head', 'redux_output_css', 150);
        remove_action('wp_enqueue_scripts', 'redux_output_css', 150);
        add_filter('redux/options/alomran_options/output', '__return_false');
        add_filter('redux/options/alomran_options/output_tag', '__return_false');
    }
}
add_action('init', 'alomran_disable_redux_frontend_css', 1);

function alomran_enqueue_assets() {
    $version = defined('ALOMRAN_THEME_VERSION') ? ALOMRAN_THEME_VERSION : wp_get_theme()->get('Version');
    $tailwind_path = get_template_directory() . '/assets/css/tailwind.css';

    wp_enqueue_style('alomran-google-fonts', 'https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap', array(), null);
    wp_enqueue_style('alomran-tailwind', get_template_directory_uri() . '/assets/css/tailwind.css', array(), file_exists($tailwind_path) ? filemtime($tailwind_path) : $version);
    wp_enqueue_style('alomran-custom', get_template_directory_uri() . '/assets/css/custom.css', array('alomran-tailwind'), $version);

    wp_enqueue_script('alomran-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-chat-widget', get_template_directory_uri() . '/assets/js/chat-widget.js', array('jquery'), $version, true);

    $localized_data = array('ajaxurl' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('alomran-nonce'));
    wp_localize_script('alomran-main', 'alomranAjax', $localized_data);
    wp_localize_script('alomran-chat-widget', 'alomranAjax', $localized_data);
}
add_action('wp_enqueue_scripts', 'alomran_enqueue_assets', 999);

