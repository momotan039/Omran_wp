<?php
/**
 * Food Preset - Story Section Template
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

$story_enable = alomran_get_option('food_story_enable', true);
if (!$story_enable) {
    return;
}

$story_image = alomran_get_option('food_story_image', '');
$story_title = alomran_get_option('food_story_title', 'أكثر من مجرد مطعم، نحن وجهة ثقافية.');
$story_title_highlight = alomran_get_option('food_story_title_highlight', 'وجهة ثقافية');
$story_subtitle = alomran_get_option('food_story_subtitle', 'قصتنا');
$story_description_1 = alomran_get_option('food_story_description_1', 'في "الجوهرة"، نؤمن بأن الطعام هو لغة الحب وكرم الضيافة. تأسسنا برؤية تهدف إلى إعادة تعريف المطبخ الشرقي، مقدمين أطباقاً تحترم الجذور وتعانق الحداثة العالمية.');
$story_description_2 = alomran_get_option('food_story_description_2', 'كل طبق هو سيمفونية من المذاق، وكل زاوية في فروعنا تروي حكاية من التراث العربي بتصميم عصري أنيق، لنضمن لكم ولعائلاتكم لحظات من الرفاهية والسكينة.');

// Get story image URL
$story_image_url = '';
if ($story_image) {
    if (is_array($story_image) && isset($story_image['url'])) {
        $story_image_url = $story_image['url'];
    } elseif (is_numeric($story_image)) {
        $story_image_url = wp_get_attachment_image_url($story_image, 'large');
    } elseif (is_string($story_image)) {
        $attachment = get_posts(array(
            'post_type' => 'attachment',
            'post_status' => 'any',
            'meta_query' => array(
                array(
                    'key' => '_demo_original_filename',
                    'value' => basename($story_image),
                    'compare' => '='
                )
            ),
            'posts_per_page' => 1,
            'fields' => 'ids'
        ));
        if (!empty($attachment)) {
            $story_image_url = wp_get_attachment_image_url($attachment[0], 'large');
        } else {
            $story_image_url = $story_image;
        }
    }
}
// Fallback to local file
if (empty($story_image_url)) {
    $local_story = get_template_directory() . '/presets/food/demo/media/story-section-image.jpg';
    if (file_exists($local_story)) {
        $story_image_url = get_template_directory_uri() . '/presets/food/demo/media/story-section-image.jpg';
    } else {
        $story_image_url = 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1200&auto=format&fit=crop';
    }
}
?>
<section id="story" class="py-20 md:py-32 bg-brand-cream relative overflow-hidden homepage-story">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <!-- Text Content -->
            <div class="order-2 lg:order-1 text-right story-content">
                <?php if (!empty($story_subtitle)): ?>
                    <div class="flex items-center gap-4 mb-6 story-subtitle">
                        <span class="h-[2px] w-16 bg-brand-gold"></span>
                        <h3 class="text-brand-gray uppercase tracking-widest font-bold"><?php echo esc_html($story_subtitle); ?></h3>
                    </div>
                <?php endif; ?>
                <div class="mb-8 story-title-wrapper">
                    <h2 class="text-4xl md:text-5xl font-black text-brand-black leading-snug mb-4 story-title">
                        <?php echo esc_html($story_title); ?>
                    </h2>
                    <?php if (!empty($story_title_highlight)): ?>
                        <div class="flex items-center gap-4 story-highlight">
                            <span class="h-[2px] w-12 bg-brand-gold"></span>
                            <p class="text-2xl md:text-3xl font-black text-brand-gold italic">
                                <?php echo esc_html($story_title_highlight); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
                <p class="text-brand-gray text-lg leading-loose mb-6 story-description-1">
                    <?php echo esc_html($story_description_1); ?>
                </p>
                <p class="text-brand-gray text-lg leading-loose story-description-2">
                    <?php echo esc_html($story_description_2); ?>
                </p>
            </div>

            <!-- Image Composition -->
            <div class="order-1 lg:order-2 relative story-image-wrapper">
                <div class="relative z-10 rounded-[40px] overflow-hidden luxury-shadow">
                    <img
                        src="<?php echo esc_url($story_image_url); ?>"
                        alt="Al-Jawhara Fine Dining Concept"
                        class="w-full h-[600px] object-cover"
                        loading="lazy"
                        decoding="async"
                    />
                </div>
                <!-- Abstract Decorative Element -->
                <div class="absolute -top-10 -left-10 w-64 h-64 bg-brand-gold/10 rounded-full blur-[100px] -z-0" style="width: 256px; height: 256px; background-color: rgba(212, 175, 55, 0.1); filter: blur(100px); border-radius: 9999px;"></div>
                <div class="absolute -bottom-10 -right-10 w-80 h-80 bg-brand-accent/10 rounded-full blur-[100px] -z-0" style="width: 320px; height: 320px; background-color: rgba(184, 134, 11, 0.1); filter: blur(100px); border-radius: 9999px;"></div>
            </div>
        </div>
    </div>
</section>

