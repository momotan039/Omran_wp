<?php
/**
 * Sections Order Configuration
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => 'ترتيب الأقسام',
    'id'         => 'sections_order',
    'subsection' => true,
    'parent'     => 'homepage_sections',
    'icon'       => 'el el-sort',
    'fields' => array(
        array(
            'id'       => 'sections_order',
            'type'     => 'sorter',
            'title'    => 'ترتيب الأقسام',
            'subtitle' => 'اسحب الأقسام لإعادة ترتيبها',
            'options'  => array(
                'enabled'  => array(
                    'hero'         => 'قسم البطل',
                    'risks'        => 'قسم المخاطر',
                    'sectors'      => 'قسم القطاعات',
                    'products'     => 'قسم المنتجات',
                    'stainless'    => 'قسم الاستانلس ستيل',
                    'testimonials' => 'قسم الشهادات',
                ),
                'disabled' => array(),
            ),
        ),
    ),
));


