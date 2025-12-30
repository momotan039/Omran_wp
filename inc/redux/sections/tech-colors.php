<?php
/**
 * Tech Preset - Colors Configuration
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
    'title'      => __('إعدادات الألوان', 'alomran'),
    'id'         => 'tech_colors_settings',
    'subsection' => true,
    'parent'     => 'tech_general_sections',
    'icon'       => 'el el-brush',
    'fields'     => array(
        array(
            'id'       => 'tech_color_primary',
            'type'     => 'color',
            'title'    => __('اللون الأساسي', 'alomran'),
            'default'  => '#2563eb',
        ),
        array(
            'id'       => 'tech_color_secondary',
            'type'     => 'color',
            'title'    => __('اللون الثانوي', 'alomran'),
            'default'  => '#1e293b',
        ),
        array(
            'id'       => 'tech_color_accent',
            'type'     => 'color',
            'title'    => __('لون التمييز', 'alomran'),
            'default'  => '#6366f1',
        ),
    ),
));



