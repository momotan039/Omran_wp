<?php
/**
 * Template Name: Testimonials Page
 * The template for displaying the testimonials page
 *
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$testimonials_query = new WP_Query(array(
    'post_type' => 'testimonial',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC'
));
?>

<div class="min-h-screen bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 animate-fade-in-up">
            <h1 class="text-4xl font-bold text-primary mb-4">ماذا يقول عملاؤنا</h1>
            <p class="text-gray-600 text-lg">نفخر بثقة عملائنا فينا</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if ($testimonials_query->have_posts()) : 
                $index = 0;
                while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                    $author = get_post_meta(get_the_ID(), 'testimonial_author', true);
                    $position = get_post_meta(get_the_ID(), 'testimonial_position', true);
            ?>
                <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-xl transition-all duration-300 animate-fade-in-up" style="animation-delay: <?php echo $index * 100; ?>ms">
                    <div class="mb-6">
                        <svg class="w-12 h-12 text-secondary mb-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.996 2.151c-2.432.917-3.996 3.638-3.996 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.997 3.638-3.997 5.849h3.983v10h-9.982z"/>
                        </svg>
                    </div>
                    <div class="text-gray-700 leading-relaxed mb-6">
                        <?php the_content(); ?>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <p class="font-bold text-primary"><?php echo esc_html($author ?: 'عميل'); ?></p>
                        <?php if ($position) : ?>
                            <p class="text-sm text-gray-500"><?php echo esc_html($position); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php 
                $index++;
                endwhile; 
                wp_reset_postdata();
            else : ?>
                <div class="col-span-full text-center text-gray-500 py-8 animate-fade-in-up">
                    لا توجد شهادات متاحة حالياً.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>

