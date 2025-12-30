<?php
/**
 * Tech Preset - Contact Page Configuration
 * 
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Redux')) {
    return;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => __('صفحة التواصل', 'alomran'),
    'id'         => 'tech_contact_page',
    'subsection' => true,
    'parent'     => 'tech_pages_sections',
    'icon'       => 'el el-envelope',
    'fields'     => array(
        array(
            'id'       => 'tech_contact_title',
            'type'     => 'text',
            'title'    => __('عنوان قسم التواصل', 'alomran'),
            'default'  => 'تواصل معنا',
        ),
        array(
            'id'       => 'tech_contact_description',
            'type'     => 'textarea',
            'title'    => __('وصف قسم التواصل', 'alomran'),
            'default'  => 'فريقنا التقني متاح لخدمتك وتقديم الاستشارات الفنية على مدار الساعة.',
        ),
        array(
            'id'       => 'tech_contact_address',
            'type'     => 'text',
            'title'    => __('العنوان', 'alomran'),
            'default'  => 'برج الابتكار، الرياض، السعودية',
        ),
        array(
            'id'       => 'tech_contact_email',
            'type'     => 'text',
            'title'    => __('البريد الإلكتروني', 'alomran'),
            'default'  => 'hello@etqan-saas.com',
            'validate' => 'email',
        ),
    ),
));



