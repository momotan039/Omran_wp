<?php
/**
 * Core Post Types Registration
 * 
 * All custom post types are registered here with hooks for preset customization.
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register all core post types.
 * 
 * @hook init (priority 10)
 */
function omran_core_register_post_types() {
    /**
     * Filter product post type arguments.
     * 
     * @since 1.0.0
     * 
     * @param array $args Product post type arguments.
     */
    $product_args = apply_filters('omran_core_product_post_type_args', array(
        'labels' => array(
            'name'               => __('المنتجات', 'alomran'),
            'singular_name'      => __('منتج', 'alomran'),
            'add_new'            => __('إضافة منتج جديد', 'alomran'),
            'add_new_item'       => __('إضافة منتج جديد', 'alomran'),
            'edit_item'          => __('تعديل المنتج', 'alomran'),
            'new_item'           => __('منتج جديد', 'alomran'),
            'view_item'          => __('عرض المنتج', 'alomran'),
            'search_items'       => __('البحث في المنتجات', 'alomran'),
            'not_found'          => __('لم يتم العثور على منتجات', 'alomran'),
            'not_found_in_trash' => __('لم يتم العثور على منتجات في سلة المحذوفات', 'alomran'),
            'all_items'          => __('جميع المنتجات', 'alomran'),
            'menu_name'          => __('المنتجات', 'alomran'),
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-products',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'      => array('slug' => 'products'),
        'show_in_rest' => true,
    ));
    
    register_post_type('product', $product_args);
    
    /**
     * Filter news post type arguments.
     * 
     * @since 1.0.0
     * 
     * @param array $args News post type arguments.
     */
    $news_args = apply_filters('omran_core_news_post_type_args', array(
        'labels' => array(
            'name'               => __('الأخبار', 'alomran'),
            'singular_name'      => __('خبر', 'alomran'),
            'add_new'            => __('إضافة خبر جديد', 'alomran'),
            'add_new_item'       => __('إضافة خبر جديد', 'alomran'),
            'edit_item'          => __('تعديل الخبر', 'alomran'),
            'new_item'           => __('خبر جديد', 'alomran'),
            'view_item'          => __('عرض الخبر', 'alomran'),
            'search_items'       => __('البحث في الأخبار', 'alomran'),
            'not_found'          => __('لم يتم العثور على أخبار', 'alomran'),
            'not_found_in_trash' => __('لم يتم العثور على أخبار في سلة المحذوفات', 'alomran'),
            'all_items'          => __('جميع الأخبار', 'alomran'),
            'menu_name'          => __('الأخبار', 'alomran'),
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-megaphone',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'author', 'date'),
        'rewrite'      => array('slug' => 'news'),
        'show_in_rest' => true,
    ));
    
    register_post_type('news', $news_args);
    
    /**
     * Filter testimonial post type arguments.
     * 
     * @since 1.0.0
     * 
     * @param array $args Testimonial post type arguments.
     */
    $testimonial_args = apply_filters('omran_core_testimonial_post_type_args', array(
        'labels' => array(
            'name'               => __('الشهادات', 'alomran'),
            'singular_name'      => __('شهادة', 'alomran'),
            'add_new'            => __('إضافة شهادة جديدة', 'alomran'),
            'add_new_item'       => __('إضافة شهادة جديدة', 'alomran'),
            'edit_item'          => __('تعديل الشهادة', 'alomran'),
            'new_item'           => __('شهادة جديدة', 'alomran'),
            'view_item'          => __('عرض الشهادة', 'alomran'),
            'search_items'       => __('البحث في الشهادات', 'alomran'),
            'not_found'          => __('لم يتم العثور على شهادات', 'alomran'),
            'not_found_in_trash' => __('لم يتم العثور على شهادات في سلة المحذوفات', 'alomran'),
            'all_items'          => __('جميع الشهادات', 'alomran'),
            'menu_name'          => __('الشهادات', 'alomran'),
        ),
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-format-quote',
        'supports'     => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
    ));
    
    register_post_type('testimonial', $testimonial_args);
    
    /**
     * Filter FAQ post type arguments.
     * 
     * @since 1.0.0
     * 
     * @param array $args FAQ post type arguments.
     */
    $faq_args = apply_filters('omran_core_faq_post_type_args', array(
        'labels' => array(
            'name'               => __('الأسئلة الشائعة', 'alomran'),
            'singular_name'      => __('سؤال شائع', 'alomran'),
            'add_new'            => __('إضافة سؤال جديد', 'alomran'),
            'add_new_item'       => __('إضافة سؤال جديد', 'alomran'),
            'edit_item'          => __('تعديل السؤال', 'alomran'),
            'new_item'           => __('سؤال جديد', 'alomran'),
            'view_item'          => __('عرض السؤال', 'alomran'),
            'search_items'       => __('البحث في الأسئلة', 'alomran'),
            'not_found'          => __('لم يتم العثور على أسئلة', 'alomran'),
            'not_found_in_trash' => __('لم يتم العثور على أسئلة في سلة المحذوفات', 'alomran'),
            'all_items'          => __('جميع الأسئلة', 'alomran'),
            'menu_name'          => __('الأسئلة الشائعة', 'alomran'),
        ),
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-editor-help',
        'supports'     => array('title', 'editor'),
        'show_in_rest' => true,
    ));
    
    register_post_type('faq', $faq_args);
    
    /**
     * Filter contact message post type arguments.
     * 
     * @since 1.0.0
     * 
     * @param array $args Contact message post type arguments.
     */
    $contact_message_args = apply_filters('omran_core_contact_message_post_type_args', array(
        'labels' => array(
            'name'               => __('رسائل التواصل', 'alomran'),
            'singular_name'      => __('رسالة', 'alomran'),
            'add_new'            => __('إضافة رسالة', 'alomran'),
            'add_new_item'       => __('إضافة رسالة جديدة', 'alomran'),
            'edit_item'          => __('عرض الرسالة', 'alomran'),
            'new_item'           => __('رسالة جديدة', 'alomran'),
            'view_item'          => __('عرض الرسالة', 'alomran'),
            'search_items'       => __('البحث في الرسائل', 'alomran'),
            'not_found'          => __('لم يتم العثور على رسائل', 'alomran'),
            'not_found_in_trash' => __('لم يتم العثور على رسائل في سلة المحذوفات', 'alomran'),
            'all_items'          => __('جميع الرسائل', 'alomran'),
            'menu_name'          => __('رسائل التواصل', 'alomran'),
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
    ));
    
    register_post_type('contact_message', $contact_message_args);
    
    /**
     * Action fired after all post types are registered.
     * 
     * @since 1.0.0
     */
    do_action('omran_core_post_types_registered');
}
add_action('init', 'omran_core_register_post_types', 10);

