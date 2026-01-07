<?php
/**
 * Template Name: احجز طاولتك
 * Description: صفحة الحجوزات
 * 
 * Food Preset - Reservations Page Template
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
    $reservations_title = alomran_get_option('food_reservations_title', 'احجز طاولتك');
    $reservations_description = alomran_get_option('food_reservations_description', 'اختر الوقت والفرع المناسب لك، وسيقوم فريق "الجوهرة" بتجهيز كل شيء لتكون أمسيتك مثالية.');
    $branches = alomran_food_get_branches();
    ?>
    
    <!-- Hero Section -->
    <section class="relative h-[60vh] min-h-[550px] overflow-hidden bg-brand-black cinematic-hero">
        <!-- Animated Background with Parallax -->
        <div class="absolute inset-0 cinematic-bg">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-gold/20 via-brand-gold/5 to-brand-black"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand-gold/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 cinematic-orb cinematic-orb-1"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-brand-gold/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2 cinematic-orb cinematic-orb-2"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-gold/5 rounded-full blur-3xl cinematic-orb cinematic-orb-3"></div>
        </div>
        
        <!-- Floating Particles -->
        <div class="absolute inset-0 cinematic-particles"></div>
        
        <!-- Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-8 h-full flex items-center">
            <div class="text-center w-full">
                <div class="inline-block mb-8 cinematic-fade-in" style="animation-delay: 0.2s;">
                    <span class="text-xs uppercase tracking-[0.5em] text-brand-gold font-bold opacity-80 cinematic-glow"><?php echo esc_html(alomran_get_option('food_reservations_hero_label', 'احجز طاولتك')); ?></span>
                </div>
                <h1 class="text-7xl md:text-8xl font-black text-white mb-8 leading-tight cinematic-slide-up" style="animation-delay: 0.4s;">
                    <?php echo esc_html($reservations_title); ?>
                </h1>
                <?php if (!empty($reservations_description)): ?>
                <p class="text-2xl text-gray-300 max-w-3xl mx-auto leading-relaxed cinematic-fade-in" style="animation-delay: 0.6s;">
                    <?php echo esc_html($reservations_description); ?>
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

    <!-- Reservation Section -->
    <section class="py-32 bg-gradient-to-b from-brand-cream via-white to-brand-cream relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-20 right-0 w-96 h-96 bg-brand-gold/8 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 left-0 w-96 h-96 bg-brand-gold/8 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-brand-gold/3 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 max-w-[1800px] mx-auto px-6 lg:px-12">
            <!-- Two Column Layout with Decorative Divider -->
            <div class="relative">
                <!-- Decorative Vertical Divider (Desktop Only) -->
                <div class="hidden lg:block absolute top-0 left-1/2 transform -translate-x-1/2 w-px h-full bg-gradient-to-b from-transparent via-brand-gold/30 to-transparent" style="height: calc(100% + 80px);"></div>
                
                <!-- Decorative Ornament (Desktop Only) -->
                <div class="hidden lg:block absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-20 cinematic-ornament">
                    <div class="w-20 h-20 bg-brand-cream rounded-full flex items-center justify-center border-4 border-brand-gold shadow-2xl cinematic-ornament-inner">
                        <div class="w-12 h-12 bg-brand-gold rounded-full flex items-center justify-center cinematic-ornament-icon">
                            <svg class="w-6 h-6 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-start">
                    <!-- Left Column: Information -->
                    <div class="lg:pr-8 cinematic-slide-right">
                        <div class="bg-gradient-to-br from-brand-black to-brand-black/95 luxury-shadow p-12 md:p-16 relative group h-full cinematic-card" style="border-radius: 60px; box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);">
                            <!-- Decorative Elements -->
                            <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-brand-gold/20 to-transparent rounded-bl-full"></div>
                            <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-brand-gold/10 to-transparent rounded-tr-full"></div>
                            
                            <!-- Animated Border -->
                            <div class="absolute inset-0 rounded-[60px] opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                                <div class="absolute inset-0 rounded-[60px] bg-gradient-to-r from-brand-gold/20 via-transparent to-brand-gold/20 animate-shimmer"></div>
                            </div>
                            
                            <div class="relative z-10 text-right">
                                <div class="mb-12">
                                    <div class="flex items-center justify-end gap-4 mb-6">
                                        <span class="text-xs uppercase tracking-[0.4em] text-brand-gold font-bold"><?php echo esc_html(alomran_get_option('food_reservations_info_label', 'معلومات الحجز')); ?></span>
                                        <div class="w-16 h-1 bg-brand-gold"></div>
                                    </div>
                                    <h2 class="text-5xl md:text-6xl font-black mb-6 text-brand-gold leading-tight"><?php echo esc_html($reservations_title); ?></h2>
                                    <p class="text-gray-300 text-xl leading-relaxed mb-10 opacity-90">
                                        <?php echo esc_html($reservations_description); ?>
                                    </p>
                                </div>
                                
                                <!-- Features List -->
                                <div class="space-y-6">
                                    <div class="flex items-start gap-4 group/item cinematic-feature-item" style="animation-delay: 0.1s;">
                                        <div class="w-12 h-12 bg-brand-gold/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover/item:bg-brand-gold/30 transition-colors duration-300">
                                            <svg class="w-6 h-6 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 pt-2">
                                            <p class="text-white text-lg font-bold"><?php echo esc_html(alomran_get_option('food_reservations_feature_1_title', 'الحجز متاح للعائلات والأفراد')); ?></p>
                                            <p class="text-gray-400 text-sm mt-1"><?php echo esc_html(alomran_get_option('food_reservations_feature_1_description', 'نوفر أجواء مناسبة لجميع الأذواق')); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start gap-4 group/item cinematic-feature-item" style="animation-delay: 0.2s;">
                                        <div class="w-12 h-12 bg-brand-gold/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover/item:bg-brand-gold/30 transition-colors duration-300">
                                            <svg class="w-6 h-6 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 pt-2">
                                            <p class="text-white text-lg font-bold"><?php echo esc_html(alomran_get_option('food_reservations_feature_2_title', 'ركن خاص للمناسبات')); ?></p>
                                            <p class="text-gray-400 text-sm mt-1"><?php echo esc_html(alomran_get_option('food_reservations_feature_2_description', 'مكان مخصص للاحتفالات الخاصة')); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start gap-4 group/item cinematic-feature-item" style="animation-delay: 0.3s;">
                                        <div class="w-12 h-12 bg-brand-gold/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover/item:bg-brand-gold/30 transition-colors duration-300">
                                            <svg class="w-6 h-6 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 pt-2">
                                            <p class="text-white text-lg font-bold"><?php echo esc_html(alomran_get_option('food_reservations_feature_3_title', 'خدمة عملاء على مدار الساعة')); ?></p>
                                            <p class="text-gray-400 text-sm mt-1"><?php echo esc_html(alomran_get_option('food_reservations_feature_3_description', 'فريقنا جاهز لمساعدتك في أي وقت')); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Reservation Form -->
                    <div class="lg:pl-8 cinematic-slide-left">
                        <div class="bg-white luxury-shadow p-10 md:p-14 relative group h-full cinematic-card" style="border-radius: 60px; box-shadow: 0 25px 80px rgba(0, 0, 0, 0.12);">
                            <!-- Decorative Elements -->
                            <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-brand-gold/10 to-transparent rounded-bl-full"></div>
                            <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-brand-gold/5 to-transparent rounded-tr-full"></div>
                            
                            <!-- Animated Border -->
                            <div class="absolute inset-0 rounded-[60px] opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                                <div class="absolute inset-0 rounded-[60px] bg-gradient-to-r from-brand-gold/20 via-transparent to-brand-gold/20 animate-shimmer"></div>
                            </div>
                            
                            <div class="relative z-10">
                                <div class="mb-10">
                                    <div class="flex items-center gap-4 mb-6">
                                        <div class="w-16 h-1 bg-brand-gold"></div>
                                        <span class="text-xs uppercase tracking-[0.4em] text-brand-gold font-bold"><?php echo esc_html(alomran_get_option('food_reservations_form_label', 'نموذج الحجز')); ?></span>
                                    </div>
                                    <h3 class="text-4xl md:text-5xl font-black mb-4 text-brand-black leading-tight"><?php echo esc_html(alomran_get_option('food_reservations_form_title', 'املأ البيانات')); ?></h3>
                                    <p class="text-brand-gray text-lg opacity-75"><?php echo esc_html(alomran_get_option('food_reservations_form_description', 'سنقوم بالتواصل معك لتأكيد الحجز')); ?></p>
                                </div>
                                
                                <form id="food-reservation-form" class="space-y-7">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                                        <div class="group">
                                            <label class="flex items-center gap-3 text-xs uppercase tracking-widest font-bold mb-4 text-brand-gray">
                                                <div class="w-8 h-8 rounded-lg bg-brand-gold/10 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                التاريخ
                                            </label>
                                            <input type="date" name="date" required class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20 bg-white/50 text-right transition-all duration-300 hover:border-brand-gold/50" min="<?php echo date('Y-m-d'); ?>" />
                                        </div>
                                        <div class="group">
                                            <label class="flex items-center gap-3 text-xs uppercase tracking-widest font-bold mb-4 text-brand-gray">
                                                <div class="w-8 h-8 rounded-lg bg-brand-gold/10 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                الوقت
                                            </label>
                                            <input type="time" name="time" required class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20 bg-white/50 text-right transition-all duration-300 hover:border-brand-gold/50" />
                                        </div>
                                    </div>
                                    
                                    <div class="group">
                                        <label class="flex items-center gap-3 text-xs uppercase tracking-widest font-bold mb-4 text-brand-gray">
                                            <div class="w-8 h-8 rounded-lg bg-brand-gold/10 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            الفرع
                                        </label>
                                        <select name="branch_id" required class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20 bg-white/50 text-right appearance-none transition-all duration-300 hover:border-brand-gold/50 cursor-pointer">
                                            <option value="">اختر الفرع</option>
                                            <?php if ($branches->have_posts()): ?>
                                                <?php while ($branches->have_posts()): $branches->the_post(); ?>
                                                    <option value="<?php the_ID(); ?>"><?php the_title(); ?></option>
                                                <?php endwhile; ?>
                                                <?php wp_reset_postdata(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="group">
                                        <label class="flex items-center gap-3 text-xs uppercase tracking-widest font-bold mb-4 text-brand-gray">
                                            <div class="w-8 h-8 rounded-lg bg-brand-gold/10 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            عدد الضيوف
                                        </label>
                                        <input type="number" name="guests" min="1" max="<?php echo alomran_get_option('food_reservations_max_guests', 20); ?>" placeholder="مثلاً: 4" required class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20 bg-white/50 text-right transition-all duration-300 hover:border-brand-gold/50" />
                                    </div>
                                    
                                    <div class="group">
                                        <label class="flex items-center gap-3 text-xs uppercase tracking-widest font-bold mb-4 text-brand-gray">
                                            <div class="w-8 h-8 rounded-lg bg-brand-gold/10 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            الاسم
                                        </label>
                                        <input type="text" name="name" placeholder="اسمك الكريم" required class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20 bg-white/50 text-right transition-all duration-300 hover:border-brand-gold/50" />
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                                        <div class="group">
                                            <label class="flex items-center gap-3 text-xs uppercase tracking-widest font-bold mb-4 text-brand-gray">
                                                <div class="w-8 h-8 rounded-lg bg-brand-gold/10 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                    </svg>
                                                </div>
                                                رقم الجوال
                                            </label>
                                            <input type="tel" name="phone" placeholder="05xxxxxxxx" required class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20 bg-white/50 text-right transition-all duration-300 hover:border-brand-gold/50" />
                                        </div>
                                        <div class="group">
                                            <label class="flex items-center gap-3 text-xs uppercase tracking-widest font-bold mb-4 text-brand-gray">
                                                <div class="w-8 h-8 rounded-lg bg-brand-gold/10 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                البريد الإلكتروني
                                            </label>
                                            <input type="email" name="email" placeholder="example@email.com" class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20 bg-white/50 text-right transition-all duration-300 hover:border-brand-gold/50" />
                                        </div>
                                    </div>
                                    
                                    <div class="group">
                                        <label class="flex items-center gap-3 text-xs uppercase tracking-widest font-bold mb-4 text-brand-gray">
                                            <div class="w-8 h-8 rounded-lg bg-brand-gold/10 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </div>
                                            ملاحظات (اختياري)
                                        </label>
                                        <textarea name="notes" rows="4" class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20 bg-white/50 text-right resize-none transition-all duration-300 hover:border-brand-gold/50" placeholder="أي ملاحظات إضافية..."></textarea>
                                    </div>
                                    
                                    <button type="submit" class="w-full bg-gradient-to-r from-brand-black via-brand-black to-brand-black text-white py-6 rounded-2xl font-black text-lg hover:from-brand-gold hover:via-brand-gold hover:to-brand-gold hover:text-brand-black transition-all duration-500 mt-8 shadow-2xl active:scale-95 transform hover:scale-[1.02] flex items-center justify-center gap-4 group relative overflow-hidden">
                                        <!-- Button Shine Effect -->
                                        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></span>
                                        <span class="relative z-10">تأكيد الحجز</span>
                                        <svg class="w-6 h-6 rtl:rotate-180 relative z-10 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </button>
                                    <div id="food-reservation-message" class="hidden text-center py-4 rounded-xl transition-all duration-300"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// Cinematic Scroll Animations
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all cinematic elements
    document.querySelectorAll('.cinematic-card, .cinematic-feature-item').forEach(el => {
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

    // Floating particles animation
    const particlesContainer = document.querySelector('.cinematic-particles');
    if (particlesContainer) {
        for (let i = 0; i < 5; i++) {
            const particle = document.createElement('div');
            particle.style.cssText = `
                position: absolute;
                width: ${Math.random() * 4 + 2}px;
                height: ${Math.random() * 4 + 2}px;
                background: rgba(212, 175, 55, ${Math.random() * 0.5 + 0.3});
                border-radius: 50%;
                left: ${Math.random() * 100}%;
                animation: particleFloat ${Math.random() * 10 + 10}s linear infinite;
                animation-delay: ${Math.random() * 5}s;
            `;
            particlesContainer.appendChild(particle);
        }
    }
});

document.getElementById('food-reservation-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const messageDiv = document.getElementById('food-reservation-message');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    const formData = new FormData(form);
    formData.append('action', 'alomran_food_create_reservation');
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="relative z-10">جاري الإرسال...</span><svg class="w-6 h-6 rtl:rotate-180 relative z-10 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>';
    messageDiv.classList.add('hidden');
    
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageDiv.className = 'bg-green-100 text-green-800 text-center py-4 rounded-xl font-medium';
            messageDiv.textContent = 'شكراً لك! تم استلام طلب الحجز وسيتم التأكيد قريباً.';
            messageDiv.classList.remove('hidden');
            form.reset();
        } else {
            messageDiv.className = 'bg-red-100 text-red-800 text-center py-4 rounded-xl font-medium';
            messageDiv.textContent = data.data?.message || 'حدث خطأ. يرجى المحاولة مرة أخرى.';
            messageDiv.classList.remove('hidden');
        }
    })
    .catch(error => {
        messageDiv.className = 'bg-red-100 text-red-800 text-center py-4 rounded-xl font-medium';
        messageDiv.textContent = 'حدث خطأ. يرجى المحاولة مرة أخرى.';
        messageDiv.classList.remove('hidden');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span class="relative z-10">تأكيد الحجز</span><svg class="w-6 h-6 rtl:rotate-180 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>';
    });
});
</script>

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

@keyframes slideRight {
    from {
        opacity: 0;
        transform: translateX(-60px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideLeft {
    from {
        opacity: 0;
        transform: translateX(60px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
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

@keyframes particleFloat {
    0% {
        transform: translateY(100vh) rotate(0deg);
        opacity: 0;
    }
    10% {
        opacity: 1;
    }
    90% {
        opacity: 1;
    }
    100% {
        transform: translateY(-100vh) rotate(360deg);
        opacity: 0;
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

/* Cinematic Classes */
.cinematic-fade-in {
    opacity: 0;
    animation: fadeInUp 1s ease-out forwards;
}

