<?php
/**
 * Tech Preset - Pricing Page Configuration
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

Redux::setSection($opt_name, array(
    'title'      => __('صفحة الأسعار', 'alomran'),
    'id'         => 'tech_pricing_page',
    'subsection' => true,
    'parent'     => 'tech_pages_sections',
    'icon'       => 'el el-usd',
    'fields'     => array(
        // Page Header
        array(
            'id'       => 'tech_pricing_page_title',
            'type'     => 'text',
            'title'    => __('عنوان الصفحة', 'alomran'),
            'default'  => 'خطط مرنة وشفافة',
        ),
        array(
            'id'       => 'tech_pricing_page_title_highlight',
            'type'     => 'text',
            'title'    => __('جزء العنوان المميز', 'alomran'),
            'default'  => 'مرنة وشفافة',
        ),
        array(
            'id'       => 'tech_pricing_show_annual_toggle',
            'type'     => 'switch',
            'title'    => __('إظهار مفتاح الشهري/السنوي', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'tech_pricing_annual_label',
            'type'     => 'text',
            'title'    => __('نص التبديل السنوي', 'alomran'),
            'subtitle' => __('النص الذي يظهر بجانب مفتاح التبديل للباقة السنوية', 'alomran'),
            'default'  => 'سنوي (وفر 20%)',
            'placeholder' => 'مثال: سنوي (وفر 20%)',
        ),
        
        // Divider: CTAs
        array(
            'id'       => 'tech_pricing_cta_divider',
            'type'     => 'divide',
            'title'    => __('إعدادات الأزرار', 'alomran'),
        ),
        
        array(
            'id'       => 'tech_pricing_cta_type',
            'type'     => 'select',
            'title'    => __('نوع رابط زر التسعير', 'alomran'),
            'subtitle' => __('اختر الصفحة التي سيوجه إليها زر التسعير', 'alomran'),
            'options'  => array(
                'book-demo' => __('احجز عرضًا توضيحيًا', 'alomran'),
                'pricing' => __('صفحة الأسعار', 'alomran'),
                'contact' => __('تواصل معنا', 'alomran'),
                'custom' => __('رابط مخصص', 'alomran'),
            ),
            'default'  => 'book-demo',
        ),
        array(
            'id'       => 'tech_pricing_cta_custom',
            'type'     => 'text',
            'title'    => __('رابط مخصص', 'alomran'),
            'subtitle' => __('أدخل رابط مخصص إذا اخترت "رابط مخصص"', 'alomran'),
            'required' => array('tech_pricing_cta_type', '=', 'custom'),
        ),
        array(
            'id'       => 'tech_pricing_cta_text',
            'type'     => 'text',
            'title'    => __('نص زر التسعير', 'alomran'),
            'default'  => 'احجز عرضًا توضيحيًا',
        ),
        array(
            'id'       => 'tech_pricing_cta_text_popular',
            'type'     => 'text',
            'title'    => __('نص زر الباقة الأكثر طلباً', 'alomran'),
            'subtitle' => __('نص مختلف للباقة المميزة (اختياري)', 'alomran'),
            'default'  => 'احجز عرضًا توضيحيًا',
        ),
        
        // Divider: Pricing Plans
        array(
            'id'       => 'tech_pricing_plans_divider',
            'type'     => 'divide',
            'title'    => __('باقات التسعير', 'alomran'),
        ),
        
        array(
            'id'       => 'tech_pricing_plans',
            'type'     => 'repeater',
            'title'    => __('باقات التسعير', 'alomran'),
            'subtitle' => __('أضف أو عدّل باقات التسعير', 'alomran'),
            'group_values' => true,
            'bind_title' => 'plan_name',
            'item_name' => __('باقة', 'alomran'),
            'fields'   => array(
                array(
                    'id'       => 'plan_name',
                    'type'     => 'text',
                    'title'    => __('اسم الباقة', 'alomran'),
                    'placeholder' => 'مثال: باقة النمو',
                ),
                array(
                    'id'       => 'plan_description',
                    'type'     => 'text',
                    'title'    => __('وصف الباقة', 'alomran'),
                    'placeholder' => 'مثال: للشركات المتوسطة',
                ),
                array(
                    'id'       => 'plan_price_monthly',
                    'type'     => 'text',
                    'title'    => __('السعر الشهري', 'alomran'),
                    'placeholder' => 'مثال: 599 أو "مخصص"',
                ),
                array(
                    'id'       => 'plan_price_annual',
                    'type'     => 'text',
                    'title'    => __('السعر السنوي', 'alomran'),
                    'placeholder' => 'مثال: 499 أو "مخصص"',
                ),
                array(
                    'id'       => 'plan_is_popular',
                    'type'     => 'switch',
                    'title'    => __('الباقة الأكثر طلباً', 'alomran'),
                    'default'  => false,
                ),
                array(
                    'id'       => 'plan_features',
                    'type'     => 'textarea',
                    'title'    => __('مميزات الباقة', 'alomran'),
                    'subtitle' => __('أضف مميزات الباقة (سطر واحد لكل ميزة)', 'alomran'),
                    'desc'     => __('<strong>مثال:</strong><br>معاملات غير محدودة<br>ربط Apple Pay<br>لوحة تحكم إحصائية', 'alomran'),
                    'default'  => '',
                    'rows'     => 6,
                ),
            ),
        ),
    ),
));

// Book Demo Page Section
Redux::setSection($opt_name, array(
    'title'      => __('صفحة حجز الديمو', 'alomran'),
    'id'         => 'tech_demo_page',
    'subsection' => true,
    'parent'     => 'tech_pages_sections',
    'icon'       => 'el el-calendar',
    'fields'     => array(
        array(
            'id'       => 'tech_demo_page_title',
            'type'     => 'text',
            'title'    => __('عنوان الصفحة', 'alomran'),
            'default'  => 'احجز عرضًا توضيحيًا مجانيًا',
        ),
        array(
            'id'       => 'tech_demo_page_subtitle',
            'type'     => 'text',
            'title'    => __('العنوان الفرعي', 'alomran'),
            'default'  => 'اكتشف كيف يمكن لمنصة إتقان أن تحول عملك',
        ),
        array(
            'id'       => 'tech_demo_page_description',
            'type'     => 'textarea',
            'title'    => __('وصف الصفحة', 'alomran'),
            'default'  => 'خلال 30 دقيقة، سنعرض لك كيف يمكن لمنصة إتقان أن تساعدك في تحقيق أهدافك التجارية. احجز موعدك الآن واستمتع بعرض توضيحي مخصص لاحتياجاتك.',
        ),
        array(
            'id'       => 'tech_demo_benefits',
            'type'     => 'repeater',
            'title'    => __('فوائد العرض التوضيحي', 'alomran'),
            'subtitle' => __('أضف فوائد العرض التوضيحي (يمكنك إضافة عدد غير محدود)', 'alomran'),
            'group_values' => true,
            'bind_title' => 'benefit_text',
            'item_name' => __('فائدة', 'alomran'),
            'fields'   => array(
                array(
                    'id'       => 'benefit_text',
                    'type'     => 'text',
                    'title'    => __('نص الفائدة', 'alomran'),
                    'placeholder' => 'مثال: عرض توضيحي مخصص لاحتياجاتك',
                    'default'  => '',
                ),
            ),
        ),
    ),
));

// CTA Section Updates
// Update CTA section to use marketing-focused defaults
// This will be handled in the CTA section file



