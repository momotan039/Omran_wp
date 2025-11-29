<?php
/**
 * Header Logo Component
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$logo_settings = alomran_get_header_logo_settings();
?>
<div class="flex items-center gap-3">
    <?php if (!empty($logo_settings['icon_url'])) : ?>
        <div class="w-10 h-10 flex items-center justify-center">
            <img src="<?php echo esc_url($logo_settings['icon_url']); ?>" alt="<?php echo esc_attr($logo_settings['title']); ?>" class="w-full h-full object-contain">
        </div>
    <?php else : ?>
        <div class="w-10 h-10 bg-secondary rounded-lg flex items-center justify-center transform rotate-45">
            <div class="w-6 h-6 border-2 border-primary transform -rotate-45"></div>
        </div>
    <?php endif; ?>
    
    <?php if ($logo_settings['show_title'] || $logo_settings['show_subtitle']) : ?>
        <div>
            <?php if ($logo_settings['show_title']) : ?>
                <?php if (is_front_page() || is_home()) : ?>
                    <h1 class="text-xl font-bold tracking-wider text-secondary"><?php echo esc_html($logo_settings['title']); ?></h1>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="text-xl font-bold tracking-wider text-secondary hover:text-yellow-400 transition">
                        <?php echo esc_html($logo_settings['title']); ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php if ($logo_settings['show_subtitle']) : ?>
                <p class="text-xs text-gray-300"><?php echo esc_html($logo_settings['subtitle']); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

