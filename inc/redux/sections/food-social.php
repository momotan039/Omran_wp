<?php
/**
 * Food Preset - Social Media Links Configuration
 * 
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Redux')) {
    return;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => __('روابط التواصل الاجتماعي', 'alomran'),
    'id'         => 'food_social_section',
    'subsection' => true,
    'parent'     => 'food_general_sections',
    'icon'       => 'el el-share',
    'fields'     => array(
        array(
            'id'       => 'food_social_enable',
            'type'     => 'switch',
            'title'    => __('تفعيل روابط التواصل الاجتماعي', 'alomran'),
            'default'  => true,
        ),
        array(
            'id'       => 'food_social_instagram',
            'type'     => 'text',
            'title'    => __('رابط Instagram', 'alomran'),
            'subtitle' => __('أدخل رابط حساب Instagram الخاص بك', 'alomran'),
            'validate' => 'url',
            'default'  => 'https://instagram.com/aljawhara',
            'placeholder' => 'https://instagram.com/your-account',
            'required' => array('food_social_enable', '=', true),
        ),
        array(
            'id'       => 'food_social_twitter',
            'type'     => 'text',
            'title'    => __('رابط Twitter', 'alomran'),
            'subtitle' => __('أدخل رابط حساب Twitter الخاص بك', 'alomran'),
            'validate' => 'url',
            'default'  => 'https://twitter.com/aljawhara',
            'placeholder' => 'https://twitter.com/your-account',
            'required' => array('food_social_enable', '=', true),
        ),
        array(
            'id'       => 'food_social_facebook',
            'type'     => 'text',
            'title'    => __('رابط Facebook', 'alomran'),
            'subtitle' => __('أدخل رابط صفحة Facebook الخاصة بك', 'alomran'),
            'validate' => 'url',
            'default'  => 'https://facebook.com/aljawhara',
            'placeholder' => 'https://facebook.com/your-page',
            'required' => array('food_social_enable', '=', true),
        ),
    ),
));

