<?php
/**
 * Sectors Section Configuration
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'  => 'قسم القطاعات',
    'id'     => 'sectors_section',
    'icon'   => 'el el-th',
    'fields' => array(
        array(
            'id'       => 'sectors_enable',
            'type'     => 'switch',
            'title'    => 'تفعيل قسم القطاعات',
            'default'  => true,
        ),
        array(
            'id'       => 'sectors_title',
            'type'     => 'text',
            'title'    => 'عنوان القسم',
            'default'  => 'قطاعات نخدمها',
            'required' => array('sectors_enable', '=', true),
        ),
        array(
            'id'       => 'sectors_subtitle',
            'type'     => 'text',
            'title'    => 'العنوان الفرعي',
            'default'  => 'نقدم حلولاً متخصصة لكل قطاع لضمان الكفاءة القصوى',
            'required' => array('sectors_enable', '=', true),
        ),
        array(
            'id'          => 'sectors_items',
            'type'        => 'textarea',
            'title'       => 'عناصر القطاعات',
            'subtitle'    => 'أدخل كل قطاع بصيغة: العنوان | الوصف | الرمز (كل قطاع في سطر منفصل)',
            'default'     => "القطاع السكني | حلول للصرف المنزلي، مصائد شحوم للمطابخ، وأنظمة ري ذكية. | residential\nالقطاع الصناعي | جريلات تتحمل الأوزان الثقيلة، ومعالجة المياه الصناعية المعقدة. | industrial\nالمطاعم والفنادق | أنظمة صحية تمنع الروائح والقوارض وتوافق اشتراطات السلامة الغذائية. | hospitality",
            'rows'        => 10,
            'required'    => array('sectors_enable', '=', true),
        ),
    ),
));

