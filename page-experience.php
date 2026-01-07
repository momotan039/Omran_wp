<?php
/**
 * Template Name: التجربة
 * Description: صفحة التجربة والأجواء
 * 
 * Food Preset - Experience Page Template
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$experience_title = alomran_get_option('food_experience_title', 'فن الأجواء');
$experience_quote = alomran_get_option('food_experience_quote', '"نحن لا نقدم الطعام فقط، بل نصمم الذكريات."');
$experience_background = alomran_get_option('food_experience_background', '');

// Get experience background image URL
$bg_url = '';
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
$lighting_title = alomran_get_option('food_experience_lighting_title', 'الإضاءة والموسيقى');
$lighting_content = alomran_get_option('food_experience_lighting_content', 'تم تصميم إضاءة الجوهرة لتعكس فخامة الأحجار الكريمة، مع سيمفونيات موسيقية هادئة مختارة بعناية لتناسب أرقى الأذواق.');
$service_title = alomran_get_option('food_experience_service_title', 'الخدمة الفندقية');
$service_content = alomran_get_option('food_experience_service_content', 'فريقنا مدرب على أعلى معايير الضيافة العالمية، ليضمن لك خصوصية تامة واهتماماً بأدق التفاصيل الشخصية.');
$ambiance_title = alomran_get_option('food_experience_ambiance_title', 'الأجواء والتصميم');
$ambiance_content = alomran_get_option('food_experience_ambiance_content', 'كل زاوية في الجوهرة تحكي قصة من التراث العربي بتصميم عصري أنيق. من الأثاث الفاخر إلى الأعمال الفنية المختارة بعناية، نخلق مساحة تجمع بين الفخامة والدفء.');
$privacy_title = alomran_get_option('food_experience_privacy_title', 'الخصوصية والمساحات');
$privacy_content = alomran_get_option('food_experience_privacy_content', 'نوفر مساحات خاصة للعائلات والأصدقاء، مع صالات VIP فاخرة للاحتفالات الخاصة والمناسبات المميزة. كل مساحة مصممة لضمان خصوصية تامة وراحة مطلقة.');
$events_title = alomran_get_option('food_experience_events_title', 'الأحداث الخاصة');
$events_content = alomran_get_option('food_experience_events_content', 'ننظم أمسيات موسيقية حية، عروض طهي خاصة، وليالي تذوق فريدة. كل حدث مصمم خصيصاً لتقديم تجربة استثنائية لا تُنسى.');
$stats_enable = alomran_get_option('food_experience_stats_enable', true);
$stat1_number = alomran_get_option('food_experience_stat1_number', '500+');
$stat1_label = alomran_get_option('food_experience_stat1_label', 'ضيف راضٍ');
$stat2_number = alomran_get_option('food_experience_stat2_number', '50+');
$stat2_label = alomran_get_option('food_experience_stat2_label', 'طبق مميز');
$stat3_number = alomran_get_option('food_experience_stat3_number', '100%');
$stat3_label = alomran_get_option('food_experience_stat3_label', 'رضا العملاء');

// Get featured menu items for signature dishes
$signature_dishes = alomran_food_get_menu_items(array(
    'posts_per_page' => 3,
    'orderby' => 'rand',
));
?>
<div class="bg-brand-black min-h-screen text-white pt-40 relative overflow-hidden experience-page">
    <!-- Background Image (Static - No Parallax) -->
    <div class="experience-bg absolute inset-0 opacity-30">
        <img src="<?php echo esc_url($bg_url); ?>" class="w-full h-full object-cover grayscale experience-bg-image" alt="<?php echo esc_attr($experience_title); ?>" loading="eager" decoding="async" />
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/20 to-black/60"></div>
    </div>
    
    <!-- Floating Particles -->
    <div class="experience-particles absolute inset-0 overflow-hidden pointer-events-none">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
        <div class="particle particle-4"></div>
        <div class="particle particle-5"></div>
    </div>
    
    <!-- Hero Section -->
    <div class="relative z-10 max-w-5xl mx-auto px-8 text-center mb-32 experience-hero">
        <h1 class="text-7xl md:text-8xl font-black text-brand-gold mb-12 leading-tight experience-title"><?php echo esc_html($experience_title); ?></h1>
        <p class="text-2xl md:text-3xl font-light leading-relaxed mb-20 italic text-gray-300 experience-quote"><?php echo esc_html($experience_quote); ?></p>
    </div>

    <!-- Main Features Grid -->
    <div class="relative z-10 max-w-7xl mx-auto px-8 mb-32">
        <div class="grid md:grid-cols-2 gap-16 mb-24 experience-features">
            <!-- Lighting Card -->
            <div class="group relative bg-white/5 backdrop-blur-sm rounded-3xl p-10 border border-white/10 hover:bg-white/10 transition-all duration-700 transform hover:-translate-y-3 hover:scale-[1.02] experience-card" data-delay="0">
                <div class="absolute top-0 right-0 w-40 h-40 bg-brand-gold/10 rounded-bl-full blur-3xl"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-brand-gold/20 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-4xl font-bold text-white border-r-4 border-brand-gold pr-6"><?php echo esc_html($lighting_title); ?></h3>
                    </div>
                    <p class="text-gray-400 text-xl leading-loose"><?php echo esc_html($lighting_content); ?></p>
                </div>
            </div>

            <!-- Service Card -->
            <div class="group relative bg-white/5 backdrop-blur-sm rounded-3xl p-10 border border-white/10 hover:bg-white/10 transition-all duration-700 transform hover:-translate-y-3 hover:scale-[1.02] experience-card" data-delay="100">
                <div class="absolute top-0 left-0 w-40 h-40 bg-brand-gold/10 rounded-br-full blur-3xl"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-brand-gold/20 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-4xl font-bold text-white border-r-4 border-brand-gold pr-6"><?php echo esc_html($service_title); ?></h3>
                    </div>
                    <p class="text-gray-400 text-xl leading-loose"><?php echo esc_html($service_content); ?></p>
                </div>
            </div>

            <!-- Ambiance Card -->
            <div class="group relative bg-white/5 backdrop-blur-sm rounded-3xl p-10 border border-white/10 hover:bg-white/10 transition-all duration-700 transform hover:-translate-y-3 hover:scale-[1.02] experience-card" data-delay="200">
                <div class="absolute top-0 right-0 w-40 h-40 bg-brand-gold/10 rounded-bl-full blur-3xl"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-brand-gold/20 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <h3 class="text-4xl font-bold text-white border-r-4 border-brand-gold pr-6"><?php echo esc_html($ambiance_title); ?></h3>
                    </div>
                    <p class="text-gray-400 text-xl leading-loose"><?php echo esc_html($ambiance_content); ?></p>
                </div>
            </div>

            <!-- Privacy Card -->
            <div class="group relative bg-white/5 backdrop-blur-sm rounded-3xl p-10 border border-white/10 hover:bg-white/10 transition-all duration-700 transform hover:-translate-y-3 hover:scale-[1.02] experience-card" data-delay="300">
                <div class="absolute top-0 left-0 w-40 h-40 bg-brand-gold/10 rounded-br-full blur-3xl"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-brand-gold/20 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h3 class="text-4xl font-bold text-white border-r-4 border-brand-gold pr-6"><?php echo esc_html($privacy_title); ?></h3>
                    </div>
                    <p class="text-gray-400 text-xl leading-loose"><?php echo esc_html($privacy_content); ?></p>
                </div>
            </div>
        </div>

        <!-- Events Section -->
        <div class="relative bg-gradient-to-br from-brand-gold/10 via-brand-gold/5 to-transparent rounded-3xl p-12 border border-brand-gold/20 mb-24 experience-events">
            <div class="flex items-center gap-6 mb-8">
                <div class="w-20 h-20 bg-brand-gold/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-10 h-10 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-5xl font-bold text-white"><?php echo esc_html($events_title); ?></h3>
            </div>
            <p class="text-gray-300 text-2xl leading-relaxed max-w-4xl"><?php echo esc_html($events_content); ?></p>
        </div>

        <!-- Stats Section -->
        <?php if ($stats_enable) : ?>
        <div class="grid md:grid-cols-3 gap-8 mb-24 experience-stats">
            <div class="text-center bg-white/5 backdrop-blur-sm rounded-2xl p-8 border border-white/10 hover:bg-white/10 transition-all duration-500 transform hover:scale-105 experience-stat" data-stat="<?php echo esc_attr($stat1_number); ?>" data-delay="0">
                <div class="text-6xl font-black text-brand-gold mb-4 stat-number">0</div>
                <div class="text-xl text-gray-300 stat-label"><?php echo esc_html($stat1_label); ?></div>
            </div>
            <div class="text-center bg-white/5 backdrop-blur-sm rounded-2xl p-8 border border-white/10 hover:bg-white/10 transition-all duration-500 transform hover:scale-105 experience-stat" data-stat="<?php echo esc_attr($stat2_number); ?>" data-delay="200">
                <div class="text-6xl font-black text-brand-gold mb-4 stat-number">0</div>
                <div class="text-xl text-gray-300 stat-label"><?php echo esc_html($stat2_label); ?></div>
            </div>
            <div class="text-center bg-white/5 backdrop-blur-sm rounded-2xl p-8 border border-white/10 hover:bg-white/10 transition-all duration-500 transform hover:scale-105 experience-stat" data-stat="<?php echo esc_attr($stat3_number); ?>" data-delay="400">
                <div class="text-6xl font-black text-brand-gold mb-4 stat-number">0</div>
                <div class="text-xl text-gray-300 stat-label"><?php echo esc_html($stat3_label); ?></div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Signature Dishes Section -->
        <?php if ($signature_dishes->have_posts()) : ?>
        <div class="mb-24 experience-dishes">
            <div class="text-center mb-16 experience-dishes-header">
                <h2 class="text-5xl font-black text-brand-gold mb-4">مختارات الشيف</h2>
                <p class="text-xl text-gray-400">أطباقنا المميزة التي تحكي قصة الجوهرة</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <?php $dish_index = 0; while ($signature_dishes->have_posts()) : $signature_dishes->the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="group relative overflow-hidden rounded-3xl h-[400px] border border-white/10 hover:border-brand-gold/50 transition-all duration-700 transform hover:scale-105 experience-dish" data-delay="<?php echo $dish_index * 150; ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-700', 'loading' => 'lazy', 'decoding' => 'async')); ?>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-8">
                        <h3 class="text-3xl font-bold text-white mb-2 group-hover:text-brand-gold transition-colors"><?php the_title(); ?></h3>
                        <?php 
                        $price = get_post_meta(get_the_ID(), 'price', true);
                        if ($price) : ?>
                            <p class="text-brand-gold text-xl font-semibold"><?php echo esc_html($price); ?></p>
                        <?php endif; ?>
                    </div>
                </a>
                <?php $dish_index++; endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- CTA Section -->
        <div class="text-center bg-gradient-to-r from-brand-gold/20 via-brand-gold/10 to-transparent rounded-3xl p-16 border border-brand-gold/30 experience-cta">
            <h2 class="text-5xl font-black text-white mb-6">جاهز لتجربة الجوهرة؟</h2>
            <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">احجز طاولتك الآن واستمتع بتجربة طهي استثنائية لا تُنسى</p>
            <a href="<?php echo esc_url(alomran_format_url('/reservations')); ?>" class="inline-flex items-center gap-4 bg-brand-gold hover:bg-brand-gold/90 text-black px-10 py-5 rounded-xl font-bold text-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl shadow-lg group">
                <span>احجز طاولتك</span>
                <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
</div>

<style>
/* Experience Page Cinematic Animations */
.experience-page {
    position: relative;
}

