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

        // Get header colors from Redux
        $header_text_color = alomran_get_option('header_text_color', '');
        $header_link_color = alomran_get_option('header_link_color', '');
        $header_link_hover_color = alomran_get_option('header_link_hover_color', '');
        
        // Build link color styles
        $link_color = $header_link_color ? $header_link_color : ($header_text_color ? $header_text_color : 'var(--theme-white)');
        $link_hover_color = $header_link_hover_color ? $header_link_hover_color : 'var(--theme-accent)';
        
        echo '<ul class="flex space-x-8 space-x-reverse items-center">';
        foreach ($nav_links as $link) {
            $is_active = (is_page($link['url']) || (is_home() && $link['url'] === home_url('/'))) ? 'font-bold' : '';
            $link_style = 'color: ' . esc_attr($link_color) . ';';
            $link_hover_style = 'color: ' . esc_attr($link_hover_color) . ';';
            echo '<li class="transition-colors duration-300 text-sm lg:text-base ' . esc_attr($is_active) . '">';
            echo '<a href="' . esc_url($link['url']) . '" style="' . esc_attr($link_style) . '" onmouseover="this.style.color=\'' . esc_js($link_hover_color) . '\'" onmouseout="this.style.color=\'' . esc_js($link_color) . '\'">' . esc_html($link['name']) . '</a>';
            echo '</li>';
        }
        echo '</ul>';
    }
    ?>
</nav>

