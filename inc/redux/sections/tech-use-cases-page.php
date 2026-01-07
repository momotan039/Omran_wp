<?php
/**
 * Tech Preset - Use Cases Page Configuration
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
    'title'      => __('صفحة حالات الاستخدام', 'alomran'),
    'id'         => 'tech_use_cases_page',
    'subsection' => true,
    'parent'     => 'tech_pages_sections',
    'icon'       => 'el el-list',
    'fields'     => array(
        array(
            'id'       => 'tech_use_cases_page_title',
            'type'     => 'text',
            'title'    => __('عنوان الصفحة', 'alomran'),
            'default'  => 'حلول مصممة لتحدياتك',
        ),
        array(
            'id'       => 'tech_use_cases_page_subtitle',
            'type'     => 'textarea',
            'title'    => __('العنوان الفرعي', 'alomran'),
            'default'  => 'نحن نفهم تحديات السوق المحلي ونقدم حلولاً تقنية تعالج جذور المشكلة.',
        ),
        array(
            'id'       => 'tech_use_cases_items',
            'type'     => 'repeater',
            'title'    => __('حالات الاستخدام', 'alomran'),
            'subtitle' => __('أضف أو عدّل حالات الاستخدام. كل حالة تحتوي على عنوان، هدف، مشكلة، حل، نتيجة، أيقونة وصورة.', 'alomran'),
            'group_values' => true,
            'bind_title' => 'title',
            'item_name' => __('حالة استخدام', 'alomran'),
            'sortable' => true,
            'default'  => array(),
            'fields'   => array(
                array(
                    'id'       => 'title',
                    'type'     => 'text',
                    'title'    => __('العنوان', 'alomran'),
                    'subtitle' => __('عنوان حالة الاستخدام', 'alomran'),
                    'placeholder' => 'مثال: منصات التجارة الإلكترونية',
                    'default'  => '',
                ),
                array(
                    'id'       => 'target',
                    'type'     => 'text',
                    'title'    => __('الهدف / النوع', 'alomran'),
                    'subtitle' => __('نوع حالة الاستخدام (مثل: E-commerce, Fintech)', 'alomran'),
                    'placeholder' => 'مثال: E-commerce',
                    'default'  => '',
                ),
                array(
                    'id'       => 'problem',
                    'type'     => 'textarea',
                    'title'    => __('المشكلة', 'alomran'),
                    'subtitle' => __('وصف المشكلة التي يواجهها العميل', 'alomran'),
                    'placeholder' => 'مثال: تشتت المخزون والشحن بين منصات متعددة.',
                    'default'  => '',
                    'rows'     => 3,
                ),
                array(
                    'id'       => 'solution',
                    'type'     => 'textarea',
                    'title'    => __('الحل', 'alomran'),
                    'subtitle' => __('وصف الحل المقدم', 'alomran'),
                    'placeholder' => 'مثال: ربط API موحد يجمع كل شركات الشحن في واجهة واحدة.',
                    'default'  => '',
                    'rows'     => 3,
                ),
                array(
                    'id'       => 'result',
                    'type'     => 'textarea',
                    'title'    => __('النتيجة', 'alomran'),
                    'subtitle' => __('النتيجة المحققة من الحل', 'alomran'),
                    'placeholder' => 'مثال: زيادة سرعة معالجة الطلبات بنسبة 60%.',
                    'default'  => '',
                    'rows'     => 2,
                ),
                array(
                    'id'       => 'icon',
                    'type'     => 'text',
                    'title'    => __('الأيقونة', 'alomran'),
                    'subtitle' => __('أيقونة emoji لحالة الاستخدام', 'alomran'),
                    'placeholder' => 'مثال: 🛒',
                    'default'  => '',
                ),
                array(
                    'id'       => 'image',
                    'type'     => 'media',
                    'title'    => __('الصورة', 'alomran'),
                    'subtitle' => __('صورة توضيحية لحالة الاستخدام', 'alomran'),
                    'url'      => true,
                    'default'  => array(
                        'url' => 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?auto=format&fit=crop&q=80&w=2000',
                    ),
                ),
            ),
        ),
    ),
));








