<?php
/**
 * Preset Registry
 * 
 * Handles preset-specific registrations (CPTs, Taxonomies, Redux sections)
 * 
 * @package AlOmran
 * @subpackage Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class AlOmran_Preset_Registry {
    
    /**
     * Initialize preset registry
     */
    public static function init() {
        // Register CPTs and Taxonomies from active preset
        add_action('init', array(__CLASS__, 'register_preset_cpts'), 5);
        add_action('init', array(__CLASS__, 'register_preset_taxonomies'), 15);
    }
    
    /**
     * Register CPTs from active preset
     */
    public static function register_preset_cpts() {
        $preset = AlOmran_Preset_Loader::get_active_preset();
        if (!$preset) {
            return;
        }
        
        $preset_dir = AlOmran_Preset_Loader::get_preset_dir($preset);
        if (!$preset_dir) {
            return;
        }
        
        // Load preset-specific CPTs file
        $cpts_file = $preset_dir . '/cpt.php';
        if (file_exists($cpts_file)) {
            require_once $cpts_file;
        }
    }
    
    /**
     * Register Taxonomies from active preset
     */
    public static function register_preset_taxonomies() {
        $preset = AlOmran_Preset_Loader::get_active_preset();
        if (!$preset) {
            return;
        }
        
        $preset_dir = AlOmran_Preset_Loader::get_preset_dir($preset);
        if (!$preset_dir) {
            return;
        }
        
        // Load preset-specific taxonomies file
        $taxonomies_file = $preset_dir . '/taxonomies.php';
        if (file_exists($taxonomies_file)) {
            require_once $taxonomies_file;
            
            // ALWAYS call registration function directly
            // This ensures taxonomy is registered immediately
            $register_function = 'alomran_' . $preset . '_register_taxonomies';
            if (function_exists($register_function)) {
                $register_function();
            }
        }
    }
    
}

