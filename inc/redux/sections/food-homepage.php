<?php
/**
 * Food Preset - Homepage Main Section
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

// Main Homepage Section
Redux::setSection($opt_name, array(
    'title'  => __('الصفحة الرئيسية', 'alomran'),
    'id'     => 'food_homepage_sections',
    'icon'   => 'el el-home',
    'desc'   => __('إعدادات أقسام الصفحة الرئيسية', 'alomran'),
));


