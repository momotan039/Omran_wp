<?php
/**
 * Redux Options Helper Functions
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

function alomran_get_option($option, $default = '') {
    if (!class_exists('Redux')) {
        return $default;
    }
    return Redux::get_option('alomran_options', $option, $default);
}

function alomran_get_ordered_sections() {
    $order = alomran_get_option('sections_order', array());
    if (empty($order) || !isset($order['enabled'])) {
        return array(
            'hero' => 'hero',
            'risks' => 'risks',
            'sectors' => 'sectors',
            'products' => 'products',
            'stainless' => 'stainless',
            'testimonials' => 'testimonials'
        );
    }
    return $order['enabled'];
}

function alomran_is_section_enabled($section) {
    return alomran_get_option($section . '_enable', true);
}

function alomran_get_ordered_about_sections() {
    $order = alomran_get_option('about_sections_order', array());
    if (empty($order) || !isset($order['enabled'])) {
        return array(
            'header' => 'header',
            'content' => 'content',
            'vision_mission' => 'vision_mission',
            'stats' => 'stats'
        );
    }
    return $order['enabled'];
}


