<?php
/**
 * SEO Image Optimization
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add width and height attributes to images for better SEO
 */
function alomran_add_image_dimensions($attr, $attachment, $size) {
    // Get image metadata
    $image_meta = wp_get_attachment_image_src($attachment->ID, $size);
    
    if ($image_meta) {
        // Set width and height from actual image dimensions
        if (!isset($attr['width']) && isset($image_meta[1])) {
            $attr['width'] = $image_meta[1];
        }
        if (!isset($attr['height']) && isset($image_meta[2])) {
            $attr['height'] = $image_meta[2];
        }
    } else {
        // Fallback to attachment metadata
        $attachment_meta = wp_get_attachment_metadata($attachment->ID);
        if ($attachment_meta) {
            if (!isset($attr['width']) && isset($attachment_meta['width'])) {
                $attr['width'] = $attachment_meta['width'];
            }
            if (!isset($attr['height']) && isset($attachment_meta['height'])) {
                $attr['height'] = $attachment_meta['height'];
            }
        }
    }
    
    // Ensure alt text exists
    if (empty($attr['alt'])) {
        $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
        if (empty($alt)) {
            $alt = get_the_title($attachment->ID) ?: get_bloginfo('name');
        }
        $attr['alt'] = $alt;
    }
    
    // Add loading="lazy" if not already set (except for above-the-fold images)
    if (!isset($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }
    
    // Add decoding="async" for better performance
    if (!isset($attr['decoding'])) {
        $attr['decoding'] = 'async';
    }
    
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'alomran_add_image_dimensions', 10, 3);

/**
 * Add proper alt text to post thumbnails
 */
function alomran_thumbnail_alt_text($html, $post_id, $post_thumbnail_id, $size, $attr) {
    if (empty($attr['alt'])) {
        $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);
        if (empty($alt)) {
            $alt = get_the_title($post_id) ?: get_bloginfo('name');
        }
        $html = str_replace('<img ', '<img alt="' . esc_attr($alt) . '" ', $html);
    }
    return $html;
}
add_filter('post_thumbnail_html', 'alomran_thumbnail_alt_text', 10, 5);

/**
 * Ensure all images have proper attributes for SEO
 */
function alomran_optimize_image_output($content) {
    if (empty($content)) {
        return $content;
    }
    
    // Add loading="lazy" and decoding="async" to images that don't have them
    $content = preg_replace_callback(
        '/<img\s+([^>]*?)(?:\s*\/)?>/i',
        function($matches) {
            $img_tag = $matches[0];
            
            // Skip if already has loading attribute
            if (strpos($img_tag, 'loading=') === false) {
                $img_tag = str_replace('<img ', '<img loading="lazy" ', $img_tag);
            }
            
            // Add decoding="async" if not present
            if (strpos($img_tag, 'decoding=') === false) {
                $img_tag = str_replace('<img ', '<img decoding="async" ', $img_tag);
            }
            
            // Ensure alt attribute exists
            if (strpos($img_tag, 'alt=') === false) {
                $img_tag = str_replace('<img ', '<img alt="' . esc_attr__('صورة', 'alomran') . '" ', $img_tag);
            }
            
            return $img_tag;
        },
        $content
    );
    
    return $content;
}
add_filter('the_content', 'alomran_optimize_image_output', 99);

/**
 * Add image dimensions to featured images
 */
function alomran_get_image_with_dimensions($post_id, $size = 'large', $attr = array()) {
    if (!has_post_thumbnail($post_id)) {
        return '';
    }
    
    $thumbnail_id = get_post_thumbnail_id($post_id);
    $image_meta = wp_get_attachment_metadata($thumbnail_id);
    
    // Get image URL
    $image_url = get_the_post_thumbnail_url($post_id, $size);
    
    // Get dimensions
    $width = '';
    $height = '';
    if ($image_meta) {
        if (isset($image_meta['sizes'][$size])) {
            $width = $image_meta['sizes'][$size]['width'];
            $height = $image_meta['sizes'][$size]['height'];
        } elseif (isset($image_meta['width']) && isset($image_meta['height'])) {
            $width = $image_meta['width'];
            $height = $image_meta['height'];
        }
    }
    
    // Build attributes
    $default_attr = array(
        'alt' => get_the_title($post_id) ?: get_bloginfo('name'),
        'loading' => 'lazy',
        'decoding' => 'async',
    );
    
    if ($width) {
        $default_attr['width'] = $width;
    }
    if ($height) {
        $default_attr['height'] = $height;
    }
    
    $attr = wp_parse_args($attr, $default_attr);
    
    return get_the_post_thumbnail($post_id, $size, $attr);
}

