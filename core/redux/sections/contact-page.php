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
    'title'      => 'صفحة التواصل',
    'id'         => 'contact_page',
    'subsection' => false,
    'icon'       => 'el el-envelope',
    'fields'     => array(
        array(
            'id'       => 'contact_page_title',
            'type'     => 'text',
            'title'    => 'عنوان الصفحة',
            'default'  => 'تواصل معنا',
        ),
        array(
            'id'       => 'contact_page_subtitle',
            'type'     => 'text',
            'title'    => 'الوصف',
            'default'  => 'فريقنا جاهز للرد على استفساراتكم وتقديم الدعم الفني',
        ),
        array(
            'id'       => 'contact_form_title',
            'type'     => 'text',
            'title'    => 'عنوان النموذج',
            'default'  => 'أرسل رسالة',
        ),
        array(
            'id'       => 'contact_phone_divider',
            'type'     => 'divide',
            'title'    => 'بطاقة الهاتف',
        ),
        array(
            'id'       => 'contact_phone_title',
            'type'     => 'text',
            'title'    => 'عنوان بطاقة الهاتف',
            'default'  => 'اتصل بنا',
        ),
        array(
            'id'       => 'contact_phone_subtitle',
            'type'     => 'text',
            'title'    => 'وصف بطاقة الهاتف',
            'default'  => 'متاحين من 9 صباحاً - 5 مساءً',
        ),
        array(
            'id'       => 'contact_email_divider',
            'type'     => 'divide',
            'title'    => 'بطاقة البريد الإلكتروني',
        ),
        array(
            'id'       => 'contact_email_title',
            'type'     => 'text',
            'title'    => 'عنوان بطاقة البريد',
            'default'  => 'البريد الإلكتروني',
        ),
        array(
            'id'       => 'contact_email_subtitle',
            'type'     => 'text',
            'title'    => 'وصف بطاقة البريد',
            'default'  => 'للتعاقدات والمبيعات',
        ),
        array(
            'id'       => 'contact_address_divider',
            'type'     => 'divide',
            'title'    => 'بطاقة العنوان',
        ),
        array(
            'id'       => 'contact_address_title',
            'type'     => 'text',
            'title'    => 'عنوان بطاقة العنوان',
            'default'  => 'المقر الرئيسي',
        ),
        array(
            'id'       => 'contact_map_divider',
            'type'     => 'divide',
            'title'    => 'الخريطة',
        ),
        array(
            'id'       => 'contact_map_enable',
            'type'     => 'switch',
            'title'    => 'إظهار الخريطة',
            'default'  => true,
        ),
        array(
            'id'       => 'contact_map_url',
            'type'     => 'textarea',
            'title'    => 'رابط أو كود Google Maps',
            'subtitle' => '<strong>يمكنك إدخال أحد الخيارات التالية:</strong><br>' . 
                         '1) رابط Embed من Google Maps (Share → Embed a map)<br>' . 
                         '2) رابط Share عادي<br>' . 
                         '3) كود iframe كامل<br><br>' . 
                         '<strong>للحصول على Embed URL:</strong><br>' . 
                         'افتح Google Maps → اختر الموقع → اضغط Share → اختر Embed a map → انسخ الرابط',
            'default'  => '',
            'placeholder' => 'https://www.google.com/maps/embed?pb=... أو <iframe src="..."></iframe>',
            'rows'     => 3,
        ),
        array(
            'id'       => 'contact_map_text',
            'type'     => 'text',
            'title'    => 'نص الخريطة',
            'default'  => 'موقع المصنع',
        ),
    ),
));

