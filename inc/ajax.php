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

    $name    = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $phone   = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $email   = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';

    $to      = get_option('admin_email');
    $subject = sprintf(__('New Contact Form Submission from %s', 'alomran'), $name);
    $body    = sprintf("Name: %s\nPhone: %s\nEmail: %s\n\nMessage:\n%s", $name, $phone, $email, $message);
    $headers = array('Content-Type: text/html; charset=UTF-8');

    if (wp_mail($to, $subject, nl2br(esc_html($body)), $headers)) {
        wp_send_json_success(array('message' => __('تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.', 'alomran')));
    }

    wp_send_json_error(array('message' => __('حدث خطأ. يرجى المحاولة مرة أخرى.', 'alomran')));
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

