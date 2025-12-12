<?php
/**
 * General Settings Section
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

Redux::setSection($opt_name, array(
    'title'      => 'معلومات الشركة',
    'id'         => 'general',
    'subsection' => true,
    'parent'     => 'company_sections',
    'icon'       => 'el el-cog',
    'fields' => array(
        array(
            'id'       => 'company_name',
            'type'     => 'text',
            'title'    => 'اسم الشركة',
            'default'  => 'العمران للصناعات المتطورة',
        ),
        array(
            'id'       => 'company_slogan',
            'type'     => 'text',
            'title'    => 'شعار الشركة',
            'default'  => 'جودة تدوم.. لمستقبل أنقى',
        ),
        array(
            'id'       => 'company_phone',
            'type'     => 'text',
            'title'    => 'رقم الهاتف',
            'default'  => '+20 100 123 4567',
        ),
        array(
            'id'       => 'company_email',
            'type'     => 'text',
            'title'    => 'البريد الإلكتروني',
            'default'  => 'info@alomran-eg.com',
        ),
        array(
            'id'       => 'company_address',
            'type'     => 'textarea',
            'title'    => 'العنوان',
            'default'  => 'المنطقة الصناعية الثالثة، مدينة العاشر من رمضان، مصر',
        ),
        array(
            'id'       => 'company_vision',
            'type'     => 'textarea',
            'title'    => 'رؤية الشركة',
            'default'  => 'أن نكون الرائد في صناعة أنظمة الصرف الصحي الآمنة والمستدامة في المنطقة، مع الالتزام بأعلى معايير الجودة والابتكار.',
            'rows'     => 4,
        ),
        array(
            'id'       => 'company_mission',
            'type'     => 'textarea',
            'title'    => 'رسالة الشركة',
            'default'  => 'توفير منتجات عالية الجودة تحمي البنية التحتية والبيئة، مع التركيز على الابتكار والاستدامة ورضا العملاء.',
            'rows'     => 4,
        ),
    ),
));


