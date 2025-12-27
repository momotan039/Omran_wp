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
    
    // Add JavaScript to preserve theme_preset on reset
    ?>
    <script type="text/javascript">
    (function($) {
        'use strict';
        
        var currentPreset = '<?php echo esc_js($current_preset); ?>';
        
        // Preserve theme_preset when resetting all
        $(document).on('click', '.redux-action_bar .redux-reset-all', function(e) {
            // Store current preset before reset
            if (currentPreset && (currentPreset === 'industrial' || currentPreset === 'food' || currentPreset === 'tech')) {
                // Wait for reset to complete, then restore preset
                setTimeout(function() {
                    var presetField = $('#redux-alomran_options-theme_preset');
                    if (presetField.length) {
                        // Set the value
                        presetField.val(currentPreset).trigger('change');
                        
                        // If it's an image select, trigger click on the correct option
                        var presetOption = presetField.closest('.redux-field-container').find('input[type="radio"][value="' + currentPreset + '"]');
                        if (presetOption.length) {
                            presetOption.prop('checked', true).trigger('change');
                        }
                    }
                }, 500);
            }
        });
        
        // Also intercept form submission on reset
        $(document).on('submit', 'form.redux-form-wrapper', function(e) {
            var form = $(this);
            var isReset = form.find('input[name="redux-reset"]').length > 0 || 
                         form.find('.redux-reset-all').length > 0 ||
                         window.location.href.indexOf('reset=all') !== -1;
            
            if (isReset && currentPreset && (currentPreset === 'industrial' || currentPreset === 'food' || currentPreset === 'tech')) {
                // Ensure theme_preset field has the correct value before submit
                var presetInput = form.find('input[name="alomran_options[theme_preset]"]');
                if (presetInput.length) {
                    presetInput.val(currentPreset);
                }
                
                // Also check for image select radio buttons
                var presetRadio = form.find('input[type="radio"][name*="theme_preset"][value="' + currentPreset + '"]');
                if (presetRadio.length) {
                    presetRadio.prop('checked', true);
                }
            }
        });
        
        // Monitor for preset changes and update currentPreset
        $(document).on('change', 'input[name*="theme_preset"], input[type="radio"][name*="theme_preset"]', function() {
            var newPreset = $(this).val();
            if (newPreset && (newPreset === 'industrial' || newPreset === 'food' || newPreset === 'tech')) {
                currentPreset = newPreset;
            }
        });
        
        // Handle section reset to ensure all 4 default items are restored
        $(document).on('click', '.redux-reset-section', function(e) {
            var button = $(this);
            var sectionId = '';
            
            // Try to get section ID from various sources
            var sectionElement = button.closest('.redux-section');
            if (sectionElement.length) {
                sectionId = sectionElement.attr('id') || sectionElement.data('id');
            }
            
            // If still no ID, try from button attributes
            if (!sectionId) {
                sectionId = button.data('id') || button.attr('data-id');
            }
            
            // Try from href
            if (!sectionId) {
                var href = button.attr('href');
                if (href) {
                    var match = href.match(/section[=:]([^&]+)/i);
                    if (match) {
                        sectionId = match[1];
                    }
                }
            }
            
            // Only handle Tech preset repeater sections
            if (currentPreset === 'tech' && sectionId) {
                var repeaterSections = {
                    'tech_features_preview_section': 'tech_features_preview_items',
                    'tech_stats_section': 'tech_stats_items',
                    'tech_testimonials_section': 'tech_testimonials_items'
                };
                
                if (repeaterSections[sectionId]) {
                    var fieldId = repeaterSections[sectionId];
                    
                    // Store section ID in form before reset
                    var form = $('form.redux-form-wrapper');
                    if (form.length) {
                        form.find('input[name="redux-reset-section"]').remove();
                        form.append('<input type="hidden" name="redux-reset-section" value="' + sectionId + '">');
                    }
                    
                    // Also store in sessionStorage for PHP to use
                    if (typeof sessionStorage !== 'undefined') {
                        sessionStorage.setItem('redux_reset_section', sectionId);
                        sessionStorage.setItem('redux_reset_time', Date.now());
                    }
                }
            }
        });
        
    })(jQuery);
    </script>
    <?php
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
 * IMPORTANT: Use a flag to prevent infinite loops
 */
