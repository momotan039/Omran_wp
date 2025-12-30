<?php
/**
 * Tech Preset - Dynamic Styles
 * Applies general settings (colors, typography) dynamically
 *
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get color settings
$primary_color = alomran_get_option('tech_color_primary', '#2563eb');
$secondary_color = alomran_get_option('tech_color_secondary', '#1e293b');
$accent_color = alomran_get_option('tech_color_accent', '#6366f1');

// Get typography settings
$font_family = alomran_get_option('tech_typography_font_family', 'cairo');

// Map font family to actual font names
$font_families = array(
    'cairo' => 'Cairo',
    'tajawal' => 'Tajawal',
    'almarai' => 'Almarai',
);

$font_name = isset($font_families[$font_family]) ? $font_families[$font_family] : 'Cairo';
?>

<style id="alomran-tech-dynamic-styles">
/* Tech Preset - Dynamic Styles from Redux Settings */

/* CSS Variables for Colors */
:root {
    --tech-primary-color: <?php echo esc_attr($primary_color); ?>;
    --tech-secondary-color: <?php echo esc_attr($secondary_color); ?>;
    --tech-accent-color: <?php echo esc_attr($accent_color); ?>;
}

/* Typography - Apply font to all elements */
*,
*::before,
*::after {
    font-family: '<?php echo esc_attr($font_name); ?>', sans-serif !important;
}

body,
html {
    font-family: '<?php echo esc_attr($font_name); ?>', sans-serif !important;
}

/* Apply to all text elements */
h1, h2, h3, h4, h5, h6,
p, span, div, a, button,
input, textarea, select,
label, li, td, th {
    font-family: '<?php echo esc_attr($font_name); ?>', sans-serif !important;
}

/* Apply primary color to buttons and links */
a,
button,
.btn-primary,
.bg-blue-600,
.text-blue-600,
.border-blue-600 {
    color: var(--tech-primary-color);
}

.bg-blue-600,
.bg-primary {
    background-color: var(--tech-primary-color) !important;
}

.text-blue-600,
.text-primary {
    color: var(--tech-primary-color) !important;
}

.border-blue-600,
.border-primary {
    border-color: var(--tech-primary-color) !important;
}

/* Apply secondary color */
.bg-slate-900,
.bg-secondary {
    background-color: var(--tech-secondary-color) !important;
}

.text-slate-900,
.text-secondary {
    color: var(--tech-secondary-color) !important;
}

/* Apply accent color */
.bg-violet-600,
.bg-accent {
    background-color: var(--tech-accent-color) !important;
}

.text-violet-600,
.text-accent {
    color: var(--tech-accent-color) !important;
}

/* Gradient backgrounds using primary and accent */
.bg-gradient-to-r.from-blue-600.to-violet-600,
.bg-gradient-primary-accent {
    background: linear-gradient(to right, var(--tech-primary-color), var(--tech-accent-color)) !important;
}

.bg-gradient-to-br.from-blue-600.via-blue-700.to-violet-600,
.bg-gradient-primary-accent-br {
    background: linear-gradient(to bottom right, var(--tech-primary-color), var(--tech-accent-color)) !important;
}

