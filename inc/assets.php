<?php
/**
 * Enqueue theme assets.
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register front-end assets.
 */
function alomran_enqueue_assets() {
    $version = defined('ALOMRAN_THEME_VERSION') ? ALOMRAN_THEME_VERSION : wp_get_theme()->get('Version');

    // Enqueue Tailwind CSS (built file)
    wp_enqueue_style(
        'alomran-tailwind',
        get_template_directory_uri() . '/assets/css/tailwind.css',
        array(),
        file_exists(get_template_directory() . '/assets/css/tailwind.css') ? filemtime(get_template_directory() . '/assets/css/tailwind.css') : $version
    );

    // Enqueue Google Fonts
    wp_enqueue_style(
        'alomran-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap',
        array(),
        null
    );

    // Enqueue custom CSS
    wp_enqueue_style(
        'alomran-custom',
        get_template_directory_uri() . '/assets/css/custom.css',
        array('alomran-tailwind'),
        $version
    );

    wp_enqueue_script(
        'alomran-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        $version,
        true
    );

    wp_enqueue_script(
        'alomran-chat-widget',
        get_template_directory_uri() . '/assets/js/chat-widget.js',
        array('jquery'),
        $version,
        true
    );

    $localized_data = array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('alomran-nonce'),
    );

    wp_localize_script('alomran-main', 'alomranAjax', $localized_data);
    wp_localize_script('alomran-chat-widget', 'alomranAjax', $localized_data);
}
add_action('wp_enqueue_scripts', 'alomran_enqueue_assets');

