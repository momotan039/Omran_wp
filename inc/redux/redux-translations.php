<?php
/**
 * Redux Translations
 * Arabic translations for Redux Framework interface
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

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
    
    // Get current preset value to preserve it
    $current_preset = alomran_get_option('theme_preset', 'industrial');
    if (class_exists('AlOmran_Preset_Loader')) {
        $active_preset = AlOmran_Preset_Loader::get_active_preset();
        if (in_array($active_preset, array('industrial', 'food', 'tech'), true)) {
            $current_preset = $active_preset;
        }
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
    
    // Add JavaScript to preserve theme_preset on reset and handle section reset
    require_once ALOMRAN_THEME_DIR . '/inc/redux/redux-js-handlers.php';
}

