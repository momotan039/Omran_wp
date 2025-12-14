<?php
/**
 * About Page Stats Section Template
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$data = alomran_get_section_data('about_stats');
if (!$data['enable'] || empty($data['stats'])) {
    return;
}
?>

<div class="container mx-auto px-4 py-16">
    <div id="about-stats-section" class="rounded-2xl p-12 text-center grid grid-cols-1 md:grid-cols-3 gap-8 animate-scale-in delay-200" style="background-color: var(--theme-primary); color: var(--theme-white);">
        <?php foreach ($data['stats'] as $index => $stat) : ?>
            <?php if (!empty($stat['number']) && !empty($stat['label'])) : ?>
                <?php
                // Extract numeric value from stat number (remove +, %, etc.)
                $numeric_value = preg_replace('/[^0-9.]/', '', $stat['number']);
                $has_suffix = preg_replace('/[0-9.]/', '', $stat['number']); // Get +, %, etc.
                ?>
                <div class="stat-item hover:scale-110 transition-transform duration-300" data-stat-index="<?php echo esc_attr($index); ?>">
                    <div class="text-5xl md:text-6xl font-black mb-3 stat-number" 
                         data-target="<?php echo esc_attr($numeric_value); ?>"
                         data-suffix="<?php echo esc_attr($has_suffix); ?>"
                         data-duration="2000">
                        <span class="stat-value">0</span><span class="stat-suffix"><?php echo esc_html($has_suffix); ?></span>
                    </div>
                    <div class="stat-label">
                        <?php echo esc_html($stat['label']); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

