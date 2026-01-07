<?php
/**
 * ACF Fields for Food Theme
 * 
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('acf_add_local_field_group')) {
    return;
}

/**
 * Register ACF fields for Food theme CPTs
 */
function alomran_register_food_acf_fields() {
    // Menu Item Fields
    acf_add_local_field_group(array(
        'key'    => 'group_menu_item_fields',
        'title'  => 'حقول صنف القائمة',
        'fields' => array(
            array(
                'key'           => 'field_menu_item_name_en',
                'label'         => 'الاسم بالإنجليزية',
                'name'          => 'name_en',
                'type'          => 'text',
                'instructions'  => 'اسم الطبق بالإنجليزية',
            ),
            array(
                'key'           => 'field_menu_item_price',
                'label'         => 'السعر',
                'name'          => 'price',
                'type'          => 'text',
                'required'      => 1,
                'default_value' => '0 ر.س',
                'placeholder'   => 'مثال: ٧٥ ر.س',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'menu_item',
                ),
            ),
        ),
    ));
    
    // Branch Fields
    acf_add_local_field_group(array(
        'key'    => 'group_branch_fields',
        'title'  => 'حقول الفرع',
        'fields' => array(
            array(
                'key'           => 'field_branch_name_en',
                'label'         => 'الاسم بالإنجليزية',
                'name'          => 'name_en',
                'type'          => 'text',
                'instructions'  => 'اسم الفرع بالإنجليزية',
            ),
            array(
                'key'           => 'field_branch_city',
                'label'         => 'المدينة',
                'name'          => 'city',
                'type'          => 'text',
                'required'      => 1,
                'placeholder'   => 'مثال: الرياض',
            ),
            array(
                'key'           => 'field_branch_address',
                'label'         => 'العنوان',
                'name'          => 'address',
                'type'          => 'text',
                'required'      => 1,
                'placeholder'   => 'مثال: حي السليمانية، الرياض',
            ),
            array(
                'key'           => 'field_branch_phone',
                'label'         => 'رقم الهاتف',
                'name'          => 'phone',
                'type'          => 'text',
                'required'      => 1,
                'placeholder'   => 'مثال: 011-234-5678',
            ),
            array(
                'key'           => 'field_branch_map_link',
                'label'         => 'رابط الخريطة',
                'name'          => 'map_link',
                'type'          => 'url',
                'placeholder'   => 'https://maps.google.com/...',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'branch',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'alomran_register_food_acf_fields');

