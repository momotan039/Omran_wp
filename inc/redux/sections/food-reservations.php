<?php
/**
 * Food Preset - Reservations Section Configuration
 * 
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Redux')) {
    return;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => __('الحجوزات', 'alomran'),
    'id'         => 'food_reservations_section',
    'subsection' => true,
    'parent'     => 'food_pages_sections',
    'icon'       => 'el el-calendar',
    'fields'     => array(
        array(
            'id'       => 'food_reservations_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل نظام الحجوزات', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'food_reservations_title',
            'type'     => 'text',
            'title'    => __('عنوان صفحة الحجوزات', 'alomran'),
            'default'  => 'احجز طاولتك',
            'required' => array('food_reservations_enable', '=', true),
        ),
        array(
            'id'       => 'food_reservations_description',
            'type'     => 'textarea',
            'title'    => __('الوصف', 'alomran'),
            'default'  => 'اختر الوقت والفرع المناسب لك، وسيقوم فريق "الجوهرة" بتجهيز كل شيء لتكون أمسيتك مثالية.',
            'required' => array('food_reservations_enable', '=', true),
        ),
        array(
            'id'       => 'food_reservations_email',
            'type'     => 'text',
            'title'    => __('البريد الإلكتروني لاستقبال الحجوزات', 'alomran'),
            'validate' => 'email',
            'required' => array('food_reservations_enable', '=', true),
        ),
        array(
            'id'       => 'food_reservations_max_guests',
            'type'     => 'spinner',
            'title'    => __('الحد الأقصى لعدد الضيوف', 'alomran'),
            'default'  => 20,
            'min'      => 1,
            'max'      => 50,
            'step'     => 1,
            'required' => array('food_reservations_enable', '=', true),
        ),
        array(
            'id'       => 'food_reservations_hero_label',
            'type'     => 'text',
            'title'    => __('تسمية Hero Section', 'alomran'),
            'subtitle' => __('التسمية الصغيرة في Hero Section (مثل: احجز طاولتك)', 'alomran'),
            'default'  => 'احجز طاولتك',
            'required' => array('food_reservations_enable', '=', true),
        ),
        array(
            'id'       => 'food_reservations_info_label',
            'type'     => 'text',
            'title'    => __('تسمية قسم المعلومات', 'alomran'),
            'subtitle' => __('التسمية الصغيرة أعلى قسم المعلومات (مثل: معلومات الحجز)', 'alomran'),
            'default'  => 'معلومات الحجز',
            'required' => array('food_reservations_enable', '=', true),
        ),
        array(
            'id'       => 'food_reservations_form_label',
            'type'     => 'text',
            'title'    => __('تسمية النموذج', 'alomran'),
            'subtitle' => __('التسمية الصغيرة أعلى نموذج الحجز (مثل: نموذج الحجز)', 'alomran'),
            'default'  => 'نموذج الحجز',
            'required' => array('food_reservations_enable', '=', true),
        ),
        array(
            'id'       => 'food_reservations_form_title',
            'type'     => 'text',
            'title'    => __('عنوان النموذج', 'alomran'),
            'subtitle' => __('العنوان الرئيسي للنموذج (مثل: املأ البيانات)', 'alomran'),
            'default'  => 'املأ البيانات',
            'required' => array('food_reservations_enable', '=', true),
        ),
        array(
            'id'       => 'food_reservations_form_description',
            'type'     => 'text',
            'title'    => __('وصف النموذج', 'alomran'),
            'subtitle' => __('الوصف أسفل عنوان النموذج', 'alomran'),
            'default'  => 'سنقوم بالتواصل معك لتأكيد الحجز',
            'required' => array('food_reservations_enable', '=', true),
        ),
        array(
            'id'       => 'food_reservations_feature_1_title',
            'type'     => 'text',
            'title'    => __('عنوان الميزة الأولى', 'alomran'),
            'default'  => 'الحجز متاح للعائلات والأفراد',
            'required' => array('food_reservations_enable', '=', true),
        ),
        array(
            'id'       => 'food_reservations_feature_1_description',
            'type'     => 'text',
            'title'    => __('وصف الميزة الأولى', 'alomran'),
            'default'  => 'نوفر أجواء مناسبة لجميع الأذواق',
            'required' => array('food_reservations_enable', '=', true),
        ),
        array(
            'id'       => 'food_reservations_feature_2_title',
            'type'     => 'text',
            'title'    => __('عنوان الميزة الثانية', 'alomran'),
            'default'  => 'ركن خاص للمناسبات',
            'required' => array('food_reservations_enable', '=', true),
        ),
        array(
            'id'       => 'food_reservations_feature_2_description',
            'type'     => 'text',
            'title'    => __('وصف الميزة الثانية', 'alomran'),
            'default'  => 'مكان مخصص للاحتفالات الخاصة',
            'required' => array('food_reservations_enable', '=', true),
        ),
        array(
            'id'       => 'food_reservations_feature_3_title',
            'type'     => 'text',
            'title'    => __('عنوان الميزة الثالثة', 'alomran'),
            'default'  => 'خدمة عملاء على مدار الساعة',
            'required' => array('food_reservations_enable', '=', true),
        ),
        array(
            'id'       => 'food_reservations_feature_3_description',
            'type'     => 'text',
            'title'    => __('وصف الميزة الثالثة', 'alomran'),
            'default'  => 'فريقنا جاهز لمساعدتك في أي وقت',
            'required' => array('food_reservations_enable', '=', true),
        ),
    ),
));

