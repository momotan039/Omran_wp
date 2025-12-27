<?php
/**
 * Tech Preset - Front Page Template
 *
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="overflow-hidden bg-slate-50">
    <?php
    // Hero Section
    $hero_template = AlOmran_Preset_Loader::locate_template('section-hero', 'sections');
    if ($hero_template) {
        include $hero_template;
    }
    
    // Features Preview Section
    $features_preview_template = AlOmran_Preset_Loader::locate_template('section-features-preview', 'sections');
    if ($features_preview_template) {
        include $features_preview_template;
    }
    
    // Case Study Section
    $case_study_template = AlOmran_Preset_Loader::locate_template('section-case-study', 'sections');
    if ($case_study_template) {
        include $case_study_template;
    }
    
    // Statistics Section
    $stats_template = AlOmran_Preset_Loader::locate_template('section-stats', 'sections');
    if ($stats_template) {
        include $stats_template;
    }
    
    // Testimonials Section
    $testimonials_template = AlOmran_Preset_Loader::locate_template('section-testimonials', 'sections');
    if ($testimonials_template) {
        include $testimonials_template;
    }
    
    // CTA Section
    $cta_template = AlOmran_Preset_Loader::locate_template('section-cta', 'sections');
    if ($cta_template) {
        include $cta_template;
    }
    ?>
</div>

<?php
get_footer();

