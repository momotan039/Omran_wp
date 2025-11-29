<?php
/**
 * About Page Main Content Section Template
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$data = alomran_get_section_data('about_content');
if (!$data['enable']) {
    return;
}
?>

<div class="container mx-auto px-4 py-16">
    <div class="flex flex-col md:flex-row gap-16 items-center mb-20">
        <div class="md:w-1/2 animate-slide-in-right">
            <?php if (!empty($data['image'])) : ?>
                <img src="<?php echo esc_url($data['image']); ?>" alt="<?php echo esc_attr($data['title']); ?>" class="rounded-xl shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500 border-4 border-gray-100 w-full" />
            <?php elseif (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array('class' => 'rounded-xl shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500 border-4 border-gray-100')); ?>
            <?php else : ?>
                <img src="https://picsum.photos/id/403/800/600" alt="Factory" class="rounded-xl shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500 border-4 border-gray-100 w-full" />
            <?php endif; ?>
        </div>
        <div class="md:w-1/2 animate-fade-in-up delay-200">
            <?php if (!empty($data['title'])) : ?>
                <h2 class="text-3xl font-bold text-primary mb-6 relative">
                    <?php echo esc_html($data['title']); ?>
                    <span class="absolute bottom-0 right-0 w-20 h-1 bg-secondary translate-y-2"></span>
                </h2>
            <?php endif; ?>
            <div class="prose prose-lg max-w-none text-gray-600 leading-loose text-lg">
                <?php if (!empty($data['content'])) : ?>
                    <?php echo wp_kses_post(wpautop($data['content'])); ?>
                <?php elseif (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

