<?php
/**
 * Common Custom Post Types
 * 
 * CPTs that are shared across all presets
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register common CPTs (shared across all presets)
 */
function alomran_register_common_post_types() {
    // Contact messages - shared across all presets
    register_post_type(
        'contact_message',
        array(
            'labels' => array(
                'name'               => 'رسائل التواصل',
                'singular_name'      => 'رسالة',
                'add_new'            => 'إضافة رسالة',
                'add_new_item'       => 'إضافة رسالة جديدة',
                'edit_item'          => 'عرض الرسالة',
                'new_item'           => 'رسالة جديدة',
                'view_item'          => 'عرض الرسالة',
                'search_items'       => 'البحث في الرسائل',
                'not_found'          => 'لم يتم العثور على رسائل',
                'not_found_in_trash' => 'لم يتم العثور على رسائل في سلة المحذوفات',
                'all_items'          => 'جميع الرسائل',
                'menu_name'          => 'رسائل التواصل',
            ),
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'has_archive'        => false,
            'menu_icon'          => 'dashicons-email-alt',
            'supports'           => array('title', 'editor'),
            'capability_type'    => 'post',
            'capabilities'       => array(
                'create_posts' => false, // Prevent manual creation
            ),
            'map_meta_cap'       => true,
            'show_in_rest'       => false,
        )
    );
    
    // Demo requests - for marketing preset
    register_post_type(
        'demo_request',
        array(
            'labels' => array(
                'name'               => 'طلبات الديمو',
                'singular_name'      => 'طلب ديمو',
                'add_new'            => 'إضافة طلب',
                'add_new_item'       => 'إضافة طلب جديد',
                'edit_item'          => 'عرض الطلب',
                'new_item'           => 'طلب جديد',
                'view_item'          => 'عرض الطلب',
                'search_items'       => 'البحث في الطلبات',
                'not_found'          => 'لم يتم العثور على طلبات',
                'not_found_in_trash' => 'لم يتم العثور على طلبات في سلة المحذوفات',
                'all_items'          => 'جميع الطلبات',
                'menu_name'          => 'طلبات الديمو',
            ),
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'has_archive'        => false,
            'menu_icon'          => 'dashicons-calendar-alt',
            'supports'           => array('title', 'editor'),
            'capability_type'    => 'post',
            'capabilities'       => array(
                'create_posts' => false, // Prevent manual creation
            ),
            'map_meta_cap'       => true,
            'show_in_rest'       => false,
        )
    );
}
add_action('init', 'alomran_register_common_post_types', 10);




