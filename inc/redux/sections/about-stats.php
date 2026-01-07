<?php
/**
 * About Page Stats Section
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => 'الإحصائيات',
    'id'         => 'about_stats_section',
    'subsection' => true,
    'parent'     => 'about_page_sections',
    'icon'       => 'el el-graph',
    'fields' => array(
        array(
            'id'       => 'about_stats_enable',
            'type'     => 'switch',
            'title'    => 'تفعيل قسم الإحصائيات',
            'default'  => true,
        ),
        array(
            'id'       => 'about_stat1_number',
            'type'     => 'text',
            'title'    => 'الإحصائية الأولى - الرقم',
            'default'  => '25+',
            'required' => array('about_stats_enable', '=', true),
        ),
        array(
            'id'       => 'about_stat1_label',
            'type'     => 'text',
            'title'    => 'الإحصائية الأولى - التسمية',
            'default'  => 'عام من الخبرة',
            'required' => array('about_stats_enable', '=', true),
        ),
        array(
            'id'       => 'about_stat2_number',
            'type'     => 'text',
            'title'    => 'الإحصائية الثانية - الرقم',
            'default'  => '500+',
            'required' => array('about_stats_enable', '=', true),
        ),
        array(
            'id'       => 'about_stat2_label',
            'type'     => 'text',
            'title'    => 'الإحصائية الثانية - التسمية',
            'default'  => 'مشروع ناجح',
            'required' => array('about_stats_enable', '=', true),
        ),
        array(
            'id'       => 'about_stat3_number',
            'type'     => 'text',
            'title'    => 'الإحصائية الثالثة - الرقم',
            'default'  => '100%',
            'required' => array('about_stats_enable', '=', true),
        ),
        array(
            'id'       => 'about_stat3_label',
            'type'     => 'text',
            'title'    => 'الإحصائية الثالثة - التسمية',
            'default'  => 'صنع في مصر',
            'required' => array('about_stats_enable', '=', true),
        ),
    ),
));

