<?php
/**
 * Schema.org Structured Data
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Generate Article schema for single posts
 *
 * @param int $post_id Post ID.
 * @return array
 */
function alomran_get_article_schema($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $post = get_post($post_id);
    if (!$post) {
        return array();
    }
    
    $author_id = $post->post_author;
    $author_name = get_the_author_meta('display_name', $author_id);
    $image = has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, 'large') : '';
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => get_the_title($post_id),
        'description' => alomran_get_auto_excerpt($post_id, 30),
        'datePublished' => get_the_date('c', $post_id),
        'dateModified' => get_the_modified_date('c', $post_id),
        'author' => array(
            '@type' => 'Person',
            'name' => $author_name,
        ),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'logo' => array(
                '@type' => 'ImageObject',
                'url' => get_site_icon_url(512) ?: '',
            ),
        ),
    );
    
    if (!empty($image)) {
        $schema['image'] = array(
            '@type' => 'ImageObject',
            'url' => $image,
            'width' => 1200,
            'height' => 630,
        );
    }
    
    return $schema;
}

/**
 * Generate Product schema
 *
 * @param int $product_id Product ID.
 * @return array
 */
function alomran_get_product_schema($product_id = null) {
    if (!$product_id) {
        $product_id = get_the_ID();
    }
    
    $price = get_field('price', $product_id) ?: '';
    $categories = get_the_terms($product_id, 'product_category');
    $image = has_post_thumbnail($product_id) ? get_the_post_thumbnail_url($product_id, 'large') : '';
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => get_the_title($product_id),
        'description' => alomran_get_auto_excerpt($product_id, 30),
        'image' => $image,
        'brand' => array(
            '@type' => 'Brand',
            'name' => get_bloginfo('name'),
        ),
        'offers' => array(
            '@type' => 'Offer',
            'url' => get_permalink($product_id),
            'priceCurrency' => 'EGP',
            'availability' => 'https://schema.org/InStock',
            'price' => $price,
        ),
    );
    
    if ($categories && !is_wp_error($categories)) {
        $schema['category'] = array();
        foreach ($categories as $category) {
            $schema['category'][] = $category->name;
        }
    }
    
    return $schema;
}

/**
 * Generate NewsArticle schema
 *
 * @param int $news_id News ID.
 * @return array
 */
function alomran_get_news_article_schema($news_id = null) {
    if (!$news_id) {
        $news_id = get_the_ID();
    }
    
    $schema = alomran_get_article_schema($news_id);
    $schema['@type'] = 'NewsArticle';
    
    return $schema;
}

/**
 * Generate WebSite schema with search action
 *
 * @return array
 */
function alomran_get_website_schema() {
    return array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => array(
                '@type' => 'EntryPoint',
                'urlTemplate' => home_url('/?s={search_term_string}'),
            ),
            'query-input' => 'required name=search_term_string',
        ),
    );
}

/**
 * Output schema for current page
 */
function alomran_output_page_schema() {
    if (is_singular('product')) {
        $schema = alomran_get_product_schema();
    } elseif (is_singular('news')) {
        $schema = alomran_get_news_article_schema();
    } elseif (is_singular()) {
        $schema = alomran_get_article_schema();
    } elseif (is_front_page() || is_home()) {
        $schema = alomran_get_website_schema();
    } else {
        return;
    }
    
    if (!empty($schema)) {
        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo "\n" . '</script>' . "\n";
    }
}
add_action('wp_head', 'alomran_output_page_schema', 4);

