<?php
/**
 * Redux Framework Configuration
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

// CRITICAL: Prevent Redux from loading on frontend
// Only allow Redux in admin panel - this is the FIRST check
// Check multiple ways to detect admin
$is_admin_page = is_admin() || 
                 (defined('WP_ADMIN') && WP_ADMIN) ||
                 (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/wp-admin/') !== false) ||
                 (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/wp-login.php') !== false) ||
                 (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'admin-ajax.php') !== false && isset($_GET['action']) && strpos($_GET['action'], 'redux') !== false);

if (!$is_admin_page) {
    return; // Don't even check for Redux on frontend - exit immediately
}

// Check if Redux Framework is installed
// Try both class names for compatibility
if (!class_exists('ReduxFramework') && !class_exists('Redux')) {
    return;
}

/**
 * Initialize Redux Framework
 * IMPORTANT: Only initialize in admin - prevent frontend loading
 */
function alomran_redux_init() {
    // CRITICAL: Only initialize Redux in admin - NEVER on frontend
    // This prevents Redux from loading any CSS/JS on client pages
    if (!is_admin()) {
        return; // Prevent Redux from initializing on frontend completely
    }
    
    // Double check Redux is available
    if (!class_exists('Redux')) {
        return;
    }
    
    $opt_name = 'alomran_options';
    
    $args = array(
        'opt_name'                  => $opt_name,
        'display_name'              => 'إعدادات الموقع',
        'display_version'           => ALOMRAN_THEME_VERSION,
        'menu_type'                 => 'menu',
        'allow_sub_menu'            => true,
        'menu_title'                => 'إعدادات الموقع',
        'page_title'                => 'إعدادات الموقع',
        'admin_bar_priority'        => 50,
        'page_priority'             => 50,
        'page_slug'                 => 'alomran-options',
        'page_permissions'          => 'manage_options',
        'menu_icon'                 => 'dashicons-admin-settings',
        'last_tab'                  => '',
        'page_icon'                 => 'icon-themes',
        'save_defaults'             => true,
        'default_show'              => false,
        'default_mark'              => '',
        'show_import_export'        => true,
        'transient_time'            => 60 * MINUTE_IN_SECONDS,
        'output'                    => false,  // Disable frontend CSS output
        'output_tag'                => false,  // Disable frontend CSS output
        'database'                  => '',
        'use_cdn'                   => true,
        'dev_mode'                  => false,
        'system_info'               => false,
    );
    
    // Add Arabic translations for Redux interface strings
    add_filter('redux/options/' . $opt_name . '/localize', 'alomran_redux_arabic_translations', 10, 1);

    try {
        if (class_exists('Redux')) {
            call_user_func(array('Redux', 'setArgs'), $opt_name, $args);
        }
    } catch (Exception $e) {
        // Redux not ready yet, try again later
        add_action('admin_init', 'alomran_redux_init', 1);
        return;
    }

    // Load theme presets helper first (always needed)
    require_once ALOMRAN_THEME_DIR . '/inc/redux/sections/theme-presets-helper.php';
    
    // Get sections from active preset
    $preset = AlOmran_Preset_Loader::get_active_preset();
    $preset_dir = AlOmran_Preset_Loader::get_preset_dir($preset);
    
    $sections_dir = ALOMRAN_THEME_DIR . '/inc/redux/sections/';
    $section_files = array();
    
    // Load preset-specific sections if available
    if ($preset_dir) {
        $redux_sections_file = $preset_dir . '/redux-sections.php';
        if (file_exists($redux_sections_file)) {
            $preset_sections = require $redux_sections_file;
            if (is_array($preset_sections)) {
                $section_files = $preset_sections;
            }
        }
    }
    
    // Always include these core sections (not preset-specific)
    $core_sections = array(
        'theme-presets.php',    // Theme presets / Layout selector (includes setup wizard)
        'content-display.php',  // Content display flexibility
    );
    
    // Merge core sections with preset sections
    $section_files = array_merge($section_files, $core_sections);

    // Load sections
    foreach ($section_files as $file) {
        $file_path = $sections_dir . $file;
        if (file_exists($file_path)) {
            require_once $file_path;
        }
    }
}
add_action('redux/loaded', 'alomran_redux_init');

