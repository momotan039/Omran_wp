<?php
/**
 * Header Loader Component
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$logo_settings = alomran_get_header_logo_settings();
?>
<!-- Page Loader -->
<div id="page-loader" class="fixed inset-0 z-[100] bg-white flex items-center justify-center transition-opacity duration-500">
    <div class="text-center">
        <!-- Logo Animation -->
        <div class="relative w-20 h-20 mx-auto mb-6">
            <?php if (!empty($logo_settings['icon_url'])) : ?>
                <div class="w-20 h-20 flex items-center justify-center animate-pulse">
                    <img src="<?php echo esc_url($logo_settings['icon_url']); ?>" alt="<?php echo esc_attr($logo_settings['title']); ?>" class="w-full h-full object-contain">
                </div>
            <?php else : ?>
                <!-- Industrial Logo Animation -->
                <div class="absolute inset-0 bg-secondary rounded-lg flex items-center justify-center transform rotate-45 animate-spin-slow">
                    <div class="w-12 h-12 border-4 border-primary border-t-transparent rounded-lg transform -rotate-45"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-8 h-8 bg-primary rounded transform rotate-45"></div>
                </div>
            <?php endif; ?>
        </div>
        <!-- Loading Text -->
        <div class="space-y-2">
            <?php if ($logo_settings['show_title']) : ?>
                <h3 class="text-xl font-bold text-primary"><?php echo esc_html($logo_settings['title']); ?></h3>
            <?php endif; ?>
            <?php if ($logo_settings['show_subtitle']) : ?>
                <p class="text-sm text-gray-600"><?php echo esc_html($logo_settings['subtitle']); ?></p>
            <?php endif; ?>
            <!-- Progress Bar -->
            <div class="w-48 h-1 bg-gray-200 rounded-full mx-auto mt-4 overflow-hidden">
                <div id="loader-progress" class="h-full bg-gradient-to-r from-primary via-secondary to-primary rounded-full transform -translate-x-full animate-progress"></div>
            </div>
        </div>
    </div>
</div>

<script>
// Vanilla JS fallback to hide loader - runs immediately
(function() {
    function hideLoader() {
        const loader = document.getElementById('page-loader');
        const page = document.getElementById('page');
        
        if (loader && page) {
            loader.style.opacity = '0';
            loader.style.pointerEvents = 'none';
            page.style.opacity = '1';
            
            setTimeout(function() {
                loader.style.display = 'none';
            }, 500);
        }
    }
    
    // Hide loader when window loads
    if (document.readyState === 'complete') {
        setTimeout(hideLoader, 800);
    } else {
        window.addEventListener('load', function() {
            setTimeout(hideLoader, 800);
        });
    }
    
    // Safety fallback - hide after 3 seconds max
    setTimeout(hideLoader, 3000);
})();
</script>