.cinematic-slide-up {
    opacity: 0;
    animation: slideUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.cinematic-slide-right {
    opacity: 0;
    animation: slideRight 1s ease-out forwards;
}

.cinematic-slide-left {
    opacity: 0;
    animation: slideLeft 1s ease-out forwards;
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
    transform: translateY(-10px) scale(1.02);
}

.cinematic-feature-item {
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

.cinematic-orb-3 {
    animation-delay: 14s;
}

/* Parallax Effect */
.cinematic-hero {
    position: relative;
    overflow: hidden;
}

.cinematic-bg {
    will-change: transform;
}

/* Floating Particles */
.cinematic-particles::before,
.cinematic-particles::after {
    content: '';
    position: absolute;
    width: 4px;
    height: 4px;
    background: rgba(212, 175, 55, 0.6);
    border-radius: 50%;
    animation: particleFloat 15s linear infinite;
}

.cinematic-particles::before {
    left: 20%;
    animation-delay: 0s;
}

.cinematic-particles::after {
    left: 80%;
    animation-delay: 5s;
}

/* Smooth Scroll Behavior */
html {
    scroll-behavior: smooth;
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
}

/* Luxury Shadow */
.luxury-shadow {
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.05);
}

/* Shimmer Animation */
@keyframes shimmer {
    0% {
        background-position: -200% 0;
    }
    100% {
        background-position: 200% 0;
    }
}

.animate-shimmer {
    background-size: 200% 100%;
    animation: shimmer 3s ease-in-out infinite;
}

/* Form Input Focus Effects */
#food-reservation-form input:focus,
#food-reservation-form textarea:focus,
#food-reservation-form select:focus {
    border-color: #d4af37;
    background: rgba(255, 255, 255, 0.9);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.15);
}

