<?php
/**
 * Hero Section Configuration
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => 'قسم البطل (Hero)',
    'id'         => 'hero_section',
    'subsection' => true,
    'parent'     => 'homepage_sections',
    'icon'       => 'el el-picture',
    'fields' => array(
        array(
            'id'       => 'hero_enable',
            'type'     => 'switch',
            'title'    => 'تفعيل قسم البطل',
            'default'  => true,
        ),
        array(
            'id'       => 'hero_badge',
            'type'     => 'text',
            'title'    => 'الشارة (Badge)',
            'default'  => 'الرائدون في مصر',
            'required' => array('hero_enable', '=', true),
        ),
        array(
            'id'       => 'hero_title',
            'type'     => 'text',
            'title'    => 'العنوان الرئيسي',
            'default'  => 'جودة تدوم.. لمستقبل أنقى',
            'required' => array('hero_enable', '=', true),
        ),
        array(
            'id'       => 'hero_subtitle',
            'type'     => 'text',
            'title'    => 'العنوان الفرعي',
            'default'  => 'في كل قطرة ومشروع',
            'required' => array('hero_enable', '=', true),
        ),
        array(
            'id'       => 'hero_description',
            'type'     => 'textarea',
            'title'    => 'الوصف',
            'default'  => 'نقدم حلولاً هندسية متكاملة لشبكات الصرف ومعالجة المياه. منتجات مصممة لتدوم، وتحمي استثماراتك من مخاطر الانسداد والتآكل.',
            'required' => array('hero_enable', '=', true),
        ),
        array(
            'id'       => 'hero_button1_text',
            'type'     => 'text',
            'title'    => 'نص الزر الأول',
            'default'  => 'تصفح المنتجات',
            'required' => array('hero_enable', '=', true),
        ),
        array(
            'id'       => 'hero_button1_url',
            'type'     => 'text',
            'title'    => 'رابط الزر الأول',
            'default'  => '/products',
            'required' => array('hero_enable', '=', true),
        ),
        array(
            'id'       => 'hero_button2_text',
            'type'     => 'text',
            'title'    => 'نص الزر الثاني',
            'default'  => 'استشارة مجانية',
            'required' => array('hero_enable', '=', true),
        ),
        array(
            'id'       => 'hero_button2_url',
            'type'     => 'text',
            'title'    => 'رابط الزر الثاني',
            'default'  => '/contact',
            'required' => array('hero_enable', '=', true),
        ),
        array(
            'id'       => 'hero_background_image',
            'type'     => 'media',
            'title'    => 'صورة الخلفية',
            'url'      => true,
            'required' => array('hero_enable', '=', true),
        ),
        array(
            'id'       => 'hero_show_seal',
            'type'     => 'switch',
            'title'    => 'إظهار شارة الجودة',
            'default'  => true,
            'required' => array('hero_enable', '=', true),
        ),
    ),
));


