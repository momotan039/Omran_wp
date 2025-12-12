<?php
/**
 * Industrial Preset - Products Section Layout
 * 
 * @package AlOmran_Preset_Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

// $products_data is passed from section-products.php
?>
<section class="py-20" style="background-color: var(--preset-background);" <?php echo omran_core_get_section_attributes('products'); ?>>
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-end mb-12 animate-fade-in-up">
            <div>
                <h2 class="text-3xl font-bold mb-2" style="color: var(--preset-primary);"><?php echo esc_html($products_data['title']); ?></h2>
                <div class="h-1 w-20" style="background-color: var(--preset-secondary);"></div>
            </div>
            <?php if ($products_data['show_all_link']) : ?>
                <a href="<?php echo esc_url($products_data['all_link_url']); ?>" class="hidden md:flex items-center font-bold hover:opacity-80 transition" style="color: var(--preset-primary);">
                    عرض الكل
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php while ($products_data['query']->have_posts()) : $products_data['query']->the_post(); ?>
                <?php get_template_part('template-parts/product-card'); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        
        <?php if ($products_data['show_all_link']) : ?>
            <div class="mt-8 text-center md:hidden">
                <a href="<?php echo esc_url($products_data['all_link_url']); ?>" class="inline-flex items-center font-bold hover:opacity-80 transition" style="color: var(--preset-primary);">
                    عرض الكل
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

