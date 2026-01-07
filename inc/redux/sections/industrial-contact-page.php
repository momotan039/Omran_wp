<?php
/**
 * Industrial Preset - Contact Page Configuration
 * 
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => __('صفحة التواصل', 'alomran'),
    'id'         => 'industrial_contact_page',
    'subsection' => false,
    'icon'       => 'el el-envelope',
    'fields'     => array(
        array(
            'id'       => 'industrial_contact_page_title',
            'type'     => 'text',
            'title'    => __('عنوان الصفحة', 'alomran'),
            'default'  => 'تواصل معنا',
        ),
        array(
            'id'       => 'industrial_contact_page_subtitle',
            'type'     => 'text',
            'title'    => __('الوصف', 'alomran'),
            'default'  => 'فريقنا جاهز للرد على استفساراتكم وتقديم الدعم الفني',
        ),
        array(
            'id'       => 'industrial_contact_form_title',
            'type'     => 'text',
            'title'    => __('عنوان النموذج', 'alomran'),
            'default'  => 'أرسل رسالة',
        ),
        array(
            'id'       => 'industrial_contact_phone_divider',
            'type'     => 'divide',
            'title'    => __('بطاقة الهاتف', 'alomran'),
        ),
        array(
            'id'       => 'industrial_contact_phone_title',
            'type'     => 'text',
            'title'    => __('عنوان بطاقة الهاتف', 'alomran'),
            'default'  => 'اتصل بنا',
        ),
        array(
            'id'       => 'industrial_contact_phone_subtitle',
            'type'     => 'text',
            'title'    => __('وصف بطاقة الهاتف', 'alomran'),
            'default'  => 'متاحين من 9 صباحاً - 5 مساءً',
        ),
        array(
            'id'       => 'industrial_contact_email_divider',
            'type'     => 'divide',
            'title'    => __('بطاقة البريد الإلكتروني', 'alomran'),
        ),
        array(
            'id'       => 'industrial_contact_email_title',
            'type'     => 'text',
            'title'    => __('عنوان بطاقة البريد', 'alomran'),
            'default'  => 'البريد الإلكتروني',
        ),
        array(
            'id'       => 'industrial_contact_email_subtitle',
            'type'     => 'text',
            'title'    => __('وصف بطاقة البريد', 'alomran'),
            'default'  => 'للتعاقدات والمبيعات',
        ),
        array(
            'id'       => 'industrial_contact_address_divider',
            'type'     => 'divide',
            'title'    => __('بطاقة العنوان', 'alomran'),
        ),
        array(
            'id'       => 'industrial_contact_address_title',
            'type'     => 'text',
            'title'    => __('عنوان بطاقة العنوان', 'alomran'),
            'default'  => 'المقر الرئيسي',
        ),
        array(
            'id'       => 'industrial_contact_map_divider',
            'type'     => 'divide',
            'title'    => __('الخريطة', 'alomran'),
        ),
        array(
            'id'       => 'industrial_contact_map_enable',
            'type'     => 'switch',
            'title'    => __('إظهار الخريطة', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'industrial_contact_map_url',
            'type'     => 'textarea',
            'title'    => __('رابط أو كود Google Maps', 'alomran'),
            'subtitle' => __('<strong>يمكنك إدخال أحد الخيارات التالية:</strong><br>1) رابط Embed من Google Maps (Share → Embed a map)<br>2) رابط Share عادي<br>3) كود iframe كامل<br><br><strong>للحصول على Embed URL:</strong><br>افتح Google Maps → اختر الموقع → اضغط Share → اختر Embed a map → انسخ الرابط', 'alomran'),
            'default'  => '',
            'placeholder' => 'https://www.google.com/maps/embed?pb=... أو <iframe src="..."></iframe>',
            'rows'     => 3,
        ),
        array(
            'id'       => 'industrial_contact_map_text',
            'type'     => 'text',
            'title'    => __('نص الخريطة', 'alomran'),
            'default'  => 'موقع المصنع',
        ),
    ),
));


