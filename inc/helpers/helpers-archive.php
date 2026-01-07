<?php
/**
 * Archive Helpers
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get archive URL based on queried object type
 *
 * @return string Archive URL.
 */
function alomran_get_archive_url() {
    $queried_object = get_queried_object();
    
    // Check if it's a taxonomy term archive
    if ($queried_object && is_a($queried_object, 'WP_Term')) {
        $term_link = get_term_link($queried_object);
        if (!is_wp_error($term_link)) {
            return $term_link;
        }
    }
    
    // Check if it's a post type archive
    if (is_post_type_archive()) {
        $archive_link = get_post_type_archive_link(get_post_type());
        if ($archive_link) {
            return $archive_link;
        }
    }
    
    // Fallback
    return home_url($_SERVER['REQUEST_URI'] ?? '/');
}

/**
 * Get current taxonomy term if on taxonomy archive
 *
 * @param string $taxonomy Taxonomy name.
 * @return WP_Term|null Term object or null.
 */
function alomran_get_current_taxonomy_term($taxonomy) {
    if (!taxonomy_exists($taxonomy) || !is_tax($taxonomy)) {
        return null;
    }
    
    $term = get_queried_object();
    return ($term && is_a($term, 'WP_Term')) ? $term : null;
}

/**
 * Get category filter buttons HTML
 *
 * @param array  $categories Array of category term objects.
 * @param string $current_slug Current active category slug.
 * @param string $archive_url Archive base URL.
 * @param string $all_label Label for "All" button.
 * @return string HTML output.
 */
function alomran_get_category_filters_html($categories, $current_slug = '', $archive_url = '', $all_label = 'الكل') {
    if (empty($archive_url)) {
        $archive_url = home_url();
    }
    
    $html = '<div class="flex flex-wrap gap-2 justify-center md:justify-start">';
    
    // "All" button
    $is_all_active = empty($current_slug);
    $html .= sprintf(
        '<a href="%s" class="px-4 py-2 rounded-full text-sm font-bold transition-all %s">%s</a>',
        esc_url($archive_url),
        $is_all_active ? 'bg-primary text-white scale-105' : 'bg-gray-100 text-gray-600 hover:bg-gray-200',
        esc_html($all_label)
    );
    
    // Category buttons
    if (!empty($categories)) {
        foreach ($categories as $category) {
            if (!is_object($category) || !isset($category->slug) || !isset($category->name)) {
                continue;
            }
            
            $is_active = ($current_slug === $category->slug);
            $category_url = taxonomy_exists($category->taxonomy ?? '') ? get_term_link($category) : '';
            
            if (!is_wp_error($category_url) && !empty($category_url)) {
                $html .= sprintf(
                    '<a href="%s" class="px-4 py-2 rounded-full text-sm font-bold transition-all %s">%s</a>',
                    esc_url($category_url),
                    $is_active ? 'bg-primary text-white scale-105' : 'bg-gray-100 text-gray-600 hover:bg-gray-200',
                    esc_html($category->name)
                );
            }
        }
    }
    
    $html .= '</div>';
    return $html;
}

/**
 * Get first category name for a post
 *
 * @param int    $post_id Post ID.
 * @param string $taxonomy Taxonomy name.
 * @return string Category name or empty string.
 */
function alomran_get_first_category_name($post_id, $taxonomy) {
    if (!taxonomy_exists($taxonomy)) {
        return '';
    }
    
    $terms = get_the_terms($post_id, $taxonomy);
    if (is_wp_error($terms) || empty($terms)) {
        return '';
    }
    
    return esc_html($terms[0]->name);
}

