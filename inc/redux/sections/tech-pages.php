<?php
/**
 * Tech Preset - Pages Main Section
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

// Main Pages Section
Redux::setSection($opt_name, array(
    'title'  => __('الصفحات', 'alomran'),
    'id'     => 'tech_pages_sections',
    'icon'   => 'el el-file-edit',
    'desc'   => __('إعدادات صفحات الموقع', 'alomran'),
));



