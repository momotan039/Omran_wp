<?php
/**
 * Archive template.
 *
 * @package AlOmran
 */

get_header();
?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <header class="text-center mb-12 animate-fade-in-up">
            <?php
            the_archive_title('<h1 class="text-4xl font-bold text-primary mb-4">', '</h1>');
            the_archive_description('<div class="text-gray-600 max-w-2xl mx-auto mt-4">', '</div>');
            ?>
        </header>

        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 animate-fade-in-up'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="relative h-64 overflow-hidden">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover transform hover:scale-110 transition-transform duration-700')); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-sm text-gray-400 mb-3">
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo esc_html(get_the_date()); ?>
                                </time>
                            </div>
                            
                            <h2 class="text-xl font-bold text-primary mb-3 hover:text-secondary transition">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="text-gray-600 text-sm leading-relaxed mb-4">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="text-secondary font-bold text-sm hover:underline inline-flex items-center gap-1">
                                <?php esc_html_e('اقرأ المزيد', 'alomran'); ?>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            the_posts_pagination(
                array(
                    'mid_size'  => 2,
                    'prev_text' => __('&laquo; السابق', 'alomran'),
                    'next_text' => __('التالي &raquo;', 'alomran'),
                )
            );
            ?>

        <?php else : ?>
            <div class="text-center py-20 animate-fade-in-up">
                <h2 class="text-2xl font-bold text-gray-500 mb-4"><?php esc_html_e('لا توجد منشورات', 'alomran'); ?></h2>
                <p class="text-gray-400"><?php esc_html_e('لم يتم العثور على أي محتوى في هذا الأرشيف.', 'alomran'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
