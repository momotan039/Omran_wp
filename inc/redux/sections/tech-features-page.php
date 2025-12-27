<?php
/**
 * Tech Preset - Features Page Configuration
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
    'title'      => __('صفحة المميزات', 'alomran'),
    'id'         => 'tech_features_page',
    'subsection' => true,
    'parent'     => 'tech_pages_sections',
    'icon'       => 'el el-star',
    'fields'     => array(
        array(
            'id'       => 'tech_features_page_title',
            'type'     => 'text',
            'title'    => __('عنوان الصفحة', 'alomran'),
            'default'  => 'بنية تحتية تنمو مع أعمالك',
        ),
        array(
            'id'       => 'tech_features_page_title_highlight',
            'type'     => 'text',
            'title'    => __('جزء العنوان المميز', 'alomran'),
            'default'  => 'تنمو مع أعمالك',
        ),
    ),
));


