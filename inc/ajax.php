<?php
/**
 * AJAX handlers for theme forms/widgets.
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle contact form submissions.
 */
function alomran_handle_contact_form() {
    check_ajax_referer('alomran-nonce', 'nonce');

    // Validate and sanitize input
    $name    = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $phone   = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $email   = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';

    // Validation
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(array('message' => __('يرجى ملء جميع الحقول المطلوبة.', 'alomran')));
    }

    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('البريد الإلكتروني غير صحيح.', 'alomran')));
    }

    // Save message to database as custom post type
    $post_data = array(
        'post_title'   => sprintf(__('رسالة من: %s', 'alomran'), $name),
        'post_content' => $message,
        'post_status'  => 'publish',
        'post_type'    => 'contact_message',
        'post_author'  => 1,
    );

    $post_id = wp_insert_post($post_data);

    if (is_wp_error($post_id)) {
        wp_send_json_error(array('message' => __('حدث خطأ في حفظ الرسالة. يرجى المحاولة مرة أخرى.', 'alomran')));
    }

    // Save additional meta data
    update_post_meta($post_id, '_contact_name', $name);
    update_post_meta($post_id, '_contact_phone', $phone);
    update_post_meta($post_id, '_contact_email', $email);
    update_post_meta($post_id, '_contact_date', current_time('mysql'));
    update_post_meta($post_id, '_contact_read', '0'); // 0 = unread, 1 = read

    // Send email notification
    $company_info = alomran_get_company_info();
    $to = $company_info['email'] ?: get_option('admin_email');
    $subject = sprintf(__('رسالة جديدة من نموذج التواصل - %s', 'alomran'), $name);
    
    $email_body = sprintf(
        '<html><body style="font-family: Arial, sans-serif; direction: rtl; text-align: right;">' .
        '<h2 style="color: #10b981;">رسالة جديدة من نموذج التواصل</h2>' .
        '<table style="width: 100%%; border-collapse: collapse; margin: 20px 0;">' .
        '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">الاسم:</td><td style="padding: 10px; border: 1px solid #ddd;">%s</td></tr>' .
        '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">الهاتف:</td><td style="padding: 10px; border: 1px solid #ddd;">%s</td></tr>' .
        '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">البريد الإلكتروني:</td><td style="padding: 10px; border: 1px solid #ddd;">%s</td></tr>' .
        '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">الرسالة:</td><td style="padding: 10px; border: 1px solid #ddd;">%s</td></tr>' .
        '</table>' .
        '<p style="color: #666; font-size: 12px; margin-top: 20px;">يمكنك عرض هذه الرسالة في لوحة التحكم: <a href="%s">عرض الرسالة</a></p>' .
        '</body></html>',
        esc_html($name),
        esc_html($phone),
        esc_html($email),
        nl2br(esc_html($message)),
        admin_url('post.php?post=' . $post_id . '&action=edit')
    );

    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    // Try to send email (don't fail if email fails)
    wp_mail($to, $subject, $email_body, $headers);

    wp_send_json_success(array('message' => __('تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.', 'alomran')));
}
add_action('wp_ajax_alomran_contact_form', 'alomran_handle_contact_form');
add_action('wp_ajax_nopriv_alomran_contact_form', 'alomran_handle_contact_form');

/**
 * Handle chat widget requests.
 */
