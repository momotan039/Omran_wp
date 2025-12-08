<?php
/**
 * Risks Section Template
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$data = alomran_get_section_data('risks');
if (!$data['enable'] || empty($data['items'])) {
    return;
}
?>

<section class="py-16 bg-accent relative z-10 -mt-10 md:-mt-20">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border-t-8 border-primary animate-fade-in-up delay-200">
            <?php if (!empty($data['title'])) : ?>
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-primary mb-4"><?php echo esc_html($data['title']); ?></h2>
                    <div class="h-1 w-20 bg-secondary mx-auto"></div>
                </div>
            <?php endif; ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($data['items'] as $idx => $risk) : ?>
                    <?php if (empty($risk['risk_title'])) continue; ?>
                    <div class="flex items-start gap-4 p-4 rounded-lg hover:bg-gray-50 transition-colors animate-scale-in delay-<?php echo ($idx % 3 + 1) * 100; ?>">
                        <div class="bg-red-50 p-3 rounded-full text-red-500 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-primary mb-2"><?php echo esc_html($risk['risk_title']); ?></h4>
                            <?php if (!empty($risk['risk_desc'])) : ?>
                                <p class="text-gray-500 text-sm leading-relaxed"><?php echo esc_html($risk['risk_desc']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>



