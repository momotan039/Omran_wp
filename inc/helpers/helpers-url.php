<?php
/**
 * URL Formatting Helpers
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get preset pages as options array for Redux select field
 * 
 * @return array Array of page options (slug => title)
 */
function alomran_get_preset_pages_options() {
    $options = array(
        '' => __('-- اختر صفحة --', 'alomran'),
    );
    
    // Add common hash links
    $options['#menu'] = __('القائمة (Hash Link)', 'alomran');
    $options['#branches'] = __('الفروع (Hash Link)', 'alomran');
    $options['#story'] = __('القصة (Hash Link)', 'alomran');
    $options['#experience'] = __('التجربة (Hash Link)', 'alomran');
    
    // Check if Preset Loader class exists
    if (!class_exists('AlOmran_Preset_Loader')) {
        $options['custom'] = __('رابط مخصص', 'alomran');
        return $options;
    }
    
    // Check if preset meta key is defined
    if (!defined('ALOMRAN_PRESET_META_KEY')) {
        $options['custom'] = __('رابط مخصص', 'alomran');
        return $options;
    }
    
    $active_preset = AlOmran_Preset_Loader::get_active_preset();
    
    if (!$active_preset) {
        $options['custom'] = __('رابط مخصص', 'alomran');
        return $options;
    }
    
    // Query for pages in current preset
    $args = array(
        'post_type'      => 'page',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
        'meta_query'     => array(
            array(
                'key'   => ALOMRAN_PRESET_META_KEY,
                'value' => $active_preset,
            ),
        ),
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $page = get_post();
            $slug = $page->post_name;
            $title = get_the_title();
            $options[$slug] = $title;
        }
        wp_reset_postdata();
    }
    
    // Add custom link option at the end
    $options['custom'] = __('رابط مخصص', 'alomran');
    
    return $options;
}

/**
 * Get preset page by slug
 * 
 * @param string $slug Page slug
 * @return WP_Post|null
 */
function alomran_get_preset_page($slug) {
    // Check if Preset Loader class exists
    if (!class_exists('AlOmran_Preset_Loader')) {
        return null;
    }
    
    // Check if preset meta key is defined
    if (!defined('ALOMRAN_PRESET_META_KEY')) {
        return null;
    }
    
    $active_preset = AlOmran_Preset_Loader::get_active_preset();
    
    if (!$active_preset) {
        return null;
    }
    
    // Remove leading slash and get clean slug
    $slug = ltrim($slug, '/');
    
    // Query for page in current preset
    $args = array(
        'post_type'      => 'page',
        'name'           => $slug,
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'   => ALOMRAN_PRESET_META_KEY,
                'value' => $active_preset,
            ),
        ),
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        $query->the_post();
        $page = get_post();
        wp_reset_postdata();
        return $page;
    }
    
    return null;
}

/**
 * Get button link based on link type and custom link
 * 
 * @param string $link_type The link type (page slug, hash link, or 'custom')
 * @param string $custom_link The custom link if type is 'custom'
 * @return string Formatted URL
 */
function alomran_get_button_link($link_type, $custom_link = '') {
    if (empty($link_type)) {
        return '#';
    }
    
    // If custom link is selected
    if ($link_type === 'custom') {
        if (empty($custom_link)) {
            return '#';
        }
        return alomran_format_url($custom_link);
    }
    
    // If it's a hash link (starts with #)
    if (strpos($link_type, '#') === 0) {
        return esc_attr($link_type);
    }
    
    // If a page slug is selected
    return alomran_format_url('/' . $link_type);
}

/**
 * Format URL - converts relative URLs to full URLs.
 * If URL starts with /, checks for preset page first.
 *
 * @param string $url The URL to format.
 * @return string Formatted URL.
 */
