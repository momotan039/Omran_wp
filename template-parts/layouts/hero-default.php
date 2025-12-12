<?php
/**
 * Default Hero Layout (Fallback)
 * 
 * Used when preset-specific layout is not found.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// $hero_data is passed from section-hero.php
?>
<section class="relative h-[85vh] flex items-center overflow-hidden" <?php echo omran_core_get_section_attributes('hero'); ?>>
    <div class="absolute inset-0 z-10 pointer-events-none" style="background-color: var(--preset-primary); opacity: 0.8;"></div>
    <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('<?php echo esc_url($hero_data['background']['url']); ?>');"></div>
    
    <div class="container mx-auto px-4 relative z-20 text-center">
        <div class="max-w-4xl mx-auto">
            <?php if (!empty($hero_data['badge'])) : ?>
                <span class="font-bold px-4 py-1 rounded-full text-sm inline-block mb-4" style="background-color: var(--preset-accent); color: var(--preset-background);">
                    <?php echo esc_html($hero_data['badge']); ?>
                </span>
            <?php endif; ?>
            
            <h1 class="text-4xl md:text-6xl font-black leading-tight mb-6" style="color: var(--preset-background);">
                <?php echo esc_html($hero_data['title']); ?>
                <?php if (!empty($hero_data['subtitle'])) : ?>
                    <br/>
                    <span style="color: var(--preset-secondary);"><?php echo esc_html($hero_data['subtitle']); ?></span>
                <?php endif; ?>
            </h1>
            
            <?php if (!empty($hero_data['description'])) : ?>
                <p class="text-lg md:text-xl mb-8 max-w-2xl mx-auto leading-relaxed" style="color: rgba(255, 255, 255, 0.9);">
                    <?php echo esc_html($hero_data['description']); ?>
                </p>
            <?php endif; ?>
            
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <?php if (!empty($hero_data['button1']['text']) && !empty($hero_data['button1']['url'])) : ?>
                    <a href="<?php echo esc_url($hero_data['button1']['url']); ?>" class="px-8 py-3 rounded-md font-bold text-lg transition-all duration-300" style="background-color: var(--preset-secondary); color: var(--preset-background);">
                        <?php echo esc_html($hero_data['button1']['text']); ?>
                    </a>
                <?php endif; ?>
                
                <?php if (!empty($hero_data['button2']['text']) && !empty($hero_data['button2']['url'])) : ?>
                    <a href="<?php echo esc_url($hero_data['button2']['url']); ?>" class="px-8 py-3 rounded-md font-bold text-lg transition-all duration-300 border-2" style="border-color: var(--preset-background); color: var(--preset-background);">
                        <?php echo esc_html($hero_data['button2']['text']); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

