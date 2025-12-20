<?php
/**
 * Food Preset - Custom Post Types
 * 
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Food preset CPTs
 */
function alomran_food_register_post_types() {
    // Menu Item CPT
    alomran_register_cpt('menu_item', array(
        'labels' => array(
            'name'               => 'قائمة الطعام',
            'singular_name'      => 'صنف القائمة',
            'add_new'            => 'إضافة صنف جديد',
            'add_new_item'       => 'إضافة صنف جديد',
            'edit_item'          => 'تعديل الصنف',
            'new_item'           => 'صنف جديد',
            'view_item'          => 'عرض الصنف',
            'search_items'       => 'البحث في الأصناف',
            'not_found'          => 'لم يتم العثور على أصناف',
            'not_found_in_trash' => 'لم يتم العثور على أصناف في سلة المحذوفات',
            'all_items'          => 'جميع الأصناف',
            'menu_name'          => 'قائمة الطعام',
            'archives'           => 'قائمة الطعام',
        ),
        'menu_icon' => 'dashicons-food',
        'rewrite'   => array(
            'slug'       => 'menu',
            'with_front' => false,
            'feeds'      => true,
            'pages'      => true,
        ),
    ));

    // Blog Post CPT
    alomran_register_cpt('blog_post', array(
        'labels' => array(
            'name'               => 'المجلة',
            'singular_name'      => 'مقال',
            'add_new'            => 'إضافة مقال جديد',
            'add_new_item'       => 'إضافة مقال جديد',
            'edit_item'          => 'تعديل المقال',
            'new_item'           => 'مقال جديد',
            'view_item'          => 'عرض المقال',
            'search_items'       => 'البحث في المقالات',
            'not_found'          => 'لم يتم العثور على مقالات',
            'not_found_in_trash' => 'لم يتم العثور على مقالات في سلة المحذوفات',
            'all_items'          => 'جميع المقالات',
            'menu_name'          => 'المجلة',
        ),
        'menu_icon' => 'dashicons-edit',
        'supports'  => array('title', 'editor', 'thumbnail', 'excerpt', 'author', 'date'),
        'rewrite'   => array('slug' => 'blog'),
    ));

    // Branch CPT
    alomran_register_cpt('branch', array(
        'labels' => array(
            'name'               => 'الفروع',
            'singular_name'      => 'فرع',
            'add_new'            => 'إضافة فرع جديد',
            'add_new_item'       => 'إضافة فرع جديد',
            'edit_item'          => 'تعديل الفرع',
            'new_item'           => 'فرع جديد',
            'view_item'          => 'عرض الفرع',
            'search_items'       => 'البحث في الفروع',
            'not_found'          => 'لم يتم العثور على فروع',
            'not_found_in_trash' => 'لم يتم العثور على فروع في سلة المحذوفات',
            'all_items'          => 'جميع الفروع',
            'menu_name'          => 'الفروع',
        ),
        'has_archive' => false,
        'menu_icon'   => 'dashicons-location',
        'supports'    => array('title', 'editor', 'thumbnail'),
        'rewrite'     => array(
            'slug'       => 'branch',
            'with_front' => false,
            'feeds'      => true,
            'pages'      => true,
        ),
    ));

    // Reservation CPT (for storing reservations)
    register_post_type(
        'reservation',
        array(
            'labels' => array(
                'name'               => 'الحجوزات',
                'singular_name'      => 'حجز',
                'add_new'            => 'إضافة حجز',
                'add_new_item'       => 'إضافة حجز جديد',
                'edit_item'          => 'عرض الحجز',
                'new_item'           => 'حجز جديد',
                'view_item'          => 'عرض الحجز',
                'search_items'       => 'البحث في الحجوزات',
                'not_found'          => 'لم يتم العثور على حجوزات',
                'not_found_in_trash' => 'لم يتم العثور على حجوزات في سلة المحذوفات',
                'all_items'          => 'جميع الحجوزات',
                'menu_name'          => 'الحجوزات',
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
add_action('init', 'alomran_food_register_post_types', 10);

/**
 * Change archive title for menu_item CPT
 */
function alomran_food_archive_title($title) {
    if (is_post_type_archive('menu_item')) {
        return 'قائمة الطعام';
    }
    return $title;
}
add_filter('get_the_archive_title', 'alomran_food_archive_title');
add_filter('post_type_archive_title', 'alomran_food_archive_title');

/**
 * Flush rewrite rules on theme activation or preset change
 */
function alomran_food_flush_rewrite_rules() {
    // Only flush if food preset is active
    $current_preset = alomran_get_option('theme_preset', 'industrial');
    if ($current_preset === 'food') {
        flush_rewrite_rules(false);
    }
}

// Flush on theme activation
add_action('after_switch_theme', 'alomran_food_flush_rewrite_rules');

// Flush when preset changes to food
add_action('redux/options/alomran_options/saved', function() {
    $preset = alomran_get_option('theme_preset', 'industrial');
    if ($preset === 'food') {
        flush_rewrite_rules(false);
    }
});
