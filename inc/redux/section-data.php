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
            $bg_url = alomran_extract_image_url(alomran_get_option('hero_background_image', array()));
            
            $data = array(
                'enable'      => alomran_get_option('hero_enable', true),
                'badge'       => alomran_get_option('hero_badge', 'الرائدون في مصر'),
                'title'       => alomran_get_option('hero_title', 'جودة تدوم.. لمستقبل أنقى'),
                'subtitle'    => alomran_get_option('hero_subtitle', 'في كل قطرة ومشروع'),
                'description' => alomran_get_option('hero_description', ''),
                'button1'     => array(
                    'text' => alomran_get_option('hero_button1_text', 'تصفح المنتجات'),
                    'url'  => alomran_format_url(alomran_get_option('hero_button1_url', '/products')),
                ),
                'button2'     => array(
                    'text' => alomran_get_option('hero_button2_text', 'استشارة مجانية'),
                    'url'  => alomran_format_url(alomran_get_option('hero_button2_url', '/contact')),
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
            
        case 'about':
        case 'about_header':
            $data = array(
                'enable'      => alomran_get_option('about_header_enable', true),
                'title'      => alomran_get_option('about_header_title', 'من نحن'),
                'subtitle'   => alomran_get_option('about_header_subtitle', 'شركاؤكم في البناء والتطوير منذ عام ١٩٩٨'),
            );
            break;
            
        case 'about_content':
            $data = array(
                'enable' => alomran_get_option('about_content_enable', true),
                'image'  => alomran_extract_image_url(alomran_get_option('about_main_image', array())),
                'title'  => alomran_get_option('about_title', 'عن شركة العمران'),
                'content' => alomran_get_option('about_content', ''),
            );
            break;
            
        case 'about_vision_mission':
            $data = array(
                'enable'       => alomran_get_option('about_vision_mission_enable', true),
                'vision_title' => alomran_get_option('about_vision_title', 'رؤيتنا'),
                'vision'       => alomran_get_option('about_vision', ''),
                'mission_title' => alomran_get_option('about_mission_title', 'رسالتنا'),
                'mission'      => alomran_get_option('about_mission', ''),
            );
            break;
            
        case 'about_stats':
            $data = array(
                'enable' => alomran_get_option('about_stats_enable', true),
                'stats'  => array(
                    array(
                        'number' => alomran_get_option('about_stat1_number', '25+'),
                        'label'  => alomran_get_option('about_stat1_label', 'عام من الخبرة'),
                    ),
                    array(
                        'number' => alomran_get_option('about_stat2_number', '500+'),
                        'label'  => alomran_get_option('about_stat2_label', 'مشروع ناجح'),
                    ),
                    array(
                        'number' => alomran_get_option('about_stat3_number', '100%'),
                        'label'  => alomran_get_option('about_stat3_label', 'صنع في مصر'),
                    ),
                ),
            );
            break;
            
        case 'footer':
            // Get company description from about page or custom field
            $use_about_info = alomran_get_option('footer_use_about_info', true);
            $company_description = '';
            if ($use_about_info) {
                $about_mission = alomran_get_option('about_mission', '');
                $company_description = !empty($about_mission) ? $about_mission : alomran_get_option('footer_company_description', '');
            } else {
                $company_description = alomran_get_option('footer_company_description', '');
            }
            
            // Get WhatsApp number and format it
            $whatsapp_number = alomran_get_option('footer_whatsapp_number', '');
            $whatsapp_url = '';
            if (!empty($whatsapp_number)) {
                $clean_number = preg_replace('/[^0-9]/', '', $whatsapp_number);
                $whatsapp_url = 'https://wa.me/' . $clean_number;
            }
            
            $data = array(
                'use_about_info' => $use_about_info,
                'description'    => $company_description,
                'social_enable'  => alomran_get_option('footer_social_enable', true),
                'social_links'   => array(
                    'facebook'  => alomran_format_url(alomran_get_option('footer_facebook_url', '')),
                    'linkedin'  => alomran_format_url(alomran_get_option('footer_linkedin_url', '')),
                    'instagram' => alomran_format_url(alomran_get_option('footer_instagram_url', '')),
                    'twitter'   => alomran_format_url(alomran_get_option('footer_twitter_url', '')),
                    'youtube'   => alomran_format_url(alomran_get_option('footer_youtube_url', '')),
                    'whatsapp'  => $whatsapp_url,
                ),
            );
            break;
            
        case 'contact_page':
            $preset = AlOmran_Preset_Loader::get_active_preset();
            $data = alomran_get_contact_page_data($preset);
            break;
    }
    
    return $data;
}


