<?php
/**
 * Tech Preset - Homepage Main Section
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

// Main Homepage Section
Redux::setSection($opt_name, array(
    'title'  => __('الصفحة الرئيسية', 'alomran'),
    'id'     => 'tech_homepage_sections',
    'icon'   => 'el el-home',
    'desc'   => __('إعدادات جميع أقسام الصفحة الرئيسية. يمكنك تفعيل/تعطيل كل قسم وتعديل محتواه بالكامل من هنا.', 'alomran'),
));

