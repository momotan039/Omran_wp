<?php
/**
 * Tech Preset - Social Media Configuration
 * 
 * @package AlOmran
 * @subpackage Tech
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
    'id'         => 'tech_social_settings',
    'subsection' => true,
    'parent'     => 'tech_general_sections',
    'icon'       => 'el el-share',
    'fields'     => array(
        array(
            'id'       => 'tech_social_twitter',
            'type'     => 'text',
            'title'    => __('تويتر', 'alomran'),
            'validate' => 'url',
        ),
        array(
            'id'       => 'tech_social_linkedin',
            'type'     => 'text',
            'title'    => __('لينكد إن', 'alomran'),
            'validate' => 'url',
        ),
        array(
            'id'       => 'tech_social_facebook',
            'type'     => 'text',
            'title'    => __('فيسبوك', 'alomran'),
            'validate' => 'url',
        ),
        array(
            'id'       => 'tech_social_instagram',
            'type'     => 'text',
            'title'    => __('إنستغرام', 'alomran'),
            'validate' => 'url',
        ),
    ),
));



