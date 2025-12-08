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
    
    $colors = array(
        'primary'   => alomran_get_option('preset_' . $preset . '_primary', '#2c5530'),
        'secondary' => alomran_get_option('preset_' . $preset . '_secondary', '#4a7c59'),
        'accent'    => alomran_get_option('preset_' . $preset . '_accent', '#f59e0b'),
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
 * Get content layout class
 * 
 * @return string
 */
function alomran_get_content_layout_class() {
    $layout = alomran_get_option('preset_content_layout', 'boxed');
    
    return $layout === 'fullwidth' ? 'w-full' : 'container mx-auto px-4';
}

/**
 * Output preset CSS variables
 */
function alomran_output_preset_css() {
    $colors = alomran_get_preset_colors();
    $font_family = alomran_get_font_family();
    $font_weight = alomran_get_font_weight();
    
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
    
    ?>
    <style id="alomran-preset-styles">
        :root {
            --preset-primary: <?php echo esc_attr($colors['primary']); ?>;
            --preset-secondary: <?php echo esc_attr($colors['secondary']); ?>;
            --preset-accent: <?php echo esc_attr($colors['accent']); ?>;
            --preset-font-family: <?php echo esc_attr($font_families[$font_family] ?? $font_families['cairo']); ?>;
            --preset-font-weight: <?php echo esc_attr($font_weight); ?>;
        }
        
        body {
            font-family: var(--preset-font-family);
            font-weight: var(--preset-font-weight);
        }
        
        .bg-primary {
            background-color: var(--preset-primary) !important;
        }
        
        .text-primary {
            color: var(--preset-primary) !important;
        }
        
        .bg-secondary {
            background-color: var(--preset-secondary) !important;
        }
        
        .text-secondary {
            color: var(--preset-secondary) !important;
        }
        
        .bg-accent {
            background-color: var(--preset-accent) !important;
        }
        
        .text-accent {
            color: var(--preset-accent) !important;
        }
        
        .border-primary {
            border-color: var(--preset-primary) !important;
        }
        
        .border-secondary {
            border-color: var(--preset-secondary) !important;
        }
        
        .border-accent {
            border-color: var(--preset-accent) !important;
        }
    </style>
    <?php
    
    // Enqueue Google Font if needed
    if (isset($font_urls[$font_family])) {
        wp_enqueue_style('alomran-preset-font', $font_urls[$font_family], array(), null);
    }
}
add_action('wp_head', 'alomran_output_preset_css', 20);

