<?php
/**
 * SEO & Accessibility Enhancements
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add skip to content link for accessibility
 */
function alomran_skip_to_content_link() {
    echo '<a class="sr-only focus:not-sr-only focus:absolute focus:top-0 focus:left-0 focus:z-[9999] focus:bg-brand-gold focus:text-brand-black focus:p-4 focus:font-bold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-gold" href="#main" aria-label="' . esc_attr__('انتقل إلى المحتوى الرئيسي', 'alomran') . '">' . __('انتقل إلى المحتوى', 'alomran') . '</a>';
}
add_action('wp_body_open', 'alomran_skip_to_content_link', 1);


/**
 * Add ARIA labels to navigation menus
 */
function alomran_add_nav_aria_labels($args) {
    if (!isset($args['container_aria_label'])) {
        $args['container_aria_label'] = __('القائمة الرئيسية', 'alomran');
    }
    return $args;
}
add_filter('wp_nav_menu_args', 'alomran_add_nav_aria_labels');

// Image alt text is handled in seo-images.php to avoid duplication

/**
 * Add proper lang attribute to html tag
 */
function alomran_html_lang_attribute($output) {
    // Ensure lang attribute is set
    if (strpos($output, 'lang=') === false) {
        $output = str_replace('<html ', '<html lang="' . get_locale() . '" ', $output);
    }
    return $output;
}
add_filter('language_attributes', 'alomran_html_lang_attribute');

/**
 * Add structured data for accessibility
 */
function alomran_add_accessibility_schema() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'accessibilityFeature' => array(
            'ARIA',
            'keyboardNavigation',
            'screenReader',
            'highContrastDisplay',
            'largePrint',
        ),
        'accessibilityHazard' => 'none',
        'accessibilitySummary' => __('هذا الموقع متوافق مع معايير الوصول والاستخدام WCAG 2.1', 'alomran'),
        'accessibilityAPI' => 'ARIA',
        'accessibilityControl' => array(
            'fullKeyboardControl',
            'fullMouseControl',
            'fullTouchControl',
        ),
    );
    
    alomran_output_schema($schema);
}
add_action('wp_head', 'alomran_add_accessibility_schema', 5);

