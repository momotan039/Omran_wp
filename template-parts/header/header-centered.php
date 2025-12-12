<?php
/**
 * Centered Header Template
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$header_sticky = alomran_is_header_sticky();
$header_classes = array('z-50', 'shadow-lg', 'border-b', 'text-center');

if ($header_sticky) {
    $header_classes[] = 'sticky top-0';
}

$header_class = implode(' ', $header_classes);
$header_style = 'background-color: var(--theme-primary); color: var(--theme-white); border-color: rgba(255, 255, 255, 0.1);';
?>
<header class="<?php echo esc_attr($header_class); ?>" style="<?php echo esc_attr($header_style); ?>">
    <div class="<?php echo esc_attr(alomran_get_container_width_class()); ?> mx-auto px-4">
        <div class="flex justify-center items-center h-20">
            <?php get_template_part('template-parts/header/header-logo'); ?>
        </div>
        <div class="flex justify-center items-center pb-4">
            <?php get_template_part('template-parts/header/header-nav'); ?>
        </div>
        <?php get_template_part('template-parts/header/header-mobile-menu'); ?>
    </div>
</header>


