<?php
/**
 * About Page Sections Order Configuration
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => 'ترتيب أقسام من نحن',
    'id'         => 'about_sections_order',
    'subsection' => true,
    'parent'     => 'about_page_sections',
    'icon'       => 'el el-sort',
    'fields' => array(
        array(
            'id'       => 'about_sections_order',
            'type'     => 'sorter',
            'title'    => 'ترتيب الأقسام',
            'subtitle' => 'اسحب الأقسام لإعادة ترتيبها',
            'options'  => array(
                'enabled'  => array(
                    'header'        => 'رأس الصفحة',
                    'content'       => 'المحتوى الرئيسي',
                    'vision_mission' => 'الرؤية والرسالة',
                    'stats'         => 'الإحصائيات',
                ),
                'disabled' => array(),
            ),
        ),
    ),
));

