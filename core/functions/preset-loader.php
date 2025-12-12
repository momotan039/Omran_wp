<?php
/**
 * Theme Preset Loader
 * 
 * Automatically loads and applies theme presets based on Redux option.
 * Supports preset configuration files, template overrides, and asset loading.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get all available presets
 * 
 * @return array Array of preset configurations.
 */
function omran_core_get_available_presets() {
    static $presets = null;
    
    if (null !== $presets) {
        return $presets;
    }
    
    $presets = array();
    $presets_dir = get_template_directory() . '/presets';
    
    if (!is_dir($presets_dir)) {
        return $presets;
    }
    
    // Scan presets directory
    $preset_folders = array_filter(glob($presets_dir . '/*'), 'is_dir');
    
    foreach ($preset_folders as $preset_folder) {
        $preset_id = basename($preset_folder);
        $config_file = $preset_folder . '/config.php';
        
        if (file_exists($config_file)) {
            $config = include $config_file;
            if (is_array($config) && isset($config['id'])) {
                $presets[$preset_id] = $config;
            }
        }
    }
    
    /**
     * Filter available presets.
     * 
     * @since 1.0.0
     * 
     * @param array $presets Array of preset configurations.
     */
    return apply_filters('omran_core_available_presets', $presets);
}

/**
 * Get current active preset configuration
 * 
 * @return array|false Preset configuration array or false if not found.
 */
function omran_core_get_active_preset_config() {
    static $config = null;
    
    if (null !== $config) {
        return $config;
    }
    
    $preset_id = omran_core_get_theme_preset();
    $presets = omran_core_get_available_presets();
    
    if (isset($presets[$preset_id])) {
        $config = $presets[$preset_id];
    } else {
        // Fallback to industrial if preset not found
        $config = isset($presets['industrial']) ? $presets['industrial'] : false;
    }
    
    /**
     * Filter active preset configuration.
     * 
     * @since 1.0.0
     * 
     * @param array|false $config Preset configuration.
     * @param string       $preset_id Preset identifier.
     */
    return apply_filters('omran_core_active_preset_config', $config, $preset_id);
}

/**
 * Get preset option value
 * 
 * @param string $key Option key (supports dot notation like 'colors.primary').
 * @param mixed  $default Default value.
 * @return mixed Option value.
 */
function omran_core_get_preset_option($key, $default = null) {
    $config = omran_core_get_active_preset_config();
    
    if (!$config) {
        return $default;
    }
    
    // Support dot notation for nested arrays
    $keys = explode('.', $key);
    $value = $config;
    
    foreach ($keys as $k) {
        if (is_array($value) && isset($value[$k])) {
            $value = $value[$k];
        } else {
            return $default;
        }
    }
    
    return $value;
}

/**
 * Load preset functions file if it exists
 * 
 * @param string $preset_id Preset identifier.
 */
function omran_core_load_preset_functions($preset_id) {
    $functions_file = get_template_directory() . '/presets/' . $preset_id . '/functions.php';
    
    if (file_exists($functions_file)) {
        require_once $functions_file;
    }
}

/**
 * Load preset templates
 * 
 * @param string $template_name Template name.
 * @param string $preset_id Preset identifier.
 * @return string|false Template path or false if not found.
 */
function omran_core_locate_preset_template($template_name, $preset_id = '') {
    if (empty($preset_id)) {
        $preset_id = omran_core_get_theme_preset();
    }
    
    $config = omran_core_get_active_preset_config();
    
    if (!$config || !isset($config['templates'][$template_name])) {
        return false;
    }
    
    $template_path = get_template_directory() . '/' . $config['templates'][$template_name];
    
    if (file_exists($template_path)) {
        return $template_path;
    }
    
    return false;
}

/**
 * Initialize preset system
 * 
 * @hook after_setup_theme (priority 10)
 */
function omran_core_init_preset_system() {
    $preset_id = omran_core_get_theme_preset();
    
    // Load preset functions
    omran_core_load_preset_functions($preset_id);
    
    // Apply preset colors to CSS variables
    add_action('wp_head', 'omran_core_output_preset_css_variables', 5);
    
    // Apply preset typography
    add_filter('body_class', 'omran_core_add_preset_typography_classes');
    
    /**
     * Action fired when preset system is initialized.
     * 
     * @since 1.0.0
     * 
     * @param string $preset_id Active preset identifier.
     */
    do_action('omran_core_preset_initialized', $preset_id);
}
add_action('after_setup_theme', 'omran_core_init_preset_system', 10);

