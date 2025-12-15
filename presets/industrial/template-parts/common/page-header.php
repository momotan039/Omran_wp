<?php
/**
 * Common Page Header Component
 * DRY: Reusable header for all page templates
 *
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render page header
 * 
 * @param array $args {
 *     @type string $title Page title (optional, defaults to post title)
 *     @type string $subtitle Subtitle text (optional)
 *     @type string $icon SVG icon path (optional)
 *     @type string $class Additional CSS classes (optional)
 * }
 */
function omran_render_page_header($args = array()) {
    $defaults = array(
        'title' => get_the_title(),
        'subtitle' => '',
        'icon' => '',
        'class' => '',
    );
    
    $args = wp_parse_args($args, $defaults);
    ?>
    <div class="text-center mb-12 md:mb-16 animate-fade-in-up <?php echo esc_attr($args['class']); ?>">
        <?php if (!empty($args['icon'])) : ?>
            <div class="mb-4">
                <?php echo $args['icon']; ?>
            </div>
        <?php endif; ?>
        <h1 class="text-3xl md:text-4xl font-bold text-primary mb-4">
            <?php echo esc_html($args['title']); ?>
        </h1>
        <?php if (!empty($args['subtitle'])) : ?>
            <p class="text-gray-600 text-lg">
                <?php echo esc_html($args['subtitle']); ?>
            </p>
        <?php endif; ?>
    </div>
    <?php
}

