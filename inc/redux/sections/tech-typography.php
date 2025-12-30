<?php
/**
 * Tech Preset - Typography Configuration
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
    'title'      => __('إعدادات الخطوط', 'alomran'),
    'id'         => 'tech_typography_settings',
    'subsection' => true,
    'parent'     => 'tech_general_sections',
    'icon'       => 'el el-font',
    'fields'     => array(
        array(
            'id'       => 'tech_typography_font_family',
            'type'     => 'select',
            'title'    => __('عائلة الخط', 'alomran'),
            'options'  => array(
                'cairo' => 'Cairo',
                'tajawal' => 'Tajawal',
                'almarai' => 'Almarai',
            ),
            'default'  => 'cairo',
        ),
    ),
));



