<?php
/**
 * The front page template - Dynamic sections via Redux
 *
 * @package AlOmran
 */

get_header();

// Get ordered sections from Redux
$sections = AlOmran_Section_Loader::get_ordered_sections();
?>

<div class="w-full">
    <?php
    // Loop through sections in order
    foreach ($sections as $section_id => $section_name) {
        // Check if section is enabled
        if (!AlOmran_Section_Loader::is_section_enabled($section_id)) {
            continue;
        }
        
        // Load section template using new loader
        AlOmran_Section_Loader::load_section($section_id);
    }
    ?>
</div>

<?php get_footer(); ?>