function alomran_restore_redux_values_after_save() {
    static $restoring = false;
    if ($restoring) {
        return;
    }
    
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
            $restoring = true;
            update_option($opt_name, $current_options, false);
            // Clear Redux cache
            delete_transient('redux-' . $opt_name);
            $restoring = false;
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
    
    // Always preserve theme_preset value before any save/reset operation
    if (isset($current_options['theme_preset']) && !empty($current_options['theme_preset'])) {
        set_transient('alomran_preset_backup', $current_options['theme_preset'], HOUR_IN_SECONDS);
    } else {
        // If no preset is set, try to get it from active preset
        if (class_exists('AlOmran_Preset_Loader')) {
            $active_preset = AlOmran_Preset_Loader::get_active_preset();
            if (in_array($active_preset, array('industrial', 'food', 'tech'), true)) {
                set_transient('alomran_preset_backup', $active_preset, HOUR_IN_SECONDS);
            }
        }
    }
}
add_action('redux/options/alomran_options/before_save', 'alomran_backup_redux_values_before_save', 10);

/**
 * Preserve theme_preset when resetting all options
 * This ensures the active preset doesn't change when user clicks "Reset All"
 * BUT allows user to change it normally
 */
function alomran_preserve_theme_preset_on_reset($options) {
    // Check if $options is an array (not Redux_Panel object)
    if (!is_array($options)) {
        return $options;
    }
    
    // Only preserve if this is a reset operation, not a normal save
    $is_reset = false;
    
    // Check if this is a reset operation
    if (isset($_POST['redux-reset']) || 
        (isset($_GET['reset']) && $_GET['reset'] === 'all') ||
        (isset($_REQUEST['redux-reset']) && $_REQUEST['redux-reset'] === 'all')) {
        $is_reset = true;
    }
    
    // Only preserve on reset, not on normal save
    if ($is_reset) {
        $current_options = get_option('alomran_options', array());
        if (isset($current_options['theme_preset']) && in_array($current_options['theme_preset'], array('industrial', 'food', 'tech'), true)) {
            $options['theme_preset'] = $current_options['theme_preset'];
        }
    }
    
    return $options;
}
add_filter('redux/options/alomran_options/validate', 'alomran_preserve_theme_preset_on_reset', 1, 1);


/**
 * Restore theme_preset after reset if it was changed
 * This hook runs after option is updated in database
 * IMPORTANT: Use a flag to prevent infinite loops
 * Only restore on reset operations, not normal saves
 */
function alomran_restore_theme_preset_after_reset($old_value, $value) {
    // Prevent infinite loop
    static $restoring = false;
    if ($restoring) {
        return;
    }
    
    // Only run for alomran_options
    if (!is_array($value)) {
        return;
    }
    
    // Check if this is a reset operation
    $is_reset = false;
    if (isset($_POST['redux-reset']) || 
        (isset($_GET['reset']) && $_GET['reset'] === 'all') ||
        (isset($_REQUEST['redux-reset']) && $_REQUEST['redux-reset'] === 'all')) {
        $is_reset = true;
    }
    
    // Only restore on reset, not on normal save
    if (!$is_reset) {
        return;
    }
    
    // Get the preset that was saved before this update
    $preset_backup = get_transient('alomran_preset_backup');
    
    // Check if we need to restore
    $needs_restore = false;
    $restore_value = null;
    
    if ($preset_backup && in_array($preset_backup, array('industrial', 'food', 'tech'), true)) {
        if (!isset($value['theme_preset']) || $value['theme_preset'] !== $preset_backup) {
            $needs_restore = true;
            $restore_value = $preset_backup;
        }
    } elseif (isset($old_value['theme_preset']) && in_array($old_value['theme_preset'], array('industrial', 'food', 'tech'), true)) {
        if (!isset($value['theme_preset']) || $value['theme_preset'] !== $old_value['theme_preset']) {
            $needs_restore = true;
            $restore_value = $old_value['theme_preset'];
        }
    }
    
    // Restore if needed
    if ($needs_restore && $restore_value) {
        $restoring = true;
        $value['theme_preset'] = $restore_value;
        
        // Use update_option with autoload=false to prevent triggering hooks
        update_option('alomran_options', $value, false);
        
        // Clear Redux cache
        delete_transient('redux-alomran_options');
        
        // Clear backup after use
        if ($preset_backup) {
            delete_transient('alomran_preset_backup');
        }
        
        $restoring = false;
    }
}
add_action('update_option_alomran_options', 'alomran_restore_theme_preset_after_reset', 10, 2);

