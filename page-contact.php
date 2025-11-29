<?php
/**
 * Template Name: Contact Page
 * The template for displaying the contact page
 *
 * @package AlOmran
 */

get_header();

$company_info = alomran_get_company_info();
$contact_data = alomran_get_section_data('contact_page');
?>

<div class="min-h-screen bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 animate-fade-in-up">
            <h1 class="text-4xl font-bold text-primary mb-4"><?php echo esc_html($contact_data['title'] ?? 'تواصل معنا'); ?></h1>
            <p class="text-gray-600"><?php echo esc_html($contact_data['subtitle'] ?? 'فريقنا جاهز للرد على استفساراتكم وتقديم الدعم الفني'); ?></p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Info Cards -->
            <div class="lg:col-span-1 space-y-6">
                <?php
                // Phone Card
                echo alomran_render_contact_card(array(
                    'icon_bg'    => 'bg-blue-50',
                    'icon_color' => 'text-primary',
                    'icon_svg'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>',
                    'title'      => $contact_data['phone_title'] ?? 'اتصل بنا',
                    'subtitle'   => $contact_data['phone_subtitle'] ?? 'متاحين من 9 صباحاً - 5 مساءً',
                    'content'    => $company_info['phone'],
                    'link_url'   => $company_info['phone'],
                    'link_type'  => 'tel',
                    'delay'      => 'delay-100',
                ));
                
                // Email Card
                echo alomran_render_contact_card(array(
                    'icon_bg'    => 'bg-yellow-50',
                    'icon_color' => 'text-secondary',
                    'icon_svg'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                    'title'      => $contact_data['email_title'] ?? 'البريد الإلكتروني',
                    'subtitle'   => $contact_data['email_subtitle'] ?? 'للتعاقدات والمبيعات',
                    'content'    => $company_info['email'],
                    'link_url'   => $company_info['email'],
                    'link_type'  => 'mailto',
                    'delay'      => 'delay-200',
                ));
                
                // Address Card
                echo alomran_render_contact_card(array(
                    'icon_bg'    => 'bg-gray-100',
                    'icon_color' => 'text-gray-700',
                    'icon_svg'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>',
                    'title'      => $contact_data['address_title'] ?? 'المقر الرئيسي',
                    'subtitle'   => '',
                    'content'    => $company_info['address'],
                    'link_url'   => '',
                    'link_type'  => 'text',
                    'delay'      => 'delay-300',
                ));
                ?>
            </div>

            <!-- Form -->
            <div class="lg:col-span-2 bg-white p-8 md:p-10 rounded-xl shadow-md animate-fade-in-up delay-300">
                <h2 class="text-2xl font-bold text-primary mb-6"><?php echo esc_html($contact_data['form_title'] ?? 'أرسل رسالة'); ?></h2>
                
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

        <!-- Map Banner -->
        <?php 
        if (!empty($contact_data['map_enable']) && !empty($contact_data['map_url'])) : 
            $map_input = $contact_data['map_url'];
            $embed_url = alomran_convert_google_maps_url($map_input);
            $original_url = alomran_extract_map_url($map_input) ?: $map_input;
        ?>
            <div class="mt-16 -mx-4 md:-mx-8 lg:-mx-16">
                <div class="w-full h-[500px] md:h-[600px] lg:h-[700px] relative overflow-hidden animate-scale-in delay-500 shadow-xl">
                    <?php if (!empty($embed_url)) : ?>
                        <iframe 
                            src="<?php echo esc_url($embed_url); ?>" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            class="w-full h-full"
                            title="<?php echo esc_attr($contact_data['map_text'] ?? 'موقع المصنع'); ?>"
                        ></iframe>
                    <?php elseif (strpos($map_input, '<iframe') !== false) : ?>
                        <?php 
                        echo wp_kses($map_input, array(
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
                    <?php else : ?>
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <p class="text-gray-500">الرجاء إدخال رابط صحيح لـ Google Maps</p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($original_url) && strpos($original_url, 'http') === 0) : ?>
                        <div class="absolute top-4 left-4 z-10">
                            <a href="<?php echo esc_url($original_url); ?>" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 bg-white/90 hover:bg-white px-4 py-2 rounded-lg shadow-lg font-bold text-primary transition-all transform hover:scale-105 backdrop-blur-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                <span class="text-sm">فتح في Google Maps</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>