#food-reservation-form input:hover,
#food-reservation-form textarea:hover,
#food-reservation-form select:hover {
    border-color: rgba(212, 175, 55, 0.5);
    background: rgba(255, 255, 255, 0.7);
}

#food-reservation-form input,
#food-reservation-form textarea,
#food-reservation-form select {
    font-size: 16px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

#food-reservation-form input::placeholder,
#food-reservation-form textarea::placeholder {
    color: rgba(0, 0, 0, 0.4);
    opacity: 0.6;
}

/* Card hover effects */
.bg-white.luxury-shadow:hover,
.bg-gradient-to-br.luxury-shadow:hover {
    transform: translateY(-8px);
}

/* Enhanced Form Animations */
#food-reservation-form .group {
    opacity: 0;
    animation: fadeInUp 0.6s ease-out forwards;
}

#food-reservation-form .group:nth-child(1) { animation-delay: 0.1s; }
#food-reservation-form .group:nth-child(2) { animation-delay: 0.2s; }
#food-reservation-form .group:nth-child(3) { animation-delay: 0.3s; }
#food-reservation-form .group:nth-child(4) { animation-delay: 0.4s; }
#food-reservation-form .group:nth-child(5) { animation-delay: 0.5s; }
#food-reservation-form .group:nth-child(6) { animation-delay: 0.6s; }
#food-reservation-form .group:nth-child(7) { animation-delay: 0.7s; }
#food-reservation-form .group:nth-child(8) { animation-delay: 0.8s; }

