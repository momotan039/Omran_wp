<?php
/**
 * Default Risks Layout (Fallback)
 * 
 * Used when preset-specific layout is not found.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// $risks_data is passed from section-risks.php
?>
<section class="py-16" style="background-color: var(--preset-accent);" <?php echo omran_core_get_section_attributes('risks'); ?>>
    <div class="container mx-auto px-4">
        <div class="rounded-2xl shadow-xl p-8 md:p-12 border-t-8" style="background-color: var(--preset-background); border-color: var(--preset-primary);">
            <?php if (!empty($risks_data['title'])) : ?>
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold mb-4" style="color: var(--preset-primary);"><?php echo esc_html($risks_data['title']); ?></h2>
                </div>
            <?php endif; ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($risks_data['items'] as $risk) : ?>
                    <?php if (empty($risk['risk_title'])) continue; ?>
                    <div class="flex items-start gap-4 p-4 rounded-lg">
                        <div class="p-3 rounded-full flex-shrink-0" style="background-color: var(--preset-accent); color: var(--preset-background);">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-2" style="color: var(--preset-primary);"><?php echo esc_html($risk['risk_title']); ?></h4>
                            <?php if (!empty($risk['risk_desc'])) : ?>
                                <p class="text-sm" style="color: var(--preset-text-light);"><?php echo esc_html($risk['risk_desc']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