/**
 * Get repeater defaults for Tech preset
 */
function alomran_get_tech_repeater_defaults() {
    return array(
        'tech_features_preview_items' => array(
            array(
                'feature_icon' => '⚡',
                'feature_title' => 'سرعة فائقة',
                'feature_description' => 'ربط فوري مع جميع المنصات في أقل من 5 ثوانٍ',
                'feature_color' => 'from-yellow-400 to-orange-500',
            ),
            array(
                'feature_icon' => '🔒',
                'feature_title' => 'أمان متقدم',
                'feature_description' => 'حماية شاملة لبياناتك مع تشفير من المستوى المصرفي',
                'feature_color' => 'from-blue-500 to-cyan-500',
            ),
            array(
                'feature_icon' => '📊',
                'feature_title' => 'تحليلات ذكية',
                'feature_description' => 'لوحات تحكم تفاعلية تعرض أداء عملك في الوقت الفعلي',
                'feature_color' => 'from-purple-500 to-pink-500',
            ),
            array(
                'feature_icon' => '🤖',
                'feature_title' => 'ذكاء اصطناعي',
                'feature_description' => 'أتمتة ذكية تتعلم من سلوك عملك وتطور نفسها تلقائياً',
                'feature_color' => 'from-green-500 to-emerald-500',
            ),
        ),
        'tech_stats_items' => array(
            array(
                'stat_number' => '50K+',
                'stat_label' => 'معاملة شهرياً',
                'stat_icon' => '📦',
                'stat_color' => 'text-blue-600',
            ),
            array(
                'stat_number' => '500+',
                'stat_label' => 'شركة تثق بنا',
                'stat_icon' => '🏢',
                'stat_color' => 'text-violet-600',
            ),
            array(
                'stat_number' => '99.9%',
                'stat_label' => 'معدل الاستقرار',
                'stat_icon' => '⚡',
                'stat_color' => 'text-emerald-600',
            ),
            array(
                'stat_number' => '24/7',
                'stat_label' => 'دعم فني متواصل',
                'stat_icon' => '💬',
                'stat_color' => 'text-orange-600',
            ),
        ),
        'tech_testimonials_items' => array(
            array(
                'testimonial_name' => 'أحمد السالم',
                'testimonial_role' => 'مدير التقنية - شركة توصيل',
                'testimonial_content' => 'إتقان غيرت طريقة عملنا بالكامل. وفرنا أكثر من 40 ساعة أسبوعياً في معالجة الطلبات. النظام سهل الاستخدام وقوي جداً.',
                'testimonial_avatar' => '👨‍💼',
                'testimonial_company' => 'توصيل',
            ),
            array(
                'testimonial_name' => 'فاطمة العلي',
                'testimonial_role' => 'المؤسسة والرئيس التنفيذي - منصة سلة',
                'testimonial_content' => 'أفضل قرار اتخذناه هذا العام. الربط مع منصات الدفع والشحن أصبح تلقائياً بالكامل. فريق الدعم استثنائي.',
                'testimonial_avatar' => '👩‍💼',
                'testimonial_company' => 'سلة',
            ),
            array(
                'testimonial_name' => 'خالد المطيري',
                'testimonial_role' => 'CTO - شركة تطوير',
                'testimonial_content' => 'API موثق بشكل ممتاز، SDKs جاهزة، وأداء لا يصدق. منصة إتقان هي الحل الذي كنا نبحث عنه منذ سنوات.',
                'testimonial_avatar' => '👨‍💻',
                'testimonial_company' => 'تطوير',
            ),
            array(
                'testimonial_name' => 'سارة النجار',
                'testimonial_role' => 'مديرة العمليات - متجر إلكتروني',
                'testimonial_content' => 'التكامل مع منصات البيع أصبح سهلاً جداً. وفرنا وقتاً كبيراً في إدارة المخزون والطلبات.',
                'testimonial_avatar' => '👩‍💼',
                'testimonial_company' => 'متجر إلكتروني',
            ),
        ),
    );
}

