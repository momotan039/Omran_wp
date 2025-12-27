<?php
/**
 * Tech Preset - General Settings Main Section
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

// Main General Settings Section
Redux::setSection($opt_name, array(
    'title'  => __('إعدادات عامة', 'alomran'),
    'id'     => 'tech_general_sections',
    'icon'   => 'el el-cog',
    'desc'   => __('الإعدادات العامة للقالب التقني', 'alomran'),
));


