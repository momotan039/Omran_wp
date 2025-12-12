<?php
/**
 * Default Sectors Layout (Fallback)
 * 
 * Used when preset-specific layout is not found.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// $sectors_data is passed from section-sectors.php
?>
<section class="py-20" style="background-color: var(--preset-background);" <?php echo omran_core_get_section_attributes('sectors'); ?>>
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <?php if (!empty($sectors_data['title'])) : ?>
                <h2 class="text-3xl font-bold mb-4" style="color: var(--preset-primary);"><?php echo esc_html($sectors_data['title']); ?></h2>
            <?php endif; ?>
            <?php if (!empty($sectors_data['subtitle'])) : ?>
                <p class="mt-4" style="color: var(--preset-text-light);"><?php echo esc_html($sectors_data['subtitle']); ?></p>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($sectors_data['items'] as $sector) : ?>
                <?php if (empty($sector['sector_title'])) continue; ?>
                <div class="p-8 rounded-xl shadow-lg border-t-4" style="background-color: var(--preset-background); border-color: var(--preset-secondary);">
                    <h3 class="text-xl font-bold mb-3" style="color: var(--preset-text);"><?php echo esc_html($sector['sector_title']); ?></h3>
                    <?php if (!empty($sector['sector_desc'])) : ?>
                        <p class="text-sm" style="color: var(--preset-text-light);"><?php echo esc_html($sector['sector_desc']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

