<?php
/**
 * Food Preset - Experience Section Template for Homepage
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

$experience_enable = alomran_get_option('food_experience_homepage_enable', true);
if (!$experience_enable) {
    return;
}

$experience_title = alomran_get_option('food_experience_homepage_title', 'فن الأجواء');
$experience_subtitle = alomran_get_option('food_experience_homepage_subtitle', 'اكتشف تجربة الجوهرة الفريدة');
$experience_description = alomran_get_option('food_experience_homepage_description', 'من الإضاءة الفاخرة إلى الخدمة الفندقية، كل تفصيلة مصممة لخلق تجربة لا تُنسى.');
$button_text = alomran_get_option('food_experience_homepage_button_text', 'اكتشف التجربة');
$button_link_type = alomran_get_option('food_experience_homepage_button_link_type', 'experience');
$button_link_custom = alomran_get_option('food_experience_homepage_button_link_custom', '');
$button_link = alomran_get_button_link($button_link_type, $button_link_custom);
$use_experience_image = alomran_get_option('food_experience_homepage_use_experience_image', true);

// Get background image
$bg_url = '';
if ($use_experience_image) {
    // Use the same image from experience page
    $experience_background = alomran_get_option('food_experience_background', '');
    if ($experience_background) {
        if (is_array($experience_background) && isset($experience_background['url'])) {
            $bg_url = $experience_background['url'];
        } elseif (is_numeric($experience_background)) {
            $bg_url = wp_get_attachment_image_url($experience_background, 'full');
        } elseif (is_string($experience_background)) {
            $attachment = get_posts(array(
                'post_type' => 'attachment',
                'post_status' => 'any',
                'meta_query' => array(
                    array(
                        'key' => '_demo_original_filename',
                        'value' => basename($experience_background),
                        'compare' => '='
                    )
                ),
                'posts_per_page' => 1,
                'fields' => 'ids'
            ));
            if (!empty($attachment)) {
                $bg_url = wp_get_attachment_image_url($attachment[0], 'full');
            } else {
                $bg_url = $experience_background;
            }
        }
    }
    // Fallback to local file
    if (empty($bg_url)) {
        $local_experience = get_template_directory() . '/presets/food/demo/media/experience-background.jpg';
        if (file_exists($local_experience)) {
            $bg_url = get_template_directory_uri() . '/presets/food/demo/media/experience-background.jpg';
        } else {
            $bg_url = 'https://images.unsplash.com/photo-1550966841-3ee7adac169a?q=80&w=1920';
        }
    }
} else {
    // Use custom image
    $custom_image = alomran_get_option('food_experience_homepage_custom_image', '');
    if ($custom_image) {
        if (is_array($custom_image) && isset($custom_image['url'])) {
            $bg_url = $custom_image['url'];
        } elseif (is_numeric($custom_image)) {
            $bg_url = wp_get_attachment_image_url($custom_image, 'full');
        } else {
            $bg_url = $custom_image;
        }
    }
}

// Get experience page data for preview
$lighting_title = alomran_get_option('food_experience_lighting_title', 'الإضاءة والموسيقى');
$lighting_content = alomran_get_option('food_experience_lighting_content', 'تم تصميم إضاءة الجوهرة لتعكس فخامة الأحجار الكريمة، مع سيمفونيات موسيقية هادئة مختارة بعناية لتناسب أرقى الأذواق.');
$service_title = alomran_get_option('food_experience_service_title', 'الخدمة الفندقية');
$service_content = alomran_get_option('food_experience_service_content', 'فريقنا مدرب على أعلى معايير الضيافة العالمية، ليضمن لك خصوصية تامة واهتماماً بأدق التفاصيل الشخصية.');
?>

<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-gray-900 via-gray-800 to-black homepage-experience">
    <!-- Background Image with Overlay -->
    <?php if (!empty($bg_url)) : ?>
    <div class="absolute inset-0 z-0">
        <img loading="lazy" decoding="async" 
            src="<?php echo esc_url($bg_url); ?>" 
            alt="<?php echo esc_attr($experience_title); ?>" 
            class="w-full h-full object-cover opacity-40 transition-transform duration-700 hover:scale-105"
        />
        <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/40 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
    </div>
    <?php endif; ?>

    <div class="relative z-10 container mx-auto px-4 py-20">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-16 animate-fade-in-up">
                <div class="inline-block mb-4">
                    <span class="text-brand-gold text-sm font-semibold tracking-wider uppercase border-b-2 border-brand-gold pb-2">
                        <?php echo esc_html($experience_subtitle); ?>
                    </span>
                </div>
                <h2 class="text-5xl md:text-7xl font-black text-white mb-6 leading-tight">
                    <?php echo esc_html($experience_title); ?>
                </h2>
                <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    <?php echo esc_html($experience_description); ?>
                </p>
            </div>

            <!-- Preview Cards -->
            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <!-- Lighting Card -->
                <div class="group relative bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 hover:bg-white/20 transition-all duration-500 transform hover:-translate-y-2 hover:shadow-2xl animate-fade-in-up delay-200">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-brand-gold/20 rounded-bl-full blur-3xl"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-brand-gold/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white"><?php echo esc_html($lighting_title); ?></h3>
                        </div>
                        <p class="text-gray-300 leading-relaxed"><?php echo esc_html($lighting_content); ?></p>
                    </div>
                </div>

                <!-- Service Card -->
                <div class="group relative bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 hover:bg-white/20 transition-all duration-500 transform hover:-translate-y-2 hover:shadow-2xl animate-fade-in-up delay-300">
                    <div class="absolute top-0 left-0 w-32 h-32 bg-brand-gold/20 rounded-br-full blur-3xl"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-brand-gold/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white"><?php echo esc_html($service_title); ?></h3>
                        </div>
                        <p class="text-gray-300 leading-relaxed"><?php echo esc_html($service_content); ?></p>
                    </div>
                </div>
            </div>

            <!-- CTA Button -->
            <div class="text-center animate-fade-in-up delay-400">
                <a 
                    href="<?php echo esc_url($button_link); ?>" 
                    class="inline-flex items-center gap-3 bg-brand-gold hover:bg-brand-gold/90 text-black px-8 py-4 rounded-lg font-bold text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl shadow-lg group"
                >
                    <span><?php echo esc_html($button_text); ?></span>
                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-white to-transparent"></div>
</section>

