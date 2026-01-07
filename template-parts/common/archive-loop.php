<?php
/**
 * Common Archive Loop Component
 * DRY: Reusable loop for archive templates
 *
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render archive loop
 * 
 * @param array $args {
 *     @type string $grid_class Grid CSS classes (optional, default: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3')
 *     @type string $item_class Item CSS classes (optional)
 *     @type bool $show_thumbnail Whether to show featured image (optional, default: true)
 *     @type bool $show_date Whether to show date (optional, default: true)
 *     @type bool $show_excerpt Whether to show excerpt (optional, default: true)
 *     @type string $excerpt_length Excerpt length (optional, default: 'auto')
 *     @type callable $custom_template Custom template callback (optional)
 * }
 */
function omran_render_archive_loop($args = array()) {
    $defaults = array(
        'grid_class' => 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8',
        'item_class' => 'bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 animate-fade-in-up',
        'show_thumbnail' => true,
        'show_date' => true,
        'show_excerpt' => true,
        'excerpt_length' => 'auto',
        'custom_template' => null,
    );
    
    $args = wp_parse_args($args, $defaults);
    
    if (!have_posts()) {
        omran_render_empty_archive();
        return;
    }
    
    ?>
    <div class="<?php echo esc_attr($args['grid_class']); ?>">
        <?php 
        $index = 0;
        while (have_posts()) : the_post(); 
            if ($args['custom_template'] && is_callable($args['custom_template'])) {
                call_user_func($args['custom_template'], get_the_ID(), $index);
            } else {
                omran_render_archive_item($args, $index);
            }
            $index++;
        endwhile; 
        ?>
    </div>
    
    <?php
    // Pagination
    the_posts_pagination(
        array(
            'mid_size'  => 2,
            'prev_text' => __('&laquo; السابق', 'alomran'),
            'next_text' => __('التالي &raquo;', 'alomran'),
        )
    );
}

/**
 * Render single archive item
 */
function omran_render_archive_item($args, $index = 0) {
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class($args['item_class']); ?> style="animation-delay: <?php echo $index * 100; ?>ms">
        <?php if ($args['show_thumbnail'] && has_post_thumbnail()) : ?>
            <div class="relative h-64 overflow-hidden">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover transform hover:scale-110 transition-transform duration-700')); ?>
                </a>
            </div>
        <?php endif; ?>
        
        <div class="p-6">
            <?php if ($args['show_date']) : ?>
                <div class="flex items-center gap-2 text-sm text-gray-400 mb-3">
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php echo esc_html(get_the_date()); ?>
                    </time>
                </div>
            <?php endif; ?>
            
            <h2 class="text-xl font-bold text-primary mb-3 hover:text-secondary transition">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            
            <?php if ($args['show_excerpt']) : ?>
                <div class="text-gray-600 text-sm leading-relaxed mb-4">
                    <?php 
                    if ($args['excerpt_length'] === 'auto') {
                        the_excerpt();
                    } else {
                        echo wp_trim_words(get_the_excerpt(), absint($args['excerpt_length']));
                    }
                    ?>
                </div>
            <?php endif; ?>
            
            <a href="<?php the_permalink(); ?>" class="text-secondary font-bold text-sm hover:underline inline-flex items-center gap-1">
                <?php esc_html_e('اقرأ المزيد', 'alomran'); ?>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        </div>
    </article>
    <?php
}

/**
 * Render empty archive state
 */
function omran_render_empty_archive() {
    ?>
    <div class="text-center py-20 animate-fade-in-up">
        <h2 class="text-2xl font-bold text-gray-500 mb-4"><?php esc_html_e('لا توجد منشورات', 'alomran'); ?></h2>
        <p class="text-gray-400"><?php esc_html_e('لم يتم العثور على أي محتوى في هذا الأرشيف.', 'alomran'); ?></p>
    </div>
    <?php
}

