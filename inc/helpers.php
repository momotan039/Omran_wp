<?php
/**
 * Helper utilities.
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Retrieve company info stored in the Customizer.
 *
 * @return array
 */
function alomran_get_company_info() {
    return array(
        'name'    => get_theme_mod('company_name', 'العمران للصناعات المتطورة'),
        'slogan'  => get_theme_mod('company_slogan', 'جودة تدوم.. لمستقبل أنقى'),
        'vision'  => get_theme_mod('company_vision', 'أن نكون الرائد في صناعة أنظمة الصرف الصحي الآمنة...'),
        'mission' => get_theme_mod('company_mission', 'توفير منتجات عالية الجودة تحمي البنية التحتية والبيئة...'),
        'phone'   => get_theme_mod('company_phone', '+20 100 123 4567'),
        'email'   => get_theme_mod('company_email', 'info@alomran-eg.com'),
        'address' => get_theme_mod('company_address', 'المنطقة الصناعية الثالثة، مدينة العاشر من رمضان، مصر'),
    );
}

/**
 * Map product category enums to readable labels.
 *
 * @param string $category Enum key.
 * @return string
 */
function alomran_get_product_category_label($category) {
    $labels = array(
        'DRAIN_GRILLS'   => 'مصافي وجريلات',
        'GREASE_TRAPS'   => 'مصائد شحوم',
        'WATER_TREATMENT'=> 'معالجة مياه',
    );

    return isset($labels[$category]) ? $labels[$category] : $category;
}

