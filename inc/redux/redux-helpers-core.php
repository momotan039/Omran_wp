<?php
/**
 * Redux Core Helper Functions
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get Redux option value
 *
 * @param string $option Option key.
 * @param mixed $default Default value.
 * @return mixed
 */
function alomran_get_option($option, $default = '') {
    // On frontend, Redux should not be loaded, so get from database directly
    if (!is_admin() && !class_exists('Redux')) {
        $options = get_option('alomran_options', array());
        return isset($options[$option]) ? $options[$option] : $default;
    }
    
    // In admin, use Redux if available
    if (class_exists('Redux')) {
        return Redux::get_option('alomran_options', $option, $default);
    }
    
    // Fallback to database
    $options = get_option('alomran_options', array());
    return isset($options[$option]) ? $options[$option] : $default;
}

/**
 * Extract image URL from Redux media field
 *
 * @param mixed $image_field Image field value (array or string).
 * @return string
 */
function alomran_extract_image_url($image_field) {
    if (empty($image_field)) {
        return '';
    }
    
    if (is_array($image_field) && isset($image_field['url'])) {
        return $image_field['url'];
    }
    
    if (is_string($image_field)) {
        return $image_field;
    }
    
    return '';
}

/**
 * Get preset-specific contact page data
 *
 * @param string $preset Preset name.
 * @return array
 */
function alomran_get_contact_page_data($preset) {
    if ($preset === 'food') {
        $map_url = alomran_get_option('food_contact_map_url', '');
        
        return array(
            'title'          => alomran_get_option('food_contact_page_title', 'تواصل معنا'),
            'subtitle'       => alomran_get_option('food_contact_page_subtitle', 'فريقنا جاهز للرد على استفساراتكم وتقديم الدعم الفني'),
            'form_title'     => alomran_get_option('food_contact_form_title', 'أرسل لنا رسالة'),
            'phone_title'    => alomran_get_option('food_contact_phone_title', 'اتصل بنا'),
            'phone_subtitle' => alomran_get_option('food_contact_phone_subtitle', 'متاحين من 9 صباحاً - 5 مساءً'),
            'phone_numbers'  => alomran_get_option('food_contact_phone_numbers', array('+966 11 234 5678', '+966 50 123 4567')),
            'email_title'    => alomran_get_option('food_contact_email_title', 'البريد الإلكتروني'),
            'email_subtitle' => alomran_get_option('food_contact_email_subtitle', 'للتعاقدات والمبيعات'),
            'email_addresses' => alomran_get_option('food_contact_email_addresses', array('info@aljawhara.com', 'reservations@aljawhara.com')),
            'address_title'  => alomran_get_option('food_contact_address_title', 'المقر الرئيسي'),
            'address_text'   => alomran_get_option('food_contact_address_text', "شارع التحلية، حي السليمانية\nالرياض، المملكة العربية السعودية"),
            'map_enable'     => alomran_get_option('food_contact_map_enable', true),
            'map_url'        => $map_url,
            'map_text'       => alomran_get_option('food_contact_map_text', 'موقع المصنع'),
        );
    }
    
    // Industrial preset (with backward compatibility)
    $map_url = alomran_get_option('industrial_contact_map_url', '') ?: alomran_get_option('contact_map_url', '');
    
    return array(
        'title'          => alomran_get_option('industrial_contact_page_title', '') ?: alomran_get_option('contact_page_title', 'تواصل معنا'),
        'subtitle'       => alomran_get_option('industrial_contact_page_subtitle', '') ?: alomran_get_option('contact_page_subtitle', 'فريقنا جاهز للرد على استفساراتكم وتقديم الدعم الفني'),
        'form_title'     => alomran_get_option('industrial_contact_form_title', '') ?: alomran_get_option('contact_form_title', 'أرسل رسالة'),
        'phone_title'    => alomran_get_option('industrial_contact_phone_title', '') ?: alomran_get_option('contact_phone_title', 'اتصل بنا'),
        'phone_subtitle' => alomran_get_option('industrial_contact_phone_subtitle', '') ?: alomran_get_option('contact_phone_subtitle', 'متاحين من 9 صباحاً - 5 مساءً'),
        'email_title'    => alomran_get_option('industrial_contact_email_title', '') ?: alomran_get_option('contact_email_title', 'البريد الإلكتروني'),
        'email_subtitle' => alomran_get_option('industrial_contact_email_subtitle', '') ?: alomran_get_option('contact_email_subtitle', 'للتعاقدات والمبيعات'),
        'address_title'  => alomran_get_option('industrial_contact_address_title', '') ?: alomran_get_option('contact_address_title', 'المقر الرئيسي'),
        'map_enable'     => alomran_get_option('industrial_contact_map_enable', true),
        'map_url'        => $map_url,
        'map_text'       => alomran_get_option('industrial_contact_map_text', '') ?: alomran_get_option('contact_map_text', 'موقع المصنع'),
    );
}

