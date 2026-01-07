<?php
/**
 * Template Name: تواصل معنا
 * Description: صفحة التواصل
 * 
 * Food Preset - Contact Page Template
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
    <!-- Hero Section -->
    <?php 
    $page_title = alomran_get_option('food_contact_page_title', 'تواصل معنا');
    $page_subtitle = alomran_get_option('food_contact_page_subtitle', 'فريقنا جاهز للرد على استفساراتكم وتقديم الدعم الفني');
    ?>
    <section class="relative h-[60vh] min-h-[500px] overflow-hidden bg-brand-black">
        <!-- Animated Background -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-gold/20 via-brand-gold/5 to-brand-black"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand-gold/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-brand-gold/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
        </div>
        
        <!-- Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-8 h-full flex items-center">
            <div class="text-center w-full animate-fade-in-up">
                <div class="inline-block mb-8">
                    <span class="text-xs uppercase tracking-[0.5em] text-brand-gold font-bold opacity-80"><?php echo esc_html(alomran_get_option('food_contact_section_label', 'تواصل معنا')); ?></span>
                </div>
                <h1 class="text-7xl md:text-8xl font-black text-white mb-8 leading-tight">
                    <?php echo esc_html($page_title); ?>
                </h1>
                <?php if (!empty($page_subtitle)): ?>
                <p class="text-2xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    <?php echo esc_html($page_subtitle); ?>
                </p>
                <?php endif; ?>
                <div class="mt-12 flex justify-center">
                    <div class="w-32 h-1 bg-brand-gold"></div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
            <svg class="w-6 h-6 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-32 bg-gradient-to-b from-brand-cream via-white to-brand-cream relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-20 right-0 w-96 h-96 bg-brand-gold/8 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 left-0 w-96 h-96 bg-brand-gold/8 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-brand-gold/3 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 max-w-[1800px] mx-auto px-6 lg:px-12">
            <!-- Section Header -->
            <div class="text-center mb-20">
                <div class="inline-block mb-6">
                    <span class="text-xs uppercase tracking-[0.5em] text-brand-gold font-bold opacity-80"><?php echo esc_html(alomran_get_option('food_contact_section_label', 'تواصل معنا')); ?></span>
                </div>
                <h2 class="text-5xl md:text-7xl font-black text-brand-black mb-6"><?php echo esc_html(alomran_get_option('food_contact_section_title', 'نحن هنا لمساعدتك')); ?></h2>
                <div class="w-32 h-1 bg-gradient-to-r from-transparent via-brand-gold to-transparent mx-auto"></div>
            </div>

            <!-- Two Column Layout with Decorative Divider -->
            <div class="relative">
                <!-- Decorative Vertical Divider (Desktop Only) -->
                <div class="hidden lg:block absolute top-0 left-1/2 transform -translate-x-1/2 w-px h-full bg-gradient-to-b from-transparent via-brand-gold/30 to-transparent" style="height: calc(100% + 80px);"></div>
                
                <!-- Decorative Ornament (Desktop Only) -->
                <div class="hidden lg:block absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-20">
                    <div class="w-20 h-20 bg-brand-cream rounded-full flex items-center justify-center border-4 border-brand-gold shadow-2xl">
                        <div class="w-12 h-12 bg-brand-gold rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 4v7a2 2 0 002 2h14a2 2 0 002-2v-7m-18 0L21 8" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-start">
                    <!-- Left Column: Contact Form -->
                    <div class="lg:pr-8">
                        <?php 
                        $form_title = alomran_get_option('food_contact_form_title', 'أرسل لنا رسالة');
                        ?>
                        <div class="bg-white luxury-shadow p-10 md:p-14 relative group h-full" style="border-radius: 60px; box-shadow: 0 25px 80px rgba(0, 0, 0, 0.12);">
                            <!-- Decorative Elements -->
                            <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-brand-gold/10 to-transparent rounded-bl-full"></div>
                            <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-brand-gold/5 to-transparent rounded-tr-full"></div>
                            
                            <!-- Animated Border -->
                            <div class="absolute inset-0 rounded-[60px] opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                                <div class="absolute inset-0 rounded-[60px] bg-gradient-to-r from-brand-gold/20 via-transparent to-brand-gold/20 animate-shimmer"></div>
                            </div>
                            
                            <div class="relative z-10">
                                <div class="mb-12">
                                    <div class="flex items-center gap-4 mb-6">
                                        <div class="w-16 h-1 bg-brand-gold"></div>
                                        <span class="text-xs uppercase tracking-[0.4em] text-brand-gold font-bold"><?php echo esc_html(alomran_get_option('food_contact_form_label', 'رسالة سريعة')); ?></span>
                                    </div>
                                    <h3 class="text-4xl md:text-5xl font-black mb-4 text-brand-black leading-tight"><?php echo esc_html($form_title); ?></h3>
                                    <p class="text-brand-gray text-lg opacity-75"><?php echo esc_html(alomran_get_option('food_contact_form_description', 'املأ النموذج وسنرد عليك في أقرب وقت ممكن')); ?></p>
                                </div>
                    <form id="food-contact-form" class="space-y-7">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                            <div class="group">
                                <label class="flex items-center gap-3 text-xs uppercase tracking-widest font-bold mb-4 text-brand-gray">
                                    <div class="w-8 h-8 rounded-lg bg-brand-gold/10 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    الاسم
                                </label>
                                <input type="text" name="name" required class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20 bg-white/50 text-right transition-all duration-300 hover:border-brand-gold/50" placeholder="اسمك الكريم" />
                            </div>
                            <div class="group">
                                <label class="flex items-center gap-3 text-xs uppercase tracking-widest font-bold mb-4 text-brand-gray">
                                    <div class="w-8 h-8 rounded-lg bg-brand-gold/10 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    رقم الجوال
                                </label>
                                <input type="tel" name="phone" required class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20 bg-white/50 text-right transition-all duration-300 hover:border-brand-gold/50" placeholder="05xxxxxxxx" />
                            </div>
                        </div>
                        <div class="group">
                            <label class="flex items-center gap-3 text-xs uppercase tracking-widest font-bold mb-4 text-brand-gray">
                                <div class="w-8 h-8 rounded-lg bg-brand-gold/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 4v7a2 2 0 002 2h14a2 2 0 002-2v-7m-18 0L21 8" />
                                    </svg>
                                </div>
                                البريد الإلكتروني
                            </label>
                            <input type="email" name="email" required class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20 bg-white/50 text-right transition-all duration-300 hover:border-brand-gold/50" placeholder="example@email.com" />
                        </div>
                        <div class="group">
                            <label class="flex items-center gap-3 text-xs uppercase tracking-widest font-bold mb-4 text-brand-gray">
                                <div class="w-8 h-8 rounded-lg bg-brand-gold/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                الرسالة
                            </label>
                            <textarea name="message" rows="6" required class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 outline-none focus:border-brand-gold focus:ring-2 focus:ring-brand-gold/20 bg-white/50 text-right resize-none transition-all duration-300 hover:border-brand-gold/50" placeholder="اكتب رسالتك هنا..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-brand-black via-brand-black to-brand-black text-white py-6 rounded-2xl font-black text-lg hover:from-brand-gold hover:via-brand-gold hover:to-brand-gold hover:text-brand-black transition-all duration-500 mt-8 shadow-2xl active:scale-95 transform hover:scale-[1.02] flex items-center justify-center gap-4 group relative overflow-hidden">
                            <!-- Button Shine Effect -->
                            <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></span>
                            <span class="relative z-10">إرسال الرسالة</span>
                            <svg class="w-6 h-6 rtl:rotate-180 relative z-10 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                        <div id="food-contact-message" class="hidden text-center py-4 rounded-xl"></div>
                    </form>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Contact Info -->
                    <div class="lg:pl-8">
                        <div class="space-y-6 lg:space-y-8 sticky top-32">
                    <!-- Phone Card -->
                    <?php 
                    $phone_title = alomran_get_option('food_contact_phone_title', 'اتصل بنا');
                    $phone_subtitle = alomran_get_option('food_contact_phone_subtitle', '');
                    $phone_numbers = alomran_get_option('food_contact_phone_numbers', array('+966 11 234 5678', '+966 50 123 4567'));
                    if (!empty($phone_numbers) && is_array($phone_numbers)) {
                        $phone_numbers = array_filter($phone_numbers); // Remove empty values
                    }
                    if (!empty($phone_numbers) && is_array($phone_numbers) && count($phone_numbers) > 0):
                    ?>
                    <div class="bg-gradient-to-br from-white to-brand-cream/30 luxury-shadow p-8 md:p-10 hover:shadow-2xl transition-all duration-500 group relative overflow-hidden border border-brand-gold/10" style="border-radius: 40px; box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);">
                        <!-- Hover Effect Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-brand-gold/0 via-brand-gold/5 to-brand-gold/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <!-- Decorative Corner -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-brand-gold/5 rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative z-10 flex items-start gap-5">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-brand-gold/20 to-brand-gold/10 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-lg">
                                <svg class="w-8 h-8 md:w-10 md:h-10 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div class="flex-1 pt-1">
                                <h3 class="text-2xl md:text-3xl font-black mb-2 text-brand-black group-hover:text-brand-gold transition-colors duration-300"><?php echo esc_html($phone_title); ?></h3>
                                <?php if (!empty($phone_subtitle)): ?>
                                <p class="text-sm text-brand-gray mb-5 opacity-75 font-medium leading-relaxed"><?php echo esc_html($phone_subtitle); ?></p>
                                <?php endif; ?>
                                <div class="space-y-2.5">
                                    <?php 
                                    foreach ($phone_numbers as $phone) {
                                        if (!empty($phone)) {
                                            echo '<p class="text-brand-gray text-lg md:text-xl"><a href="tel:' . esc_attr(str_replace(array(' ', '-', '(', ')'), '', $phone)) . '" class="hover:text-brand-gold transition-all duration-300 font-bold group-hover:translate-x-2 inline-block flex items-center gap-2"><span class="w-2 h-2 bg-brand-gold rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>' . esc_html($phone) . '</a></p>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Email Card -->
                    <?php 
                    $email_title = alomran_get_option('food_contact_email_title', 'البريد الإلكتروني');
                    $email_subtitle = alomran_get_option('food_contact_email_subtitle', '');
                    $email_addresses = alomran_get_option('food_contact_email_addresses', array('info@aljawhara.com', 'reservations@aljawhara.com'));
                    if (!empty($email_addresses) && is_array($email_addresses)) {
                        $email_addresses = array_filter($email_addresses); // Remove empty values
                    }
                    if (!empty($email_addresses) && is_array($email_addresses) && count($email_addresses) > 0):
                    ?>
                    <div class="bg-gradient-to-br from-white to-brand-cream/30 luxury-shadow p-8 md:p-10 hover:shadow-2xl transition-all duration-500 group relative overflow-hidden border border-brand-gold/10" style="border-radius: 40px; box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);">
                        <!-- Hover Effect Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-brand-gold/0 via-brand-gold/5 to-brand-gold/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <!-- Decorative Corner -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-brand-gold/5 rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative z-10 flex items-start gap-5">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-brand-gold/20 to-brand-gold/10 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-lg">
                                <svg class="w-8 h-8 md:w-10 md:h-10 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 4v7a2 2 0 002 2h14a2 2 0 002-2v-7m-18 0L21 8" />
                                </svg>
                            </div>
                            <div class="flex-1 pt-1">
                                <h3 class="text-2xl md:text-3xl font-black mb-2 text-brand-black group-hover:text-brand-gold transition-colors duration-300"><?php echo esc_html($email_title); ?></h3>
                                <?php if (!empty($email_subtitle)): ?>
                                <p class="text-sm text-brand-gray mb-5 opacity-75 font-medium leading-relaxed"><?php echo esc_html($email_subtitle); ?></p>
                                <?php endif; ?>
                                <div class="space-y-2.5">
                                    <?php 
                                    foreach ($email_addresses as $email) {
                                        if (!empty($email)) {
                                            echo '<p class="text-lg md:text-xl"><a href="mailto:' . esc_attr($email) . '" class="text-brand-gold hover:text-brand-black transition-all duration-300 font-bold group-hover:translate-x-2 inline-block flex items-center gap-2"><span class="w-2 h-2 bg-brand-gold rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>' . esc_html($email) . '</a></p>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Address Card -->
                    <?php 
                    $address_title = alomran_get_option('food_contact_address_title', 'المقر الرئيسي');
                    $address_text = alomran_get_option('food_contact_address_text', "شارع التحلية، حي السليمانية\nالرياض، المملكة العربية السعودية");
                    if (!empty($address_text)):
                    ?>
                    <div class="bg-gradient-to-br from-white to-brand-cream/30 luxury-shadow p-8 md:p-10 hover:shadow-2xl transition-all duration-500 group relative overflow-hidden border border-brand-gold/10" style="border-radius: 40px; box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);">
                        <!-- Hover Effect Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-brand-gold/0 via-brand-gold/5 to-brand-gold/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <!-- Decorative Corner -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-brand-gold/5 rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative z-10 flex items-start gap-5">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-brand-gold/20 to-brand-gold/10 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-lg">
                                <svg class="w-8 h-8 md:w-10 md:h-10 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 pt-1">
                                <h3 class="text-2xl md:text-3xl font-black mb-3 text-brand-black group-hover:text-brand-gold transition-colors duration-300"><?php echo esc_html($address_title); ?></h3>
                                <p class="text-brand-gray text-lg md:text-xl leading-relaxed font-medium">
                                    <?php echo nl2br(esc_html($address_text)); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Social Media -->
                    <?php
                    $contact_social_enable = alomran_get_option('food_contact_social_enable', true);
                    $social_enable = alomran_get_option('food_social_enable', true);
                    $social_title = alomran_get_option('food_contact_social_title', 'تابعنا');
                    $instagram = alomran_get_option('food_social_instagram', '');
                    $twitter = alomran_get_option('food_social_twitter', '');
                    $facebook = alomran_get_option('food_social_facebook', '');
                    $has_social = !empty($instagram) || !empty($twitter) || !empty($facebook);
                    ?>
                    <?php if ($contact_social_enable && $social_enable && $has_social): ?>
                    <div class="bg-gradient-to-br from-white to-brand-cream/30 luxury-shadow p-8 md:p-10 hover:shadow-2xl transition-all duration-500 group relative overflow-hidden border border-brand-gold/10" style="border-radius: 40px; box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);">
                        <!-- Hover Effect Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-brand-gold/0 via-brand-gold/5 to-brand-gold/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <!-- Decorative Corner -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-brand-gold/5 rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative z-10">
                            <h3 class="text-2xl md:text-3xl font-black mb-6 text-brand-black group-hover:text-brand-gold transition-colors duration-300"><?php echo esc_html($social_title); ?></h3>
                            <div class="flex gap-3 md:gap-4 flex-wrap">
                            <?php if ($instagram): ?>
                                <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" class="w-16 h-16 bg-brand-black text-white rounded-2xl flex items-center justify-center hover:bg-brand-gold hover:text-brand-black transition-all duration-500 transform hover:scale-110 hover:rotate-3 shadow-lg hover:shadow-2xl">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            <?php if ($twitter): ?>
                                <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener noreferrer" class="w-16 h-16 bg-brand-black text-white rounded-2xl flex items-center justify-center hover:bg-brand-gold hover:text-brand-black transition-all duration-500 transform hover:scale-110 hover:rotate-3 shadow-lg hover:shadow-2xl">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            <?php if ($facebook): ?>
                                <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener noreferrer" class="w-16 h-16 bg-brand-black text-white rounded-2xl flex items-center justify-center hover:bg-brand-gold hover:text-brand-black transition-all duration-500 transform hover:scale-110 hover:rotate-3 shadow-lg hover:shadow-2xl">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <?php 
    $map_enable = alomran_get_option('food_contact_map_enable', true);
    $map_url = alomran_get_option('food_contact_map_url', '');
    $map_text = alomran_get_option('food_contact_map_text', 'موقع المصنع');
    
    if ($map_enable && !empty($map_url)) :
        // Check if it's already an iframe
        if (strpos($map_url, '<iframe') !== false) {
            $map_html = $map_url;
        } else {
            // Convert to embed URL if needed
            require_once get_template_directory() . '/inc/helpers/helpers-url.php';
            $embed_url = alomran_convert_google_maps_url($map_url);
            if ($embed_url) {
                $map_html = '<iframe src="' . esc_url($embed_url) . '" width="100%" height="100%" style="border:0; display:block;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
            } else {
                $map_html = '';
            }
        }
        
        if (!empty($map_html)) :
    ?>
    <section class="py-32 bg-gradient-to-b from-brand-cream to-white relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-brand-gold/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-brand-gold/5 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
        
        <div class="relative z-10 max-w-[1600px] mx-auto px-8">
            <div class="text-center mb-16">
                <div class="inline-block mb-6">
                    <span class="text-xs uppercase tracking-[0.3em] text-brand-gold font-bold"><?php echo esc_html(alomran_get_option('food_contact_map_label', 'موقعنا')); ?></span>
                </div>
                <h2 class="text-6xl md:text-7xl font-black text-brand-black mb-6"><?php echo esc_html($map_text); ?></h2>
                <div class="w-24 h-1 bg-brand-gold mx-auto"></div>
            </div>
            
            <div class="bg-white luxury-shadow rounded-[50px] overflow-hidden relative" style="box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);">
                <div class="contact-map-container w-full" style="height: 600px; min-height: 600px;">
                    <?php 
                    // Clean and prepare iframe HTML
                    $map_html_clean = $map_html;
                    // Remove any existing width/height attributes that might interfere
                    $map_html_clean = preg_replace('/width\s*=\s*["\'][^"\']*["\']/i', '', $map_html_clean);
                    $map_html_clean = preg_replace('/height\s*=\s*["\'][^"\']*["\']/i', '', $map_html_clean);
                    // Ensure proper styling
                    if (strpos($map_html_clean, 'style=') === false) {
                        $map_html_clean = str_replace('<iframe', '<iframe style="width: 100% !important; height: 100% !important; border: 0; display: block; position: absolute; top: 0; left: 0;"', $map_html_clean);
                    } else {
                        $map_html_clean = preg_replace('/style\s*=\s*["\']([^"\']*)["\']/i', 'style="width: 100% !important; height: 100% !important; border: 0; display: block; position: absolute; top: 0; left: 0; $1"', $map_html_clean);
                    }
                    echo wp_kses($map_html_clean, array(
                        'iframe' => array(
                            'src' => array(),
                            'width' => array(),
                            'height' => array(),
                            'style' => array(),
                            'allowfullscreen' => array(),
                            'loading' => array(),
                            'referrerpolicy' => array(),
                            'class' => array(),
                            'title' => array(),
                            'frameborder' => array(),
                        ),
                    )); 
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php 
        endif;
    endif; 
    ?>
</div>

<script>
document.getElementById('food-contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const messageDiv = document.getElementById('food-contact-message');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    const formData = new FormData(form);
    formData.append('action', 'alomran_contact_form');
    formData.append('nonce', '<?php echo wp_create_nonce('alomran-nonce'); ?>');
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span>جاري الإرسال...</span>';
    messageDiv.classList.add('hidden');
    
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageDiv.className = 'bg-green-100 text-green-800 text-center py-4 rounded-lg';
            messageDiv.textContent = 'شكراً لك! تم إرسال رسالتك بنجاح وسنقوم بالرد عليك قريباً.';
            messageDiv.classList.remove('hidden');
            form.reset();
        } else {
            messageDiv.className = 'bg-red-100 text-red-800 text-center py-4 rounded-lg';
            messageDiv.textContent = data.data?.message || 'حدث خطأ. يرجى المحاولة مرة أخرى.';
            messageDiv.classList.remove('hidden');
        }
    })
    .catch(error => {
        messageDiv.className = 'bg-red-100 text-red-800 text-center py-4 rounded-lg';
        messageDiv.textContent = 'حدث خطأ. يرجى المحاولة مرة أخرى.';
        messageDiv.classList.remove('hidden');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span>إرسال الرسالة</span><svg class="w-6 h-6 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>';
    });
});
</script>

<style>
/* Contact Page Animations */
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

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
}

