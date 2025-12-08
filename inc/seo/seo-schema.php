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
 * Generate Product schema (multi-industry support)
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
    $industry_type = alomran_get_product_industry_type($product_id);
    $dimensions = alomran_get_product_dimensions($product_id);
    $specs = alomran_get_product_technical_specs($product_id);
    $certifications = alomran_get_product_certifications($product_id);
    
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
    );
    
    // Add offers if price is available
    if (!empty($price) && is_numeric(str_replace(array('EGP', 'ج.م', ',', ' '), '', $price))) {
        $clean_price = preg_replace('/[^0-9.]/', '', $price);
        if (!empty($clean_price)) {
            $schema['offers'] = array(
                '@type' => 'Offer',
                'url' => get_permalink($product_id),
                'priceCurrency' => 'EGP',
                'availability' => 'https://schema.org/InStock',
                'price' => $clean_price,
            );
        }
    } else {
        // Even without price, add basic offer
        $schema['offers'] = array(
            '@type' => 'Offer',
            'url' => get_permalink($product_id),
            'availability' => 'https://schema.org/InStock',
        );
    }
    
    // Add categories
    if ($categories && !is_wp_error($categories)) {
        $schema['category'] = array();
        foreach ($categories as $category) {
            $schema['category'][] = $category->name;
        }
    }
    
    // Add additional properties based on industry
    if ($industry_type === 'food') {
        $ingredients = alomran_get_product_ingredients($product_id);
        if (!empty($ingredients)) {
            $schema['nutrition'] = array(
                '@type' => 'NutritionInformation',
            );
        }
    }
    
    // Add dimensions if available
    if ($dimensions) {
        $schema['size'] = alomran_format_dimensions($dimensions);
    }
    
    // Add technical specifications
    if (!empty($specs)) {
        $schema['additionalProperty'] = array();
        foreach ($specs as $spec) {
            $schema['additionalProperty'][] = array(
                '@type' => 'PropertyValue',
                'name' => $spec['label'],
                'value' => $spec['value'],
            );
        }
    }
    
    // Add certifications
    if (!empty($certifications)) {
        $schema['award'] = array();
        foreach ($certifications as $cert) {
            $schema['award'][] = $cert['name'];
        }
    }
    
    return $schema;
}

/**
 * Generate Service schema
 *
 * @param int $service_id Service/Page ID.
 * @return array
 */
function alomran_get_service_schema($service_id = null) {
    if (!$service_id) {
        $service_id = get_the_ID();
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => get_the_title($service_id),
        'description' => alomran_get_auto_excerpt($service_id, 30),
        'provider' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'url' => home_url('/'),
        ),
        'areaServed' => array(
            '@type' => 'Country',
            'name' => 'Egypt',
        ),
    );
    
    $image = has_post_thumbnail($service_id) ? get_the_post_thumbnail_url($service_id, 'large') : '';
    if ($image) {
        $schema['image'] = $image;
    }
    
    return $schema;
}

/**
 * Generate Project schema
 *
 * @param int $project_id Project ID.
 * @return array
 */
function alomran_get_project_schema($project_id = null) {
    if (!$project_id) {
        $project_id = get_the_ID();
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'CreativeWork',
        'name' => get_the_title($project_id),
        'description' => alomran_get_auto_excerpt($project_id, 30),
        'creator' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
        ),
        'datePublished' => get_the_date('c', $project_id),
    );
    
    $image = has_post_thumbnail($project_id) ? get_the_post_thumbnail_url($project_id, 'large') : '';
    if ($image) {
        $schema['image'] = $image;
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
 * Output schema for current page (multi-industry support)
 */
function alomran_output_page_schema() {
    $schemas = array();
    
    // Always output Organization schema on homepage
    if (is_front_page() || is_home()) {
        $schemas[] = alomran_get_website_schema();
        $schemas[] = alomran_get_organization_schema();
    }
    
    // Content-specific schemas
    if (is_singular('product')) {
        $schemas[] = alomran_get_product_schema();
    } elseif (is_singular('news')) {
        $schemas[] = alomran_get_news_article_schema();
    } elseif (is_page()) {
        // Check if page is a service page (can be determined by template or custom field)
        $page_template = get_page_template_slug();
        if (strpos($page_template, 'service') !== false || get_field('is_service')) {
            $schemas[] = alomran_get_service_schema();
        } else {
            $schemas[] = alomran_get_article_schema();
        }
    } elseif (is_singular()) {
        $schemas[] = alomran_get_article_schema();
    }
    
    // Output all schemas
    foreach ($schemas as $schema) {
        if (!empty($schema)) {
            echo '<script type="application/ld+json">' . "\n";
            echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            echo "\n" . '</script>' . "\n";
        }
    }
}
add_action('wp_head', 'alomran_output_page_schema', 4);

