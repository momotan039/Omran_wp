<?php
/**
 * Header Logo Component
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get logo settings using unified helper function (DRY principle)
$logo_settings = alomran_get_header_logo_settings();
$logo_url = $logo_settings['icon_url'];
$logo_width = $logo_settings['width'];
$logo_height = $logo_settings['height'];
$show_title = $logo_settings['show_title'];
$show_subtitle = $logo_settings['show_subtitle'];
$title_text = $logo_settings['title'];
$subtitle_text = $logo_settings['subtitle'];

// Logo style
$logo_style = '';
if ($logo_width) {
    $logo_style .= 'width: ' . intval($logo_width) . 'px; ';
}
if ($logo_height) {
    $logo_style .= 'height: ' . intval($logo_height) . 'px; ';
}

// Get header text color for title/subtitle
$header_text_color = alomran_get_option('header_text_color', '');
$text_color_style = $header_text_color ? 'color: ' . esc_attr($header_text_color) . ';' : '';
?>
<a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3" title="<?php echo esc_attr($title_text); ?>">
    <?php if ($logo_url) : ?>
        <img src="<?php echo esc_url($logo_url); ?>" 
             alt="<?php echo esc_attr($title_text); ?>" 
             style="<?php echo esc_attr($logo_style); ?>"
             class="object-contain flex-shrink-0">
    <?php endif; ?>
    
    <?php if ($show_title || $show_subtitle) : ?>
        <div class="flex flex-col">
            <?php if ($show_title && $title_text) : ?>
                <?php if (is_front_page() || is_home()) : ?>
                    <h1 class="text-xl font-bold leading-tight" style="<?php echo esc_attr($text_color_style); ?>">
                        <?php echo esc_html($title_text); ?>
                    </h1>
                <?php else : ?>
                    <span class="text-xl font-bold leading-tight" style="<?php echo esc_attr($text_color_style); ?>">
                        <?php echo esc_html($title_text); ?>
                    </span>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php if ($show_subtitle && $subtitle_text) : ?>
                <span class="text-xs opacity-80 leading-tight mt-0.5" style="<?php echo esc_attr($text_color_style); ?>">
                    <?php echo esc_html($subtitle_text); ?>
                </span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</a>

