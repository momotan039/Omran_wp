<?php
/**
 * About Page Main Content Section
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => 'المحتوى الرئيسي',
    'id'         => 'about_content_section',
    'subsection' => true,
    'parent'     => 'about_page_sections',
    'icon'       => 'el el-align-left',
    'fields' => array(
        array(
            'id'       => 'about_content_enable',
            'type'     => 'switch',
            'title'    => 'تفعيل المحتوى الرئيسي',
            'default'  => true,
        ),
        array(
            'id'       => 'about_main_image',
            'type'     => 'media',
            'title'    => 'الصورة الرئيسية',
            'url'      => true,
            'default'  => array('url' => 'https://picsum.photos/id/403/800/600'),
            'required' => array('about_content_enable', '=', true),
        ),
        array(
            'id'       => 'about_title',
            'type'     => 'text',
            'title'    => 'عنوان المحتوى',
            'default'  => 'عن شركة العمران',
            'required' => array('about_content_enable', '=', true),
        ),
        array(
            'id'       => 'about_content',
            'type'     => 'editor',
            'title'    => 'محتوى الصفحة',
            'default'  => 'شركة العمران للصناعات المتطورة هي شركة رائدة في مجال تصنيع أنظمة الصرف الصحي ومعالجة المياه في مصر. تأسست الشركة عام 1998 بهدف تقديم حلول هندسية متكاملة عالية الجودة تلبي احتياجات السوق المحلي والإقليمي.',
            'args'     => array(
                'wpautop'       => true,
                'media_buttons' => false,
                'textarea_rows' => 15,
                'teeny'         => false,
            ),
            'required' => array('about_content_enable', '=', true),
        ),
    ),
));

