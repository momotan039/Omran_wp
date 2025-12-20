<?php
/**
 * Food Preset - Pages Main Section
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

// Main Pages Section
Redux::setSection($opt_name, array(
    'title'  => __('الصفحات', 'alomran'),
    'id'     => 'food_pages_sections',
    'icon'   => 'el el-file',
    'desc'   => __('إعدادات صفحات الموقع', 'alomran'),
));

// Experience Section
Redux::setSection($opt_name, array(
    'title'      => __('التجربة', 'alomran'),
    'id'         => 'food_experience_section',
    'subsection' => true,
    'parent'     => 'food_pages_sections',
    'icon'       => 'el el-star',
    'fields'     => array(
        array(
            'id'       => 'food_experience_title',
            'type'     => 'text',
            'title'    => __('عنوان القسم', 'alomran'),
            'default'  => 'فن الأجواء',
        ),
        array(
            'id'       => 'food_experience_quote',
            'type'     => 'text',
            'title'    => __('الاقتباس', 'alomran'),
            'default'  => '"نحن لا نقدم الطعام فقط، بل نصمم الذكريات."',
        ),
        array(
            'id'       => 'food_experience_background',
            'type'     => 'media',
            'title'    => __('صورة الخلفية', 'alomran'),
            'subtitle' => __('سيتم حفظ الصورة حتى عند تعطيل القسم', 'alomran'),
            // No 'required' to prevent deletion
        ),
        array(
            'id'       => 'food_experience_lighting_title',
            'type'     => 'text',
            'title'    => __('عنوان الإضاءة والموسيقى', 'alomran'),
            'default'  => 'الإضاءة والموسيقى',
        ),
        array(
            'id'       => 'food_experience_lighting_content',
            'type'     => 'textarea',
            'title'    => __('محتوى الإضاءة والموسيقى', 'alomran'),
            'default'  => 'تم تصميم إضاءة الجوهرة لتعكس فخامة الأحجار الكريمة، مع سيمفونيات موسيقية هادئة مختارة بعناية لتناسب أرقى الأذواق.',
        ),
        array(
            'id'       => 'food_experience_service_title',
            'type'     => 'text',
            'title'    => __('عنوان الخدمة الفندقية', 'alomran'),
            'default'  => 'الخدمة الفندقية',
        ),
        array(
            'id'       => 'food_experience_service_content',
            'type'     => 'textarea',
            'title'    => __('محتوى الخدمة الفندقية', 'alomran'),
            'default'  => 'فريقنا مدرب على أعلى معايير الضيافة العالمية، ليضمن لك خصوصية تامة واهتماماً بأدق التفاصيل الشخصية.',
        ),
        array(
            'id'       => 'food_experience_ambiance_title',
            'type'     => 'text',
            'title'    => __('عنوان الأجواء والتصميم', 'alomran'),
            'default'  => 'الأجواء والتصميم',
        ),
        array(
            'id'       => 'food_experience_ambiance_content',
            'type'     => 'textarea',
            'title'    => __('محتوى الأجواء والتصميم', 'alomran'),
            'default'  => 'كل زاوية في الجوهرة تحكي قصة من التراث العربي بتصميم عصري أنيق. من الأثاث الفاخر إلى الأعمال الفنية المختارة بعناية، نخلق مساحة تجمع بين الفخامة والدفء.',
        ),
        array(
            'id'       => 'food_experience_privacy_title',
            'type'     => 'text',
            'title'    => __('عنوان الخصوصية والمساحات', 'alomran'),
            'default'  => 'الخصوصية والمساحات',
        ),
        array(
            'id'       => 'food_experience_privacy_content',
            'type'     => 'textarea',
            'title'    => __('محتوى الخصوصية والمساحات', 'alomran'),
            'default'  => 'نوفر مساحات خاصة للعائلات والأصدقاء، مع صالات VIP فاخرة للاحتفالات الخاصة والمناسبات المميزة. كل مساحة مصممة لضمان خصوصية تامة وراحة مطلقة.',
        ),
        array(
            'id'       => 'food_experience_events_title',
            'type'     => 'text',
            'title'    => __('عنوان الأحداث الخاصة', 'alomran'),
            'default'  => 'الأحداث الخاصة',
        ),
        array(
            'id'       => 'food_experience_events_content',
            'type'     => 'textarea',
            'title'    => __('محتوى الأحداث الخاصة', 'alomran'),
            'default'  => 'ننظم أمسيات موسيقية حية، عروض طهي خاصة، وليالي تذوق فريدة. كل حدث مصمم خصيصاً لتقديم تجربة استثنائية لا تُنسى.',
        ),
        array(
            'id'       => 'food_experience_stats_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل قسم الإحصائيات', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'food_experience_stat1_number',
            'type'     => 'text',
            'title'    => __('الإحصائية الأولى - الرقم', 'alomran'),
            'default'  => '500+',
            'required' => array('food_experience_stats_enable', '=', true),
        ),
        array(
            'id'       => 'food_experience_stat1_label',
            'type'     => 'text',
            'title'    => __('الإحصائية الأولى - التسمية', 'alomran'),
            'default'  => 'ضيف راضٍ',
            'required' => array('food_experience_stats_enable', '=', true),
        ),
        array(
            'id'       => 'food_experience_stat2_number',
            'type'     => 'text',
            'title'    => __('الإحصائية الثانية - الرقم', 'alomran'),
            'default'  => '50+',
            'required' => array('food_experience_stats_enable', '=', true),
        ),
        array(
            'id'       => 'food_experience_stat2_label',
            'type'     => 'text',
            'title'    => __('الإحصائية الثانية - التسمية', 'alomran'),
            'default'  => 'طبق مميز',
            'required' => array('food_experience_stats_enable', '=', true),
        ),
        array(
            'id'       => 'food_experience_stat3_number',
            'type'     => 'text',
            'title'    => __('الإحصائية الثالثة - الرقم', 'alomran'),
            'default'  => '100%',
            'required' => array('food_experience_stats_enable', '=', true),
        ),
        array(
            'id'       => 'food_experience_stat3_label',
            'type'     => 'text',
            'title'    => __('الإحصائية الثالثة - التسمية', 'alomran'),
            'default'  => 'رضا العملاء',
            'required' => array('food_experience_stats_enable', '=', true),
        ),
    ),
));

// Story Page Section (separate from story section in front-page)
Redux::setSection($opt_name, array(
    'title'      => __('صفحة القصة', 'alomran'),
    'id'         => 'food_story_page_section',
    'subsection' => true,
    'parent'     => 'food_pages_sections',
    'icon'       => 'el el-file-edit',
    'fields'     => array(
        array(
            'id'       => 'food_story_page_title',
            'type'     => 'text',
            'title'    => __('عنوان الصفحة', 'alomran'),
            'default'  => 'القصة والمنشأ',
        ),
        array(
            'id'       => 'food_story_page_subtitle',
            'type'     => 'text',
            'title'    => __('الوصف الفرعي', 'alomran'),
            'subtitle' => __('نص صغير يظهر أعلى العنوان', 'alomran'),
            'default'  => 'Our Story',
        ),
        array(
            'id'       => 'food_story_page_image',
            'type'     => 'media',
            'title'    => __('صورة صفحة القصة', 'alomran'),
            'subtitle' => __('الصورة الرئيسية التي تظهر في صفحة القصة', 'alomran'),
        ),
        array(
            'id'       => 'food_story_page_content',
            'type'     => 'editor',
            'title'    => __('محتوى صفحة القصة', 'alomran'),
            'default'  => 'بدأت الجوهرة كحلم لجمع شتات المطبخ العربي في قالب عالمي أنيق. كل حجر في مطاعمنا، وكل نكهة في قائمة طعامنا، تم اختيارها لتكون جزءاً من هذا الإرث.

نحن نؤمن بأن الطعام ليس مجرد وجبة، بل هو رحلة عبر الزمن والثقافة. من حقول الزعفران في إيران إلى مزارع الزيتون في فلسطين، نجمع أندر المكونات لنقدم لك تجربة طهي استثنائية.',
            'args'     => array(
                'wpautop'       => true,
                'media_buttons' => false,
                'textarea_rows' => 10,
            ),
        ),
        array(
            'id'       => 'food_story_page_quote',
            'type'     => 'textarea',
            'title'    => __('اقتباس مميز', 'alomran'),
            'subtitle' => __('اقتباس يظهر بشكل مميز في الصفحة (اختياري)', 'alomran'),
            'default'  => '',
            'rows'     => 3,
        ),
        array(
            'id'       => 'food_story_page_quote_author',
            'type'     => 'text',
            'title'    => __('مؤلف الاقتباس', 'alomran'),
            'subtitle' => __('اسم مؤلف الاقتباس (اختياري)', 'alomran'),
            'default'  => '',
        ),
    ),
));

