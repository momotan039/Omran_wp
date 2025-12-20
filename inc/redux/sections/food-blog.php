<?php
/**
 * Food Preset - Blog Section Configuration
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
    'title'      => __('المجلة', 'alomran'),
    'id'         => 'food_blog_section',
    'subsection' => true,
    'parent'     => 'food_homepage_sections',
    'icon'       => 'el el-edit',
    'fields'     => array(
        array(
            'id'       => 'food_blog_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل قسم المجلة', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'food_blog_title',
            'type'     => 'text',
            'title'    => __('عنوان القسم', 'alomran'),
            'default'  => 'المجلة والنمط الغذائي',
            'required' => array('food_blog_enable', '=', true),
        ),
        array(
            'id'       => 'food_blog_posts_per_page',
            'type'     => 'spinner',
            'title'    => __('عدد المقالات في الصفحة', 'alomran'),
            'default'  => 6,
            'min'      => 3,
            'max'      => 12,
            'step'     => 3,
            'required' => array('food_blog_enable', '=', true),
        ),
        array(
            'id'       => 'food_blog_random_order',
            'type'     => 'switch',
            'title'    => __('عرض المقالات بشكل عشوائي', 'alomran'),
            'subtitle' => __('عند التفعيل، سيتم عرض المقالات بشكل عشوائي بدلاً من الترتيب حسب التاريخ', 'alomran'),
            'default'  => false,
            'required' => array('food_blog_enable', '=', true),
        ),
    ),
));

