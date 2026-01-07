<?php
/**
 * Content Processing Helpers
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get page by Arabic title or English slug.
 * This allows pages to be named in Arabic while still being findable.
 *
 * @param string $identifier Page title (Arabic) or slug (English).
 * @return WP_Post|null
 */
function alomran_get_page($identifier) {
    // First try to find by slug (English fallback)
    $page = get_page_by_path($identifier);
    
    if ($page) {
        return $page;
    }
    
    // If not found by slug, try to find by title (supports Arabic)
    global $wpdb;
    $page_id = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} 
        WHERE post_type = 'page' 
        AND post_status = 'publish' 
        AND post_title = %s 
        LIMIT 1",
        $identifier
    ));
    
    if ($page_id) {
        return get_post($page_id);
    }
    
    return null;
}

/**
 * Get page permalink by Arabic title or English slug.
 *
 * @param string $identifier Page title (Arabic) or slug (English).
 * @return string|false
 */
function alomran_get_page_url($identifier) {
    $page = alomran_get_page($identifier);
    return $page ? get_permalink($page) : false;
}

/**
 * Generate automatic excerpt from post content
 *
 * @param int|WP_Post $post Optional. Post ID or post object. Default is global $post.
 * @param int $length Optional. Excerpt length in words. Default 30.
 * @param string $more Optional. More text. Default '...'.
 * @return string Generated excerpt.
 */
function alomran_get_auto_excerpt($post = null, $length = 30, $more = '...') {
    $post = get_post($post);
    
    if (!$post) {
        return '';
    }
    
    // Try to get manual excerpt first
    if (!empty($post->post_excerpt)) {
        return wp_trim_words($post->post_excerpt, $length, $more);
    }
    
    // Generate from content
    $content = $post->post_content;
    
    // Remove shortcodes
    $content = strip_shortcodes($content);
    
    // Remove HTML tags
    $content = wp_strip_all_tags($content);
    
    // Trim whitespace
    $content = trim($content);
    
    // Generate excerpt
    $excerpt = wp_trim_words($content, $length, $more);
    
    return $excerpt;
}

