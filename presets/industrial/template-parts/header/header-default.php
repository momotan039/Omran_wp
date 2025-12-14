<?php
/**
 * Default Header Template
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$header_sticky = alomran_is_header_sticky();
$header_classes = array('z-50', 'shadow-lg', 'border-b');

if ($header_sticky) {
    $header_classes[] = 'sticky top-0';
}

// Get header colors from Redux
$header_bg_color = alomran_get_option('header_bg_color', '');
$header_text_color = alomran_get_option('header_text_color', '');
$header_border_color = alomran_get_option('header_border_color', '');

// Build inline styles
$header_style = '';
if ($header_bg_color) {
    $header_style .= 'background-color: ' . esc_attr($header_bg_color) . '; ';
} else {
    $header_style .= 'background-color: var(--theme-primary); ';
}

if ($header_text_color) {
    $header_style .= 'color: ' . esc_attr($header_text_color) . '; ';
} else {
    $header_style .= 'color: var(--theme-white); ';
}

if ($header_border_color) {
    $header_style .= 'border-color: ' . esc_attr($header_border_color) . '; ';
} else {
    $header_style .= 'border-color: rgba(255, 255, 255, 0.1); ';
}

$header_class = implode(' ', $header_classes);
?>
<header class="<?php echo esc_attr($header_class); ?>" style="<?php echo esc_attr($header_style); ?>">
    <div class="<?php echo esc_attr(alomran_get_container_width_class()); ?> mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <?php AlOmran_Preset_Loader::get_template_part('header-logo', '', array(), 'header'); ?>
            
            <?php AlOmran_Preset_Loader::get_template_part('header-nav', '', array(), 'header'); ?>
            
            <?php AlOmran_Preset_Loader::get_template_part('header-mobile-menu', '', array(), 'header'); ?>
        </div>
    </div>
</header>


