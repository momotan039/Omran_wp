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
    $image_data = alomran_get_seo_image($post_id);
    $description = alomran_get_seo_description($post_id);
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => get_the_title($post_id),
        'description' => $description,
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
                'width' => 512,
                'height' => 512,
            ),
        ),
        'mainEntityOfPage' => array(
            '@type' => 'WebPage',
            '@id' => get_permalink($post_id),
        ),
    );
    
    if ($image_data) {
        $schema['image'] = array(
            '@type' => 'ImageObject',
            'url' => $image_data['url'],
            'width' => $image_data['width'],
            'height' => $image_data['height'],
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
    $image_data = alomran_get_seo_image($product_id);
    $industry_type = alomran_get_product_industry_type($product_id);
    $dimensions = alomran_get_product_dimensions($product_id);
    $specs = alomran_get_product_technical_specs($product_id);
    $certifications = alomran_get_product_certifications($product_id);
    $description = alomran_get_seo_description($product_id);
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => get_the_title($product_id),
        'description' => $description,
        'image' => $image_data ? $image_data['url'] : '',
        'brand' => array(
            '@type' => 'Brand',
            'name' => get_bloginfo('name'),
        ),
        'sku' => 'PROD-' . $product_id,
        'mpn' => 'PROD-' . $product_id,
    );
    
    // Add offers if price is available
    if (!empty($price) && is_numeric(str_replace(array('EGP', 'ج.م', ',', ' '), '', $price))) {
        $clean_price = preg_replace('/[^0-9.]/', '', $price);
        if (!empty($clean_price)) {
            $schema['offers'] = array(
                '@type' => 'Offer',
                'url' => get_permalink($product_id),
                'priceCurrency' => 'SAR',
                'availability' => 'https://schema.org/InStock',
                'price' => $clean_price,
                'priceValidUntil' => date('Y-m-d', strtotime('+1 year')),
                'itemCondition' => 'https://schema.org/NewCondition',
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
    
    $description = alomran_get_seo_description($service_id);
    $image_data = alomran_get_seo_image($service_id);
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => get_the_title($service_id),
        'description' => $description,
        'provider' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'url' => home_url('/'),
        ),
        'areaServed' => array(
            '@type' => 'Country',
            'name' => 'Saudi Arabia',
        ),
        'serviceType' => get_the_title($service_id),
    );
    
    if ($image_data) {
        $schema['image'] = $image_data['url'];
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
    
    $description = alomran_get_seo_description($project_id);
    $image_data = alomran_get_seo_image($project_id);
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'CreativeWork',
        'name' => get_the_title($project_id),
        'description' => $description,
        'creator' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
        ),
        'datePublished' => get_the_date('c', $project_id),
        'dateModified' => get_the_modified_date('c', $project_id),
    );
    
    if ($image_data) {
        $schema['image'] = $image_data['url'];
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
 * Generate Restaurant schema for Food preset
 *
 * @return array
 */
function alomran_get_restaurant_schema() {
    $preset = AlOmran_Preset_Loader::get_active_preset();
    if ($preset !== 'food') {
        return array();
    }
    
    $app_name_ar = alomran_get_option('food_app_name_ar', get_bloginfo('name'));
    $app_name_en = alomran_get_option('food_app_name_en', '');
    $address = alomran_get_option('food_contact_address_text', '');
    $phone = alomran_get_option('food_contact_phone_numbers', array());
    $email = alomran_get_option('food_contact_email_addresses', array());
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Restaurant',
        'name' => $app_name_ar,
        'url' => home_url('/'),
        'image' => get_site_icon_url(512) ?: '',
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
    
    // Contact
    $contact_points = alomran_build_contact_points($phone, $email, 'reservations', 'customer service');
    if (!empty($contact_points)) {
        $schema['contactPoint'] = $contact_points;
    }
    
    // Social media
    $social_urls = alomran_get_food_social_urls();
    if (!empty($social_urls)) {
        $schema['sameAs'] = $social_urls;
    }
    
    // Menu
    $menu_url = get_post_type_archive_link('menu_item');
    if ($menu_url) {
        $schema['hasMenu'] = array(
            '@type' => 'Menu',
            'url' => $menu_url,
        );
    }
    
    return $schema;
}

/**
 * Generate FoodEstablishment schema for branches
 *
 * @param int $branch_id Branch ID.
 * @return array
 */
function alomran_get_food_establishment_schema($branch_id = null) {
    if (!$branch_id) {
        $branch_id = get_the_ID();
    }
    
    if (get_post_type($branch_id) !== 'branch') {
        return array();
    }
    
    $city = alomran_food_get_branch_city($branch_id);
    $address = alomran_food_get_branch_address($branch_id);
    $phone = alomran_food_get_branch_phone($branch_id);
    $map_link = alomran_food_get_branch_map_link($branch_id);
    
    $image_data = alomran_get_seo_image($branch_id);
    $description = alomran_get_seo_description($branch_id) ?: get_the_title($branch_id);
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'FoodEstablishment',
        'name' => get_the_title($branch_id),
        'url' => get_permalink($branch_id),
        'image' => $image_data ? $image_data['url'] : '',
        'description' => $description,
    );
    
    // Address
    if (!empty($address)) {
        $schema['address'] = array(
            '@type' => 'PostalAddress',
            'addressCountry' => 'SA',
            'addressLocality' => $city ?: 'الرياض',
            'streetAddress' => $address,
        );
    }
    
    // Phone
    if (!empty($phone)) {
        $schema['telephone'] = $phone;
    }
    
    // Geo coordinates if map link exists
    if (!empty($map_link) && strpos($map_link, 'google.com/maps') !== false) {
        // Try to extract coordinates from Google Maps URL
        if (preg_match('/@(-?\d+\.?\d*),(-?\d+\.?\d*)/', $map_link, $matches)) {
            $schema['geo'] = array(
                '@type' => 'GeoCoordinates',
                'latitude' => floatval($matches[1]),
                'longitude' => floatval($matches[2]),
            );
        }
    }
    
    return $schema;
}

/**
 * Generate MenuItem schema
 *
 * @param int $menu_item_id Menu item ID.
 * @return array
 */
function alomran_get_menu_item_schema($menu_item_id = null) {
    if (!$menu_item_id) {
        $menu_item_id = get_the_ID();
    }
    
    if (get_post_type($menu_item_id) !== 'menu_item') {
        return array();
    }
    
    $price = alomran_food_get_menu_item_price($menu_item_id);
    $name_en = alomran_food_get_menu_item_name_en($menu_item_id);
    $categories = get_the_terms($menu_item_id, 'menu_category');
    $description = alomran_get_seo_description($menu_item_id) ?: get_the_title($menu_item_id);
    $image_data = alomran_get_seo_image($menu_item_id);
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'MenuItem',
        'name' => get_the_title($menu_item_id),
        'description' => $description,
        'image' => $image_data ? $image_data['url'] : '',
        'nutrition' => array(
            '@type' => 'NutritionInformation',
        ),
    );
    
    if (!empty($name_en)) {
        $schema['alternateName'] = $name_en;
    }
    
    // Price
    if (!empty($price)) {
        $clean_price = preg_replace('/[^0-9.]/', '', $price);
        if (!empty($clean_price)) {
            $schema['offers'] = array(
                '@type' => 'Offer',
                'price' => $clean_price,
                'priceCurrency' => 'SAR',
                'availability' => 'https://schema.org/InStock',
                'url' => get_permalink($menu_item_id),
            );
        }
    }
    
    // Menu category
    if ($categories && !is_wp_error($categories)) {
        $schema['menuAddOn'] = array();
        foreach ($categories as $category) {
            $schema['menuAddOn'][] = array(
                '@type' => 'MenuSection',
                'name' => $category->name,
            );
        }
    }
    
    return $schema;
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
        
        // Add Restaurant schema for Food preset
        $restaurant_schema = alomran_get_restaurant_schema();
        if (!empty($restaurant_schema)) {
            $schemas[] = $restaurant_schema;
        }
    }
    
    // Content-specific schemas
    if (is_singular('product')) {
        $schemas[] = alomran_get_product_schema();
    } elseif (is_singular('branch')) {
        $schemas[] = alomran_get_food_establishment_schema();
    } elseif (is_singular('menu_item')) {
        $schemas[] = alomran_get_menu_item_schema();
    } elseif (is_singular('news') || is_singular('blog_post')) {
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
        alomran_output_schema($schema);
    }
}
add_action('wp_head', 'alomran_output_page_schema', 4);

