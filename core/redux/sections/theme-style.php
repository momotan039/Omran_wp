<?php
/**
 * Theme Style Panel - Dynamic Preset Switching
 * 
 * Provides a comprehensive theme switching interface with preview,
 * dynamic preset detection, and instant updates.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// Only load in admin
if (!is_admin()) {
    return;
}

$opt_name = 'alomran_options';

// Get available presets dynamically
$available_presets = array();
if (function_exists('omran_core_get_available_presets')) {
    $presets = omran_core_get_available_presets();
    foreach ($presets as $preset_id => $preset_config) {
        $available_presets[$preset_id] = isset($preset_config['name']) 
            ? $preset_config['name'] 
            : ucfirst(str_replace('-', ' ', $preset_id));
    }
} else {
    // Fallback to default presets
    $available_presets = array(
        'industrial'    => __('Industrial', 'alomran'),
        'food-beverage' => __('Food & Beverage', 'alomran'),
        'tech-devices' => __('Technology & Devices', 'alomran'),
    );
}

// Get current preset
$current_preset = function_exists('omran_core_get_theme_preset') 
    ? omran_core_get_theme_preset() 
    : 'industrial';

// Get preset config for preview
$preset_config = function_exists('omran_core_get_active_preset_config') 
    ? omran_core_get_active_preset_config() 
    : false;

Redux::setSection($opt_name, array(
    'title'      => __('Theme Style', 'alomran'),
    'id'         => 'theme_style',
    'icon'       => 'el el-brush',
    'desc'       => __('Switch between theme presets and customize colors, typography, and layout. Changes apply instantly.', 'alomran'),
    'priority'   => 1, // Show at the top
    'fields' => array(
        // Preset Selector with Preview
        array(
            'id'       => 'theme_preset',
            'type'     => 'select',
            'title'    => __('Select Theme Preset', 'alomran'),
            'subtitle' => __('Choose a preset that matches your industry. You can customize colors and settings below.', 'alomran'),
            'options'  => $available_presets,
            'default'  => $current_preset,
            'desc'     => '<div id="omran-preset-preview" style="margin-top: 15px; padding: 15px; background: #f5f5f5; border-radius: 4px; display: none;">
                            <h4 style="margin-top: 0;">' . __('Preset Preview', 'alomran') . '</h4>
                            <div id="omran-preset-preview-content"></div>
                            <button type="button" id="omran-apply-preset" class="button button-primary" style="margin-top: 10px;">
                                ' . __('Apply Preset', 'alomran') . '
                            </button>
                            <button type="button" id="omran-preview-preset" class="button" style="margin-top: 10px; margin-left: 10px;">
                                ' . __('Preview Changes', 'alomran') . '
                            </button>
                          </div>',
        ),
        
        // Preset Info Section
        array(
            'id'       => 'preset_info_section',
            'type'     => 'section',
            'title'    => __('Preset Information', 'alomran'),
            'indent'   => true,
        ),
        array(
            'id'       => 'preset_info',
            'type'     => 'raw',
            'title'    => __('Current Preset', 'alomran'),
            'content'  => '<div id="omran-preset-info">
                            <p><strong>' . __('Preset:', 'alomran') . '</strong> <span id="preset-name">' . esc_html($current_preset) . '</span></p>
                            <p id="preset-description" style="color: #666; font-style: italic;"></p>
                            <div id="preset-colors-preview" style="display: flex; gap: 10px; margin-top: 10px;">
                                <div class="color-preview" style="width: 50px; height: 50px; border-radius: 4px; border: 1px solid #ddd;"></div>
                                <div class="color-preview" style="width: 50px; height: 50px; border-radius: 4px; border: 1px solid #ddd;"></div>
                                <div class="color-preview" style="width: 50px; height: 50px; border-radius: 4px; border: 1px solid #ddd;"></div>
                            </div>
                          </div>',
        ),
        
        // Color Customization Section
        array(
            'id'       => 'preset_colors_section',
            'type'     => 'section',
            'title'    => __('Color Customization', 'alomran'),
            'subtitle' => __('Customize colors for the active preset. Changes apply instantly.', 'alomran'),
            'indent'   => true,
        ),
        array(
            'id'       => 'preset_primary_color',
            'type'     => 'color',
            'title'    => __('Primary Color', 'alomran'),
            'subtitle' => __('Main brand color used throughout the theme', 'alomran'),
            'default'  => $preset_config && isset($preset_config['colors']['primary']) 
                ? $preset_config['colors']['primary'] 
                : '#2c5530',
            'validate' => 'color',
            'transparent' => false,
        ),
        array(
            'id'       => 'preset_secondary_color',
            'type'     => 'color',
            'title'    => __('Secondary Color', 'alomran'),
            'subtitle' => __('Secondary brand color for accents and highlights', 'alomran'),
            'default'  => $preset_config && isset($preset_config['colors']['secondary']) 
                ? $preset_config['colors']['secondary'] 
                : '#4a7c59',
            'validate' => 'color',
            'transparent' => false,
        ),
        array(
            'id'       => 'preset_accent_color',
            'type'     => 'color',
            'title'    => __('Accent Color', 'alomran'),
            'subtitle' => __('Used for buttons, links, and call-to-action elements', 'alomran'),
            'default'  => $preset_config && isset($preset_config['colors']['accent']) 
                ? $preset_config['colors']['accent'] 
                : '#f97316',
            'validate' => 'color',
            'transparent' => false,
        ),
        array(
            'id'       => 'preset_background_color',
            'type'     => 'color',
            'title'    => __('Background Color', 'alomran'),
            'subtitle' => __('Main background color', 'alomran'),
            'default'  => $preset_config && isset($preset_config['colors']['background']) 
                ? $preset_config['colors']['background'] 
                : '#ffffff',
            'validate' => 'color',
            'transparent' => false,
        ),
        array(
            'id'       => 'preset_text_color',
            'type'     => 'color',
            'title'    => __('Text Color', 'alomran'),
            'subtitle' => __('Main text color', 'alomran'),
            'default'  => $preset_config && isset($preset_config['colors']['text']) 
                ? $preset_config['colors']['text'] 
                : '#1f2937',
            'validate' => 'color',
            'transparent' => false,
        ),
        
        // Typography Section
        array(
            'id'       => 'preset_typography_section',
            'type'     => 'section',
            'title'    => __('Typography Settings', 'alomran'),
            'indent'   => true,
        ),
        array(
            'id'       => 'preset_font_family',
            'type'     => 'select',
            'title'    => __('Font Family', 'alomran'),
            'subtitle' => __('Choose the primary font for your theme', 'alomran'),
            'options'  => array(
                'Cairo'    => 'Cairo',
                'Tajawal'  => 'Tajawal',
                'Almarai'  => 'Almarai',
                'Changa'   => 'Changa',
                'Amiri'    => 'Amiri',
                'Roboto'   => 'Roboto',
                'Open Sans' => 'Open Sans',
            ),
            'default'  => $preset_config && isset($preset_config['typography']['font_family']) 
                ? $preset_config['typography']['font_family'] 
                : 'Cairo',
        ),
        array(
            'id'       => 'preset_font_weight',
            'type'     => 'select',
            'title'    => __('Font Weight', 'alomran'),
            'subtitle' => __('Base font weight for body text', 'alomran'),
            'options'  => array(
                '300' => __('Light', 'alomran'),
                '400' => __('Normal', 'alomran'),
                '500' => __('Medium', 'alomran'),
                '600' => __('Semi Bold', 'alomran'),
                '700' => __('Bold', 'alomran'),
                '800' => __('Extra Bold', 'alomran'),
                '900' => __('Black', 'alomran'),
            ),
            'default'  => $preset_config && isset($preset_config['typography']['font_weight']) 
                ? $preset_config['typography']['font_weight'] 
                : '400',
        ),
        
        // Layout Settings
        array(
            'id'       => 'preset_layout_section',
            'type'     => 'section',
            'title'    => __('Layout Settings', 'alomran'),
            'indent'   => true,
        ),
        array(
            'id'       => 'preset_container_width',
            'type'     => 'select',
            'title'    => __('Container Width', 'alomran'),
            'subtitle' => __('Maximum width of the main content container', 'alomran'),
            'options'  => array(
                'full'      => __('Full Width', 'alomran') . ' (100%)',
                'wide'      => __('Wide', 'alomran') . ' (1400px)',
                'standard'  => __('Standard', 'alomran') . ' (1200px)',
                'narrow'    => __('Narrow', 'alomran') . ' (960px)',
            ),
            'default'  => $preset_config && isset($preset_config['layout']['container_width']) 
                ? $preset_config['layout']['container_width'] 
                : 'standard',
        ),
        array(
            'id'       => 'preset_content_layout',
            'type'     => 'select',
            'title'    => __('Content Layout', 'alomran'),
            'subtitle' => __('Layout style for content areas', 'alomran'),
            'options'  => array(
                'boxed'     => __('Boxed', 'alomran'),
                'fullwidth' => __('Full Width', 'alomran'),
            ),
            'default'  => $preset_config && isset($preset_config['layout']['content_layout']) 
                ? $preset_config['layout']['content_layout'] 
                : 'boxed',
        ),
        array(
            'id'       => 'preset_header_style',
            'type'     => 'select',
            'title'    => __('Header Style', 'alomran'),
            'subtitle' => __('Visual style of the header', 'alomran'),
            'options'  => array(
                'default'     => __('Default', 'alomran'),
                'transparent' => __('Transparent', 'alomran'),
                'minimal'     => __('Minimal', 'alomran'),
                'centered'    => __('Centered', 'alomran'),
            ),
            'default'  => $preset_config && isset($preset_config['layout']['header_style']) 
                ? $preset_config['layout']['header_style'] 
                : 'default',
        ),
        array(
            'id'       => 'preset_header_sticky',
            'type'     => 'switch',
            'title'    => __('Sticky Header', 'alomran'),
            'subtitle' => __('Keep header visible when scrolling', 'alomran'),
            'default'  => $preset_config && isset($preset_config['layout']['header_sticky']) 
                ? $preset_config['layout']['header_sticky'] 
                : true,
        ),
        array(
            'id'       => 'preset_footer_style',
            'type'     => 'select',
            'title'    => __('Footer Style', 'alomran'),
            'subtitle' => __('Visual style of the footer', 'alomran'),
            'options'  => array(
                'default'  => __('Default', 'alomran'),
                'minimal'  => __('Minimal', 'alomran'),
                'centered' => __('Centered', 'alomran'),
                'dark'     => __('Dark', 'alomran'),
            ),
            'default'  => $preset_config && isset($preset_config['layout']['footer_style']) 
                ? $preset_config['layout']['footer_style'] 
                : 'default',
        ),
        
        // Advanced Settings
        array(
            'id'       => 'preset_advanced_section',
            'type'     => 'section',
            'title'    => __('Advanced Settings', 'alomran'),
            'subtitle' => __('Advanced customization options', 'alomran'),
            'indent'   => true,
        ),
        array(
            'id'       => 'preset_rebuild_styles',
            'type'     => 'button_set',
            'title'    => __('Rebuild Styles', 'alomran'),
            'subtitle' => __('Regenerate CSS files with new color values', 'alomran'),
            'options'  => array(
                'auto'   => __('Automatic', 'alomran'),
                'manual' => __('Manual', 'alomran'),
            ),
            'default'  => 'auto',
        ),
        array(
            'id'       => 'preset_update_tailwind',
            'type'     => 'switch',
            'title'    => __('Update Tailwind Config', 'alomran'),
            'subtitle' => __('Automatically update Tailwind configuration with preset colors', 'alomran'),
            'default'  => true,
        ),
    ),
));

