<?php
/**
 * Tech Preset - Features Preview Section Template
 *
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

$features_preview_enable = alomran_get_option('tech_features_preview_enable', true);
if (!$features_preview_enable) {
    return;
}

$features_preview_title = alomran_get_option('tech_features_preview_title', 'لماذا تختار إتقان؟');
$features_preview_subtitle = alomran_get_option('tech_features_preview_subtitle', 'حلول تقنية متكاملة تجعل عملك ينمو بسرعة');

$default_features = array(
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
);

$features_items = alomran_get_repeater_items(
    'tech_features_preview_items',
    $default_features,
    array('feature_title', 'feature_description')
);
?>
<section id="features-preview" class="py-32 bg-white relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-10 w-72 h-72 bg-blue-100 rounded-full blur-[100px] opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-violet-100 rounded-full blur-[120px] opacity-15 animate-pulse" style="animation-delay: 1s;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-20">
            <div class="inline-block mb-6">
                <span class="text-sm font-black text-blue-600 uppercase tracking-widest">المميزات</span>
            </div>
            <h2 class="text-4xl lg:text-6xl font-black text-slate-900 mb-6 leading-tight">
                <?php echo esc_html($features_preview_title); ?>
            </h2>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto font-medium">
                <?php echo esc_html($features_preview_subtitle); ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($features_items as $index => $feature) : 
                $feature_icon = isset($feature['feature_icon']) ? trim($feature['feature_icon']) : '⚡';
                $feature_title = isset($feature['feature_title']) ? trim($feature['feature_title']) : '';
                $feature_description = isset($feature['feature_description']) ? trim($feature['feature_description']) : '';
                $feature_color = isset($feature['feature_color']) ? trim($feature['feature_color']) : 'from-yellow-400 to-orange-500';
                
                if (empty($feature_title) && empty($feature_description)) {
                    continue;
                }
            ?>
                <div class="group feature-card bg-white p-8 rounded-3xl border border-slate-100 hover:border-transparent hover:shadow-2xl transition-all duration-700 transform hover:-translate-y-2" data-index="<?php echo $index; ?>">
                    <div class="mb-6">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br <?php echo esc_attr($feature_color); ?> flex items-center justify-center text-3xl mb-4 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-lg">
                            <?php echo esc_html($feature_icon); ?>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-3"><?php echo esc_html($feature_title); ?></h3>
                        <p class="text-slate-600 leading-relaxed font-medium"><?php echo esc_html($feature_description); ?></p>
                    </div>
                    <div class="pt-4 border-t border-slate-100">
                        <a href="<?php echo esc_url(alomran_format_url('/features')); ?>" class="inline-flex items-center gap-2 text-blue-600 font-bold text-sm hover:gap-4 transition-all group/link">
                            اكتشف المزيد <span class="group-hover/link:translate-x-[-4px] transition-transform">→</span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
