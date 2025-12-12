<?php
/**
 * Industrial Preset - Testimonials Section Layout
 * 
 * @package AlOmran_Preset_Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

// $testimonials_data is passed from section-testimonials.php
?>
<section class="py-20 relative overflow-hidden" style="background-color: var(--preset-background);" <?php echo omran_core_get_section_attributes('testimonials'); ?>>
    <div class="absolute top-0 right-0 w-64 h-64 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2" style="background-color: var(--preset-secondary); opacity: 0.1;"></div>

    <div class="container mx-auto px-4 relative z-10">
        <?php if (!empty($testimonials_data['title'])) : ?>
            <h2 class="text-3xl font-bold text-center mb-16 animate-fade-in-up" style="color: var(--preset-primary);"><?php echo esc_html($testimonials_data['title']); ?></h2>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php $idx = 0; while ($testimonials_data['query']->have_posts()) : $testimonials_data['query']->the_post(); 
                $role = get_field('role') ?: '';
                $company = get_field('company') ?: '';
                $content = get_field('content') ?: get_the_content();
            ?>
                <div class="p-8 rounded-xl shadow-sm border flex flex-col md:flex-row gap-6 items-center md:items-start text-center md:text-right hover:border-secondary transition-colors duration-300 animate-slide-in-right delay-<?php echo ($idx + 1) * 200; ?>" style="background-color: var(--preset-background); border-color: var(--preset-secondary);">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('thumbnail', array('class' => 'w-20 h-20 rounded-full object-cover border-4 shadow-md', 'style' => 'border-color: var(--preset-background);')); ?>
                    <?php else : ?>
                        <div class="w-20 h-20 rounded-full flex items-center justify-center border-4 shadow-md" style="background-color: var(--preset-secondary); opacity: 0.2; border-color: var(--preset-background);">
                            <span class="text-2xl" style="color: var(--preset-primary);"><?php echo mb_substr(get_the_title(), 0, 1); ?></span>
                        </div>
                    <?php endif; ?>
                    <div>
                        <p class="italic mb-4" style="color: var(--preset-text-light);">"<?php echo esc_html($content); ?>"</p>
                        <h4 class="font-bold" style="color: var(--preset-primary);"><?php the_title(); ?></h4>
                        <?php if ($role || $company) : ?>
                            <span class="text-xs font-bold uppercase tracking-wider" style="color: var(--preset-secondary);">
                                <?php if ($role) echo esc_html($role); ?>
                                <?php if ($role && $company) echo ' - '; ?>
                                <?php if ($company) echo esc_html($company); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php $idx++; endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

