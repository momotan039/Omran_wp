<?php
/**
 * Tech Preset - CTA Section Template
 *
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get settings
$cta_enable = alomran_get_option('tech_cta_enable', true);
if (!$cta_enable) {
    return;
}

$cta_title = alomran_get_option('tech_cta_title', 'جاهز لبدء رحلتك الرقمية؟');
$cta_description = alomran_get_option('tech_cta_description', 'انضم إلى مئات الشركات التي تعتمد على إتقان لتحويل أعمالها رقمياً');
$cta_button_text = alomran_get_option('tech_cta_button_text', 'ابدأ مجاناً الآن');
$cta_button_link_type = alomran_get_option('tech_cta_button_link_type', 'register');
$cta_button_link_custom = alomran_get_option('tech_cta_button_link_custom', '');
$cta_button_link = alomran_get_button_link($cta_button_link_type, $cta_button_link_custom);
$cta_secondary_text = alomran_get_option('tech_cta_secondary_text', 'أو شاهد العرض التوضيحي');
$cta_secondary_link_type = alomran_get_option('tech_cta_secondary_link_type', 'features');
$cta_secondary_link_custom = alomran_get_option('tech_cta_secondary_link_custom', '');
$cta_secondary_link = alomran_get_button_link($cta_secondary_link_type, $cta_secondary_link_custom);
?>
<section id="cta" class="py-32 bg-gradient-to-br from-blue-600 via-blue-700 to-violet-600 text-white relative overflow-hidden">
    <!-- Animated background -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-full h-full bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-white/10 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/4 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-violet-400/20 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/4 animate-pulse" style="animation-delay: 1s;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-block mb-6">
                <span class="text-sm font-black text-blue-200 uppercase tracking-widest">ابدأ الآن</span>
            </div>
            
            <h2 class="text-4xl lg:text-7xl font-black mb-8 leading-tight">
                <?php echo esc_html($cta_title); ?>
            </h2>
            
            <p class="text-xl lg:text-2xl text-blue-100 mb-12 leading-relaxed font-medium max-w-2xl mx-auto">
                <?php echo esc_html($cta_description); ?>
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a 
                    href="<?php echo esc_url($cta_button_link); ?>" 
                    class="group w-full sm:w-auto px-12 py-5 bg-white text-blue-600 rounded-2xl font-black text-xl hover:bg-blue-50 transition-all shadow-2xl hover:-translate-y-1 hover:scale-105"
                >
                    <?php echo esc_html($cta_button_text); ?> 
                    <span class="inline-block group-hover:translate-x-[-5px] transition-transform">←</span>
                </a>
                
                <a 
                    href="<?php echo esc_url($cta_secondary_link); ?>" 
                    class="w-full sm:w-auto px-12 py-5 bg-transparent text-white border-2 border-white/30 rounded-2xl font-bold text-xl hover:bg-white/10 hover:border-white/50 transition-all"
                >
                    <?php echo esc_html($cta_secondary_text); ?>
                </a>
            </div>
            
            <!-- Trust indicators -->
            <div class="mt-16 flex flex-wrap items-center justify-center gap-8 text-blue-100">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-bold">تجربة مجانية 14 يوم</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-bold">لا حاجة لبطاقة ائتمان</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-bold">إلغاء في أي وقت</span>
                </div>
            </div>
        </div>
    </div>
</section>


