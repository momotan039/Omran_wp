<?php
/**
 * Section Loader Helper
 * DRY: Reusable function to load section templates
 *
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load section template with data check
 * DRY: Centralized section loading logic
 * 
 * @param string $section_id Section ID (e.g., 'about-header')
 * @param string $template_name Template name (e.g., 'about-header')
 * @param string $data_key Redux data key (e.g., 'about_header')
 * @param string $subdirectory Subdirectory in template-parts (default: 'sections')
 * @return bool True if loaded, false otherwise
 */
function omran_load_section($section_id, $template_name, $data_key, $subdirectory = 'sections') {
    // Always load template part - let the template itself decide what to show
    // This allows templates to show fallback content even if section is disabled
    // This will search in: presets/industrial/template-parts/{subdirectory}/{template_name}.php
    AlOmran_Preset_Loader::get_template_part($template_name, '', array(), $subdirectory);
    
    return true;
}

/**
 * Render section with wrapper
 * DRY: Consistent section rendering
 * 
 * @param string $section_id Section ID
 * @param string $template_name Template name
 * @param string $data_key Redux data key
 * @param string $wrapper_class Optional wrapper CSS classes
 * @param string $subdirectory Subdirectory (default: 'sections')
 */
function omran_render_section($section_id, $template_name, $data_key, $wrapper_class = '', $subdirectory = 'sections') {
    $data = alomran_get_section_data($data_key);
    
    if (isset($data['enable']) && !$data['enable']) {
        return;
    }
    
    if ($wrapper_class) {
        echo '<div class="' . esc_attr($wrapper_class) . '">';
    }
    
    omran_load_section($section_id, $template_name, $data_key, $subdirectory);
    
    if ($wrapper_class) {
        echo '</div>';
    }
}

