<?php
/**
 * Register custom post types.
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register all theme CPTs.
 */
function alomran_register_post_types() {
    register_post_type(
        'product',
        array(
            'labels' => array(
                'name'               => 'المنتجات',
                'singular_name'      => 'منتج',
                'add_new'            => 'إضافة منتج جديد',
                'add_new_item'       => 'إضافة منتج جديد',
                'edit_item'          => 'تعديل المنتج',
                'new_item'           => 'منتج جديد',
                'view_item'          => 'عرض المنتج',
                'search_items'       => 'البحث في المنتجات',
                'not_found'          => 'لم يتم العثور على منتجات',
                'not_found_in_trash' => 'لم يتم العثور على منتجات في سلة المحذوفات',
                'all_items'          => 'جميع المنتجات',
                'menu_name'          => 'المنتجات',
            ),
            'public'       => true,
            'has_archive'  => true,
            'menu_icon'    => 'dashicons-products',
            'supports'     => array('title', 'editor', 'thumbnail', 'excerpt'),
            'rewrite'      => array('slug' => 'products'),
            'show_in_rest' => true,
        )
    );

    register_post_type(
        'news',
        array(
            'labels' => array(
                'name'               => 'الأخبار',
                'singular_name'      => 'خبر',
                'add_new'            => 'إضافة خبر جديد',
                'add_new_item'       => 'إضافة خبر جديد',
                'edit_item'          => 'تعديل الخبر',
                'new_item'           => 'خبر جديد',
                'view_item'          => 'عرض الخبر',
                'search_items'       => 'البحث في الأخبار',
                'not_found'          => 'لم يتم العثور على أخبار',
                'not_found_in_trash' => 'لم يتم العثور على أخبار في سلة المحذوفات',
                'all_items'          => 'جميع الأخبار',
                'menu_name'          => 'الأخبار',
            ),
            'public'       => true,
            'has_archive'  => true,
            'menu_icon'    => 'dashicons-megaphone',
            'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'author', 'date'),
            'rewrite'      => array('slug' => 'news'),
            'show_in_rest' => true,
        )
    );

    register_post_type(
        'testimonial',
        array(
            'labels' => array(
                'name'               => 'الشهادات',
                'singular_name'      => 'شهادة',
                'add_new'            => 'إضافة شهادة جديدة',
                'add_new_item'       => 'إضافة شهادة جديدة',
                'edit_item'          => 'تعديل الشهادة',
                'new_item'           => 'شهادة جديدة',
                'view_item'          => 'عرض الشهادة',
                'search_items'       => 'البحث في الشهادات',
                'not_found'          => 'لم يتم العثور على شهادات',
                'not_found_in_trash' => 'لم يتم العثور على شهادات في سلة المحذوفات',
                'all_items'          => 'جميع الشهادات',
                'menu_name'          => 'الشهادات',
            ),
            'public'       => true,
            'has_archive'  => false,
            'menu_icon'    => 'dashicons-format-quote',
            'supports'     => array('title', 'editor', 'thumbnail'),
            'show_in_rest' => true,
        )
    );

    register_post_type(
        'faq',
        array(
            'labels' => array(
                'name'               => 'الأسئلة الشائعة',
                'singular_name'      => 'سؤال شائع',
                'add_new'            => 'إضافة سؤال جديد',
                'add_new_item'       => 'إضافة سؤال جديد',
                'edit_item'          => 'تعديل السؤال',
                'new_item'           => 'سؤال جديد',
                'view_item'          => 'عرض السؤال',
                'search_items'       => 'البحث في الأسئلة',
                'not_found'          => 'لم يتم العثور على أسئلة',
                'not_found_in_trash' => 'لم يتم العثور على أسئلة في سلة المحذوفات',
                'all_items'          => 'جميع الأسئلة',
                'menu_name'          => 'الأسئلة الشائعة',
            ),
            'public'       => true,
            'has_archive'  => false,
            'menu_icon'    => 'dashicons-editor-help',
            'supports'     => array('title', 'editor'),
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'alomran_register_post_types');

