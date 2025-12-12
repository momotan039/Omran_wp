<?php
/**
 * Food & Beverage Preset - Hero Section Layout
 * 
 * Vibrant, appetizing design for food industry
 * 
 * @package AlOmran_Preset_Food
 */

if (!defined('ABSPATH')) {
    exit;
}

// $hero_data is passed from section-hero.php
?>
<section class="relative h-[90vh] flex items-center overflow-hidden" <?php echo omran_core_get_section_attributes('hero'); ?>>
    <div class="absolute inset-0 z-10 pointer-events-none" style="background: linear-gradient(135deg, rgba(220, 38, 38, 0.85) 0%, rgba(249, 115, 22, 0.75) 100%);"></div>
    <div class="absolute inset-0 bg-cover bg-center z-0 animate-scale-in pointer-events-none" style="background-image: url('<?php echo esc_url($hero_data['background']['url']); ?>'); animation-duration: 10s;"></div>
    
    <div class="container mx-auto px-4 relative z-20 text-center">
        <div class="max-w-4xl mx-auto">
            <?php if (!empty($hero_data['badge'])) : ?>
                <span class="font-bold px-6 py-2 rounded-full text-base inline-block mb-6 animate-bounce" style="background-color: var(--preset-accent); color: var(--preset-primary); box-shadow: 0 4px 12px rgba(250, 204, 21, 0.4);">
                    <?php echo esc_html($hero_data['badge']); ?>
                </span>
            <?php endif; ?>
            
            <h1 class="text-5xl md:text-7xl font-black leading-tight mb-6 animate-fade-in-up" style="color: var(--preset-background); text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);">
                <?php echo esc_html($hero_data['title']); ?>
                <?php if (!empty($hero_data['subtitle'])) : ?>
                    <br/>
                    <span style="color: var(--preset-accent);"><?php echo esc_html($hero_data['subtitle']); ?></span>
                <?php endif; ?>
            </h1>
            
            <?php if (!empty($hero_data['description'])) : ?>
                <p class="text-xl md:text-2xl mb-10 max-w-2xl mx-auto leading-relaxed animate-fade-in-up delay-200" style="color: rgba(255, 255, 255, 0.95);">
                    <?php echo esc_html($hero_data['description']); ?>
                </p>
            <?php endif; ?>
            
            <div class="flex flex-col md:flex-row gap-6 justify-center animate-fade-in-up delay-400">
                <?php if (!empty($hero_data['button1']['text']) && !empty($hero_data['button1']['url'])) : ?>
                    <a href="<?php echo esc_url($hero_data['button1']['url']); ?>" class="px-10 py-4 rounded-full font-bold text-lg transition-all duration-300 flex items-center justify-center gap-2 shadow-xl hover:shadow-2xl transform hover:scale-105" style="background-color: var(--preset-primary); color: var(--preset-background);">
                        <?php echo esc_html($hero_data['button1']['text']); ?>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                <?php endif; ?>
                
                <?php if (!empty($hero_data['button2']['text']) && !empty($hero_data['button2']['url'])) : ?>
                    <a href="<?php echo esc_url($hero_data['button2']['url']); ?>" class="px-10 py-4 rounded-full font-bold text-lg transition-all duration-300 border-2 transform hover:scale-105" style="border-color: var(--preset-background); color: var(--preset-background); background-color: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                        <?php echo esc_html($hero_data['button2']['text']); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="absolute bottom-0 left-0 right-0 z-20 pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="var(--preset-background)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

