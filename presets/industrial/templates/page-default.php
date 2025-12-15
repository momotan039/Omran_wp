<?php
/**
 * Default Page Template
 * The default template for displaying pages
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

<div class="min-h-screen py-12 bg-white">
    <div class="container mx-auto px-4">
        <?php
        // Render header
        omran_render_page_header(array(
            'show_thumbnail' => true,
        ));
        
        // Render content
        omran_render_page_content(array(
            'show_thumbnail' => false, // Already shown in header
            'show_title' => false, // Already shown in header
        ));
        ?>
    </div>
</div>

<?php get_footer(); ?>