/* Page Title Gradient Text Fix (for features page and similar) */
h1 span.text-transparent.bg-clip-text,
h1 span.bg-gradient-to-r,
h1 span.from-blue-600,
h1 span.to-violet-600,
.page-title span.text-transparent.bg-clip-text,
.page-title span.bg-gradient-to-r {
    background: linear-gradient(to right, var(--tech-primary-color), #60a5fa, var(--tech-accent-color)) !important;
    background-size: 200% auto !important;
    background-image: linear-gradient(to right, var(--tech-primary-color), #60a5fa, var(--tech-accent-color)) !important;
    -webkit-background-clip: text !important;
    background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    color: transparent !important;
    display: inline-block !important;
    position: relative !important;
    z-index: 10 !important;
    background-color: transparent !important;
    line-height: 1.4 !important;
    padding-top: 0.15em !important;
    padding-bottom: 0.15em !important;
    margin-top: -0.15em !important;
    margin-bottom: -0.15em !important;
    vertical-align: baseline !important;
    overflow: visible !important;
    text-overflow: clip !important;
    /* Remove any Tailwind background classes */
    background-position: 0% 50% !important;
    background-repeat: no-repeat !important;
}

/* Hero Title Gradient Text Fix */
.hero-title span.text-transparent.bg-clip-text,
.hero-title span.bg-gradient-to-r {
    background: linear-gradient(to right, var(--tech-primary-color), #60a5fa, var(--tech-accent-color)) !important;
    background-size: 200% auto !important;
    -webkit-background-clip: text !important;
    background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    color: transparent !important;
    display: inline-block !important;
    position: relative !important;
    z-index: 10 !important;
    background-color: transparent !important;
    line-height: 1.4 !important;
    padding-top: 0.15em !important;
    padding-bottom: 0.15em !important;
    margin-top: -0.15em !important;
    margin-bottom: -0.15em !important;
    vertical-align: baseline !important;
    overflow: visible !important;
    text-overflow: clip !important;
}

/* Override any Tailwind classes that might interfere - Page Titles */
h1 span.bg-clip-text,
.page-title span.bg-clip-text {
    background-image: linear-gradient(to right, var(--tech-primary-color), #60a5fa, var(--tech-accent-color)) !important;
    background-size: 200% auto !important;
    -webkit-background-clip: text !important;
    background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    color: transparent !important;
    background-color: transparent !important;
    line-height: 1.4 !important;
    padding-top: 0.15em !important;
    padding-bottom: 0.15em !important;
    margin-top: -0.15em !important;
    margin-bottom: -0.15em !important;
    vertical-align: baseline !important;
    overflow: visible !important;
    text-overflow: clip !important;
}

/* Override any Tailwind classes that might interfere */
.hero-title span.bg-clip-text {
    background-image: linear-gradient(to right, var(--tech-primary-color), #60a5fa, var(--tech-accent-color)) !important;
    background-size: 200% auto !important;
    -webkit-background-clip: text !important;
    background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    color: transparent !important;
    background-color: transparent !important;
    line-height: 1.4 !important;
    padding-top: 0.15em !important;
    padding-bottom: 0.15em !important;
    margin-top: -0.15em !important;
    margin-bottom: -0.15em !important;
    vertical-align: baseline !important;
    overflow: visible !important;
    text-overflow: clip !important;
}

/* Remove any background layers that might cover the text - Page Titles */
h1 span.text-transparent,
h1 span.bg-gradient-to-r,
h1 span.from-blue-600,
h1 span.to-violet-600,
.page-title span.text-transparent {
    background-color: transparent !important;
    background-image: linear-gradient(to right, var(--tech-primary-color), #60a5fa, var(--tech-accent-color)) !important;
    background-size: 200% auto !important;
    -webkit-background-clip: text !important;
    background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    color: transparent !important;
    box-shadow: none !important;
    text-shadow: none !important;
    line-height: 1.4 !important;
    padding-top: 0.15em !important;
    padding-bottom: 0.15em !important;
    margin-top: -0.15em !important;
    margin-bottom: -0.15em !important;
    vertical-align: baseline !important;
    display: inline-block !important;
    overflow: visible !important;
    text-overflow: clip !important;
    /* Force remove any Tailwind background utilities */
    background-position: 0% 50% !important;
    background-repeat: no-repeat !important;
    /* Remove any pseudo-element backgrounds */
    isolation: isolate !important;
}

/* Remove any background layers that might cover the text */
.hero-title span.text-transparent {
    background-color: transparent !important;
    background-image: linear-gradient(to right, var(--tech-primary-color), #60a5fa, var(--tech-accent-color)) !important;
    background-size: 200% auto !important;
    -webkit-background-clip: text !important;
    background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    color: transparent !important;
    box-shadow: none !important;
    text-shadow: none !important;
    line-height: 1.4 !important;
    padding-top: 0.15em !important;
    padding-bottom: 0.15em !important;
    margin-top: -0.15em !important;
    margin-bottom: -0.15em !important;
    vertical-align: baseline !important;
    display: inline-block !important;
    overflow: visible !important;
    text-overflow: clip !important;
}

/* Ensure no pseudo-elements cover the text - Page Titles */
h1 span.text-transparent::before,
h1 span.text-transparent::after,
.page-title span.text-transparent::before,
.page-title span.text-transparent::after {
    display: none !important;
    content: none !important;
}

/* Ensure no pseudo-elements cover the text */
.hero-title span.text-transparent::before,
.hero-title span.text-transparent::after {
    display: none !important;
    content: none !important;
}

/* Fallback: if gradient doesn't work, show primary color - Page Titles */
@supports not (-webkit-background-clip: text) {
    h1 span.text-transparent,
    .page-title span.text-transparent {
        color: var(--tech-primary-color) !important;
        -webkit-text-fill-color: var(--tech-primary-color) !important;
        background: none !important;
        background-image: none !important;
    }
    
    .hero-title span.text-transparent {
        color: var(--tech-primary-color) !important;
        -webkit-text-fill-color: var(--tech-primary-color) !important;
        background: none !important;
        background-image: none !important;
    }
}

/* Hover states */
a:hover,
button:hover {
    color: var(--tech-primary-color);
}

/* Focus states */
input:focus,
textarea:focus,
select:focus {
    border-color: var(--tech-primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

/* Custom scrollbar */
::-webkit-scrollbar-thumb {
    background-color: var(--tech-primary-color);
}

/* Selection */
::selection {
    background-color: var(--tech-primary-color);
    color: white;
}

::-moz-selection {
    background-color: var(--tech-primary-color);
    color: white;
}
</style>

