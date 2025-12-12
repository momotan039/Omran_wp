<?php
/**
 * Translation & Multi-Language Support
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load theme text domain
 */
function alomran_load_textdomain() {
    load_theme_textdomain('alomran', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'alomran_load_textdomain');

/**
 * Get current language code
 * 
 * @return string
 */
function alomran_get_current_language() {
    // WPML support
    if (defined('ICL_LANGUAGE_CODE')) {
        return ICL_LANGUAGE_CODE;
    }
    
    // Polylang support
    if (function_exists('pll_current_language')) {
        return pll_current_language();
    }
    
    // Default
    return get_locale();
}

/**
 * Check if RTL language
 * 
 * @return bool
 */
function alomran_is_rtl() {
    $locale = get_locale();
    $rtl_languages = array('ar', 'he', 'fa', 'ur');
    
    foreach ($rtl_languages as $rtl_lang) {
        if (strpos($locale, $rtl_lang) === 0) {
            return true;
        }
    }
    
    return false;
}

/**
 * Get HTML direction attribute
 * 
 * @return string
 */
function alomran_get_html_dir() {
    return alomran_is_rtl() ? 'rtl' : 'ltr';
}

/**
 * Get language attribute for HTML tag
 * 
 * @return string
 */
function alomran_get_html_lang() {
    $locale = get_locale();
    return str_replace('_', '-', $locale);
}

/**
 * WPML compatibility: Register strings for translation
 */
function alomran_wpml_register_strings() {
    if (!function_exists('icl_register_string')) {
        return;
    }
    
    // Register common strings
    $strings = array(
        'الرئيسية' => 'Home',
        'المنتجات' => 'Products',
        'الأخبار' => 'News',
        'من نحن' => 'About Us',
        'اتصل بنا' => 'Contact Us',
        'تواصل للسعر' => 'Contact for Price',
        'منتج مميز' => 'Featured Product',
        'المواصفات الفنية' => 'Technical Specifications',
        'المميزات الرئيسية' => 'Main Features',
        'طلب عرض سعر' => 'Request Quote',
        'مشاركة المنتج' => 'Share Product',
    );
    
    foreach ($strings as $string => $context) {
        icl_register_string('alomran', $string, $string);
    }
}

/**
 * Get translated string (WPML/Polylang compatible)
 * 
 * @param string $string String to translate
 * @param string $context Context for translation
 * @return string
 */
function alomran_translate($string, $context = 'alomran') {
    // WPML
    if (function_exists('icl_t')) {
        return icl_t($context, $string, $string);
    }
    
    // Polylang
    if (function_exists('pll__')) {
        return pll__($string);
    }
    
    // WordPress native
    return __($string, 'alomran');
}

/**
 * Echo translated string
 * 
 * @param string $string String to translate
 * @param string $context Context for translation
 */
function alomran_translate_e($string, $context = 'alomran') {
    echo alomran_translate($string, $context);
}

/**
 * WPML: Register theme options for translation
 */
function alomran_wpml_register_options() {
    if (!function_exists('icl_register_string')) {
        return;
    }
    
    // Register Redux options that should be translatable
    $translatable_options = array(
        'company_name',
        'company_slogan',
        'company_vision',
        'company_mission',
    );
    
    foreach ($translatable_options as $option) {
        $value = alomran_get_option($option, '');
        if (!empty($value)) {
            icl_register_string('alomran', $option, $value);
        }
    }
}
add_action('redux/options/alomran_options/saved', 'alomran_wpml_register_options');

/**
 * Polylang: Register strings
 */
function alomran_polylang_register_strings() {
    if (!function_exists('pll_register_string')) {
        return;
    }
    
    $strings = array(
        'الرئيسية',
        'المنتجات',
        'الأخبار',
        'من نحن',
        'اتصل بنا',
        'تواصل للسعر',
        'منتج مميز',
    );
    
    foreach ($strings as $string) {
        pll_register_string('alomran', $string, 'Theme Strings');
    }
}
add_action('init', 'alomran_polylang_register_strings');

/**
 * Filter HTML direction based on language
 */
function alomran_filter_html_attributes($output, $doctype) {
    if ($doctype === 'html') {
        $dir = alomran_get_html_dir();
        $lang = alomran_get_html_lang();
        
        // Update dir attribute
        $output = preg_replace('/dir="[^"]*"/', 'dir="' . esc_attr($dir) . '"', $output);
        if (strpos($output, 'dir=') === false) {
            $output = str_replace('<html ', '<html dir="' . esc_attr($dir) . '" ', $output);
        }
        
        // Update lang attribute
        $output = preg_replace('/lang="[^"]*"/', 'lang="' . esc_attr($lang) . '"', $output);
    }
    
    return $output;
}
add_filter('language_attributes', 'alomran_filter_html_attributes', 10, 2);

