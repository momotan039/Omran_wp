<?php
/**
 * Common Single Post Content Component
 * DRY: Reusable content wrapper for single post templates
 *
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render single post content
 * 
 * @param array $args {
 *     @type string $content_class Content wrapper CSS classes (optional)
 *     @type bool $show_tags Whether to show tags (optional, default: true)
 *     @type bool $show_navigation Whether to show post navigation (optional, default: true)
 *     @type string $class Additional CSS classes (optional)
 * }
 */
function omran_render_single_content($args = array()) {
    $defaults = array(
        'content_class' => 'prose prose-lg max-w-none text-gray-700 leading-relaxed mb-8',
        'show_tags' => true,
        'show_navigation' => true,
        'class' => '',
    );
    
    $args = wp_parse_args($args, $defaults);
    ?>
    <div class="<?php echo esc_attr($args['class']); ?>">
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

        <?php if ($args['show_tags']) : ?>
            <footer class="border-t border-gray-200 pt-8 mt-8">
                <div class="flex items-center justify-between">
                    <div>
                        <?php
                        $tags = get_the_tags();
                        if ($tags) :
                            ?>
                            <div class="flex gap-2 flex-wrap">
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-secondary hover:text-white transition">
                                        <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </footer>
        <?php endif; ?>

        <?php if ($args['show_navigation']) : ?>
            <?php
            the_post_navigation(
                array(
                    'prev_text' => '<span class="nav-subtitle">' . esc_html__('السابق:', 'alomran') . '</span> <span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">' . esc_html__('التالي:', 'alomran') . '</span> <span class="nav-title">%title</span>',
                )
            );
            ?>
        <?php endif; ?>
    </div>
    <?php
}

