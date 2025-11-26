<?php
/**
 * The front page template - Dynamic sections via Redux
 *
 * @package AlOmran
 */

get_header();

// Get ordered sections from Redux
$sections = alomran_get_ordered_sections();
?>

<div class="w-full">
    <?php
    // Loop through sections in order
    foreach ($sections as $section_id => $section_name) {
        // Check if section is enabled
        if (!alomran_is_section_enabled($section_id)) {
            continue;
        }
        
        // Load section template
        $template_file = 'template-parts/sections/section-' . $section_id;
        get_template_part($template_file);
    }
    ?>
</div>

<?php get_footer(); ?>

