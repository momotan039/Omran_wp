<?php
/**
 * Template Name: Terms of Service Page
 * The template for displaying the terms of service page
 *
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Load common components (DRY)
omran_load_common_components();
?>

<div class="min-h-screen bg-white py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        <?php
        omran_render_page_header(array(
            'title' => 'شروط الخدمة',
            'subtitle' => 'آخر تحديث: ' . date_i18n('j F Y'),
        ));
        
        omran_render_page_content(array(
            'show_thumbnail' => false,
            'show_title' => false,
        ));
        ?>
    </div>
</div>

<?php get_footer(); ?>