/**
 * Remove repeater defaults from being saved automatically
 * This ensures defaults are only used in frontend, not stored in database
 * REMOVED: No longer restoring defaults on reset - user must add items manually
 */
function alomran_restore_repeater_defaults_on_section_reset($options) {
    // DISABLED: We don't want to restore defaults automatically
    // User must add items manually in Redux panel
    return $options;
    // Check if $options is an array
    if (!is_array($options)) {
        return $options;
    }
    
    // Check if this is a section reset operation
    $is_section_reset = false;
    $reset_section = '';
    
    // Check POST first
    if (isset($_POST['redux-reset-section']) && !empty($_POST['redux-reset-section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_POST['redux-reset-section']);
    } 
    // Check GET
    elseif (isset($_GET['redux-reset-section']) && !empty($_GET['redux-reset-section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_GET['redux-reset-section']);
    }
    // Check REQUEST
    elseif (isset($_REQUEST['redux-reset-section']) && !empty($_REQUEST['redux-reset-section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_REQUEST['redux-reset-section']);
    }
    
    // Map section IDs to repeater field IDs
    $section_to_field = array(
        'tech_features_preview_section' => 'tech_features_preview_items',
        'tech_stats_section' => 'tech_stats_items',
        'tech_testimonials_section' => 'tech_testimonials_items',
    );
    
    // If we have a section ID, restore its defaults
    if ($is_section_reset && !empty($reset_section) && isset($section_to_field[$reset_section])) {
        $field_id = $section_to_field[$reset_section];
        $defaults = alomran_get_tech_repeater_defaults();
        
        if (isset($defaults[$field_id])) {
            $options[$field_id] = $defaults[$field_id];
        }
    }
    
    // Also check if repeater fields are being reset individually
    // When a repeater field is reset, it might only have 1 item instead of 4
    $repeater_fields = array('tech_features_preview_items', 'tech_stats_items', 'tech_testimonials_items');
    $defaults = alomran_get_tech_repeater_defaults();
    
    foreach ($repeater_fields as $field_id) {
        // If field exists but has less than 4 items, restore defaults
        if (isset($options[$field_id])) {
            $current_value = $options[$field_id];
            
            // Check if it's an array with less than 4 items
            if (is_array($current_value)) {
                // Check if it's in the format with separate field arrays
                if (isset($current_value['feature_icon']) || isset($current_value['stat_number']) || isset($current_value['testimonial_name'])) {
                    // This is the separate arrays format - check count
                    $count = 0;
                    if (isset($current_value['feature_icon']) && is_array($current_value['feature_icon'])) {
                        $count = count($current_value['feature_icon']);
                    } elseif (isset($current_value['stat_number']) && is_array($current_value['stat_number'])) {
                        $count = count($current_value['stat_number']);
                    } elseif (isset($current_value['testimonial_name']) && is_array($current_value['testimonial_name'])) {
                        $count = count($current_value['testimonial_name']);
                    }
                    
                    // If less than 4 items, restore defaults
                    if ($count > 0 && $count < 4 && isset($defaults[$field_id])) {
                        $options[$field_id] = $defaults[$field_id];
                    }
                } 
                // Check if it's a direct array of items
                elseif (isset($current_value[0]) && is_array($current_value[0])) {
                    $count = count($current_value);
                    // If less than 4 items, restore defaults
                    if ($count > 0 && $count < 4 && isset($defaults[$field_id])) {
                        $options[$field_id] = $defaults[$field_id];
                    }
                }
                // Check redux_repeater_data format
                elseif (isset($current_value['redux_repeater_data']) && is_array($current_value['redux_repeater_data'])) {
                    $count = count($current_value['redux_repeater_data']);
                    // If less than 4 items, restore defaults
                    if ($count > 0 && $count < 4 && isset($defaults[$field_id])) {
                        $options[$field_id] = $defaults[$field_id];
                    }
                }
            }
        }
    }
    
    return $options;
}
add_filter('redux/options/alomran_options/validate', 'alomran_restore_repeater_defaults_on_section_reset', 5, 1);

/**
 * DISABLED: No longer restoring defaults automatically
 * User must add items manually in Redux panel
 * Defaults are only used in frontend templates when no items are saved
 */

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

