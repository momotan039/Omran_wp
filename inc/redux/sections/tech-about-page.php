<?php
/**
 * Tech Preset - About Page Configuration
 * 
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Redux')) {
    return;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => __('صفحة من نحن', 'alomran'),
    'id'         => 'tech_about_page',
    'subsection' => true,
    'parent'     => 'tech_pages_sections',
    'icon'       => 'el el-info-circle',
    'fields'     => array(
        array(
            'id'       => 'tech_about_page_title',
            'type'     => 'text',
            'title'    => __('عنوان الصفحة', 'alomran'),
            'default'  => 'نعيد تعريف الربط التقني في المنطقة',
        ),
        array(
            'id'       => 'tech_about_page_title_highlight',
            'type'     => 'text',
            'title'    => __('جزء العنوان المميز', 'alomran'),
            'default'  => 'الربط التقني',
        ),
        array(
            'id'       => 'tech_about_page_description',
            'type'     => 'textarea',
            'title'    => __('الوصف', 'alomran'),
            'default'  => 'نحن لا نقدم مجرد برمجيات، بل نبني جسوراً تقنية تربط بين أعمالك وبين طموحات عملائك. "إتقان" هي ثمرة سنوات من البحث والتطوير في السوق السعودي.',
        ),
        array(
            'id'       => 'tech_about_page_image',
            'type'     => 'media',
            'title'    => __('صورة الفريق', 'alomran'),
        ),
        array(
            'id'       => 'tech_about_stats_years',
            'type'     => 'text',
            'title'    => __('عدد سنوات الخبرة', 'alomran'),
            'default'  => '+10',
        ),
        array(
            'id'       => 'tech_about_stats_partners',
            'type'     => 'text',
            'title'    => __('عدد الشركاء', 'alomran'),
            'default'  => '+500',
        ),
        array(
            'id'       => 'tech_about_location_title',
            'type'     => 'text',
            'title'    => __('عنوان الموقع', 'alomran'),
            'default'  => 'مقرنا بالرياض',
        ),
        array(
            'id'       => 'tech_about_location_address',
            'type'     => 'text',
            'title'    => __('عنوان الموقع', 'alomran'),
            'default'  => 'حي الصحافة، مركز الابتكار الرقمي',
        ),
        array(
            'id'       => 'tech_about_location_image',
            'type'     => 'media',
            'title'    => __('صورة الموقع', 'alomran'),
        ),
    ),
));



