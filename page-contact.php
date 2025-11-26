<?php
/**
 * Template Name: Contact Page
 * The template for displaying the contact page
 *
 * @package AlOmran
 */

get_header();

$company_info = alomran_get_company_info();
?>

<div class="min-h-screen bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 animate-fade-in-up">
            <h1 class="text-4xl font-bold text-primary mb-4">تواصل معنا</h1>
            <p class="text-gray-600">فريقنا جاهز للرد على استفساراتكم وتقديم الدعم الفني</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Info Cards -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-8 rounded-xl shadow-sm flex items-start gap-4 animate-slide-in-right delay-100 hover:shadow-md transition">
                    <div class="bg-blue-50 p-3 rounded-lg text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-1">اتصل بنا</h3>
                        <p class="text-gray-500 text-sm mb-2">متاحين من 9 صباحاً - 5 مساءً</p>
                        <p class="font-bold text-primary dir-ltr text-right">
                            <a href="tel:<?php echo esc_attr(str_replace(' ', '', $company_info['phone'])); ?>">
                                <?php echo esc_html($company_info['phone']); ?>
                            </a>
                        </p>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm flex items-start gap-4 animate-slide-in-right delay-200 hover:shadow-md transition">
                    <div class="bg-yellow-50 p-3 rounded-lg text-secondary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-1">البريد الإلكتروني</h3>
                        <p class="text-gray-500 text-sm mb-2">للتعاقدات والمبيعات</p>
                        <p class="font-bold text-primary">
                            <a href="mailto:<?php echo esc_attr($company_info['email']); ?>">
                                <?php echo esc_html($company_info['email']); ?>
                            </a>
                        </p>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm flex items-start gap-4 animate-slide-in-right delay-300 hover:shadow-md transition">
                    <div class="bg-gray-100 p-3 rounded-lg text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-1">المقر الرئيسي</h3>
                        <p class="text-gray-600 text-sm leading-relaxed"><?php echo esc_html($company_info['address']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="lg:col-span-2 bg-white p-8 md:p-10 rounded-xl shadow-md animate-fade-in-up delay-300">
                <h2 class="text-2xl font-bold text-primary mb-6">أرسل رسالة</h2>
                
                <form id="contact-form" class="space-y-6">
                    <div id="form-message" class="hidden"></div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="animate-fade-in-up delay-400">
                            <label class="block text-sm font-bold text-gray-700 mb-2">الاسم بالكامل</label>
                            <input type="text" name="name" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-secondary focus:bg-white transition" required />
                        </div>
                        <div class="animate-fade-in-up delay-400">
                            <label class="block text-sm font-bold text-gray-700 mb-2">رقم الهاتف</label>
                            <input type="tel" name="phone" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-secondary focus:bg-white transition" required />
                        </div>
                    </div>
                    <div class="animate-fade-in-up delay-500">
                        <label class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني</label>
                        <input type="email" name="email" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-secondary focus:bg-white transition" required />
                    </div>
                    <div class="animate-fade-in-up delay-500">
                        <label class="block text-sm font-bold text-gray-700 mb-2">الرسالة</label>
                        <textarea name="message" rows="5" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-secondary focus:bg-white transition resize-none" required></textarea>
                    </div>
                    <button type="submit" class="bg-primary text-white px-8 py-3 rounded-lg font-bold hover:bg-secondary hover:text-primary transition-all flex items-center justify-center gap-2 w-full md:w-auto transform hover:-translate-y-1 animate-fade-in-up delay-500">
                        إرسال الآن
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Map Placeholder -->
        <div class="mt-12 rounded-xl overflow-hidden shadow-md h-80 bg-gray-200 relative group animate-scale-in delay-500">
            <img src="https://picsum.photos/id/122/1200/400" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-700" alt="Map Location" />
            <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                <div class="bg-white px-6 py-3 rounded-full shadow-lg font-bold text-primary flex items-center gap-2 hover:scale-110 transition">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    موقع المصنع
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

