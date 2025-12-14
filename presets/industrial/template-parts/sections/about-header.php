<?php
/**
 * About Page Header Section Template
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$data = alomran_get_section_data('about_header');
if (!$data['enable']) {
    return;
}
?>

<div class="py-20 relative overflow-hidden" style="background-color: var(--theme-primary); color: var(--theme-white);">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] pointer-events-none"></div>
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 animate-fade-in-up">
            <?php echo esc_html($data['title']); ?>
        </h1>
        <?php if (!empty($data['subtitle'])) : ?>
            <p class="text-xl animate-fade-in-up delay-200" style="color: rgba(255, 255, 255, 0.9);">
                <?php echo esc_html($data['subtitle']); ?>
            </p>
        <?php endif; ?>
    </div>
</div>

