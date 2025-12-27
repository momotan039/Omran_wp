<?php
/**
 * Tech Preset - Contact Page Template
 *
 * Template Name: Contact
 * 
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Get contact settings
$contact_title = alomran_get_option('tech_contact_title', 'تواصل معنا');
$contact_description = alomran_get_option('tech_contact_description', 'فريقنا التقني متاح لخدمتك وتقديم الاستشارات الفنية على مدار الساعة.');
$contact_address = alomran_get_option('tech_contact_address', 'برج الابتكار، الرياض، السعودية');
$contact_email = alomran_get_option('tech_contact_email', 'hello@etqan-saas.com');
?>

<div class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="contact" class="bg-slate-900 p-12 lg:p-24 rounded-[4rem] text-white relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-full h-full bg-blue-600/5 group-hover:opacity-100 opacity-0 transition-opacity"></div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 relative z-10">
                <div>
                    <h2 class="text-4xl lg:text-6xl font-black mb-8"><?php echo esc_html($contact_title); ?></h2>
                    <p class="text-slate-400 text-lg mb-12"><?php echo esc_html($contact_description); ?></p>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors">
                            <span class="text-2xl">📍</span>
                            <span class="font-bold"><?php echo esc_html($contact_address); ?></span>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors">
                            <span class="text-2xl">✉️</span>
                            <span class="font-bold"><?php echo esc_html($contact_email); ?></span>
                        </div>
                    </div>
                </div>
                <form class="space-y-6 bg-white p-10 lg:p-16 rounded-[3rem] shadow-2xl" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <?php wp_nonce_field('tech_contact_form', 'tech_contact_nonce'); ?>
                    <input type="hidden" name="action" value="tech_contact_submit">
                    <input type="text" name="name" placeholder="الاسم الكامل" required class="w-full p-5 rounded-2xl bg-slate-50 border-none focus:ring-4 focus:ring-blue-100 transition-all text-slate-900 font-bold" />
                    <input type="email" name="email" placeholder="البريد الإلكتروني" required class="w-full p-5 rounded-2xl bg-slate-50 border-none focus:ring-4 focus:ring-blue-100 transition-all text-slate-900 font-bold" />
                    <textarea name="message" rows="4" placeholder="كيف يمكننا مساعدتك؟" required class="w-full p-5 rounded-2xl bg-slate-50 border-none focus:ring-4 focus:ring-blue-100 transition-all text-slate-900 font-bold resize-none"></textarea>
                    <button type="submit" class="w-full py-5 bg-blue-600 text-white rounded-2xl font-black text-xl hover:bg-blue-700 transition-all shadow-xl hover:-translate-y-1">إرسال الرسالة</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();


