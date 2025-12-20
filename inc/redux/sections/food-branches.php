<?php
/**
 * Food Preset - Branches Section Configuration
 * 
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Redux')) {
    return;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => __('الفروع', 'alomran'),
    'id'         => 'food_branches_section',
    'subsection' => true,
    'parent'     => 'food_homepage_sections',
    'icon'       => 'el el-map-marker',
    'fields'     => array(
        array(
            'id'       => 'food_branches_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل قسم الفروع', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'food_branches_title',
            'type'     => 'text',
            'title'    => __('عنوان القسم', 'alomran'),
            'default'  => 'فروعنا',
            'required' => array('food_branches_enable', '=', true),
        ),
        array(
            'id'       => 'food_branches_subtitle',
            'type'     => 'text',
            'title'    => __('العنوان الفرعي', 'alomran'),
            'default'  => 'نتشرف بزيارتكم في مواقعنا المميزة',
            'required' => array('food_branches_enable', '=', true),
        ),
    ),
));

