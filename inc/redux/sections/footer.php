<?php
/**
 * Footer Section Configuration
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => 'التذييل (Footer)',
    'id'         => 'footer_section',
    'subsection' => false,
    'icon'       => 'el el-list-alt',
    'fields' => array(
        array(
            'id'       => 'footer_use_about_info',
            'type'     => 'switch',
            'title'    => 'استخدام معلومات صفحة من نحن',
            'subtitle' => 'استخدام نص الرسالة من صفحة من نحن في قسم الشركة',
            'default'  => true,
        ),
        array(
            'id'       => 'footer_company_description',
            'type'     => 'textarea',
            'title'    => 'وصف الشركة في التذييل',
            'subtitle' => 'سيتم استخدام هذا النص إذا تم تعطيل استخدام معلومات صفحة من نحن',
            'default'  => 'شركة رائدة في مجال تصنيع أنظمة الصرف الصحي ومعالجة المياه في مصر.',
            'rows'     => 3,
        ),
        array(
            'id'       => 'footer_social_enable',
            'type'     => 'switch',
            'title'    => 'تفعيل روابط وسائل التواصل الاجتماعي',
            'default'  => true,
        ),
        array(
            'id'       => 'footer_facebook_url',
            'type'     => 'text',
            'title'    => 'رابط Facebook',
            'default'  => '',
            'required' => array('footer_social_enable', '=', true),
        ),
        array(
            'id'       => 'footer_linkedin_url',
            'type'     => 'text',
            'title'    => 'رابط LinkedIn',
            'default'  => '',
            'required' => array('footer_social_enable', '=', true),
        ),
        array(
            'id'       => 'footer_instagram_url',
            'type'     => 'text',
            'title'    => 'رابط Instagram',
            'default'  => '',
            'required' => array('footer_social_enable', '=', true),
        ),
        array(
            'id'       => 'footer_twitter_url',
            'type'     => 'text',
            'title'    => 'رابط Twitter/X',
            'default'  => '',
            'required' => array('footer_social_enable', '=', true),
        ),
        array(
            'id'       => 'footer_youtube_url',
            'type'     => 'text',
            'title'    => 'رابط YouTube',
            'default'  => '',
            'required' => array('footer_social_enable', '=', true),
        ),
        array(
            'id'       => 'footer_whatsapp_number',
            'type'     => 'text',
            'title'    => 'رقم WhatsApp',
            'subtitle' => 'أدخل الرقم بصيغة: 201234567890 (بدون + أو مسافات)',
            'default'  => '',
            'required' => array('footer_social_enable', '=', true),
        ),
    ),
));

