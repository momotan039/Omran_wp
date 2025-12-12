<?php
/**
 * Redux Section Data Retrieval
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once OMRAN_CORE_DIR . '/redux/parsers.php';

/**
 * Load section data (internal function)
 * 
 * @param string $section Section identifier.
 * @return array Section data.
 */
function omran_core_load_section_data($section) {
    $data = array();
    
    switch ($section) {
        case 'hero':
            $bg = omran_core_get_option('hero_background_image', array());
            $bg_url = is_array($bg) && isset($bg['url']) ? $bg['url'] : (is_string($bg) ? $bg : '');
            
            $data = array(
                'enable'      => omran_core_get_option('hero_enable', true),
                'badge'       => omran_core_get_option('hero_badge', __('الرائدون في مصر', 'alomran')),
                'title'       => omran_core_get_option('hero_title', __('جودة تدوم.. لمستقبل أنقى', 'alomran')),
                'subtitle'    => omran_core_get_option('hero_subtitle', __('في كل قطرة ومشروع', 'alomran')),
                'description' => omran_core_get_option('hero_description', ''),
                'button1'     => array(
                    'text' => omran_core_get_option('hero_button1_text', __('تصفح المنتجات', 'alomran')),
                    'url'  => alomran_format_url(omran_core_get_option('hero_button1_url', '/products')),
                ),
                'button2'     => array(
                    'text' => omran_core_get_option('hero_button2_text', __('استشارة مجانية', 'alomran')),
                    'url'  => alomran_format_url(omran_core_get_option('hero_button2_url', '/contact')),
                ),
                'background'  => array('url' => $bg_url),
                'show_seal'   => omran_core_get_option('hero_show_seal', true),
            );
            break;
            
        case 'risks':
            $risks_text = omran_core_get_option('risks_items', '');
            $data = array(
                'enable' => omran_core_get_option('risks_enable', true),
                'title'  => omran_core_get_option('risks_title', __('المخاطر في أنظمة الصرف الرديئة', 'alomran')),
                'items'  => is_array($risks_text) ? $risks_text : omran_core_parse_risks_items($risks_text),
            );
            break;
            
        case 'sectors':
            $sectors_text = omran_core_get_option('sectors_items', '');
            $data = array(
                'enable'    => omran_core_get_option('sectors_enable', true),
                'title'     => omran_core_get_option('sectors_title', __('قطاعات نخدمها', 'alomran')),
                'subtitle'  => omran_core_get_option('sectors_subtitle', __('نقدم حلولاً متخصصة لكل قطاع لضمان الكفاءة القصوى', 'alomran')),
                'items'     => is_array($sectors_text) ? $sectors_text : omran_core_parse_sectors_items($sectors_text),
            );
            break;
            
        case 'products':
            $data = array(
                'enable'        => omran_core_get_option('products_enable', true),
                'title'         => omran_core_get_option('products_title', __('منتجات مختارة', 'alomran')),
                'count'         => omran_core_get_option('products_count', 3),
                'show_all_link' => omran_core_get_option('products_show_all_link', true),
            );
            break;
            
        case 'stainless':
            $stainless_text = omran_core_get_option('stainless_items', '');
            $data = array(
                'enable'   => omran_core_get_option('stainless_enable', true),
                'title'    => omran_core_get_option('stainless_title', __('ليش الاستانلس ستيل هو الخيار الأمثل؟', 'alomran')),
                'subtitle' => omran_core_get_option('stainless_subtitle', __('الجودة التي تستحق الاستثمار', 'alomran')),
                'items'    => is_array($stainless_text) ? $stainless_text : omran_core_parse_stainless_items($stainless_text),
            );
            break;
            
        case 'testimonials':
            $data = array(
                'enable' => omran_core_get_option('testimonials_enable', true),
                'title'  => omran_core_get_option('testimonials_title', __('شركاء النجاح', 'alomran')),
                'count'  => omran_core_get_option('testimonials_count', 2),
            );
            break;
            
        case 'about':
        case 'about_header':
            $data = array(
                'enable'      => omran_core_get_option('about_header_enable', true),
                'title'      => omran_core_get_option('about_header_title', __('من نحن', 'alomran')),
                'subtitle'   => omran_core_get_option('about_header_subtitle', __('شركاؤكم في البناء والتطوير منذ عام ١٩٩٨', 'alomran')),
            );
            break;
            
        case 'about_content':
            $about_image = omran_core_get_option('about_main_image', array());
            $about_image_url = is_array($about_image) && isset($about_image['url']) ? $about_image['url'] : (is_string($about_image) ? $about_image : '');
            
            $data = array(
                'enable' => omran_core_get_option('about_content_enable', true),
                'image'  => $about_image_url,
                'title'  => omran_core_get_option('about_title', __('عن شركة العمران', 'alomran')),
                'content' => omran_core_get_option('about_content', ''),
            );
            break;
            
        case 'about_vision_mission':
            $data = array(
                'enable'       => omran_core_get_option('about_vision_mission_enable', true),
                'vision_title' => omran_core_get_option('about_vision_title', __('رؤيتنا', 'alomran')),
                'vision'       => omran_core_get_option('about_vision', ''),
                'mission_title' => omran_core_get_option('about_mission_title', __('رسالتنا', 'alomran')),
                'mission'      => omran_core_get_option('about_mission', ''),
            );
            break;
            
        case 'about_stats':
            $data = array(
                'enable' => omran_core_get_option('about_stats_enable', true),
                'stats'  => array(
                    array(
                        'number' => omran_core_get_option('about_stat1_number', '25+'),
                        'label'  => omran_core_get_option('about_stat1_label', __('عام من الخبرة', 'alomran')),
                    ),
                    array(
                        'number' => omran_core_get_option('about_stat2_number', '500+'),
                        'label'  => omran_core_get_option('about_stat2_label', __('مشروع ناجح', 'alomran')),
                    ),
                    array(
                        'number' => omran_core_get_option('about_stat3_number', '100%'),
                        'label'  => omran_core_get_option('about_stat3_label', __('صنع في مصر', 'alomran')),
                    ),
                ),
            );
            break;
            
        case 'footer':
            // Get company description from about page or custom field
            $use_about_info = omran_core_get_option('footer_use_about_info', true);
            $company_description = '';
            if ($use_about_info) {
                $about_mission = omran_core_get_option('about_mission', '');
                $company_description = !empty($about_mission) ? $about_mission : omran_core_get_option('footer_company_description', '');
            } else {
                $company_description = omran_core_get_option('footer_company_description', '');
            }
            
            // Get WhatsApp number and format it
            $whatsapp_number = omran_core_get_option('footer_whatsapp_number', '');
            $whatsapp_url = '';
            if (!empty($whatsapp_number)) {
                $clean_number = preg_replace('/[^0-9]/', '', $whatsapp_number);
                $whatsapp_url = 'https://wa.me/' . $clean_number;
            }
            
            $data = array(
                'use_about_info' => $use_about_info,
                'description'    => $company_description,
                'social_enable'  => omran_core_get_option('footer_social_enable', true),
                'social_links'   => array(
                    'facebook'  => alomran_format_url(omran_core_get_option('footer_facebook_url', '')),
                    'linkedin'  => alomran_format_url(omran_core_get_option('footer_linkedin_url', '')),
                    'instagram' => alomran_format_url(omran_core_get_option('footer_instagram_url', '')),
                    'twitter'   => alomran_format_url(omran_core_get_option('footer_twitter_url', '')),
                    'youtube'   => alomran_format_url(omran_core_get_option('footer_youtube_url', '')),
                    'whatsapp'  => $whatsapp_url,
                ),
            );
            break;
            
        case 'contact_page':
            $map_url = omran_core_get_option('contact_map_url', '');
            
            $data = array(
                'title'          => omran_core_get_option('contact_page_title', __('تواصل معنا', 'alomran')),
                'subtitle'       => omran_core_get_option('contact_page_subtitle', __('فريقنا جاهز للرد على استفساراتكم وتقديم الدعم الفني', 'alomran')),
                'form_title'     => omran_core_get_option('contact_form_title', __('أرسل رسالة', 'alomran')),
                'phone_title'    => omran_core_get_option('contact_phone_title', __('اتصل بنا', 'alomran')),
                'phone_subtitle' => omran_core_get_option('contact_phone_subtitle', __('متاحين من 9 صباحاً - 5 مساءً', 'alomran')),
                'email_title'    => omran_core_get_option('contact_email_title', __('البريد الإلكتروني', 'alomran')),
                'email_subtitle' => omran_core_get_option('contact_email_subtitle', __('للتعاقدات والمبيعات', 'alomran')),
                'address_title'  => omran_core_get_option('contact_address_title', __('المقر الرئيسي', 'alomran')),
                'map_enable'     => omran_core_get_option('contact_map_enable', true),
                'map_url'        => $map_url,
                'map_text'       => omran_core_get_option('contact_map_text', __('موقع المصنع', 'alomran')),
            );
            break;
    }
    
    return $data;
}