function alomran_format_url($url) {
    if (empty($url)) {
        return '#';
    }
    
    // If it's already a full URL (http:// or https://), return as is
    if (preg_match('/^https?:\/\//', $url)) {
        return esc_url($url);
    }
    
    // If it's a hash anchor, return as is
    if (strpos($url, '#') === 0) {
        return esc_attr($url);
    }
    
    // If it starts with /, check for preset page first
    if (strpos($url, '/') === 0) {
        // Extract slug from URL (remove leading slash and any query/hash)
        $path = trim($url, '/');
        $path_parts = explode('?', $path);
        $slug = $path_parts[0];
        $path_parts = explode('#', $slug);
        $slug = $path_parts[0];
        
        // Try to find page in current preset
        $preset_page = alomran_get_preset_page($slug);
        
        if ($preset_page) {
            // Found preset page, use home_url with slug to ensure correct path
            // This ensures we get the full path including subdirectory if WordPress is installed in one
            $permalink = home_url('/' . $slug . '/');
            
            // Preserve query string and hash if present
            if (strpos($url, '?') !== false || strpos($url, '#') !== false) {
                $query_hash = '';
                if (strpos($url, '?') !== false) {
                    $query_hash = substr($url, strpos($url, '?'));
                } elseif (strpos($url, '#') !== false) {
                    $query_hash = substr($url, strpos($url, '#'));
                }
                // Remove trailing slash before adding query/hash
                $permalink = rtrim($permalink, '/');
                return esc_url($permalink . $query_hash);
            }
            
            return esc_url($permalink);
        }
        
        // No preset page found, use home_url as fallback
        return esc_url(home_url($url));
    }
    
    // Otherwise, treat as relative path and prepend home_url
    return esc_url(home_url('/' . ltrim($url, '/')));
}

/**
 * Extract iframe src from iframe code or return URL as-is
 *
 * @param string $input Iframe code or URL.
 * @return string Clean URL or src from iframe.
 */
function alomran_extract_map_url($input) {
    if (empty($input)) {
        return '';
    }
    
    $input = trim($input);
    
    // Try to extract src from iframe tag
    if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/', $input, $matches)) {
        return $matches[1];
    }
    
    // Fallback: try different pattern
    if (strpos($input, '<iframe') !== false && preg_match('/src\s*=\s*["\']?([^"\'\s>]+)["\']?/', $input, $matches)) {
        return $matches[1];
    }
    
    // Return as-is if it's just a URL
    return $input;
}

/**
 * Add output=embed parameter to Google Maps URL
 *
 * @param string $url Google Maps URL.
 * @return string URL with output=embed parameter.
 */
function alomran_add_embed_parameter($url) {
    if (strpos($url, 'output=embed') !== false) {
        return $url; // Already has embed parameter
    }
    
    $separator = (strpos($url, '?') !== false) ? '&' : '?';
    return $url . $separator . 'output=embed';
}

/**
 * Convert Google Maps URL to embed URL
 *
 * @param string $url Google Maps URL (share link or embed URL).
 * @return string Embed URL ready for iframe.
 */
function alomran_convert_google_maps_url($url) {
    if (empty($url)) {
        return '';
    }
    
    // Extract URL from iframe code if present
    $url = alomran_extract_map_url($url);
    
    if (empty($url)) {
        return '';
    }
    
    // If it's already an embed URL, return as is
    if (strpos($url, 'maps/embed') !== false) {
        return esc_url($url);
    }
    
    // Method 1: Extract coordinates from @lat,lng format (most common)
    if (preg_match('/@(-?\d+\.?\d*),(-?\d+\.?\d*),?(\d+\.?\d*)?z/', $url, $matches)) {
        $lat = $matches[1];
        $lng = $matches[2];
        $zoom = !empty($matches[3]) ? $matches[3] : '15';
        return esc_url("https://www.google.com/maps?q={$lat},{$lng}&hl=ar&z={$zoom}&output=embed");
    }
    
    // Method 2: Extract place ID or name from /place/ URL
    if (preg_match('/\/place\/([^\/\?&]+)/', $url, $matches)) {
        $place_query = urlencode(str_replace('+', ' ', $matches[1]));
        return esc_url("https://www.google.com/maps?q={$place_query}&hl=ar&output=embed");
    }
    
    // Method 3: Extract query parameter (?q= or &q=)
    if (preg_match('/[?&]q=([^&]+)/', $url, $matches)) {
        $query = urlencode(urldecode($matches[1]));
        return esc_url("https://www.google.com/maps?q={$query}&hl=ar&output=embed");
    }
    
    // Method 4: Extract coordinates (lat,lng without @)
    if (preg_match('/(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
        $lat = $matches[1];
        $lng = $matches[2];
        return esc_url("https://www.google.com/maps?q={$lat},{$lng}&hl=ar&output=embed");
    }
    
    // Method 5: For Google Maps URLs, add output=embed parameter
    if (strpos($url, 'google.com/maps') !== false || strpos($url, 'maps.google.com') !== false) {
        return esc_url(alomran_add_embed_parameter($url));
    }
    
    // Fallback: Try adding output=embed to any URL
    return esc_url(alomran_add_embed_parameter($url));
}

