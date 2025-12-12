<?php
/**
 * Preset Switcher - AJAX Handler and Dynamic Updates
 * 
 * Handles preset switching, color injection, and style rebuilding.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * AJAX Handler: Switch Preset
 * 
 * @hook wp_ajax_omran_switch_preset
 */
function omran_core_ajax_switch_preset() {
    // Security check
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => __('Insufficient permissions', 'alomran')));
        return;
    }
    
    check_ajax_referer('omran_switch_preset', 'nonce');
    
    $preset_id = isset($_POST['preset_id']) ? sanitize_text_field($_POST['preset_id']) : '';
    $colors = isset($_POST['colors']) ? $_POST['colors'] : array();
    
    if (empty($preset_id)) {
        wp_send_json_error(array('message' => __('Preset ID is required', 'alomran')));
        return;
    }
    
    // Get preset config
    $presets = omran_core_get_available_presets();
    if (!isset($presets[$preset_id])) {
        wp_send_json_error(array('message' => __('Preset not found', 'alomran')));
        return;
    }
    
    $preset_config = $presets[$preset_id];
    
    // Update Redux options
    $options = get_option('alomran_options', array());
    
    // Set preset
    $options['theme_preset'] = $preset_id;
    
    // Update colors if provided
    if (!empty($colors) && is_array($colors)) {
        foreach ($colors as $key => $value) {
            $color_key = 'preset_' . $preset_id . '_' . $key;
            $options[$color_key] = sanitize_hex_color($value);
        }
    } else {
        // Use preset default colors
        if (isset($preset_config['colors'])) {
            foreach ($preset_config['colors'] as $key => $value) {
                $color_key = 'preset_' . $preset_id . '_' . $key;
                $options[$color_key] = $value;
            }
        }
    }
    
    // Update layout settings from preset
    if (isset($preset_config['layout'])) {
        foreach ($preset_config['layout'] as $key => $value) {
            $layout_key = 'preset_' . str_replace('_', '_', $key);
            $options[$layout_key] = $value;
        }
    }
    
    // Update typography from preset
    if (isset($preset_config['typography'])) {
        foreach ($preset_config['typography'] as $key => $value) {
            $typography_key = 'preset_' . str_replace('_', '_', $key);
            $options[$typography_key] = $value;
        }
    }
    
    // Save options
    update_option('alomran_options', $options);
    
    // Update Tailwind config if enabled
    $update_tailwind = isset($_POST['update_tailwind']) && $_POST['update_tailwind'] === 'true';
    if ($update_tailwind) {
        omran_core_update_tailwind_config($preset_config);
    }
    
    // Rebuild styles if needed
    $rebuild_styles = isset($_POST['rebuild_styles']) && $_POST['rebuild_styles'] === 'true';
    if ($rebuild_styles) {
        omran_core_rebuild_preset_styles($preset_id, $preset_config);
    }
    
    // Clear cache
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush();
    }
    
    wp_send_json_success(array(
        'message' => __('Preset applied successfully', 'alomran'),
        'preset' => $preset_id,
        'config' => $preset_config,
    ));
}
add_action('wp_ajax_omran_switch_preset', 'omran_core_ajax_switch_preset');

/**
 * AJAX Handler: Get Preset Preview
 * 
 * @hook wp_ajax_omran_get_preset_preview
 */
