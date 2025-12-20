<?php
/**
 * Food Preset - Footer Section Configuration
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
    'title'      => __('التذييل', 'alomran'),
    'id'         => 'food_footer_section',
    'subsection' => true,
    'parent'     => 'food_general_sections',
    'icon'       => 'el el-arrow-down',
    'fields'     => array(
        array(
            'id'       => 'food_footer_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل التذييل', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'food_footer_description',
            'type'     => 'textarea',
            'title'    => __('الوصف', 'alomran'),
            'default'  => 'حيث تتحول النكهات إلى قصص، والمكان إلى ذكرى تدوم. الجوهرة هي وجهتكم الأولى لتعريف الفخامة بمفهوم عربي أصيل.',
            'required' => array('food_footer_enable', '=', true),
        ),
        array(
            'id'       => 'food_footer_copyright',
            'type'     => 'text',
            'title'    => __('حقوق النشر', 'alomran'),
            'default'  => '© ' . date('Y') . ' Al-Jawhara. All Rights Reserved.',
            'required' => array('food_footer_enable', '=', true),
        ),
    ),
));

