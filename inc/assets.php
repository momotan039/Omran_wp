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
        // Remove all Redux CSS output actions
        remove_action('wp_head', 'redux_output_css', 150);
        remove_action('wp_enqueue_scripts', 'redux_output_css', 150);
        
        // Try to remove instance-specific actions if Redux is initialized
        if (method_exists('Redux', 'instance')) {
            try {
                $redux_instance = Redux::instance('alomran_options');
                if ($redux_instance) {
                    remove_action('wp_head', array($redux_instance, 'output_css'), 150);
                    remove_action('wp_enqueue_scripts', array($redux_instance, 'output_css'), 150);
                }
            } catch (Exception $e) {
                // Redux not initialized yet, continue with other methods
            }
        }
        
        // Disable output via filters
        add_filter('redux/options/alomran_options/output', '__return_false');
        add_filter('redux/options/alomran_options/output_tag', '__return_false');
        add_filter('redux/options/alomran_options/compiler', '__return_false');
        
        // Disable Redux CSS globally
        add_filter('redux/' . 'alomran_options' . '/field/class/output', '__return_false');
        add_filter('redux/' . 'alomran_options' . '/compiler', '__return_false');
        
        // Prevent Redux from enqueuing any stylesheets
        add_action('wp_enqueue_scripts', function() {
            wp_dequeue_style('redux-admin-css');
            wp_dequeue_style('redux-elusive-icon');
            wp_dequeue_style('redux-elusive-icon-ie7');
            wp_dequeue_style('redux-field-css');
        }, 999);
    }
}
add_action('init', 'alomran_disable_redux_frontend_css', 1);

// Additional hook to ensure Redux CSS is disabled early
function alomran_disable_redux_css_early() {
    if (!is_admin() && class_exists('Redux')) {
        // Disable output before Redux initializes
        add_filter('redux/options/alomran_options/output', '__return_false', 1);
        add_filter('redux/options/alomran_options/output_tag', '__return_false', 1);
        add_filter('redux/options/alomran_options/compiler', '__return_false', 1);
    }
}
add_action('after_setup_theme', 'alomran_disable_redux_css_early', 1);

// Remove any Redux CSS that might still be output in the HTML
function alomran_remove_redux_css_from_html() {
    if (!is_admin()) {
        // Start output buffering to filter final HTML
        ob_start(function($html) {
            // Remove Redux-generated inline style tags
            $html = preg_replace('/<style[^>]*(?:data-redux|id="[^"]*redux[^"]*")[^>]*>.*?<\/style>/is', '', $html);
            // Remove Redux CSS file links
            $html = preg_replace('/<link[^>]*href="[^"]*redux[^"]*"[^>]*>/i', '', $html);
            // Remove any style tags with Redux-related content
            $html = preg_replace('/<style[^>]*>.*?redux.*?<\/style>/is', '', $html);
            return $html;
        });
    }
}
add_action('template_redirect', 'alomran_remove_redux_css_from_html', 1);

function alomran_enqueue_assets() {
    $version = defined('ALOMRAN_THEME_VERSION') ? ALOMRAN_THEME_VERSION : wp_get_theme()->get('Version');
    $tailwind_path = get_template_directory() . '/assets/css/tailwind.css';

    wp_enqueue_style('alomran-google-fonts', 'https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap', array(), null);
    wp_enqueue_style('alomran-tailwind', get_template_directory_uri() . '/assets/css/tailwind.css', array(), file_exists($tailwind_path) ? filemtime($tailwind_path) : $version);
    wp_enqueue_style('alomran-custom', get_template_directory_uri() . '/assets/css/custom.css', array('alomran-tailwind'), $version);

    // Enqueue JavaScript modules in order
    wp_enqueue_script('alomran-loader', get_template_directory_uri() . '/assets/js/modules/loader.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-mobile-menu', get_template_directory_uri() . '/assets/js/modules/mobile-menu.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-faq', get_template_directory_uri() . '/assets/js/modules/faq.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-contact-form', get_template_directory_uri() . '/assets/js/modules/contact-form.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-animations', get_template_directory_uri() . '/assets/js/modules/animations.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-stats-counter', get_template_directory_uri() . '/assets/js/modules/stats-counter.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-product-gallery', get_template_directory_uri() . '/assets/js/modules/product-gallery.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'alomran-loader', 'alomran-mobile-menu', 'alomran-faq', 'alomran-contact-form', 'alomran-animations', 'alomran-stats-counter', 'alomran-product-gallery'), $version, true);
    wp_enqueue_script('alomran-chat-widget', get_template_directory_uri() . '/assets/js/chat-widget.js', array('jquery'), $version, true);

    $localized_data = array('ajaxurl' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('alomran-nonce'));
    wp_localize_script('alomran-contact-form', 'alomranAjax', $localized_data);
    wp_localize_script('alomran-chat-widget', 'alomranAjax', $localized_data);
}
add_action('wp_enqueue_scripts', 'alomran_enqueue_assets', 999);

