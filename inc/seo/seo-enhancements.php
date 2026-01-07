<?php
/**
 * Additional SEO Enhancements
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Remove unnecessary WordPress meta tags that can hurt SEO
 */
function alomran_remove_unnecessary_meta_tags() {
    // Remove generator tag
    remove_action('wp_head', 'wp_generator');
    
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove wlwmanifest link
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Remove adjacent posts links (can cause duplicate content issues)
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
}
add_action('init', 'alomran_remove_unnecessary_meta_tags');

/**
 * Add robots meta tag based on page type
 */
function alomran_add_robots_meta() {
    // Don't add if already set by plugin
    if (has_action('wp_head', 'wp_robots')) {
        return;
    }
    
    $robots = array('index', 'follow', 'max-image-preview:large', 'max-snippet:-1', 'max-video-preview:-1');
    
    // Noindex for search results, 404, etc.
    if (is_search() || is_404()) {
        $robots = array('noindex', 'follow');
    }
    
    // Noindex for paginated pages (except first page)
    if (is_paged()) {
        $robots = array('noindex', 'follow');
    }
    
    echo '<meta name="robots" content="' . esc_attr(implode(', ', $robots)) . '">' . "\n";
}
add_action('wp_head', 'alomran_add_robots_meta', 1);

/**
 * Improve canonical URL handling
 */
function alomran_improve_canonical_url($canonical) {
    // Remove query parameters from canonical URL
    if ($canonical) {
        $canonical = strtok($canonical, '?');
    }
    
    return $canonical;
}
add_filter('get_canonical_url', 'alomran_improve_canonical_url');

/**
 * Add hreflang tags for multilingual support (if needed)
 */
function alomran_add_hreflang_tags() {
    // Only add if site has multiple languages
    $languages = apply_filters('wpml_active_languages', null);
    
    if (empty($languages) || count($languages) <= 1) {
        return;
    }
    
    $current_url = home_url($_SERVER['REQUEST_URI']);
    
    foreach ($languages as $lang) {
        $url = apply_filters('wpml_permalink', $current_url, $lang['code']);
        if ($url) {
            echo '<link rel="alternate" hreflang="' . esc_attr($lang['code']) . '" href="' . esc_url($url) . '">' . "\n";
        }
    }
    
    // Add x-default
    echo '<link rel="alternate" hreflang="x-default" href="' . esc_url(home_url('/')) . '">' . "\n";
}
add_action('wp_head', 'alomran_add_hreflang_tags', 2);

/**
 * Add preload for critical resources
 */
function alomran_preload_critical_resources() {
    // Preload critical CSS
    $tailwind_path = get_template_directory() . '/assets/css/tailwind.css';
    if (file_exists($tailwind_path)) {
        $tailwind_uri = get_template_directory_uri() . '/assets/css/tailwind.css';
        $tailwind_version = filemtime($tailwind_path);
        echo '<link rel="preload" href="' . esc_url($tailwind_uri) . '?ver=' . esc_attr($tailwind_version) . '" as="style">' . "\n";
    }
    
    // Preload fonts if using custom fonts
    $fonts = apply_filters('alomran_critical_fonts', array());
    foreach ($fonts as $font_url) {
        echo '<link rel="preload" href="' . esc_url($font_url) . '" as="font" type="font/woff2" crossorigin>' . "\n";
    }
    
    // Preload site icon for better performance
    $site_icon = get_site_icon_url(192);
    if ($site_icon) {
        echo '<link rel="preload" href="' . esc_url($site_icon) . '" as="image">' . "\n";
    }
}
add_action('wp_head', 'alomran_preload_critical_resources', 1);

/**
 * Add theme color meta tag for mobile browsers
 */
function alomran_add_theme_color_meta() {
    $theme_color = alomran_get_option('general_theme_color', '#D4AF37'); // brand-gold default
    echo '<meta name="theme-color" content="' . esc_attr($theme_color) . '">' . "\n";
    echo '<meta name="msapplication-TileColor" content="' . esc_attr($theme_color) . '">' . "\n";
    echo '<meta name="msapplication-config" content="' . esc_url(home_url('/browserconfig.xml')) . '">' . "\n";
}
add_action('wp_head', 'alomran_add_theme_color_meta', 1);

/**
 * Add apple-touch-icon meta tags
 */
function alomran_add_apple_touch_icons() {
    $icon_sizes = array(57, 60, 72, 76, 114, 120, 144, 152, 180);
    
    foreach ($icon_sizes as $size) {
        $icon_url = get_site_icon_url($size);
        if ($icon_url) {
            echo '<link rel="apple-touch-icon" sizes="' . esc_attr($size . 'x' . $size) . '" href="' . esc_url($icon_url) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'alomran_add_apple_touch_icons', 1);

/**
 * Add JSON-LD for FAQ schema (if FAQ content exists)
 */
function alomran_add_faq_schema() {
    // This can be extended to check for FAQ content
    $faq_content = apply_filters('alomran_faq_content', array());
    
    if (empty($faq_content)) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array(),
    );
    
    foreach ($faq_content as $faq) {
        if (isset($faq['question']) && isset($faq['answer'])) {
            $schema['mainEntity'][] = array(
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text' => $faq['answer'],
                ),
            );
        }
    }
    
    if (!empty($schema['mainEntity'])) {
        alomran_output_schema($schema);
    }
}
add_action('wp_head', 'alomran_add_faq_schema', 5);

/**
 * Optimize title tag length
 */
function alomran_optimize_title_tag($title) {
    // Limit title to 60 characters for better SEO
    if (mb_strlen($title) > 60) {
        $title = mb_substr($title, 0, 57) . '...';
    }
    
    return $title;
}
add_filter('wp_title', 'alomran_optimize_title_tag', 99);
add_filter('document_title_parts', function($title_parts) {
    $full_title = implode(' | ', $title_parts);
    if (mb_strlen($full_title) > 60) {
        // Adjust parts to fit within limit
        if (isset($title_parts['title']) && mb_strlen($title_parts['title']) > 40) {
            $title_parts['title'] = mb_substr($title_parts['title'], 0, 37) . '...';
        }
    }
    return $title_parts;
}, 99);

/**
 * Add security headers for better SEO and security
 */
function alomran_add_security_headers() {
    if (!headers_sent()) {
        // X-Content-Type-Options
        header('X-Content-Type-Options: nosniff');
        
        // X-Frame-Options
        header('X-Frame-Options: SAMEORIGIN');
        
        // Referrer-Policy
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'alomran_add_security_headers');


