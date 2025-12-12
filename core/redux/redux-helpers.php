<?php
/**
 * Redux Framework Helper Functions Loader
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load core Redux files
require_once OMRAN_CORE_DIR . '/redux/options.php';
require_once OMRAN_CORE_DIR . '/redux/section-data.php';

/**
 * Sanitize Redux sorter field values to ensure they are always arrays
 * This fixes the array_merge error when saved values are strings
 * 
 * @param array $options Redux options array.
 * @return array Sanitized options array.
 */
function omran_core_sanitize_redux_sorter_fields($options) {
    if (!is_array($options)) {
        return $options;
    }
    
    // List of sorter field IDs that need sanitization
    $sorter_fields = array(
        'ads_header_pages',
        'ads_sidebar_pages',
        'ads_content_before_pages',
        'ads_content_after_pages',
        'ads_footer_pages',
    );
    
    // Default structures for each field
    $defaults = array(
        'ads_header_pages' => array(
            'enabled'  => array(),
            'disabled' => array(
                'home'    => 'الصفحة الرئيسية',
                'product' => 'صفحات المنتجات',
                'news'    => 'صفحات الأخبار',
                'single'  => 'الصفحات والمقالات',
                'archive' => 'أرشيفات',
            ),
        ),
        'ads_sidebar_pages' => array(
            'enabled'  => array(),
            'disabled' => array(
                'home'    => 'الصفحة الرئيسية',
                'product' => 'صفحات المنتجات',
                'news'    => 'صفحات الأخبار',
                'single'  => 'الصفحات والمقالات',
                'archive' => 'أرشيفات',
            ),
        ),
        'ads_content_before_pages' => array(
            'enabled'  => array(),
            'disabled' => array(
                'product' => 'صفحات المنتجات',
                'news'    => 'صفحات الأخبار',
                'single'  => 'الصفحات والمقالات',
            ),
        ),
        'ads_content_after_pages' => array(
            'enabled'  => array(),
            'disabled' => array(
                'product' => 'صفحات المنتجات',
                'news'    => 'صفحات الأخبار',
                'single'  => 'الصفحات والمقالات',
            ),
        ),
        'ads_footer_pages' => array(
            'enabled'  => array(),
            'disabled' => array(
                'home'    => 'الصفحة الرئيسية',
                'product' => 'صفحات المنتجات',
                'news'    => 'صفحات الأخبار',
                'single'  => 'الصفحات والمقالات',
                'archive' => 'أرشيفات',
            ),
        ),
    );
    
    // Sanitize each sorter field
    foreach ($sorter_fields as $field_id) {
        if (!isset($options[$field_id])) {
            continue;
        }
        
        $value = $options[$field_id];
        
        // If value is not an array, replace with default
        if (!is_array($value)) {
            if (isset($defaults[$field_id])) {
                $options[$field_id] = $defaults[$field_id];
            } else {
                $options[$field_id] = array('enabled' => array(), 'disabled' => array());
            }
            continue;
        }
        
        // If array but missing required keys, fix it
        if (!isset($value['enabled']) || !isset($value['disabled'])) {
            if (isset($defaults[$field_id])) {
                $options[$field_id] = array(
                    'enabled'  => isset($value['enabled']) && is_array($value['enabled']) ? $value['enabled'] : $defaults[$field_id]['enabled'],
                    'disabled' => isset($value['disabled']) && is_array($value['disabled']) ? $value['disabled'] : $defaults[$field_id]['disabled'],
                );
            } else {
                $options[$field_id] = array(
                    'enabled'  => isset($value['enabled']) && is_array($value['enabled']) ? $value['enabled'] : array(),
                    'disabled' => isset($value['disabled']) && is_array($value['disabled']) ? $value['disabled'] : array(),
                );
            }
            continue;
        }
        
        // Ensure both enabled and disabled are arrays
        $options[$field_id] = array(
            'enabled'  => is_array($value['enabled']) ? $value['enabled'] : array(),
            'disabled' => is_array($value['disabled']) ? $value['disabled'] : array(),
        );
    }
    
    return $options;
}

// Hook into Redux to sanitize options when loaded
add_filter('redux/options/alomran_options', 'omran_core_sanitize_redux_sorter_fields', 1);
add_filter('option_alomran_options', 'omran_core_sanitize_redux_sorter_fields', 1);

// Backward compatibility
if (!function_exists('alomran_sanitize_redux_sorter_fields')) {
    function alomran_sanitize_redux_sorter_fields($options) {
        return omran_core_sanitize_redux_sorter_fields($options);
    }
}

