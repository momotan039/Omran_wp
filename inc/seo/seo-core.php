<?php
/**
 * Core SEO Functions
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get SEO meta data for current page
 *
 * @return array
 */
function alomran_get_seo_meta() {
    $meta = array(
        'title'       => '',
        'description' => '',
        'image'       => '',
        'type'        => 'website',
        'url'         => '',
        'site_name'   => get_bloginfo('name'),
    );
    
    if (is_singular()) {
        $post_id = get_the_ID();
        $meta['title'] = get_the_title() . ' | ' . get_bloginfo('name');
        $meta['description'] = alomran_get_auto_excerpt($post_id, 30);
        $meta['image'] = has_post_thumbnail() ? get_the_post_thumbnail_url($post_id, 'large') : '';
        $meta['url'] = get_permalink();
        $meta['type'] = is_single() ? 'article' : 'website';
        
        if (is_single()) {
            $meta['published_time'] = get_the_date('c');
            $meta['modified_time'] = get_the_modified_date('c');
            $meta['author'] = get_the_author();
        }
    } elseif (is_archive()) {
        $meta['title'] = get_the_archive_title() . ' | ' . get_bloginfo('name');
        $meta['description'] = get_the_archive_description() ?: get_bloginfo('description');
        $meta['url'] = alomran_get_archive_url();
    } elseif (is_home() || is_front_page()) {
        $meta['title'] = get_bloginfo('name') . ' | ' . get_bloginfo('description');
        $meta['description'] = get_bloginfo('description');
        $meta['url'] = home_url('/');
    } else {
        $meta['title'] = wp_get_document_title();
        $meta['description'] = get_bloginfo('description');
        $meta['url'] = home_url($_SERVER['REQUEST_URI']);
    }
    
    // Fallback for image
    if (empty($meta['image'])) {
        $meta['image'] = get_site_icon_url(512) ?: '';
    }
    
    return $meta;
}

/**
 * Output SEO meta tags in head
 */
function alomran_output_seo_meta() {
    $meta = alomran_get_seo_meta();
    
    // Basic Meta Tags
    echo '<meta name="description" content="' . esc_attr($meta['description']) . '">' . "\n";
    echo '<link rel="canonical" href="' . esc_url($meta['url']) . '">' . "\n";
    
    // Open Graph
    echo '<meta property="og:title" content="' . esc_attr($meta['title']) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($meta['description']) . '">' . "\n";
    echo '<meta property="og:type" content="' . esc_attr($meta['type']) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($meta['url']) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr($meta['site_name']) . '">' . "\n";
    if (!empty($meta['image'])) {
        echo '<meta property="og:image" content="' . esc_url($meta['image']) . '">' . "\n";
        echo '<meta property="og:image:width" content="1200">' . "\n";
        echo '<meta property="og:image:height" content="630">' . "\n";
    }
    
    if (isset($meta['published_time'])) {
        echo '<meta property="article:published_time" content="' . esc_attr($meta['published_time']) . '">' . "\n";
    }
    if (isset($meta['modified_time'])) {
        echo '<meta property="article:modified_time" content="' . esc_attr($meta['modified_time']) . '">' . "\n";
    }
    if (isset($meta['author'])) {
        echo '<meta property="article:author" content="' . esc_attr($meta['author']) . '">' . "\n";
    }
    
    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($meta['title']) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($meta['description']) . '">' . "\n";
    if (!empty($meta['image'])) {
        echo '<meta name="twitter:image" content="' . esc_url($meta['image']) . '">' . "\n";
    }
}
add_action('wp_head', 'alomran_output_seo_meta', 1);

/**
 * Generate breadcrumbs schema
 *
 * @return array
 */
function alomran_get_breadcrumbs_schema() {
    $breadcrumbs = array(
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => array(),
    );
    
    $position = 1;
    
    // Home
    $breadcrumbs['itemListElement'][] = array(
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => 'الرئيسية',
        'item' => home_url('/'),
    );
    
    if (is_singular('product')) {
        // Products Archive
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => 'المنتجات',
            'item' => get_post_type_archive_link('product') ?: home_url('/products'),
        );
        
        // Current Product
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    } elseif (is_singular('news')) {
        // News Archive
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => 'الأخبار',
            'item' => get_post_type_archive_link('news') ?: home_url('/news'),
        );
        
        // Current News
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    } elseif (is_page()) {
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    } elseif (is_archive()) {
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_archive_title(),
            'item' => alomran_get_archive_url(),
        );
    }
    
    return $breadcrumbs;
}

/**
 * Output breadcrumbs schema
 */
function alomran_output_breadcrumbs_schema() {
    $schema = alomran_get_breadcrumbs_schema();
    if (!empty($schema['itemListElement'])) {
        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo "\n" . '</script>' . "\n";
    }
}
add_action('wp_head', 'alomran_output_breadcrumbs_schema', 2);

/**
 * Generate Organization schema
 *
 * @return array
 */
function alomran_get_organization_schema() {
    $company_info = alomran_get_company_info();
    
    return array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $company_info['name'],
        'url' => home_url('/'),
        'logo' => get_site_icon_url(512) ?: '',
        'description' => $company_info['slogan'],
        'address' => array(
            '@type' => 'PostalAddress',
            'addressCountry' => 'EG',
            'addressLocality' => $company_info['address'],
        ),
        'contactPoint' => array(
            '@type' => 'ContactPoint',
            'telephone' => $company_info['phone'],
            'email' => $company_info['email'],
            'contactType' => 'customer service',
        ),
        'sameAs' => alomran_get_social_media_urls(),
    );
}

/**
 * Get social media URLs from Redux
 *
 * @return array
 */
function alomran_get_social_media_urls() {
    $urls = array();
    $social_media = array('facebook', 'linkedin', 'instagram', 'twitter', 'youtube', 'whatsapp');
    
    foreach ($social_media as $platform) {
        $url = alomran_get_option('footer_social_' . $platform, '');
        if (!empty($url)) {
            $urls[] = esc_url($url);
        }
    }
    
    return $urls;
}

/**
 * Output Organization schema
 */
function alomran_output_organization_schema() {
    if (is_front_page() || is_home()) {
        $schema = alomran_get_organization_schema();
        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo "\n" . '</script>' . "\n";
    }
}
add_action('wp_head', 'alomran_output_organization_schema', 3);

