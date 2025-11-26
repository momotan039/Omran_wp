<?php
/**
 * Template Name: FAQ Page
 * The template for displaying the FAQ page
 *
 * @package AlOmran
 */

get_header();

$faqs_query = new WP_Query(array(
    'post_type' => 'faq',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
));
?>

<div class="min-h-screen bg-white py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="text-center mb-12 animate-fade-in-up">
            <svg class="mx-auto text-secondary mb-4 animate-bounce w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h1 class="text-3xl md:text-4xl font-bold text-primary mb-6">الأسئلة الشائعة والدعم الفني</h1>
            <div class="relative max-w-lg mx-auto">
                <input 
                    type="text" 
                    id="faq-search"
                    placeholder="ابحث في الأسئلة..." 
                    class="w-full pl-4 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition"
                />
                <svg class="absolute right-4 top-3.5 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>

        <div class="space-y-4">
            <?php if ($faqs_query->have_posts()) : 
                $index = 0;
                while ($faqs_query->have_posts()) : $faqs_query->the_post(); 
            ?>
                <div 
                    class="faq-item border rounded-lg transition-all duration-300 animate-fade-in-up <?php echo $index === 0 ? 'border-secondary bg-blue-50/30' : 'border-gray-200 hover:border-gray-300'; ?>"
                    style="animation-delay: <?php echo $index * 100; ?>ms"
                    data-question="<?php echo esc_attr(strtolower(get_the_title())); ?>"
                    data-answer="<?php echo esc_attr(strtolower(get_the_content())); ?>"
                >
                    <button 
                        class="faq-toggle w-full flex items-center justify-between p-5 text-right focus:outline-none"
                        data-index="<?php echo $index; ?>"
                    >
                        <span class="font-bold text-lg <?php echo $index === 0 ? 'text-secondary' : 'text-gray-700'; ?>">
                            <?php the_title(); ?>
                        </span>
                        <svg class="w-5 h-5 <?php echo $index === 0 ? 'text-secondary' : 'text-gray-400'; ?> faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <?php if ($index === 0) : ?>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            <?php else : ?>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            <?php endif; ?>
                        </svg>
                    </button>
                    <div class="faq-content overflow-hidden transition-all duration-300 <?php echo $index === 0 ? 'max-h-48 opacity-100' : 'max-h-0 opacity-0'; ?>">
                        <div class="p-5 pt-0 text-gray-600 leading-relaxed border-t border-dashed border-gray-200 mt-2 mx-5">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            <?php 
                $index++;
                endwhile; 
                wp_reset_postdata();
            else : ?>
                <div class="text-center text-gray-500 py-8 animate-fade-in-up">
                    لا توجد أسئلة شائعة متاحة حالياً.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>

