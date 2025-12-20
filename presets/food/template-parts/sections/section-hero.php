<?php
/**
 * Food Preset - Hero Section Template
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

$hero_enable = alomran_get_option('food_hero_enable', true);
if (!$hero_enable) {
    return;
}

$hero_badge = alomran_get_option('food_hero_badge', 'Al-Jawhara Dining Experience');
$hero_title = alomran_get_option('food_hero_title', 'جوهرة الضيافة');
$hero_title_highlight = alomran_get_option('food_hero_title_highlight', 'الضيافة');
$hero_description = alomran_get_option('food_hero_description', 'حيث يلتقي عبق الماضي بأناقة الحاضر في تجربة طهي استثنائية مصممة لنخبة الذواقين.');
$hero_background = alomran_get_option('food_hero_background_image', '');
// Try to get image from media library by filename first
$hero_bg_url = '';
if ($hero_background) {
    if (is_array($hero_background) && isset($hero_background['url'])) {
        $hero_bg_url = $hero_background['url'];
    } elseif (is_numeric($hero_background)) {
        $hero_bg_url = wp_get_attachment_image_url($hero_background, 'full');
    } elseif (is_string($hero_background)) {
        // Try to find by filename
        $attachment = get_posts(array(
            'post_type' => 'attachment',
            'post_status' => 'any',
            'meta_query' => array(
                array(
                    'key' => '_demo_original_filename',
                    'value' => basename($hero_background),
                    'compare' => '='
                )
            ),
            'posts_per_page' => 1,
            'fields' => 'ids'
        ));
        if (!empty($attachment)) {
            $hero_bg_url = wp_get_attachment_image_url($attachment[0], 'full');
        } else {
            $hero_bg_url = $hero_background; // Fallback to URL string
        }
    }
}
// Fallback to local file if exists
if (empty($hero_bg_url)) {
    $local_hero = get_template_directory() . '/presets/food/demo/media/hero-background.jpg';
    if (file_exists($local_hero)) {
        $hero_bg_url = get_template_directory_uri() . '/presets/food/demo/media/hero-background.jpg';
    } else {
        $hero_bg_url = 'https://images.unsplash.com/photo-1544148103-0773bf10d330?q=80&w=1920&auto=format&fit=crop';
    }
}
$primary_button_text = alomran_get_option('food_hero_primary_button_text', 'احجز طاولتك');
$primary_button_link_type = alomran_get_option('food_hero_primary_button_link_type', 'reservations');
$primary_button_link_custom = alomran_get_option('food_hero_primary_button_link_custom', '');
$primary_button_link = alomran_get_button_link($primary_button_link_type, $primary_button_link_custom);

$secondary_button_text = alomran_get_option('food_hero_secondary_button_text', 'استكشف القائمة');
$secondary_button_link_type = alomran_get_option('food_hero_secondary_button_link_type', '#menu');
$secondary_button_link_custom = alomran_get_option('food_hero_secondary_button_link_custom', '');
$secondary_button_link = alomran_get_button_link($secondary_button_link_type, $secondary_button_link_custom);
?>
<section class="relative h-screen w-full overflow-hidden bg-brand-black flex items-center homepage-hero">
    <!-- Background -->
    <div class="absolute inset-0 z-0 opacity-60">
        <img src="<?php echo esc_url($hero_bg_url); ?>" alt="<?php echo esc_attr($hero_title); ?>" class="w-full h-full object-cover" loading="eager" decoding="async" />
        <div class="absolute inset-0" style="background: linear-gradient(to left, #0A0A0A, rgba(10, 10, 10, 0.4), transparent);"></div>
    </div>

    <div class="relative z-20 max-w-7xl mx-auto px-8 w-full">
        <div class="max-w-3xl text-right">
            <div class="animate-fade-in-up">
                <span class="text-brand-gold font-bold tracking-[0.5em] uppercase text-sm mb-6 block drop-shadow-lg">
                    <?php echo esc_html($hero_badge); ?>
                </span>
            </div>
            
            <h1 class="text-6xl md:text-8xl lg:text-9xl font-black text-white leading-none mb-8 drop-shadow-2xl animate-fade-in-up delay-200">
                <?php 
                $title_parts = explode($hero_title_highlight, $hero_title);
                echo esc_html($title_parts[0]);
                if (isset($title_parts[1])) {
                    echo '<span class="text-brand-gold italic">' . esc_html($hero_title_highlight) . '</span>';
                    echo esc_html($title_parts[1]);
                } else {
                    echo esc_html($hero_title);
                }
                ?>
            </h1>

            <p class="text-xl md:text-2xl text-gray-200 font-light leading-relaxed mb-12 max-w-xl ml-auto animate-fade-in-up delay-400">
                <?php echo esc_html($hero_description); ?>
            </p>
            
            <div class="flex justify-end gap-6 animate-fade-in-up delay-600">
                <a href="<?php echo esc_url($primary_button_link); ?>" class="bg-brand-gold text-brand-black px-12 py-5 rounded-full font-black text-lg hover:bg-white transition-all shadow-2xl hover:scale-105 active:scale-95">
                    <?php echo esc_html($primary_button_text); ?>
                </a>
                <a href="<?php echo esc_url($secondary_button_link); ?>" class="border border-white/30 text-white px-10 py-5 rounded-full font-bold text-lg backdrop-blur-sm hover:bg-white/10 transition-all">
                    <?php echo esc_html($secondary_button_text); ?>
                </a>
            </div>
        </div>
    </div>

    <!-- Vertical Decorative Bar -->
    <div class="absolute right-12 bottom-24 hidden lg:flex flex-col items-center gap-8">
        <div class="w-[1px] h-32" style="background-color: rgba(212, 175, 55, 0.5);"></div>
        <span class="rotate-90 text-brand-gold tracking-[1em] text-[10px] uppercase origin-center whitespace-nowrap opacity-70">Scroll Experience</span>
    </div>
</section>

