<?php
/**
 * Food Preset - Front Page Template
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="w-full font-sans antialiased text-brand-black bg-brand-cream min-h-screen relative homepage-cinematic">
    <?php
    // Hero Section
    $hero_template = AlOmran_Preset_Loader::locate_template('section-hero', 'sections');
    if ($hero_template) {
        include $hero_template;
    }
    
    // Philosophical Intro Section
    $philosophy_enable = alomran_get_option('food_philosophy_enable', true);
    if ($philosophy_enable):
        $philosophy_image = alomran_get_option('food_philosophy_image', '');
        $philosophy_title = alomran_get_option('food_philosophy_title', 'نعيد صياغة مفهوم الضيافة');
        $philosophy_title_highlight = alomran_get_option('food_philosophy_title_highlight', 'مفهوم الضيافة');
        $philosophy_description = alomran_get_option('food_philosophy_description', 'في الجوهرة، لسنا مجرد مطعم؛ نحن صالون ثقافي يحتفي بأرقى معايير الطهي. نجمع بين أندر المكونات العالمية والوصفات المتوارثة لنقدم لك سيمفونية من المذاق الفريد.');
        $philosophy_quote = alomran_get_option('food_philosophy_quote', '"الفخامة هي التفاصيل التي لا تُنسى"');
        
        // Get philosophy image URL
        $philosophy_image_url = '';
        if ($philosophy_image) {
            if (is_array($philosophy_image) && isset($philosophy_image['url'])) {
                $philosophy_image_url = $philosophy_image['url'];
            } elseif (is_numeric($philosophy_image)) {
                $philosophy_image_url = wp_get_attachment_image_url($philosophy_image, 'large');
            } elseif (is_string($philosophy_image)) {
                $attachment = get_posts(array(
                    'post_type' => 'attachment',
                    'post_status' => 'any',
                    'meta_query' => array(
                        array(
                            'key' => '_demo_original_filename',
                            'value' => basename($philosophy_image),
                            'compare' => '='
                        )
                    ),
                    'posts_per_page' => 1,
                    'fields' => 'ids'
                ));
                if (!empty($attachment)) {
                    $philosophy_image_url = wp_get_attachment_image_url($attachment[0], 'large');
                } else {
                    $philosophy_image_url = $philosophy_image;
                }
            }
        }
        // Fallback to local file
        if (empty($philosophy_image_url)) {
            $local_philosophy = get_template_directory() . '/presets/food/demo/media/philosophy-image.jpg';
            if (file_exists($local_philosophy)) {
                $philosophy_image_url = get_template_directory_uri() . '/presets/food/demo/media/philosophy-image.jpg';
            } else {
                $philosophy_image_url = 'https://images.unsplash.com/photo-1590846406792-0adc7f938f1d?q=80&w=1000';
            }
        }
    ?>
    
    <section class="py-32 bg-brand-cream relative overflow-hidden homepage-philosophy">
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-gold/5 blur-[120px] rounded-full philosophy-glow" style="width: 384px; height: 384px; background-color: rgba(212, 175, 55, 0.05); filter: blur(120px); border-radius: 9999px;"></div>
        <div class="max-w-7xl mx-auto px-8 grid lg:grid-cols-2 gap-24 items-center">
            <div class="relative philosophy-image-wrapper">
                <div class="relative z-10 overflow-hidden luxury-shadow philosophy-image" style="border-radius: 40px;">
                    <img src="<?php echo esc_url($philosophy_image_url); ?>" class="w-full h-[600px] object-cover" alt="<?php echo esc_attr($philosophy_title); ?>" loading="lazy" decoding="async" />
                </div>
                <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-brand-black rounded-[40px] flex items-center justify-center p-10 hidden md:flex philosophy-quote-box" style="width: 256px; height: 256px; border-radius: 40px;">
                    <p class="text-brand-gold text-2xl font-black leading-tight text-center italic">
                        <?php echo esc_html($philosophy_quote); ?>
                    </p>
                </div>
            </div>
            <div class="text-right philosophy-content">
                <span class="text-brand-gray font-bold tracking-widest mb-6 block">فلسفتنا</span>
                <h2 class="text-5xl md:text-6xl font-black mb-10 leading-tight">
                    <?php 
                    $title_parts = explode($philosophy_title_highlight, $philosophy_title);
                    echo esc_html($title_parts[0]);
                    if (isset($title_parts[1])) {
                        echo '<br/><span class="text-brand-gold">' . esc_html($philosophy_title_highlight) . '</span>';
                        echo esc_html($title_parts[1]);
                    } else {
                        echo esc_html($philosophy_title);
                    }
                    ?>
                </h2>
                <p class="text-xl text-brand-gray leading-loose mb-12">
                    <?php echo esc_html($philosophy_description); ?>
                </p>
                <a href="<?php echo esc_url(alomran_format_url('/story')); ?>" class="group flex items-center gap-6 text-xl font-black transition-all hover:gap-10">
                    <span>اكتشف قصتنا</span>
                    <div class="w-16 h-16 rounded-full border border-brand-black flex items-center justify-center group-hover:bg-brand-black group-hover:text-white transition-all">←</div>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // Story Section
    $story_template = AlOmran_Preset_Loader::locate_template('section-story', 'sections');
    if ($story_template) {
        include $story_template;
    }
    
    // Experience Section
    $experience_template = AlOmran_Preset_Loader::locate_template('section-experience', 'sections');
    if ($experience_template) {
        include $experience_template;
    }
    
    // Signature Carousel Section
    $menu_enable = alomran_get_option('food_menu_enable', true);
    if ($menu_enable):
        $menu_title = alomran_get_option('food_menu_title', 'مختارات النخبة');
        $menu_subtitle = alomran_get_option('food_menu_subtitle', "Chef's Selection");
        $menu_random = alomran_get_option('food_menu_random_order', false);
        $menu_query = alomran_food_get_menu_items(array(
            'posts_per_page' => 2,
            'orderby' => $menu_random ? 'rand' : 'menu_order',
            'order' => $menu_random ? '' : 'ASC',
        ));
    ?>
    <section class="py-32 bg-brand-black text-white relative homepage-menu">
        <div class="max-w-7xl mx-auto px-8">
            <div class="flex justify-between items-end mb-20 homepage-menu-header">
                <div>
                    <h4 class="text-brand-gold font-bold tracking-widest uppercase mb-4"><?php echo esc_html($menu_subtitle); ?></h4>
                    <h2 class="text-5xl font-black"><?php echo esc_html($menu_title); ?></h2>
                </div>
                <a href="<?php echo esc_url(get_post_type_archive_link('menu_item')); ?>" class="text-brand-gold hover:text-white font-black text-lg underline decoration-brand-gold underline-offset-8 transition-all homepage-menu-link">
                    قائمة الطعام كاملة
                </a>
            </div>
            <div class="grid md:grid-cols-2 gap-12 homepage-menu-grid">
                <?php if ($menu_query->have_posts()): ?>
                    <?php $menu_index = 0; while ($menu_query->have_posts()): $menu_query->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="group relative overflow-hidden cursor-pointer h-[500px] homepage-menu-item" style="border-radius: 40px;" data-delay="<?php echo $menu_index * 200; ?>">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000', 'loading' => 'lazy', 'decoding' => 'async')); ?>
                            <?php endif; ?>
                            <div class="absolute inset-0" style="background: linear-gradient(to top, #0A0A0A, rgba(10, 10, 10, 0.2), transparent);"></div>
                            <div class="absolute bottom-12 right-12 left-12 text-right">
                                <h3 class="text-4xl font-black mb-4 group-hover:text-brand-gold transition-colors"><?php the_title(); ?></h3>
                                <p class="text-gray-400 text-lg leading-relaxed line-clamp-2"><?php echo esc_html(get_the_excerpt()); ?></p>
                            </div>
                        </a>
                    <?php $menu_index++; endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <?php
    // Branches Section
    $branches_template = AlOmran_Preset_Loader::locate_template('section-branches', 'sections');
    if ($branches_template) {
        include $branches_template;
    }
    ?>
</div>

<style>
/* Homepage Cinematic Animations */
.homepage-cinematic {
    position: relative;
}