function alomran_handle_chat_message() {
    check_ajax_referer('alomran-nonce', 'nonce');

    $message = isset($_POST['message']) ? sanitize_text_field(wp_unslash($_POST['message'])) : '';
    $company_info = alomran_get_company_info();
    $response = '';
    $lower_message = mb_strtolower($message);

    if (false !== strpos($lower_message, 'منتج') || false !== strpos($lower_message, 'سعر') || false !== strpos($lower_message, 'مواصفات')) {
        $response = __('يمكنك تصفح جميع منتجاتنا في صفحة المنتجات. إذا كنت تريد معلومات محددة عن منتج معين، يرجى التواصل معنا عبر صفحة "تواصل معنا".', 'alomran');
    } elseif (false !== strpos($lower_message, 'عنوان') || false !== strpos($lower_message, 'مكان')) {
        $response = sprintf(
            /* translators: 1: address, 2: phone, 3: email */
            __('عنواننا: %1$s. يمكنك التواصل معنا عبر الهاتف: %2$s أو البريد الإلكتروني: %3$s', 'alomran'),
            $company_info['address'],
            $company_info['phone'],
            $company_info['email']
        );
    } elseif (false !== strpos($lower_message, 'اتصال') || false !== strpos($lower_message, 'تواصل')) {
        $response = sprintf(
            __('يمكنك التواصل معنا عبر الهاتف: %1$s أو البريد الإلكتروني: %2$s. كما يمكنك زيارة صفحة "تواصل معنا" لملء النموذج.', 'alomran'),
            $company_info['phone'],
            $company_info['email']
        );
    } else {
        $response = __('شكراً لاهتمامك! للحصول على معلومات أكثر تفصيلاً، يرجى تصفح صفحات الموقع أو التواصل معنا مباشرة عبر صفحة "تواصل معنا". نحن سعداء بخدمتك!', 'alomran');
    }

    wp_send_json_success(array('message' => $response));
}
add_action('wp_ajax_alomran_chat_message', 'alomran_handle_chat_message');
add_action('wp_ajax_nopriv_alomran_chat_message', 'alomran_handle_chat_message');

/**
 * Handle food reservation form submissions.
 */
function alomran_food_handle_reservation() {
    // Validate and sanitize input
    $branch_id = isset($_POST['branch_id']) ? intval($_POST['branch_id']) : 0;
    $date      = isset($_POST['date']) ? sanitize_text_field(wp_unslash($_POST['date'])) : '';
    $time      = isset($_POST['time']) ? sanitize_text_field(wp_unslash($_POST['time'])) : '';
    $guests    = isset($_POST['guests']) ? intval($_POST['guests']) : 0;
    $name      = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $phone     = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $email     = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $notes     = isset($_POST['notes']) ? sanitize_textarea_field(wp_unslash($_POST['notes'])) : '';

    // Validation
    if (empty($branch_id) || empty($date) || empty($time) || empty($guests) || empty($name) || empty($phone)) {
        wp_send_json_error(array('message' => __('يرجى ملء جميع الحقول المطلوبة.', 'alomran')));
    }

    if ($guests < 1) {
        wp_send_json_error(array('message' => __('عدد الضيوف يجب أن يكون على الأقل 1.', 'alomran')));
    }

    $max_guests = alomran_get_option('food_reservations_max_guests', 20);
    if ($guests > $max_guests) {
        wp_send_json_error(array('message' => sprintf(__('الحد الأقصى لعدد الضيوف هو %d.', 'alomran'), $max_guests)));
    }

    // Create reservation
    $reservation_data = array(
        'branch_id' => $branch_id,
        'date'      => $date,
        'time'      => $time,
        'guests'    => $guests,
        'name'      => $name,
        'phone'     => $phone,
        'email'     => $email,
        'notes'     => $notes,
    );

    $result = alomran_food_create_reservation($reservation_data);

    if (is_wp_error($result)) {
        wp_send_json_error(array('message' => __('حدث خطأ في حفظ الحجز. يرجى المحاولة مرة أخرى.', 'alomran')));
    }

    wp_send_json_success(array('message' => __('شكراً لك! تم استلام طلب الحجز وسيتم التأكيد قريباً.', 'alomran')));
}
add_action('wp_ajax_alomran_food_create_reservation', 'alomran_food_handle_reservation');
add_action('wp_ajax_nopriv_alomran_food_create_reservation', 'alomran_food_handle_reservation');

/**
 * Handle Tech preset contact form submissions (admin-post.php).
 */
