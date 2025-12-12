<?php
/**
 * Company Information Helpers
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Retrieve company info from Redux options.
 *
 * @return array
 */
function alomran_get_company_info() {
    return array(
        'name'    => alomran_get_option('company_name', 'العمران للصناعات المتطورة'),
        'slogan'  => alomran_get_option('company_slogan', 'جودة تدوم.. لمستقبل أنقى'),
        'vision'  => alomran_get_option('company_vision', 'أن نكون الرائد في صناعة أنظمة الصرف الصحي الآمنة والمستدامة في المنطقة، مع الالتزام بأعلى معايير الجودة والابتكار.'),
        'mission' => alomran_get_option('company_mission', 'توفير منتجات عالية الجودة تحمي البنية التحتية والبيئة، مع التركيز على الابتكار والاستدامة ورضا العملاء.'),
        'phone'   => alomran_get_option('company_phone', '+20 100 123 4567'),
        'email'   => alomran_get_option('company_email', 'info@alomran-eg.com'),
        'address' => alomran_get_option('company_address', 'المنطقة الصناعية الثالثة، مدينة العاشر من رمضان، مصر'),
    );
}

/**
 * Get header logo settings.
 *
 * @return array
 */
function alomran_get_header_logo_settings() {
    $company_info = alomran_get_company_info();
    
    $logo_icon = alomran_get_option('header_logo_icon', '');
    $icon_url = '';
    if (!empty($logo_icon) && is_array($logo_icon) && isset($logo_icon['url'])) {
        $icon_url = $logo_icon['url'];
    } elseif (!empty($logo_icon) && is_numeric($logo_icon)) {
        $icon_url = wp_get_attachment_image_url($logo_icon, 'full');
    } elseif (is_string($logo_icon) && !empty($logo_icon)) {
        $icon_url = $logo_icon;
    }
    
    $custom_title = alomran_get_option('header_logo_custom_title', '');
    $custom_subtitle = alomran_get_option('header_logo_custom_subtitle', '');
    
    return array(
        'icon_url'      => $icon_url,
        'show_title'    => alomran_get_option('header_logo_show_title', true),
        'show_subtitle' => alomran_get_option('header_logo_show_subtitle', true),
        'title'         => !empty($custom_title) ? $custom_title : $company_info['name'],
        'subtitle'      => !empty($custom_subtitle) ? $custom_subtitle : $company_info['slogan'],
    );
}

