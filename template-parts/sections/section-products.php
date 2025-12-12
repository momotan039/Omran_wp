<?php
/**
 * Products Section Template
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$data = alomran_get_section_data('products');
if (!$data['enable']) {
    return;
}

$featured_products_query = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => $data['count'],
    'meta_query' => array(
        array(
            'key' => 'is_featured',
            'value' => '1',
            'compare' => '='
        )
    )
));

if (!$featured_products_query->have_posts()) {
    return;
}
?>

<section class="py-20 bg-accent">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-end mb-12 animate-fade-in-up">
            <div>
                <h2 class="text-3xl font-bold text-primary mb-2"><?php echo esc_html($data['title']); ?></h2>
                <div class="h-1 w-20 bg-secondary"></div>
            </div>
            <?php if ($data['show_all_link']) : ?>
                <a href="<?php echo esc_url(get_post_type_archive_link('product') ?: home_url('/products')); ?>" class="hidden md:flex items-center text-primary font-bold hover:text-secondary transition">
                    عرض الكل
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php while ($featured_products_query->have_posts()) : $featured_products_query->the_post(); ?>
                <?php get_template_part('template-parts/product-card'); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        
        <?php if ($data['show_all_link']) : ?>
            <div class="mt-8 text-center md:hidden">
                <a href="<?php echo esc_url(get_post_type_archive_link('product') ?: home_url('/products')); ?>" class="inline-flex items-center text-primary font-bold hover:text-secondary transition">
                    عرض الكل
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>




