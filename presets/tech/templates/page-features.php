<?php
/**
 * Tech Preset - Features Page Template
 *
 * Template Name: Features
 * 
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Get page settings
$page_title = alomran_get_option('tech_features_page_title', 'بنية تحتية تنمو مع أعمالك');
$page_title_highlight = alomran_get_option('tech_features_page_title_highlight', 'تنمو مع أعمالك');

// Default features data (used if no data saved in Redux)
$default_features_categories = array(
    'integration' => array(
        'label' => 'الربط البرمجي (API)',
        'features' => array(
            array('title' => 'SDKs جاهزة', 'desc' => 'مكتبات برمجية متكاملة لـ PHP, Python, Node.js.', 'icon' => '📦'),
            array('title' => 'Webhooks لحظية', 'desc' => 'استقبل إشعارات فورية عن حالة الشحنات والمدفوعات.', 'icon' => '🔌'),
            array('title' => 'توثيق Swagger', 'desc' => 'مرجع تقني شامل يسهل عملية الربط في دقائق.', 'icon' => '📄'),
        ),
    ),
    'automation' => array(
        'label' => 'الأتمتة الذكية',
        'features' => array(
            array('title' => 'سير عمل مرن', 'desc' => 'أتمتة دورة حياة الطلب من الدفع إلى الشحن.', 'icon' => '⚙️'),
            array('title' => 'تحديث المخزون', 'desc' => 'مزامنة رصيد المنتجات بين متجرك ومستودعاتك.', 'icon' => '🔄'),
            array('title' => 'ذكاء اصطناعي', 'desc' => 'خوارزميات لتحديد أفضل شركة شحن أوتوماتيكياً.', 'icon' => '🤖'),
        ),
    ),
    'fintech' => array(
        'label' => 'الحلول المالية',
        'features' => array(
            array('title' => 'دعم Apple Pay', 'desc' => 'تفعيل الدفع السريع بضغطة زر واحدة.', 'icon' => '📲'),
            array('title' => 'تسوية المبالغ', 'desc' => 'نظام آلي لتسوية المبالغ وتحويلها دورياً.', 'icon' => '🏦'),
            array('title' => 'فوترة إلكترونية', 'desc' => 'فواتير متوافقة مع متطلبات هيئة الزكاة والدخل.', 'icon' => '🧾'),
        ),
    ),
    'analytics' => array(
        'label' => 'التحليلات المتقدمة',
        'features' => array(
            array('title' => 'لوحات قياس', 'desc' => 'تقارير تفاعلية تعرض حجم المبيعات والأداء.', 'icon' => '📊'),
            array('title' => 'تحليل السلوك', 'desc' => 'فهم أعمق لعمليات التخلي عن السلة.', 'icon' => '📈'),
            array('title' => 'تصدير ذكي', 'desc' => 'تصدير البيانات بصيغ متوافقة مع أنظمة المحاسبة.', 'icon' => '📤'),
        ),
    ),
);

// Get features categories from Redux repeater or use defaults (same mechanism as pricing plans)
$features_categories_redux = alomran_get_repeater_items('tech_features_categories', array(), array('category_label'));

// Fallback: Try reading directly from Redux if repeater helper doesn't work
if (empty($features_categories_redux)) {
    $features_categories_redux = alomran_get_option('tech_features_categories', array());
    if (is_string($features_categories_redux)) {
        $features_categories_redux = maybe_unserialize($features_categories_redux);
    }
    if (!is_array($features_categories_redux)) {
        $features_categories_redux = array();
    }
}

$features_categories = array();

if (!empty($features_categories_redux) && is_array($features_categories_redux)) {
    // Handle different Redux data formats
    if (isset($features_categories_redux['redux_repeater_data']) && is_array($features_categories_redux['redux_repeater_data'])) {
        $features_categories_redux = $features_categories_redux['redux_repeater_data'];
    } elseif (isset($features_categories_redux['category_label']) && is_array($features_categories_redux['category_label'])) {
        // Convert separate arrays to combined array
        $temp_categories = array();
        $max_count = 0;
        foreach ($features_categories_redux as $key => $value) {
            if (is_array($value) && count($value) > $max_count) {
                $max_count = count($value);
            }
        }
        for ($i = 0; $i < $max_count; $i++) {
            $temp_categories[$i] = array();
            foreach ($features_categories_redux as $key => $value) {
                if (is_array($value) && isset($value[$i])) {
                    $temp_categories[$i][$key] = $value[$i];
                }
            }
        }
        $features_categories_redux = $temp_categories;
    }
    
    // Use Redux repeater data
    foreach ($features_categories_redux as $category_data) {
        if (!is_array($category_data)) {
            continue;
        }
        
        $cat_label = isset($category_data['category_label']) ? trim($category_data['category_label']) : '';
        $cat_id = isset($category_data['category_id']) ? trim($category_data['category_id']) : '';
        
        // Skip if missing required field
        if (empty($cat_label)) {
            continue;
        }
        
        // Generate category ID from label if not provided
        if (empty($cat_id)) {
            $cat_id = preg_replace('/[^a-z0-9_]/', '', strtolower($cat_label));
            if (empty($cat_id)) {
                $cat_id = 'cat_' . md5($cat_label);
            }
        } else {
            $cat_id = preg_replace('/[^a-z0-9_]/', '', strtolower($cat_id));
        }
        
        if (empty($cat_id)) {
            continue;
        }
        
        // Parse features from textarea (format: Title | Description | Icon)
        $features = array();
        if (isset($category_data['category_features']) && !empty($category_data['category_features'])) {
            $features_text = trim($category_data['category_features']);
            if (!empty($features_text)) {
                $lines = explode("\n", $features_text);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line)) {
                        continue;
                    }
                    
                    // Split by | separator
                    $parts = array_map('trim', explode('|', $line));
                    
                    $feature_title = isset($parts[0]) ? trim($parts[0]) : '';
                    $feature_desc = isset($parts[1]) ? trim($parts[1]) : '';
                    $feature_icon = isset($parts[2]) ? trim($parts[2]) : '📦';
                    
                    // Skip if missing title
                    if (empty($feature_title)) {
                        continue;
                    }
                    
                    $features[] = array(
                        'title' => $feature_title,
                        'desc' => $feature_desc,
                        'icon' => !empty($feature_icon) ? $feature_icon : '📦',
                    );
                }
            }
        }
        
        $features_categories[$cat_id] = array(
            'label' => $cat_label,
            'features' => $features,
        );
    }
}

// Fallback to default categories if Redux data is empty
if (empty($features_categories)) {
    $features_categories = $default_features_categories;
}
?>

<div class="py-24 bg-white relative overflow-hidden">
    <div class="absolute top-0 left-0 w-96 h-96 bg-blue-100/30 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2 animate-pulse"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-24 transition-all duration-1000 transform">
            <h1 class="text-4xl lg:text-7xl font-black text-slate-900 mb-8 leading-tight animate-in fade-in slide-in-from-bottom-8 duration-1000">
                <?php echo esc_html($page_title); ?> <span class="text-transparent bg-clip-text relative z-10 inline-block" style="background: linear-gradient(to right, var(--tech-primary-color), #60a5fa, var(--tech-accent-color)); background-size: 200% auto; -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; color: transparent; background-color: transparent; line-height: 1.4; padding-top: 0.15em; padding-bottom: 0.15em; margin-top: -0.15em; margin-bottom: -0.15em; overflow: visible; display: inline-block; position: relative;"><?php echo esc_html($page_title_highlight); ?></span>
            </h1>
        </div>

        <?php
        $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : '';
        if (empty($active_tab) || !isset($features_categories[$active_tab])) {
            $category_keys = array_keys($features_categories);
            $active_tab = !empty($category_keys) ? $category_keys[0] : '';
        }
        
        if (empty($active_tab) || !isset($features_categories[$active_tab])) {
            return;
        }
        ?>

        <div class="flex flex-wrap justify-center gap-3 mb-16 p-2 bg-slate-50 rounded-[2rem] max-w-fit mx-auto border border-slate-100">
            <?php foreach ($features_categories as $cat_id => $cat_data) : ?>
                <a
                    href="?tab=<?php echo esc_attr($cat_id); ?>"
                    class="px-8 py-4 rounded-[1.5rem] font-black text-sm transition-all duration-300 <?php echo ($active_tab === $cat_id) ? 'bg-white text-blue-600 shadow-xl scale-105' : 'text-slate-500 hover:text-slate-900'; ?>"
                >
                    <?php echo esc_html($cat_data['label']); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php 
            if (isset($features_categories[$active_tab]['features']) && is_array($features_categories[$active_tab]['features'])) :
                foreach ($features_categories[$active_tab]['features'] as $i => $feature) : 
                    $feature_title = isset($feature['title']) ? trim($feature['title']) : '';
                    $feature_desc = isset($feature['desc']) ? trim($feature['desc']) : '';
                    $feature_icon = isset($feature['icon']) ? trim($feature['icon']) : '📦';
                    
                    if (empty($feature_title)) {
                        continue;
                    }
            ?>
                <div class="bg-white p-12 rounded-[3rem] border border-slate-100 hover:border-blue-200 hover:shadow-2xl transition-all duration-700 group transform opacity-100 translate-y-0 scale-100">
                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-4xl mb-10 group-hover:bg-blue-600 group-hover:text-white group-hover:rotate-6 transition-all duration-500">
                        <?php echo esc_html($feature_icon); ?>
                    </div>
                    <h4 class="text-2xl font-black text-slate-900 mb-4 tracking-tight"><?php echo esc_html($feature_title); ?></h4>
                    <p class="text-slate-500 leading-relaxed font-medium text-lg"><?php echo esc_html($feature_desc); ?></p>
                </div>
            <?php 
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
