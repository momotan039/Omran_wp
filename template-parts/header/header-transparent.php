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

// Get header colors from Redux
$header_bg_color = alomran_get_option('header_bg_color', '');
$header_text_color = alomran_get_option('header_text_color', '');

// Build inline styles for transparent header
$header_style = '';
if ($header_sticky) {
    if ($header_bg_color) {
        // Convert hex to rgba for transparency
        $bg_rgb = alomran_hex_to_rgb($header_bg_color);
        $header_style .= 'background-color: rgba(' . $bg_rgb . ', 0.8); ';
    } else {
        $header_style .= 'background-color: rgba(var(--theme-primary-rgb), 0.8); ';
    }
} else {
    $header_style .= 'background-color: transparent; ';
}

if ($header_text_color) {
    $header_style .= 'color: ' . esc_attr($header_text_color) . '; ';
} else {
    $header_style .= 'color: var(--theme-white); ';
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


