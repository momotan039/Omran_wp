<?php
/**
 * Tech Preset - Hero Section Template
 *
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get hero settings
$hero_enable = alomran_get_option('tech_hero_enable', true);
if (!$hero_enable) {
    return;
}

$hero_badge = alomran_get_option('tech_hero_badge', 'جديد: الربط المباشر مع منصات "زد" و "سلة" و "تطوير"');
$hero_title = alomran_get_option('tech_hero_title', 'اربط تقنياتك وأتمت عملك');
$hero_title_highlight = alomran_get_option('tech_hero_title_highlight', 'في 5 ثوانٍ فقط');
$hero_description = alomran_get_option('tech_hero_description', 'محرك الأتمتة الأول للشركات التقنية في المنطقة. وفر أسابيع من التطوير البرمجي وابدأ التوسع اليوم.');
$hero_image = alomran_get_option('tech_hero_image', '');

// Get button settings
$primary_button_text = alomran_get_option('tech_hero_primary_button_text', 'ابدأ مجاناً');
$primary_button_link_type = alomran_get_option('tech_hero_primary_button_link_type', 'register');
$primary_button_link_custom = alomran_get_option('tech_hero_primary_button_link_custom', '');
$primary_button_link = alomran_get_button_link($primary_button_link_type, $primary_button_link_custom);

$secondary_button_text = alomran_get_option('tech_hero_secondary_button_text', 'شاهد العرض');
$secondary_button_link_type = alomran_get_option('tech_hero_secondary_button_link_type', 'features');
$secondary_button_link_custom = alomran_get_option('tech_hero_secondary_button_link_custom', '');
$secondary_button_link = alomran_get_button_link($secondary_button_link_type, $secondary_button_link_custom);

// Get image URL
$hero_image_url = '';
if ($hero_image) {
    if (is_array($hero_image) && isset($hero_image['url'])) {
        $hero_image_url = $hero_image['url'];
    } elseif (is_numeric($hero_image)) {
        $hero_image_url = wp_get_attachment_image_url($hero_image, 'full');
    }
}
?>
<section id="hero" class="relative pt-24 pb-20 lg:pt-32 lg:pb-40 overflow-hidden">
    <!-- Enhanced animated background -->
    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-[600px] h-[600px] bg-blue-100 rounded-full blur-[120px] opacity-40 animate-pulse"></div>
    <div class="absolute top-20 left-0 -translate-x-1/4 w-[400px] h-[400px] bg-violet-100 rounded-full blur-[100px] opacity-30"></div>
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-blue-200 rounded-full blur-[150px] opacity-20 animate-pulse" style="animation-delay: 1.5s;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-5xl mx-auto">
            <?php if ($hero_badge) : ?>
                <div class="hero-badge inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white border border-blue-100 text-blue-700 text-xs sm:text-sm font-bold mb-10 shadow-sm transition-all duration-1000 transform opacity-0 translate-y-4">
                    <span class="flex h-2 w-2 rounded-full bg-blue-600 animate-ping"></span>
                    <?php echo esc_html($hero_badge); ?>
                </div>
            <?php endif; ?>
            
            <h1 class="hero-title text-5xl lg:text-8xl font-black text-slate-900 leading-[1.1] mb-8 tracking-tight transition-all duration-1000 delay-300 transform opacity-0 translate-y-12 blur-xl">
                <?php echo esc_html($hero_title); ?> <br />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-violet-600 animate-gradient-x">
                    <?php echo esc_html($hero_title_highlight); ?>
                </span>
            </h1>
            
            <p class="hero-description text-xl lg:text-2xl text-slate-600 mb-12 leading-relaxed max-w-3xl mx-auto font-medium transition-all duration-1000 delay-500 transform opacity-0 translate-y-8">
                <?php echo esc_html($hero_description); ?>
            </p>
            
            <div class="hero-buttons flex flex-col sm:flex-row items-center justify-center gap-5 transition-all duration-1000 delay-700 transform opacity-0 translate-y-6">
                <a href="<?php echo esc_url($primary_button_link); ?>" class="group w-full sm:w-auto px-12 py-5 bg-blue-600 text-white rounded-2xl font-black text-xl hover:bg-blue-700 transition-all shadow-2xl shadow-blue-200 hover:-translate-y-1">
                    <?php echo esc_html($primary_button_text); ?> <span class="inline-block group-hover:translate-x-[-5px] transition-transform">←</span>
                </a>
                <a href="<?php echo esc_url($secondary_button_link); ?>" class="w-full sm:w-auto px-12 py-5 bg-white text-slate-700 border border-slate-200 rounded-2xl font-bold text-xl hover:bg-slate-50 transition-all hover:-translate-y-1">
                    <?php echo esc_html($secondary_button_text); ?>
                </a>
            </div>

            <?php if ($hero_image_url) : ?>
                <div class="mt-24 relative hero-image-container transition-all duration-1000 delay-1000 transform opacity-0 translate-y-20 scale-95">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-50 via-transparent to-transparent z-10 bottom-0 h-32"></div>
                    <div class="rounded-[3rem] overflow-hidden border-[12px] border-white shadow-[0_50px_100px_-20px_rgba(0,0,0,0.15)] bg-slate-900 group">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/0 via-blue-600/10 to-violet-600/0 opacity-0 group-hover:opacity-100 transition-opacity duration-700 z-10"></div>
                        <img 
                            src="<?php echo esc_url($hero_image_url); ?>" 
                            alt="<?php echo esc_attr($hero_title); ?>" 
                            class="w-full h-auto opacity-90 hover:opacity-100 transition-all duration-700 group-hover:scale-105"
                        />
                    </div>
                    <!-- Floating badges -->
                    <div class="absolute -top-6 -right-6 bg-blue-600 text-white px-6 py-3 rounded-2xl shadow-2xl font-black text-sm animate-bounce" style="animation-delay: 2s;">
                        ⚡ سريع جداً
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-violet-600 text-white px-6 py-3 rounded-2xl shadow-2xl font-black text-sm animate-bounce" style="animation-delay: 2.5s;">
                        🔒 آمن 100%
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

