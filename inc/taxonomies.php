<?php
/**
 * Register theme taxonomies.
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register custom taxonomies.
 */
function alomran_register_taxonomies() {
    register_taxonomy(
        'product_category',
        'product',
        array(
            'labels' => array(
                'name'              => 'فئات المنتجات',
                'singular_name'     => 'فئة المنتج',
                'search_items'     => 'البحث في الفئات',
                'all_items'         => 'جميع الفئات',
                'edit_item'        => 'تعديل الفئة',
                'update_item'      => 'تحديث الفئة',
                'add_new_item'      => 'إضافة فئة جديدة',
                'new_item_name'     => 'اسم الفئة الجديدة',
                'parent_item'       => 'الفئة الرئيسية',
                'parent_item_colon' => 'الفئة الرئيسية:',
            ),
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'product-category'),
            'show_in_rest'      => true,
        )
    );

    register_taxonomy(
        'news_category',
        'news',
        array(
            'labels' => array(
                'name'              => 'فئات الأخبار',
                'singular_name'     => 'فئة الأخبار',
                'search_items'      => 'البحث في الفئات',
                'all_items'         => 'جميع الفئات',
                'edit_item'         => 'تعديل الفئة',
                'update_item'       => 'تحديث الفئة',
                'add_new_item'      => 'إضافة فئة جديدة',
                'new_item_name'     => 'اسم الفئة الجديدة',
                'parent_item'       => 'الفئة الرئيسية',
                'parent_item_colon' => 'الفئة الرئيسية:',
            ),
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'news-category'),
            'show_in_rest'      => true,
        )
    );
}
add_action('init', 'alomran_register_taxonomies');

