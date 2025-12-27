<?php
/**
 * Tech Preset - Testimonials Section Template
 *
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

$testimonials_enable = alomran_get_option('tech_testimonials_enable', true);
if (!$testimonials_enable) {
    return;
}

$testimonials_title = alomran_get_option('tech_testimonials_title', 'ماذا يقول عملاؤنا');
$testimonials_subtitle = alomran_get_option('tech_testimonials_subtitle', 'شركات رائدة تثق بإتقان لتحويل أعمالها رقمياً');

$default_testimonials = array(
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
);

// Get testimonials items using helper function
$testimonials_items = alomran_get_repeater_items(
    'tech_testimonials_items',
    $default_testimonials,
    array('testimonial_name', 'testimonial_content') // Required fields for validation
);
?>
<section id="testimonials" class="py-32 bg-slate-50 relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-100 rounded-full blur-[120px] opacity-20 -translate-y-1/2 translate-x-1/4"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-violet-100 rounded-full blur-[120px] opacity-20 translate-y-1/2 -translate-x-1/4"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-20">
            <div class="inline-block mb-6">
                <span class="text-sm font-black text-blue-600 uppercase tracking-widest">الشهادات</span>
            </div>
            <h2 class="text-4xl lg:text-6xl font-black text-slate-900 mb-6 leading-tight">
                <?php echo esc_html($testimonials_title); ?>
            </h2>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto font-medium">
                <?php echo esc_html($testimonials_subtitle); ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($testimonials_items as $index => $testimonial) : 
                $testimonial_name = isset($testimonial['testimonial_name']) ? $testimonial['testimonial_name'] : '';
                $testimonial_role = isset($testimonial['testimonial_role']) ? $testimonial['testimonial_role'] : '';
                $testimonial_content = isset($testimonial['testimonial_content']) ? $testimonial['testimonial_content'] : '';
                $testimonial_avatar = isset($testimonial['testimonial_avatar']) ? $testimonial['testimonial_avatar'] : '👤';
                $testimonial_company = isset($testimonial['testimonial_company']) ? $testimonial['testimonial_company'] : '';
            ?>
                <div 
                    class="testimonial-card bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-2 border border-slate-100"
                    data-index="<?php echo $index; ?>"
                >
                    <!-- Quote icon -->
                    <div class="mb-6">
                        <svg class="w-12 h-12 text-blue-100" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.996 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.984zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                    </div>
                    
                    <!-- Content -->
                    <p class="text-slate-700 text-lg leading-relaxed mb-8 font-medium">
                        "<?php echo esc_html($testimonial_content); ?>"
                    </p>
                    
                    <!-- Author -->
                    <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-violet-500 flex items-center justify-center text-2xl shadow-lg">
                            <?php echo esc_html($testimonial_avatar); ?>
                        </div>
                        <div>
                            <div class="font-black text-slate-900"><?php echo esc_html($testimonial_name); ?></div>
                            <div class="text-sm text-slate-500 font-medium"><?php echo esc_html($testimonial_role); ?></div>
                            <div class="text-xs text-blue-600 font-bold mt-1"><?php echo esc_html($testimonial_company); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
