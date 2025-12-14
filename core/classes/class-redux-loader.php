<?php
/**
 * Core Redux Loader
 * 
 * Handles loading preset-specific Redux configurations
 * 
 * @package AlOmran
 * @subpackage Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class AlOmran_Redux_Loader {
    
    /**
     * Loaded Redux configs cache
     * 
     * @var array
     */
    private static $loaded_configs = array();
    
    /**
     * Initialize Redux loader
     */
    public static function init() {
        // Only load in admin
        if (!is_admin()) {
            return;
        }
        
        // Check if Redux is available
        if (!class_exists('Redux')) {
            return;
        }
        
        // Hook into Redux initialization
        add_action('redux/loaded', array(__CLASS__, 'load_preset_redux_config'), 5);
    }
    
    /**
     * Load preset-specific Redux configuration
     */
    public static function load_preset_redux_config() {
        $preset = AlOmran_Preset_Loader::get_active_preset();
        $preset_dir = AlOmran_Preset_Loader::get_preset_dir($preset);
        
        if (!$preset_dir) {
            return;
        }
        
        // Load Redux PHP config if exists (preferred method - supports all field types)
        $redux_php = $preset_dir . '/redux-config.php';
        if (file_exists($redux_php)) {
            require_once $redux_php;
        }
        
        // Load Redux JSON config if exists (alternative method - limited field types)
        // Note: Repeater and complex fields should use PHP config
        $redux_json = $preset_dir . '/redux.json';
        if (file_exists($redux_json)) {
            self::load_redux_from_json($redux_json, $preset);
        }
    }
    
    /**
     * Load Redux configuration from JSON file
     * 
     * @param string $json_path Path to JSON file
     * @param string $preset Preset name
     */
    private static function load_redux_from_json($json_path, $preset) {
        $json_content = file_get_contents($json_path);
        if (!$json_content) {
            return;
        }
        
        $config = json_decode($json_content, true);
        if (!$config || !is_array($config)) {
            return;
        }
        
        // Cache loaded config
        self::$loaded_configs[$preset] = $config;
        
        // Convert JSON config to Redux sections
        if (isset($config['sections']) && is_array($config['sections'])) {
            $opt_name = 'alomran_options';
            
            foreach ($config['sections'] as $section) {
                if (!isset($section['id']) || !isset($section['title'])) {
                    continue;
                }
                
                // Convert JSON section to Redux format
                $redux_section = array(
                    'title' => $section['title'],
                    'id' => $section['id'],
                    'icon' => isset($section['icon']) ? $section['icon'] : 'el el-cog',
                    'desc' => isset($section['desc']) ? $section['desc'] : '',
                );
                
                if (isset($section['fields']) && is_array($section['fields'])) {
                    $redux_section['fields'] = self::convert_json_fields_to_redux($section['fields']);
                }
                
                // Add section to Redux
                if (class_exists('Redux')) {
                    try {
                        Redux::setSection($opt_name, $redux_section);
                    } catch (Exception $e) {
                        // Ignore errors
                    }
                }
            }
        }
    }
    
    /**
     * Convert JSON fields to Redux format
     * 
     * @param array $fields JSON fields
     * @return array Redux fields
     */
    private static function convert_json_fields_to_redux($fields) {
        $redux_fields = array();
        
        // Field types that are NOT supported in JSON (must use PHP)
        $unsupported_types = array('repeater', 'group', 'slides', 'sorter');
        
        foreach ($fields as $field) {
            if (!isset($field['id']) || !isset($field['type'])) {
                continue;
            }
            
            // Skip unsupported field types - they should be in PHP config
            if (in_array($field['type'], $unsupported_types, true)) {
                continue;
            }
            
            $redux_field = array(
                'id' => $field['id'],
                'type' => $field['type'],
                'title' => isset($field['title']) ? $field['title'] : '',
            );
            
            // Add optional properties
            $optional_props = array('subtitle', 'desc', 'default', 'validate', 'required', 'options', 'placeholder');
            foreach ($optional_props as $prop) {
                if (isset($field[$prop])) {
                    $redux_field[$prop] = $field[$prop];
                }
            }
            
            $redux_fields[] = $redux_field;
        }
        
        return $redux_fields;
    }
    
    /**
     * Get Redux config for preset
     * 
     * @param string $preset Preset name
     * @return array|false
     */
    public static function get_preset_redux_config($preset) {
        if (isset(self::$loaded_configs[$preset])) {
            return self::$loaded_configs[$preset];
        }
        
        $preset_dir = AlOmran_Preset_Loader::get_preset_dir($preset);
        if (!$preset_dir) {
            return false;
        }
        
        $redux_json = $preset_dir . '/redux.json';
        if (!file_exists($redux_json)) {
            return false;
        }
        
        $json_content = file_get_contents($redux_json);
        if (!$json_content) {
            return false;
        }
        
        $config = json_decode($json_content, true);
        if (!$config || !is_array($config)) {
            return false;
        }
        
        self::$loaded_configs[$preset] = $config;
        return $config;
    }
}

