<?php
/**
 * Tech Preset - Book Demo Page Template
 *
 * Template Name: Book Demo
 * 
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Get page settings
$page_title = alomran_get_option('tech_demo_page_title', 'احجز عرضًا توضيحيًا مجانيًا');
$page_subtitle = alomran_get_option('tech_demo_page_subtitle', 'اكتشف كيف يمكن لمنصة إتقان أن تحول عملك');
$page_description = alomran_get_option('tech_demo_page_description', 'خلال 30 دقيقة، سنعرض لك كيف يمكن لمنصة إتقان أن تساعدك في تحقيق أهدافك التجارية. احجز موعدك الآن واستمتع بعرض توضيحي مخصص لاحتياجاتك.');

// Get benefits from Redux repeater or use defaults
$demo_benefits_redux = alomran_get_option('tech_demo_benefits', array());
$demo_benefits = array();

if (!empty($demo_benefits_redux) && is_array($demo_benefits_redux)) {
    foreach ($demo_benefits_redux as $benefit_data) {
        if (isset($benefit_data['benefit_text']) && !empty($benefit_data['benefit_text'])) {
            $demo_benefits[] = $benefit_data['benefit_text'];
        }
    }
}

// Fallback to defaults if Redux data is empty
if (empty($demo_benefits)) {
    $demo_benefits = array(
        'عرض توضيحي مخصص لاحتياجاتك',
        'إجابات على جميع أسئلتك',
        'خطة تنفيذ واضحة',
        'عروض خاصة للمشاهدين'
    );
}

// Handle form submission
$demo_error = '';
$demo_success = false;

if (isset($_POST['tech_demo_submit'])) {
    if (!isset($_POST['tech_demo_nonce']) || !wp_verify_nonce($_POST['tech_demo_nonce'], 'tech_demo_form')) {
        $demo_error = 'التحقق من الأمان فشل. يرجى المحاولة مرة أخرى.';
    } else {
        $name = isset($_POST['demo_name']) ? sanitize_text_field($_POST['demo_name']) : '';
        $email = isset($_POST['demo_email']) ? sanitize_email($_POST['demo_email']) : '';
        $company = isset($_POST['demo_company']) ? sanitize_text_field($_POST['demo_company']) : '';
        $message = isset($_POST['demo_message']) ? sanitize_textarea_field($_POST['demo_message']) : '';
        
        if (empty($name) || empty($email) || empty($company)) {
            $demo_error = 'يرجى ملء جميع الحقول المطلوبة.';
        } elseif (!is_email($email)) {
            $demo_error = 'البريد الإلكتروني غير صحيح.';
        } else {
            // Save demo request
            $demo_data = array(
                'name' => $name,
                'email' => $email,
                'company' => $company,
                'message' => $message,
                'date' => current_time('mysql'),
                'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
            );
            
            // Save to database
            $post_id = wp_insert_post(array(
                'post_title' => sprintf('%s - %s', $name, $company),
                'post_content' => sprintf(
                    "الاسم: %s\nالبريد: %s\nالشركة: %s\nالرسالة: %s\nالتاريخ: %s",
                    $name,
                    $email,
                    $company,
                    $message,
                    $demo_data['date']
                ),
                'post_type' => 'demo_request',
                'post_status' => 'publish',
                'meta_input' => array_merge($demo_data, array(
                    '_demo_read' => '0', // Mark as unread
                )),
            ));
            
            if (!is_wp_error($post_id)) {
                // Send email notification
                $admin_email = get_option('admin_email');
                $subject = sprintf('[طلب ديمو] من %s - %s', $name, $company);
                $email_message = sprintf(
                    "طلب جديد لحجز عرض توضيحي:\n\nالاسم: %s\nالبريد: %s\nالشركة: %s\nالرسالة: %s\n\nعرض الطلب: %s",
                    $name,
                    $email,
                    $company,
                    $message,
                    admin_url('post.php?post=' . $post_id . '&action=edit')
                );
                
                wp_mail($admin_email, $subject, $email_message);
                
                $demo_success = true;
            } else {
                $demo_error = 'حدث خطأ أثناء إرسال الطلب. يرجى المحاولة مرة أخرى.';
            }
        }
    }
}
?>

<div class="py-24 bg-gradient-to-br from-slate-50 via-blue-50 to-slate-50 relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-100/30 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-violet-100/30 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/4"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <!-- Left Side: Content -->
            <div class="lg:sticky lg:top-24">
                <div class="mb-8">
                    <span class="inline-block text-sm font-black text-blue-600 uppercase tracking-widest mb-4">عرض توضيحي مجاني</span>
                    <h1 class="text-4xl lg:text-6xl font-black text-slate-900 mb-6 leading-tight">
                        <?php echo esc_html($page_title); ?>
                    </h1>
                    <p class="text-xl text-slate-600 mb-8 leading-relaxed font-medium">
                        <?php echo esc_html($page_subtitle); ?>
                    </p>
                    <p class="text-lg text-slate-500 mb-12 leading-relaxed">
                        <?php echo esc_html($page_description); ?>
                    </p>
                </div>
                
                <?php if (!empty($demo_benefits) && is_array($demo_benefits)) : ?>
                    <div class="space-y-4">
                        <h3 class="text-xl font-black text-slate-900 mb-6">ماذا ستحصل:</h3>
                        <?php foreach ($demo_benefits as $benefit) : ?>
                            <div class="flex items-start gap-4 p-4 bg-white rounded-2xl border border-slate-100 shadow-sm">
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <p class="text-slate-700 font-bold flex-grow"><?php echo esc_html($benefit); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Right Side: Form -->
            <div class="bg-white p-10 lg:p-16 rounded-[4rem] shadow-2xl border border-slate-100">
                <?php if ($demo_success) : ?>
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-black text-slate-900 mb-4">شكراً لك!</h2>
                        <p class="text-lg text-slate-600 mb-8">تم استلام طلبك بنجاح. سيتواصل معك فريقنا خلال 24 ساعة لتأكيد موعد العرض التوضيحي.</p>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block px-8 py-4 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 transition-colors">
                            العودة للصفحة الرئيسية
                        </a>
                    </div>
                <?php else : ?>
                    <?php if ($demo_error) : ?>
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                            <?php echo esc_html($demo_error); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" action="<?php echo esc_url(get_permalink()); ?>" class="space-y-6" id="demo-form">
                        <?php wp_nonce_field('tech_demo_form', 'tech_demo_nonce'); ?>
                        <input type="hidden" name="tech_demo_submit" value="1">
                        
                        <div class="space-y-2">
                            <label for="demo_name" class="text-sm font-black text-slate-700">الاسم الكامل *</label>
                            <input 
                                id="demo_name"
                                name="demo_name" 
                                type="text" 
                                placeholder="أحمد محمد" 
                                required 
                                value="<?php echo isset($_POST['demo_name']) ? esc_attr($_POST['demo_name']) : ''; ?>"
                                class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all text-slate-900 font-bold" 
                            />
                        </div>
                        
                        <div class="space-y-2">
                            <label for="demo_email" class="text-sm font-black text-slate-700">البريد الإلكتروني *</label>
                            <input 
                                id="demo_email"
                                name="demo_email" 
                                type="email" 
                                placeholder="ahmed@company.com" 
                                required 
                                value="<?php echo isset($_POST['demo_email']) ? esc_attr($_POST['demo_email']) : ''; ?>"
                                class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all text-slate-900 font-bold" 
                            />
                        </div>
                        
                        <div class="space-y-2">
                            <label for="demo_company" class="text-sm font-black text-slate-700">اسم الشركة *</label>
                            <input 
                                id="demo_company"
                                name="demo_company" 
                                type="text" 
                                placeholder="شركة التقنية المتقدمة" 
                                required 
                                value="<?php echo isset($_POST['demo_company']) ? esc_attr($_POST['demo_company']) : ''; ?>"
                                class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all text-slate-900 font-bold" 
                            />
                        </div>
                        
                        <div class="space-y-2">
                            <label for="demo_message" class="text-sm font-black text-slate-700">رسالة (اختياري)</label>
                            <textarea 
                                id="demo_message"
                                name="demo_message" 
                                rows="4" 
                                placeholder="أخبرنا عن احتياجاتك أو أي أسئلة لديك..."
                                class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all text-slate-900 font-bold resize-none"
                            ><?php echo isset($_POST['demo_message']) ? esc_textarea($_POST['demo_message']) : ''; ?></textarea>
                        </div>

                        <button 
                            type="submit"
                            class="w-full py-5 bg-blue-600 text-white rounded-2xl font-black text-xl hover:bg-blue-700 transition-all shadow-xl hover:-translate-y-1 hover:scale-[1.02]"
                        >
                            احجز عرضًا توضيحيًا
                        </button>
                        
                        <p class="text-xs text-center text-slate-500">
                            بالضغط على الزر، أنت توافق على <a href="#" class="text-blue-600 hover:underline">سياسة الخصوصية</a> و <a href="#" class="text-blue-600 hover:underline">شروط الخدمة</a>
                        </p>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();