/**
 * Add Arabic translations for Redux Framework interface strings
 */
function alomran_redux_arabic_translations($localize) {
    if (!is_array($localize)) {
        $localize = array();
    }
    
    // Translate common Redux strings
    $localize['rAds'] = array(
        'save_pending'   => __('جارٍ الحفظ...', 'alomran'),
        'save_verify'    => __('جارٍ التحقق...', 'alomran'),
        'reset_confirm'  => __('هل أنت متأكد من إعادة تعيين هذا القسم؟', 'alomran'),
        'reset_all_confirm' => __('هل أنت متأكد من إعادة تعيين جميع الإعدادات؟', 'alomran'),
        'preset_confirm' => __('هل أنت متأكد من تطبيق هذا القالب؟ سيتم استبدال جميع الإعدادات الحالية.', 'alomran'),
        'opt_name'       => 'alomran_options',
    );
    
    // Translate Redux interface strings
    $localize['redux'] = array(
        'save_changes'   => __('حفظ التغييرات', 'alomran'),
        'reset_section'  => __('إعادة تعيين القسم', 'alomran'),
        'reset_all'      => __('إعادة تعيين الكل', 'alomran'),
        'upload'         => __('رفع', 'alomran'),
        'remove'         => __('إزالة', 'alomran'),
        'on'             => __('مفعل', 'alomran'),
        'off'            => __('معطل', 'alomran'),
    );
    
    return $localize;
}

/**
 * Translate Redux switch on/off labels
 */
add_filter('redux/options/alomran_options/field/switch/on', function() {
    return __('مفعل', 'alomran');
});

add_filter('redux/options/alomran_options/field/switch/off', function() {
    return __('معطل', 'alomran');
});

/**
 * Add JavaScript to translate Redux interface strings using PHP translations
 */
add_action('admin_footer', 'alomran_redux_arabic_js_translations');
function alomran_redux_arabic_js_translations() {
    // Only on Redux admin pages
    if (!isset($_GET['page']) || $_GET['page'] !== 'alomran-options') {
        return;
    }
    
    // Get translations from PHP (using Redux filter)
    $localize = apply_filters('redux/options/alomran_options/localize', array());
    $redux_translations = isset($localize['redux']) ? $localize['redux'] : array();
    
    // Fallback to direct translations if filter didn't provide them
    if (empty($redux_translations)) {
        $redux_translations = array(
            'save_changes'  => __('حفظ التغييرات', 'alomran'),
            'reset_section' => __('إعادة تعيين القسم', 'alomran'),
            'reset_all'     => __('إعادة تعيين الكل', 'alomran'),
            'upload'        => __('رفع', 'alomran'),
            'remove'        => __('إزالة', 'alomran'),
            'on'            => __('مفعل', 'alomran'),
            'off'           => __('معطل', 'alomran'),
        );
    }
    
    // Load and output JavaScript with translations
    $js_file = ALOMRAN_THEME_DIR . '/inc/redux/redux-translations.js';
    if (file_exists($js_file)) {
        $js_content = file_get_contents($js_file);
        
        // Replace placeholders with actual translations
        $js_content = str_replace('{{SAVE_CHANGES}}', esc_js($redux_translations['save_changes']), $js_content);
        $js_content = str_replace('{{RESET_SECTION}}', esc_js($redux_translations['reset_section']), $js_content);
        $js_content = str_replace('{{RESET_ALL}}', esc_js($redux_translations['reset_all']), $js_content);
        $js_content = str_replace('{{UPLOAD}}', esc_js($redux_translations['upload']), $js_content);
        $js_content = str_replace('{{REMOVE}}', esc_js($redux_translations['remove']), $js_content);
        $js_content = str_replace('{{ON}}', esc_js($redux_translations['on']), $js_content);
        $js_content = str_replace('{{OFF}}', esc_js($redux_translations['off']), $js_content);
        
        echo '<script type="text/javascript">' . "\n";
        echo $js_content;
        echo "\n" . '</script>' . "\n";
    }
}

/**
 * Preserve Redux field values when sections are disabled
 * This prevents Redux from deleting values when required fields become hidden
 */