/* Static Background - No Parallax */
.experience-bg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.experience-bg-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Floating Particles */
.experience-particles {
    z-index: 1;
}

.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: rgba(212, 175, 55, 0.3);
    border-radius: 50%;
    animation: float 20s infinite ease-in-out;
}

.particle-1 {
    top: 20%;
    left: 10%;
    animation-delay: 0s;
    animation-duration: 15s;
}

.particle-2 {
    top: 60%;
    left: 80%;
    animation-delay: 2s;
    animation-duration: 18s;
}

.particle-3 {
    top: 80%;
    left: 30%;
    animation-delay: 4s;
    animation-duration: 20s;
}

.particle-4 {
    top: 40%;
    left: 70%;
    animation-delay: 6s;
    animation-duration: 16s;
}

.particle-5 {
    top: 10%;
    left: 50%;
    animation-delay: 8s;
    animation-duration: 22s;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0) translateX(0) scale(1);
        opacity: 0.3;
    }
    25% {
        transform: translateY(-30px) translateX(20px) scale(1.2);
        opacity: 0.6;
    }
    50% {
        transform: translateY(-60px) translateX(-20px) scale(0.8);
        opacity: 0.4;
    }
    75% {
        transform: translateY(-30px) translateX(30px) scale(1.1);
        opacity: 0.5;
    }
}

