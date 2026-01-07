<?php
/**
 * Tech Preset - Pricing Page Template
 *
 * Template Name: Pricing
 * 
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Get page settings
$page_title = alomran_get_option('tech_pricing_page_title', 'خطط مرنة وشفافة');
$page_title_highlight = alomran_get_option('tech_pricing_page_title_highlight', 'مرنة وشفافة');
$show_annual_toggle = alomran_get_option('tech_pricing_show_annual_toggle', true);
$annual_label = alomran_get_option('tech_pricing_annual_label', 'سنوي (وفر 20%)');

// Get pricing plans from Redux repeater or use defaults
$pricing_plans_redux = alomran_get_repeater_items('tech_pricing_plans', array(), array('plan_name'));
$plans = array();

if (!empty($pricing_plans_redux) && is_array($pricing_plans_redux)) {
    // Use Redux repeater data
    foreach ($pricing_plans_redux as $plan_data) {
        if (isset($plan_data['plan_name']) && !empty(trim($plan_data['plan_name']))) {
            $features = array();
            // Parse features from textarea (one feature per line)
            if (isset($plan_data['plan_features']) && !empty($plan_data['plan_features'])) {
                $features_text = trim($plan_data['plan_features']);
                if (!empty($features_text)) {
                    $lines = explode("\n", $features_text);
                    foreach ($lines as $line) {
                        $line = trim($line);
                        if (!empty($line)) {
                            $features[] = $line;
                        }
                    }
                }
            }
            
            $plans[] = array(
                'name' => trim($plan_data['plan_name']),
                'price_monthly' => isset($plan_data['plan_price_monthly']) ? trim($plan_data['plan_price_monthly']) : '',
                'price_annual' => isset($plan_data['plan_price_annual']) ? trim($plan_data['plan_price_annual']) : '',
                'desc' => isset($plan_data['plan_description']) ? trim($plan_data['plan_description']) : '',
                'features' => $features,
                'is_popular' => isset($plan_data['plan_is_popular']) ? (bool) $plan_data['plan_is_popular'] : false,
            );
        }
    }
}

// Fallback to default plans if Redux data is empty
if (empty($plans)) {
    $plans = array(
        array(
            'name' => 'باقة الانطلاق',
            'price_monthly' => '249',
            'price_annual' => '199',
            'desc' => 'للمتاجر الإلكترونية الناشئة',
            'features' => array('ربط بوابة دفع واحدة', 'حتى 1,000 معاملة', 'تكامل مع شركة شحن'),
            'is_popular' => false,
        ),
        array(
            'name' => 'باقة النمو',
            'price_monthly' => '599',
            'price_annual' => '499',
            'desc' => 'للشركات المتوسطة سريعة التوسع',
            'features' => array('معاملات غير محدودة', 'ربط Apple Pay', 'لوحة تحكم إحصائية', 'دعم فني واتساب'),
            'is_popular' => true,
        ),
        array(
            'name' => 'باقة المؤسسات',
            'price_monthly' => 'مخصص',
            'price_annual' => 'مخصص',
            'desc' => 'للشركات التقنية الكبرى',
            'features' => array('تخصيص كامل للنظام', 'بنية تحتية مخصصة', 'اتفاقية مستوى الخدمة'),
            'is_popular' => false,
        ),
    );
}
?>

<div class="py-24 bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-20 animate-in fade-in slide-in-from-top-8 duration-1000">
            <h1 class="text-4xl lg:text-7xl font-black text-slate-900 mb-8 leading-tight">
                <?php echo esc_html($page_title); ?> <span class="text-blue-600"><?php echo esc_html($page_title_highlight); ?></span>
            </h1>
            
            <?php if ($show_annual_toggle) : ?>
                <div class="inline-flex items-center gap-6 p-2 bg-white rounded-[2rem] border border-slate-200 shadow-sm transition-transform hover:scale-105" id="pricing-toggle-container">
                    <span class="text-sm font-black transition-colors text-slate-400" id="pricing-monthly-label">شهري</span>
                    <button onclick="togglePricing()" class="w-16 h-8 bg-slate-900 rounded-full relative transition-colors duration-300" id="pricing-toggle">
                        <div class="absolute top-1 w-6 h-6 bg-white rounded-full shadow-md transition-transform duration-500 left-1" id="pricing-toggle-dot"></div>
                    </button>
                    <span class="text-sm font-black transition-colors text-blue-600" id="pricing-annual-label"><?php echo esc_html($annual_label); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
            <?php foreach ($plans as $i => $plan) : ?>
                <div class="relative bg-white p-12 rounded-[4rem] border transition-all duration-700 flex flex-col hover:-translate-y-4 hover:shadow-2xl animate-in fade-in zoom-in-95 duration-700 <?php echo $plan['is_popular'] ? 'border-blue-600 shadow-2xl scale-105 z-10' : 'border-slate-100'; ?>">
                    <?php if ($plan['is_popular']) : ?>
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-blue-600 text-white text-[10px] font-black px-6 py-2 rounded-full uppercase tracking-widest animate-pulse">
                            الأكثر طلباً
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-10">
                        <h3 class="text-3xl font-black text-slate-900 mb-3"><?php echo esc_html($plan['name']); ?></h3>
                        <p class="text-slate-500 text-sm font-medium"><?php echo esc_html($plan['desc']); ?></p>
                    </div>

                    <div class="mb-10 flex items-baseline gap-2">
                        <span class="text-6xl font-black text-slate-900 tracking-tighter pricing-price" data-monthly="<?php echo esc_attr($plan['price_monthly']); ?>" data-annual="<?php echo esc_attr($plan['price_annual']); ?>">
                            <?php echo esc_html($plan['price_annual']); ?>
                        </span>
                        <?php if ($plan['price_monthly'] !== 'مخصص' && $plan['price_annual'] !== 'مخصص') : ?>
                            <span class="text-slate-400 font-bold text-sm pricing-period">/ سنة</span>
                        <?php endif; ?>
                    </div>

                    <ul class="space-y-5 mb-12 flex-grow">
                        <?php foreach ($plan['features'] as $feature) : ?>
                            <li class="flex items-center gap-4 text-slate-600 text-sm font-bold">
                                <span class="w-5 h-5 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-[10px]">✓</span> <?php echo esc_html($feature); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <?php
                    // Get CTA settings from Redux
                    $pricing_cta_type = alomran_get_option('tech_pricing_cta_type', 'book-demo');
                    $pricing_cta_custom = alomran_get_option('tech_pricing_cta_custom', '');
                    $pricing_cta_text = alomran_get_option('tech_pricing_cta_text', 'احجز عرضًا توضيحيًا');
                    
                    // Get button link
                    $pricing_link = alomran_get_button_link($pricing_cta_type, $pricing_cta_custom);
                    
                    // Override text for popular plan if set
                    if ($plan['is_popular']) {
                        $pricing_cta_text_popular = alomran_get_option('tech_pricing_cta_text_popular', $pricing_cta_text);
                        if (!empty($pricing_cta_text_popular)) {
                            $pricing_cta_text = $pricing_cta_text_popular;
                        }
                    }
                    ?>
                    <a href="<?php echo esc_url($pricing_link); ?>" class="block text-center py-5 rounded-2xl font-black text-lg transition-all <?php echo $plan['is_popular'] ? 'bg-blue-600 text-white hover:bg-blue-700 shadow-xl' : 'bg-slate-900 text-white hover:bg-slate-800'; ?>">
                        <?php echo esc_html($pricing_cta_text); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php if ($show_annual_toggle) : ?>
<script>
let isAnnual = true;
function togglePricing() {
    isAnnual = !isAnnual;
    const prices = document.querySelectorAll('.pricing-price');
    const periods = document.querySelectorAll('.pricing-period');
    const dot = document.getElementById('pricing-toggle-dot');
    const monthlyLabel = document.getElementById('pricing-monthly-label');
    const annualLabel = document.getElementById('pricing-annual-label');
    
    prices.forEach(price => {
        const monthly = price.getAttribute('data-monthly');
        const annual = price.getAttribute('data-annual');
        price.textContent = isAnnual ? annual : monthly;
    });
    
    periods.forEach(period => {
        period.textContent = isAnnual ? '/ سنة' : '/ شهر';
    });
    
    if (isAnnual) {
        dot.style.left = '4px';
        monthlyLabel.classList.remove('text-blue-600');
        monthlyLabel.classList.add('text-slate-400');
        annualLabel.classList.remove('text-slate-400');
        annualLabel.classList.add('text-blue-600');
    } else {
        dot.style.left = '36px';
        monthlyLabel.classList.remove('text-slate-400');
        monthlyLabel.classList.add('text-blue-600');
        annualLabel.classList.remove('text-blue-600');
        annualLabel.classList.add('text-slate-400');
    }
}
</script>
<?php endif; ?>

<?php
get_footer();
