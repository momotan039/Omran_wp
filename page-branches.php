<?php
/**
 * Template Name: فروعنا
 * Description: صفحة عرض جميع الفروع
 * 
 * Food Preset - All Branches Page Template
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
    $branches_title = alomran_get_option('food_branches_title', 'فروعنا');
    $branches_subtitle = alomran_get_option('food_branches_subtitle', 'Our Branches');
    $branches_description = alomran_get_option('food_branches_description', 'زورونا في أحد فروعنا المنتشرة في المنطقة.');
    $branches_query = alomran_food_get_branches(); // Get all branches
    ?>
    
    <!-- Hero Section -->
    <section class="relative h-[50vh] min-h-[450px] overflow-hidden bg-brand-black cinematic-hero">
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
                    <span class="text-xs uppercase tracking-[0.5em] text-brand-gold font-bold opacity-80 cinematic-glow"><?php echo esc_html($branches_subtitle); ?></span>
                </div>
                <h1 class="text-7xl md:text-8xl font-black text-white mb-8 leading-tight cinematic-slide-up" style="animation-delay: 0.4s;">
                    <?php echo esc_html($branches_title); ?>
                </h1>
                <?php if (!empty($branches_description)): ?>
                <p class="text-2xl text-gray-300 max-w-3xl mx-auto leading-relaxed cinematic-fade-in" style="animation-delay: 0.6s;">
                    <?php echo esc_html($branches_description); ?>
                </p>
                <?php endif; ?>
                <div class="mt-12 flex justify-center cinematic-scale-in" style="animation-delay: 0.8s;">
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

    <!-- Branches Section -->
    <section class="py-32 bg-gradient-to-b from-brand-cream via-white to-brand-cream relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-20 right-0 w-96 h-96 bg-brand-gold/8 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 left-0 w-96 h-96 bg-brand-gold/8 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-brand-gold/3 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 max-w-[1600px] mx-auto px-6 lg:px-12">
            <!-- Branches Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 branches-grid">
                <?php if ($branches_query->have_posts()): ?>
                    <?php $branch_index = 0; while ($branches_query->have_posts()): $branches_query->the_post(); ?>
                        <?php
                        $city = alomran_food_get_branch_city(get_the_ID());
                        $address = alomran_food_get_branch_address(get_the_ID());
                        $phone = alomran_food_get_branch_phone(get_the_ID());
                        $map_link = alomran_food_get_branch_map_link(get_the_ID());
                        ?>
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="group relative overflow-hidden cursor-pointer luxury-shadow hover:-translate-y-2 transition-all duration-500 branch-card cinematic-card" style="border-radius: 40px; animation-delay: <?php echo $branch_index * 0.1; ?>s;">
                            <!-- Image -->
                            <div class="aspect-[4/5] w-full overflow-hidden">
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110', 'loading' => 'lazy', 'decoding' => 'async')); ?>
                                <?php else: ?>
                                    <div class="w-full h-full bg-gradient-to-br from-brand-black to-brand-gray flex items-center justify-center">
                                        <svg class="w-24 h-24 text-brand-gold/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Overlay with content -->
                            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(10, 10, 10, 0.95), rgba(10, 10, 10, 0.5), transparent);"></div>
                            
                            <div class="absolute inset-0 flex flex-col justify-end p-8">
                                <!-- City Badge -->
                                <?php if ($city): ?>
                                    <div class="mb-4">
                                        <span class="inline-block px-4 py-2 bg-brand-gold text-brand-black text-sm font-black rounded-full">
                                            <?php echo esc_html($city); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Title -->
                                <h3 class="text-3xl font-black text-white mb-3 group-hover:text-brand-gold transition-colors">
                                    <?php the_title(); ?>
                                </h3>
                                
                                <!-- Address -->
                                <?php if ($address): ?>
                                    <div class="flex items-start gap-3 mb-4 text-gray-300">
                                        <svg class="w-5 h-5 text-brand-gold mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-sm leading-relaxed"><?php echo esc_html($address); ?></p>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Phone -->
                                <?php if ($phone): ?>
                                    <div class="flex items-center gap-3 mb-6 text-gray-300">
                                        <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="text-sm font-medium"><?php echo esc_html($phone); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- CTA Button -->
                                <div class="translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                    <div class="inline-flex items-center gap-3 text-brand-gold font-black text-lg">
                                        <span>استكشف الفرع</span>
                                        <svg class="w-6 h-6 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php $branch_index++; endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else: ?>
                    <div class="col-span-full text-center text-gray-500 py-20">
                        <svg class="w-24 h-24 mx-auto mb-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <p class="text-xl">لا توجد فروع متاحة حالياً.</p>
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
    opacity: 0;
    animation: fadeInUp 0.8s ease-out forwards;
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

.branches-grid .branch-card {
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.branches-grid .branch-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
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

    // Observe all branch cards
    document.querySelectorAll('.branch-card').forEach((el, index) => {
        el.style.animationDelay = (index * 0.1) + 's';
        observer.observe(el);
    });

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
});
</script>

<?php get_footer(); ?>

