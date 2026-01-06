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
        
        /**
         * Unified function to detect section ID from button context
         * This is the PRIMARY method for detecting section IDs
         * Works for both homepage and page sections
         */
        function detectSectionIdFromButton(button) {
            var sectionId = '';
            
            // Configuration: Field ID to Section ID mapping
            // This is the SINGLE SOURCE OF TRUTH for field detection
            var fieldToSectionMap = {
                // Homepage sections (tab 8, redux-section 3)
                'tech_features_preview_items': 'tech_features_preview_section',
                'tech_stats_items': 'tech_stats_section',
                'tech_testimonials_items': 'tech_testimonials_section',
                // Page sections
                'tech_demo_benefits': 'tech_demo_page',
                'tech_pricing_plans': 'tech_pricing_page',
                'tech_features_categories': 'tech_features_page',
                'tech_use_cases_items': 'tech_use_cases_page',
            };
            
            // Method 1: Check for field IDs in the current section (PRIMARY METHOD)
            // This works for ALL subsections (homepage and pages)
            var currentSection = button.closest('.redux-section, .redux-group-tab, .redux-group, .redux-field-container, .redux-field');
            if (!currentSection.length) {
                // Try wider search if closest didn't work
                currentSection = button.parents('.redux-section, .redux-group-tab, .redux-group');
            }
            
            if (currentSection.length) {
                
                // Check each field ID in the map
                // IMPORTANT: Check homepage sections FIRST (they're more specific)
                var fieldIdsToCheck = [
                    // Homepage sections (check first - more specific)
                    'tech_features_preview_items',
                    'tech_stats_items',
                    'tech_testimonials_items',
                    // Page sections
                    'tech_demo_benefits',
                    'tech_pricing_plans',
                    'tech_features_categories',
                    'tech_use_cases_items',
                ];
                
                for (var idx = 0; idx < fieldIdsToCheck.length; idx++) {
                    var fieldId = fieldIdsToCheck[idx];
                    if (!fieldToSectionMap.hasOwnProperty(fieldId)) {
                        continue;
                    }
                    
                    // Multiple selectors to catch all possible field representations
                    // IMPORTANT: Check for repeater-specific selectors first
                    var selectors = [
                        // Repeater-specific selectors (most reliable)
                        '.redux-field-container[data-id*="' + fieldId + '"]',
                        '.redux-field[data-id*="' + fieldId + '"]',
                        '.redux-field[data-id="' + fieldId + '"]',
                        // General selectors
                        '[id*="' + fieldId + '"]',
                        '[name*="' + fieldId + '"]',
                        '[for*="' + fieldId + '"]',
                        'input[name*="' + fieldId + '"]',
                        'textarea[name*="' + fieldId + '"]',
                        'select[name*="' + fieldId + '"]',
                        // Repeater title bind (for group_values)
                        '.redux-repeater[data-id*="' + fieldId + '"]',
                        '.redux-repeater-title[data-field*="' + fieldId + '"]',
                    ];
                    
                    var found = false;
                    for (var i = 0; i < selectors.length; i++) {
                        var matches = currentSection.find(selectors[i]);
                        if (matches.length > 0) {
                            sectionId = fieldToSectionMap[fieldId];
                            found = true;
                            break;
                        }
                    }
                    
                    if (found) {
                        break; // Found section, stop checking
                    } else {
                    }
                }
            }
            
            // Method 2: Try from button's closest redux-section or redux-field-container
            if (!sectionId) {
                var sectionElement = button.closest('.redux-section, .redux-field-container');
            if (sectionElement.length) {
                sectionId = sectionElement.attr('id') || sectionElement.data('id');
                    if (sectionId) {
                        // Remove redux prefix if exists
                        sectionId = sectionId.replace(/^redux-alomran_options-/, '');
                    }
                }
            }
            
            // Method 3: Try from button's data attributes
            if (!sectionId) {
                sectionId = button.data('id') || button.attr('data-id') || button.data('section-id');
                if (sectionId) {
                }
            }
            
            // Method 4: Try from href
            if (!sectionId) {
                var href = button.attr('href');
                if (href) {
                    // Try multiple patterns
                    var match = href.match(/section[=:]([^&]+)/i) || href.match(/[#&]tab[=:](\d+)/i);
                    if (match) {
                        sectionId = match[1];
                    }
                }
            }
            
            // Method 5: Try from parent section container
            if (!sectionId) {
                var parentSection = button.closest('[id*="section"], [id*="page"]');
                if (parentSection.length) {
                    var parentId = parentSection.attr('id');
                    if (parentId) {
                        // Remove redux prefix if exists
                        sectionId = parentId.replace(/^redux-alomran_options-/, '').replace(/^redux-section-/, '');
                    }
                }
            }
            
            return sectionId;
        }
        
        // Handle section reset to ensure all default items are restored
        $(document).on('click', '.redux-reset-section', function(e) {
            var button = $(this);
            // Get current tab from URL
            var urlParams = new URLSearchParams(window.location.search);
            var currentTab = urlParams.get('tab');
            
            var sectionId = detectSectionIdFromButton(button);
            
            // If sectionId is still empty, try to get it from the button's context more aggressively
            if (!sectionId) {
                // Try to find the section ID from the button's parent sections
                var parentSection = button.closest('.redux-section, .redux-group-tab, .redux-group');
                if (parentSection.length) {
                    // Try to extract section ID from parent
                    var parentId = parentSection.attr('id') || parentSection.data('id');
                    if (parentId) {
                        // Remove common prefixes
                        parentId = parentId.replace(/^redux-alomran_options-/, '')
                                          .replace(/^redux-section-/, '')
                                          .replace(/^section-/, '');
                        if (parentId && parentId !== 'redux-section') {
                            sectionId = parentId;
                        }
                    }
                }
            }
            
            // Only handle Tech preset repeater sections
            if (currentPreset === 'tech' && sectionId) {
                // Get section configuration (matches PHP config)
                var repeaterSections = {
                    // Homepage sections (tab 8, redux-section 3)
                    'tech_features_preview_section': 'tech_features_preview_items',
                    'tech_stats_section': 'tech_stats_items',
                    'tech_testimonials_section': 'tech_testimonials_items',
                    // Pages sections
                    'tech_use_cases_page': 'tech_use_cases_items',
                    'tech_features_page': 'tech_features_categories',
                    'tech_pricing_page': 'tech_pricing_plans',
                    'tech_demo_page': 'tech_demo_benefits'
                };
                
                if (repeaterSections[sectionId]) {
                    var fieldId = repeaterSections[sectionId];
                    
                    // Store section ID in form before reset - use multiple methods
                    var form = $('form.redux-form-wrapper');
                    if (form.length) {
                        // Remove any existing hidden inputs
                        form.find('input[name="redux-reset-section"]').remove();
                        form.find('input[name="redux_reset_section"]').remove();
                        form.find('input[name="redux-reset-section-id"]').remove();
                        
                        // Add hidden inputs with section ID
                        form.append('<input type="hidden" name="redux-reset-section" value="' + sectionId + '">');
                        form.append('<input type="hidden" name="redux_reset_section" value="' + sectionId + '">');
                        form.append('<input type="hidden" name="redux-reset-section-id" value="' + sectionId + '">');
                        
                        // Also set as data attribute on form for PHP to access
                        form.data('redux-reset-section', sectionId);
                        form.attr('data-redux-reset-section', sectionId);
                    }
                    
                    // Also store in sessionStorage for PHP to use
                    if (typeof sessionStorage !== 'undefined') {
                        sessionStorage.setItem('redux_reset_section', sectionId);
                        sessionStorage.setItem('redux_reset_time', Date.now());
                    }
                    
                    // Also store in cookie as backup (with longer expiration)
                    var expireDate = new Date();
                    expireDate.setTime(expireDate.getTime() + (60 * 1000)); // 1 minute
                    document.cookie = 'redux_reset_section=' + sectionId + '; expires=' + expireDate.toUTCString() + '; path=/';
                    
                    // Also add to URL if it's a GET request
                    if (button.attr('href') && button.attr('href').indexOf('?') !== -1) {
                        var url = button.attr('href');
                        if (url.indexOf('redux-reset-section=') === -1) {
                            url += (url.indexOf('&') !== -1 ? '&' : '&') + 'redux-reset-section=' + encodeURIComponent(sectionId);
                            button.attr('href', url);
                        }
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
 * Get unified section configuration for Tech preset
 * Returns array with section ID, field ID, tab number, and type for each section
 * This is the SINGLE SOURCE OF TRUTH for all section mappings
 * 
 * Structure:
 * [
 *   'section_id' => [
 *     'field_id' => 'repeater_field_id',
 *     'tab' => tab_number,  // Optional, for page sections only
 *     'type' => 'homepage' | 'page',  // Section type
 *     'group' => 'homepage' | 'pages'  // Group for organization
 *   ]
 * ]
 */
function alomran_get_tech_sections_config() {
    return array(
        // ============================================
        // Homepage Sections (tab 8, redux-section 3)
        // Each section is handled separately
        // ============================================
        'tech_features_preview_section' => array(
            'field_id' => 'tech_features_preview_items',
            'type' => 'homepage',
            'group' => 'homepage',
            'tab' => 8,  // Homepage tab
            'redux_section' => 3,  // Redux internal section number
        ),
        'tech_stats_section' => array(
            'field_id' => 'tech_stats_items',
            'type' => 'homepage',
            'group' => 'homepage',
            'tab' => 8,
            'redux_section' => 3,
        ),
        'tech_testimonials_section' => array(
            'field_id' => 'tech_testimonials_items',
            'type' => 'homepage',
            'group' => 'homepage',
            'tab' => 8,
            'redux_section' => 3,
        ),
        // ============================================
        // Page Sections (tabs 9-15)
        // ============================================
        'tech_features_page' => array(
            'field_id' => 'tech_features_categories',
            'type' => 'page',
            'group' => 'pages',
            'tab' => 9,
            'redux_section' => 9,
        ),
        'tech_pricing_page' => array(
            'field_id' => 'tech_pricing_plans',
            'type' => 'page',
            'group' => 'pages',
            'tab' => 10,
            'redux_section' => 10,
        ),
        'tech_use_cases_page' => array(
            'field_id' => 'tech_use_cases_items',
            'type' => 'page',
            'group' => 'pages',
            'tab' => 11,
            'redux_section' => 11,
        ),
        'tech_demo_page' => array(
            'field_id' => 'tech_demo_benefits',
            'type' => 'page',
            'group' => 'pages',
            'tab' => 10,  // Same tab as pricing (subsection)
            'redux_section' => 10,
        ),
    );
}

/**
 * Get section-to-field mapping (backward compatibility)
 * @deprecated Use alomran_get_tech_sections_config() instead
 */
function alomran_get_tech_section_to_field_map() {
    $config = alomran_get_tech_sections_config();
    $map = array();
    foreach ($config as $section_id => $section_data) {
        $map[$section_id] = $section_data['field_id'];
    }
    return $map;
}

/**
 * Get field-to-section mapping (for reverse lookup)
 */
function alomran_get_tech_field_to_section_map() {
    $config = alomran_get_tech_sections_config();
    $map = array();
    foreach ($config as $section_id => $section_data) {
        $map[$section_data['field_id']] = $section_id;
    }
    return $map;
}

/**
 * Get homepage sections only
 */
function alomran_get_tech_homepage_sections() {
    $config = alomran_get_tech_sections_config();
    $homepage = array();
    foreach ($config as $section_id => $section_data) {
        if ($section_data['type'] === 'homepage') {
            $homepage[$section_id] = $section_data;
        }
    }
    return $homepage;
}

/**
 * Get page sections only
 */
function alomran_get_tech_page_sections() {
    $config = alomran_get_tech_sections_config();
    $pages = array();
    foreach ($config as $section_id => $section_data) {
        if ($section_data['type'] === 'page') {
            $pages[$section_id] = $section_data;
        }
    }
    return $pages;
}

/**
 * Get repeater defaults for Tech preset
 * Returns default values for all repeater fields
 */
function alomran_get_tech_repeater_defaults() {
    return array(
        // Homepage sections
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
        // Pages sections - empty defaults (user must add items manually)
        'tech_use_cases_items' => array(),
        'tech_features_categories' => array(),
        'tech_pricing_plans' => array(),
        'tech_demo_benefits' => array(),
    );
}

/**
 * Backup user repeater data before reset
 * Saves current user data to transient for potential recovery
 */
function alomran_backup_repeater_data_before_reset() {
    // Check if this is a section reset operation or reset all
    $is_section_reset = false;
    $is_reset_all = false;
    $reset_section = '';
    
    // Check if this is a section reset operation - check multiple sources
    // 1. POST data
    if (isset($_POST['redux-reset-section']) && !empty($_POST['redux-reset-section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_POST['redux-reset-section']);
    } 
    // 2. GET data
    elseif (isset($_GET['redux-reset-section']) && !empty($_GET['redux-reset-section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_GET['redux-reset-section']);
    }
    // 3. REQUEST data
    elseif (isset($_REQUEST['redux-reset-section']) && !empty($_REQUEST['redux-reset-section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_REQUEST['redux-reset-section']);
    }
    // 4. Cookie (set by JavaScript)
    elseif (isset($_COOKIE['redux_reset_section']) && !empty($_COOKIE['redux_reset_section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_COOKIE['redux_reset_section']);
    }
    // 5. Check for Redux's internal reset mechanism
    elseif (isset($_POST['redux_reset_section']) && !empty($_POST['redux_reset_section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_POST['redux_reset_section']);
    }
    // 6. Check URL parameters (Redux sometimes uses this)
    elseif (isset($_GET['section']) && isset($_GET['redux-reset']) && $_GET['redux-reset'] === '1') {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_GET['section']);
    }
    
    // Check if this is a reset all operation
    if (isset($_POST['redux-reset']) || 
        (isset($_GET['reset']) && $_GET['reset'] === 'all') ||
        (isset($_REQUEST['redux-reset']) && $_REQUEST['redux-reset'] === 'all') ||
        (isset($_GET['redux-reset']) && $_GET['redux-reset'] === 'all')) {
        $is_reset_all = true;
    }
    
    // Only backup on reset operations
    if (!$is_section_reset && !$is_reset_all) {
        return;
    }
    
    // Get current options
    $current_options = get_option('alomran_options', array());
    
    // Get unified section configuration
    $section_config = alomran_get_tech_sections_config();
    $section_to_field = alomran_get_tech_section_to_field_map();
    
    // Get all repeater field IDs
    $all_repeater_fields = array_values($section_to_field);
    
    // Backup data
    $backup_data = array();
    
    if ($is_section_reset && !empty($reset_section) && isset($section_to_field[$reset_section])) {
        // Backup single section
        $field_id = $section_to_field[$reset_section];
        if (isset($current_options[$field_id]) && !empty($current_options[$field_id])) {
            $backup_data[$field_id] = $current_options[$field_id];
        }
    } elseif ($is_reset_all) {
        // Backup all repeater fields
        foreach ($all_repeater_fields as $field_id) {
            if (isset($current_options[$field_id]) && !empty($current_options[$field_id])) {
                $backup_data[$field_id] = $current_options[$field_id];
            }
        }
    }
    
    // Save backup to transient (store for 24 hours)
    if (!empty($backup_data)) {
        set_transient('alomran_repeater_backup_' . time(), $backup_data, DAY_IN_SECONDS);
        // Also save with section ID for easy retrieval
        if ($is_section_reset && !empty($reset_section)) {
            set_transient('alomran_repeater_backup_section_' . $reset_section, $backup_data, DAY_IN_SECONDS);
        }
    }
}
add_action('redux/options/alomran_options/before_save', 'alomran_backup_repeater_data_before_reset', 5);

/**
 * Restore repeater defaults when section is reset or reset all
 * This ensures that repeater fields are restored to defaults when user clicks Reset Section or Reset All
 * User data is backed up before reset (see alomran_backup_repeater_data_before_reset)
 */
function alomran_restore_repeater_defaults_on_section_reset($options) {
    // Check if $options is an array (not Redux_Panel object)
    if (!is_array($options)) {
        return $options;
    }
    
    // Check if data is URL-encoded in POST['data']
    $parsed_data = array();
    if (isset($_POST['data']) && !empty($_POST['data'])) {
        parse_str($_POST['data'], $parsed_data);
    }
    
    // Check if this is a section reset operation or reset all
    $is_section_reset = false;
    $is_reset_all = false;
    $reset_section = '';
    
    // Check Redux's defaults-section parameter (most important!)
    if (isset($parsed_data['alomran_options']['defaults-section']) && !empty($parsed_data['alomran_options']['defaults-section'])) {
        $is_section_reset = true;
        if (isset($parsed_data['alomran_options']['redux-section']) && !empty($parsed_data['alomran_options']['redux-section'])) {
            $tab_number = intval($parsed_data['alomran_options']['redux-section']);
            // Build tab mapping from unified config
            $section_config = alomran_get_tech_sections_config();
            $tab_to_section = array();
            foreach ($section_config as $section_id => $config) {
                if (isset($config['tab']) && isset($config['type']) && $config['type'] === 'page') {
                    $tab = $config['tab'];
                    // Handle multiple sections on same tab (like tech_demo_page on tab 10)
                    if (!isset($tab_to_section[$tab])) {
                        $tab_to_section[$tab] = $section_id;
                    }
                }
            }
            if (isset($tab_to_section[$tab_number])) {
                $reset_section = $tab_to_section[$tab_number];
            }
        }
    }
    // Also check in direct POST
    elseif (isset($_POST['alomran_options']['defaults-section']) && !empty($_POST['alomran_options']['defaults-section'])) {
        $is_section_reset = true;
        if (isset($_POST['alomran_options']['redux-section']) && !empty($_POST['alomran_options']['redux-section'])) {
            $tab_number = intval($_POST['alomran_options']['redux-section']);
            // Build tab mapping from unified config
            $section_config = alomran_get_tech_sections_config();
            $tab_to_section = array();
            foreach ($section_config as $section_id => $config) {
                if (isset($config['tab']) && isset($config['type']) && $config['type'] === 'page') {
                    $tab = $config['tab'];
                    // Handle multiple sections on same tab (like tech_demo_page on tab 10)
                    if (!isset($tab_to_section[$tab])) {
                        $tab_to_section[$tab] = $section_id;
                    }
                }
            }
            if (isset($tab_to_section[$tab_number])) {
                $reset_section = $tab_to_section[$tab_number];
            }
        }
    }
    
    // Check JavaScript-set values (for homepage subsections and other sections)
    // This is the PRIMARY method for homepage subsections (tech_features_preview_section, tech_stats_section, tech_testimonials_section)
    if (empty($reset_section) && isset($_POST['redux-reset-section']) && !empty($_POST['redux-reset-section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_POST['redux-reset-section']);
    }
    elseif (empty($reset_section) && isset($_COOKIE['redux_reset_section']) && !empty($_COOKIE['redux_reset_section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_COOKIE['redux_reset_section']);
    }
    elseif (empty($reset_section) && isset($_POST['redux_reset_section']) && !empty($_POST['redux_reset_section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_POST['redux_reset_section']);
    }
    elseif (empty($reset_section) && isset($_POST['redux-reset-section-id']) && !empty($_POST['redux-reset-section-id'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_POST['redux-reset-section-id']);
    }
    elseif (empty($reset_section) && isset($_GET['redux-reset-section']) && !empty($_GET['redux-reset-section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_GET['redux-reset-section']);
    }
    elseif (empty($reset_section) && isset($_REQUEST['redux-reset-section']) && !empty($_REQUEST['redux-reset-section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_REQUEST['redux-reset-section']);
    }
    elseif (empty($reset_section) && isset($_GET['section']) && isset($_GET['redux-reset']) && $_GET['redux-reset'] === '1') {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_GET['section']);
    }
    
    // Check if this is a reset all operation
    if (isset($_POST['redux-reset']) || 
        (isset($_GET['reset']) && $_GET['reset'] === 'all') ||
        (isset($_REQUEST['redux-reset']) && $_REQUEST['redux-reset'] === 'all') ||
        (isset($_GET['redux-reset']) && $_GET['redux-reset'] === 'all')) {
        $is_reset_all = true;
    }
    
    // CRITICAL: If this is NOT a reset operation, return options as-is
    // Each section is independent - Redux will handle saving only what's in POST
    // We don't need to preserve or modify other sections
    if (!$is_section_reset && !$is_reset_all) {
        // Let Redux handle normal saves naturally - no intervention needed
        return $options;
    }
    
    // Get unified section configuration
    $section_config = alomran_get_tech_sections_config();
    $section_to_field = alomran_get_tech_section_to_field_map();
    
    // Get all repeater field IDs for reset all
    $all_repeater_fields = array_values($section_to_field);
    
    // Get default values
    $defaults = alomran_get_tech_repeater_defaults();
    
    // Process section reset - restore defaults for single section ONLY
    // CRITICAL: Each section is independent - we only modify the section being reset
    // Redux will automatically preserve other sections from database
    if ($is_section_reset && !empty($reset_section)) {
        if (isset($section_to_field[$reset_section])) {
            $field_id = $section_to_field[$reset_section];
            
            // Set to defaults or empty array for THIS section ONLY
            if (isset($defaults[$field_id]) && !empty($defaults[$field_id])) {
                $options[$field_id] = $defaults[$field_id];
            } else {
                $options[$field_id] = array();
            }
            
            // Remove from POST data to prevent Redux from re-saving old data
            if (isset($_POST['data']) && !empty($_POST['data'])) {
                parse_str($_POST['data'], $post_data);
                if (isset($post_data['alomran_options'][$field_id])) {
                    unset($post_data['alomran_options'][$field_id]);
                    $_POST['data'] = http_build_query($post_data);
                }
            }
            if (isset($_POST['alomran_options'][$field_id])) {
                unset($_POST['alomran_options'][$field_id]);
            }
        }
    }
    
    // Process reset all - restore defaults for all repeater fields
    if ($is_reset_all) {
        foreach ($all_repeater_fields as $field_id) {
            // Restore default values if available, otherwise set to empty array
            if (isset($defaults[$field_id])) {
                $options[$field_id] = $defaults[$field_id];
            } else {
                $options[$field_id] = array();
            }
        }
    }
    
        return $options;
    }
add_filter('redux/options/alomran_options/validate', 'alomran_restore_repeater_defaults_on_section_reset', 1, 1);

/**
 * Handle section reset using Redux's reset hook
 * This is more reliable than checking POST/GET data
 */
add_action('redux/options/alomran_options/reset', 'alomran_handle_redux_section_reset', 10, 1);
function alomran_handle_redux_section_reset($options) {
    // Get section ID from various sources
    $reset_section = '';
    
    // Check multiple sources for section ID
    if (isset($_POST['redux-reset-section']) && !empty($_POST['redux-reset-section'])) {
        $reset_section = sanitize_text_field($_POST['redux-reset-section']);
    }
    elseif (isset($_GET['redux-reset-section']) && !empty($_GET['redux-reset-section'])) {
        $reset_section = sanitize_text_field($_GET['redux-reset-section']);
    }
    elseif (isset($_REQUEST['redux-reset-section']) && !empty($_REQUEST['redux-reset-section'])) {
        $reset_section = sanitize_text_field($_REQUEST['redux-reset-section']);
    }
    elseif (isset($_COOKIE['redux_reset_section']) && !empty($_COOKIE['redux_reset_section'])) {
        $reset_section = sanitize_text_field($_COOKIE['redux_reset_section']);
    }
    elseif (isset($_POST['redux_reset_section']) && !empty($_POST['redux_reset_section'])) {
        $reset_section = sanitize_text_field($_POST['redux_reset_section']);
    }
    elseif (isset($_GET['section']) && isset($_GET['redux-reset']) && $_GET['redux-reset'] === '1') {
        $reset_section = sanitize_text_field($_GET['section']);
    }
    elseif (isset($_POST['redux-reset-section-id']) && !empty($_POST['redux-reset-section-id'])) {
        $reset_section = sanitize_text_field($_POST['redux-reset-section-id']);
    }
    
    // Get unified section configuration
    $section_config = alomran_get_tech_sections_config();
    $section_to_field = alomran_get_tech_section_to_field_map();
    
    // Get default values
    $defaults = alomran_get_tech_repeater_defaults();
    
    // If we have a section ID, restore its defaults
    if (!empty($reset_section) && isset($section_to_field[$reset_section])) {
            $field_id = $section_to_field[$reset_section];
        
        // Restore default values if available, otherwise set to empty array
        if (isset($defaults[$field_id])) {
            $options[$field_id] = $defaults[$field_id];
        } else {
            $options[$field_id] = array();
        }
    }
    
    return $options;
}

/**
 * ULTRA-FAST: Force delete repeater data immediately after section reset
 * This runs on EVERY page load in admin to catch reset operations
 */
add_action('admin_init', 'alomran_ultra_fast_reset_repeater', 1);
function alomran_ultra_fast_reset_repeater() {
    // Only in admin
    if (!is_admin()) {
        return;
    }
    
    // Check if data is URL-encoded in POST['data']
    $parsed_data = array();
    if (isset($_POST['data']) && !empty($_POST['data'])) {
        parse_str($_POST['data'], $parsed_data);
    }
    
    // CRITICAL: Only run on reset operations, NOT on normal saves
    // Check if this is a reset operation first
    $is_reset_operation = false;
    
    // Check for reset indicators
    if (isset($parsed_data['alomran_options']['defaults-section']) && !empty($parsed_data['alomran_options']['defaults-section'])) {
        $is_reset_operation = true;
    }
    if (!$is_reset_operation && isset($_POST['alomran_options']['defaults-section']) && !empty($_POST['alomran_options']['defaults-section'])) {
        $is_reset_operation = true;
    }
    if (!$is_reset_operation && (isset($_POST['redux-reset-section']) || isset($_GET['redux-reset-section']) || isset($_COOKIE['redux_reset_section']))) {
        $is_reset_operation = true;
    }
    
    // If this is NOT a reset operation, handle normal save
    // Remove homepage repeater fields that are NOT being modified
    if (!$is_reset_operation) {
        // Check if this is a Redux AJAX save request
        $is_ajax_save = isset($_POST['action']) && $_POST['action'] === 'alomran_options_ajax_save';
        
        if ($is_ajax_save || isset($parsed_data['alomran_options'])) {
            // Get homepage sections
            $homepage_sections = alomran_get_tech_homepage_sections();
            
            // Get current tab from URL or POST
            $current_tab = null;
            if (isset($_GET['tab']) && !empty($_GET['tab'])) {
                $current_tab = intval($_GET['tab']);
            } elseif (isset($parsed_data['alomran_options']['redux-section']) && !empty($parsed_data['alomran_options']['redux-section'])) {
                $current_tab = intval($parsed_data['alomran_options']['redux-section']);
            } elseif (isset($_POST['alomran_options']['redux-section']) && !empty($_POST['alomran_options']['redux-section'])) {
                $current_tab = intval($_POST['alomran_options']['redux-section']);
            }
            
            // Map tab to section
            $tab_to_section = array(
                4 => 'tech_features_preview_section',
                5 => 'tech_stats_section',
                6 => 'tech_testimonials_section',
            );
            
            // Determine which section is being saved
            $current_section = null;
            if ($current_tab && isset($tab_to_section[$current_tab])) {
                $current_section = $tab_to_section[$current_tab];
            }
            
            if ($current_section) {
                // Remove homepage repeater fields that are NOT in the current section
                $removed_any = false;
                foreach ($homepage_sections as $section_id => $section_data) {
                    $field_id = $section_data['field_id'];
                    
                    // Skip if this is the current section being saved
                    if ($current_section === $section_id) {
                        continue;
                    }
                    
                    // Remove from parsed POST data
                    if (isset($parsed_data['alomran_options'][$field_id])) {
                        unset($parsed_data['alomran_options'][$field_id]);
                        $removed_any = true;
                    }
                    
                    // Also remove from direct POST array (Redux uses this directly)
                    if (isset($_POST['alomran_options'][$field_id])) {
                        unset($_POST['alomran_options'][$field_id]);
                        $removed_any = true;
                    }
                }
                
                // Rebuild POST data string if we removed any fields
                if ($removed_any && isset($_POST['data']) && !empty($_POST['data'])) {
                    $_POST['data'] = http_build_query($parsed_data);
                }
            }
        }
        
        // Exit - don't process reset logic
        return;
    }
    
    // If this is a reset operation, continue with reset logic
    // Get unified section configuration
    $section_config = alomran_get_tech_sections_config();
    $section_to_field = alomran_get_tech_section_to_field_map();
    
    // Get section ID from ALL possible sources
    $reset_section = '';
    
    // Note: $parsed_data is already set above (in the normal save check)
    if (empty($parsed_data) && isset($_POST['data']) && !empty($_POST['data'])) {
        parse_str($_POST['data'], $parsed_data);
    }
    
    // Check Redux's defaults-section parameter (most important!)
    // Check in parsed data first
    if (isset($parsed_data['alomran_options']['defaults-section']) && !empty($parsed_data['alomran_options']['defaults-section'])) {
        // Try to get section ID from redux-section (tab number)
        if (isset($parsed_data['alomran_options']['redux-section']) && !empty($parsed_data['alomran_options']['redux-section'])) {
            $tab_number = intval($parsed_data['alomran_options']['redux-section']);
            
            // Map tab numbers to section IDs using unified config
            // WARNING: Tab numbers may vary! We should rely on JavaScript-set section ID instead
            // This is a fallback only - JavaScript should send section ID directly
            $section_config = alomran_get_tech_sections_config();
            $tab_to_section = array();
            foreach ($section_config as $section_id => $config) {
                if (isset($config['tab']) && isset($config['type']) && $config['type'] === 'page') {
                    $tab = $config['tab'];
                    // Handle multiple sections on same tab (like tech_demo_page on tab 10)
                    if (!isset($tab_to_section[$tab])) {
                        $tab_to_section[$tab] = $section_id;
                    }
                }
            }
            
            if (isset($tab_to_section[$tab_number])) {
                $reset_section = $tab_to_section[$tab_number];
            }
        }
    }
    // Also check in direct POST
    elseif (isset($_POST['alomran_options']['defaults-section']) && !empty($_POST['alomran_options']['defaults-section'])) {
        if (isset($_POST['alomran_options']['redux-section']) && !empty($_POST['alomran_options']['redux-section'])) {
            $tab_number = intval($_POST['alomran_options']['redux-section']);
            
            // Build tab mapping from unified config
            $section_config = alomran_get_tech_sections_config();
            $tab_to_section = array();
            foreach ($section_config as $section_id => $config) {
                if (isset($config['tab']) && isset($config['type']) && $config['type'] === 'page') {
                    $tab = $config['tab'];
                    // Handle multiple sections on same tab (like tech_demo_page on tab 10)
                    if (!isset($tab_to_section[$tab])) {
                        $tab_to_section[$tab] = $section_id;
                    }
                }
            }
            
            if (isset($tab_to_section[$tab_number])) {
                $reset_section = $tab_to_section[$tab_number];
            }
        }
    }
    
    // Check JavaScript-set values (for homepage subsections and pages)
    // This is the PRIMARY method - JavaScript should set this for all sections
    if (empty($reset_section) && isset($_POST['redux-reset-section']) && !empty($_POST['redux-reset-section'])) {
        $reset_section = sanitize_text_field($_POST['redux-reset-section']);
    }
    elseif (empty($reset_section) && isset($_GET['redux-reset-section']) && !empty($_GET['redux-reset-section'])) {
        $reset_section = sanitize_text_field($_GET['redux-reset-section']);
    }
    elseif (empty($reset_section) && isset($_REQUEST['redux-reset-section']) && !empty($_REQUEST['redux-reset-section'])) {
        $reset_section = sanitize_text_field($_REQUEST['redux-reset-section']);
    }
    elseif (empty($reset_section) && isset($_COOKIE['redux_reset_section']) && !empty($_COOKIE['redux_reset_section'])) {
        $reset_section = sanitize_text_field($_COOKIE['redux_reset_section']);
    }
    elseif (empty($reset_section) && isset($_POST['redux_reset_section']) && !empty($_POST['redux_reset_section'])) {
        $reset_section = sanitize_text_field($_POST['redux_reset_section']);
    }
    elseif (empty($reset_section) && isset($_GET['section']) && isset($_GET['redux-reset'])) {
        $reset_section = sanitize_text_field($_GET['section']);
    }
    elseif (empty($reset_section) && isset($_POST['redux-reset-section-id']) && !empty($_POST['redux-reset-section-id'])) {
        $reset_section = sanitize_text_field($_POST['redux-reset-section-id']);
    }
    
    // For homepage subsections, detect from field IDs in POST data
    // IMPORTANT: Use URL tab parameter to narrow down which section we're in
    // Then check which homepage repeater field is present in POST data
    if (empty($reset_section) && isset($parsed_data['alomran_options']['defaults-section'])) {
        // Get homepage sections from unified config
        $homepage_sections = alomran_get_tech_homepage_sections();
        $field_to_section = alomran_get_tech_field_to_section_map();
        
        // Get current tab from URL or POST
        $current_tab = null;
        if (isset($_GET['tab']) && !empty($_GET['tab'])) {
            $current_tab = intval($_GET['tab']);
        } elseif (isset($parsed_data['alomran_options']['redux-section']) && !empty($parsed_data['alomran_options']['redux-section'])) {
            $current_tab = intval($parsed_data['alomran_options']['redux-section']);
        }
        
        // Check which homepage repeater field is present in POST data
        // IMPORTANT: If we have a current tab, use it to determine which section is being reset
        // This works regardless of how many items are in the repeater
        $best_match = null;
        $best_match_score = 999; // Lower is better
        
        // First, try to match by tab number (most reliable when tab is known)
        if ($current_tab) {
            $tab_to_section = array(
                4 => 'tech_features_preview_section',  // Tab 4 = Features Preview
                5 => 'tech_stats_section',              // Tab 5 = Stats
                6 => 'tech_testimonials_section',        // Tab 6 = Testimonials
            );
            
            if (isset($tab_to_section[$current_tab])) {
                $candidate_section = $tab_to_section[$current_tab];
                $candidate_field = isset($homepage_sections[$candidate_section]) ? $homepage_sections[$candidate_section]['field_id'] : null;
                
                // Verify that this field exists in POST data
                if ($candidate_field && isset($parsed_data['alomran_options'][$candidate_field])) {
                    $best_match = $candidate_section;
                    $best_match_score = 0; // Highest priority
                } else {
                }
            }
        }
        
        // Fallback: If tab matching didn't work, check all fields and find the best match
        if (!$best_match) {
            foreach ($homepage_sections as $section_id => $section_data) {
                $field_id = $section_data['field_id'];
                if (isset($parsed_data['alomran_options'][$field_id])) {
                    $field_data = $parsed_data['alomran_options'][$field_id];
                    
                    // Count how many items are in this repeater field
                    $item_count = 0;
                    if (is_array($field_data)) {
                        // Check for repeater structure: look for sub-arrays or indexed arrays
                        if (isset($field_data['redux_repeater_data']) && is_array($field_data['redux_repeater_data'])) {
                            $item_count = count($field_data['redux_repeater_data']);
                        } else {
                            // Check if it's a flat array with indexed values
                            foreach ($field_data as $key => $value) {
                                if (is_array($value) && isset($value[0])) {
                                    // Count how many items based on first sub-array length
                                    $item_count = count($value);
                                    break;
                                }
                            }
                        }
                    }
                    
                    // IMPORTANT: If we have a current tab, prioritize fields that are likely in that tab
                    // Tab 4 is usually features preview section
                    // Tab 5 is usually stats section
                    // Tab 6 is usually testimonials section
                    $is_likely_match = false;
                    $priority_boost = 0;
                    
                    if ($current_tab === 4) {
                        // Tab 4 is likely features preview
                        if ($section_id === 'tech_features_preview_section') {
                            $is_likely_match = true;
                            $priority_boost = 20; // High priority for features preview in tab 4
                        }
                    } elseif ($current_tab === 5) {
                        // Tab 5 is likely stats section
                        if ($section_id === 'tech_stats_section') {
                            $is_likely_match = true;
                            $priority_boost = 20; // High priority for stats in tab 5
                        }
                    } elseif ($current_tab === 6) {
                        // Tab 6 is likely testimonials section
                        if ($section_id === 'tech_testimonials_section') {
                            $is_likely_match = true;
                            $priority_boost = 20; // High priority for testimonials in tab 6
                        }
                    }
                    
                    // Calculate score: lower is better
                    // Boost priority for likely matches based on tab
                    // Use item_count as base score (fewer items = higher priority, but not required)
                    $score = $item_count - $priority_boost;
                    
                    if ($score < $best_match_score) {
                        $best_match = $section_id;
                        $best_match_score = $score;
                    }
                }
            }
        }
        
        if ($best_match) {
            $reset_section = $best_match;
        }
    }
    
    
    // If we found a section to reset
    if (!empty($reset_section) && isset($section_to_field[$reset_section])) {
        
        $field_id = $section_to_field[$reset_section];
        $defaults = alomran_get_tech_repeater_defaults();
        
        
        // Get current options DIRECTLY from database
        global $wpdb;
        $options_raw = $wpdb->get_var("SELECT option_value FROM {$wpdb->options} WHERE option_name = 'alomran_options'");
        $current_options = maybe_unserialize($options_raw);
        if (!is_array($current_options)) {
            $current_options = array();
        }
        
        // Log current value before reset
        if (isset($current_options[$field_id])) {
        }
        
        // FORCE DELETE - set to empty array or defaults
        // IMPORTANT: Always use defaults if available, regardless of current value
        if (isset($defaults[$field_id]) && !empty($defaults[$field_id])) {
            // Ensure defaults are in correct format (array of arrays for repeater)
            $default_value = $defaults[$field_id];
            if (is_array($default_value) && !empty($default_value)) {
                $current_options[$field_id] = $default_value;
            } else {
                $current_options[$field_id] = array();
            }
        } else {
            $current_options[$field_id] = array();
        }
        
        // CRITICAL: Remove data from POST to prevent Redux from saving it again
        if (isset($_POST['data']) && !empty($_POST['data'])) {
            // Parse and remove the field from POST data
            parse_str($_POST['data'], $post_data);
            if (isset($post_data['alomran_options'][$field_id])) {
                unset($post_data['alomran_options'][$field_id]);
                // Rebuild POST data string
                $_POST['data'] = http_build_query($post_data);
            }
        }
        
        // Also remove from direct POST array
        if (isset($_POST['alomran_options'][$field_id])) {
            unset($_POST['alomran_options'][$field_id]);
        }
        
        // Update DIRECTLY in database (bypass all hooks)
        $result = $wpdb->update(
            $wpdb->options,
            array('option_value' => maybe_serialize($current_options)),
            array('option_name' => 'alomran_options'),
            array('%s'),
            array('%s')
        );
        
        
        // Clear ALL caches
        delete_transient('redux-alomran_options');
        wp_cache_delete('alomran_options', 'options');
        wp_cache_delete('alloptions', 'options');
        
        // Clear cookie
        if (isset($_COOKIE['redux_reset_section'])) {
            setcookie('redux_reset_section', '', time() - 3600, '/');
            unset($_COOKIE['redux_reset_section']);
        }
        
    } else {
        // Log if section not found
        if (!empty($reset_section)) {
        }
    }
}

/**
 * Ensure repeater defaults are restored after section reset or reset all
 * This hook runs after option is updated in database (EXACT same as restore_theme_preset_after_reset)
 * IMPORTANT: Use a flag to prevent infinite loops
 * Only process on section reset operations or reset all, not normal saves
 */
function alomran_ensure_repeater_defaults_restored_after_section_reset($old_value, $value) {
    // Prevent infinite loop
    static $restoring = false;
    if ($restoring) {
        return;
    }
    
    // Only run for alomran_options
    if (!is_array($value)) {
        return;
    }
    
    // Check if this is a section reset operation or reset all
    $is_section_reset = false;
    $is_reset_all = false;
    $reset_section = '';
    
    // Check if data is URL-encoded in POST['data']
    $parsed_data = array();
    if (isset($_POST['data']) && !empty($_POST['data'])) {
        parse_str($_POST['data'], $parsed_data);
    }
    
    // Check Redux's defaults-section parameter (most important!)
    if (isset($parsed_data['alomran_options']['defaults-section']) && !empty($parsed_data['alomran_options']['defaults-section'])) {
        $is_section_reset = true;
        if (isset($parsed_data['alomran_options']['redux-section']) && !empty($parsed_data['alomran_options']['redux-section'])) {
            $tab_number = intval($parsed_data['alomran_options']['redux-section']);
            // Build tab mapping from unified config
            $section_config = alomran_get_tech_sections_config();
            $tab_to_section = array();
            foreach ($section_config as $section_id => $config) {
                if (isset($config['tab']) && isset($config['type']) && $config['type'] === 'page') {
                    $tab = $config['tab'];
                    // Handle multiple sections on same tab (like tech_demo_page on tab 10)
                    if (!isset($tab_to_section[$tab])) {
                        $tab_to_section[$tab] = $section_id;
                    }
                }
            }
            if (isset($tab_to_section[$tab_number])) {
                $reset_section = $tab_to_section[$tab_number];
            }
        }
    }
    // Also check in direct POST
    elseif (isset($_POST['alomran_options']['defaults-section']) && !empty($_POST['alomran_options']['defaults-section'])) {
        $is_section_reset = true;
        if (isset($_POST['alomran_options']['redux-section']) && !empty($_POST['alomran_options']['redux-section'])) {
            $tab_number = intval($_POST['alomran_options']['redux-section']);
            // Build tab mapping from unified config
            $section_config = alomran_get_tech_sections_config();
            $tab_to_section = array();
            foreach ($section_config as $section_id => $config) {
                if (isset($config['tab']) && isset($config['type']) && $config['type'] === 'page') {
                    $tab = $config['tab'];
                    // Handle multiple sections on same tab (like tech_demo_page on tab 10)
                    if (!isset($tab_to_section[$tab])) {
                        $tab_to_section[$tab] = $section_id;
                    }
                }
            }
            if (isset($tab_to_section[$tab_number])) {
                $reset_section = $tab_to_section[$tab_number];
            }
        }
    }
    
    // Check if this is a section reset operation - check multiple sources
    // 1. POST data
    if (empty($reset_section) && isset($_POST['redux-reset-section']) && !empty($_POST['redux-reset-section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_POST['redux-reset-section']);
    }
    // 2. GET data
    elseif (empty($reset_section) && isset($_GET['redux-reset-section']) && !empty($_GET['redux-reset-section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_GET['redux-reset-section']);
    }
    // 3. REQUEST data
    elseif (empty($reset_section) && isset($_REQUEST['redux-reset-section']) && !empty($_REQUEST['redux-reset-section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_REQUEST['redux-reset-section']);
    }
    // 4. Cookie (set by JavaScript)
    elseif (empty($reset_section) && isset($_COOKIE['redux_reset_section']) && !empty($_COOKIE['redux_reset_section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_COOKIE['redux_reset_section']);
    }
    // 5. Check for Redux's internal reset mechanism
    elseif (isset($_POST['redux_reset_section']) && !empty($_POST['redux_reset_section'])) {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_POST['redux_reset_section']);
    }
    // 6. Check URL parameters (Redux sometimes uses this)
    elseif (isset($_GET['section']) && isset($_GET['redux-reset']) && $_GET['redux-reset'] === '1') {
        $is_section_reset = true;
        $reset_section = sanitize_text_field($_GET['section']);
    }
    
    // Check if this is a reset all operation
    if (isset($_POST['redux-reset']) || 
        (isset($_GET['reset']) && $_GET['reset'] === 'all') ||
        (isset($_REQUEST['redux-reset']) && $_REQUEST['redux-reset'] === 'all') ||
        (isset($_GET['redux-reset']) && $_GET['redux-reset'] === 'all')) {
        $is_reset_all = true;
    }
    
    // Only process on section reset or reset all, not on normal save
    if (!$is_section_reset && !$is_reset_all) {
        return;
    }
    
    // Get unified section configuration
    $section_config = alomran_get_tech_sections_config();
    $section_to_field = alomran_get_tech_section_to_field_map();
    
    // Get default values
    $defaults = alomran_get_tech_repeater_defaults();
    
    // Process section reset - ensure defaults are restored
    // Each section is handled separately
    if ($is_section_reset && !empty($reset_section) && isset($section_to_field[$reset_section])) {
        $field_id = $section_to_field[$reset_section];
        
        $restoring = true;
        
        // Always set to empty array (don't check - just do it)
        // Restore default values if available, otherwise set to empty array
        if (isset($defaults[$field_id]) && !empty($defaults[$field_id])) {
            $value[$field_id] = $defaults[$field_id];
        } else {
            $value[$field_id] = array();
        }
        
        // Use update_option with autoload=false to prevent triggering hooks
        update_option('alomran_options', $value, false);
        
        // Clear Redux cache
        delete_transient('redux-alomran_options');
        wp_cache_delete('alomran_options', 'options');
        wp_cache_delete('alloptions', 'options');
        
        // Clear cookie after use
        if (isset($_COOKIE['redux_reset_section'])) {
            setcookie('redux_reset_section', '', time() - 3600, '/');
        }
        
        $restoring = false;
    }
    
    // Process reset all - ensure defaults are restored for all fields
    if ($is_reset_all) {
        $all_repeater_fields = array_values($section_to_field);
        $needs_update = false;
        
        foreach ($all_repeater_fields as $field_id) {
            // Check if field needs default values restored
            if (isset($defaults[$field_id])) {
                // Field has defaults - check if current value matches defaults
                if (!isset($value[$field_id]) || $value[$field_id] !== $defaults[$field_id]) {
                    $value[$field_id] = $defaults[$field_id];
                    $needs_update = true;
                }
            } else {
                // Field has no defaults - ensure it's empty array
        if (isset($value[$field_id]) && !empty($value[$field_id])) {
                    $value[$field_id] = array();
                    $needs_update = true;
                }
            }
        }
        
        // Update options if any fields were restored
        if ($needs_update) {
            $restoring = true;
            
            // Use update_option with autoload=false to prevent triggering hooks
            update_option('alomran_options', $value, false);
            
            // Clear Redux cache
            delete_transient('redux-alomran_options');
            
            $restoring = false;
        }
    }
}
add_action('update_option_alomran_options', 'alomran_ensure_repeater_defaults_restored_after_section_reset', 10, 2);

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

