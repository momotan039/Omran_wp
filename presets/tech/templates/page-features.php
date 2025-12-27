<?php
/**
 * Tech Preset - Features Page Template
 *
 * Template Name: Features
 * 
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Get page settings
$page_title = alomran_get_option('tech_features_page_title', 'بنية تحتية تنمو مع أعمالك');
$page_title_highlight = alomran_get_option('tech_features_page_title_highlight', 'تنمو مع أعمالك');

// Features data (can be extended with Redux repeater)
$features_categories = array(
    'integration' => array(
        'label' => 'الربط البرمجي (API)',
        'features' => array(
            array('title' => 'SDKs جاهزة', 'desc' => 'مكتبات برمجية متكاملة لـ PHP, Python, Node.js.', 'icon' => '📦'),
            array('title' => 'Webhooks لحظية', 'desc' => 'استقبل إشعارات فورية عن حالة الشحنات والمدفوعات.', 'icon' => '🔌'),
            array('title' => 'توثيق Swagger', 'desc' => 'مرجع تقني شامل يسهل عملية الربط في دقائق.', 'icon' => '📄'),
        ),
    ),
    'automation' => array(
        'label' => 'الأتمتة الذكية',
        'features' => array(
            array('title' => 'سير عمل مرن', 'desc' => 'أتمتة دورة حياة الطلب من الدفع إلى الشحن.', 'icon' => '⚙️'),
            array('title' => 'تحديث المخزون', 'desc' => 'مزامنة رصيد المنتجات بين متجرك ومستودعاتك.', 'icon' => '🔄'),
            array('title' => 'ذكاء اصطناعي', 'desc' => 'خوارزميات لتحديد أفضل شركة شحن أوتوماتيكياً.', 'icon' => '🤖'),
        ),
    ),
    'fintech' => array(
        'label' => 'الحلول المالية',
        'features' => array(
            array('title' => 'دعم Apple Pay', 'desc' => 'تفعيل الدفع السريع بضغطة زر واحدة.', 'icon' => '📲'),
            array('title' => 'تسوية المبالغ', 'desc' => 'نظام آلي لتسوية المبالغ وتحويلها دورياً.', 'icon' => '🏦'),
            array('title' => 'فوترة إلكترونية', 'desc' => 'فواتير متوافقة مع متطلبات هيئة الزكاة والدخل.', 'icon' => '🧾'),
        ),
    ),
    'analytics' => array(
        'label' => 'التحليلات المتقدمة',
        'features' => array(
            array('title' => 'لوحات قياس', 'desc' => 'تقارير تفاعلية تعرض حجم المبيعات والأداء.', 'icon' => '📊'),
            array('title' => 'تحليل السلوك', 'desc' => 'فهم أعمق لعمليات التخلي عن السلة.', 'icon' => '📈'),
            array('title' => 'تصدير ذكي', 'desc' => 'تصدير البيانات بصيغ متوافقة مع أنظمة المحاسبة.', 'icon' => '📤'),
        ),
    ),
);
?>

<div class="py-24 bg-white relative overflow-hidden">
    <div class="absolute top-0 left-0 w-96 h-96 bg-blue-100/30 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2 animate-pulse"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-24 transition-all duration-1000 transform">
            <h1 class="text-4xl lg:text-7xl font-black text-slate-900 mb-8 leading-tight animate-in fade-in slide-in-from-bottom-8 duration-1000">
                <?php echo esc_html($page_title); ?> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-violet-600"><?php echo esc_html($page_title_highlight); ?></span>
            </h1>
        </div>

        <?php
        $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'integration';
        if (!isset($features_categories[$active_tab])) {
            $active_tab = 'integration';
        }
        ?>

        <div class="flex flex-wrap justify-center gap-3 mb-16 p-2 bg-slate-50 rounded-[2rem] max-w-fit mx-auto border border-slate-100">
            <?php foreach ($features_categories as $cat_id => $cat_data) : ?>
                <a
                    href="?tab=<?php echo esc_attr($cat_id); ?>"
                    class="px-8 py-4 rounded-[1.5rem] font-black text-sm transition-all duration-300 <?php echo ($active_tab === $cat_id) ? 'bg-white text-blue-600 shadow-xl scale-105' : 'text-slate-500 hover:text-slate-900'; ?>"
                >
                    <?php echo esc_html($cat_data['label']); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($features_categories[$active_tab]['features'] as $i => $feature) : ?>
                <div class="bg-white p-12 rounded-[3rem] border border-slate-100 hover:border-blue-200 hover:shadow-2xl transition-all duration-700 group transform opacity-100 translate-y-0 scale-100">
                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-4xl mb-10 group-hover:bg-blue-600 group-hover:text-white group-hover:rotate-6 transition-all duration-500">
                        <?php echo esc_html($feature['icon']); ?>
                    </div>
                    <h4 class="text-2xl font-black text-slate-900 mb-4 tracking-tight"><?php echo esc_html($feature['title']); ?></h4>
                    <p class="text-slate-500 leading-relaxed font-medium text-lg"><?php echo esc_html($feature['desc']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
get_footer();


