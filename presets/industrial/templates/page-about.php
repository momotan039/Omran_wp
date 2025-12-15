<?php
/**
 * Template Name: About Page
 * The template for displaying the about page
 *
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Load common components (DRY) - This loads section-loader.php automatically
omran_load_common_components();

// Ensure section-loader.php is loaded
if (!function_exists('omran_load_section')) {
    $preset_dir = AlOmran_Preset_Loader::get_preset_dir('industrial');
    if ($preset_dir) {
        $section_loader = trailingslashit($preset_dir) . 'template-parts/common/section-loader.php';
        if (file_exists($section_loader)) {
            require_once $section_loader;
        }
    }
}

// Get ordered sections from Redux
$sections = alomran_get_ordered_about_sections();

// Fallback: If no sections from Redux, use default order
if (empty($sections) || !is_array($sections)) {
    $sections = array(
        'header' => 'Header',
        'content' => 'Content',
        'vision_mission' => 'Vision & Mission',
        'stats' => 'Stats',
    );
}

// Section mapping (DRY: Centralized configuration)
$section_map = array(
    'header' => array('template' => 'about-header', 'data_key' => 'about_header'),
    'content' => array('template' => 'about-content', 'data_key' => 'about_content'),
    'vision_mission' => array('template' => 'about-vision-mission', 'data_key' => 'about_vision_mission'),
    'stats' => array('template' => 'about-stats', 'data_key' => 'about_stats'),
);
?>

<div class="bg-white">
    <?php
    // Debug: Log sections (only in development)
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('About Page Sections: ' . print_r($sections, true));
        error_log('Section Map: ' . print_r($section_map, true));
    }
    
    // Always load sections - use fallback if no order from Redux
    $sections_to_load = !empty($sections) && is_array($sections) ? $sections : array_keys($section_map);
    
    // Loop through sections in order
    foreach ($sections_to_load as $section_id => $section_name) {
        // Handle both array formats: ['header' => 'header'] or ['header', 'content']
        if (is_numeric($section_id)) {
            $section_id = $section_name;
        }
        
        if (!isset($section_map[$section_id])) {
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log('Section not in map: ' . $section_id);
            }
            continue;
        }
        
        $config = $section_map[$section_id];
        
        // Debug: Log section loading
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log(sprintf('Loading section: %s | Template: %s | Data Key: %s', 
                $section_id, 
                $config['template'], 
                $config['data_key']
            ));
        }
        
        // Load section - try multiple methods
        $template_loaded = false;
        
        // Method 1: Using omran_load_section
        if (function_exists('omran_load_section')) {
            omran_load_section($section_id, $config['template'], $config['data_key'], 'sections');
            $template_loaded = true;
        }
        
        // Method 2: Using preset loader
        if (!$template_loaded) {
            AlOmran_Preset_Loader::get_template_part($config['template'], '', array(), 'sections');
            $template_loaded = true;
        }
        
        // Method 3: Direct include (final fallback)
        if (!$template_loaded) {
            $preset_dir = AlOmran_Preset_Loader::get_preset_dir('industrial');
            if ($preset_dir) {
                $direct_path = trailingslashit($preset_dir) . 'template-parts/sections/' . $config['template'] . '.php';
                if (file_exists($direct_path)) {
                    include $direct_path;
                } elseif (defined('WP_DEBUG') && WP_DEBUG) {
                    error_log('Failed to load template: ' . $direct_path);
                }
            }
        }
    }
    ?>
</div>

<?php get_footer(); ?>

