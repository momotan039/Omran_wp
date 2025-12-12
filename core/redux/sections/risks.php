<?php
/**
 * Risks Section Configuration
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => 'قسم المخاطر',
    'id'         => 'risks_section',
    'subsection' => true,
    'parent'     => 'homepage_sections',
    'icon'       => 'el el-warning-sign',
    'fields' => array(
        array(
            'id'       => 'risks_enable',
            'type'     => 'switch',
            'title'    => 'تفعيل قسم المخاطر',
            'default'  => true,
        ),
        array(
            'id'       => 'risks_title',
            'type'     => 'text',
            'title'    => 'عنوان القسم',
            'default'  => 'المخاطر في أنظمة الصرف الرديئة',
            'required' => array('risks_enable', '=', true),
        ),
        array(
            'id'          => 'risks_items',
            'type'        => 'textarea',
            'title'       => 'عناصر المخاطر',
            'subtitle'    => 'أدخل كل عنصر بصيغة: العنوان | الوصف (كل عنصر في سطر منفصل)',
            'default'     => "انسداد متكرر | يعطّل خطوط الإنتاج ويوقف العمل.\nتآكل سريع | يؤدي إلى تسرّب الروائح والمياه وتلوث البيئة.\nنمو بكتيري | بسبب استخدام خامات رديئة غير مقاومة للميكروبات.\nخسائر تشغيلية | تكاليف باهظة بسبب الأعطال والصيانة المستمرة.\nتهديد السلامة | مخالفة معايير السلامة في المنشآت الغذائية والصناعية.",
            'rows'        => 10,
            'required'    => array('risks_enable', '=', true),
        ),
    ),
));

