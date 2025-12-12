<?php
/**
 * Stainless Steel Section Configuration
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => 'قسم الاستانلس ستيل',
    'id'         => 'stainless_section',
    'subsection' => true,
    'parent'     => 'homepage_sections',
    'icon'       => 'el el-star',
    'fields' => array(
        array(
            'id'       => 'stainless_enable',
            'type'     => 'switch',
            'title'    => 'تفعيل قسم الاستانلس ستيل',
            'default'  => true,
        ),
        array(
            'id'       => 'stainless_title',
            'type'     => 'text',
            'title'    => 'عنوان القسم',
            'default'  => 'ليش الاستانلس ستيل هو الخيار الأمثل؟',
            'required' => array('stainless_enable', '=', true),
        ),
        array(
            'id'       => 'stainless_subtitle',
            'type'     => 'text',
            'title'    => 'العنوان الفرعي',
            'default'  => 'الجودة التي تستحق الاستثمار',
            'required' => array('stainless_enable', '=', true),
        ),
        array(
            'id'          => 'stainless_items',
            'type'        => 'textarea',
            'title'       => 'مميزات الاستانلس ستيل',
            'subtitle'    => 'أدخل كل ميزة في سطر منفصل',
            'default'     => "مقاومة عالية للتآكل في البيئات الرطبة.\nعمر افتراضي طويل وصيانة شبه معدومة.\nيمنع تراكم البكتيريا وسهل التنظيف.\nيتحمل درجات حرارة مختلفة.\nيحافظ على جودة الأنظمة ويقلل الأعطال.\nمناسب للمنشآت الغذائية وفق المعايير الدولية.",
            'rows'        => 10,
            'required'    => array('stainless_enable', '=', true),
        ),
    ),
));

