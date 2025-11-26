<?php
/**
 * The template for displaying news archives
 *
 * @package AlOmran
 */

get_header();
?>

<div class="bg-gray-50 min-h-screen py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 animate-fade-in-up">
            <h1 class="text-4xl font-bold text-primary mb-4">الأخبار والمقالات</h1>
            <p class="text-gray-600">تابع أحدث إنجازات الشركة ومقالات تكنولوجية في مجال المعالجة</p>
        </div>

        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php 
                $index = 0;
                while (have_posts()) : the_post(); 
                    $summary = get_field('summary') ?: get_the_excerpt();
                    $news_categories = get_the_terms(get_the_ID(), 'news_category');
                    $category_name = $news_categories && !is_wp_error($news_categories) ? $news_categories[0]->name : '';
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full border border-gray-100 animate-fade-in-up'); ?> style="animation-delay: <?php echo $index * 150; ?>ms;">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="h-48 overflow-hidden relative">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('news-thumbnail', array('class' => 'w-full h-full object-cover transform hover:scale-105 transition-transform duration-500')); ?>
                                </a>
                                <?php if ($category_name) : ?>
                                    <div class="absolute top-4 right-4 bg-secondary text-primary text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                        <?php echo esc_html($category_name); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="p-6 flex-grow flex flex-col">
                            <div class="flex items-center text-gray-400 text-sm mb-3">
                                <svg class="w-3.5 h-3.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>
                            </div>
                            
                            <h3 class="text-xl font-bold text-primary mb-3 hover:text-secondary cursor-pointer transition">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <p class="text-gray-600 text-sm leading-relaxed mb-6 line-clamp-3">
                                <?php echo esc_html($summary); ?>
                            </p>
                            
                            <div class="mt-auto">
                                <a href="<?php the_permalink(); ?>" class="text-secondary font-bold flex items-center gap-1 hover:gap-2 transition-all text-sm">
                                    اقرأ المزيد
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php 
                $index++;
                endwhile; 
                ?>
            </div>

            <?php
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('&laquo; السابق', 'alomran'),
                'next_text' => __('التالي &raquo;', 'alomran'),
            ));
            ?>

        <?php else : ?>
            <div class="text-center py-20 animate-fade-in-up">
                <h2 class="text-2xl font-bold text-gray-500 mb-4">لا توجد أخبار</h2>
                <p class="text-gray-400">لم يتم العثور على أي أخبار.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>

