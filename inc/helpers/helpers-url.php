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
 * Format URL - converts relative URLs to full URLs.
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
    
    // If it starts with /, it's a relative path - convert to full URL
    if (strpos($url, '/') === 0) {
        return esc_url(home_url($url));
    }
    
    // If it's a hash anchor, return as is
    if (strpos($url, '#') === 0) {
        return esc_attr($url);
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

