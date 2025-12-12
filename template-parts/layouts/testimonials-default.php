<?php
/**
 * Default Testimonials Layout (Fallback)
 * 
 * Used when preset-specific layout is not found.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// $testimonials_data is passed from section-testimonials.php
?>
<section class="py-20" style="background-color: var(--preset-background);" <?php echo omran_core_get_section_attributes('testimonials'); ?>>
    <div class="container mx-auto px-4">
        <?php if (!empty($testimonials_data['title'])) : ?>
            <h2 class="text-3xl font-bold text-center mb-16" style="color: var(--preset-primary);"><?php echo esc_html($testimonials_data['title']); ?></h2>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php while ($testimonials_data['query']->have_posts()) : $testimonials_data['query']->the_post(); 
                $role = get_field('role') ?: '';
                $company = get_field('company') ?: '';
                $content = get_field('content') ?: get_the_content();
            ?>
                <div class="p-8 rounded-xl shadow-sm border" style="background-color: var(--preset-background); border-color: var(--preset-secondary);">
                    <p class="italic mb-4" style="color: var(--preset-text-light);">"<?php echo esc_html($content); ?>"</p>
                    <h4 class="font-bold" style="color: var(--preset-primary);"><?php the_title(); ?></h4>
                    <?php if ($role || $company) : ?>
                        <span class="text-xs" style="color: var(--preset-secondary);">
                            <?php if ($role) echo esc_html($role); ?>
                            <?php if ($role && $company) echo ' - '; ?>
                            <?php if ($company) echo esc_html($company); ?>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

