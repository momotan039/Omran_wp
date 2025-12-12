<?php
/**
 * Default Stainless Layout (Fallback)
 * 
 * Used when preset-specific layout is not found.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// $stainless_data is passed from section-stainless.php
?>
<section class="py-20" style="background-color: var(--preset-background);" <?php echo omran_core_get_section_attributes('stainless'); ?>>
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <?php if (!empty($stainless_data['title'])) : ?>
                <h2 class="text-3xl font-bold mb-4" style="color: var(--preset-primary);"><?php echo esc_html($stainless_data['title']); ?></h2>
            <?php endif; ?>
            <?php if (!empty($stainless_data['subtitle'])) : ?>
                <p style="color: var(--preset-text-light);"><?php echo esc_html($stainless_data['subtitle']); ?></p>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($stainless_data['items'] as $item) : ?>
                <?php if (empty($item['feature_text'])) continue; ?>
                <div class="p-6 rounded-lg shadow-sm border" style="background-color: var(--preset-background); border-color: var(--preset-secondary);">
                    <p class="font-bold" style="color: var(--preset-text);"><?php echo esc_html($item['feature_text']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