function alomran_preserve_redux_values($options, $changed_values) {
    $opt_name = 'alomran_options';
    $current_options = get_option($opt_name, array());
    
    // Get critical fields from helper
    $preserve_fields = alomran_get_critical_redux_fields();
    
    // Preserve existing values if they exist and are not empty
    foreach ($preserve_fields as $field) {
        if (isset($current_options[$field]) && !empty($current_options[$field])) {
            // Only preserve if the new value is empty or doesn't exist
            if (!isset($options[$field]) || empty($options[$field])) {
                $options[$field] = $current_options[$field];
            }
        }
    }
    
    return $options;
}
add_filter('redux/options/alomran_options/validate', 'alomran_preserve_redux_values', 10, 2);

/**
 * Restore deleted values after Redux save
 * This ensures values are not permanently lost when sections are disabled
 */
function alomran_restore_redux_values_after_save() {
    $opt_name = 'alomran_options';
    $current_options = get_option($opt_name, array());
    
    // Backup of values before save (stored in transient)
    $backup = get_transient('alomran_redux_backup');
    
    if ($backup && is_array($backup)) {
        $needs_update = false;
        
        // Get critical fields from helper
        $preserve_fields = alomran_get_critical_redux_fields();
        
        // Restore values that were deleted
        foreach ($preserve_fields as $field) {
            // If backup has value but current doesn't, restore it
            if (isset($backup[$field]) && !empty($backup[$field])) {
                if (!isset($current_options[$field]) || empty($current_options[$field])) {
                    $current_options[$field] = $backup[$field];
                    $needs_update = true;
                }
            }
        }
        
        // Update options if needed
        if ($needs_update) {
            update_option($opt_name, $current_options);
            // Clear Redux cache
            delete_transient('redux-' . $opt_name);
        }
        
        // Clear backup after use
        delete_transient('alomran_redux_backup');
    }
}
add_action('redux/options/alomran_options/saved', 'alomran_restore_redux_values_after_save', 20);

/**
 * Create backup before Redux save
 */
function alomran_backup_redux_values_before_save() {
    $opt_name = 'alomran_options';
    $current_options = get_option($opt_name, array());
    
    // Create backup (store for 1 hour)
    set_transient('alomran_redux_backup', $current_options, HOUR_IN_SECONDS);
}
add_action('redux/options/alomran_options/before_save', 'alomran_backup_redux_values_before_save', 10);

/**
 * ULTRA-AGGRESSIVE frontend protection: Block Redux completely on frontend
 * This ensures Redux NEVER loads on client pages, only in admin
 */
if (!is_admin()) {
    // Block ALL Redux filters at the earliest possible moment
    add_filter('redux/options/alomran_options/output', '__return_false', 1);
    add_filter('redux/options/alomran_options/output_tag', '__return_false', 1);
    add_filter('redux/options/alomran_options/compiler', '__return_false', 1);
    add_filter('redux/options/alomran_options/enqueue', '__return_false', 1);
    add_filter('redux/enqueue', '__return_false', 1);
    add_filter('redux/register', '__return_false', 1);
    add_filter('redux/output', '__return_false', 1);
    add_filter('redux/output_tag', '__return_false', 1);
    add_filter('redux/compiler', '__return_false', 1);
    add_filter('redux/output/enable', '__return_false', 1);
    
    // Also block at maximum priority as backup
    add_filter('redux/options/alomran_options/output', '__return_false', 99999);
    add_filter('redux/options/alomran_options/output_tag', '__return_false', 99999);
    add_filter('redux/options/alomran_options/compiler', '__return_false', 99999);
    add_filter('redux/options/alomran_options/enqueue', '__return_false', 99999);
    add_filter('redux/enqueue', '__return_false', 99999);
    add_filter('redux/output/enable', '__return_false', 99999);
    
    // Prevent Redux from hooking into frontend at multiple priorities
    $priorities = array(1, 10, 50, 100, 999, 9999);
    foreach ($priorities as $priority) {
        add_action('init', function() use ($priority) {
            remove_action('wp_head', 'redux_output_css', $priority);
            remove_action('wp_footer', 'redux_output_css', $priority);
            remove_action('wp_enqueue_scripts', 'redux_output_css', $priority);
            remove_action('wp_enqueue_scripts', 'redux_enqueue', $priority);
        }, 1);
    }
}

