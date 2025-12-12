<?php
/**
 * Ads Helper Functions - Simplified & DRY
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add AdSense script to header if publisher ID is provided
 */
function alomran_add_adsense_script() {
    $publisher_id = alomran_get_option('adsense_publisher_id', '');
    
    if (!empty($publisher_id) && alomran_ads_enabled()) {
        // Extract publisher ID from full format (ca-pub-xxxxxxxxxxxxx)
        $publisher_id_clean = str_replace('ca-pub-', '', $publisher_id);
        
        echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-' . esc_attr($publisher_id_clean) . '" crossorigin="anonymous"></script>' . "\n";
    }
}
add_action('wp_head', 'alomran_add_adsense_script', 5);

/**
 * Check if ads are globally enabled
 */
function alomran_ads_enabled() {
    return alomran_get_option('ads_global_enable', false);
}

/**
 * Check if ads should be displayed on current page
 * 
 * @param string $location Ad location
 * @return bool
 */
function alomran_should_display_ad($location) {
    if (!alomran_ads_enabled()) {
        return false;
    }
    
    // Demo ads always show when enabled
    if (alomran_get_option('demo_ads_enable', false)) {
        return true;
    }
    
    // Check if location is enabled
    if (!alomran_get_option('ads_' . $location . '_enable', false)) {
        return false;
    }
    
    // Check page restrictions
    $pages_key = 'ads_' . $location . '_pages';
    $allowed_pages = alomran_get_option($pages_key, array());
    
    // Handle sorter field structure
    $enabled_pages = array();
    if (is_array($allowed_pages) && isset($allowed_pages['enabled']) && is_array($allowed_pages['enabled'])) {
        $enabled_pages = array_keys($allowed_pages['enabled']);
    }
    
    if (empty($enabled_pages)) {
        return false;
    }
    
    return in_array(alomran_get_current_page_type(), $enabled_pages);
}

/**
 * Get current page type
 */
function alomran_get_current_page_type() {
    if (is_front_page() || is_home()) return 'home';
    if (is_singular('product')) return 'product';
    if (is_singular('news')) return 'news';
    if (is_archive() || is_category() || is_tag() || is_tax()) return 'archive';
    return 'single';
}

/**
 * Display ad for a specific location
 * 
 * @param string $location Ad location
 * @param string $wrapper_class Optional CSS class
 * @param string $wrapper_id Optional ID
 */
function alomran_display_ad($location, $wrapper_class = '', $wrapper_id = '') {
    if (!alomran_should_display_ad($location)) {
        return;
    }
    
    // Demo ads take priority
    if (alomran_get_option('demo_ads_enable', false)) {
        alomran_display_demo_ad($location, $wrapper_class, $wrapper_id);
        return;
    }
    
    // Real AdSense ads
    alomran_display_real_ad($location, $wrapper_class, $wrapper_id);
}

/**
 * Generate AdSense ad code (DRY function)
 * 
 * @param string $publisher_id Publisher ID
 * @param string $ad_slot Ad Slot ID
 * @param string $ad_size Optional ad size (e.g., '728x90')
 * @return string AdSense HTML code
 */
function alomran_generate_adsense_code($publisher_id, $ad_slot, $ad_size = '') {
    if (empty($publisher_id) || empty($ad_slot)) {
        return '';
    }
    
    // Format publisher ID
    $publisher_id_clean = strpos($publisher_id, 'ca-pub-') === 0 ? $publisher_id : 'ca-pub-' . $publisher_id;
    
    // Build ad code
    $style = 'display:block';
    if (!empty($ad_size)) {
        list($width, $height) = explode('x', $ad_size);
        $style .= ";width:{$width}px;height:{$height}px";
    }
    
    $code = '<ins class="adsbygoogle"';
    $code .= ' style="' . esc_attr($style) . '"';
    $code .= ' data-ad-client="' . esc_attr($publisher_id_clean) . '"';
    $code .= ' data-ad-slot="' . esc_attr($ad_slot) . '"';
    $code .= ' data-ad-format="auto"';
    $code .= ' data-full-width-responsive="true"';
    $code .= '></ins>';
    $code .= '<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
    
    return $code;
}

/**
 * Display demo ad (placeholder image)
 */
