<?php
/**
 * Products Section Configuration
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'  => 'قسم المنتجات',
    'id'     => 'products_section',
    'icon'   => 'el el-shopping-cart',
    'fields' => array(
        array(
            'id'       => 'products_enable',
            'type'     => 'switch',
            'title'    => 'تفعيل قسم المنتجات',
            'default'  => true,
        ),
        array(
            'id'       => 'products_title',
            'type'     => 'text',
            'title'    => 'عنوان القسم',
            'default'  => 'منتجات مختارة',
            'required' => array('products_enable', '=', true),
        ),
        array(
            'id'       => 'products_count',
            'type'     => 'spinner',
            'title'    => 'عدد المنتجات',
            'default'  => 3,
            'min'      => 1,
            'max'      => 12,
            'step'     => 1,
            'required' => array('products_enable', '=', true),
        ),
        array(
            'id'       => 'products_show_all_link',
            'type'     => 'switch',
            'title'    => 'إظهار رابط "عرض الكل"',
            'default'  => true,
            'required' => array('products_enable', '=', true),
        ),
    ),
));

