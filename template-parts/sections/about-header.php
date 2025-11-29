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

<div class="bg-primary text-white py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] pointer-events-none"></div>
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 animate-fade-in-up">
            <?php echo esc_html($data['title']); ?>
        </h1>
        <?php if (!empty($data['subtitle'])) : ?>
            <p class="text-xl text-green-100 animate-fade-in-up delay-200">
                <?php echo esc_html($data['subtitle']); ?>
            </p>
        <?php endif; ?>
    </div>
</div>

