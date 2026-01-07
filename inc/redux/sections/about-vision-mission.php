<?php
/**
 * About Page Vision & Mission Section
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => 'الرؤية والرسالة',
    'id'         => 'about_vision_mission_section',
    'subsection' => true,
    'parent'     => 'about_page_sections',
    'icon'       => 'el el-eye-open',
    'fields' => array(
        array(
            'id'       => 'about_vision_mission_enable',
            'type'     => 'switch',
            'title'    => 'تفعيل قسم الرؤية والرسالة',
            'default'  => true,
        ),
        array(
            'id'       => 'about_vision_title',
            'type'     => 'text',
            'title'    => 'عنوان الرؤية',
            'default'  => 'رؤيتنا',
            'required' => array('about_vision_mission_enable', '=', true),
        ),
        array(
            'id'       => 'about_vision',
            'type'     => 'textarea',
            'title'    => 'نص الرؤية',
            'default'  => 'أن نكون الرائد في صناعة أنظمة الصرف الصحي الآمنة والمستدامة في مصر والمنطقة، وأن نكون الشريك المفضل للعملاء في مشاريعهم الإنشائية والصناعية.',
            'rows'     => 4,
            'required' => array('about_vision_mission_enable', '=', true),
        ),
        array(
            'id'       => 'about_mission_title',
            'type'     => 'text',
            'title'    => 'عنوان الرسالة',
            'default'  => 'رسالتنا',
            'required' => array('about_vision_mission_enable', '=', true),
        ),
        array(
            'id'       => 'about_mission',
            'type'     => 'textarea',
            'title'    => 'نص الرسالة',
            'default'  => 'توفير منتجات عالية الجودة تحمي البنية التحتية والبيئة، مع تقديم خدمات استشارية متخصصة وضمان رضا العملاء من خلال الابتكار والتميز في التصنيع.',
            'rows'     => 4,
            'required' => array('about_vision_mission_enable', '=', true),
        ),
    ),
));

