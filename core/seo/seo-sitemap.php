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
        $sitemap .= '<url>' . "\n";
        $sitemap .= '<loc>' . esc_url(get_permalink($product->ID)) . '</loc>' . "\n";
        $sitemap .= '<lastmod>' . get_the_modified_date('Y-m-d', $product->ID) . '</lastmod>' . "\n";
        $sitemap .= '<changefreq>weekly</changefreq>' . "\n";
        $sitemap .= '<priority>0.9</priority>' . "\n";
        
        if (has_post_thumbnail($product->ID)) {
            $image_url = get_the_post_thumbnail_url($product->ID, 'large');
            $sitemap .= '<image:image>' . "\n";
            $sitemap .= '<image:loc>' . esc_url($image_url) . '</image:loc>' . "\n";
            $sitemap .= '<image:title>' . esc_html(get_the_title($product->ID)) . '</image:title>' . "\n";
            $sitemap .= '</image:image>' . "\n";
        }
        
        $sitemap .= '</url>' . "\n";
    }
    
    // News
    $news = get_posts(array(
        'post_type' => 'news',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ));
    
    foreach ($news as $news_item) {
        $sitemap .= '<url>' . "\n";
        $sitemap .= '<loc>' . esc_url(get_permalink($news_item->ID)) . '</loc>' . "\n";
        $sitemap .= '<lastmod>' . get_the_modified_date('Y-m-d', $news_item->ID) . '</lastmod>' . "\n";
        $sitemap .= '<changefreq>weekly</changefreq>' . "\n";
        $sitemap .= '<priority>0.8</priority>' . "\n";
        
        if (has_post_thumbnail($news_item->ID)) {
            $image_url = get_the_post_thumbnail_url($news_item->ID, 'large');
            $sitemap .= '<image:image>' . "\n";
            $sitemap .= '<image:loc>' . esc_url($image_url) . '</image:loc>' . "\n";
            $sitemap .= '<image:title>' . esc_html(get_the_title($news_item->ID)) . '</image:title>' . "\n";
            $sitemap .= '</image:image>' . "\n";
        }
        
        $sitemap .= '</url>' . "\n";
    }
    
    // Archives
    $sitemap .= '<url>' . "\n";
    $sitemap .= '<loc>' . esc_url(get_post_type_archive_link('product')) . '</loc>' . "\n";
    $sitemap .= '<changefreq>weekly</changefreq>' . "\n";
    $sitemap .= '<priority>0.7</priority>' . "\n";
    $sitemap .= '</url>' . "\n";
    
    $sitemap .= '<url>' . "\n";
    $sitemap .= '<loc>' . esc_url(get_post_type_archive_link('news')) . '</loc>' . "\n";
    $sitemap .= '<changefreq>weekly</changefreq>' . "\n";
    $sitemap .= '<priority>0.7</priority>' . "\n";
    $sitemap .= '</url>' . "\n";
    
    // Categories
    $categories = get_terms(array(
        'taxonomy' => 'product_category',
        'hide_empty' => true,
    ));
    
    foreach ($categories as $category) {
        $sitemap .= '<url>' . "\n";
        $sitemap .= '<loc>' . esc_url(get_term_link($category)) . '</loc>' . "\n";
        $sitemap .= '<changefreq>monthly</changefreq>' . "\n";
        $sitemap .= '<priority>0.6</priority>' . "\n";
        $sitemap .= '</url>' . "\n";
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
    $output .= "\nSitemap: " . home_url('/?sitemap=xml') . "\n";
    return $output;
}
add_filter('robots_txt', 'alomran_add_sitemap_to_robots');

