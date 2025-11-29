<?php
/**
 * Header Mobile Menu Component
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="md:hidden">
    <button id="mobile-menu-toggle" class="text-white focus:outline-none" aria-label="<?php esc_attr_e('Toggle Menu', 'alomran'); ?>">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="menu-icon">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
        <svg class="w-7 h-7 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="close-icon">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<div id="mobile-menu" class="md:hidden hidden bg-primary border-t border-gray-700">
    <div class="flex flex-col space-y-4 px-4 py-6">
        <?php
        if (has_nav_menu('primary')) {
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'flex flex-col space-y-4',
                'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                'walker'         => new AlOmran_Walker_Nav_Menu(),
                'fallback_cb'    => false,
            ));
        } else {
            // Fallback menu if no menu is assigned
            $nav_links = array(
                array('name' => 'الرئيسية', 'url' => home_url('/')),
                array('name' => 'منتجاتنا', 'url' => get_post_type_archive_link('product') ?: home_url('/products')),
                array('name' => 'عن الشركة', 'url' => alomran_get_page_url('عن الشركة') ?: alomran_get_page_url('about') ?: home_url('/about')),
                array('name' => 'الأخبار', 'url' => get_post_type_archive_link('news') ?: home_url('/news')),
                array('name' => 'الأسئلة الشائعة', 'url' => alomran_get_page_url('الأسئلة الشائعة') ?: alomran_get_page_url('faq') ?: home_url('/faq')),
                array('name' => 'تواصل معنا', 'url' => alomran_get_page_url('تواصل معنا') ?: alomran_get_page_url('contact') ?: home_url('/contact')),
            );

            foreach ($nav_links as $link) {
                $is_active = (is_page($link['url']) || (is_home() && $link['url'] === home_url('/'))) ? 'text-secondary font-bold' : 'text-white hover:text-secondary';
                echo '<a href="' . esc_url($link['url']) . '" class="block ' . esc_attr($is_active) . '">' . esc_html($link['name']) . '</a>';
            }
        }
        ?>
    </div>
</div>

