<?php
/**
 * Tech Preset - Case Study Section Template
 *
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get case study settings
$case_study_enable = alomran_get_option('tech_case_study_enable', true);
if (!$case_study_enable) {
    return;
}

$case_study_title = alomran_get_option('tech_case_study_title', 'كيف أتمتنا 50,000 شحنة شهرياً؟');
$case_study_description = alomran_get_option('tech_case_study_description', 'قامت شركة "توصيل" بربط أسطولها التقني بالكامل عبر واجهة إتقان، مما سمح لهم بتتبع الشحنات لحظياً آلياً في الوقت الحقيقي.');
$case_study_link_text = alomran_get_option('tech_case_study_link_text', 'اقرأ تفاصيل الربط التقني');
$case_study_link_type = alomran_get_option('tech_case_study_link_type', 'use-cases');
$case_study_link_custom = alomran_get_option('tech_case_study_link_custom', '');
$case_study_link = alomran_get_button_link($case_study_link_type, $case_study_link_custom);

$case_study_image = alomran_get_option('tech_case_study_image', '');

// Get image URL
$case_study_image_url = '';
if ($case_study_image) {
    if (is_array($case_study_image) && isset($case_study_image['url'])) {
        $case_study_image_url = $case_study_image['url'];
    } elseif (is_numeric($case_study_image)) {
        $case_study_image_url = wp_get_attachment_image_url($case_study_image, 'full');
    }
}

// Fallback image
if (!$case_study_image_url) {
    $case_study_image_url = 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&q=80&w=2000';
}
?>
<section id="case-study" class="py-32 bg-slate-900 text-white relative overflow-hidden">
    <!-- Enhanced background effects -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600/20 rounded-full blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-violet-600/20 rounded-full blur-[120px] animate-pulse" style="animation-delay: 1s;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 transition-all duration-1000 transform opacity-0 translate-y-10 scale-95">
        <div class="lg:flex items-center gap-24">
            <div class="lg:w-1/2">
                <h3 class="text-4xl lg:text-6xl font-black mb-10 leading-[1.15]"><?php echo esc_html($case_study_title); ?></h3>
                <p class="text-slate-400 text-xl mb-12 leading-relaxed font-medium"><?php echo esc_html($case_study_description); ?></p>
                <a href="<?php echo esc_url($case_study_link); ?>" class="inline-flex items-center gap-3 text-blue-400 font-black text-lg hover:gap-6 transition-all group">
                    <?php echo esc_html($case_study_link_text); ?> <span>←</span>
                </a>
            </div>
            <div class="lg:w-1/2 mt-16 lg:mt-0 relative group">
                <div class="absolute inset-0 bg-blue-600 rounded-[4rem] opacity-20 blur-3xl group-hover:opacity-40 transition-opacity duration-700"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/30 to-violet-600/30 rounded-[4rem] opacity-0 group-hover:opacity-100 transition-opacity duration-700 z-20"></div>
                <img 
                    src="<?php echo esc_url($case_study_image_url); ?>" 
                    class="rounded-[4rem] shadow-2xl relative z-10 w-full transition-all duration-700 group-hover:scale-[1.05] group-hover:brightness-110" 
                    alt="<?php echo esc_attr($case_study_title); ?>" 
                />
                <!-- Success badge -->
                <div class="absolute top-6 right-6 bg-emerald-500 text-white px-4 py-2 rounded-xl shadow-xl font-black text-xs z-30 animate-pulse">
                    ✓ نجاح مؤكد
                </div>
            </div>
        </div>
    </div>
</section>

