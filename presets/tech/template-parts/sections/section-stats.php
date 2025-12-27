<?php
/**
 * Tech Preset - Statistics Section Template
 *
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

$stats_enable = alomran_get_option('tech_stats_enable', true);
if (!$stats_enable) {
    return;
}

$stats_title = alomran_get_option('tech_stats_title', 'أرقام تتحدث عن نفسها');
$stats_subtitle = alomran_get_option('tech_stats_subtitle', 'نمو مستمر وثقة متزايدة من الشركات التقنية');

$default_stats = array(
    array(
        'stat_number' => '50K+',
        'stat_label' => 'معاملة شهرياً',
        'stat_icon' => '📦',
        'stat_color' => 'text-blue-600',
    ),
    array(
        'stat_number' => '500+',
        'stat_label' => 'شركة تثق بنا',
        'stat_icon' => '🏢',
        'stat_color' => 'text-violet-600',
    ),
    array(
        'stat_number' => '99.9%',
        'stat_label' => 'معدل الاستقرار',
        'stat_icon' => '⚡',
        'stat_color' => 'text-emerald-600',
    ),
    array(
        'stat_number' => '24/7',
        'stat_label' => 'دعم فني متواصل',
        'stat_icon' => '💬',
        'stat_color' => 'text-orange-600',
    ),
);

// Get stats items using helper function
$stats_items = alomran_get_repeater_items(
    'tech_stats_items',
    $default_stats,
    array('stat_number', 'stat_label') // Required fields for validation
);
?>
<section id="stats" class="py-32 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 via-violet-600/20 to-blue-600/20 animate-gradient-x"></div>
    
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <?php for ($i = 0; $i < 20; $i++) : ?>
            <div class="absolute w-2 h-2 bg-white/10 rounded-full animate-float" 
                 style="left: <?php echo rand(0, 100); ?>%; top: <?php echo rand(0, 100); ?>%; animation-delay: <?php echo $i * 0.5; ?>s; animation-duration: <?php echo 3 + rand(0, 4); ?>s;"></div>
        <?php endfor; ?>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-20">
            <div class="inline-block mb-6">
                <span class="text-sm font-black text-blue-400 uppercase tracking-widest">الإحصائيات</span>
            </div>
            <h2 class="text-4xl lg:text-6xl font-black mb-6 leading-tight">
                <?php echo esc_html($stats_title); ?>
            </h2>
            <p class="text-xl text-slate-300 max-w-2xl mx-auto font-medium">
                <?php echo esc_html($stats_subtitle); ?>
            </p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($stats_items as $index => $stat) : 
                $stat_number = $stat['stat_number'] ?? '0';
                $stat_label = $stat['stat_label'] ?? '';
                $stat_icon = $stat['stat_icon'] ?? '📊';
                $stat_color = $stat['stat_color'] ?? 'text-blue-600';
            ?>
                <div class="stat-card text-center group" data-index="<?php echo $index; ?>">
                    <div class="mb-4 inline-block">
                        <div class="text-5xl mb-4 group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                            <?php echo esc_html($stat_icon); ?>
                        </div>
                    </div>
                    <div class="<?php echo esc_attr($stat_color); ?> text-5xl lg:text-6xl font-black mb-3 stat-number" data-target="<?php echo esc_attr($stat_number); ?>" data-format="<?php echo esc_attr($stat_number); ?>">
                        <?php 
                        if ($stat_number === '24/7') {
                            echo '0';
                        } elseif (strpos($stat_number, '%') !== false) {
                            echo '0%';
                        } elseif (strpos($stat_number, 'K+') !== false) {
                            echo '0K+';
                        } elseif (strpos($stat_number, '+') !== false) {
                            echo '0+';
                        } else {
                            echo '0';
                        }
                        ?>
                    </div>
                    <p class="text-slate-300 text-lg font-bold uppercase tracking-wide"><?php echo esc_html($stat_label); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
