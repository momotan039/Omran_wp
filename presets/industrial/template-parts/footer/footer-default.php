<?php
/**
 * Default Footer Template
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$company_info = alomran_get_company_info();
$footer_data = alomran_get_section_data('footer');
?>
<footer class="pt-16 pb-8 border-t border-secondary/20" style="background-color: var(--theme-slate-900); color: var(--theme-slate-300);">
    <div class="<?php echo esc_attr(alomran_get_container_width_class()); ?> mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <div class="md:col-span-1">
                <h3 class="text-2xl font-bold mb-4" style="color: var(--theme-white);"><?php echo esc_html($company_info['name']); ?></h3>
                <?php if (!empty($footer_data['description'])) : ?>
                <p class="mb-6 leading-relaxed text-sm" style="color: var(--theme-gray-400);">
                    <?php echo esc_html($footer_data['description']); ?>
                </p>
                <?php endif; ?>
                <?php if (!empty($footer_data['social_enable']) && !empty($footer_data['social_links'])) : ?>
                    <div class="flex space-x-4 space-x-reverse flex-wrap gap-3">
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
                        <?php if (!empty($footer_data['social_links']['instagram'])) : ?>
                            <a href="<?php echo esc_url($footer_data['social_links']['instagram']); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-secondary hover:text-primary transition-all duration-300" style="background-color: var(--theme-slate-800);" aria-label="<?php esc_attr_e('Instagram', 'alomran'); ?>">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($footer_data['social_links']['twitter'])) : ?>
                            <a href="<?php echo esc_url($footer_data['social_links']['twitter']); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-secondary hover:text-primary transition-all duration-300" style="background-color: var(--theme-slate-800);" aria-label="<?php esc_attr_e('Twitter', 'alomran'); ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($footer_data['social_links']['youtube'])) : ?>
                        <a href="<?php echo esc_url($footer_data['social_links']['youtube']); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-secondary hover:text-primary transition-all duration-300" style="background-color: var(--theme-slate-800);" aria-label="<?php esc_attr_e('YouTube', 'alomran'); ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($footer_data['social_links']['whatsapp'])) : ?>
                        <a href="<?php echo esc_url($footer_data['social_links']['whatsapp']); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-secondary hover:text-primary transition-all duration-300" style="background-color: var(--theme-slate-800);" aria-label="<?php esc_attr_e('WhatsApp', 'alomran'); ?>">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-4 border-b-2 border-secondary w-fit pb-1" style="color: var(--theme-white);"><?php esc_html_e('روابط سريعة', 'alomran'); ?></h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo esc_url(get_post_type_archive_link('product') ?: home_url('/products')); ?>" class="hover:text-secondary transition"><?php esc_html_e('منتجاتنا', 'alomran'); ?></a></li>
                    <li><a href="<?php echo esc_url(alomran_get_page_url('عن الشركة') ?: alomran_get_page_url('about') ?: home_url('/about')); ?>" class="hover:text-secondary transition"><?php esc_html_e('من نحن', 'alomran'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_post_type_archive_link('news') ?: home_url('/news')); ?>" class="hover:text-secondary transition"><?php esc_html_e('آخر الأخبار', 'alomran'); ?></a></li>
                    <li><a href="<?php echo esc_url(alomran_get_page_url('تواصل معنا') ?: alomran_get_page_url('contact') ?: home_url('/contact')); ?>" class="hover:text-secondary transition"><?php esc_html_e('اتصل بنا', 'alomran'); ?></a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-4 border-b-2 border-secondary w-fit pb-1" style="color: var(--theme-white);"><?php esc_html_e('منتجاتنا', 'alomran'); ?></h4>
                <?php
                $product_categories = alomran_get_product_categories(6);
                
                if (!empty($product_categories)) : ?>
                    <ul class="space-y-2 text-sm">
                        <?php foreach ($product_categories as $category) : 
                            $category_link = get_term_link($category);
                            if (!is_wp_error($category_link)) : ?>
                                <li>
                                    <a href="<?php echo esc_url($category_link); ?>" class="hover:text-secondary transition">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                <ul class="space-y-2 text-sm">
                        <li><a href="<?php echo esc_url(get_post_type_archive_link('product') ?: home_url('/products')); ?>" class="hover:text-secondary transition"><?php esc_html_e('جميع المنتجات', 'alomran'); ?></a></li>
                </ul>
                <?php endif; ?>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-4 border-b-2 border-secondary w-fit pb-1" style="color: var(--theme-white);"><?php esc_html_e('تواصل معنا', 'alomran'); ?></h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4" style="color: var(--theme-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <?php echo esc_html($company_info['address']); ?>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4" style="color: var(--theme-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <a href="tel:<?php echo esc_attr(str_replace(' ', '', $company_info['phone'])); ?>" class="hover:text-secondary transition"><?php echo esc_html($company_info['phone']); ?></a>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4" style="color: var(--theme-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <a href="mailto:<?php echo esc_attr($company_info['email']); ?>" class="hover:text-secondary transition"><?php echo esc_html($company_info['email']); ?></a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="border-t pt-8 flex flex-col md:flex-row justify-between items-center text-sm gap-4" style="border-color: var(--theme-slate-800); color: var(--theme-gray-500);">
            <p><?php printf(__('جميع الحقوق محفوظة © %s شركة العمران للصناعات المتطورة.', 'alomran'), esc_html(date('Y'))); ?></p>
            <p class="flex items-center gap-1">
                <?php esc_html_e('تطوير وتصميم', 'alomran'); ?>
                    <a href="https://mohamad-taha.com/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors font-bold" style="color: var(--theme-secondary);">
                    محمد طه
                </a>
            </p>
        </div>
    </div>
</footer>