/* Luxury Shadow */
.luxury-shadow {
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.05);
}

/* Form Input Focus Effects */
#food-contact-form input:focus,
#food-contact-form textarea:focus {
    border-color: #d4af37;
    background: rgba(255, 255, 255, 0.9);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.15);
}

#food-contact-form input:hover,
#food-contact-form textarea:hover {
    border-color: rgba(212, 175, 55, 0.5);
    background: rgba(255, 255, 255, 0.7);
}

#food-contact-form input,
#food-contact-form textarea {
    font-size: 16px;
}

#food-contact-form input::placeholder,
#food-contact-form textarea::placeholder {
    color: rgba(0, 0, 0, 0.4);
    opacity: 0.6;
}

/* Smooth transitions for all interactive elements */
.group {
    transition: all 0.3s ease;
}

/* Card hover effects enhancement */
.bg-white.luxury-shadow:hover,
.bg-gradient-to-br.luxury-shadow:hover {
    transform: translateY(-8px);
}

/* Shimmer Animation for Form Border */
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

/* Sticky Column Enhancement */
.sticky {
    transition: all 0.3s ease;
}

/* Decorative Divider Animation */
@keyframes fadeInOut {
    0%, 100% {
        opacity: 0.3;
    }
    50% {
        opacity: 0.6;
    }
}

/* Responsive Adjustments */
@media (max-width: 1024px) {
    .lg\:pr-8,
    .lg\:pl-8 {
        padding: 0;
    }
}

/* Enhanced Form Input Styling */
#food-contact-form input,
#food-contact-form textarea {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

#food-contact-form input:focus,
#food-contact-form textarea:focus {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.15);
}

/* Map Container Fix */
.contact-map-container {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
    min-height: 600px;
}

.contact-map-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100% !important;
    height: 100% !important;
    min-width: 100%;
    min-height: 100%;
    border: 0;
    display: block;
    margin: 0;
    padding: 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .contact-map-container {
        min-height: 400px;
    }
}
</style>

<?php get_footer(); ?>

