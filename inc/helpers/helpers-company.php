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
 * Get header logo URL with fallback priority.
 * Priority: header_logo > header_logo_icon > custom_logo
 *
 * @return string Logo URL
 */
function alomran_get_header_logo_url() {
    // Try new header_logo field first
    $header_logo = alomran_get_option('header_logo', array());
    if (!empty($header_logo) && isset($header_logo['url'])) {
        return $header_logo['url'];
    }
    
    // Fallback to old header_logo_icon field (backward compatibility)
    $logo_icon = alomran_get_option('header_logo_icon', '');
    if (!empty($logo_icon)) {
        if (is_array($logo_icon) && isset($logo_icon['url'])) {
            return $logo_icon['url'];
        } elseif (is_numeric($logo_icon)) {
            $url = wp_get_attachment_image_url($logo_icon, 'full');
            if ($url) {
                return $url;
            }
        } elseif (is_string($logo_icon) && !empty($logo_icon)) {
            return $logo_icon;
        }
    }
    
    // Final fallback to WordPress custom logo
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $url = wp_get_attachment_image_url($custom_logo_id, 'full');
        if ($url) {
            return $url;
        }
    }
    
    return '';
}

/**
 * Get header logo title with fallback priority.
 * Priority: header_logo_title > header_logo_custom_title > company_name
 *
 * @return string Title text
 */
function alomran_get_header_logo_title() {
    $company_info = alomran_get_company_info();
    
    // Try new header_logo_title field first
    $logo_title = alomran_get_option('header_logo_title', '');
    if (!empty($logo_title)) {
        return $logo_title;
    }
    
    // Fallback to old header_logo_custom_title field (backward compatibility)
    $custom_title = alomran_get_option('header_logo_custom_title', '');
    if (!empty($custom_title)) {
        return $custom_title;
    }
    
    // Final fallback to company name
    return $company_info['name'];
}

/**
 * Get header logo subtitle with fallback priority.
 * Priority: header_logo_subtitle > header_logo_custom_subtitle > company_slogan
 *
 * @return string Subtitle text
 */
function alomran_get_header_logo_subtitle() {
    $company_info = alomran_get_company_info();
    
    // Try new header_logo_subtitle field first
    $logo_subtitle = alomran_get_option('header_logo_subtitle', '');
    if (!empty($logo_subtitle)) {
        return $logo_subtitle;
    }
    
    // Fallback to old header_logo_custom_subtitle field (backward compatibility)
    $custom_subtitle = alomran_get_option('header_logo_custom_subtitle', '');
    if (!empty($custom_subtitle)) {
        return $custom_subtitle;
    }
    
    // Final fallback to company slogan
    return $company_info['slogan'];
}

/**
 * Get header logo settings (unified function for backward compatibility).
 *
 * @return array {
 *     @type string $icon_url      Logo URL
 *     @type bool   $show_title    Whether to show title
 *     @type bool   $show_subtitle Whether to show subtitle
 *     @type string $title         Title text
 *     @type string $subtitle      Subtitle text
 *     @type int    $width         Logo width in pixels
 *     @type int    $height        Logo height in pixels
 * }
 */
function alomran_get_header_logo_settings() {
    return array(
        'icon_url'      => alomran_get_header_logo_url(),
        'show_title'    => alomran_get_option('header_logo_show_title', true),
        'show_subtitle' => alomran_get_option('header_logo_show_subtitle', true),
        'title'         => alomran_get_header_logo_title(),
        'subtitle'      => alomran_get_header_logo_subtitle(),
        'width'         => alomran_get_option('header_logo_width', 150),
        'height'        => alomran_get_option('header_logo_height', 60),
    );
}

