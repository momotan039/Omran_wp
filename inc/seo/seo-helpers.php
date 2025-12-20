<?php
/**
 * SEO Helper Functions
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get post description (excerpt or auto-generated)
 *
 * @param int $post_id Post ID.
 * @param int $words Number of words for auto-excerpt.
 * @return string
 */
function alomran_get_seo_description($post_id, $words = 30) {
    $description = get_the_excerpt($post_id);
    if (empty($description)) {
        $description = alomran_get_auto_excerpt($post_id, $words);
    }
    return $description;
}

/**
 * Get post image with dimensions
 *
 * @param int $post_id Post ID.
 * @param string $size Image size.
 * @return array|false Array with url, width, height or false.
 */
function alomran_get_seo_image($post_id, $size = 'large') {
    if (!has_post_thumbnail($post_id)) {
        return false;
    }
    
    $image_url = get_the_post_thumbnail_url($post_id, $size);
    $image_meta = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
    
    if (!$image_meta) {
        return array('url' => $image_url, 'width' => 1200, 'height' => 630);
    }
    
    return array(
        'url' => $image_url,
        'width' => $image_meta[1] ?: 1200,
        'height' => $image_meta[2] ?: 630,
    );
}

/**
 * Output JSON-LD schema
 *
 * @param array $schema Schema data.
 */
function alomran_output_schema($schema) {
    if (empty($schema)) {
        return;
    }
    
    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n" . '</script>' . "\n";
}

/**
 * Build contact points array from phone and email arrays
 *
 * @param array $phones Phone numbers.
 * @param array $emails Email addresses.
 * @param string $phone_type Contact type for phones.
 * @param string $email_type Contact type for emails.
 * @return array
 */
function alomran_build_contact_points($phones, $emails, $phone_type = 'customer service', $email_type = 'customer service') {
    $contact_points = array();
    
    if (!empty($phones) && is_array($phones)) {
        foreach ($phones as $phone) {
            if (!empty($phone)) {
                $contact_points[] = array(
                    '@type' => 'ContactPoint',
                    'telephone' => $phone,
                    'contactType' => $phone_type,
                );
            }
        }
    }
    
    if (!empty($emails) && is_array($emails)) {
        foreach ($emails as $email) {
            if (!empty($email)) {
                $contact_points[] = array(
                    '@type' => 'ContactPoint',
                    'email' => $email,
                    'contactType' => $email_type,
                );
            }
        }
    }
    
    return $contact_points;
}

/**
 * Get social media URLs for Food preset
 *
 * @return array
 */
function alomran_get_food_social_urls() {
    $urls = array();
    $platforms = array('instagram', 'facebook', 'twitter');
    
    foreach ($platforms as $platform) {
        $url = alomran_get_option('food_social_' . $platform, '');
        if (!empty($url)) {
            $urls[] = $url;
        }
    }
    
    return $urls;
}

/**
 * Add sitemap URL entry
 *
 * @param string $sitemap Sitemap string.
 * @param string $url URL.
 * @param string $lastmod Last modified date.
 * @param string $changefreq Change frequency.
 * @param float $priority Priority.
 * @param int|null $post_id Post ID for image.
 * @return string
 */
function alomran_add_sitemap_url($sitemap, $url, $lastmod, $changefreq, $priority, $post_id = null) {
    $sitemap .= '<url>' . "\n";
    $sitemap .= '<loc>' . esc_url($url) . '</loc>' . "\n";
    $sitemap .= '<lastmod>' . esc_html($lastmod) . '</lastmod>' . "\n";
    $sitemap .= '<changefreq>' . esc_html($changefreq) . '</changefreq>' . "\n";
    $sitemap .= '<priority>' . esc_html($priority) . '</priority>' . "\n";
    
    if ($post_id && has_post_thumbnail($post_id)) {
        $image_url = get_the_post_thumbnail_url($post_id, 'large');
        $sitemap .= '<image:image>' . "\n";
        $sitemap .= '<image:loc>' . esc_url($image_url) . '</image:loc>' . "\n";
        $sitemap .= '<image:title>' . esc_html(get_the_title($post_id)) . '</image:title>' . "\n";
        if ($excerpt = get_the_excerpt($post_id)) {
            $sitemap .= '<image:caption>' . esc_html($excerpt) . '</image:caption>' . "\n";
        }
        $sitemap .= '</image:image>' . "\n";
    }
    
    $sitemap .= '</url>' . "\n";
    return $sitemap;
}

