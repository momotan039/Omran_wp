<?php
/**
 * Header template.
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="<?php echo esc_attr(alomran_get_html_dir()); ?>" itemscope itemtype="https://schema.org/WebSite">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <?php 
    // Preconnect to external resources for better performance
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">' . "\n";
    
    // DNS prefetch for common external resources
    echo '<link rel="dns-prefetch" href="//www.google.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//www.google-analytics.com">' . "\n";
    
    // Force Loader CSS to load first for smooth transition
    $loader_css_path = get_template_directory() . '/assets/css/loader.css';
    $loader_css_uri = get_template_directory_uri() . '/assets/css/loader.css';
    $loader_css_version = file_exists($loader_css_path) ? filemtime($loader_css_path) : '1.0.0';
    if (file_exists($loader_css_path)) {
        echo '<link rel="stylesheet" id="alomran-loader-css" href="' . esc_url($loader_css_uri) . '?ver=' . esc_attr($loader_css_version) . '" type="text/css" media="all" />' . "\n";
    }
    
    // Force Tailwind CSS to load - direct output as fallback
    $tailwind_path = get_template_directory() . '/assets/css/tailwind.css';
    $tailwind_uri = get_template_directory_uri() . '/assets/css/tailwind.css';
    $tailwind_version = file_exists($tailwind_path) ? filemtime($tailwind_path) : '1.0.0';
    echo '<link rel="stylesheet" id="alomran-tailwind-css" href="' . esc_url($tailwind_uri) . '?ver=' . esc_attr($tailwind_version) . '" type="text/css" media="all" />' . "\n";
    ?>
    <?php wp_head(); ?>
    
    <?php
    // Load dynamic styles for Tech preset
    $dynamic_styles_template = AlOmran_Preset_Loader::locate_template('dynamic-styles', 'common');
    if ($dynamic_styles_template) {
        include $dynamic_styles_template;
    }
    ?>
</head>
<?php
// Get typography settings for body class
$font_family = alomran_get_option('tech_typography_font_family', 'cairo');
$font_families = array(
    'cairo' => 'Cairo',
    'tajawal' => 'Tajawal',
    'almarai' => 'Almarai',
);
$font_name = isset($font_families[$font_family]) ? $font_families[$font_family] : 'Cairo';
?>
<body <?php body_class('font-sans antialiased'); ?> style="background-color: var(--theme-background); color: var(--theme-text); font-family: '<?php echo esc_attr($font_name); ?>', sans-serif !important;">
<?php wp_body_open(); ?>

<?php
// Get loader settings from Redux
$loader_enable = alomran_get_option('tech_loader_enable', true);
$loader_style = alomran_get_option('tech_loader_style', 'default');
$loader_text = alomran_get_option('tech_loader_text', 'جاري التحميل');
$loader_logo_type = alomran_get_option('tech_loader_logo_type', 'text');
$loader_logo_image = alomran_get_option('tech_loader_logo_image', '');
$loader_primary_color = alomran_get_option('tech_loader_primary_color', '#2563eb');
$loader_secondary_color = alomran_get_option('tech_loader_secondary_color', '#6366f1');
$loader_bg_color = alomran_get_option('tech_loader_bg_color', '#f8fafc');
$loader_min_time_seconds = alomran_get_option('tech_loader_min_time', 0.8);
// Ensure we have a valid number, convert to float, then to milliseconds
$loader_min_time_seconds = is_numeric($loader_min_time_seconds) ? floatval($loader_min_time_seconds) : 0.8;
$loader_min_time = round($loader_min_time_seconds * 1000, 0); // Convert to milliseconds and round
$loader_show_progress = alomran_get_option('tech_loader_show_progress', true);
$loader_show_spinner = alomran_get_option('tech_loader_show_spinner', true);
$loader_show_dots = alomran_get_option('tech_loader_show_dots', true);

// Get logo image URL
$loader_logo_url = '';
if ($loader_logo_type === 'image' && $loader_logo_image) {
    if (is_array($loader_logo_image) && isset($loader_logo_image['url'])) {
        $loader_logo_url = $loader_logo_image['url'];
    } elseif (is_numeric($loader_logo_image)) {
        $loader_logo_url = wp_get_attachment_image_url($loader_logo_image, 'full');
    }
}

// Get logo text - get first character from header logo text setting
$loader_logo_text = '';
if ($loader_logo_type === 'text') {
    $logo_text = alomran_get_option('tech_header_logo_text', 'إتقان');
    // Get first character, handling multi-byte characters properly
    if (!empty($logo_text)) {
        $loader_logo_text = mb_substr(trim($logo_text), 0, 1, 'UTF-8');
    } else {
        // Fallback to default
        $loader_logo_text = 'إ';
    }
}
?>

<?php if ($loader_enable) : ?>
<!-- Professional Page Loader -->
<div id="alomran-page-loader" 
     class="loader-style-<?php echo esc_attr($loader_style); ?>" 
     data-min-time="<?php echo esc_attr((string)$loader_min_time); ?>"
     style="background: linear-gradient(135deg, <?php echo esc_attr($loader_bg_color); ?> 0%, #ffffff 100%);">
    <style>
        #alomran-page-loader .loader-logo-inner {
            background: linear-gradient(135deg, <?php echo esc_attr($loader_primary_color); ?> 0%, <?php echo esc_attr($loader_secondary_color); ?> 100%);
        }
        #alomran-page-loader .loader-spinner::before {
            border-top-color: <?php echo esc_attr($loader_primary_color); ?>;
            border-right-color: <?php echo esc_attr($loader_primary_color); ?>;
        }
        #alomran-page-loader .loader-spinner::after {
            border-top-color: <?php echo esc_attr($loader_secondary_color); ?>;
            border-right-color: <?php echo esc_attr($loader_secondary_color); ?>;
        }
        #alomran-page-loader .loader-progress-bar {
            background: linear-gradient(90deg, <?php echo esc_attr($loader_primary_color); ?> 0%, <?php echo esc_attr($loader_secondary_color); ?> 100%);
        }
        #alomran-page-loader .loader-dots span {
            background: <?php echo esc_attr($loader_primary_color); ?>;
        }
    </style>
    <div class="loader-content">
        <?php if ($loader_logo_type !== 'none') : ?>
            <!-- Logo/Icon -->
            <div class="loader-logo" <?php echo ($loader_logo_type === 'image' && !$loader_logo_url) ? 'style="display:none;"' : ''; ?>>
                <div class="loader-logo-inner">
                    <?php if ($loader_logo_type === 'image' && $loader_logo_url) : ?>
                        <img src="<?php echo esc_url($loader_logo_url); ?>" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                    <?php elseif ($loader_logo_type === 'text' && $loader_logo_text) : ?>
                        <?php echo esc_html($loader_logo_text); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if ($loader_show_spinner) : ?>
            <!-- Spinner -->
            <div class="loader-spinner"></div>
        <?php endif; ?>
        
        <?php if ($loader_show_progress) : ?>
            <!-- Progress Bar -->
            <div class="loader-progress">
                <div class="loader-progress-bar"></div>
            </div>
        <?php endif; ?>
        
        <!-- Loading Text -->
        <div class="loader-text">
            <?php echo esc_html($loader_text); ?>
            <?php if ($loader_show_dots) : ?>
                <div class="loader-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
// Inline fallback to ensure loader hides
(function() {
    'use strict';
    
    function hideLoader() {
        var loader = document.getElementById('alomran-page-loader');
        var page = document.getElementById('page');
        
        if (!loader) return;
        
        // Minimum display time from Redux settings (in milliseconds)
        // Get from data attribute or use PHP value as fallback
        var minTime = loader.dataset.minTime 
            ? parseFloat(loader.dataset.minTime) 
            : <?php echo $loader_enable ? (float)$loader_min_time : 800; ?>;
        var startTime = Date.now();
        
        function hideNow() {
            var elapsed = Date.now() - startTime;
            var remaining = Math.max(0, minTime - elapsed);
            
            setTimeout(function() {
                loader.classList.add('hidden');
                if (page) {
                    page.classList.remove('opacity-0');
                    page.classList.add('opacity-100');
                }
                
                setTimeout(function() {
                    if (loader.parentNode) {
                        loader.remove();
                    }
                }, 500);
            }, remaining);
        }
        
        if (document.readyState === 'complete') {
            hideNow();
        } else {
            window.addEventListener('load', hideNow);
        }
        
        // Safety fallback
        setTimeout(function() {
            if (loader && !loader.classList.contains('hidden')) {
                hideNow();
            }
        }, 2000);
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', hideLoader);
    } else {
        hideLoader();
    }
    
    window.addEventListener('load', function() {
        var loader = document.getElementById('alomran-page-loader');
        if (loader && !loader.classList.contains('hidden')) {
            setTimeout(function() {
                loader.classList.add('hidden');
                setTimeout(function() {
                    if (loader.parentNode) {
                        loader.remove();
                    }
                }, 500);
            }, 300);
        }
    });
})();
</script>

<?php 
// Load header loader from preset
$loader_template = AlOmran_Preset_Loader::locate_template('header-loader', 'header');
if ($loader_template) {
    include $loader_template;
}
?>

<div id="page" class="site flex flex-col min-h-screen opacity-0 transition-opacity duration-500">
    <?php
    // Header removed - no header or logo displayed
    ?>

    <?php alomran_display_ad('header', 'container mx-auto px-4 py-2', 'header-ad'); ?>

    <main id="main" class="site-main flex-grow">
