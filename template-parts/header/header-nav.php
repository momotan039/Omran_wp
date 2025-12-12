<?php
/**
 * Header Navigation Component
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<nav class="hidden md:flex space-x-8 space-x-reverse items-center">
    <?php
    if (has_nav_menu('primary')) {
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'flex space-x-8 space-x-reverse items-center',
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

        echo '<ul class="flex space-x-8 space-x-reverse items-center">';
        foreach ($nav_links as $link) {
            $is_active = (is_page($link['url']) || (is_home() && $link['url'] === home_url('/'))) ? 'text-secondary font-bold' : 'hover:text-secondary';
            // For minimal header, use dark text; otherwise use white
            $text_color_style = alomran_get_header_style() === 'minimal' 
                ? 'color: var(--theme-gray-900);' 
                : 'color: var(--theme-white);';
            echo '<li class="transition-colors duration-300 text-sm lg:text-base ' . esc_attr($is_active) . '" style="' . esc_attr($text_color_style) . '">';
            echo '<a href="' . esc_url($link['url']) . '">' . esc_html($link['name']) . '</a>';
            echo '</li>';
        }
        echo '</ul>';
    }
    ?>
</nav>

