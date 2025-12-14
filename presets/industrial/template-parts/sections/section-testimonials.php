<?php
/**
 * Testimonials Section Template
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$data = alomran_get_section_data('testimonials');
if (!$data['enable']) {
    return;
}

$testimonials_query = new WP_Query(array(
    'post_type' => 'testimonial',
    'posts_per_page' => $data['count']
));

if (!$testimonials_query->have_posts()) {
    return;
}
?>

<section class="py-20 relative overflow-hidden" style="background-color: var(--theme-white);">
    <div class="absolute top-0 right-0 w-64 h-64 bg-secondary/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

    <div class="container mx-auto px-4 relative z-10">
        <?php if (!empty($data['title'])) : ?>
            <h2 class="text-3xl font-bold text-center text-primary mb-16 animate-fade-in-up"><?php echo esc_html($data['title']); ?></h2>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php $idx = 0; while ($testimonials_query->have_posts()) : $testimonials_query->the_post(); 
                $role = get_field('role') ?: '';
                $company = get_field('company') ?: '';
                $content = get_field('content') ?: get_the_content();
            ?>
                <div class="p-8 rounded-xl shadow-sm border flex flex-col md:flex-row gap-6 items-center md:items-start text-center md:text-right hover:border-secondary transition-colors duration-300 animate-slide-in-right delay-<?php echo ($idx + 1) * 200; ?>" style="background-color: var(--theme-gray-50); border-color: var(--theme-gray-100);">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('thumbnail', array('class' => 'w-20 h-20 rounded-full object-cover border-4 shadow-md', 'style' => 'border-color: var(--theme-white);')); ?>
                    <?php else : ?>
                        <div class="w-20 h-20 rounded-full bg-secondary/20 flex items-center justify-center border-4 shadow-md" style="border-color: var(--theme-white);">
                            <span class="text-2xl"><?php echo mb_substr(get_the_title(), 0, 1); ?></span>
                        </div>
                    <?php endif; ?>
                    <div>
                        <p class="italic mb-4" style="color: var(--theme-gray-600);">"<?php echo esc_html($content); ?>"</p>
                        <h4 class="font-bold text-primary"><?php the_title(); ?></h4>
                        <?php if ($role || $company) : ?>
                            <span class="text-xs text-secondary font-bold uppercase tracking-wider">
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




