<?php
/**
 * Centered Footer Template
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$company_info = alomran_get_company_info();
$footer_data = alomran_get_section_data('footer');
?>
<footer class="pt-16 pb-8 border-t border-secondary/20 text-center" style="background-color: var(--theme-slate-900); color: var(--theme-slate-300);">
    <div class="<?php echo esc_attr(alomran_get_container_width_class()); ?> mx-auto px-4">
        <div class="max-w-2xl mx-auto mb-12">
            <h3 class="text-2xl font-bold mb-4" style="color: var(--theme-white);"><?php echo esc_html($company_info['name']); ?></h3>
            <?php if (!empty($footer_data['description'])) : ?>
            <p class="mb-6 leading-relaxed text-sm" style="color: var(--theme-gray-400);">
                <?php echo esc_html($footer_data['description']); ?>
            </p>
            <?php endif; ?>
            
            <?php if (!empty($footer_data['social_enable']) && !empty($footer_data['social_links'])) : ?>
                <div class="flex justify-center space-x-4 space-x-reverse flex-wrap gap-3 mb-8">
                    <?php if (!empty($footer_data['social_links']['facebook'])) : ?>
                        <a href="<?php echo esc_url($footer_data['social_links']['facebook']); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-secondary hover:text-primary transition-all duration-300" style="background-color: var(--theme-slate-800);" aria-label="<?php esc_attr_e('Facebook', 'alomran'); ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($footer_data['social_links']['linkedin'])) : ?>
                        <a href="<?php echo esc_url($footer_data['social_links']['linkedin']); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-secondary hover:text-primary transition-all duration-300" style="background-color: var(--theme-slate-800);" aria-label="<?php esc_attr_e('LinkedIn', 'alomran'); ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <div class="flex flex-wrap justify-center gap-6 text-sm mb-8">
                <a href="<?php echo esc_url(get_post_type_archive_link('product') ?: home_url('/products')); ?>" class="hover:text-secondary transition"><?php esc_html_e('منتجاتنا', 'alomran'); ?></a>
                <a href="<?php echo esc_url(alomran_get_page_url('عن الشركة') ?: alomran_get_page_url('about') ?: home_url('/about')); ?>" class="hover:text-secondary transition"><?php esc_html_e('من نحن', 'alomran'); ?></a>
                <a href="<?php echo esc_url(get_post_type_archive_link('news') ?: home_url('/news')); ?>" class="hover:text-secondary transition"><?php esc_html_e('آخر الأخبار', 'alomran'); ?></a>
                <a href="<?php echo esc_url(alomran_get_page_url('تواصل معنا') ?: alomran_get_page_url('contact') ?: home_url('/contact')); ?>" class="hover:text-secondary transition"><?php esc_html_e('اتصل بنا', 'alomran'); ?></a>
            </div>
        </div>
        
        <div class="border-t pt-8 text-sm" style="border-color: var(--theme-slate-800); color: var(--theme-gray-500);">
            <p><?php printf(__('جميع الحقوق محفوظة © %s شركة العمران للصناعات المتطورة.', 'alomran'), esc_html(date('Y'))); ?></p>
        </div>
    </div>
</footer>


