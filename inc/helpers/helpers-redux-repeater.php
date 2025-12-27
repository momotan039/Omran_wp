<?php
/**
 * Redux Repeater Helper Functions
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get repeater items from Redux options with multiple format support
 *
 * @param string $option_id The Redux option ID (e.g., 'tech_features_preview_items')
 * @param array $default_items Default items to use if no saved items found
 * @param array $required_fields Array of field keys that must have values (at least one) for item to be valid
 * @return array Array of items
 */
function alomran_get_repeater_items($option_id, $default_items = array(), $required_fields = array()) {
    // Get only the specific option from database
    $saved_options = get_option('alomran_options', array());
    
    // CRITICAL: Only get data for the specific option_id passed to this function
    if (!isset($saved_options[$option_id])) {
        return $default_items;
    }
    
    $items_raw = $saved_options[$option_id];
    
    // If no data saved for this specific option, return defaults
    if ($items_raw === null || $items_raw === '' || $items_raw === array() || $items_raw === false) {
        return $default_items;
    }
    
    // Handle serialized strings
    if (is_string($items_raw)) {
        $unserialized = maybe_unserialize($items_raw);
        if ($unserialized !== false && is_array($unserialized)) {
            $items_raw = $unserialized;
        } else {
            return $default_items;
        }
    }
    
    if (!is_array($items_raw)) {
        return $default_items;
    }
    
    $items = array();
    $has_saved_items = false;
    
    // Handle separate field arrays format (old Redux format)
    // Check if first key is a string and its value is an array (indicating separate arrays format)
    $keys = array_keys($items_raw);
    $first_key = !empty($keys) ? $keys[0] : null;
    
    if ($first_key !== null && is_string($first_key) && isset($items_raw[$first_key]) && is_array($items_raw[$first_key])) {
        // This is the separate arrays format - extract all field arrays
        $field_arrays = array();
        foreach ($items_raw as $key => $value) {
            if (is_array($value)) {
                $field_arrays[$key] = $value;
            }
        }
        
        if (!empty($field_arrays)) {
            $max_count = max(array_map('count', $field_arrays));
            
            for ($i = 0; $i < $max_count; $i++) {
                $item = array();
                foreach ($field_arrays as $field_key => $field_array) {
                    if (isset($field_array[$i]) && $field_array[$i] !== '') {
                        $item[$field_key] = $field_array[$i];
                    }
                }
                
                // Validate item if required fields specified - must have at least ONE required field with non-empty value
                if (!empty($required_fields)) {
                    $is_valid = false;
                    foreach ($required_fields as $field) {
                        if (isset($item[$field]) && !empty(trim((string) $item[$field]))) {
                            $is_valid = true;
                            break;
                        }
                    }
                    if (!$is_valid) {
                        continue; // Skip this item if it doesn't have required fields
                    }
                }
                
                if (!empty($item)) {
                    $items[] = $item;
                    $has_saved_items = true;
                }
            }
        }
    }
    // Handle redux_repeater_data format
    elseif (isset($items_raw['redux_repeater_data']) && is_array($items_raw['redux_repeater_data'])) {
        foreach ($items_raw['redux_repeater_data'] as $item_data) {
            if (!is_array($item_data)) {
                continue;
            }
            
            // Validate item if required fields specified - must have at least ONE required field with non-empty value
            if (!empty($required_fields)) {
                $is_valid = false;
                foreach ($required_fields as $field) {
                    if (isset($item_data[$field]) && !empty(trim((string) $item_data[$field]))) {
                        $is_valid = true;
                        break;
                    }
                }
                if (!$is_valid) {
                    continue; // Skip this item if it doesn't have required fields
                }
            }
            
            if (!empty($item_data)) {
                $items[] = $item_data;
                $has_saved_items = true;
            }
        }
    }
    // Handle direct array format (group_values = true)
    elseif (!empty($items_raw) && isset($items_raw[0]) && is_array($items_raw[0])) {
        foreach ($items_raw as $item) {
            if (!is_array($item)) {
                continue;
            }
            
            // Validate item if required fields specified - must have at least ONE required field with non-empty value
            if (!empty($required_fields)) {
                $is_valid = false;
                foreach ($required_fields as $field) {
                    if (isset($item[$field]) && !empty(trim((string) $item[$field]))) {
                        $is_valid = true;
                        break;
                    }
                }
                if (!$is_valid) {
                    continue; // Skip this item if it doesn't have required fields
                }
            }
            
            if (!empty($item)) {
                $items[] = $item;
                $has_saved_items = true;
            }
        }
    }
    
    // Use defaults only if no saved items were found
    if (!$has_saved_items || empty($items)) {
        return $default_items;
    }
    
    return $items;
}
