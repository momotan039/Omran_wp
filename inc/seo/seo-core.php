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
        'image_width' => 1200,
        'image_height' => 630,
        'type'        => 'website',
        'url'         => '',
        'site_name'   => get_bloginfo('name'),
        'locale'      => get_locale(),
    );
    
    if (is_singular()) {
        $post_id = get_the_ID();
        $meta['title'] = get_the_title() . ' | ' . get_bloginfo('name');
        
        // Get description from excerpt or generate from content
        $meta['description'] = get_the_excerpt($post_id);
        if (empty($meta['description'])) {
            $meta['description'] = alomran_get_auto_excerpt($post_id, 30);
        }
        // Limit description to 155-160 characters for optimal SEO
        $meta['description'] = wp_trim_words($meta['description'], 25, '');
        // Ensure it's not too long
        if (mb_strlen($meta['description']) > 160) {
            $meta['description'] = mb_substr($meta['description'], 0, 157) . '...';
        }
        
        // Get featured image with dimensions
        if (has_post_thumbnail($post_id)) {
            $thumbnail_id = get_post_thumbnail_id($post_id);
            $meta['image'] = get_the_post_thumbnail_url($post_id, 'large');
            $image_meta = wp_get_attachment_image_src($thumbnail_id, 'large');
            if ($image_meta) {
                $meta['image_width'] = $image_meta[1];
                $meta['image_height'] = $image_meta[2];
            }
        }
        
        $meta['url'] = get_permalink();
        $meta['type'] = is_single() ? 'article' : 'website';
        
        if (is_single()) {
            $meta['published_time'] = get_the_date('c');
            $meta['modified_time'] = get_the_modified_date('c');
            $author_id = get_post_field('post_author', $post_id);
            $meta['author'] = get_the_author_meta('display_name', $author_id);
            
            // Get categories/tags for article
            $categories = get_the_category($post_id);
            if ($categories) {
                $meta['categories'] = array();
                foreach ($categories as $category) {
                    $meta['categories'][] = $category->name;
                }
            }
        }
    } elseif (is_archive()) {
        $meta['title'] = wp_get_document_title();
        $meta['description'] = get_the_archive_description() ?: get_bloginfo('description');
        $meta['url'] = alomran_get_archive_url();
    } elseif (is_home() || is_front_page()) {
        $meta['title'] = get_bloginfo('name') . ' | ' . get_bloginfo('description');
        $meta['description'] = get_bloginfo('description') ?: __('موقعنا الرسمي', 'alomran');
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
    
    // Ensure description is not empty
    if (empty($meta['description'])) {
        $meta['description'] = get_bloginfo('description') ?: __('موقعنا الرسمي', 'alomran');
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
    echo '<meta name="author" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    echo '<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">' . "\n";
    echo '<link rel="canonical" href="' . esc_url($meta['url']) . '">' . "\n";
    
    // Open Graph
    echo '<meta property="og:locale" content="' . esc_attr($meta['locale']) . '">' . "\n";
    echo '<meta property="og:type" content="' . esc_attr($meta['type']) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($meta['title']) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($meta['description']) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($meta['url']) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr($meta['site_name']) . '">' . "\n";
    if (!empty($meta['image'])) {
        echo '<meta property="og:image" content="' . esc_url($meta['image']) . '">' . "\n";
        echo '<meta property="og:image:secure_url" content="' . esc_url($meta['image']) . '">' . "\n";
        echo '<meta property="og:image:width" content="' . esc_attr($meta['image_width']) . '">' . "\n";
        echo '<meta property="og:image:height" content="' . esc_attr($meta['image_height']) . '">' . "\n";
        echo '<meta property="og:image:alt" content="' . esc_attr($meta['title']) . '">' . "\n";
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
    if (isset($meta['categories']) && !empty($meta['categories'])) {
        foreach ($meta['categories'] as $category) {
            echo '<meta property="article:section" content="' . esc_attr($category) . '">' . "\n";
        }
    }
    
    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($meta['title']) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($meta['description']) . '">' . "\n";
    if (!empty($meta['image'])) {
        echo '<meta name="twitter:image" content="' . esc_url($meta['image']) . '">' . "\n";
        echo '<meta name="twitter:image:alt" content="' . esc_attr($meta['title']) . '">' . "\n";
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
    } elseif (is_singular('branch')) {
        // Branches Archive
        $branches_page = get_page_by_path('branches');
        if ($branches_page) {
            $breadcrumbs['itemListElement'][] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => get_the_title($branches_page->ID),
                'item' => get_permalink($branches_page->ID),
            );
        }
        
        // Current Branch
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    } elseif (is_singular('menu_item')) {
        // Menu Archive
        $menu_url = get_post_type_archive_link('menu_item');
        if ($menu_url) {
            $breadcrumbs['itemListElement'][] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => __('القائمة', 'alomran'),
                'item' => $menu_url,
            );
        }
        
        // Current Menu Item
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    } elseif (is_singular('blog_post')) {
        // Blog Archive
        $blog_url = get_post_type_archive_link('blog_post');
        if ($blog_url) {
            $breadcrumbs['itemListElement'][] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => __('المجلة', 'alomran'),
                'item' => $blog_url,
            );
        }
        
        // Current Post
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
        alomran_output_schema($schema);
    }
}
add_action('wp_head', 'alomran_output_breadcrumbs_schema', 2);

/**
 * Generate Organization schema
 *
 * @return array
 */
function alomran_get_organization_schema() {
    $preset = AlOmran_Preset_Loader::get_active_preset();
    
    // For Food preset, use food-specific data
    if ($preset === 'food') {
        $app_name_ar = alomran_get_option('food_app_name_ar', get_bloginfo('name'));
        $app_name_en = alomran_get_option('food_app_name_en', '');
        $address = alomran_get_option('food_contact_address_text', '');
        $phone = alomran_get_option('food_contact_phone_numbers', array());
        $email = alomran_get_option('food_contact_email_addresses', array());
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $app_name_ar,
            'url' => home_url('/'),
            'logo' => get_site_icon_url(512) ?: '',
            'description' => get_bloginfo('description'),
        );
        
        if (!empty($app_name_en)) {
            $schema['alternateName'] = $app_name_en;
        }
        
        // Address
        if (!empty($address)) {
            $schema['address'] = array(
                '@type' => 'PostalAddress',
                'addressCountry' => 'SA',
                'addressLocality' => 'الرياض',
                'streetAddress' => $address,
            );
        }
        
        // Contact points
        $contact_points = alomran_build_contact_points($phone, $email);
        if (!empty($contact_points)) {
            $schema['contactPoint'] = $contact_points;
        }
        
        // Social media
        $social_urls = alomran_get_food_social_urls();
        if (!empty($social_urls)) {
            $schema['sameAs'] = $social_urls;
        }
        
        return $schema;
    }
    
    // Default for other presets
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
        alomran_output_schema(alomran_get_organization_schema());
    }
}
add_action('wp_head', 'alomran_output_organization_schema', 3);