/* Input Focus Cinematic Effect */
#food-reservation-form input:focus,
#food-reservation-form textarea:focus,
#food-reservation-form select:focus {
    box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1), 0 4px 20px rgba(212, 175, 55, 0.2);
    transform: translateY(-2px) scale(1.01);
}

/* Button Cinematic Effect */
#food-reservation-form button[type="submit"] {
    position: relative;
    overflow: hidden;
}

#food-reservation-form button[type="submit"]::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

#food-reservation-form button[type="submit"]:hover::before {
    width: 300px;
    height: 300px;
}

/* Decorative Ornament Animation */
.cinematic-ornament {
    animation: float 6s ease-in-out infinite;
}

.cinematic-ornament-inner {
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}

.cinematic-ornament:hover .cinematic-ornament-inner {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 20px 60px rgba(212, 175, 55, 0.4);
}

.cinematic-ornament-icon {
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}

.cinematic-ornament:hover .cinematic-ornament-icon {
    transform: rotate(360deg);
}

/* Feature Items Hover Enhancement */
.cinematic-feature-item:hover {
    transform: translateX(-10px);
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.cinematic-feature-item:hover .w-12 {
    transform: scale(1.2) rotate(10deg);
    box-shadow: 0 10px 30px rgba(212, 175, 55, 0.4);
}

/* Smooth Page Transitions */
@keyframes pageFadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.font-sans.antialiased {
    animation: pageFadeIn 0.8s ease-out;
}

/* Enhanced Button Ripple Effect */
#food-reservation-form button[type="submit"] {
    position: relative;
    overflow: hidden;
}

#food-reservation-form button[type="submit"]:active::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    transform: translate(-50%, -50%);
    animation: ripple 0.6s ease-out;
}

@keyframes ripple {
    to {
        width: 300px;
        height: 300px;
        opacity: 0;
    }
}

/* Loading State Animation */
#food-reservation-form button[type="submit"]:disabled {
    position: relative;
}

#food-reservation-form button[type="submit"]:disabled::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    animation: loading 1.5s infinite;
}

@keyframes loading {
    to {
        left: 100%;
    }
}

/* Responsive Adjustments */
@media (max-width: 1024px) {
    .lg\:pr-8,
    .lg\:pl-8 {
        padding: 0;
    }
}
</style>

<?php get_footer(); ?>