function omran_core_ajax_get_preset_preview() {
    // Security check
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => __('Insufficient permissions', 'alomran')));
        return;
    }
    
    check_ajax_referer('omran_get_preset_preview', 'nonce');
    
    $preset_id = isset($_POST['preset_id']) ? sanitize_text_field($_POST['preset_id']) : '';
    
    if (empty($preset_id)) {
        wp_send_json_error(array('message' => __('Preset ID is required', 'alomran')));
        return;
    }
    
    $presets = omran_core_get_available_presets();
    if (!isset($presets[$preset_id])) {
        wp_send_json_error(array('message' => __('Preset not found', 'alomran')));
        return;
    }
    
    $preset_config = $presets[$preset_id];
    
    // Build preview HTML
    $preview_html = '<div class="preset-preview">';
    $preview_html .= '<h4>' . esc_html($preset_config['name']) . '</h4>';
    
    if (isset($preset_config['description'])) {
        $preview_html .= '<p>' . esc_html($preset_config['description']) . '</p>';
    }
    
    // Color preview
    if (isset($preset_config['colors'])) {
        $preview_html .= '<div class="color-preview" style="display: flex; gap: 10px; margin-top: 15px;">';
        $color_keys = array('primary', 'secondary', 'accent');
        foreach ($color_keys as $key) {
            if (isset($preset_config['colors'][$key])) {
                $color = $preset_config['colors'][$key];
                $preview_html .= '<div style="width: 60px; height: 60px; background: ' . esc_attr($color) . '; border-radius: 4px; border: 1px solid #ddd;" title="' . esc_attr(ucfirst($key)) . '"></div>';
            }
        }
        $preview_html .= '</div>';
    }
    
    // Typography preview
    if (isset($preset_config['typography'])) {
        $typography = $preset_config['typography'];
        $preview_html .= '<div style="margin-top: 15px;">';
        $preview_html .= '<strong>' . __('Typography:', 'alomran') . '</strong> ';
        if (isset($typography['font_family'])) {
            $preview_html .= esc_html($typography['font_family']);
        }
        if (isset($typography['font_weight'])) {
            $preview_html .= ' (' . esc_html($typography['font_weight']) . ')';
        }
        $preview_html .= '</div>';
    }
    
    $preview_html .= '</div>';
    
    wp_send_json_success(array(
        'preview' => $preview_html,
        'config' => $preset_config,
    ));
}
add_action('wp_ajax_omran_get_preset_preview', 'omran_core_ajax_get_preset_preview');

/**
 * Update Tailwind configuration with preset colors
 * 
 * @param array $preset_config Preset configuration array.
 * @return bool True on success, false on failure.
 */
function omran_core_update_tailwind_config($preset_config) {
    if (!isset($preset_config['colors'])) {
        return false;
    }
    
    $tailwind_config_path = get_template_directory() . '/tailwind.config.js';
    
    if (!file_exists($tailwind_config_path)) {
        return false;
    }
    
    // Read current config
    $config_content = file_get_contents($tailwind_config_path);
    
    // Extract colors from preset
    $colors = $preset_config['colors'];
    $primary = isset($colors['primary']) ? $colors['primary'] : '#2c5530';
    $secondary = isset($colors['secondary']) ? $colors['secondary'] : '#4a7c59';
    $accent = isset($colors['accent']) ? $colors['accent'] : '#f97316';
    
    // Update primary color (handle both formats)
    $config_content = preg_replace(
        "/(primary:\s*['\"])#[^'\"]+(['\"])/",
        '$1' . $primary . '$2',
        $config_content
    );
    
    // Update secondary color
    $config_content = preg_replace(
        "/(secondary:\s*['\"])#[^'\"]+(['\"])/",
        '$1' . $secondary . '$2',
        $config_content
    );
    
    // Update accent color
    $config_content = preg_replace(
        "/(accent:\s*['\"])#[^'\"]+(['\"])/",
        '$1' . $accent . '$2',
        $config_content
    );
    
    // If colors don't exist, add them to the extend.colors section
    if (strpos($config_content, 'primary:') === false) {
        // Find the colors section and add primary, secondary, accent
        $config_content = preg_replace(
            "/(colors:\s*\{)/",
            "$1\n        primary: '{$primary}',\n        secondary: '{$secondary}',\n        accent: '{$accent}',",
            $config_content
        );
    }
    
    // Write updated config
    $result = file_put_contents($tailwind_config_path, $config_content);
    
    /**
     * Action fired after Tailwind config is updated.
     * 
     * @since 1.0.0
     * 
     * @param array $preset_config Preset configuration.
     * @param bool  $result Whether update was successful.
     */
    do_action('omran_core_tailwind_config_updated', $preset_config, $result !== false);
    
    return $result !== false;
}

