<?php
/**
 * Taxonomy Helper Functions
 * 
 * Shared helper functions for registering taxonomies across presets
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get taxonomy labels for a given taxonomy
 *
 * @param string $singular Singular name.
 * @param string $plural   Plural name.
 * @return array Labels array.
 */
function alomran_get_taxonomy_labels($singular, $plural) {
    return array(
        'name'              => $plural,
        'singular_name'     => $singular,
        'search_items'      => 'البحث في الفئات',
        'all_items'         => 'جميع الفئات',
        'edit_item'         => 'تعديل الفئة',
        'update_item'       => 'تحديث الفئة',
        'add_new_item'      => 'إضافة فئة جديدة',
        'new_item_name'     => 'اسم الفئة الجديدة',
        'parent_item'       => 'الفئة الرئيسية',
        'parent_item_colon' => 'الفئة الرئيسية:',
    );
}

/**
 * Get taxonomy arguments
 *
 * @param string $slug Rewrite slug.
 * @return array Taxonomy arguments.
 */
function alomran_get_taxonomy_args($slug) {
    return array(
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => $slug),
        'show_in_rest'      => true,
    );
}

/**
 * Register a single taxonomy with helper functions
 *
 * @param string $taxonomy_name Taxonomy name.
 * @param string $post_type     Post type name.
 * @param string $singular      Singular label.
 * @param string $plural        Plural label.
 * @param string $slug          Rewrite slug.
 */
function alomran_register_taxonomy($taxonomy_name, $post_type, $singular, $plural, $slug) {
    if (taxonomy_exists($taxonomy_name)) {
        return;
    }
    
    if (!post_type_exists($post_type)) {
        return;
    }
    
    register_taxonomy(
        $taxonomy_name,
        $post_type,
        array_merge(
            array('labels' => alomran_get_taxonomy_labels($singular, $plural)),
            alomran_get_taxonomy_args($slug)
        )
    );
}