/* Hero Section - handled in section-hero.php */
.homepage-hero {
    opacity: 0;
    animation: heroReveal 1.5s cubic-bezier(0.16, 1, 0.3, 1) 0.1s forwards;
}

@keyframes heroReveal {
    0% {
        opacity: 0;
        transform: scale(1.05);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

.homepage-hero .animate-fade-in-up {
    opacity: 0;
    transform: translateY(30px);
}

.homepage-hero.animated .animate-fade-in-up {
    animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

/* Philosophy Section */
.homepage-philosophy {
    opacity: 0;
    transform: translateY(60px);
    transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-philosophy.animated {
    opacity: 1;
    transform: translateY(0);
}

.philosophy-image-wrapper {
    opacity: 0;
    transform: translateX(-50px) scale(0.95);
    transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-philosophy.animated .philosophy-image-wrapper {
    opacity: 1;
    transform: translateX(0) scale(1);
    transition-delay: 0.2s;
}

.philosophy-image {
    transform: scale(1);
    transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.philosophy-image-wrapper:hover .philosophy-image {
    transform: scale(1.05);
}

.philosophy-quote-box {
    opacity: 0;
    transform: translateY(30px) rotate(-5deg);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-philosophy.animated .philosophy-quote-box {
    opacity: 1;
    transform: translateY(0) rotate(0deg);
    transition-delay: 0.5s;
}

.philosophy-content {
    opacity: 0;
    transform: translateX(50px);
    transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-philosophy.animated .philosophy-content {
    opacity: 1;
    transform: translateX(0);
    transition-delay: 0.3s;
}

.philosophy-glow {
    animation: glowPulse 4s ease-in-out infinite;
}

@keyframes glowPulse {
    0%, 100% {
        opacity: 0.3;
        transform: scale(1);
    }
    50% {
        opacity: 0.5;
        transform: scale(1.1);
    }
}

/* Story Section - handled in section-story.php but add wrapper */
.homepage-story {
    opacity: 0;
    transform: translateY(50px);
    transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-story.animated {
    opacity: 1;
    transform: translateY(0);
}

/* Story Section Internal Elements */
.story-content {
    opacity: 0;
    transform: translateX(50px);
    transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-story.animated .story-content {
    opacity: 1;
    transform: translateX(0);
    transition-delay: 0.2s;
}

.story-subtitle {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-story.animated .story-subtitle {
    opacity: 1;
    transform: translateY(0);
    transition-delay: 0.3s;
}

.story-title {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-story.animated .story-title {
    opacity: 1;
    transform: translateY(0);
    transition-delay: 0.4s;
}

.story-highlight {
    opacity: 0;
    transform: translateX(-20px);
    transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-story.animated .story-highlight {
    opacity: 1;
    transform: translateX(0);
    transition-delay: 0.6s;
}

.story-description-1,
.story-description-2 {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-story.animated .story-description-1 {
    opacity: 1;
    transform: translateY(0);
    transition-delay: 0.5s;
}

.homepage-story.animated .story-description-2 {
    opacity: 1;
    transform: translateY(0);
    transition-delay: 0.7s;
}

.story-image-wrapper {
    opacity: 0;
    transform: translateX(-50px) scale(0.95);
    transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-story.animated .story-image-wrapper {
    opacity: 1;
    transform: translateX(0) scale(1);
    transition-delay: 0.3s;
}

.story-image-wrapper:hover {
    transform: translateX(-10px) scale(1.02);
}

/* Experience Section - handled in section-experience.php */
.homepage-experience {
    opacity: 0;
    transform: translateY(50px);
    transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-experience.animated {
    opacity: 1;
    transform: translateY(0);
}

/* Menu Section */
.homepage-menu {
    opacity: 0;
    transform: translateY(60px);
    transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-menu.animated {
    opacity: 1;
    transform: translateY(0);
}

.homepage-menu-header {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-menu.animated .homepage-menu-header {
    opacity: 1;
    transform: translateY(0);
    transition-delay: 0.2s;
}

.homepage-menu-item {
    opacity: 0;
    transform: translateY(50px) scale(0.95);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-menu-item.animated {
    opacity: 1;
    transform: translateY(0) scale(1);
}

.homepage-menu-item:hover {
    transform: translateY(-10px) scale(1.02);
}

/* Branches Section */
.homepage-branches {
    opacity: 0;
    transform: translateY(50px);
    transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-branches.animated {
    opacity: 1;
    transform: translateY(0);
}

.branch-card {
    opacity: 0;
    transform: translateY(40px) scale(0.95);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.branch-card.animated {
    opacity: 1;
    transform: translateY(0) scale(1);
}

.branch-card:hover {
    transform: translateY(-8px) scale(1.02);
}

/* Branches Header Elements */
.branches-header {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-branches.animated .branches-header {
    opacity: 1;
    transform: translateY(0);
    transition-delay: 0.2s;
}

.branches-subtitle {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-branches.animated .branches-subtitle {
    opacity: 1;
    transform: translateY(0);
    transition-delay: 0.3s;
}

.branches-title {
    opacity: 0;
    transform: translateY(30px) scale(0.95);
    transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-branches.animated .branches-title {
    opacity: 1;
    transform: translateY(0) scale(1);
    transition-delay: 0.4s;
}

.branches-description {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-branches.animated .branches-description {
    opacity: 1;
    transform: translateY(0);
    transition-delay: 0.5s;
}

.branches-grid {
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.homepage-branches.animated .branches-grid {
    opacity: 1;
    transform: translateY(0);
    transition-delay: 0.6s;
}

/* Enhanced Smooth Scroll */
html {
    scroll-behavior: smooth;
    scroll-padding-top: 100px;
}

/* Momentum scrolling for better feel */
@media (prefers-reduced-motion: no-preference) {
    * {
        scroll-behavior: inherit;
    }
    
    body {
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
    }
}

/* Stagger Animation Delays */
[data-delay="0"] { transition-delay: 0s; }
[data-delay="100"] { transition-delay: 0.1s; }
[data-delay="200"] { transition-delay: 0.2s; }
[data-delay="300"] { transition-delay: 0.3s; }
[data-delay="400"] { transition-delay: 0.4s; }
[data-delay="500"] { transition-delay: 0.5s; }
</style>

<script>
(function() {
    'use strict';
    
    // Enhanced Smooth Scroll
    function initSmoothScroll() {
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#' || href === '#!') return;
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const headerOffset = 100;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Smooth scroll with momentum effect
        let isScrolling = false;
        let scrollTimeout;
        
        window.addEventListener('scroll', function() {
            if (!isScrolling) {
                window.requestAnimationFrame(function() {
                    isScrolling = false;
                });
                isScrolling = true;
            }
            
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(function() {
                // Scroll ended
            }, 150);
        }, { passive: true });
    }
    
    // Scroll Animations for Homepage
    function initHomepageAnimations() {
        const observerOptions = {
            threshold: 0.12,
            rootMargin: '0px 0px -60px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const delay = element.dataset.delay || 0;
                    
                    setTimeout(function() {
                        element.classList.add('animated');
                        
                        // Animate child elements with stagger
                        const children = element.querySelectorAll('.homepage-menu-item, .homepage-menu-header, .philosophy-image-wrapper, .philosophy-content, .philosophy-quote-box, .story-content, .story-image-wrapper, .branches-header, .branches-grid');
                        children.forEach(function(child, index) {
                            setTimeout(function() {
                                child.classList.add('animated');
                            }, index * 80);
                        });
                    }, delay);
                    
                    observer.unobserve(element);
                }
            });
        }, observerOptions);
        
        // Observe all sections
        document.querySelectorAll('.homepage-philosophy, .homepage-menu, .homepage-branches, .homepage-story, .homepage-experience').forEach(function(section) {
            observer.observe(section);
        });
        
        // Observe menu items and branch cards individually for stagger effect
        const itemObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const item = entry.target;
                    const delay = parseInt(item.dataset.delay || 0);
                    setTimeout(function() {
                        item.classList.add('animated');
                    }, delay);
                    itemObserver.unobserve(item);
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.homepage-menu-item, .branch-card').forEach(function(item) {
            itemObserver.observe(item);
        });
        
        // Observe story section elements
        const storyObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const parent = entry.target.closest('.homepage-story');
                    if (parent && parent.classList.contains('animated')) {
                        const delay = parseInt(entry.target.dataset.delay || 0);
                        setTimeout(function() {
                            entry.target.classList.add('animated');
                        }, delay);
                        storyObserver.unobserve(entry.target);
                    }
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.story-subtitle, .story-title, .story-highlight, .story-description-1, .story-description-2, .story-image-wrapper').forEach(function(el) {
            storyObserver.observe(el);
        });
        
        // Observe branches header elements
        const branchesHeaderObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const parent = entry.target.closest('.homepage-branches');
                    if (parent && parent.classList.contains('animated')) {
                        setTimeout(function() {
                            entry.target.classList.add('animated');
                        }, parseInt(entry.target.dataset.delay || 0));
                        branchesHeaderObserver.unobserve(entry.target);
                    }
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.branches-subtitle, .branches-title, .branches-description').forEach(function(el) {
            branchesHeaderObserver.observe(el);
        });
    }
    
    // Initialize on load
    function init() {
        initSmoothScroll();
        initHomepageAnimations();
        
        // Animate hero immediately if exists
        setTimeout(function() {
            const hero = document.querySelector('.homepage-hero');
            if (hero) {
                hero.classList.add('animated');
                
                // Animate hero children
                setTimeout(function() {
                    hero.querySelectorAll('.animate-fade-in-up').forEach(function(el, index) {
                        setTimeout(function() {
                            el.classList.add('animated');
                        }, index * 200);
                    });
                }, 300);
            }
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

