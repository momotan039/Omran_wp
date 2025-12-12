<?php
/**
 * Ads / Monetization Settings - Simplified
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'  => __('الإعلانات والربح', 'alomran'),
    'id'     => 'ads-settings',
    'desc'   => __('إعدادات الإعلانات ونظام الربح - بسيط وسهل', 'alomran'),
    'icon'   => 'el el-usd',
    'fields' => array(
        // Global Ads Toggle
        array(
            'id'       => 'ads_global_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل الإعلانات', 'alomran'),
            'subtitle' => __('تفعيل أو تعطيل جميع الإعلانات على الموقع', 'alomran'),
            'default'  => false,
        ),
        
        // AdSense Publisher ID (Global)
        array(
            'id'       => 'adsense_publisher_id',
            'type'     => 'text',
            'title'    => __('معرف الناشر AdSense', 'alomran'),
            'subtitle' => __('أدخل معرف الناشر الخاص بك من Google AdSense', 'alomran'),
            'desc'     => __('مثال: ca-pub-4680336731771243 أو فقط 4680336731771243', 'alomran'),
            'placeholder' => 'ca-pub-xxxxxxxxxxxxx',
            'required' => array('ads_global_enable', '=', true),
        ),
        
        // Demo Ads Section
        array(
            'id'       => 'demo_ads_section',
            'type'     => 'section',
            'title'    => __('إعلانات تجريبية', 'alomran'),
            'subtitle' => __('عرض إعلانات تجريبية لمعاينة المظهر قبل إضافة الإعلانات الحقيقية', 'alomran'),
            'indent'   => true,
        ),
        
        array(
            'id'       => 'demo_ads_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل الإعلانات التجريبية', 'alomran'),
            'subtitle' => __('عند التفعيل، سيتم عرض إعلانات تجريبية بدلاً من الإعلانات الحقيقية', 'alomran'),
            'default'  => false,
            'required' => array('ads_global_enable', '=', true),
        ),
        
        // Real Ads Section
        array(
            'id'       => 'real_ads_section',
            'type'     => 'section',
            'title'    => __('إعلانات AdSense الحقيقية', 'alomran'),
            'subtitle' => __('أدخل معرفات Ad Slot لكل موقع إعلان', 'alomran'),
            'indent'   => true,
        ),
        
        // Header Ads
        array(
            'id'       => 'header_ads_section',
            'type'     => 'section',
            'title'    => __('إعلانات الهيدر', 'alomran'),
            'indent'   => true,
        ),
        
        array(
            'id'       => 'ads_header_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل إعلانات الهيدر', 'alomran'),
            'default'  => false,
            'required' => array('ads_global_enable', '=', true),
        ),
        
        array(
            'id'       => 'ads_header_pages',
            'type'     => 'sorter',
            'title'    => __('عرض إعلانات الهيدر على', 'alomran'),
            'subtitle' => __('اسحب الصفحات من "معطل" إلى "مفعل"', 'alomran'),
            'options'  => array(
                'enabled'  => array(),
                'disabled' => array(
                    'home'    => 'الصفحة الرئيسية',
                    'product' => 'صفحات المنتجات',
                    'news'    => 'صفحات الأخبار',
                    'single'  => 'الصفحات والمقالات',
                    'archive' => 'أرشيفات',
                ),
            ),
            'default'  => array(
                'enabled'  => array(),
                'disabled' => array(
                    'home'    => 'الصفحة الرئيسية',
                    'product' => 'صفحات المنتجات',
                    'news'    => 'صفحات الأخبار',
                    'single'  => 'الصفحات والمقالات',
                    'archive' => 'أرشيفات',
                ),
            ),
            'required' => array('ads_header_enable', '=', true),
        ),
        
        array(
            'id'       => 'ads_header_slot',
            'type'     => 'text',
            'title'    => __('Ad Slot ID للهيدر', 'alomran'),
            'subtitle' => __('أدخل Ad Slot ID من Google AdSense', 'alomran'),
            'desc'     => __('مثال: 1234567890 (الرقم فقط، بدون ca-pub-)', 'alomran'),
            'placeholder' => '1234567890',
            'required' => array('ads_header_enable', '=', true),
        ),
        
        // Sidebar Ads
        array(
            'id'       => 'sidebar_ads_section',
            'type'     => 'section',
            'title'    => __('إعلانات الشريط الجانبي', 'alomran'),
            'indent'   => true,
        ),
        
        array(
            'id'       => 'ads_sidebar_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل إعلانات الشريط الجانبي', 'alomran'),
            'default'  => false,
            'required' => array('ads_global_enable', '=', true),
        ),
        
        array(
            'id'       => 'ads_sidebar_pages',
            'type'     => 'sorter',
            'title'    => __('عرض إعلانات الشريط الجانبي على', 'alomran'),
            'subtitle' => __('اسحب الصفحات من "معطل" إلى "مفعل"', 'alomran'),
            'options'  => array(
                'enabled'  => array(),
                'disabled' => array(
                    'home'    => 'الصفحة الرئيسية',
                    'product' => 'صفحات المنتجات',
                    'news'    => 'صفحات الأخبار',
                    'single'  => 'الصفحات والمقالات',
                    'archive' => 'أرشيفات',
                ),
            ),
            'default'  => array(
                'enabled'  => array(),
                'disabled' => array(
                    'home'    => 'الصفحة الرئيسية',
                    'product' => 'صفحات المنتجات',
                    'news'    => 'صفحات الأخبار',
                    'single'  => 'الصفحات والمقالات',
                    'archive' => 'أرشيفات',
                ),
            ),
            'required' => array('ads_sidebar_enable', '=', true),
        ),
        
        array(
            'id'       => 'ads_sidebar_slot',
            'type'     => 'text',
            'title'    => __('Ad Slot ID للشريط الجانبي', 'alomran'),
            'subtitle' => __('أدخل Ad Slot ID من Google AdSense', 'alomran'),
            'desc'     => __('مثال: 1234567890', 'alomran'),
            'placeholder' => '1234567890',
            'required' => array('ads_sidebar_enable', '=', true),
        ),
        
        // Content Ads
        array(
            'id'       => 'content_ads_section',
            'type'     => 'section',
            'title'    => __('إعلانات المحتوى', 'alomran'),
            'indent'   => true,
        ),
        
        array(
            'id'       => 'ads_content_before_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل إعلان قبل المحتوى', 'alomran'),
            'default'  => false,
            'required' => array('ads_global_enable', '=', true),
        ),
        
        array(
            'id'       => 'ads_content_before_pages',
            'type'     => 'sorter',
            'title'    => __('عرض إعلان قبل المحتوى على', 'alomran'),
            'subtitle' => __('اسحب الصفحات من "معطل" إلى "مفعل"', 'alomran'),
            'options'  => array(
                'enabled'  => array(),
                'disabled' => array(
                    'product' => 'صفحات المنتجات',
                    'news'    => 'صفحات الأخبار',
                    'single'  => 'الصفحات والمقالات',
                ),
            ),
            'default'  => array(
                'enabled'  => array(),
                'disabled' => array(
                    'product' => 'صفحات المنتجات',
                    'news'    => 'صفحات الأخبار',
                    'single'  => 'الصفحات والمقالات',
                ),
            ),
            'required' => array('ads_content_before_enable', '=', true),
        ),
        
        array(
            'id'       => 'ads_content_before_slot',
            'type'     => 'text',
            'title'    => __('Ad Slot ID قبل المحتوى', 'alomran'),
            'subtitle' => __('أدخل Ad Slot ID من Google AdSense', 'alomran'),
            'desc'     => __('مثال: 1234567890', 'alomran'),
            'placeholder' => '1234567890',
            'required' => array('ads_content_before_enable', '=', true),
        ),
        
        array(
            'id'       => 'ads_content_after_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل إعلان بعد المحتوى', 'alomran'),
            'default'  => false,
            'required' => array('ads_global_enable', '=', true),
        ),
        
        array(
            'id'       => 'ads_content_after_pages',
            'type'     => 'sorter',
            'title'    => __('عرض إعلان بعد المحتوى على', 'alomran'),
            'subtitle' => __('اسحب الصفحات من "معطل" إلى "مفعل"', 'alomran'),
            'options'  => array(
                'enabled'  => array(),
                'disabled' => array(
                    'product' => 'صفحات المنتجات',
                    'news'    => 'صفحات الأخبار',
                    'single'  => 'الصفحات والمقالات',
                ),
            ),
            'default'  => array(
                'enabled'  => array(),
                'disabled' => array(
                    'product' => 'صفحات المنتجات',
                    'news'    => 'صفحات الأخبار',
                    'single'  => 'الصفحات والمقالات',
                ),
            ),
            'required' => array('ads_content_after_enable', '=', true),
        ),
        
        array(
            'id'       => 'ads_content_after_slot',
            'type'     => 'text',
            'title'    => __('Ad Slot ID بعد المحتوى', 'alomran'),
            'subtitle' => __('أدخل Ad Slot ID من Google AdSense', 'alomran'),
            'desc'     => __('مثال: 1234567890', 'alomran'),
            'placeholder' => '1234567890',
            'required' => array('ads_content_after_enable', '=', true),
        ),
        
        // Footer Ads
        array(
            'id'       => 'footer_ads_section',
            'type'     => 'section',
            'title'    => __('إعلانات الفوتر', 'alomran'),
            'indent'   => true,
        ),
        
        array(
            'id'       => 'ads_footer_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل إعلانات الفوتر', 'alomran'),
            'default'  => false,
            'required' => array('ads_global_enable', '=', true),
        ),
        
        array(
            'id'       => 'ads_footer_pages',
            'type'     => 'sorter',
            'title'    => __('عرض إعلانات الفوتر على', 'alomran'),
            'subtitle' => __('اسحب الصفحات من "معطل" إلى "مفعل"', 'alomran'),
            'options'  => array(
                'enabled'  => array(),
                'disabled' => array(
                    'home'    => 'الصفحة الرئيسية',
                    'product' => 'صفحات المنتجات',
                    'news'    => 'صفحات الأخبار',
                    'single'  => 'الصفحات والمقالات',
                    'archive' => 'أرشيفات',
                ),
            ),
            'default'  => array(
                'enabled'  => array(),
                'disabled' => array(
                    'home'    => 'الصفحة الرئيسية',
                    'product' => 'صفحات المنتجات',
                    'news'    => 'صفحات الأخبار',
                    'single'  => 'الصفحات والمقالات',
                    'archive' => 'أرشيفات',
                ),
            ),
            'required' => array('ads_footer_enable', '=', true),
        ),
        
        array(
            'id'       => 'ads_footer_slot',
            'type'     => 'text',
            'title'    => __('Ad Slot ID للفوتر', 'alomran'),
            'subtitle' => __('أدخل Ad Slot ID من Google AdSense', 'alomran'),
            'desc'     => __('مثال: 1234567890', 'alomran'),
            'placeholder' => '1234567890',
            'required' => array('ads_footer_enable', '=', true),
        ),
        
        // Widget Ads
        array(
            'id'       => 'widget_ads_section',
            'type'     => 'section',
            'title'    => __('إعلانات الويدجت', 'alomran'),
            'indent'   => true,
        ),
        
        array(
            'id'       => 'ads_widget_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل إعلانات الويدجت', 'alomran'),
            'default'  => false,
            'required' => array('ads_global_enable', '=', true),
        ),
        
        array(
            'id'       => 'ads_widget_slot',
            'type'     => 'text',
            'title'    => __('Ad Slot ID للويدجت', 'alomran'),
            'subtitle' => __('أدخل Ad Slot ID من Google AdSense', 'alomran'),
            'desc'     => __('مثال: 1234567890', 'alomran'),
            'placeholder' => '1234567890',
            'required' => array('ads_widget_enable', '=', true),
        ),
    ),
));
