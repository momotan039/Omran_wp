<?php
/**
 * Core Preset Loader
 * 
 * Handles preset detection, template loading, and asset management
 * 
 * @package AlOmran
 * @subpackage Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class AlOmran_Preset_Loader {
    
    /**
     * Current active preset
     * 
     * @var string
     */
    private static $active_preset = null;
    
    /**
     * Available presets
     * 
     * @var array
     */
    private static $available_presets = array('industrial', 'food', 'tech');
    
    /**
     * Preset paths cache
     * 
     * @var array
     */
    private static $preset_paths = array();
    
    /**
     * Initialize the preset loader
     */
    public static function init() {
        // Detect active preset
        self::$active_preset = self::detect_active_preset();
        
        // Register preset paths
        self::register_preset_paths();
        
        // Load preset assets
        add_action('wp_enqueue_scripts', array(__CLASS__, 'load_preset_assets'), 10);
        
        // Load preset templates via filters
        add_filter('alomran_template_path', array(__CLASS__, 'filter_template_path'), 10, 2);
        
        // Add preset body class
        add_filter('body_class', array(__CLASS__, 'add_preset_body_class'));
        
        // Load page templates from preset
        add_filter('page_template', array(__CLASS__, 'load_preset_page_template'));
        
        // Load preset-specific templates (front-page, archive, single, etc.)
        add_filter('template_include', array(__CLASS__, 'load_preset_template_include'), 20);
    }
    
    /**
     * Detect the active preset
     * 
     * @return string
     */
    public static function detect_active_preset() {
        // Check if already detected
        if (self::$active_preset !== null) {
            return self::$active_preset;
        }
        
        // Get from Redux options
        $preset = alomran_get_option('theme_preset', 'industrial');
        
        // Validate preset exists
        if (!in_array($preset, self::$available_presets, true)) {
            $preset = 'industrial';
        }
        
        return $preset;
    }
    
    /**
     * Get active preset
     * 
     * @return string
     */
    public static function get_active_preset() {
        if (self::$active_preset === null) {
            self::$active_preset = self::detect_active_preset();
        }
        return self::$active_preset;
    }
    
    /**
     * Get preset directory path
     * 
     * @param string $preset Preset name
     * @return string|false
     */
    public static function get_preset_dir($preset = null) {
        if ($preset === null) {
            $preset = self::get_active_preset();
        }
        
        if (!in_array($preset, self::$available_presets, true)) {
            return false;
        }
        
        $path = ALOMRAN_THEME_DIR . '/presets/' . sanitize_file_name($preset);
        
        if (!file_exists($path)) {
            return false;
        }
        
        return $path;
    }
    
    /**
     * Get preset directory URI
     * 
     * @param string $preset Preset name
     * @return string|false
     */
    public static function get_preset_uri($preset = null) {
        if ($preset === null) {
            $preset = self::get_active_preset();
        }
        
        if (!in_array($preset, self::$available_presets, true)) {
            return false;
        }
        
        return ALOMRAN_THEME_URI . '/presets/' . sanitize_file_name($preset);
    }
    
    /**
     * Get available header styles for active preset
     * 
     * @return array Array of style slugs => display names
     */
    public static function get_available_header_styles() {
        $preset = self::get_active_preset();
        $preset_dir = self::get_preset_dir($preset);
        
        if (!$preset_dir) {
            return array('default' => __('افتراضي', 'alomran'));
        }
        
        $header_dir = $preset_dir . '/template-parts/header';
        if (!file_exists($header_dir) || !is_dir($header_dir)) {
            return array('default' => __('افتراضي', 'alomran'));
        }
        
        $styles = array();
        $header_files = glob($header_dir . '/header-*.php');
        
        foreach ($header_files as $file) {
            $filename = basename($file, '.php');
            $style_slug = str_replace('header-', '', $filename);
            
            // Skip component files
            if (in_array($style_slug, array('logo', 'nav', 'mobile-menu', 'loader'), true)) {
                continue;
            }
            
            $style_names = array(
                'default' => __('افتراضي', 'alomran'),
                'transparent' => __('شفاف', 'alomran'),
                'minimal' => __('بسيط', 'alomran'),
                'centered' => __('مركزي', 'alomran'),
            );
            
            $display_name = isset($style_names[$style_slug]) 
                ? $style_names[$style_slug] 
                : ucfirst(str_replace('-', ' ', $style_slug));
            
            $styles[$style_slug] = $display_name;
        }
        
        // Ensure default is always first
        if (isset($styles['default'])) {
            $default = array('default' => $styles['default']);
            unset($styles['default']);
            $styles = array_merge($default, $styles);
        }
        
        return $styles;
    }
    
    /**
     * Get available footer styles for active preset
     * 
     * @return array Array of style slugs => display names
     */
    public static function get_available_footer_styles() {
        $preset = self::get_active_preset();
        $preset_dir = self::get_preset_dir($preset);
        
        if (!$preset_dir) {
            return array('default' => __('افتراضي', 'alomran'));
        }
        
        $footer_dir = $preset_dir . '/template-parts/footer';
        if (!file_exists($footer_dir) || !is_dir($footer_dir)) {
            return array('default' => __('افتراضي', 'alomran'));
        }
        
        $styles = array();
        $footer_files = glob($footer_dir . '/footer-*.php');
        
        foreach ($footer_files as $file) {
            $filename = basename($file, '.php');
            $style_slug = str_replace('footer-', '', $filename);
            
            $style_names = array(
                'default' => __('افتراضي', 'alomran'),
                'dark' => __('داكن', 'alomran'),
                'minimal' => __('بسيط', 'alomran'),
                'centered' => __('مركزي', 'alomran'),
            );
            
            $display_name = isset($style_names[$style_slug]) 
                ? $style_names[$style_slug] 
                : ucfirst(str_replace('-', ' ', $style_slug));
            
            $styles[$style_slug] = $display_name;
        }
        
        // Ensure default is always first
        if (isset($styles['default'])) {
            $default = array('default' => $styles['default']);
            unset($styles['default']);
            $styles = array_merge($default, $styles);
        }
        
        return $styles;
    }
    
    /**
     * Register preset paths for template loading
     */
    private static function register_preset_paths() {
        $preset = self::get_active_preset();
        $preset_dir = self::get_preset_dir($preset);
        
        if (!$preset_dir) {
            return;
        }
        
        // Cache preset paths
        self::$preset_paths[$preset] = array(
            'dir' => $preset_dir,
            'uri' => self::get_preset_uri($preset),
            'templates' => $preset_dir . '/template-parts',
            'assets' => $preset_dir . '/assets',
        );
    }
    
    /**
     * Load preset-specific assets
     */
    public static function load_preset_assets() {
        if (is_admin()) {
            return;
        }
        
        $preset = self::get_active_preset();
        $preset_paths = isset(self::$preset_paths[$preset]) ? self::$preset_paths[$preset] : null;
        
        if (!$preset_paths) {
            return;
        }
        
        $version = defined('ALOMRAN_THEME_VERSION') ? ALOMRAN_THEME_VERSION : '1.0.0';
        
        // Load preset CSS
        $css_file = $preset_paths['assets'] . '/css/preset.css';
        if (file_exists($css_file)) {
            $css_uri = $preset_paths['uri'] . '/assets/css/preset.css';
            $css_version = file_exists($css_file) ? filemtime($css_file) : $version;
            wp_enqueue_style(
                'alomran-preset-' . $preset . '-css',
                $css_uri,
                array('alomran-tailwind'),
                $css_version
            );
        }
        
        // Load preset JS
        $js_file = $preset_paths['assets'] . '/js/preset.js';
        if (file_exists($js_file)) {
            $js_uri = $preset_paths['uri'] . '/assets/js/preset.js';
            $js_version = file_exists($js_file) ? filemtime($js_file) : $version;
            wp_enqueue_script(
                'alomran-preset-' . $preset . '-js',
                $js_uri,
                array('jquery', 'alomran-main'),
                $js_version,
                true
            );
        }
        
        // Load preset module JS files
        $modules_dir = $preset_paths['assets'] . '/js/modules';
        if (file_exists($modules_dir) && is_dir($modules_dir)) {
            $modules = glob($modules_dir . '/*.js');
            foreach ($modules as $module_file) {
                $module_name = basename($module_file, '.js');
                $module_uri = $preset_paths['uri'] . '/assets/js/modules/' . basename($module_file);
                $module_version = filemtime($module_file);
                
                wp_enqueue_script(
                    'alomran-preset-' . $preset . '-' . $module_name,
                    $module_uri,
                    array('jquery'),
                    $module_version,
                    true
                );
            }
        }
    }
    
    /**
     * Filter template path to use preset-specific templates
     * 
     * @param string $template_path Original template path
     * @param string $template_name Template name
     * @return string
     */
    public static function filter_template_path($template_path, $template_name) {
        $preset = self::get_active_preset();
        $preset_paths = isset(self::$preset_paths[$preset]) ? self::$preset_paths[$preset] : null;
        
        if (!$preset_paths) {
            return $template_path;
        }
        
        // Check if preset has this template
        $preset_template = $preset_paths['templates'] . '/' . $template_name . '.php';
        
        if (file_exists($preset_template)) {
            return $preset_paths['templates'] . '/' . $template_name . '.php';
        }
        
        return $template_path;
    }
    
    /**
     * Get template part from preset or fallback to core
     * 
     * @param string $template_name Template name (without .php)
     * @param string $subdirectory Optional subdirectory
     * @param array $args Optional arguments to pass to template
     * @return string|false Template path or false if not found
     */
    public static function locate_template($template_name, $subdirectory = '', $args = array()) {
        $preset = self::get_active_preset();
        $preset_paths = isset(self::$preset_paths[$preset]) ? self::$preset_paths[$preset] : null;
        
        // Build template path
        $template_path = $template_name;
        if ($subdirectory) {
            $template_path = $subdirectory . '/' . $template_name;
        }
        
        // First, try preset template
        if ($preset_paths) {
            $preset_template = $preset_paths['templates'] . '/' . $template_path . '.php';
            if (file_exists($preset_template)) {
                return $preset_template;
            }
        }
        
        return false;
    }
    
    /**
     * Load template part from preset or fallback to core
     * 
     * @param string $template_name Template name
     * @param string $subdirectory Optional subdirectory
     * @param array $args Optional arguments
     */
    public static function load_template($template_name, $subdirectory = '', $args = array()) {
        $template_path = self::locate_template($template_name, $subdirectory, $args);
        
        if ($template_path) {
            extract($args);
            include $template_path;
        }
    }
    
    /**
     * Get template part - WordPress compatible function
     * Replaces get_template_part() to use preset loader
     * 
     * @param string $slug Template slug
     * @param string $name Optional template name
     * @param array $args Optional arguments
     * @param string $subdirectory Optional subdirectory override
     */
    public static function get_template_part($slug, $name = '', $args = array(), $subdirectory = '') {
        $template_name = $slug;
        if ($name) {
            $template_name = $slug . '-' . $name;
        }
        
        // If subdirectory not provided, extract from template name
        if (empty($subdirectory)) {
            $parts = explode('/', $template_name);
            if (count($parts) > 1) {
                $subdirectory = $parts[0];
                $template_name = $parts[1];
            }
        }
        
        $template_path = self::locate_template($template_name, $subdirectory, $args);
        
        if ($template_path) {
            if (!empty($args)) {
                extract($args);
            }
            load_template($template_path, false, $args);
        }
    }
    
    /**
     * Add preset body class
     * 
     * @param array $classes Body classes
     * @return array
     */
    public static function add_preset_body_class($classes) {
        $preset = self::get_active_preset();
        $classes[] = 'preset-' . esc_attr($preset);
        return $classes;
    }
    
    /**
     * Check if preset is active
     * 
     * @param string $preset Preset name
     * @return bool
     */
    public static function is_preset_active($preset) {
        return self::get_active_preset() === $preset;
    }
    
    /**
     * Load page template from preset
     * 
     * @param string $template Template path
     * @return string
     */
    public static function load_preset_page_template($template) {
        global $post;
        
        if (!$post) {
            return $template;
        }
        
        // Get page template from post meta
        $page_template = get_post_meta($post->ID, '_wp_page_template', true);
        
        if (empty($page_template) || $page_template === 'default') {
            return $template;
        }
        
        // Check if template is from preset (format: presets/{preset}/templates/page-xxx.php)
        if (strpos($page_template, 'presets/') === 0) {
            $preset_template = ALOMRAN_THEME_DIR . '/' . $page_template;
            if (file_exists($preset_template)) {
                return $preset_template;
            }
        }
        
        // Check if template is just filename (e.g., 'page-story.php')
        // Try to find it in active preset
        $preset = self::get_active_preset();
        $preset_dir = self::get_preset_dir($preset);
        
        if ($preset_dir) {
            $preset_template = $preset_dir . '/templates/' . $page_template;
            if (file_exists($preset_template)) {
                return $preset_template;
            }
        }
        
        return $template;
    }
    
    /**
     * Load preset-specific front-page.php and archive templates
     * 
     * @param string $template Template path
     * @return string
     */
    public static function load_preset_template_include($template) {
        // Don't override if template is already from preset
        if (strpos($template, '/presets/') !== false) {
            return $template;
        }
        
        $preset = self::get_active_preset();
        $preset_dir = self::get_preset_dir($preset);
        
        if (!$preset_dir) {
            return $template;
        }
        
        $preset_templates_dir = $preset_dir . '/templates';
        
        // Check for front-page.php
        if (is_front_page()) {
            $preset_front_page = $preset_templates_dir . '/front-page.php';
            if (file_exists($preset_front_page)) {
                return $preset_front_page;
            }
        }
        
        // Check for archive templates
        if (is_archive()) {
            // Check for archive-{post_type}.php (e.g., archive-menu_item.php)
            if (is_post_type_archive()) {
                $post_type = get_post_type();
                if ($post_type && $post_type !== 'post') {
                    $archive_template = $preset_templates_dir . '/archive-' . $post_type . '.php';
                    if (file_exists($archive_template)) {
                        return $archive_template;
                    }
                }
            }
            
            // Check for taxonomy templates (e.g., taxonomy-menu_category.php)
            if (is_tax()) {
                $term = get_queried_object();
                if ($term && isset($term->taxonomy)) {
                    $taxonomy_template = $preset_templates_dir . '/taxonomy-' . $term->taxonomy . '.php';
                    if (file_exists($taxonomy_template)) {
                        return $taxonomy_template;
                    }
                }
            }
            
            // Check for generic archive.php in preset
            $preset_archive = $preset_templates_dir . '/archive.php';
            if (file_exists($preset_archive)) {
                return $preset_archive;
            }
        }
        
        // Check for single templates
        if (is_singular()) {
            $post_type = get_post_type();
            if ($post_type && $post_type !== 'post' && $post_type !== 'page') {
                $single_template = $preset_templates_dir . '/single-' . $post_type . '.php';
                if (file_exists($single_template)) {
                    return $single_template;
                }
            }
        }
        
        return $template;
    }
    
    /**
     * Load preset-specific front-page.php (kept for backward compatibility)
     * 
     * @param string $template Template path
     * @return string
     */
    public static function load_preset_front_page($template) {
        return self::load_preset_template_include($template);
    }
    
    /**
     * Get available presets
     * 
     * @return array
     */
    public static function get_available_presets() {
        return self::$available_presets;
    }
    
    /**
     * Check if preset exists
     * 
     * @param string $preset Preset name
     * @return bool
     */
    public static function preset_exists($preset) {
        return in_array($preset, self::$available_presets, true) && 
               file_exists(ALOMRAN_THEME_DIR . '/presets/' . sanitize_file_name($preset));
    }
}