function alomran_tech_handle_contact_submit() {
    // Verify nonce
    if (!isset($_POST['tech_contact_nonce']) || !wp_verify_nonce($_POST['tech_contact_nonce'], 'tech_contact_form')) {
        wp_die(__('التحقق من الأمان فشل. يرجى المحاولة مرة أخرى.', 'alomran'));
    }

    // Validate and sanitize input
    $name    = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $email   = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';

    // Validation
    if (empty($name) || empty($email) || empty($message)) {
        wp_redirect(add_query_arg('tech_contact_error', 'missing_fields', wp_get_referer()));
        exit;
    }

    if (!is_email($email)) {
        wp_redirect(add_query_arg('tech_contact_error', 'invalid_email', wp_get_referer()));
        exit;
    }

    // Save message to database as custom post type
    $post_data = array(
        'post_title'   => sprintf(__('رسالة من: %s', 'alomran'), $name),
        'post_content' => $message,
        'post_status'  => 'publish',
        'post_type'    => 'contact_message',
        'post_author'  => 1,
    );

    $post_id = wp_insert_post($post_data);

    if (is_wp_error($post_id)) {
        wp_redirect(add_query_arg('tech_contact_error', 'save_error', wp_get_referer()));
        exit;
    }

    // Save additional meta data
    update_post_meta($post_id, '_contact_name', $name);
    update_post_meta($post_id, '_contact_email', $email);
    update_post_meta($post_id, '_contact_date', current_time('mysql'));
    update_post_meta($post_id, '_contact_read', '0'); // 0 = unread, 1 = read

    // Send email notification
    $contact_email = alomran_get_option('tech_contact_email', get_option('admin_email'));
    $to = $contact_email ?: get_option('admin_email');
    $subject = sprintf(__('رسالة جديدة من نموذج التواصل - %s', 'alomran'), $name);
    
    $email_body = sprintf(
        '<html><body style="font-family: Arial, sans-serif; direction: rtl; text-align: right;">' .
        '<h2 style="color: #2563eb;">رسالة جديدة من نموذج التواصل - منصة إتقان</h2>' .
        '<table style="width: 100%%; border-collapse: collapse; margin: 20px 0;">' .
        '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">الاسم:</td><td style="padding: 10px; border: 1px solid #ddd;">%s</td></tr>' .
        '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">البريد الإلكتروني:</td><td style="padding: 10px; border: 1px solid #ddd;">%s</td></tr>' .
        '<tr><td style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">الرسالة:</td><td style="padding: 10px; border: 1px solid #ddd;">%s</td></tr>' .
        '</table>' .
        '<p style="color: #666; font-size: 12px; margin-top: 20px;">يمكنك عرض هذه الرسالة في لوحة التحكم: <a href="%s">عرض الرسالة</a></p>' .
        '</body></html>',
        esc_html($name),
        esc_html($email),
        nl2br(esc_html($message)),
        admin_url('post.php?post=' . $post_id . '&action=edit')
    );

    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    // Try to send email (don't fail if email fails)
    wp_mail($to, $subject, $email_body, $headers);

    // Redirect back with success message
    wp_redirect(add_query_arg('tech_contact_success', '1', wp_get_referer()));
    exit;
}
add_action('admin_post_tech_contact_submit', 'alomran_tech_handle_contact_submit');
add_action('admin_post_nopriv_tech_contact_submit', 'alomran_tech_handle_contact_submit');

/**
 * Handle menu reset/import AJAX request
 */
function alomran_handle_menu_reset() {
    check_ajax_referer('alomran_reset_menu', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => 'غير مصرح'));
    }
    
    $preset = isset($_POST['preset']) ? sanitize_text_field($_POST['preset']) : 'tech';
    $force_update = isset($_POST['force_update']) && $_POST['force_update'] === '1';
    
    $result = alomran_import_preset_menus($preset, $force_update);
    
    if ($result['success']) {
        wp_send_json_success($result);
    } else {
        wp_send_json_error($result);
    }
}
add_action('wp_ajax_alomran_reset_menu', 'alomran_handle_menu_reset');