/**
 * Get critical fields that should be preserved
 *
 * @return array
 */
function alomran_get_critical_redux_fields() {
    return array(
        // Hero section
        'food_hero_background_image', 'food_hero_badge', 'food_hero_title', 'food_hero_title_highlight',
        'food_hero_description', 'food_hero_primary_button_text', 'food_hero_primary_button_link',
        'food_hero_secondary_button_text', 'food_hero_secondary_button_link',
        
        // Philosophy section
        'food_philosophy_image', 'food_philosophy_title', 'food_philosophy_title_highlight',
        'food_philosophy_description', 'food_philosophy_quote',
        
        // Experience section
        'food_experience_background', 'food_experience_title', 'food_experience_quote',
        'food_experience_lighting_title', 'food_experience_lighting_content',
        'food_experience_service_title', 'food_experience_service_content',
        
        // Story section
        'food_story_image', 'food_story_title', 'food_story_title_highlight',
        'food_story_description_1', 'food_story_description_2',
        
        // Story page
        'food_story_page_image', 'food_story_page_content',
        
        // Menu section
        'food_menu_title', 'food_menu_subtitle', 'food_menu_description', 'food_menu_items_per_page',
        
        // Blog section
        'food_blog_title', 'food_blog_subtitle', 'food_blog_description', 'food_blog_posts_per_page',
        
        // Branches section
        'food_branches_title', 'food_branches_subtitle', 'food_branches_description',
        
        // Reservations section
        'food_reservations_title', 'food_reservations_subtitle', 'food_reservations_description',
        'food_reservations_email', 'food_reservations_max_guests',
        
        // Footer section
        'food_footer_description', 'food_footer_copyright_text',
        
        // Social section
        'food_social_instagram', 'food_social_twitter', 'food_social_facebook',
    );
}

/**
 * Parse textarea items with delimiter
 *
 * @param string $textarea Textarea content.
 * @param string $delimiter Delimiter (default: '|').
 * @param array $keys Array of keys for parsed items.
 * @param array $defaults Optional default values for keys.
 * @return array
 */
function alomran_parse_textarea_items($textarea, $delimiter = '|', $keys = array(), $defaults = array()) {
    if (empty($textarea)) {
        return array();
    }
    
    $lines = array_filter(array_map('trim', explode("\n", $textarea)));
    $items = array();
    
    foreach ($lines as $line) {
        if (empty($line)) {
            continue;
        }
        
        $parts = explode($delimiter, $line);
        $item = array();
        
        foreach ($keys as $index => $key) {
            $value = isset($parts[$index]) ? trim($parts[$index]) : '';
            // Use default if value is empty and default exists
            if (empty($value) && isset($defaults[$key])) {
                $value = $defaults[$key];
            }
            $item[$key] = $value;
        }
        
        // Only add if first key has value
        if (!empty($item[$keys[0]])) {
            $items[] = $item;
        }
    }
    
    return $items;
}

/**
 * Register CPT with common defaults
 *
 * @param string $post_type Post type slug.
 * @param array $args Post type arguments.
 * @return void
 */
function alomran_register_cpt($post_type, $args) {
    $defaults = array(
        'public'            => true,
        'has_archive'      => true,
        'publicly_queryable' => true,
        'query_var'         => true,
        'show_in_rest'      => true,
        'supports'          => array('title', 'editor', 'thumbnail', 'excerpt'),
    );
    
    $args = wp_parse_args($args, $defaults);
    
    // Ensure labels exist
    if (!isset($args['labels']) || !is_array($args['labels'])) {
        $singular = ucfirst(str_replace('_', ' ', $post_type));
        $plural = $singular . 's';
        
        $args['labels'] = array(
            'name'               => $plural,
            'singular_name'      => $singular,
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New ' . $singular,
            'edit_item'          => 'Edit ' . $singular,
            'new_item'           => 'New ' . $singular,
            'view_item'          => 'View ' . $singular,
            'search_items'       => 'Search ' . $plural,
            'not_found'          => 'No ' . strtolower($plural) . ' found',
            'not_found_in_trash' => 'No ' . strtolower($plural) . ' found in trash',
            'all_items'          => 'All ' . $plural,
        );
    }
    
    register_post_type($post_type, $args);
}

// alomran_register_taxonomy() is already defined in inc/helpers/helpers-taxonomies.php

