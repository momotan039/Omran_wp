<?php
/**
 * Core Assets Loader
 * 
 * Handles loading of CSS and JavaScript assets from the core directory.
 * Supports preset-specific styles and proper dependency management.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue core theme assets
 * 
 * @hook wp_enqueue_scripts (priority 5)
 */
function omran_core_enqueue_assets() {
    // Only enqueue on frontend
    if (is_admin()) {
        return;
    }

    $version = defined('OMRAN_CORE_VERSION') ? OMRAN_CORE_VERSION : '1.0.0';
    $theme_version = defined('ALOMRAN_THEME_VERSION') ? ALOMRAN_THEME_VERSION : wp_get_theme()->get('Version');

    // Enqueue Google Fonts
    wp_enqueue_style(
        'alomran-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap',
        array(),
        null
    );

    // Enqueue Tailwind CSS (from assets directory for now, can be moved later)
    $tailwind_path = get_template_directory() . '/assets/css/tailwind.css';
    $tailwind_uri = get_template_directory_uri() . '/assets/css/tailwind.css';
    $tailwind_version = file_exists($tailwind_path) ? filemtime($tailwind_path) : $theme_version;

    wp_register_style('alomran-tailwind', $tailwind_uri, array(), $tailwind_version, 'all');
    wp_enqueue_style('alomran-tailwind');

    // Enqueue base component styles
    $components_css_path = OMRAN_CORE_DIR . '/assets/css/components.css';
    $components_css_uri = OMRAN_CORE_URI . '/assets/css/components.css';
    if (file_exists($components_css_path)) {
        $components_version = filemtime($components_css_path);
        wp_enqueue_style(
            'omran-core-components',
            $components_css_uri,
            array('alomran-tailwind'),
            $components_version,
            'all'
        );
    }

    // Enqueue base styles
    $base_css_path = OMRAN_CORE_DIR . '/assets/css/base.css';
    $base_css_uri = OMRAN_CORE_URI . '/assets/css/base.css';
    if (file_exists($base_css_path)) {
        $base_version = filemtime($base_css_path);
        wp_enqueue_style(
            'omran-core-base',
            $base_css_uri,
            array('alomran-tailwind', 'omran-core-components'),
            $base_version,
            'all'
        );
    }

    // Enqueue preset-specific styles
    $preset = omran_core_get_theme_preset();
    $preset_css_path = OMRAN_CORE_DIR . '/assets/css/presets/' . $preset . '.css';
    $preset_css_uri = OMRAN_CORE_URI . '/assets/css/presets/' . $preset . '.css';

    // Map preset names to CSS files
    $preset_map = array(
        'food' => 'food-beverage',
        'food-beverage' => 'food-beverage',
        'tech' => 'tech-devices',
        'tech-devices' => 'tech-devices',
        'industrial' => 'industrial',
    );

    if (isset($preset_map[$preset])) {
        $preset_file = $preset_map[$preset];
        $preset_css_path = OMRAN_CORE_DIR . '/assets/css/presets/' . $preset_file . '.css';
        $preset_css_uri = OMRAN_CORE_URI . '/assets/css/presets/' . $preset_file . '.css';
    }

    if (file_exists($preset_css_path)) {
        $preset_version = filemtime($preset_css_path);
        wp_enqueue_style(
            'omran-core-preset',
            $preset_css_uri,
            array('alomran-tailwind', 'omran-core-components', 'omran-core-base'),
            $preset_version,
            'all'
        );
    }

    /**
     * Allow presets to enqueue additional styles
     * This is handled by preset-loader.php which automatically loads preset assets
     * 
     * @since 1.0.0
     * 
     * @param string $preset Current preset identifier.
     */
    do_action('omran_core_enqueue_preset_styles', $preset);

    // Enqueue JavaScript
    omran_core_enqueue_scripts($version);
}

add_action('wp_enqueue_scripts', 'omran_core_enqueue_assets', 5);

/**
 * Enqueue core JavaScript files
 * 
 * @param string $version Version number.
 */
function omran_core_enqueue_scripts($version) {
    // Ensure jQuery is loaded first and in header
    wp_deregister_script('jquery');
    wp_register_script('jquery', includes_url('js/jquery/jquery.min.js'), array(), '3.7.1', false);
    wp_enqueue_script('jquery');

    // Enqueue JavaScript modules in order with proper jQuery dependency
    $js_base_uri = get_template_directory_uri() . '/assets/js';
    
    wp_enqueue_script('alomran-loader', $js_base_uri . '/modules/loader.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-mobile-menu', $js_base_uri . '/modules/mobile-menu.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-faq', $js_base_uri . '/modules/faq.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-contact-form', $js_base_uri . '/modules/contact-form.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-animations', $js_base_uri . '/modules/animations.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-stats-counter', $js_base_uri . '/modules/stats-counter.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-product-gallery', $js_base_uri . '/modules/product-gallery.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-main', $js_base_uri . '/main.js', array('jquery', 'alomran-loader', 'alomran-mobile-menu', 'alomran-faq', 'alomran-contact-form', 'alomran-animations', 'alomran-stats-counter', 'alomran-product-gallery'), $version, true);
    wp_enqueue_script('alomran-chat-widget', $js_base_uri . '/chat-widget.js', array('jquery'), $version, true);

    // Localize scripts
    $localized_data = array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('alomran-nonce')
    );
    wp_localize_script('alomran-contact-form', 'alomranAjax', $localized_data);
    wp_localize_script('alomran-chat-widget', 'alomranAjax', $localized_data);

    /**
     * Allow presets to enqueue additional scripts
     * 
     * @since 1.0.0
     */
    do_action('omran_core_enqueue_preset_scripts', $version);
}

/**
 * Ensure jQuery loads in header before all other scripts
 * 
 * @hook wp_enqueue_scripts (priority 20)
 */
function omran_core_ensure_jquery_header() {
    global $wp_scripts;

    if (isset($wp_scripts->registered['jquery'])) {
        $wp_scripts->registered['jquery']->extra['group'] = 0;
    }
}
add_action('wp_enqueue_scripts', 'omran_core_ensure_jquery_header', 20);

/**
 * Filter to allow presets to override asset paths
 * 
 * @param string $path Original asset path.
 * @param string $type Asset type (css/js).
 * @return string Modified asset path.
 * 
 * @hook omran_core_asset_path
 */
function omran_core_get_asset_path($path, $type = 'css') {
    /**
     * Filter asset path before loading.
     * 
     * @since 1.0.0
     * 
     * @param string $path Asset path.
     * @param string $type Asset type.
     */
    return apply_filters('omran_core_asset_path', $path, $type);
}

