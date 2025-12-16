<?php
/**
 * Preset Content Isolation
 * 
 * Isolates content between different presets - each preset only shows its own content
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Meta key for storing preset association
 */
define('ALOMRAN_PRESET_META_KEY', '_alomran_preset');

/**
 * Initialize preset content isolation
 */
function alomran_init_preset_isolation() {
    // Only on frontend
    if (is_admin()) {
        return;
    }
    
    // Filter queries to exclude other presets' content
    add_action('pre_get_posts', 'alomran_filter_preset_content', 10);
    
    // Filter menus to exclude other presets' menus
    add_filter('wp_get_nav_menu_items', 'alomran_filter_preset_menus', 10, 3);
    
    // Filter widgets (if needed)
    add_filter('widget_posts_args', 'alomran_filter_preset_widgets', 10, 1);
}
add_action('init', 'alomran_init_preset_isolation');

/**
 * Filter queries to show only current preset's content
 * 
 * @param WP_Query $query
 */
function alomran_filter_preset_content($query) {
    // Don't filter admin queries
    if (is_admin()) {
        return;
    }
    
    // Don't filter main query in admin
    if (!$query->is_main_query()) {
        // Only filter frontend queries
        if (!is_admin()) {
            alomran_apply_preset_filter($query);
        }
        return;
    }
    
    // Apply filter to main query on frontend
    if (!is_admin()) {
        alomran_apply_preset_filter($query);
    }
}

/**
 * Apply preset filter to query
 * 
 * @param WP_Query $query
 */
function alomran_apply_preset_filter($query) {
    $active_preset = AlOmran_Preset_Loader::get_active_preset();
    
    if (!$active_preset) {
        return;
    }
    
    // Get post types that should be filtered
    $filtered_post_types = array('page', 'post', 'product', 'news', 'testimonial', 'faq');
    
    // Check if this query is for a filtered post type
    $post_type = $query->get('post_type');
    
    // Handle array of post types
    if (is_array($post_type)) {
        $should_filter = false;
        foreach ($post_type as $pt) {
            if (in_array($pt, $filtered_post_types, true)) {
                $should_filter = true;
                break;
            }
        }
    } else {
        $should_filter = in_array($post_type, $filtered_post_types, true);
    }
    
    // Also filter if post_type is not set (defaults to 'post')
    if (empty($post_type)) {
        $should_filter = true;
    }
    
    if (!$should_filter) {
        return;
    }
    
    // Get meta query
    $meta_query = $query->get('meta_query');
    if (!is_array($meta_query)) {
        $meta_query = array();
    }
    
    // Add preset filter - show posts with current preset OR posts with no preset (backward compatibility)
    $meta_query['relation'] = 'OR';
    $meta_query[] = array(
        'key'     => ALOMRAN_PRESET_META_KEY,
        'value'   => $active_preset,
        'compare' => '=',
    );
    $meta_query[] = array(
        'key'     => ALOMRAN_PRESET_META_KEY,
        'compare' => 'NOT EXISTS',
    );
    
    $query->set('meta_query', $meta_query);
}

/**
 * Filter menu items to show only current preset's menus
 * 
 * @param array $items Menu items
 * @param object $menu Menu object
 * @param array $args Menu arguments
 * @return array Filtered menu items
 */
function alomran_filter_preset_menus($items, $menu, $args) {
    if (empty($items) || !is_array($items)) {
        return $items;
    }
    
    $active_preset = AlOmran_Preset_Loader::get_active_preset();
    
    if (!$active_preset) {
        return $items;
    }
    
    // Check if menu has preset meta
    $menu_preset = get_term_meta($menu->term_id, ALOMRAN_PRESET_META_KEY, true);
    
    // If menu has preset meta and it doesn't match, return empty
    if (!empty($menu_preset) && $menu_preset !== $active_preset) {
        return array();
    }
    
    // Filter menu items by their associated posts' presets
    $filtered_items = array();
    
    foreach ($items as $item) {
        // Skip custom links and other non-post items
        if ($item->type !== 'post_type' && $item->type !== 'taxonomy') {
            // Allow custom links and other items
            $filtered_items[] = $item;
            continue;
        }
        
        // For post type items, check the post's preset
        if ($item->type === 'post_type' && !empty($item->object_id)) {
            $post_preset = get_post_meta($item->object_id, ALOMRAN_PRESET_META_KEY, true);
            
            // If post has no preset meta, allow it (backward compatibility)
            // If post has preset meta, it must match active preset
            if (empty($post_preset) || $post_preset === $active_preset) {
                $filtered_items[] = $item;
            }
        } else {
            // For taxonomy items, allow them (categories, etc.)
            $filtered_items[] = $item;
        }
    }
    
    return $filtered_items;
}

