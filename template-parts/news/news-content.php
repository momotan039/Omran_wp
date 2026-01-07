<?php
/**
 * News Content Section
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$post_id = get_the_ID();
$news_categories = get_the_terms($post_id, 'news_category');
$author_name = get_the_author();
?>
<div class="container mx-auto px-4 -mt-16 relative z-30">
    <div class="rounded-xl shadow-xl p-8 md:p-12 border-t-4 border-secondary animate-fade-in-up delay-200" style="background-color: var(--theme-white);">
        
        <!-- Meta Data -->
        <div class="flex flex-wrap items-center gap-6 text-sm mb-8 border-b pb-6" style="color: var(--theme-gray-500); border-color: var(--theme-gray-100);">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo get_the_date(); ?>
                </time>
            </div>
            <?php if ($news_categories && !is_wp_error($news_categories) && !empty($news_categories[0])) : ?>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span><?php echo esc_html($news_categories[0]->name); ?></span>
                </div>
            <?php endif; ?>
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span><?php echo esc_html($author_name); ?></span>
            </div>
        </div>

        <!-- Content Body -->
        <div class="prose prose-lg max-w-none leading-loose" style="color: var(--theme-gray-700);">
            <?php 
            $excerpt = alomran_get_auto_excerpt($post_id, 30);
            if (!empty($excerpt)) : ?>
                <p class="font-bold text-xl mb-6" style="color: var(--theme-gray-900);"><?php echo esc_html($excerpt); ?></p>
            <?php endif; ?>
            
            <?php the_content(); ?>
        </div>

