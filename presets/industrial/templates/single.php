<?php
/**
 * Single Post Template
 * The default template for displaying single posts
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
    <div class="container mx-auto px-4 max-w-4xl">
        <?php while (have_posts()) : the_post(); ?>
            <?php
            // Render single header
            omran_render_single_header();
            
            // Render single content
            omran_render_single_content();
            ?>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>

