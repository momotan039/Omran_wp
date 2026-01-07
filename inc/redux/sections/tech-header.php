<?php
/**
 * Tech Preset - Header Configuration
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
    'title'      => __('إعدادات الهيدر', 'alomran'),
    'id'         => 'tech_header_settings',
    'subsection' => true,
    'parent'     => 'tech_general_sections',
    'icon'       => 'el el-arrow-up',
    'fields'     => array(
        array(
            'id'       => 'tech_header_logo_text',
            'type'     => 'text',
            'title'    => __('نص الشعار', 'alomran'),
            'default'  => 'إتقان',
        ),
        array(
            'id'       => 'tech_header_logo_image',
            'type'     => 'media',
            'title'    => __('صورة الشعار', 'alomran'),
            'subtitle' => __('إذا تم تحديد صورة، سيتم استخدامها بدلاً من النص', 'alomran'),
        ),
    ),
));












