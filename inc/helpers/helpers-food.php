<?php
/**
 * Food Preset Helper Functions
 * 
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get menu items query
 * 
 * @param array $args Query arguments
 * @return WP_Query
 */
function alomran_food_get_menu_items($args = array()) {
    $random_order = alomran_get_option('food_menu_random_order', false);
    
    $defaults = array(
        'post_type'      => 'menu_item',
        'posts_per_page' => alomran_get_option('food_menu_items_per_page', 6),
        'post_status'    => 'publish',
    );
    
    // Set order based on random option (unless overridden in $args)
    if (!isset($args['orderby'])) {
        if ($random_order) {
            $defaults['orderby'] = 'rand';
        } else {
            $defaults['orderby'] = 'menu_order';
            $defaults['order'] = 'ASC';
        }
    }
    
    $args = wp_parse_args($args, $defaults);
    
    return new WP_Query($args);
}

/**
 * Get menu item price
 * 
 * @param int $post_id Post ID
 * @return string
 */
function alomran_food_get_menu_item_price($post_id) {
    if (function_exists('get_field')) {
        return get_field('price', $post_id) ?: '';
    }
    return get_post_meta($post_id, '_menu_item_price', true) ?: '';
}

/**
 * Get menu item name in English
 * 
 * @param int $post_id Post ID
 * @return string
 */
function alomran_food_get_menu_item_name_en($post_id) {
    if (function_exists('get_field')) {
        return get_field('name_en', $post_id) ?: '';
    }
    return get_post_meta($post_id, '_menu_item_name_en', true) ?: '';
}

/**
 * Get menu item category
 * 
 * @param int $post_id Post ID
 * @return WP_Term|false
 */
function alomran_food_get_menu_item_category($post_id) {
    $terms = get_the_terms($post_id, 'menu_category');
    if (!is_wp_error($terms) && !empty($terms)) {
        return $terms[0];
    }
    return false;
}

/**
 * Get blog posts query
 * 
 * @param array $args Query arguments
 * @return WP_Query
 */
function alomran_food_get_blog_posts($args = array()) {
    $random_order = alomran_get_option('food_blog_random_order', false);
    
    $defaults = array(
        'post_type'      => 'blog_post',
        'posts_per_page' => alomran_get_option('food_blog_posts_per_page', 6),
        'post_status'    => 'publish',
    );
    
    // Set order based on random option
    if ($random_order) {
        $defaults['orderby'] = 'rand';
    } else {
        $defaults['orderby'] = 'date';
        $defaults['order'] = 'DESC';
    }
    
    $args = wp_parse_args($args, $defaults);
    
    return new WP_Query($args);
}

/**
 * Get branches query
 * 
 * @param array $args Query arguments
 * @return WP_Query
 */
function alomran_food_get_branches($args = array()) {
    $defaults = array(
        'post_type'      => 'branch',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );
    
    $args = wp_parse_args($args, $defaults);
    
    return new WP_Query($args);
}

/**
 * Get branch phone
 * 
 * @param int $post_id Post ID
 * @return string
 */
function alomran_food_get_branch_phone($post_id) {
    if (function_exists('get_field')) {
        return get_field('phone', $post_id) ?: '';
    }
    return get_post_meta($post_id, '_branch_phone', true) ?: '';
}

/**
 * Get branch address
 * 
 * @param int $post_id Post ID
 * @return string
 */
function alomran_food_get_branch_address($post_id) {
    if (function_exists('get_field')) {
        return get_field('address', $post_id) ?: '';
    }
    return get_post_meta($post_id, '_branch_address', true) ?: '';
}

/**
 * Get branch map link
 * 
 * @param int $post_id Post ID
 * @return string
 */
function alomran_food_get_branch_map_link($post_id) {
    if (function_exists('get_field')) {
        return get_field('map_link', $post_id) ?: '#';
    }
    return get_post_meta($post_id, '_branch_map_link', true) ?: '#';
}

/**
 * Get branch city
 * 
 * @param int $post_id Post ID
 * @return string
 */
function alomran_food_get_branch_city($post_id) {
    if (function_exists('get_field')) {
        return get_field('city', $post_id) ?: '';
    }
    return get_post_meta($post_id, '_branch_city', true) ?: '';
}

/**
 * Get branch name in English
 * 
 * @param int $post_id Post ID
 * @return string
 */
function alomran_food_get_branch_name_en($post_id) {
    if (function_exists('get_field')) {
        return get_field('name_en', $post_id) ?: '';
    }
    return get_post_meta($post_id, '_branch_name_en', true) ?: '';
}

/**
 * Get menu categories
 * 
 * @return array
 */
function alomran_food_get_menu_categories() {
    $categories = get_terms(array(
        'taxonomy'   => 'menu_category',
        'hide_empty' => true,
    ));
    
    if (is_wp_error($categories)) {
        return array();
    }
    
    return $categories;
}

/**
 * Create reservation
 * 
 * @param array $data Reservation data
 * @return int|WP_Error Post ID on success, WP_Error on failure
 */
