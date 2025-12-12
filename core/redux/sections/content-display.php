<?php
/**
 * Content Display Flexibility Section
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => 'عرض المحتوى',
    'id'         => 'content_display',
    'icon'       => 'el el-view-mode',
    'desc'       => 'إعدادات عرض المحتوى والأقسام',
    'fields' => array(
        // Archive Display Options
        array(
            'id'       => 'archive_display_section',
            'type'     => 'section',
            'title'    => 'عرض الأرشيف',
            'indent'   => true,
        ),
        array(
            'id'       => 'products_archive_view',
            'type'     => 'button_set',
            'title'    => 'عرض أرشيف المنتجات',
            'options'  => array(
                'grid' => 'شبكة',
                'list' => 'قائمة',
            ),
            'default'  => 'grid',
        ),
        array(
            'id'       => 'products_archive_columns',
            'type'     => 'select',
            'title'    => 'عدد الأعمدة (عرض الشبكة)',
            'options'  => array(
                '2' => 'عمودان',
                '3' => 'ثلاثة أعمدة',
                '4' => 'أربعة أعمدة',
            ),
            'default'  => '3',
            'required' => array('products_archive_view', '=', 'grid'),
        ),
        array(
            'id'       => 'news_archive_view',
            'type'     => 'button_set',
            'title'    => 'عرض أرشيف الأخبار',
            'options'  => array(
                'grid' => 'شبكة',
                'list' => 'قائمة',
            ),
            'default'  => 'grid',
        ),
        array(
            'id'       => 'news_archive_columns',
            'type'     => 'select',
            'title'    => 'عدد الأعمدة (عرض الشبكة)',
            'options'  => array(
                '2' => 'عمودان',
                '3' => 'ثلاثة أعمدة',
            ),
            'default'  => '2',
            'required' => array('news_archive_view', '=', 'grid'),
        ),
        
        // Section Visibility
        array(
            'id'       => 'section_visibility_section',
            'type'     => 'section',
            'title'    => 'إظهار/إخفاء الأقسام',
            'indent'   => true,
        ),
        array(
            'id'       => 'show_breadcrumbs',
            'type'     => 'switch',
            'title'    => 'إظهار مسار التنقل (Breadcrumbs)',
            'default'  => true,
        ),
        array(
            'id'       => 'show_related_products',
            'type'     => 'switch',
            'title'    => 'إظهار منتجات ذات صلة',
            'default'  => true,
        ),
        array(
            'id'       => 'show_related_news',
            'type'     => 'switch',
            'title'    => 'إظهار أخبار ذات صلة',
            'default'  => true,
        ),
        array(
            'id'       => 'show_share_buttons',
            'type'     => 'switch',
            'title'    => 'إظهار أزرار المشاركة',
            'default'  => true,
        ),
        array(
            'id'       => 'show_author_info',
            'type'     => 'switch',
            'title'    => 'إظهار معلومات المؤلف',
            'default'  => false,
        ),
        array(
            'id'       => 'show_post_date',
            'type'     => 'switch',
            'title'    => 'إظهار تاريخ النشر',
            'default'  => true,
        ),
    ),
));

