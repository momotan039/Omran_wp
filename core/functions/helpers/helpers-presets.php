<?php
/**
 * Theme Presets Helper Functions
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get current theme preset
 * 
 * @return string
 */
function alomran_get_theme_preset() {
    return alomran_get_option('theme_preset', 'industrial');
}

/**
 * Get preset colors
 * 
 * @return array
 */
function alomran_get_preset_colors() {
    $preset = alomran_get_theme_preset();
    
    // Default colors for each preset
    // Accent colors are optimized for visibility, contrast, and harmony with primary/secondary colors
    $defaults = array(
        'industrial' => array(
            'primary'   => '#2c5530',
            'secondary' => '#4a7c59',
            'accent'    => '#f97316', // Vibrant orange - warm contrast to green, perfect for highlights
            'background' => '#ffffff',
            'text'      => '#1f2937',
            'text_light' => '#6b7280',
        ),
        'food' => array(
            'primary'   => '#dc2626',
            'secondary' => '#f97316',
            'accent'    => '#facc15', // Bright yellow - vibrant and appetizing, complements red/orange
            'background' => '#ffffff',
            'text'      => '#1f2937',
            'text_light' => '#6b7280',
        ),
        'tech' => array(
            'primary'   => '#1e40af',
            'secondary' => '#3b82f6',
            'accent'    => '#22d3ee', // Bright cyan - modern tech feel, complements blue palette
            'background' => '#ffffff',
            'text'      => '#1f2937',
            'text_light' => '#6b7280',
        ),
    );
    
    $default = isset($defaults[$preset]) ? $defaults[$preset] : $defaults['industrial'];
    
    $colors = array(
        'primary'    => alomran_get_option('preset_' . $preset . '_primary', $default['primary']),
        'secondary'  => alomran_get_option('preset_' . $preset . '_secondary', $default['secondary']),
        'accent'     => alomran_get_option('preset_' . $preset . '_accent', $default['accent']),
        'background' => alomran_get_option('preset_' . $preset . '_background', $default['background']),
        'text'       => alomran_get_option('preset_' . $preset . '_text', $default['text']),
        'text_light' => alomran_get_option('preset_' . $preset . '_text_light', $default['text_light']),
    );
    
    return $colors;
}

/**
 * Get primary color for current preset
 * 
 * @return string
 */
function alomran_get_primary_color() {
    $colors = alomran_get_preset_colors();
    return $colors['primary'];
}

/**
 * Get secondary color for current preset
 * 
 * @return string
 */
function alomran_get_secondary_color() {
    $colors = alomran_get_preset_colors();
    return $colors['secondary'];
}

/**
 * Get accent color for current preset
 * 
 * @return string
 */
function alomran_get_accent_color() {
    $colors = alomran_get_preset_colors();
    return $colors['accent'];
}

/**
 * Get font family
 * 
 * @return string
 */
function alomran_get_font_family() {
    return alomran_get_option('preset_font_family', 'cairo');
}

/**
 * Get font weight
 * 
 * @return string
 */
function alomran_get_font_weight() {
    return alomran_get_option('preset_font_weight', '400');
}

/**
 * Get header style
 * 
 * @return string
 */
function alomran_get_header_style() {
    return alomran_get_option('preset_header_style', 'default');
}

/**
 * Check if header is sticky
 * 
 * @return bool
 */
function alomran_is_header_sticky() {
    return alomran_get_option('preset_header_sticky', true);
}

/**
 * Get footer style
 * 
 * @return string
 */
function alomran_get_footer_style() {
    return alomran_get_option('preset_footer_style', 'default');
}

/**
 * Get container width class
 * 
 * @return string
 */
function alomran_get_container_width_class() {
    $width = alomran_get_option('preset_container_width', 'standard');
    
    $classes = array(
        'full'      => 'max-w-full',
        'wide'      => 'max-w-7xl',
        'standard'  => 'max-w-6xl',
        'narrow'    => 'max-w-4xl',
    );
    
    return isset($classes[$width]) ? $classes[$width] : $classes['standard'];
}

/**
 * Get container width value in pixels
 * 
 * @return string
 */
function alomran_get_container_width_value() {
    $width = alomran_get_option('preset_container_width', 'standard');
    
    $values = array(
        'full'      => '100%',
        'wide'      => '1400px',
        'standard'  => '1200px',
        'narrow'    => '960px',
    );
    
    return isset($values[$width]) ? $values[$width] : $values['standard'];
}

/**
 * Get content layout class
 * 
 * @return string
 */
function alomran_get_content_layout_class() {
    $layout = alomran_get_option('preset_content_layout', 'boxed');
    
    return $layout === 'fullwidth' ? 'w-full' : 'container mx-auto px-4';
}