function alomran_display_demo_ad($location, $wrapper_class = '', $wrapper_id = '') {
    // Map location to demo ad option key
    $location_map = array(
        'header' => 'header',
        'sidebar' => 'sidebar',
        'content_before' => 'content',
        'content_after' => 'content',
        'footer' => 'footer',
        'widget' => 'sidebar',
    );
    
    $demo_key = isset($location_map[$location]) ? $location_map[$location] : 'header';
    $demo_ad_option = 'demo_ad_' . $demo_key;
    
    // Get demo ad image
    $demo_ad_image = alomran_get_option($demo_ad_option, '');
    
    // Extract URL from Redux media field array
    $image_url = '';
    if (is_array($demo_ad_image)) {
        if (isset($demo_ad_image['url']) && !empty($demo_ad_image['url'])) {
            $image_url = $demo_ad_image['url'];
        } elseif (isset($demo_ad_image['id']) && !empty($demo_ad_image['id'])) {
            $image_url = wp_get_attachment_image_url($demo_ad_image['id'], 'full');
        }
    } elseif (is_numeric($demo_ad_image)) {
        $image_url = wp_get_attachment_image_url($demo_ad_image, 'full');
    } elseif (is_string($demo_ad_image) && !empty($demo_ad_image)) {
        $image_url = $demo_ad_image;
    }
    
    // Default to placeholder if no custom image
    if (empty($image_url)) {
        $image_url = alomran_get_demo_ad_placeholder($location);
    }
    
    if (empty($image_url)) {
        return;
    }
    
    // Build wrapper attributes
    $wrapper_attr = '';
    if (!empty($wrapper_class)) {
        $wrapper_attr .= ' class="' . esc_attr($wrapper_class) . ' demo-ad-wrapper"';
    } else {
        $wrapper_attr .= ' class="demo-ad-wrapper"';
    }
    if (!empty($wrapper_id)) {
        $wrapper_attr .= ' id="' . esc_attr($wrapper_id) . '"';
    }
    
    // Output demo ad
    echo '<div' . $wrapper_attr . '>';
    echo '<div class="demo-ad-container relative">';
    echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr__('إعلان تجريبي', 'alomran') . '" class="demo-ad-image w-full h-auto" />';
    echo '<div class="demo-ad-watermark absolute inset-0 flex items-center justify-center bg-black/20 backdrop-blur-sm">';
    echo '<span class="demo-ad-label bg-primary/90 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-lg">';
    echo esc_html__('إعلان تجريبي - استبدله من إعدادات الإعلانات', 'alomran');
    echo '</span>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

/**
 * Display real AdSense ad
 */
function alomran_display_real_ad($location, $wrapper_class = '', $wrapper_id = '') {
    // First, try to get ad from Ads CPT (if exists)
    $ad_from_cpt = alomran_get_ad_from_cpt($location);
    if (!empty($ad_from_cpt)) {
        alomran_output_ad_wrapper($ad_from_cpt, $wrapper_class, $wrapper_id);
        return;
    }
    
    // Get publisher ID and ad slot ID
    $publisher_id = alomran_get_option('adsense_publisher_id', '');
    $ad_slot = alomran_get_option('ads_' . $location . '_slot', '');
    
    // Generate AdSense code if both are provided
    if (!empty($publisher_id) && !empty($ad_slot)) {
        // Get ad size based on location
        $ad_sizes = array(
            'header' => '728x90',
            'sidebar' => '300x250',
            'content_before' => '728x90',
            'content_after' => '728x90',
            'footer' => '728x90',
            'widget' => '300x250',
        );
        $ad_size = isset($ad_sizes[$location]) ? $ad_sizes[$location] : '';
        
        $ad_code = alomran_generate_adsense_code($publisher_id, $ad_slot, $ad_size);
        if (!empty($ad_code)) {
            alomran_output_ad_wrapper($ad_code, $wrapper_class, $wrapper_id);
            return;
        }
    }
}

/**
 * Output ad wrapper (DRY helper)
 */
function alomran_output_ad_wrapper($ad_code, $wrapper_class = '', $wrapper_id = '') {
    $wrapper_attr = '';
    if (!empty($wrapper_class)) {
        $wrapper_attr .= ' class="' . esc_attr($wrapper_class) . '"';
    }
    if (!empty($wrapper_id)) {
        $wrapper_attr .= ' id="' . esc_attr($wrapper_id) . '"';
    }
    
    echo '<div' . $wrapper_attr . '>';
    echo $ad_code; // Output ad code (HTML/JS allowed)
    echo '</div>';
}

/**
 * Get demo ad placeholder image URL
 */
function alomran_get_demo_ad_placeholder($location) {
    $dimensions = array(
        'header' => '728x90',
        'sidebar' => '300x250',
        'content' => '728x90',
        'content_before' => '728x90',
        'content_after' => '728x90',
        'footer' => '728x90',
        'widget' => '300x250',
    );
    
    $size = isset($dimensions[$location]) ? $dimensions[$location] : '728x90';
    $location_names = array(
        'header' => 'Header',
        'sidebar' => 'Sidebar',
        'content' => 'Content',
        'content_before' => 'Before Content',
        'content_after' => 'After Content',
        'footer' => 'Footer',
        'widget' => 'Widget',
    );
    
    $location_name = isset($location_names[$location]) ? $location_names[$location] : 'Ad';
    $text = urlencode($location_name . ' Ad');
    
    return 'https://placehold.co/' . $size . '/4a5568/ffffff?text=' . $text;
}

/**
 * Get ad from Ads CPT (if exists)
 */
function alomran_get_ad_from_cpt($location) {
    if (!post_type_exists('ad')) {
        return '';
    }
    
    $ads_query = new WP_Query(array(
        'post_type' => 'ad',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => 'ad_location',
                'value' => $location,
                'compare' => '=',
            ),
        ),
        'post_status' => 'publish',
    ));
    
    if ($ads_query->have_posts()) {
        $ads_query->the_post();
        $ad_code = get_post_meta(get_the_ID(), 'ad_code', true);
        $ad_type = get_post_meta(get_the_ID(), 'ad_type', true);
        $ad_link = get_post_meta(get_the_ID(), 'ad_link', true);
        
        wp_reset_postdata();
        
        if (!empty($ad_code)) {
            return $ad_code;
        }
        
        // If ad type is image and has featured image
        if ($ad_type === 'image' && has_post_thumbnail()) {
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $image_alt = get_the_title();
            
            if (!empty($image_url)) {
                $ad_html = '<a href="' . esc_url($ad_link ?: '#') . '" target="_blank" rel="nofollow">';
                $ad_html .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '" class="w-full h-auto" />';
                $ad_html .= '</a>';
                return $ad_html;
            }
        }
    }
    
    return '';
}

/**
 * Get widget ad code (for widgets)
 */
function alomran_get_widget_ad_code() {
    if (!alomran_ads_enabled() || !alomran_get_option('ads_widget_enable', false)) {
        return '';
    }
    
    $publisher_id = alomran_get_option('adsense_publisher_id', '');
    $ad_slot = alomran_get_option('ads_widget_slot', '');
    
    if (!empty($publisher_id) && !empty($ad_slot)) {
        return alomran_generate_adsense_code($publisher_id, $ad_slot, '300x250');
    }
    
    return '';
}
