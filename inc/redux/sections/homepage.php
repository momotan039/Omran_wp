<?php
/**
 * Homepage Sections - Main Section
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

// Main Homepage Section
Redux::setSection($opt_name, array(
    'title'  => 'الصفحة الرئيسية',
    'id'     => 'homepage_sections',
    'icon'   => 'el el-home',
    'desc'   => 'إعدادات أقسام الصفحة الرئيسية',
));

