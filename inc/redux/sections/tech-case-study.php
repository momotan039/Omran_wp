<?php
/**
 * Tech Preset - Case Study Section Configuration
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

// Features Preview Section
Redux::setSection($opt_name, array(
    'title'      => __('قسم  المميزات', 'alomran'),
    'id'         => 'tech_features_preview_section',
    'subsection' => true,
    'parent'     => 'tech_homepage_sections',
    'icon'       => 'el el-star-empty',
    'desc'       => __('إعدادات قسم  المميزات الرئيسية', 'alomran'),
    'fields'     => array(
        // Enable/Disable
        array(
            'id'       => 'tech_features_preview_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل قسم  المميزات', 'alomran'),
            'subtitle' => __('عرض/إخفاء قسم المميزات من الصفحة الرئيسية', 'alomran'),
            'default'  => true,
        ),
        
        // Divider: العناوين
        array(
            'id'       => 'tech_features_preview_headers_divider',
            'type'     => 'divide',
            'title'    => __('العناوين', 'alomran'),
        ),
        
        array(
            'id'       => 'tech_features_preview_title',
            'type'     => 'text',
            'title'    => __('عنوان القسم', 'alomran'),
            'subtitle' => __('العنوان الرئيسي الذي يظهر أعلى قسم المميزات', 'alomran'),
            'default'  => 'لماذا تختار إتقان؟',
            'required' => array('tech_features_preview_enable', '=', true),
        ),
        array(
            'id'       => 'tech_features_preview_subtitle',
            'type'     => 'textarea',
            'title'    => __('العنوان الفرعي', 'alomran'),
            'subtitle' => __('وصف مختصر يظهر تحت العنوان الرئيسي', 'alomran'),
            'default'  => 'حلول تقنية متكاملة تجعل عملك ينمو بسرعة',
            'required' => array('tech_features_preview_enable', '=', true),
        ),
        
        // Divider: المميزات
        array(
            'id'       => 'tech_features_preview_items_divider',
            'type'     => 'divide',
            'title'    => __('المميزات', 'alomran'),
        ),
        
        array(
            'id'          => 'tech_features_preview_items',
            'type'        => 'repeater',
            'title'       => __('قائمة المميزات', 'alomran'),
            'subtitle'    => __('أضف أو عدّل أو احذف المميزات المعروضة. يمكنك إضافة عدد غير محدود من المميزات.', 'alomran'),
            'desc'        => __('<strong>ملاحظة:</strong> إذا لم تقم بإضافة أي مميزات، سيتم عرض البيانات الافتراضية (4 مميزات) في الموقع. لن تظهر العناصر الافتراضية هنا في لوحة التحكم.', 'alomran'),
            'required'    => array('tech_features_preview_enable', '=', true),
            'bind_title' => 'feature_title',
            'group_values' => true, // IMPORTANT: This ensures all sub-field values are stored within the main repeater ID
            'fields'      => array(
                array(
                    'id'       => 'feature_icon',
                    'type'     => 'text',
                    'title'    => __('الأيقونة (Emoji)', 'alomran'),
                    'subtitle' => __('استخدم emoji واحد، مثال: ⚡ 🔒 📊 🤖', 'alomran'),
                    'default'  => '⚡',
                    'placeholder' => '⚡',
                ),
                array(
                    'id'       => 'feature_title',
                    'type'     => 'text',
                    'title'    => __('عنوان الميزة', 'alomran'),
                    'subtitle' => __('عنوان الميزة الذي يظهر بخط عريض', 'alomran'),
                    'default'  => 'سرعة فائقة',
                    'placeholder' => 'مثال: سرعة فائقة',
                ),
                array(
                    'id'       => 'feature_description',
                    'type'     => 'textarea',
                    'title'    => __('وصف الميزة', 'alomran'),
                    'subtitle' => __('وصف مختصر للميزة (سطر أو سطرين)', 'alomran'),
                    'default'  => 'ربط فوري مع جميع المنصات في أقل من 5 ثوانٍ',
                    'placeholder' => 'مثال: ربط فوري مع جميع المنصات...',
                ),
                array(
                    'id'       => 'feature_color',
                    'type'     => 'select',
                    'title'    => __('لون التدرج للأيقونة', 'alomran'),
                    'subtitle' => __('اختر لون التدرج الذي يظهر خلف الأيقونة', 'alomran'),
                    'options'  => array(
                        'from-yellow-400 to-orange-500' => 'أصفر إلى برتقالي',
                        'from-blue-500 to-cyan-500' => 'أزرق إلى سماوي',
                        'from-purple-500 to-pink-500' => 'بنفسجي إلى وردي',
                        'from-green-500 to-emerald-500' => 'أخضر إلى زمردي',
                        'from-red-500 to-pink-500' => 'أحمر إلى وردي',
                        'from-indigo-500 to-purple-500' => 'نيلي إلى بنفسجي',
                    ),
                    'default'  => 'from-yellow-400 to-orange-500',
                ),
            ),
        ),
    ),
));

// Case Study Section
Redux::setSection($opt_name, array(
    'title'      => __('قسم دراسة الحالة', 'alomran'),
    'id'         => 'tech_case_study_section',
    'subsection' => true,
    'parent'     => 'tech_homepage_sections',
    'icon'       => 'el el-file',
    'desc'       => __('إعدادات قسم دراسة الحالة (Case Study) الذي يعرض نجاحات العملاء', 'alomran'),
    'fields'     => array(
        array(
            'id'       => 'tech_case_study_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل قسم دراسة الحالة', 'alomran'),
            'subtitle' => __('عرض/إخفاء قسم دراسة الحالة من الصفحة الرئيسية', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'tech_case_study_content_divider',
            'type'     => 'divide',
            'title'    => __('المحتوى', 'alomran'),
        ),
        array(
            'id'       => 'tech_case_study_title',
            'type'     => 'text',
            'title'    => __('عنوان دراسة الحالة', 'alomran'),
            'subtitle' => __('عنوان جذاب يلخص دراسة الحالة', 'alomran'),
            'default'  => 'كيف أتمتنا 50,000 شحنة شهرياً؟',
            'required' => array('tech_case_study_enable', '=', true),
        ),
        array(
            'id'       => 'tech_case_study_description',
            'type'     => 'textarea',
            'title'    => __('وصف دراسة الحالة', 'alomran'),
            'subtitle' => __('وصف تفصيلي لدراسة الحالة (2-3 أسطر)', 'alomran'),
            'default'  => 'قامت شركة "توصيل" بربط أسطولها التقني بالكامل عبر واجهة إتقان، مما سمح لهم بتتبع الشحنات لحظياً آلياً في الوقت الحقيقي.',
            'required' => array('tech_case_study_enable', '=', true),
        ),
        array(
            'id'       => 'tech_case_study_link_divider',
            'type'     => 'divide',
            'title'    => __('الرابط', 'alomran'),
        ),
        array(
            'id'       => 'tech_case_study_link_text',
            'type'     => 'text',
            'title'    => __('نص رابط "اقرأ المزيد"', 'alomran'),
            'subtitle' => __('النص الذي يظهر على رابط "اقرأ المزيد"', 'alomran'),
            'default'  => 'اقرأ تفاصيل الربط التقني',
            'required' => array('tech_case_study_enable', '=', true),
        ),
        array(
            'id'       => 'tech_case_study_link_type',
            'type'     => 'select',
            'title'    => __('صفحة الوجهة', 'alomran'),
            'subtitle' => __('اختر الصفحة التي سيؤدي إليها رابط "اقرأ المزيد"', 'alomran'),
            'options'  => alomran_get_preset_pages_options(),
            'default'  => 'use-cases',
            'required' => array('tech_case_study_enable', '=', true),
        ),
        array(
            'id'       => 'tech_case_study_image_divider',
            'type'     => 'divide',
            'title'    => __('الصورة', 'alomran'),
        ),
        array(
            'id'       => 'tech_case_study_image',
            'type'     => 'media',
            'title'    => __('صورة دراسة الحالة', 'alomran'),
            'subtitle' => __('صورة توضيحية لدراسة الحالة (يفضل صورة عالية الجودة)', 'alomran'),
            'required' => array('tech_case_study_enable', '=', true),
        ),
    ),
));

// Statistics Section
Redux::setSection($opt_name, array(
    'title'      => __('قسم الإحصائيات', 'alomran'),
    'id'         => 'tech_stats_section',
    'subsection' => true,
    'parent'     => 'tech_homepage_sections',
    'icon'       => 'el el-graph',
    'desc'       => __('إعدادات قسم الإحصائيات - الأرقام تتحرك تلقائياً عند الوصول للقسم', 'alomran'),
    'fields'     => array(
        // Enable/Disable
        array(
            'id'       => 'tech_stats_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل قسم الإحصائيات', 'alomran'),
            'subtitle' => __('عرض/إخفاء قسم الإحصائيات من الصفحة الرئيسية', 'alomran'),
            'default'  => true,
        ),
        
        // Divider: العناوين
        array(
            'id'       => 'tech_stats_headers_divider',
            'type'     => 'divide',
            'title'    => __('العناوين', 'alomran'),
        ),
        
        array(
            'id'       => 'tech_stats_title',
            'type'     => 'text',
            'title'    => __('عنوان القسم', 'alomran'),
            'subtitle' => __('العنوان الرئيسي الذي يظهر أعلى الإحصائيات', 'alomran'),
            'default'  => 'أرقام تتحدث عن نفسها',
            'required' => array('tech_stats_enable', '=', true),
        ),
        array(
            'id'       => 'tech_stats_subtitle',
            'type'     => 'textarea',
            'title'    => __('العنوان الفرعي', 'alomran'),
            'subtitle' => __('وصف مختصر يظهر تحت العنوان الرئيسي', 'alomran'),
            'default'  => 'نمو مستمر وثقة متزايدة من الشركات التقنية',
            'required' => array('tech_stats_enable', '=', true),
        ),
        
        // Divider: الإحصائيات
        array(
            'id'       => 'tech_stats_items_divider',
            'type'     => 'divide',
            'title'    => __('الإحصائيات', 'alomran'),
        ),
        
        array(
            'id'          => 'tech_stats_items',
            'type'        => 'repeater',
            'title'       => __('قائمة الإحصائيات', 'alomran'),
            'subtitle'    => __('أضف أو عدّل أو احذف الإحصائيات. الأرقام تتحرك تلقائياً من 0 إلى القيمة المحددة عند الوصول للقسم.', 'alomran'),
            'desc'        => __('<strong>ملاحظة:</strong> إذا لم تقم بإضافة أي إحصائيات، سيتم عرض البيانات الافتراضية (4 إحصائيات) في الموقع. لن تظهر العناصر الافتراضية هنا في لوحة التحكم.', 'alomran'),
            'required'    => array('tech_stats_enable', '=', true),
            'bind_title' => 'stat_label',
            'group_values' => true, // IMPORTANT: This ensures all sub-field values are stored within the main repeater ID
            'fields'      => array(
                array(
                    'id'       => 'stat_number',
                    'type'     => 'text',
                    'title'    => __('الرقم', 'alomran'),
                    'subtitle' => __('الرقم النهائي الذي سيصل إليه العداد. التنسيقات المدعومة: 50K+ (للآلاف), 500+ (للأرقام), 99.9% (للنسب), 24/7 (نص ثابت)', 'alomran'),
                    'default'  => '50K+',
                    'placeholder' => 'مثال: 50K+ أو 500+ أو 99.9%',
                ),
                array(
                    'id'       => 'stat_label',
                    'type'     => 'text',
                    'title'    => __('التسمية', 'alomran'),
                    'subtitle' => __('النص الذي يظهر تحت الرقم', 'alomran'),
                    'default'  => 'معاملة شهرياً',
                    'placeholder' => 'مثال: معاملة شهرياً',
                ),
                array(
                    'id'       => 'stat_icon',
                    'type'     => 'text',
                    'title'    => __('الأيقونة (Emoji)', 'alomran'),
                    'subtitle' => __('استخدم emoji واحد، مثال: 📦 🏢 ⚡ 💬', 'alomran'),
                    'default'  => '📦',
                    'placeholder' => '📦',
                ),
                array(
                    'id'       => 'stat_color',
                    'type'     => 'select',
                    'title'    => __('لون الرقم', 'alomran'),
                    'subtitle' => __('اختر لون الرقم المعروض', 'alomran'),
                    'options'  => array(
                        'text-blue-600' => 'أزرق',
                        'text-violet-600' => 'بنفسجي',
                        'text-emerald-600' => 'أخضر',
                        'text-orange-600' => 'برتقالي',
                        'text-pink-600' => 'وردي',
                        'text-cyan-600' => 'سماوي',
                    ),
                    'default'  => 'text-blue-600',
                ),
            ),
        ),
    ),
));

// Testimonials Section
Redux::setSection($opt_name, array(
    'title'      => __('قسم الشهادات', 'alomran'),
    'id'         => 'tech_testimonials_section',
    'subsection' => true,
    'parent'     => 'tech_homepage_sections',
    'icon'       => 'el el-quote',
    'desc'       => __('إعدادات قسم شهادات العملاء - يعرض تجارب العملاء مع المنصة', 'alomran'),
    'fields'     => array(
        // Enable/Disable
        array(
            'id'       => 'tech_testimonials_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل قسم الشهادات', 'alomran'),
            'subtitle' => __('عرض/إخفاء قسم الشهادات من الصفحة الرئيسية', 'alomran'),
            'default'  => true,
        ),
        
        // Divider: العناوين
        array(
            'id'       => 'tech_testimonials_headers_divider',
            'type'     => 'divide',
            'title'    => __('العناوين', 'alomran'),
        ),
        
        array(
            'id'       => 'tech_testimonials_title',
            'type'     => 'text',
            'title'    => __('عنوان القسم', 'alomran'),
            'subtitle' => __('العنوان الرئيسي الذي يظهر أعلى الشهادات', 'alomran'),
            'default'  => 'ماذا يقول عملاؤنا',
            'required' => array('tech_testimonials_enable', '=', true),
        ),
        array(
            'id'       => 'tech_testimonials_subtitle',
            'type'     => 'textarea',
            'title'    => __('العنوان الفرعي', 'alomran'),
            'subtitle' => __('وصف مختصر يظهر تحت العنوان الرئيسي', 'alomran'),
            'default'  => 'شركات رائدة تثق بإتقان لتحويل أعمالها رقمياً',
            'required' => array('tech_testimonials_enable', '=', true),
        ),
        
        // Divider: الشهادات
        array(
            'id'       => 'tech_testimonials_items_divider',
            'type'     => 'divide',
            'title'    => __('الشهادات', 'alomran'),
        ),
        
        array(
            'id'          => 'tech_testimonials_items',
            'type'        => 'repeater',
            'title'       => __('قائمة الشهادات', 'alomran'),
            'subtitle'    => __('أضف أو عدّل أو احذف شهادات العملاء. يمكنك إضافة عدد غير محدود من الشهادات.', 'alomran'),
            'desc'        => __('<strong>ملاحظة:</strong> إذا لم تقم بإضافة أي شهادات، سيتم عرض البيانات الافتراضية (4 شهادات) في الموقع. لن تظهر العناصر الافتراضية هنا في لوحة التحكم.', 'alomran'),
            'required'    => array('tech_testimonials_enable', '=', true),
            'bind_title' => 'testimonial_name',
            'group_values' => true, // IMPORTANT: This ensures all sub-field values are stored within the main repeater ID
            'fields'      => array(
                array(
                    'id'       => 'testimonial_name',
                    'type'     => 'text',
                    'title'    => __('اسم صاحب الشهادة', 'alomran'),
                    'subtitle' => __('الاسم الكامل لصاحب الشهادة', 'alomran'),
                    'default'  => 'أحمد السالم',
                    'placeholder' => 'مثال: أحمد السالم',
                ),
                array(
                    'id'       => 'testimonial_role',
                    'type'     => 'text',
                    'title'    => __('المنصب', 'alomran'),
                    'subtitle' => __('منصب صاحب الشهادة في الشركة', 'alomran'),
                    'default'  => 'مدير التقنية - شركة توصيل',
                    'placeholder' => 'مثال: مدير التقنية - شركة توصيل',
                ),
                array(
                    'id'       => 'testimonial_content',
                    'type'     => 'textarea',
                    'title'    => __('محتوى الشهادة', 'alomran'),
                    'subtitle' => __('نص الشهادة الكامل (2-3 أسطر)', 'alomran'),
                    'default'  => 'إتقان غيرت طريقة عملنا بالكامل. وفرنا أكثر من 40 ساعة أسبوعياً في معالجة الطلبات. النظام سهل الاستخدام وقوي جداً.',
                    'placeholder' => 'اكتب نص الشهادة هنا...',
                ),
                array(
                    'id'       => 'testimonial_avatar',
                    'type'     => 'text',
                    'title'    => __('الأفاتار (Emoji)', 'alomran'),
                    'subtitle' => __('استخدم emoji واحد، مثال: 👨‍💼 👩‍💼 👨‍💻', 'alomran'),
                    'default'  => '👨‍💼',
                    'placeholder' => '👨‍💼',
                ),
                array(
                    'id'       => 'testimonial_company',
                    'type'     => 'text',
                    'title'    => __('اسم الشركة', 'alomran'),
                    'subtitle' => __('اسم شركة صاحب الشهادة', 'alomran'),
                    'default'  => 'توصيل',
                    'placeholder' => 'مثال: توصيل',
                ),
            ),
        ),
    ),
));

// CTA Section
Redux::setSection($opt_name, array(
    'title'      => __('قسم الدعوة للعمل', 'alomran'),
    'id'         => 'tech_cta_section',
    'subsection' => true,
    'parent'     => 'tech_homepage_sections',
    'icon'       => 'el el-hand-up',
    'desc'       => __('إعدادات قسم الدعوة للعمل (Call to Action) - القسم الأخير في الصفحة الرئيسية', 'alomran'),
    'fields'     => array(
        // Enable/Disable
        array(
            'id'       => 'tech_cta_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل قسم الدعوة للعمل', 'alomran'),
            'subtitle' => __('عرض/إخفاء قسم الدعوة للعمل من الصفحة الرئيسية', 'alomran'),
            'default'  => true,
        ),
        
        // Divider: المحتوى
        array(
            'id'       => 'tech_cta_content_divider',
            'type'     => 'divide',
            'title'    => __('المحتوى', 'alomran'),
        ),
        
        array(
            'id'       => 'tech_cta_title',
            'type'     => 'text',
            'title'    => __('عنوان القسم', 'alomran'),
            'subtitle' => __('العنوان الرئيسي الذي يظهر في قسم CTA', 'alomran'),
            'default'  => 'جاهز لبدء رحلتك الرقمية؟',
            'required' => array('tech_cta_enable', '=', true),
        ),
        array(
            'id'       => 'tech_cta_description',
            'type'     => 'textarea',
            'title'    => __('وصف القسم', 'alomran'),
            'subtitle' => __('وصف مختصر يظهر تحت العنوان', 'alomran'),
            'default'  => 'انضم إلى مئات الشركات التي تعتمد على إتقان لتحويل أعمالها رقمياً',
            'required' => array('tech_cta_enable', '=', true),
        ),
        
        // Divider: الزر الأساسي
        array(
            'id'       => 'tech_cta_primary_button_divider',
            'type'     => 'divide',
            'title'    => __('الزر الأساسي', 'alomran'),
        ),
        
        array(
            'id'       => 'tech_cta_button_text',
            'type'     => 'text',
            'title'    => __('نص الزر الأساسي', 'alomran'),
            'subtitle' => __('النص الذي يظهر على الزر الأساسي (عادة زر التسجيل)', 'alomran'),
            'default'  => 'ابدأ مجاناً الآن',
            'required' => array('tech_cta_enable', '=', true),
        ),
        array(
            'id'       => 'tech_cta_button_link_type',
            'type'     => 'select',
            'title'    => __('صفحة الوجهة للزر الأساسي', 'alomran'),
            'subtitle' => __('اختر الصفحة التي سيؤدي إليها الزر الأساسي', 'alomran'),
            'options'  => alomran_get_preset_pages_options(),
            'default'  => 'register',
            'required' => array('tech_cta_enable', '=', true),
        ),
        array(
            'id'       => 'tech_cta_button_link_custom',
            'type'     => 'text',
            'title'    => __('رابط مخصص للزر الأساسي', 'alomran'),
            'subtitle' => __('أدخل رابط خارجي (https://) أو hash (#section) - يظهر فقط عند اختيار "رابط مخصص"', 'alomran'),
            'default'  => '',
            'required' => array(
                array('tech_cta_enable', '=', true),
                array('tech_cta_button_link_type', '=', 'custom'),
            ),
        ),
        
        // Divider: الزر الثانوي
        array(
            'id'       => 'tech_cta_secondary_button_divider',
            'type'     => 'divide',
            'title'    => __('الزر الثانوي', 'alomran'),
        ),
        
        array(
            'id'       => 'tech_cta_secondary_text',
            'type'     => 'text',
            'title'    => __('نص الزر الثانوي', 'alomran'),
            'subtitle' => __('النص الذي يظهر على الزر الثانوي (عادة زر ال)', 'alomran'),
            'default'  => 'أو شاهد العرض التوضيحي',
            'required' => array('tech_cta_enable', '=', true),
        ),
        array(
            'id'       => 'tech_cta_secondary_link_type',
            'type'     => 'select',
            'title'    => __('صفحة الوجهة للزر الثانوي', 'alomran'),
            'subtitle' => __('اختر الصفحة التي سيؤدي إليها الزر الثانوي', 'alomran'),
            'options'  => alomran_get_preset_pages_options(),
            'default'  => 'features',
            'required' => array('tech_cta_enable', '=', true),
        ),
        array(
            'id'       => 'tech_cta_secondary_link_custom',
            'type'     => 'text',
            'title'    => __('رابط مخصص للزر الثانوي', 'alomran'),
            'subtitle' => __('أدخل رابط خارجي (https://) أو hash (#section) - يظهر فقط عند اختيار "رابط مخصص"', 'alomran'),
            'default'  => '',
            'required' => array(
                array('tech_cta_enable', '=', true),
                array('tech_cta_secondary_link_type', '=', 'custom'),
            ),
        ),
    ),
));

