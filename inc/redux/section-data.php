<?php
/**
 * Redux Section Data Retrieval
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once ALOMRAN_THEME_DIR . '/inc/redux/parsers.php';

function alomran_get_section_data($section) {
    $data = array();
    
    switch ($section) {
        case 'hero':
            $bg = alomran_get_option('hero_background_image', array());
            $bg_url = is_array($bg) && isset($bg['url']) ? $bg['url'] : (is_string($bg) ? $bg : '');
            
            $data = array(
                'enable'      => alomran_get_option('hero_enable', true),
                'badge'       => alomran_get_option('hero_badge', 'الرائدون في مصر'),
                'title'       => alomran_get_option('hero_title', 'جودة تدوم.. لمستقبل أنقى'),
                'subtitle'    => alomran_get_option('hero_subtitle', 'في كل قطرة ومشروع'),
                'description' => alomran_get_option('hero_description', ''),
                'button1'     => array(
                    'text' => alomran_get_option('hero_button1_text', 'تصفح المنتجات'),
                    'url'  => alomran_get_option('hero_button1_url', '/products'),
                ),
                'button2'     => array(
                    'text' => alomran_get_option('hero_button2_text', 'استشارة مجانية'),
                    'url'  => alomran_get_option('hero_button2_url', '/contact'),
                ),
                'background'  => array('url' => $bg_url),
                'show_seal'   => alomran_get_option('hero_show_seal', true),
            );
            break;
            
        case 'risks':
            $risks_text = alomran_get_option('risks_items', '');
            $data = array(
                'enable' => alomran_get_option('risks_enable', true),
                'title'  => alomran_get_option('risks_title', 'المخاطر في أنظمة الصرف الرديئة'),
                'items'  => is_array($risks_text) ? $risks_text : alomran_parse_risks_items($risks_text),
            );
            break;
            
        case 'sectors':
            $sectors_text = alomran_get_option('sectors_items', '');
            $data = array(
                'enable'    => alomran_get_option('sectors_enable', true),
                'title'     => alomran_get_option('sectors_title', 'قطاعات نخدمها'),
                'subtitle'  => alomran_get_option('sectors_subtitle', 'نقدم حلولاً متخصصة لكل قطاع لضمان الكفاءة القصوى'),
                'items'     => is_array($sectors_text) ? $sectors_text : alomran_parse_sectors_items($sectors_text),
            );
            break;
            
        case 'products':
            $data = array(
                'enable'        => alomran_get_option('products_enable', true),
                'title'         => alomran_get_option('products_title', 'منتجات مختارة'),
                'count'         => alomran_get_option('products_count', 3),
                'show_all_link' => alomran_get_option('products_show_all_link', true),
            );
            break;
            
        case 'stainless':
            $stainless_text = alomran_get_option('stainless_items', '');
            $data = array(
                'enable'   => alomran_get_option('stainless_enable', true),
                'title'    => alomran_get_option('stainless_title', 'ليش الاستانلس ستيل هو الخيار الأمثل؟'),
                'subtitle' => alomran_get_option('stainless_subtitle', 'الجودة التي تستحق الاستثمار'),
                'items'    => is_array($stainless_text) ? $stainless_text : alomran_parse_stainless_items($stainless_text),
            );
            break;
            
        case 'testimonials':
            $data = array(
                'enable' => alomran_get_option('testimonials_enable', true),
                'title'  => alomran_get_option('testimonials_title', 'شركاء النجاح'),
                'count'  => alomran_get_option('testimonials_count', 2),
            );
            break;
    }
    
    return $data;
}

