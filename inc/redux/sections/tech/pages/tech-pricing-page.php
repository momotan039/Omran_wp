<?php
/**
 * Tech Preset - Pricing Page Configuration
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
    'title'      => __('صفحة الأسعار', 'alomran'),
    'id'         => 'tech_pricing_page',
    'subsection' => true,
    'parent'     => 'tech_pages_sections',
    'icon'       => 'el el-usd',
    'fields'     => array(
        array(
            'id'       => 'tech_pricing_page_title',
            'type'     => 'text',
            'title'    => __('عنوان الصفحة', 'alomran'),
            'default'  => 'خطط مرنة وشفافة',
        ),
        array(
            'id'       => 'tech_pricing_page_title_highlight',
            'type'     => 'text',
            'title'    => __('جزء العنوان المميز', 'alomran'),
            'default'  => 'مرنة وشفافة',
        ),
        array(
            'id'       => 'tech_pricing_show_annual_toggle',
            'type'     => 'switch',
            'title'    => __('إظهار مفتاح الشهري/السنوي', 'alomran'),
            'default'  => true,
        ),
    ),
));


