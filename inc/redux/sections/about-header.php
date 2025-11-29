<?php
/**
 * About Page Header Section
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => 'رأس الصفحة',
    'id'         => 'about_header_section',
    'subsection' => true,
    'parent'     => 'about_page_sections',
    'icon'       => 'el el-file-edit',
    'fields' => array(
        array(
            'id'       => 'about_header_enable',
            'type'     => 'switch',
            'title'    => 'تفعيل رأس الصفحة',
            'default'  => true,
        ),
        array(
            'id'       => 'about_header_title',
            'type'     => 'text',
            'title'    => 'عنوان الصفحة',
            'default'  => 'من نحن',
            'required' => array('about_header_enable', '=', true),
        ),
        array(
            'id'       => 'about_header_subtitle',
            'type'     => 'text',
            'title'    => 'العنوان الفرعي',
            'default'  => 'شركاؤكم في البناء والتطوير منذ عام ١٩٩٨',
            'required' => array('about_header_enable', '=', true),
        ),
    ),
));

