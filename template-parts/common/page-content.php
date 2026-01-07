<?php
/**
 * Common Page Content Component
 * DRY: Reusable content wrapper for page templates
 *
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render page content
 * 
 * @param array $args {
 *     @type string $container_class Container CSS classes (optional)
 *     @type string $content_class Content wrapper CSS classes (optional)
 *     @type bool $show_thumbnail Whether to show featured image (optional, default: true)
 *     @type bool $show_title Whether to show title (optional, default: false, usually handled by header)
 * }
 */
function omran_render_page_content($args = array()) {
    $defaults = array(
        'container_class' => 'container mx-auto px-4',
        'content_class' => 'prose prose-lg max-w-none text-gray-700 leading-relaxed',
        'show_thumbnail' => true,
        'show_title' => false,
    );
    
    $args = wp_parse_args($args, $defaults);
    
    while (have_posts()) : the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('animate-fade-in-up'); ?>>
            <?php if ($args['show_title']) : ?>
                <header class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-primary mb-4"><?php the_title(); ?></h1>
                </header>
            <?php endif; ?>
            
            <?php if ($args['show_thumbnail'] && has_post_thumbnail()) : ?>
                <div class="mb-8 rounded-xl overflow-hidden shadow-lg">
                    <?php the_post_thumbnail('large', array('class' => 'w-full h-auto')); ?>
                </div>
            <?php endif; ?>
            
            <div class="<?php echo esc_attr($args['content_class']); ?>">
                <?php
                the_content();
                wp_link_pages(
                    array(
                        'before'      => '<div class="page-links mt-8"><span class="page-links-title">' . esc_html__('Pages:', 'alomran') . '</span>',
                        'after'       => '</div>',
                        'link_before' => '<span>',
                        'link_after'  => '</span>',
                    )
                );
                ?>
            </div>
        </article>
        <?php
    endwhile;
}

