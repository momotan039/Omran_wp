<?php
/**
 * Minimal Header Template
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$header_sticky = alomran_is_header_sticky();
$header_classes = array('z-50', 'shadow-sm', 'border-b', 'border-gray-200');

if ($header_sticky) {
    $header_classes[] = 'sticky top-0';
}

$header_class = implode(' ', $header_classes);
?>
<header class="<?php echo esc_attr($header_class); ?>">
    <div class="<?php echo esc_attr(alomran_get_container_width_class()); ?> mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <?php get_template_part('template-parts/header/header-logo'); ?>
            
            <?php get_template_part('template-parts/header/header-nav'); ?>
            
            <?php get_template_part('template-parts/header/header-mobile-menu'); ?>
        </div>
    </div>
</header>


