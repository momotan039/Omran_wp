<?php
/**
 * Industrial Preset - Sectors Section Layout
 * 
 * @package AlOmran_Preset_Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

// $sectors_data is passed from section-sectors.php
$icons = array(
    'residential' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>',
    'industrial' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>',
    'hospitality' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
);
?>
<section class="py-20" style="background-color: var(--preset-background);" <?php echo omran_core_get_section_attributes('sectors'); ?>>
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 animate-fade-in-up">
            <?php if (!empty($sectors_data['title'])) : ?>
                <h2 class="text-3xl font-bold mb-4" style="color: var(--preset-primary);"><?php echo esc_html($sectors_data['title']); ?></h2>
                <div class="h-1 w-20 mx-auto" style="background-color: var(--preset-secondary);"></div>
            <?php endif; ?>
            <?php if (!empty($sectors_data['subtitle'])) : ?>
                <p class="mt-4" style="color: var(--preset-text-light);"><?php echo esc_html($sectors_data['subtitle']); ?></p>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($sectors_data['items'] as $idx => $sector) : ?>
                <?php if (empty($sector['sector_title'])) continue; ?>
                <?php 
                $icon_key = !empty($sector['sector_icon']) ? $sector['sector_icon'] : 'residential';
                $icon = isset($icons[$icon_key]) ? $icons[$icon_key] : $icons['residential'];
                ?>
                <?php 
                $delay_classes = array('delay-100', 'delay-200', 'delay-300', 'delay-400', 'delay-500');
                $delay_class = isset($delay_classes[$idx]) ? $delay_classes[$idx] : 'delay-500';
                ?>
                <div class="p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-t-4 group animate-fade-in-up <?php echo esc_attr($delay_class); ?>" style="background-color: var(--preset-background); border-color: var(--preset-secondary);">
                    <div class="mb-6 group-hover:opacity-80 transition-colors duration-300 transform group-hover:scale-110 origin-right" style="color: var(--preset-primary);">
                        <?php echo $icon; ?>
                    </div>
                    <h3 class="text-xl font-bold mb-3" style="color: var(--preset-text);"><?php echo esc_html($sector['sector_title']); ?></h3>
                    <?php if (!empty($sector['sector_desc'])) : ?>
                        <p class="leading-relaxed text-sm" style="color: var(--preset-text-light);"><?php echo esc_html($sector['sector_desc']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

