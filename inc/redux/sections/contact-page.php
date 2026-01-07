<?php
/**
 * Contact Page Configuration
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => __('صفحة التواصل', 'alomran'),
    'id'         => 'contact_page',
    'subsection' => true,
    'parent'     => 'food_pages_sections',
    'icon'       => 'el el-envelope',
    'fields'     => array(
        array(
            'id'       => 'contact_page_title',
            'type'     => 'text',
            'title'    => __('عنوان الصفحة', 'alomran'),
            'default'  => 'تواصل معنا',
        ),
        array(
            'id'       => 'contact_page_subtitle',
            'type'     => 'text',
            'title'    => __('الوصف', 'alomran'),
            'default'  => 'فريقنا جاهز للرد على استفساراتكم وتقديم الدعم الفني',
        ),
        array(
            'id'       => 'contact_form_title',
            'type'     => 'text',
            'title'    => __('عنوان النموذج', 'alomran'),
            'default'  => 'أرسل رسالة',
        ),
        array(
            'id'       => 'contact_phone_divider',
            'type'     => 'divide',
            'title'    => __('بطاقة الهاتف', 'alomran'),
        ),
        array(
            'id'       => 'contact_phone_title',
            'type'     => 'text',
            'title'    => __('عنوان بطاقة الهاتف', 'alomran'),
            'default'  => 'اتصل بنا',
        ),
        array(
            'id'       => 'contact_phone_subtitle',
            'type'     => 'text',
            'title'    => __('وصف بطاقة الهاتف', 'alomran'),
            'default'  => 'متاحين من 9 صباحاً - 5 مساءً',
        ),
        array(
            'id'       => 'contact_phone_numbers',
            'type'     => 'multi_text',
            'title'    => __('أرقام الهواتف', 'alomran'),
            'subtitle' => __('أضف أرقام الهواتف (يمكنك إضافة أكثر من رقم)', 'alomran'),
            'add_text' => __('إضافة رقم هاتف', 'alomran'),
            'default'  => array(
                '+966 11 234 5678',
                '+966 50 123 4567',
            ),
        ),
        array(
            'id'       => 'contact_email_divider',
            'type'     => 'divide',
            'title'    => __('بطاقة البريد الإلكتروني', 'alomran'),
        ),
        array(
            'id'       => 'contact_email_title',
            'type'     => 'text',
            'title'    => __('عنوان بطاقة البريد', 'alomran'),
            'default'  => 'البريد الإلكتروني',
        ),
        array(
            'id'       => 'contact_email_subtitle',
            'type'     => 'text',
            'title'    => __('وصف بطاقة البريد', 'alomran'),
            'default'  => 'للتعاقدات والمبيعات',
        ),
        array(
            'id'       => 'contact_email_addresses',
            'type'     => 'multi_text',
            'title'    => __('عناوين البريد الإلكتروني', 'alomran'),
            'subtitle' => __('أضف عناوين البريد الإلكتروني (يمكنك إضافة أكثر من عنوان)', 'alomran'),
            'add_text' => __('إضافة بريد إلكتروني', 'alomran'),
            'default'  => array(
                'info@aljawhara.com',
                'reservations@aljawhara.com',
            ),
        ),
        array(
            'id'       => 'contact_address_divider',
            'type'     => 'divide',
            'title'    => __('بطاقة العنوان', 'alomran'),
        ),
        array(
            'id'       => 'contact_address_title',
            'type'     => 'text',
            'title'    => __('عنوان بطاقة العنوان', 'alomran'),
            'default'  => 'المقر الرئيسي',
        ),
        array(
            'id'       => 'contact_address_text',
            'type'     => 'textarea',
            'title'    => __('نص العنوان', 'alomran'),
            'subtitle' => __('أدخل العنوان الكامل (يمكنك استخدام سطر جديد بـ Enter)', 'alomran'),
            'default'  => "شارع التحلية، حي السليمانية\nالرياض، المملكة العربية السعودية",
            'rows'     => 3,
        ),
        array(
            'id'       => 'contact_map_divider',
            'type'     => 'divide',
            'title'    => __('الخريطة', 'alomran'),
        ),
        array(
            'id'       => 'contact_map_enable',
            'type'     => 'switch',
            'title'    => __('إظهار الخريطة', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'contact_map_url',
            'type'     => 'textarea',
            'title'    => __('رابط أو كود Google Maps', 'alomran'),
            'subtitle' => __('<strong>يمكنك إدخال أحد الخيارات التالية:</strong><br>1) رابط Embed من Google Maps (Share → Embed a map)<br>2) رابط Share عادي<br>3) كود iframe كامل<br><br><strong>للحصول على Embed URL:</strong><br>افتح Google Maps → اختر الموقع → اضغط Share → اختر Embed a map → انسخ الرابط', 'alomran'),
            'default'  => '',
            'placeholder' => 'https://www.google.com/maps/embed?pb=... أو <iframe src="..."></iframe>',
            'rows'     => 3,
        ),
        array(
            'id'       => 'contact_map_text',
            'type'     => 'text',
            'title'    => __('نص الخريطة', 'alomran'),
            'default'  => 'موقع المصنع',
        ),
        array(
            'id'       => 'contact_social_divider',
            'type'     => 'divide',
            'title'    => __('روابط التواصل الاجتماعي', 'alomran'),
        ),
        array(
            'id'       => 'contact_social_enable',
            'type'     => 'switch',
            'title'    => __('إظهار روابط التواصل الاجتماعي', 'alomran'),
            'subtitle' => __('إظهار قسم "تابعنا" في صفحة التواصل', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'contact_social_title',
            'type'     => 'text',
            'title'    => __('عنوان قسم التواصل الاجتماعي', 'alomran'),
            'default'  => 'تابعنا',
            'required' => array('contact_social_enable', '=', true),
        ),
        array(
            'id'       => 'contact_social_note',
            'type'     => 'info',
            'style'    => 'info',
            'title'    => __('ملاحظة', 'alomran'),
            'desc'     => __('<strong>روابط التواصل الاجتماعي:</strong><br>يمكنك إضافة روابط التواصل الاجتماعي من: <strong>إعدادات الموقع → إعدادات عامة → روابط التواصل الاجتماعي</strong><br>سيتم عرض الروابط المضافة هنا تلقائياً.', 'alomran'),
            'required' => array('contact_social_enable', '=', true),
        ),
    ),
));

