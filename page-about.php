<?php
/**
 * Template Name: About Page
 * The template for displaying the about page
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Get ordered sections from Redux
$sections = alomran_get_ordered_about_sections();
?>

<div class="bg-white">
    <?php
    // Loop through sections in order
    foreach ($sections as $section_id => $section_name) {
        // Map section IDs to template names and data keys
        $template_map = array(
            'header' => array('template' => 'about-header', 'data_key' => 'about_header'),
            'content' => array('template' => 'about-content', 'data_key' => 'about_content'),
            'vision_mission' => array('template' => 'about-vision-mission', 'data_key' => 'about_vision_mission'),
            'stats' => array('template' => 'about-stats', 'data_key' => 'about_stats'),
        );
        
        if (!isset($template_map[$section_id])) {
            continue;
        }
        
        $template_name = $template_map[$section_id]['template'];
        $data_key = $template_map[$section_id]['data_key'];
        
        // Check if section is enabled
        $section_data = alomran_get_section_data($data_key);
        if (isset($section_data['enable']) && !$section_data['enable']) {
            continue;
        }
        
        // Load section template
        get_template_part('template-parts/sections/' . $template_name);
    }
    ?>
</div>

<?php get_footer(); ?>

