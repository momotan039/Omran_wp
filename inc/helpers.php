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

/**
 * Get page by Arabic title or English slug.
 * This allows pages to be named in Arabic while still being findable.
 *
 * @param string $identifier Page title (Arabic) or slug (English).
 * @return WP_Post|null
 */
function alomran_get_page($identifier) {
    // First try to find by slug (English fallback)
    $page = get_page_by_path($identifier);
    
    if ($page) {
        return $page;
    }
    
    // If not found by slug, try to find by title (supports Arabic)
    global $wpdb;
    $page_id = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} 
        WHERE post_type = 'page' 
        AND post_status = 'publish' 
        AND post_title = %s 
        LIMIT 1",
        $identifier
    ));
    
    if ($page_id) {
        return get_post($page_id);
    }
    
    return null;
}

/**
 * Get page permalink by Arabic title or English slug.
 *
 * @param string $identifier Page title (Arabic) or slug (English).
 * @return string|false
 */
function alomran_get_page_url($identifier) {
    $page = alomran_get_page($identifier);
    return $page ? get_permalink($page) : false;
}

/**
 * Parse features from textarea (ACF free compatible).
 * Converts line-separated text into array format.
 *
 * @param string|array $features Features field value.
 * @return array
 */
function alomran_parse_features($features) {
    // If already an array (from ACF Pro repeater), return as is
    if (is_array($features) && !empty($features) && isset($features[0]['feature_text'])) {
        return $features;
    }
    
    // If it's a string (from textarea), parse it
    if (is_string($features) && !empty($features)) {
        $lines = array_filter(array_map('trim', explode("\n", $features)));
        $parsed = array();
        foreach ($lines as $line) {
            if (!empty($line)) {
                $parsed[] = array('feature_text' => $line);
            }
        }
        return $parsed;
    }
    
    // If it's already an array of strings, convert it
    if (is_array($features) && !empty($features) && is_string($features[0])) {
        $parsed = array();
        foreach ($features as $feature) {
            if (!empty($feature)) {
                $parsed[] = array('feature_text' => $feature);
            }
        }
        return $parsed;
    }
    
    return array();
}

/**
 * Parse specifications from textarea (ACF free compatible).
 * Converts "Label: Value" format into array format.
 *
 * @param string|array $specs Specs field value.
 * @return array
 */
function alomran_parse_specs($specs) {
    // If already an array (from ACF Pro repeater), return as is
    if (is_array($specs) && !empty($specs) && isset($specs[0]['label'])) {
        return $specs;
    }
    
    // If it's a string (from textarea), parse it
    if (is_string($specs) && !empty($specs)) {
        $lines = array_filter(array_map('trim', explode("\n", $specs)));
        $parsed = array();
        foreach ($lines as $line) {
            if (!empty($line)) {
                // Check if line contains colon separator
                if (strpos($line, ':') !== false) {
                    $parts = explode(':', $line, 2);
                    $label = trim($parts[0]);
                    $value = isset($parts[1]) ? trim($parts[1]) : '';
                    if (!empty($label)) {
                        $parsed[] = array(
                            'label' => $label,
                            'value' => $value
                        );
                    }
                } else {
                    // If no colon, treat entire line as label with empty value
                    $parsed[] = array(
                        'label' => $line,
                        'value' => ''
                    );
                }
            }
        }
        return $parsed;
    }
    
    return array();
}