/**
 * Output preset CSS variables
 * 
 * @hook wp_head (priority 5)
 */
function omran_core_output_preset_css_variables() {
    $config = omran_core_get_active_preset_config();
    
    if (!$config || !isset($config['colors'])) {
        return;
    }
    
    $colors = $config['colors'];
    $preset_id = $config['id'];
    
    echo '<style id="omran-preset-variables">' . "\n";
    echo ':root {' . "\n";
    
    // Output color variables
    foreach ($colors as $key => $value) {
        $var_name = '--preset-' . str_replace('_', '-', $key);
        echo '    ' . esc_html($var_name) . ': ' . esc_html($value) . ';' . "\n";
    }
    
    // Output typography variables
    if (isset($config['typography'])) {
        $typography = $config['typography'];
        if (isset($typography['font_family'])) {
            echo '    --preset-font-family: "' . esc_html($typography['font_family']) . '", sans-serif;' . "\n";
        }
        if (isset($typography['font_weight'])) {
            echo '    --preset-font-weight: ' . esc_html($typography['font_weight']) . ';' . "\n";
        }
    }
    
    // Output component variables
    if (isset($config['components'])) {
        $components = $config['components'];
        foreach ($components as $key => $value) {
            if (is_string($value) || is_numeric($value)) {
                $var_name = '--preset-' . str_replace('_', '-', $key);
                echo '    ' . esc_html($var_name) . ': ' . esc_html($value) . ';' . "\n";
            }
        }
    }
    
    echo '}' . "\n";
    echo '</style>' . "\n";
}

/**
 * Add preset typography classes to body
 * 
 * @param array $classes Body classes.
 * @return array Modified classes.
 * 
 * @hook body_class
 */
function omran_core_add_preset_typography_classes($classes) {
    $config = omran_core_get_active_preset_config();
    
    if (!$config || !isset($config['typography'])) {
        return $classes;
    }
    
    $typography = $config['typography'];
    
    if (isset($typography['font_family'])) {
        $classes[] = 'font-' . sanitize_html_class($typography['font_family']);
    }
    
    if (isset($typography['font_weight'])) {
        $classes[] = 'font-weight-' . sanitize_html_class($typography['font_weight']);
    }
    
    return $classes;
}

/**
 * Enqueue preset assets
 * 
 * @hook omran_core_enqueue_preset_styles
 */
function omran_core_enqueue_preset_assets($preset_id) {
    $config = omran_core_get_active_preset_config();
    
    if (!$config) {
        return;
    }
    
    // Enqueue preset CSS
    if (isset($config['styles']) && is_array($config['styles'])) {
        foreach ($config['styles'] as $handle => $file) {
            $file_path = get_template_directory() . '/' . $file;
            $file_uri = get_template_directory_uri() . '/' . $file;
            
            if (file_exists($file_path)) {
                $version = filemtime($file_path);
                wp_enqueue_style(
                    'omran-preset-' . $config['id'] . '-' . $handle,
                    $file_uri,
                    array('alomran-tailwind', 'omran-core-base'),
                    $version,
                    'all'
                );
            }
        }
    }
    
    // Enqueue preset JavaScript
    if (isset($config['scripts']) && is_array($config['scripts'])) {
        foreach ($config['scripts'] as $handle => $file) {
            $file_path = get_template_directory() . '/' . $file;
            $file_uri = get_template_directory_uri() . '/' . $file;
            
            if (file_exists($file_path)) {
                $version = filemtime($file_path);
                wp_enqueue_script(
                    'omran-preset-' . $config['id'] . '-' . $handle,
                    $file_uri,
                    array('jquery'),
                    $version,
                    true
                );
            }
        }
    }
}
add_action('omran_core_enqueue_preset_styles', 'omran_core_enqueue_preset_assets');

/**
 * Filter template location to use preset templates
 * 
 * @param string $template Template path.
 * @param string $template_name Template name.
 * @return string Modified template path.
 * 
 * @hook omran_core_section_template
 */
function omran_core_filter_preset_templates($template, $template_name) {
    $preset_template = omran_core_locate_preset_template($template_name);
    
    if ($preset_template) {
        return $preset_template;
    }
    
    return $template;
}
add_filter('omran_core_section_template', 'omran_core_filter_preset_templates', 10, 2);

