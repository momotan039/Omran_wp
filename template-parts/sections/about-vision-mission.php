<?php
/**
 * About Page Vision & Mission Section Template
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$data = alomran_get_section_data('about_vision_mission');
if (!$data['enable']) {
    return;
}
?>

<div class="container mx-auto px-4 py-16">
    <?php if (!empty($data['vision']) || !empty($data['mission'])) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
            <?php if (!empty($data['vision'])) : ?>
                <div class="bg-white p-10 rounded-xl border-t-4 border-secondary shadow-lg hover:shadow-xl transition transform hover:-translate-y-2 animate-fade-in-up delay-300">
                    <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center text-primary mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-primary mb-4">
                        <?php echo esc_html($data['vision_title']); ?>
                    </h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        <?php echo esc_html($data['vision']); ?>
                    </p>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($data['mission'])) : ?>
                <div class="bg-white p-10 rounded-xl border-t-4 border-primary shadow-lg hover:shadow-xl transition transform hover:-translate-y-2 animate-fade-in-up delay-400">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-primary mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-primary mb-4">
                        <?php echo esc_html($data['mission_title']); ?>
                    </h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        <?php echo esc_html($data['mission']); ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

