<?php
/**
 * News Hero Section
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$post_id = get_the_ID();
$bg_image = has_post_thumbnail() ? get_the_post_thumbnail_url($post_id, 'full') : '';
$news_categories = get_the_terms($post_id, 'news_category');
$author_name = get_the_author();
?>
<section class="relative h-[500px] flex items-center overflow-hidden">
    <div class="absolute inset-0 bg-primary/80 z-10 mix-blend-multiply pointer-events-none"></div>
    <div class="absolute inset-0 bg-black/30 z-10 pointer-events-none"></div>
    <?php if ($bg_image) : ?>
        <div class="absolute inset-0 bg-cover bg-center z-0 animate-scale-in pointer-events-none" style="background-image: url('<?php echo esc_url($bg_image); ?>'); animation-duration: 10s;"></div>
    <?php endif; ?>
    
    <div class="container mx-auto px-4 relative z-20 text-white text-center md:text-right">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-start">
            <div class="md:w-2/3">
                <?php if ($news_categories && !is_wp_error($news_categories) && !empty($news_categories[0])) : ?>
                    <span class="bg-secondary text-white font-bold px-4 py-1 rounded-full text-sm inline-block mb-4 animate-bounce">
                        <?php echo esc_html($news_categories[0]->name); ?>
                    </span>
                <?php endif; ?>
                
                <h1 class="text-4xl md:text-6xl font-black leading-tight mb-6 font-sans animate-fade-in-up">
                    <?php the_title(); ?>
                </h1>
                
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 md:gap-6 text-white/90 text-sm md:text-base mb-8 animate-fade-in-up delay-200">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo get_the_date(); ?>
                        </time>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span><?php echo esc_html($author_name); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="absolute bottom-0 left-0 right-0 z-20 pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 180" preserveAspectRatio="none" class="w-full" style="height: 150px;">
            <path fill="#f3f4f6" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,180L1392,180C1344,180,1248,180,1152,180C1056,180,960,180,864,180C768,180,672,180,576,180C480,180,384,180,288,180C192,180,96,180,48,180L0,180Z"></path>
        </svg>
    </div>
</section>

