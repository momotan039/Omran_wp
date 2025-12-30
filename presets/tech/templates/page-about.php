<?php
/**
 * Tech Preset - About Page Template
 *
 * Template Name: About
 * 
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Get page settings
$page_title = alomran_get_option('tech_about_page_title', 'نعيد تعريف الربط التقني في المنطقة');
$page_title_highlight = alomran_get_option('tech_about_page_title_highlight', 'الربط التقني');
$page_description = alomran_get_option('tech_about_page_description', 'نحن لا نقدم مجرد برمجيات، بل نبني جسوراً تقنية تربط بين أعمالك وبين طموحات عملائك. "إتقان" هي ثمرة سنوات من البحث والتطوير في السوق السعودي.');
$about_image = alomran_get_option('tech_about_page_image', '');
$stats_years = alomran_get_option('tech_about_stats_years', '+10');
$stats_partners = alomran_get_option('tech_about_stats_partners', '+500');
$location_title = alomran_get_option('tech_about_location_title', 'مقرنا بالرياض');
$location_address = alomran_get_option('tech_about_location_address', 'حي الصحافة، مركز الابتكار الرقمي');
$location_image = alomran_get_option('tech_about_location_image', '');

// Get image URLs
$about_image_url = '';
if ($about_image) {
    if (is_array($about_image) && isset($about_image['url'])) {
        $about_image_url = $about_image['url'];
    } elseif (is_numeric($about_image)) {
        $about_image_url = wp_get_attachment_image_url($about_image, 'full');
    }
}
if (!$about_image_url) {
    $about_image_url = 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=2000';
}

$location_image_url = '';
if ($location_image) {
    if (is_array($location_image) && isset($location_image['url'])) {
        $location_image_url = $location_image['url'];
    } elseif (is_numeric($location_image)) {
        $location_image_url = wp_get_attachment_image_url($location_image, 'full');
    }
}
if (!$location_image_url) {
    $location_image_url = 'https://images.unsplash.com/photo-1549109786-eb80da1f8732?auto=format&fit=crop&q=80&w=2000';
}
?>

<div class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 mb-40 items-center">
            <div class="animate-in fade-in slide-in-from-right duration-1000">
                <h1 class="text-4xl lg:text-7xl font-black text-slate-900 mb-10 leading-[1.1]">
                    <?php echo esc_html(str_replace($page_title_highlight, '', $page_title)); ?> <br /> 
                    <span class="text-blue-600"><?php echo esc_html($page_title_highlight); ?></span> <br /> 
                    <?php echo esc_html(substr($page_title, strpos($page_title, $page_title_highlight) + strlen($page_title_highlight))); ?>
                </h1>
                <p class="text-xl text-slate-500 mb-8 font-medium"><?php echo esc_html($page_description); ?></p>
                <div class="flex gap-8">
                    <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100">
                        <div class="text-4xl font-black text-blue-600 mb-2"><?php echo esc_html($stats_years); ?></div>
                        <div class="text-xs font-bold text-slate-500 uppercase">أعوام خبرة</div>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100">
                        <div class="text-4xl font-black text-violet-600 mb-2"><?php echo esc_html($stats_partners); ?></div>
                        <div class="text-xs font-bold text-slate-500 uppercase">شريك نجاح</div>
                    </div>
                </div>
            </div>
            <div class="relative animate-in fade-in slide-in-from-left duration-1000">
                <div class="aspect-square rounded-[4rem] overflow-hidden shadow-2xl group border-8 border-slate-50">
                    <img src="<?php echo esc_url($about_image_url); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[2s]" alt="فريق العمل" />
                </div>
                <div class="absolute -bottom-10 -right-10 bg-white p-8 rounded-3xl shadow-2xl border border-slate-100 animate-bounce">
                    <div class="text-blue-600 font-black text-3xl">99.9%</div>
                    <div class="text-xs font-bold text-slate-400">استقرار النظام</div>
                </div>
            </div>
        </div>

        <!-- Location Section -->
        <div class="mb-40 rounded-[4rem] overflow-hidden relative h-96 group shadow-2xl">
            <img 
                src="<?php echo esc_url($location_image_url); ?>" 
                class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000" 
                alt="<?php echo esc_attr($location_title); ?>"
            />
            <div class="absolute inset-0 bg-blue-600/20"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="bg-white/90 backdrop-blur-md p-8 rounded-[2rem] text-center shadow-2xl">
                    <h3 class="text-2xl font-black text-slate-900 mb-2"><?php echo esc_html($location_title); ?></h3>
                    <p class="text-slate-500 font-bold"><?php echo esc_html($location_address); ?></p>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <?php
        $contact_title = alomran_get_option('tech_contact_title', 'تواصل معنا');
        $contact_description = alomran_get_option('tech_contact_description', 'فريقنا التقني متاح لخدمتك وتقديم الاستشارات الفنية على مدار الساعة.');
        $contact_address = alomran_get_option('tech_contact_address', 'برج الابتكار، الرياض، السعودية');
        $contact_email = alomran_get_option('tech_contact_email', 'hello@etqan-saas.com');
        ?>
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