function alomran_food_create_reservation($data) {
    $defaults = array(
        'branch_id' => '',
        'date'      => '',
        'time'      => '',
        'guests'    => '',
        'name'      => '',
        'phone'     => '',
        'email'     => '',
        'notes'     => '',
    );
    
    $data = wp_parse_args($data, $defaults);
    
    $post_data = array(
        'post_type'    => 'reservation',
        'post_title'   => sprintf(__('حجز من %s', 'alomran'), $data['name']),
        'post_content' => $data['notes'],
        'post_status'  => 'publish',
    );
    
    $post_id = wp_insert_post($post_data);
    
    if (is_wp_error($post_id)) {
        return $post_id;
    }
    
    // Save meta fields
    update_post_meta($post_id, '_reservation_branch_id', sanitize_text_field($data['branch_id']));
    update_post_meta($post_id, '_reservation_date', sanitize_text_field($data['date']));
    update_post_meta($post_id, '_reservation_time', sanitize_text_field($data['time']));
    update_post_meta($post_id, '_reservation_guests', intval($data['guests']));
    update_post_meta($post_id, '_reservation_name', sanitize_text_field($data['name']));
    update_post_meta($post_id, '_reservation_phone', sanitize_text_field($data['phone']));
    update_post_meta($post_id, '_reservation_email', sanitize_email($data['email']));
    update_post_meta($post_id, '_reservation_status', 'pending'); // Default status
    update_post_meta($post_id, '_reservation_read', '0'); // Mark as unread
    
    // Send email notification to admin
    $admin_email = alomran_get_option('food_reservations_email', '');
    if ($admin_email && is_email($admin_email)) {
        $branch_name = $data['branch_id'] ? get_the_title($data['branch_id']) : __('غير محدد', 'alomran');
        $subject = sprintf(__('حجز جديد - %s', 'alomran'), $data['name']);
        
        $email_body = sprintf(
            '<html><body style="font-family: Arial, sans-serif; direction: rtl; text-align: right;">' .
            '<h2 style="color: #10b981;">حجز جديد</h2>' .
            '<table style="width: 100%%; border-collapse: collapse; margin: 20px 0;">' .
            '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">الاسم:</td><td style="padding: 10px; border: 1px solid #ddd;">%s</td></tr>' .
            '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">الهاتف:</td><td style="padding: 10px; border: 1px solid #ddd;">%s</td></tr>' .
            '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">البريد الإلكتروني:</td><td style="padding: 10px; border: 1px solid #ddd;">%s</td></tr>' .
            '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">التاريخ:</td><td style="padding: 10px; border: 1px solid #ddd;">%s</td></tr>' .
            '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">الوقت:</td><td style="padding: 10px; border: 1px solid #ddd;">%s</td></tr>' .
            '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">عدد الضيوف:</td><td style="padding: 10px; border: 1px solid #ddd;">%s</td></tr>' .
            '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">الفرع:</td><td style="padding: 10px; border: 1px solid #ddd;">%s</td></tr>' .
            '%s' .
            '</table>' .
            '<p style="color: #666; font-size: 12px; margin-top: 20px;">يمكنك عرض هذا الحجز في لوحة التحكم: <a href="%s">عرض الحجز</a></p>' .
            '</body></html>',
            esc_html($data['name']),
            esc_html($data['phone']),
            esc_html($data['email'] ?: '-'),
            esc_html($data['date'] ? date_i18n('l، d F Y', strtotime($data['date'])) : '-'),
            esc_html($data['time'] ?: '-'),
            esc_html($data['guests']),
            esc_html($branch_name),
            $data['notes'] ? '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">ملاحظات:</td><td style="padding: 10px; border: 1px solid #ddd;">' . nl2br(esc_html($data['notes'])) . '</td></tr>' : '',
            admin_url('post.php?post=' . $post_id . '&action=edit')
        );
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($admin_email, $subject, $email_body, $headers);
    }
    
    // Send confirmation email to customer (if email provided)
    if (!empty($data['email']) && is_email($data['email'])) {
        $customer_subject = __('شكراً لحجزك في الجوهرة', 'alomran');
        $customer_message = sprintf(
            __('عزيزي/عزيزتي %s،

شكراً لك على حجزك في مطعم الجوهرة.

تفاصيل الحجز:
التاريخ: %s
الوقت: %s
عدد الضيوف: %s
الفرع: %s

سيتم مراجعة حجزك والتأكيد قريباً. سنتواصل معك في أقرب وقت ممكن.

مع أطيب التحيات،
فريق الجوهرة', 'alomran'),
            esc_html($data['name']),
            esc_html($data['date'] ? date_i18n('l، d F Y', strtotime($data['date'])) : '-'),
            esc_html($data['time'] ?: '-'),
            esc_html($data['guests']),
            esc_html($data['branch_id'] ? get_the_title($data['branch_id']) : __('غير محدد', 'alomran'))
        );
        
        wp_mail($data['email'], $customer_subject, $customer_message);
    }
    
    return $post_id;
}

