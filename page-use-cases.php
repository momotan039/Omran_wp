<?php
/**
 * Tech Preset - Use Cases Page Template
 *
 * Template Name: Use Cases
 * 
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Get page settings
$page_title = alomran_get_option('tech_use_cases_page_title', 'حلول مصممة لتحدياتك');
$page_subtitle = alomran_get_option('tech_use_cases_page_subtitle', 'نحن نفهم تحديات السوق المحلي ونقدم حلولاً تقنية تعالج جذور المشكلة.');

// Default use cases data (used if no data saved in Redux)
$default_use_cases = array(
    array(
        'title' => 'منصات التجارة الإلكترونية',
        'target' => 'E-commerce',
        'problem' => 'تشتت المخزون والشحن بين منصات متعددة.',
        'solution' => 'ربط API موحد يجمع كل شركات الشحن في واجهة واحدة.',
        'result' => 'زيادة سرعة معالجة الطلبات بنسبة 60%.',
        'icon' => '🛒',
        'image' => 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?auto=format&fit=crop&q=80&w=2000',
    ),
    array(
        'title' => 'التقنية المالية (Fintech)',
        'target' => 'Fintech',
        'problem' => 'تعقيد عمليات التحقق والدفع اللحظي.',
        'solution' => 'تكامل مباشر مع خدمات نفاذ، سداد، وبوابات الدفع العالمية.',
        'result' => 'فتح حسابات وإتمام مدفوعات في أقل من 3 دقائق.',
        'icon' => '💳',
        'image' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&q=80&w=2000',
    ),
    array(
        'title' => 'إدارة العقارات الذكية',
        'target' => 'PropTech',
        'problem' => 'صعوبة تحصيل الإيجارات وتتبع عقود الصيانة.',
        'solution' => 'لوحة تحكم موحدة تجمع التحصيل المالي وإدارة الأصول.',
        'result' => 'رفع كفاءة التحصيل المالي بنسبة 30%.',
        'icon' => '🏠',
        'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80&w=2000',
    ),
);

// Get use cases from Redux repeater or use defaults
$use_cases_redux = alomran_get_repeater_items('tech_use_cases_items', array(), array('title'));

// Process Redux data and convert to expected format
$use_cases = array();

if (!empty($use_cases_redux) && is_array($use_cases_redux)) {
    foreach ($use_cases_redux as $item) {
        if (!is_array($item) || empty($item['title'])) {
            continue;
        }
        
        // Get image URL from media field
        $image_url = '';
        if (isset($item['image'])) {
            if (is_array($item['image'])) {
                // Check for URL first
                if (isset($item['image']['url']) && !empty($item['image']['url'])) {
                    $image_url = $item['image']['url'];
                }
                // If no URL, try to get from attachment ID
                if (empty($image_url) && isset($item['image']['id']) && is_numeric($item['image']['id'])) {
                    $attachment_url = wp_get_attachment_image_url(intval($item['image']['id']), 'full');
                    if ($attachment_url) {
                        $image_url = $attachment_url;
                    }
                }
            } elseif (is_string($item['image']) && !empty($item['image'])) {
                // Direct URL string
                $image_url = $item['image'];
            } elseif (is_numeric($item['image'])) {
                // Just attachment ID
                $attachment_url = wp_get_attachment_image_url(intval($item['image']), 'full');
                if ($attachment_url) {
                    $image_url = $attachment_url;
                }
            }
        }
        
        // Build use case array
        $use_case = array(
            'title' => isset($item['title']) ? $item['title'] : '',
            'target' => isset($item['target']) ? $item['target'] : '',
            'problem' => isset($item['problem']) ? $item['problem'] : '',
            'solution' => isset($item['solution']) ? $item['solution'] : '',
            'result' => isset($item['result']) ? $item['result'] : '',
            'icon' => isset($item['icon']) ? $item['icon'] : '📦',
            'image' => !empty($image_url) ? $image_url : 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?auto=format&fit=crop&q=80&w=2000',
        );
        
        // Only add if title is not empty
        if (!empty($use_case['title'])) {
            $use_cases[] = $use_case;
        }
    }
}

// Use defaults if no valid use cases from Redux
if (empty($use_cases)) {
    $use_cases = $default_use_cases;
}
?>

<div class="py-24 bg-slate-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-24 animate-in fade-in duration-1000">
            <h1 class="text-4xl lg:text-7xl font-black text-slate-900 mb-6 tracking-tight">
                <?php echo esc_html($page_title); ?> <span class="text-blue-600 underline decoration-blue-200 underline-offset-8">لتحدياتك</span>
            </h1>
            <p class="text-xl text-slate-500 font-medium max-w-2xl mx-auto"><?php echo esc_html($page_subtitle); ?></p>
        </div>

        <div class="space-y-40">
            <?php foreach ($use_cases as $i => $uc) : ?>
                <div class="use-case-row lg:flex items-center gap-20 transition-all duration-1000 transform opacity-100 translate-x-0 <?php echo ($i % 2 !== 0) ? 'lg:flex-row-reverse' : ''; ?>">
                    <div class="lg:w-1/2 mb-12 lg:mb-0">
                        <div class="text-6xl mb-6 transition-transform hover:scale-125 cursor-default inline-block"><?php echo esc_html($uc['icon']); ?></div>
                        <h2 class="text-3xl lg:text-5xl font-bold text-slate-900 mb-2"><?php echo esc_html($uc['title']); ?></h2>
                        <div class="text-blue-600 font-bold mb-8 text-sm uppercase tracking-widest"><?php echo esc_html($uc['target']); ?></div>
                        
                        <div class="space-y-6">
                            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl transition-shadow">
                                <p class="text-slate-600 leading-relaxed font-medium mb-4"><?php echo esc_html($uc['problem']); ?></p>
                                <div class="pt-4 border-t border-slate-50 text-blue-600 font-black">
                                    الحل: <?php echo esc_html($uc['solution']); ?>
                                    <div class="text-emerald-500 text-sm mt-2">النتيجة: <?php echo esc_html($uc['result']); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10">
                            <?php
                            $register_page = get_page_by_path('register');
                            $register_link = $register_page ? get_permalink($register_page) : '#';
                            ?>
                            <a href="<?php echo esc_url($register_link); ?>" class="inline-flex items-center gap-3 px-10 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-blue-600 transition-all shadow-xl group">
                                ابدأ الآن <span class="group-hover:translate-x-[-5px] transition-transform">←</span>
                            </a>
                        </div>
                    </div>
                    <div class="lg:w-1/2 relative group">
                        <div class="absolute inset-0 bg-blue-600 rounded-[3rem] translate-x-4 translate-y-4 opacity-10 group-hover:opacity-20 transition-all"></div>
                        <img src="<?php echo esc_url($uc['image']); ?>" class="w-full aspect-[4/3] object-cover rounded-[3rem] shadow-2xl transition-transform duration-700 group-hover:scale-[1.03]" alt="<?php echo esc_attr($uc['title']); ?>" />
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
get_footer();












