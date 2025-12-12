<?php
/**
 * Widgets Loader
 * 
 * Loads all core widgets.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register and load all core widgets
 * 
 * @hook widgets_init
 */
function omran_core_register_widgets() {
    $widget_files = array(
        'ads-widget.php',
        'hero-widget.php',
        'spec-table-widget.php',
        'download-box-widget.php',
        'gallery-widget.php',
        'testimonials-widget.php',
        'projects-slider-widget.php',
        'clients-grid-widget.php',
    );
    
    foreach ($widget_files as $file) {
        $filepath = OMRAN_CORE_DIR . '/widgets/' . $file;
        if (file_exists($filepath)) {
            require_once $filepath;
        }
    }
    
    /**
     * Action fired after all widgets are loaded.
     * Allows presets to register additional widgets.
     * 
     * @since 1.0.0
     */
    do_action('omran_core_widgets_loaded');
}
add_action('widgets_init', 'omran_core_register_widgets', 10);