/**
 * Filter widget queries to show only current preset's content
 * 
 * @param array $args Widget query arguments
 * @return array Filtered arguments
 */
function alomran_filter_preset_widgets($args) {
    $active_preset = AlOmran_Preset_Loader::get_active_preset();
    
    if (!$active_preset) {
        return $args;
    }
    
    if (!isset($args['meta_query'])) {
        $args['meta_query'] = array();
    }
    
    $args['meta_query'][] = array(
        'key'     => ALOMRAN_PRESET_META_KEY,
        'value'   => $active_preset,
        'compare' => '=',
    );
    
    return $args;
}

/**
 * Set preset meta for a post
 * 
 * @param int $post_id Post ID
 * @param string $preset Preset name
 * @return bool|int Meta ID on success, false on failure
 */
function alomran_set_post_preset($post_id, $preset) {
    return update_post_meta($post_id, ALOMRAN_PRESET_META_KEY, sanitize_text_field($preset));
}

/**
 * Get preset meta for a post
 * 
 * @param int $post_id Post ID
 * @return string|false Preset name or false
 */
function alomran_get_post_preset($post_id) {
    return get_post_meta($post_id, ALOMRAN_PRESET_META_KEY, true);
}

/**
 * Set preset meta for a menu
 * 
 * @param int $menu_id Menu term ID
 * @param string $preset Preset name
 * @return bool|int Meta ID on success, false on failure
 */
function alomran_set_menu_preset($menu_id, $preset) {
    return update_term_meta($menu_id, ALOMRAN_PRESET_META_KEY, sanitize_text_field($preset));
}

/**
 * Get preset meta for a menu
 * 
 * @param int $menu_id Menu term ID
 * @return string|false Preset name or false
 */
function alomran_get_menu_preset($menu_id) {
    return get_term_meta($menu_id, ALOMRAN_PRESET_META_KEY, true);
}

/**
 * Delete all content from a specific preset
 * 
 * @param string $preset Preset name
 * @return array Results
 */
function alomran_delete_preset_content($preset) {
    $results = array(
        'posts' => 0,
        'pages' => 0,
        'products' => 0,
        'news' => 0,
        'menus' => 0,
    );
    
    // Get all posts with this preset
    $post_types = array('post', 'page', 'product', 'news', 'testimonial', 'faq');
    
    foreach ($post_types as $post_type) {
        $query = new WP_Query(array(
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => ALOMRAN_PRESET_META_KEY,
                    'value' => $preset,
                    'compare' => '=',
                ),
            ),
            'fields' => 'ids',
        ));
        
        if ($query->have_posts()) {
            foreach ($query->posts as $post_id) {
                wp_delete_post($post_id, true);
                
                // Count by post type
                if ($post_type === 'post') {
                    $results['posts']++;
                } elseif ($post_type === 'page') {
                    $results['pages']++;
                } elseif ($post_type === 'product') {
                    $results['products']++;
                } elseif ($post_type === 'news') {
                    $results['news']++;
                }
            }
        }
    }
    
    // Delete menus with this preset
    $menus = wp_get_nav_menus();
    foreach ($menus as $menu) {
        $menu_preset = get_term_meta($menu->term_id, ALOMRAN_PRESET_META_KEY, true);
        if ($menu_preset === $preset) {
            wp_delete_nav_menu($menu->term_id);
            $results['menus']++;
        }
    }
    
    return $results;
}

