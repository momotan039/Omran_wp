<?php
/**
 * Redux Repeater Defaults
 * Default values for all repeater fields in Tech preset
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get repeater defaults for Tech preset
 * Returns default values for all repeater fields
 */
function alomran_get_tech_repeater_defaults() {
    return array(
        // Homepage sections
        'tech_features_preview_items' => array(
            array(
                'feature_icon' => '⚡',
                'feature_title' => 'سرعة فائقة',
                'feature_description' => 'ربط فوري مع جميع المنصات في أقل من 5 ثوانٍ',
                'feature_color' => 'from-yellow-400 to-orange-500',
            ),
            array(
                'feature_icon' => '🔒',
                'feature_title' => 'أمان متقدم',
                'feature_description' => 'حماية شاملة لبياناتك مع تشفير من المستوى المصرفي',
                'feature_color' => 'from-blue-500 to-cyan-500',
            ),
            array(
                'feature_icon' => '📊',
                'feature_title' => 'تحليلات ذكية',
                'feature_description' => 'لوحات تحكم تفاعلية تعرض أداء عملك في الوقت الفعلي',
                'feature_color' => 'from-purple-500 to-pink-500',
            ),
            array(
                'feature_icon' => '🤖',
                'feature_title' => 'ذكاء اصطناعي',
                'feature_description' => 'أتمتة ذكية تتعلم من سلوك عملك وتطور نفسها تلقائياً',
                'feature_color' => 'from-green-500 to-emerald-500',
            ),
        ),
        'tech_stats_items' => array(
            array(
                'stat_number' => '50K+',
                'stat_label' => 'معاملة شهرياً',
                'stat_icon' => '📦',
                'stat_color' => 'text-blue-600',
            ),
            array(
                'stat_number' => '500+',
                'stat_label' => 'شركة تثق بنا',
                'stat_icon' => '🏢',
                'stat_color' => 'text-violet-600',
            ),
            array(
                'stat_number' => '99.9%',
                'stat_label' => 'معدل الاستقرار',
                'stat_icon' => '⚡',
                'stat_color' => 'text-emerald-600',
            ),
            array(
                'stat_number' => '24/7',
                'stat_label' => 'دعم فني متواصل',
                'stat_icon' => '💬',
                'stat_color' => 'text-orange-600',
            ),
        ),
        'tech_testimonials_items' => array(
            array(
                'testimonial_name' => 'أحمد السالم',
                'testimonial_role' => 'مدير التقنية - شركة توصيل',
                'testimonial_content' => 'إتقان غيرت طريقة عملنا بالكامل. وفرنا أكثر من 40 ساعة أسبوعياً في معالجة الطلبات. النظام سهل الاستخدام وقوي جداً.',
                'testimonial_avatar' => '👨‍💼',
                'testimonial_company' => 'توصيل',
            ),
            array(
                'testimonial_name' => 'فاطمة العلي',
                'testimonial_role' => 'المؤسسة والرئيس التنفيذي - منصة سلة',
                'testimonial_content' => 'أفضل قرار اتخذناه هذا العام. الربط مع منصات الدفع والشحن أصبح تلقائياً بالكامل. فريق الدعم استثنائي.',
                'testimonial_avatar' => '👩‍💼',
                'testimonial_company' => 'سلة',
            ),
            array(
                'testimonial_name' => 'خالد المطيري',
                'testimonial_role' => 'CTO - شركة تطوير',
                'testimonial_content' => 'API موثق بشكل ممتاز، SDKs جاهزة، وأداء لا يصدق. منصة إتقان هي الحل الذي كنا نبحث عنه منذ سنوات.',
                'testimonial_avatar' => '👨‍💻',
                'testimonial_company' => 'تطوير',
            ),
            array(
                'testimonial_name' => 'سارة النجار',
                'testimonial_role' => 'مديرة العمليات - متجر إلكتروني',
                'testimonial_content' => 'التكامل مع منصات البيع أصبح سهلاً جداً. وفرنا وقتاً كبيراً في إدارة المخزون والطلبات.',
                'testimonial_avatar' => '👩‍💼',
                'testimonial_company' => 'متجر إلكتروني',
            ),
        ),
        // Pages sections - empty defaults (user must add items manually)
        'tech_use_cases_items' => array(),
        'tech_features_categories' => array(),
        'tech_pricing_plans' => array(),
        'tech_demo_benefits' => array(),
    );
}