/* Hero Section Animations */
.experience-hero {
    opacity: 0;
    animation: fadeInUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) 0.3s forwards;
}

.experience-title {
    opacity: 0;
    transform: translateY(50px);
    animation: titleReveal 1.5s cubic-bezier(0.16, 1, 0.3, 1) 0.5s forwards;
}

.experience-quote {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) 1.2s forwards;
}

@keyframes titleReveal {
    0% {
        opacity: 0;
        transform: translateY(50px) scale(0.9);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Cards Stagger Animation */
.experience-card {
    opacity: 0;
    transform: translateY(60px) scale(0.95);
    transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1);
}

.experience-card.animated {
    opacity: 1;
    transform: translateY(0) scale(1);
}

/* Events Section */
.experience-events {
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.experience-events.animated {
    opacity: 1;
    transform: translateY(0);
}

/* Stats Counter Animation */
.experience-stat {
    opacity: 0;
    transform: translateY(40px) scale(0.9);
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.experience-stat.animated {
    opacity: 1;
    transform: translateY(0) scale(1);
}

.stat-number {
    transition: all 0.3s ease;
}

/* Dishes Section */
.experience-dishes-header {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.experience-dishes-header.animated {
    opacity: 1;
    transform: translateY(0);
}

.experience-dish {
    opacity: 0;
    transform: translateY(50px) rotateY(10deg);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.experience-dish.animated {
    opacity: 1;
    transform: translateY(0) rotateY(0deg);
}

.experience-dish:hover {
    transform: translateY(-10px) scale(1.05) rotateY(-2deg);
}

/* CTA Section */
.experience-cta {
    opacity: 0;
    transform: translateY(40px) scale(0.95);
    transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.experience-cta.animated {
    opacity: 1;
    transform: translateY(0) scale(1);
}

/* Smooth Scroll Behavior */
html {
    scroll-behavior: smooth;
}

/* Glow Effect on Hover */
.experience-card:hover .absolute {
    animation: glowPulse 2s ease-in-out infinite;
}

@keyframes glowPulse {
    0%, 100% {
        opacity: 0.1;
        transform: scale(1);
    }
    50% {
        opacity: 0.2;
        transform: scale(1.1);
    }
}
</style>

<script>
(function() {
    'use strict';
    
    // Removed Parallax - Background is now static for smoother experience
    
    // Scroll Animations
    function initScrollAnimations() {
        const observerOptions = {
            threshold: 0.15,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const delay = element.dataset.delay || 0;
                    
                    setTimeout(function() {
                        element.classList.add('animated');
                    }, delay);
                    
                    observer.unobserve(element);
                }
            });
        }, observerOptions);
        
        // Observe all animated elements
        document.querySelectorAll('.experience-card, .experience-events, .experience-stat, .experience-dishes-header, .experience-dish, .experience-cta').forEach(function(el) {
            observer.observe(el);
        });
    }
    
    // Number Counter Animation
    function animateCounter(element, target, duration = 2000) {
        const isPercentage = target.includes('%');
        const isPlus = target.includes('+');
        const numTarget = parseInt(target.replace(/[^0-9]/g, ''));
        const start = 0;
        const increment = numTarget / (duration / 16);
        let current = start;
        
        const timer = setInterval(function() {
            current += increment;
            if (current >= numTarget) {
                current = numTarget;
                clearInterval(timer);
            }
            
            let displayValue = Math.floor(current);
            if (isPlus) displayValue += '+';
            if (isPercentage) displayValue += '%';
            
            element.textContent = displayValue;
        }, 16);
    }
    
    // Stats Counter Observer
    function initStatsCounter() {
        const statsObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const statElement = entry.target;
                    const statNumber = statElement.querySelector('.stat-number');
                    const targetValue = statElement.dataset.stat;
                    
                    if (statNumber && targetValue) {
                        const delay = parseInt(statElement.dataset.delay || 0);
                        setTimeout(function() {
                            animateCounter(statNumber, targetValue);
                        }, delay);
                    }
                    
                    statsObserver.unobserve(statElement);
                }
            });
        }, { threshold: 0.5 });
        
        document.querySelectorAll('.experience-stat').forEach(function(stat) {
            statsObserver.observe(stat);
        });
    }
    
    // Initialize all animations
    function init() {
        // Parallax removed for smoother experience
        initScrollAnimations();
        initStatsCounter();
        
        // Animate hero immediately
        setTimeout(function() {
            document.querySelector('.experience-hero')?.classList.add('animated');
        }, 100);
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>

<?php get_footer(); ?>

