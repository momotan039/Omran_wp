<?php
/**
 * Company Page Sections - Main Section
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$opt_name = 'alomran_options';

// Main Company Section
Redux::setSection($opt_name, array(
    'title'  => 'صفحة الشركة',
    'id'     => 'company_sections',
    'icon'   => 'el el-info-circle',
    'desc'   => 'إعدادات صفحة الشركة ومعلوماتها',
));

