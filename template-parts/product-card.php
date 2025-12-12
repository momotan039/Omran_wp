<?php
/**
 * Template part for displaying product cards
 *
 * @package AlOmran
 */

$product_id = get_the_ID();
$short_description = get_field('short_description') ?: get_the_excerpt();
$price = get_field('price') ?: 'تواصل للسعر';
$is_featured = get_field('is_featured') ?: false;
?>

<div class="group rounded-lg overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 flex flex-col h-full border animate-fade-in-up" style="background-color: var(--theme-white); border-color: var(--theme-gray-100);">
    <?php if (has_post_thumbnail()) : ?>
        <div class="relative h-64 overflow-hidden">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('product-thumbnail', array('class' => 'w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700')); ?>
            </a>
            <div class="absolute inset-0 opacity-0 group-hover:opacity-60 transition-opacity duration-300 flex items-center justify-center" style="background-color: var(--theme-primary);">
                <a href="<?php the_permalink(); ?>" class="px-6 py-2 rounded-full font-bold transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 hover:bg-secondary hover:text-white" style="background-color: var(--theme-white); color: var(--theme-primary);">
                    التفاصيل
                </a>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="p-6 flex-grow flex flex-col">
        <div class="flex justify-between items-start mb-2">
            <?php if ($is_featured) : ?>
                <span class="text-[10px] px-2 py-0.5 rounded badge-accent" style="background-color: var(--theme-accent); color: var(--theme-white);">مميز</span>
            <?php endif; ?>
        </div>
        
        <h3 class="text-xl font-bold mb-3 group-hover:text-accent transition-colors" style="color: var(--theme-gray-800);">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <p class="text-sm mb-4 line-clamp-2" style="color: var(--theme-gray-500);"><?php echo esc_html($short_description); ?></p>
        
        <div class="mt-auto pt-4 border-t flex items-center justify-between" style="border-color: var(--theme-gray-100);">
            <span class="font-bold" style="color: var(--theme-primary);"><?php echo esc_html($price); ?></span>
            <a href="<?php the_permalink(); ?>" class="text-sm hover:text-accent flex items-center transition-colors" style="color: var(--theme-gray-400);">
                المزيد
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        </div>
    </div>
</div>

