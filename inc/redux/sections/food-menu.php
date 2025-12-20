<?php
/**
 * Food Preset - Menu Section Configuration
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
    'title'      => __('قائمة الطعام', 'alomran'),
    'id'         => 'food_menu_section',
    'subsection' => true,
    'parent'     => 'food_homepage_sections',
    'icon'       => 'el el-list',
    'fields'     => array(
        array(
            'id'       => 'food_menu_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل قسم القائمة', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'food_menu_title',
            'type'     => 'text',
            'title'    => __('عنوان القسم', 'alomran'),
            'default'  => 'مختارات النخبة',
            'required' => array('food_menu_enable', '=', true),
        ),
        array(
            'id'       => 'food_menu_subtitle',
            'type'     => 'text',
            'title'    => __('العنوان الفرعي', 'alomran'),
            'default'  => "Chef's Selection",
            'required' => array('food_menu_enable', '=', true),
        ),
        array(
            'id'       => 'food_menu_description',
            'type'     => 'textarea',
            'title'    => __('الوصف', 'alomran'),
            'default'  => 'كل طبق هو رحلة عبر الزمن، محضرة بأفضل المكونات الموسمية والتقنيات العصرية.',
            'required' => array('food_menu_enable', '=', true),
        ),
        array(
            'id'       => 'food_menu_items_per_page',
            'type'     => 'spinner',
            'title'    => __('عدد الأصناف في الصفحة', 'alomran'),
            'default'  => 6,
            'min'      => 3,
            'max'      => 12,
            'step'     => 3,
            'required' => array('food_menu_enable', '=', true),
        ),
        array(
            'id'       => 'food_menu_show_categories',
            'type'     => 'switch',
            'title'    => __('إظهار الفئات', 'alomran'),
            'default'  => true,
            'required' => array('food_menu_enable', '=', true),
        ),
        array(
            'id'       => 'food_menu_random_order',
            'type'     => 'switch',
            'title'    => __('عرض الأصناف بشكل عشوائي', 'alomran'),
            'subtitle' => __('عند التفعيل، سيتم عرض الأصناف بشكل عشوائي بدلاً من الترتيب الافتراضي', 'alomran'),
            'default'  => false,
            'required' => array('food_menu_enable', '=', true),
        ),
    ),
));

