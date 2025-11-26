<?php
/**
 * Testimonials Section Configuration
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'  => 'قسم الشهادات',
    'id'     => 'testimonials_section',
    'icon'   => 'el el-quote-right',
    'fields' => array(
        array(
            'id'       => 'testimonials_enable',
            'type'     => 'switch',
            'title'    => 'تفعيل قسم الشهادات',
            'default'  => true,
        ),
        array(
            'id'       => 'testimonials_title',
            'type'     => 'text',
            'title'    => 'عنوان القسم',
            'default'  => 'شركاء النجاح',
            'required' => array('testimonials_enable', '=', true),
        ),
        array(
            'id'       => 'testimonials_count',
            'type'     => 'spinner',
            'title'    => 'عدد الشهادات',
            'default'  => 2,
            'min'      => 1,
            'max'      => 6,
            'step'     => 1,
            'required' => array('testimonials_enable', '=', true),
        ),
    ),
));

