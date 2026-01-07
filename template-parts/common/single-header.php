<?php
/**
 * Common Single Post Header Component
 * DRY: Reusable header for single post templates
 *
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render single post header
 * 
 * @param array $args {
 *     @type bool $show_date Whether to show date (optional, default: true)
 *     @type bool $show_categories Whether to show categories (optional, default: true)
 *     @type bool $show_thumbnail Whether to show featured image (optional, default: true)
 *     @type string $title_tag Title HTML tag (optional, default: 'h1')
 *     @type string $class Additional CSS classes (optional)
 * }
 */
function omran_render_single_header($args = array()) {
    $defaults = array(
        'show_date' => true,
        'show_categories' => true,
        'show_thumbnail' => true,
        'title_tag' => 'h1',
        'class' => '',
    );
    
    $args = wp_parse_args($args, $defaults);
    ?>
    <header class="mb-8 <?php echo esc_attr($args['class']); ?>">
        <?php if ($args['show_date'] || $args['show_categories']) : ?>
            <div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
                <?php if ($args['show_date']) : ?>
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php echo esc_html(get_the_date()); ?>
                    </time>
                <?php endif; ?>
                
                <?php if ($args['show_categories'] && get_the_category()) : ?>
                    <?php if ($args['show_date']) : ?>
                        <span>•</span>
                    <?php endif; ?>
                    <?php the_category(', '); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <<?php echo esc_attr($args['title_tag']); ?> class="text-4xl font-bold text-primary mb-4">
            <?php the_title(); ?>
        </<?php echo esc_attr($args['title_tag']); ?>>
        
        <?php if ($args['show_thumbnail'] && has_post_thumbnail()) : ?>
            <div class="mt-6 rounded-xl overflow-hidden shadow-lg">
                <?php the_post_thumbnail('large', array('class' => 'w-full h-auto')); ?>
            </div>
        <?php endif; ?>
    </header>
    <?php
}