/**
 * Rebuild preset styles
 * 
 * @param string $preset_id Preset identifier.
 * @param array  $preset_config Preset configuration.
 * @return bool True on success, false on failure.
 */
function omran_core_rebuild_preset_styles($preset_id, $preset_config) {
    if (!isset($preset_config['colors'])) {
        return false;
    }
    
    $preset_css_path = get_template_directory() . '/presets/' . $preset_id . '/assets/css/preset.css';
    
    // If preset CSS doesn't exist, create it
    if (!file_exists($preset_css_path)) {
        $preset_dir = dirname($preset_css_path);
        if (!is_dir($preset_dir)) {
            wp_mkdir_p($preset_dir);
        }
    }
    
    // Generate CSS with updated colors
    $css = "/* Preset: {$preset_id} - Auto-generated */\n\n";
    $css .= ":root {\n";
    
    foreach ($preset_config['colors'] as $key => $value) {
        $var_name = '--preset-' . str_replace('_', '-', $key);
        $css .= "    {$var_name}: {$value};\n";
    }
    
    $css .= "}\n";
    
    // Write CSS file
    file_put_contents($preset_css_path, $css);
    
    return true;
}

/**
 * Enqueue preset switcher scripts in admin
 * 
 * @hook admin_enqueue_scripts
 */
function omran_core_enqueue_preset_switcher_scripts($hook) {
    // Only load on Redux options page
    if ($hook !== 'toplevel_page_alomran-options') {
        return;
    }
    
    wp_enqueue_script(
        'omran-preset-switcher',
        get_template_directory_uri() . '/core/assets/js/preset-switcher.js',
        array('jquery', 'redux-js'),
        OMRAN_CORE_VERSION,
        true
    );
    
    wp_localize_script('omran-preset-switcher', 'omranPresetSwitcher', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('omran_switch_preset'),
        'previewNonce' => wp_create_nonce('omran_get_preset_preview'),
        'strings' => array(
            'applying' => __('Applying preset...', 'alomran'),
            'applied' => __('Preset applied successfully!', 'alomran'),
            'error' => __('Error applying preset. Please try again.', 'alomran'),
            'loading' => __('Loading preview...', 'alomran'),
        ),
    ));
    
    wp_enqueue_style(
        'omran-preset-switcher',
        get_template_directory_uri() . '/core/assets/css/preset-switcher.css',
        array(),
        OMRAN_CORE_VERSION
    );
}
add_action('admin_enqueue_scripts', 'omran_core_enqueue_preset_switcher_scripts');

/**
 * Handle frontend preset preview
 * 
 * @hook template_redirect
 */
function omran_core_handle_preset_preview() {
    if (!isset($_GET['omran_preview']) || !current_user_can('manage_options')) {
        return;
    }
    
    $preview_preset = sanitize_text_field($_GET['omran_preview']);
    
    // Temporarily set preset for preview
    add_filter('omran_core_theme_preset', function() use ($preview_preset) {
        return $preview_preset;
    }, 999);
    
    // Add preview banner
    add_action('wp_footer', function() use ($preview_preset) {
        echo '<div style="position: fixed; top: 0; left: 0; right: 0; background: #ff6b6b; color: white; padding: 10px; text-align: center; z-index: 99999; font-weight: bold;">
                ' . sprintf(__('Preview Mode: %s Preset', 'alomran'), esc_html($preview_preset)) . '
                <a href="' . esc_url(remove_query_arg('omran_preview')) . '" style="color: white; text-decoration: underline; margin-left: 20px;">' . __('Exit Preview', 'alomran') . '</a>
              </div>';
    });
}
add_action('template_redirect', 'omran_core_handle_preset_preview', 1);

