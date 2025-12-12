<?php
/**
 * Transparent Header Template
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$header_sticky = alomran_is_header_sticky();
$header_classes = array('absolute', 'w-full', 'z-50');

if ($header_sticky) {
    $header_classes[] = 'sticky top-0';
    $header_classes[] = 'backdrop-blur-md';
}

$header_class = implode(' ', $header_classes);
$header_style = $header_sticky 
    ? 'background-color: rgba(var(--theme-primary-rgb), 0.8); color: var(--theme-white);'
    : 'background-color: transparent; color: var(--theme-white);';
?>
<header class="<?php echo esc_attr($header_class); ?>" style="<?php echo esc_attr($header_style); ?>">
    <div class="<?php echo esc_attr(alomran_get_container_width_class()); ?> mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <?php get_template_part('template-parts/header/header-logo'); ?>
            
            <?php get_template_part('template-parts/header/header-nav'); ?>
            
            <?php get_template_part('template-parts/header/header-mobile-menu'); ?>
        </div>
    </div>
</header>


