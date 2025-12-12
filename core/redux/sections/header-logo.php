<?php
/**
 * Header Logo Settings
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

Redux::setSection(
    'alomran_options',
    array(
        'title'  => esc_html__('شعار الموقع', 'alomran'),
        'id'     => 'header_logo_section',
        'icon'   => 'el el-picture',
        'fields' => array(
            array(
                'id'       => 'header_logo_icon',
                'type'     => 'media',
                'title'    => esc_html__('أيقونة الشعار', 'alomran'),
                'subtitle' => esc_html__('قم برفع صورة الأيقونة التي تريد عرضها بدلاً من الأيقونة الافتراضية', 'alomran'),
                'desc'     => esc_html__('الحجم الموصى به: 40x40 بكسل. سيتم عرضها في الهيدر والـ Loader', 'alomran'),
                'default'  => '',
            ),
            array(
                'id'       => 'header_logo_show_title',
                'type'     => 'switch',
                'title'    => esc_html__('إظهار العنوان', 'alomran'),
                'subtitle' => esc_html__('إظهار أو إخفاء اسم الشركة بجانب الأيقونة', 'alomran'),
                'default'  => true,
                'on'       => esc_html__('إظهار', 'alomran'),
                'off'      => esc_html__('إخفاء', 'alomran'),
            ),
            array(
                'id'       => 'header_logo_show_subtitle',
                'type'     => 'switch',
                'title'    => esc_html__('إظهار العنوان الفرعي', 'alomran'),
                'subtitle' => esc_html__('إظهار أو إخفاء شعار الشركة تحت العنوان', 'alomran'),
                'default'  => true,
                'on'       => esc_html__('إظهار', 'alomran'),
                'off'      => esc_html__('إخفاء', 'alomran'),
            ),
            array(
                'id'       => 'header_logo_custom_title',
                'type'     => 'text',
                'title'    => esc_html__('عنوان مخصص (اختياري)', 'alomran'),
                'subtitle' => esc_html__('اتركه فارغاً لاستخدام اسم الشركة من الإعدادات العامة', 'alomran'),
                'default'  => '',
                'required' => array('header_logo_show_title', '=', true),
            ),
            array(
                'id'       => 'header_logo_custom_subtitle',
                'type'     => 'text',
                'title'    => esc_html__('عنوان فرعي مخصص (اختياري)', 'alomran'),
                'subtitle' => esc_html__('اتركه فارغاً لاستخدام شعار الشركة من الإعدادات العامة', 'alomran'),
                'default'  => '',
                'required' => array('header_logo_show_subtitle', '=', true),
            ),
        ),
    )
);

