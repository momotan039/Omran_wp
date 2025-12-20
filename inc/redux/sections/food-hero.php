<?php
/**
 * Food Preset - Hero Section Configuration
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

Redux::setSection($opt_name, array(
    'title'      => __('قسم البطل', 'alomran'),
    'id'         => 'food_hero_section',
    'subsection' => true,
    'parent'     => 'food_homepage_sections',
    'icon'       => 'el el-picture',
    'fields'     => array(
        array(
            'id'       => 'food_hero_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل قسم البطل', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'food_hero_badge',
            'type'     => 'text',
            'title'    => __('الشارة (Badge)', 'alomran'),
            'default'  => 'Al-Jawhara Dining Experience',
            'required' => array('food_hero_enable', '=', true),
        ),
        array(
            'id'       => 'food_hero_title',
            'type'     => 'text',
            'title'    => __('العنوان الرئيسي', 'alomran'),
            'default'  => 'جوهرة الضيافة',
            'subtitle' => __('سيتم حفظ العنوان حتى عند تعطيل القسم', 'alomran'),
            // Removed 'required' to prevent deletion when section is disabled
        ),
        array(
            'id'       => 'food_hero_title_highlight',
            'type'     => 'text',
            'title'    => __('جزء العنوان المميز', 'alomran'),
            'subtitle' => __('الكلمة التي ستظهر باللون الذهبي', 'alomran'),
            'default'  => 'الضيافة',
            'required' => array('food_hero_enable', '=', true),
        ),
        array(
            'id'       => 'food_hero_description',
            'type'     => 'textarea',
            'title'    => __('الوصف', 'alomran'),
            'default'  => 'حيث يلتقي عبق الماضي بأناقة الحاضر في تجربة طهي استثنائية مصممة لنخبة الذواقين.',
            'required' => array('food_hero_enable', '=', true),
        ),
        array(
            'id'       => 'food_hero_background_image',
            'type'     => 'media',
            'title'    => __('صورة الخلفية', 'alomran'),
            'subtitle' => __('سيتم حفظ الصورة حتى عند تعطيل القسم', 'alomran'),
            // Removed 'required' to prevent deletion when section is disabled
        ),
        array(
            'id'       => 'food_hero_primary_button_text',
            'type'     => 'text',
            'title'    => __('نص الزر الأساسي', 'alomran'),
            'default'  => 'احجز طاولتك',
            'required' => array('food_hero_enable', '=', true),
        ),
        array(
            'id'       => 'food_hero_primary_button_link_type',
            'type'     => 'select',
            'title'    => __('نوع رابط الزر الأساسي', 'alomran'),
            'subtitle' => __('اختر صفحة من القالب أو رابط مخصص', 'alomran'),
            'options'  => alomran_get_preset_pages_options(),
            'default'  => 'reservations',
            'required' => array('food_hero_enable', '=', true),
        ),
        array(
            'id'       => 'food_hero_primary_button_link_custom',
            'type'     => 'text',
            'title'    => __('رابط مخصص للزر الأساسي', 'alomran'),
            'subtitle' => __('أدخل رابط خارجي أو hash (مثل: #section أو https://example.com)', 'alomran'),
            'default'  => '',
            'required' => array(
                array('food_hero_enable', '=', true),
                array('food_hero_primary_button_link_type', '=', 'custom'),
            ),
        ),
        array(
            'id'       => 'food_hero_secondary_button_text',
            'type'     => 'text',
            'title'    => __('نص الزر الثانوي', 'alomran'),
            'default'  => 'استكشف القائمة',
            'required' => array('food_hero_enable', '=', true),
        ),
        array(
            'id'       => 'food_hero_secondary_button_link_type',
            'type'     => 'select',
            'title'    => __('نوع رابط الزر الثانوي', 'alomran'),
            'subtitle' => __('اختر صفحة من القالب أو رابط مخصص', 'alomran'),
            'options'  => alomran_get_preset_pages_options(),
            'default'  => '#menu',
            'required' => array('food_hero_enable', '=', true),
        ),
        array(
            'id'       => 'food_hero_secondary_button_link_custom',
            'type'     => 'text',
            'title'    => __('رابط مخصص للزر الثانوي', 'alomran'),
            'subtitle' => __('أدخل رابط خارجي أو hash (مثل: #section أو https://example.com)', 'alomran'),
            'default'  => '',
            'required' => array(
                array('food_hero_enable', '=', true),
                array('food_hero_secondary_button_link_type', '=', 'custom'),
            ),
        ),
    ),
));

// Philosophy Section
Redux::setSection($opt_name, array(
    'title'      => __('فلسفتنا', 'alomran'),
    'id'         => 'food_philosophy_section',
    'subsection' => true,
    'parent'     => 'food_homepage_sections',
    'icon'       => 'el el-quote',
    'fields'     => array(
        array(
            'id'       => 'food_philosophy_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل قسم الفلسفة', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'food_philosophy_image',
            'type'     => 'media',
            'title'    => __('صورة القسم', 'alomran'),
            'subtitle' => __('سيتم حفظ الصورة حتى عند تعطيل القسم', 'alomran'),
            // Removed 'required' to prevent deletion when section is disabled
        ),
        array(
            'id'       => 'food_philosophy_title',
            'type'     => 'text',
            'title'    => __('العنوان', 'alomran'),
            'default'  => 'نعيد صياغة مفهوم الضيافة',
            'subtitle' => __('سيتم حفظ العنوان حتى عند تعطيل القسم', 'alomran'),
            // Removed 'required' to prevent deletion when section is disabled
        ),
        array(
            'id'       => 'food_philosophy_title_highlight',
            'type'     => 'text',
            'title'    => __('جزء العنوان المميز', 'alomran'),
            'default'  => 'مفهوم الضيافة',
            'required' => array('food_philosophy_enable', '=', true),
        ),
        array(
            'id'       => 'food_philosophy_description',
            'type'     => 'textarea',
            'title'    => __('الوصف', 'alomran'),
            'default'  => 'في الجوهرة، لسنا مجرد مطعم؛ نحن صالون ثقافي يحتفي بأرقى معايير الطهي. نجمع بين أندر المكونات العالمية والوصفات المتوارثة لنقدم لك سيمفونية من المذاق الفريد.',
            'required' => array('food_philosophy_enable', '=', true),
        ),
        array(
            'id'       => 'food_philosophy_quote',
            'type'     => 'text',
            'title'    => __('الاقتباس', 'alomran'),
            'default'  => '"الفخامة هي التفاصيل التي لا تُنسى"',
            'required' => array('food_philosophy_enable', '=', true),
        ),
    ),
));

// Experience Section for Homepage (Preview)
Redux::setSection($opt_name, array(
    'title'      => __('التجربة - الصفحة الرئيسية', 'alomran'),
    'id'         => 'food_experience_homepage_section',
    'subsection' => true,
    'parent'     => 'food_homepage_sections',
    'icon'       => 'el el-star-empty',
    'fields'     => array(
        array(
            'id'       => 'food_experience_homepage_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل قسم التجربة في الصفحة الرئيسية', 'alomran'),
            'subtitle' => __('عرض قسم معاينة للتجربة في الصفحة الرئيسية', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'food_experience_homepage_title',
            'type'     => 'text',
            'title'    => __('عنوان القسم', 'alomran'),
            'default'  => 'فن الأجواء',
            'required' => array('food_experience_homepage_enable', '=', true),
        ),
        array(
            'id'       => 'food_experience_homepage_subtitle',
            'type'     => 'text',
            'title'    => __('العنوان الفرعي', 'alomran'),
            'default'  => 'اكتشف تجربة الجوهرة الفريدة',
            'required' => array('food_experience_homepage_enable', '=', true),
        ),
        array(
            'id'       => 'food_experience_homepage_description',
            'type'     => 'textarea',
            'title'    => __('الوصف', 'alomran'),
            'default'  => 'من الإضاءة الفاخرة إلى الخدمة الفندقية، كل تفصيلة مصممة لخلق تجربة لا تُنسى.',
            'required' => array('food_experience_homepage_enable', '=', true),
        ),
        array(
            'id'       => 'food_experience_homepage_button_text',
            'type'     => 'text',
            'title'    => __('نص الزر', 'alomran'),
            'default'  => 'اكتشف التجربة',
            'required' => array('food_experience_homepage_enable', '=', true),
        ),
        array(
            'id'       => 'food_experience_homepage_button_link_type',
            'type'     => 'select',
            'title'    => __('نوع رابط الزر', 'alomran'),
            'subtitle' => __('اختر صفحة من القالب أو رابط مخصص', 'alomran'),
            'options'  => alomran_get_preset_pages_options(),
            'default'  => 'experience',
            'required' => array('food_experience_homepage_enable', '=', true),
        ),
        array(
            'id'       => 'food_experience_homepage_button_link_custom',
            'type'     => 'text',
            'title'    => __('رابط مخصص للزر', 'alomran'),
            'subtitle' => __('أدخل رابط خارجي أو hash (مثل: #section أو https://example.com)', 'alomran'),
            'default'  => '',
            'required' => array(
                array('food_experience_homepage_enable', '=', true),
                array('food_experience_homepage_button_link_type', '=', 'custom'),
            ),
        ),
        array(
            'id'       => 'food_experience_homepage_use_experience_image',
            'type'     => 'switch',
            'title'    => __('استخدام صورة صفحة التجربة', 'alomran'),
            'subtitle' => __('عند التفعيل، سيتم استخدام نفس صورة صفحة التجربة', 'alomran'),
            'default'  => true,
            'required' => array('food_experience_homepage_enable', '=', true),
        ),
        array(
            'id'       => 'food_experience_homepage_custom_image',
            'type'     => 'media',
            'title'    => __('صورة مخصصة', 'alomran'),
            'subtitle' => __('استخدم صورة مختلفة (فقط إذا لم تكن تستخدم صورة صفحة التجربة)', 'alomran'),
            'required' => array(
                array('food_experience_homepage_enable', '=', true),
                array('food_experience_homepage_use_experience_image', '=', false),
            ),
        ),
    ),
));

// Story Section
Redux::setSection($opt_name, array(
    'title'      => __('القصة', 'alomran'),
    'id'         => 'food_story_section',
    'subsection' => true,
    'parent'     => 'food_homepage_sections',
    'icon'       => 'el el-book',
    'fields'     => array(
        array(
            'id'       => 'food_story_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل قسم القصة', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'food_story_image',
            'type'     => 'media',
            'title'    => __('صورة القصة', 'alomran'),
            'subtitle' => __('سيتم حفظ الصورة حتى عند تعطيل القسم', 'alomran'),
            // Removed 'required' to prevent deletion when section is disabled
        ),
        array(
            'id'       => 'food_story_subtitle',
            'type'     => 'text',
            'title'    => __('العنوان الفرعي', 'alomran'),
            'default'  => 'قصتنا',
            'subtitle' => __('العنوان الفرعي الذي يظهر أعلى العنوان الرئيسي', 'alomran'),
            // Removed 'required' to prevent deletion when section is disabled
        ),
        array(
            'id'       => 'food_story_title',
            'type'     => 'text',
            'title'    => __('عنوان القصة', 'alomran'),
            'default'  => 'أكثر من مجرد مطعم، نحن وجهة ثقافية.',
            'subtitle' => __('سيتم حفظ العنوان حتى عند تعطيل القسم', 'alomran'),
            // Removed 'required' to prevent deletion when section is disabled
        ),
        array(
            'id'       => 'food_story_title_highlight',
            'type'     => 'text',
            'title'    => __('جزء العنوان المميز', 'alomran'),
            'default'  => 'وجهة ثقافية',
            'required' => array('food_story_enable', '=', true),
        ),
        array(
            'id'       => 'food_story_description_1',
            'type'     => 'textarea',
            'title'    => __('الوصف الأول', 'alomran'),
            'default'  => 'في "الجوهرة"، نؤمن بأن الطعام هو لغة الحب وكرم الضيافة. تأسسنا برؤية تهدف إلى إعادة تعريف المطبخ الشرقي، مقدمين أطباقاً تحترم الجذور وتعانق الحداثة العالمية.',
            'required' => array('food_story_enable', '=', true),
        ),
        array(
            'id'       => 'food_story_description_2',
            'type'     => 'textarea',
            'title'    => __('الوصف الثاني', 'alomran'),
            'default'  => 'كل طبق هو سيمفونية من المذاق، وكل زاوية في فروعنا تروي حكاية من التراث العربي بتصميم عصري أنيق، لنضمن لكم ولعائلاتكم لحظات من الرفاهية والسكينة.',
            'required' => array('food_story_enable', '=', true),
        ),
    ),
));

