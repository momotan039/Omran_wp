<?php
/**
 * Hero Section Template
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$data = alomran_get_section_data('hero');
if (!$data['enable']) {
    return;
}

$bg_image = !empty($data['background']['url']) ? $data['background']['url'] : 'https://picsum.photos/id/195/1920/1080';
?>

<section class="relative h-[85vh] flex items-center overflow-hidden">
    <div class="absolute inset-0 z-10 mix-blend-multiply pointer-events-none" style="background-color: var(--theme-primary); opacity: 0.8;"></div>
    <div class="absolute inset-0 z-10 pointer-events-none" style="background-color: rgba(0, 0, 0, 0.3);"></div>
    <div class="absolute inset-0 bg-cover bg-center z-0 animate-scale-in pointer-events-none" style="background-image: url('<?php echo esc_url($bg_image); ?>'); animation-duration: 10s;"></div>
    
    <div class="container mx-auto px-4 relative z-20 text-center md:text-right" style="color: var(--theme-white);">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-start">
            <div class="md:w-2/3">
                <?php if (!empty($data['badge'])) : ?>
                    <span class="font-bold px-4 py-1 rounded-full text-sm inline-block mb-4 animate-bounce badge-accent" style="background-color: var(--theme-accent); color: var(--theme-white);">
                        <?php echo esc_html($data['badge']); ?>
                    </span>
                <?php endif; ?>
                
                <h1 class="text-4xl md:text-6xl font-black leading-tight mb-6 font-sans animate-fade-in-up">
                    <?php echo esc_html($data['title']); ?>
                    <?php if (!empty($data['subtitle'])) : ?>
                        <br/>
                        <span class="text-secondary"><?php echo esc_html($data['subtitle']); ?></span>
                    <?php endif; ?>
                </h1>
                
                <?php if (!empty($data['description'])) : ?>
                    <p class="text-lg md:text-xl mb-8 max-w-2xl leading-relaxed animate-fade-in-up delay-200" style="color: var(--theme-gray-100);">
                        <?php echo esc_html($data['description']); ?>
                    </p>
                <?php endif; ?>
                
                <div class="flex flex-col md:flex-row gap-4 justify-center md:justify-start animate-fade-in-up delay-400 relative z-30">
                    <?php if (!empty($data['button1']['text']) && !empty($data['button1']['url'])) : ?>
                        <a href="<?php echo esc_url($data['button1']['url']); ?>" class="hover:bg-white hover:text-primary px-8 py-3 rounded-md font-bold text-lg transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-secondary/50 relative z-30 cursor-pointer" style="background-color: var(--theme-secondary); color: var(--theme-white);" onmouseover="this.style.backgroundColor='var(--theme-white)'; this.style.color='var(--theme-primary)';" onmouseout="this.style.backgroundColor='var(--theme-secondary)'; this.style.color='var(--theme-white)';">
                            <?php echo esc_html($data['button1']['text']); ?>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['button2']['text']) && !empty($data['button2']['url'])) : ?>
                        <a href="<?php echo esc_url($data['button2']['url']); ?>" class="border-2 hover:bg-white hover:text-primary px-8 py-3 rounded-md font-bold text-lg transition-all duration-300 relative z-30 cursor-pointer" style="border-color: var(--theme-white);" onmouseover="this.style.backgroundColor='var(--theme-white)'; this.style.color='var(--theme-primary)';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--theme-white)';">
                            <?php echo esc_html($data['button2']['text']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if ($data['show_seal']) : ?>
                <div class="hidden md:flex flex-col items-center justify-center mt-8 md:mt-0 opacity-90 animate-scale-in delay-500">
                    <div class="w-32 h-32 md:w-40 md:h-40 backdrop-blur-md rounded-full border-2 border-secondary flex flex-col items-center justify-center p-4 shadow-xl rotate-12 hover:rotate-0 transition-all duration-500" style="background-color: rgba(255, 255, 255, 0.1);">
                        <svg class="w-12 h-12 text-secondary mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        <span class="text-xs font-bold text-center leading-tight" style="color: var(--theme-white);">جودة معتمدة<br/>ISO 9001</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="absolute bottom-0 left-0 right-0 z-20 pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="var(--theme-gray-100)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>


