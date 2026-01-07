<?php
/**
 * Redux Framework Helper Functions Loader
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once ALOMRAN_THEME_DIR . '/inc/redux/redux-helpers-core.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-redux-repeater.php';
require_once ALOMRAN_THEME_DIR . '/inc/redux/options.php';
require_once ALOMRAN_THEME_DIR . '/inc/redux/section-data.php';

/**
 * Sanitize Redux sorter field values to ensure they are always arrays
 */
function alomran_sanitize_redux_sorter_fields($options) {
    if (!is_array($options)) {
        return $options;
    }
    
    $sorter_fields = array(
        'ads_header_pages',
        'ads_sidebar_pages',
        'ads_content_before_pages',
        'ads_content_after_pages',
        'ads_footer_pages',
    );
    
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
    
    foreach ($sorter_fields as $field_id) {
        if (!isset($options[$field_id])) {
            continue;
        }
        
        $value = $options[$field_id];
        
        if (!is_array($value)) {
            $options[$field_id] = isset($defaults[$field_id]) ? $defaults[$field_id] : array('enabled' => array(), 'disabled' => array());
            continue;
        }
        
        if (!isset($value['enabled']) || !isset($value['disabled'])) {
            $options[$field_id] = array(
                'enabled'  => isset($value['enabled']) && is_array($value['enabled']) ? $value['enabled'] : (isset($defaults[$field_id]['enabled']) ? $defaults[$field_id]['enabled'] : array()),
                'disabled' => isset($value['disabled']) && is_array($value['disabled']) ? $value['disabled'] : (isset($defaults[$field_id]['disabled']) ? $defaults[$field_id]['disabled'] : array()),
            );
            continue;
        }
        
        $options[$field_id] = array(
            'enabled'  => is_array($value['enabled']) ? $value['enabled'] : array(),
            'disabled' => is_array($value['disabled']) ? $value['disabled'] : array(),
        );
    }
    
    return $options;
}

/**
 * Sanitize Redux repeater fields to remove duplicates
 */
function alomran_sanitize_redux_repeater_fields($options) {
    if (!is_array($options)) {
        return $options;
    }
    
    $repeater_fields = array(
        'tech_features_preview_items',
        'tech_stats_items',
        'tech_testimonials_items',
    );
    
    foreach ($repeater_fields as $field_id) {
        if (!isset($options[$field_id]) || !is_array($options[$field_id])) {
            continue;
        }
        
        $items = $options[$field_id];
        $unique = array();
        $seen = array();
        
        foreach ($items as $item) {
            if (!is_array($item) || empty($item)) {
                continue;
            }
            
            $unique_key = '';
            if (isset($item['feature_title'])) {
                $unique_key = 'feature_' . md5($item['feature_title'] . (isset($item['feature_description']) ? $item['feature_description'] : ''));
            } elseif (isset($item['stat_label'])) {
                $unique_key = 'stat_' . md5($item['stat_label'] . (isset($item['stat_number']) ? $item['stat_number'] : ''));
            } elseif (isset($item['testimonial_name'])) {
                $unique_key = 'testimonial_' . md5($item['testimonial_name'] . (isset($item['testimonial_content']) ? $item['testimonial_content'] : ''));
            } else {
                $unique_key = md5(serialize($item));
            }
            
            if (!isset($seen[$unique_key])) {
                $seen[$unique_key] = true;
                $unique[] = $item;
            }
        }
        
        if (count($unique) !== count($items)) {
            $options[$field_id] = array_values($unique);
        }
    }
    
    return $options;
}

add_filter('redux/options/alomran_options', 'alomran_sanitize_redux_sorter_fields', 1);
add_filter('option_alomran_options', 'alomran_sanitize_redux_sorter_fields', 1);
add_filter('redux/options/alomran_options', 'alomran_sanitize_redux_repeater_fields', 2);
add_filter('option_alomran_options', 'alomran_sanitize_redux_repeater_fields', 2);
