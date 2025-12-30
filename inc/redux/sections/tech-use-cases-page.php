<?php
/**
 * Tech Preset - Use Cases Page Configuration
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
    'title'      => __('صفحة حالات الاستخدام', 'alomran'),
    'id'         => 'tech_use_cases_page',
    'subsection' => true,
    'parent'     => 'tech_pages_sections',
    'icon'       => 'el el-list',
    'fields'     => array(
        array(
            'id'       => 'tech_use_cases_page_title',
            'type'     => 'text',
            'title'    => __('عنوان الصفحة', 'alomran'),
            'default'  => 'حلول مصممة لتحدياتك',
        ),
        array(
            'id'       => 'tech_use_cases_page_subtitle',
            'type'     => 'textarea',
            'title'    => __('العنوان الفرعي', 'alomran'),
            'default'  => 'نحن نفهم تحديات السوق المحلي ونقدم حلولاً تقنية تعالج جذور المشكلة.',
        ),
    ),
));



