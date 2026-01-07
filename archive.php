<?php
/**
 * Archive Template
 * The default template for displaying archives
 * DRY: Uses common components for consistency
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

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <?php
        // Render archive header
        omran_render_archive_header();
        
        // Render archive loop
        omran_render_archive_loop();
        ?>
    </div>
</div>

<?php get_footer(); ?>

