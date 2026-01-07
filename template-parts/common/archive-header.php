<?php
/**
 * Common Archive Header Component
 * DRY: Reusable header for all archive templates
 *
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render archive header
 * 
 * @param array $args {
 *     @type string $title Archive title (optional, defaults to archive title)
 *     @type string $description Archive description (optional)
 *     @type string $icon SVG icon path (optional)
 *     @type string $class Additional CSS classes (optional)
 * }
 */
function omran_render_archive_header($args = array()) {
    $defaults = array(
        'title' => get_the_archive_title(),
        'description' => get_the_archive_description(),
        'icon' => '',
        'class' => '',
    );
    
    $args = wp_parse_args($args, $defaults);
    ?>
    <header class="text-center mb-12 md:mb-16 animate-fade-in-up <?php echo esc_attr($args['class']); ?>">
        <?php if (!empty($args['icon'])) : ?>
            <div class="mb-4">
                <?php echo $args['icon']; ?>
            </div>
        <?php endif; ?>
        
        <h1 class="text-3xl md:text-4xl font-bold text-primary mb-4">
            <?php 
            if ($args['title'] === get_the_archive_title()) {
                the_archive_title('<span>', '</span>');
            } else {
                echo esc_html($args['title']);
            }
            ?>
        </h1>
        
        <?php if (!empty($args['description'])) : ?>
            <div class="text-gray-600 max-w-2xl mx-auto mt-4">
                <?php 
                if ($args['description'] === get_the_archive_description()) {
                    the_archive_description();
                } else {
                    echo esc_html($args['description']);
                }
                ?>
            </div>
        <?php endif; ?>
    </header>
    <?php
}

