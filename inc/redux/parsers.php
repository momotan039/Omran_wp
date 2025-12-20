<?php
/**
 * Redux Textarea Parsers
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

function alomran_parse_risks_items($textarea) {
    return alomran_parse_textarea_items($textarea, '|', array('risk_title', 'risk_desc'));
}

function alomran_parse_sectors_items($textarea) {
    return alomran_parse_textarea_items($textarea, '|', array('sector_title', 'sector_desc', 'sector_icon'), array('sector_icon' => 'residential'));
}

function alomran_parse_stainless_items($textarea) {
    if (empty($textarea)) {
        return array();
    }
    
    $lines = array_filter(array_map('trim', explode("\n", $textarea)));
    $items = array();
    
    foreach ($lines as $line) {
        if (!empty($line)) {
            $items[] = array('feature_text' => $line);
        }
    }
    
    return $items;
}






