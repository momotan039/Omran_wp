<?php
/**
 * Redux Textarea Parsers
 * 
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

function omran_core_parse_risks_items($textarea) {
    if (empty($textarea)) {
        return array();
    }
    
    $lines = array_filter(array_map('trim', explode("\n", $textarea)));
    $items = array();
    
    foreach ($lines as $line) {
        if (empty($line)) continue;
        
        $parts = explode('|', $line, 2);
        $title = trim($parts[0]);
        $desc = isset($parts[1]) ? trim($parts[1]) : '';
        
        if (!empty($title)) {
            $items[] = array(
                'risk_title' => $title,
                'risk_desc'  => $desc,
            );
        }
    }
    
    return $items;
}

function omran_core_parse_sectors_items($textarea) {
    if (empty($textarea)) {
        return array();
    }
    
    $lines = array_filter(array_map('trim', explode("\n", $textarea)));
    $items = array();
    
    foreach ($lines as $line) {
        if (empty($line)) continue;
        
        $parts = explode('|', $line, 3);
        $title = trim($parts[0]);
        $desc = isset($parts[1]) ? trim($parts[1]) : '';
        $icon = isset($parts[2]) ? trim($parts[2]) : 'residential';
        
        if (!empty($title)) {
            $items[] = array(
                'sector_title' => $title,
                'sector_desc'  => $desc,
                'sector_icon'  => $icon,
            );
        }
    }
    
    return $items;
}

function omran_core_parse_stainless_items($textarea) {
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