/**
 * Convert hex color to RGB string
 */
function alomran_hex_to_rgb($hex) {
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    return hexdec(substr($hex, 0, 2)) . ', ' . hexdec(substr($hex, 2, 2)) . ', ' . hexdec(substr($hex, 4, 2));
}

/**
 * Output preset CSS variables
 */
function alomran_output_preset_css() {
    $preset = alomran_get_theme_preset();
    $colors = alomran_get_preset_colors();
    $font_family = alomran_get_font_family();
    $font_weight = alomran_get_font_weight();
    $container_width = alomran_get_container_width_value();
    $header_style = alomran_get_header_style();
    $footer_style = alomran_get_footer_style();
    $content_layout = alomran_get_option('preset_content_layout', 'boxed');
    
    // Map font families to Google Fonts URLs
    $font_urls = array(
        'cairo'     => 'https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap',
        'tajawal'   => 'https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap',
        'almarai'   => 'https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap',
        'changa'    => 'https://fonts.googleapis.com/css2?family=Changa:wght@200;300;400;500;600;700;800&display=swap',
        'amiri'     => 'https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap',
    );
    
    $font_families = array(
        'cairo'     => 'Cairo, sans-serif',
        'tajawal'   => 'Tajawal, sans-serif',
        'almarai'   => 'Almarai, sans-serif',
        'changa'    => 'Changa, sans-serif',
        'amiri'     => 'Amiri, serif',
    );
    
    // Convert hex to RGB for opacity variants
    $primary_rgb = alomran_hex_to_rgb($colors['primary']);
    $secondary_rgb = alomran_hex_to_rgb($colors['secondary']);
    $accent_rgb = alomran_hex_to_rgb($colors['accent']);
    $white_rgb = '255, 255, 255'; // For white text on accent backgrounds
    
    ?>
    <style id="alomran-preset-styles">
        :root {
            /* Preset Colors */
            --theme-primary: <?php echo esc_attr($colors['primary']); ?>;
            --theme-secondary: <?php echo esc_attr($colors['secondary']); ?>;
            --theme-accent: <?php echo esc_attr($colors['accent']); ?>;
            --theme-background: <?php echo esc_attr($colors['background']); ?>;
            --theme-text: <?php echo esc_attr($colors['text']); ?>;
            --theme-text-light: <?php echo esc_attr($colors['text_light']); ?>;
            
            /* RGB values for opacity variants */
            --theme-primary-rgb: <?php echo $primary_rgb; ?>;
            --theme-secondary-rgb: <?php echo $secondary_rgb; ?>;
            --theme-accent-rgb: <?php echo $accent_rgb; ?>;
            --theme-white-rgb: <?php echo $white_rgb; ?>;
            
            /* Neutral Colors - Derived from preset */
            --theme-white: #ffffff;
            --theme-black: #000000;
            --theme-gray-50: #f9fafb;
            --theme-gray-100: #f3f4f6;
            --theme-gray-200: #e5e7eb;
            --theme-gray-300: #d1d5db;
            --theme-gray-400: #9ca3af;
            --theme-gray-500: #6b7280;
            --theme-gray-600: #4b5563;
            --theme-gray-700: #374151;
            --theme-gray-800: #1f2937;
            --theme-gray-900: #111827;
            --theme-slate-50: #f8fafc;
            --theme-slate-100: #f1f5f9;
            --theme-slate-200: #e2e8f0;
            --theme-slate-300: #cbd5e1;
            --theme-slate-400: #94a3b8;
            --theme-slate-500: #64748b;
            --theme-slate-600: #475569;
            --theme-slate-700: #334155;
            --theme-slate-800: #1e293b;
            --theme-slate-900: #0f172a;
            
            /* Semantic Colors */
            --theme-success: rgba(var(--theme-secondary-rgb), 0.1);
            --theme-success-text: var(--theme-secondary);
            --theme-warning: rgba(239, 68, 68, 0.1);
            --theme-warning-text: rgb(220, 38, 38);
            --theme-error: rgba(239, 68, 68, 0.1);
            --theme-error-text: rgb(220, 38, 38);
            
            /* Typography */
            --theme-font-family: <?php echo esc_attr($font_families[$font_family] ?? $font_families['cairo']); ?>;
            --theme-font-weight: <?php echo esc_attr($font_weight); ?>;
            
            /* Layout */
            --theme-container-width: <?php echo esc_attr($container_width); ?>;
            
            /* Legacy support - keep old variable names */
            --preset-primary: var(--theme-primary);
            --preset-secondary: var(--theme-secondary);
            --preset-accent: var(--theme-accent);
            --preset-font-family: var(--theme-font-family);
            --preset-font-weight: var(--theme-font-weight);
        }
        
        /* Global Typography */
        body {
            font-family: var(--theme-font-family);
            font-weight: var(--theme-font-weight);
            background-color: var(--theme-background);
            color: var(--theme-text);
        }
        
        /* Container Width */
        .container,
        .alomran-container {
            max-width: var(--theme-container-width);
        }
        
        /* Color Utilities - Primary */
        .bg-primary,
        .bg-theme-primary {
            background-color: var(--theme-primary) !important;
        }
        
        .text-primary,
        .text-theme-primary {
            color: var(--theme-primary) !important;
        }
        
        .border-primary,
        .border-theme-primary {
            border-color: var(--theme-primary) !important;
        }
        
        /* Color Utilities - Secondary */
        .bg-secondary,
        .bg-theme-secondary {
            background-color: var(--theme-secondary) !important;
        }
        
        .text-secondary,
        .text-theme-secondary {
            color: var(--theme-secondary) !important;
        }
        
        .border-secondary,
        .border-theme-secondary {
            border-color: var(--theme-secondary) !important;
        }
        
        /* Color Utilities - Accent */
        .bg-accent,
        .bg-theme-accent {
            background-color: var(--theme-accent) !important;
        }
        
        .text-accent,
        .text-theme-accent {
            color: var(--theme-accent) !important;
        }
        
        .border-accent,
        .border-theme-accent {
            border-color: var(--theme-accent) !important;
        }
        
        /* Hover States - Primary */
        .hover\:bg-primary:hover,
        .hover\:bg-theme-primary:hover {
            background-color: var(--theme-primary) !important;
        }
        
        .hover\:bg-secondary:hover,
        .hover\:bg-theme-secondary:hover {
            background-color: var(--theme-secondary) !important;
        }
        
        .hover\:text-primary:hover,
        .hover\:text-theme-primary:hover {
            color: var(--theme-primary) !important;
        }
        
        .hover\:text-secondary:hover,
        .hover\:text-theme-secondary:hover {
            color: var(--theme-secondary) !important;
        }
        
        /* Hover States - Accent */
        .hover\:bg-accent:hover,
        .hover\:bg-theme-accent:hover {
            background-color: var(--theme-accent) !important;
        }
        
        .hover\:text-accent:hover,
        .hover\:text-theme-accent:hover {
            color: var(--theme-accent) !important;
        }
        
        .hover\:border-accent:hover,
        .hover\:border-theme-accent:hover {
            border-color: var(--theme-accent) !important;
        }
        
        /* Hover states for white/black */
        .hover\:bg-white:hover {
            background-color: var(--theme-white) !important;
        }
        
        .hover\:text-white:hover {
            color: var(--theme-white) !important;
        }
        
        .hover\:bg-gray-100:hover {
            background-color: var(--theme-gray-100) !important;
        }
        
        .hover\:text-gray-300:hover {
            color: var(--theme-gray-300) !important;
        }
        
        /* Opacity Variants */
        .bg-primary\/80,
        [class*="bg-primary/80"] {
            background-color: rgba(var(--theme-primary-rgb), 0.8) !important;
        }
        
        .bg-primary\/60,
        [class*="bg-primary/60"] {
            background-color: rgba(var(--theme-primary-rgb), 0.6) !important;
        }
        
        .bg-primary\/30,
        [class*="bg-primary/30"] {
            background-color: rgba(var(--theme-primary-rgb), 0.3) !important;
        }
        
        .bg-secondary\/10,
        [class*="bg-secondary/10"] {
            background-color: rgba(var(--theme-secondary-rgb), 0.1) !important;
        }
        
        .bg-secondary\/20,
        [class*="bg-secondary/20"] {
            background-color: rgba(var(--theme-secondary-rgb), 0.2) !important;
        }
        
        /* Accent Opacity Variants */
        .bg-accent\/90,
        [class*="bg-accent/90"] {
            background-color: rgba(var(--theme-accent-rgb), 0.9) !important;
        }
        
        .bg-accent\/80,
        [class*="bg-accent/80"] {
            background-color: rgba(var(--theme-accent-rgb), 0.8) !important;
        }
        
        .bg-accent\/60,
        [class*="bg-accent/60"] {
            background-color: rgba(var(--theme-accent-rgb), 0.6) !important;
        }
        
        .bg-accent\/30,
        [class*="bg-accent/30"] {
            background-color: rgba(var(--theme-accent-rgb), 0.3) !important;
        }
        
        .bg-accent\/20,
        [class*="bg-accent/20"] {
            background-color: rgba(var(--theme-accent-rgb), 0.2) !important;
        }
        
        .bg-accent\/10,
        [class*="bg-accent/10"] {
            background-color: rgba(var(--theme-accent-rgb), 0.1) !important;
        }
        
        /* Neutral Color Utilities */
        .bg-white { background-color: var(--theme-white) !important; }
        .text-white { color: var(--theme-white) !important; }
        .bg-black { background-color: var(--theme-black) !important; }
        .text-black { color: var(--theme-black) !important; }
        
        .bg-gray-50 { background-color: var(--theme-gray-50) !important; }
        .bg-gray-100 { background-color: var(--theme-gray-100) !important; }
        .bg-gray-200 { background-color: var(--theme-gray-200) !important; }
        .bg-gray-300 { background-color: var(--theme-gray-300) !important; }
        .bg-gray-400 { background-color: var(--theme-gray-400) !important; }
        .bg-gray-500 { background-color: var(--theme-gray-500) !important; }
        .bg-gray-600 { background-color: var(--theme-gray-600) !important; }
        .bg-gray-700 { background-color: var(--theme-gray-700) !important; }
        .bg-gray-800 { background-color: var(--theme-gray-800) !important; }
        .bg-gray-900 { background-color: var(--theme-gray-900) !important; }
        
        .text-gray-50 { color: var(--theme-gray-50) !important; }
        .text-gray-100 { color: var(--theme-gray-100) !important; }
        .text-gray-200 { color: var(--theme-gray-200) !important; }
        .text-gray-300 { color: var(--theme-gray-300) !important; }
        .text-gray-400 { color: var(--theme-gray-400) !important; }
        .text-gray-500 { color: var(--theme-gray-500) !important; }
        .text-gray-600 { color: var(--theme-gray-600) !important; }
        .text-gray-700 { color: var(--theme-gray-700) !important; }
        .text-gray-800 { color: var(--theme-gray-800) !important; }
        .text-gray-900 { color: var(--theme-gray-900) !important; }
        
        .border-gray-100 { border-color: var(--theme-gray-100) !important; }
        .border-gray-200 { border-color: var(--theme-gray-200) !important; }
        .border-gray-300 { border-color: var(--theme-gray-300) !important; }
        
        .bg-slate-800 { background-color: var(--theme-slate-800) !important; }
        .bg-slate-900 { background-color: var(--theme-slate-900) !important; }
        .text-slate-300 { color: var(--theme-slate-300) !important; }
        .text-slate-800 { color: var(--theme-slate-800) !important; }
        .border-slate-800 { border-color: var(--theme-slate-800) !important; }
        
        /* Header Styles */
        <?php if ($header_style === 'transparent') : ?>
        .header-transparent {
            background-color: transparent !important;
            position: absolute;
            width: 100%;
            z-index: 50;
        }
        <?php endif; ?>
        
        /* Footer Styles */
        <?php if ($footer_style === 'dark') : ?>
        .footer-dark {
            background-color: var(--theme-slate-900) !important;
            color: var(--theme-slate-300) !important;
        }
        <?php elseif ($footer_style === 'minimal') : ?>
        .footer-minimal {
            background-color: var(--theme-gray-100) !important;
            color: var(--theme-gray-700) !important;
        }
        <?php endif; ?>
        
        /* Interactive Elements - Use Accent for Highlights */
        a:hover,
        button:hover,
        .hover\:text-accent:hover {
            transition: color 0.2s ease;
        }
        
        /* Badge/Highlight Styles */
        .badge-accent,
        [class*="badge"] {
            background-color: var(--theme-accent);
            color: var(--theme-white);
        }
        
        /* Link Accent Hover */
        a.text-accent,
        a[class*="text-accent"] {
            color: var(--theme-accent);
        }
        
        a.text-accent:hover,
        a[class*="text-accent"]:hover {
            color: var(--theme-accent);
            opacity: 0.8;
        }
        
        /* Button Accent Styles */
        .btn-accent,
        button.btn-accent,
        a.btn-accent {
            background-color: var(--theme-accent);
            color: var(--theme-white);
            border-color: var(--theme-accent);
        }
        
        .btn-accent:hover,
        button.btn-accent:hover,
        a.btn-accent:hover {
            background-color: rgba(var(--theme-accent-rgb), 0.9);
            border-color: rgba(var(--theme-accent-rgb), 0.9);
        }
        
        .btn-accent-outline {
            background-color: transparent;
            color: var(--theme-accent);
            border-color: var(--theme-accent);
        }
        
        .btn-accent-outline:hover {
            background-color: var(--theme-accent);
            color: var(--theme-white);
        }
    </style>
    <?php
    
    // Enqueue Google Font if needed
    if (isset($font_urls[$font_family])) {
        wp_enqueue_style('alomran-preset-font', $font_urls[$font_family], array(), null);
    }
}
add_action('wp_head', 'alomran_output_preset_css', 20);

