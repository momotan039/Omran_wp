<?php
/**
 * XML Sitemap Generation
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Generate XML sitemap
 */
function alomran_generate_sitemap() {
    if (!isset($_GET['sitemap']) || $_GET['sitemap'] !== 'xml') {
        return;
    }
    
    header('Content-Type: application/xml; charset=utf-8');
    
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";
    
    // Homepage
    $sitemap .= '<url>' . "\n";
    $sitemap .= '<loc>' . esc_url(home_url('/')) . '</loc>' . "\n";
    $sitemap .= '<lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    $sitemap .= '<changefreq>daily</changefreq>' . "\n";
    $sitemap .= '<priority>1.0</priority>' . "\n";
    $sitemap .= '</url>' . "\n";
    
    // Pages
    $pages = get_pages(array('post_status' => 'publish'));
    foreach ($pages as $page) {
        $sitemap .= '<url>' . "\n";
        $sitemap .= '<loc>' . esc_url(get_permalink($page->ID)) . '</loc>' . "\n";
        $sitemap .= '<lastmod>' . get_the_modified_date('Y-m-d', $page->ID) . '</lastmod>' . "\n";
        $sitemap .= '<changefreq>monthly</changefreq>' . "\n";
        $sitemap .= '<priority>0.8</priority>' . "\n";
        $sitemap .= '</url>' . "\n";
    }
    
    // Products
    $products = get_posts(array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ));
    
    foreach ($products as $product) {
        $sitemap = alomran_add_sitemap_url($sitemap, get_permalink($product->ID), get_the_modified_date('Y-m-d', $product->ID), 'weekly', '0.9', $product->ID);
    }
    
    // News
    $news = get_posts(array(
        'post_type' => 'news',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ));
    
    foreach ($news as $news_item) {
        $sitemap = alomran_add_sitemap_url($sitemap, get_permalink($news_item->ID), get_the_modified_date('Y-m-d', $news_item->ID), 'weekly', '0.8', $news_item->ID);
    }
    
    // Food Preset Post Types
    $food_post_types = array('branch', 'menu_item', 'blog_post');
    foreach ($food_post_types as $post_type) {
        if (post_type_exists($post_type)) {
            $posts = get_posts(array(
                'post_type' => $post_type,
                'posts_per_page' => -1,
                'post_status' => 'publish',
            ));
            
            foreach ($posts as $post) {
                $sitemap = alomran_add_sitemap_url($sitemap, get_permalink($post->ID), get_the_modified_date('Y-m-d', $post->ID), 'weekly', '0.8', $post->ID);
            }
            
            // Add archive link
            $archive_link = get_post_type_archive_link($post_type);
            if ($archive_link) {
                $sitemap .= '<url>' . "\n";
                $sitemap .= '<loc>' . esc_url($archive_link) . '</loc>' . "\n";
                $sitemap .= '<changefreq>weekly</changefreq>' . "\n";
                $sitemap .= '<priority>0.7</priority>' . "\n";
                $sitemap .= '</url>' . "\n";
            }
        }
    }
    
    // Archives
    if (post_type_exists('product')) {
        $sitemap .= '<url>' . "\n";
        $sitemap .= '<loc>' . esc_url(get_post_type_archive_link('product')) . '</loc>' . "\n";
        $sitemap .= '<changefreq>weekly</changefreq>' . "\n";
        $sitemap .= '<priority>0.7</priority>' . "\n";
        $sitemap .= '</url>' . "\n";
    }
    
    if (post_type_exists('news')) {
        $sitemap .= '<url>' . "\n";
        $sitemap .= '<loc>' . esc_url(get_post_type_archive_link('news')) . '</loc>' . "\n";
        $sitemap .= '<changefreq>weekly</changefreq>' . "\n";
        $sitemap .= '<priority>0.7</priority>' . "\n";
        $sitemap .= '</url>' . "\n";
    }
    
    // Categories and Taxonomies
    $taxonomies = array('product_category', 'menu_category');
    foreach ($taxonomies as $taxonomy) {
        if (taxonomy_exists($taxonomy)) {
            $terms = get_terms(array(
                'taxonomy' => $taxonomy,
                'hide_empty' => true,
            ));
            
            if (!is_wp_error($terms) && !empty($terms)) {
                foreach ($terms as $term) {
                    $sitemap .= '<url>' . "\n";
                    $sitemap .= '<loc>' . esc_url(get_term_link($term)) . '</loc>' . "\n";
                    $sitemap .= '<changefreq>monthly</changefreq>' . "\n";
                    $sitemap .= '<priority>0.6</priority>' . "\n";
                    $sitemap .= '</url>' . "\n";
                }
            }
        }
    }
    
    $sitemap .= '</urlset>';
    
    echo $sitemap;
    exit;
}
add_action('template_redirect', 'alomran_generate_sitemap');

/**
 * Add sitemap to robots.txt
 */
function alomran_add_sitemap_to_robots($output) {
    // Add sitemap reference
    $output .= "\nSitemap: " . home_url('/?sitemap=xml') . "\n";
    
    // Add user-agent rules for better SEO
    $output .= "\nUser-agent: *\n";
    $output .= "Allow: /\n";
    $output .= "Disallow: /wp-admin/\n";
    $output .= "Disallow: /wp-includes/\n";
    $output .= "Disallow: /wp-content/plugins/\n";
    $output .= "Disallow: /wp-content/themes/*/assets/\n";
    $output .= "Disallow: /*?*\n"; // Disallow query strings
    $output .= "Disallow: /search/\n";
    $output .= "Disallow: /feed/\n";
    
    // Allow important files
    $output .= "Allow: /wp-content/uploads/\n";
    $output .= "Allow: /wp-content/themes/*/assets/css/\n";
    $output .= "Allow: /wp-content/themes/*/assets/js/\n";
    
    return $output;
}
add_filter('robots_txt', 'alomran_add_sitemap_to_robots');

