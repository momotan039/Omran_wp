<?php
/**
 * Template Name: القصة
 * Description: صفحة القصة والمنشأ
 * 
 * Food Preset - Story Page Template
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="font-sans antialiased text-brand-black bg-brand-cream min-h-screen relative overflow-x-hidden">
    <?php
    $story_title = alomran_get_option('food_story_page_title', 'القصة والمنشأ');
    $story_subtitle = alomran_get_option('food_story_page_subtitle', 'Our Story');
    $story_image = alomran_get_option('food_story_page_image', '');
    // Fallback to story section image if page image not set
    if (empty($story_image)) {
        $story_image = alomran_get_option('food_story_image', '');
    }
    $story_content = alomran_get_option('food_story_page_content', 'بدأت الجوهرة كحلم لجمع شتات المطبخ العربي في قالب عالمي أنيق. كل حجر في مطاعمنا، وكل نكهة في قائمة طعامنا، تم اختيارها لتكون جزءاً من هذا الإرث.

نحن نؤمن بأن الطعام ليس مجرد وجبة، بل هو رحلة عبر الزمن والثقافة. من حقول الزعفران في إيران إلى مزارع الزيتون في فلسطين، نجمع أندر المكونات لنقدم لك تجربة طهي استثنائية.');
    // Fallback to story section content if page content not set
    if (empty($story_content)) {
        $story_content = alomran_get_option('food_story_content', $story_content);
    }
    $story_quote = alomran_get_option('food_story_page_quote', '');
    $story_quote_author = alomran_get_option('food_story_page_quote_author', '');
    
    // Handle image
    $image_id = '';
    $image_url = '';
    
    if (!empty($story_image)) {
        if (is_array($story_image)) {
            $image_id = isset($story_image['id']) ? $story_image['id'] : '';
            $image_url = isset($story_image['url']) ? $story_image['url'] : '';
        } else {
            $image_id = is_numeric($story_image) ? $story_image : '';
            $image_url = !is_numeric($story_image) ? $story_image : '';
        }
    }
    
    $image_src = '';
    if (!empty($image_id) && is_numeric($image_id)) {
        $image_src = wp_get_attachment_image_url($image_id, 'full');
    } elseif (!empty($image_url)) {
        $image_src = $image_url;
    }
    ?>
    
    <!-- Hero Section -->
    <section class="relative h-[70vh] min-h-[600px] overflow-hidden bg-brand-black cinematic-hero">
        <!-- Animated Background -->
        <div class="absolute inset-0 cinematic-bg">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-gold/20 via-brand-gold/5 to-brand-black"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand-gold/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 cinematic-orb cinematic-orb-1"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-brand-gold/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2 cinematic-orb cinematic-orb-2"></div>
        </div>
        
        <!-- Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-8 h-full flex items-center">
            <div class="text-center w-full">
                <div class="inline-block mb-8 cinematic-fade-in" style="animation-delay: 0.2s;">
                    <span class="text-xs uppercase tracking-[0.5em] text-brand-gold font-bold opacity-80 cinematic-glow"><?php echo esc_html($story_subtitle); ?></span>
                </div>
                <h1 class="text-7xl md:text-8xl font-black text-white mb-8 leading-tight cinematic-slide-up" style="animation-delay: 0.4s;" itemprop="headline">
                    <?php echo esc_html($story_title); ?>
                </h1>
                <div class="mt-12 flex justify-center cinematic-scale-in" style="animation-delay: 0.6s;">
                    <div class="w-32 h-1 bg-brand-gold cinematic-line"></div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 cinematic-bounce">
            <svg class="w-6 h-6 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </section>

    <!-- Story Content Section -->
    <section class="py-32 bg-gradient-to-b from-brand-cream via-white to-brand-cream relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-20 right-0 w-96 h-96 bg-brand-gold/8 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 left-0 w-96 h-96 bg-brand-gold/8 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        
        <div class="relative z-10 max-w-[1400px] mx-auto px-6 lg:px-12">
            <!-- Main Image -->
            <?php if (!empty($image_src)): ?>
            <div class="mb-20 cinematic-fade-in">
                <div class="relative overflow-hidden luxury-shadow rounded-[60px] cinematic-card" style="box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);">
                    <div class="aspect-[16/9] w-full overflow-hidden">
                        <img 
                            src="<?php echo esc_url($image_src); ?>" 
                            alt="<?php echo esc_attr($story_title); ?>" 
                            class="w-full h-full object-cover transition-transform duration-1000 hover:scale-110"
                            loading="lazy"
                            decoding="async"
                        />
                    </div>
                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-black/20 to-transparent pointer-events-none"></div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Story Content -->
            <div class="max-w-4xl mx-auto">
                <div class="prose prose-lg max-w-none text-2xl text-brand-gray leading-relaxed mb-16 cinematic-slide-up" style="animation-delay: 0.2s;">
                    <?php echo wp_kses_post(wpautop($story_content)); ?>
                </div>
                
                <!-- Quote Section -->
                <?php if (!empty($story_quote)): ?>
                <div class="my-20 cinematic-fade-in" style="animation-delay: 0.4s;">
                    <div class="relative bg-gradient-to-br from-brand-black to-brand-black/95 luxury-shadow p-12 md:p-16 rounded-[50px] cinematic-card" style="box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);">
                        <!-- Decorative Elements -->
                        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-brand-gold/20 to-transparent rounded-bl-full"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-brand-gold/10 to-transparent rounded-tr-full"></div>
                        
                        <div class="relative z-10 text-center">
                            <svg class="w-16 h-16 text-brand-gold mx-auto mb-8 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.996 2.151c-2.481.817-4.276 3.049-4.276 5.806v4.384h6.293v7.659h-11.996zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.482.817-4.277 3.049-4.277 5.806v4.384h6.293v7.659h-12z"/>
                            </svg>
                            <blockquote class="text-3xl md:text-4xl font-bold text-white leading-relaxed mb-6">
                                <?php echo esc_html($story_quote); ?>
                            </blockquote>
                            <?php if (!empty($story_quote_author)): ?>
                            <p class="text-xl text-brand-gold font-medium">
                                — <?php echo esc_html($story_quote_author); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<style>
/* Cinematic Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(60px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

@keyframes glow {
    0%, 100% {
        text-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
    }
    50% {
        text-shadow: 0 0 20px rgba(212, 175, 55, 0.8), 0 0 30px rgba(212, 175, 55, 0.5);
    }
}

@keyframes lineExpand {
    from {
        width: 0;
        opacity: 0;
    }
    to {
        width: 128px;
        opacity: 1;
    }
}

@keyframes orbFloat {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(30px, -30px) scale(1.1);
    }
    66% {
        transform: translate(-30px, 30px) scale(0.9);
    }
}

.cinematic-fade-in {
    opacity: 0;
    animation: fadeInUp 1s ease-out forwards;
}

.cinematic-slide-up {
    opacity: 0;
    animation: slideUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.cinematic-scale-in {
    opacity: 0;
    animation: scaleIn 0.8s ease-out forwards;
}

.cinematic-bounce {
    animation: float 3s ease-in-out infinite;
}

.cinematic-glow {
    animation: glow 3s ease-in-out infinite;
}

.cinematic-line {
    animation: lineExpand 1s ease-out forwards;
}

.cinematic-card {
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.cinematic-card:hover {
    transform: translateY(-5px);
}

.cinematic-orb {
    animation: orbFloat 20s ease-in-out infinite;
}

.cinematic-orb-1 {
    animation-delay: 0s;
}

.cinematic-orb-2 {
    animation-delay: 7s;
}

/* Lazy Loading Styles */
img[loading="lazy"] {
    opacity: 0;
    transition: opacity 0.3s;
}

img[loading="lazy"].loaded {
    opacity: 1;
}

/* Prose Customization */
.prose {
    color: #4a5568;
}

.prose p {
    margin-bottom: 1.5em;
}

.prose strong {
    color: #1a202c;
    font-weight: 700;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lazy Loading Enhancement
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(function(img) {
            imageObserver.observe(img);
        });
    } else {
        // Fallback for browsers without IntersectionObserver
        lazyImages.forEach(function(img) {
            img.classList.add('loaded');
        });
    }
    
    // Parallax effect for hero background
    const hero = document.querySelector('.cinematic-hero');
    const heroBg = document.querySelector('.cinematic-bg');
    
    if (hero && heroBg) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * 0.5;
            heroBg.style.transform = `translateY(${rate}px)`;
        });
    }
    
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.cinematic-card, .cinematic-fade-in, .cinematic-slide-up').forEach(el => {
        observer.observe(el);
    });
});
</script>

<?php get_footer(); ?>
