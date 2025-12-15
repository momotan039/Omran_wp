<?php
/**
 * Industrial Preset Redux Settings
 * 
 * Returns Redux settings array for the Industrial preset
 * 
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get Redux settings for Industrial preset
 * 
 * @return array Redux settings array
 */
function omran_demo_get_redux_settings() {
    return array(
        // Theme preset
        'theme_preset' => 'industrial',
        
        // Colors
        'preset_industrial_primary' => '#2c5530',
        'preset_industrial_secondary' => '#4a7c59',
        'preset_industrial_accent' => '#f97316',
        
        // Typography
        'preset_font_family' => 'cairo',
        'preset_font_weight' => '400',
        
        // Header & Footer
        'preset_header_style' => 'default',
        'preset_header_sticky' => true,
        'preset_footer_style' => 'default',
        
        // Layout
        'preset_container_width' => 'standard',
        'preset_content_layout' => 'boxed',
        
        // Hero Section
        'industrial_hero_title' => 'أنظمة صرف صحي متطورة',
        'industrial_hero_subtitle' => 'حلول ذكية ومستدامة لأنظمة الصرف الصحي ومعالجة المياه الصناعية',
        'industrial_hero_button_text' => 'اكتشف حلولنا',
        'industrial_hero_button_url' => '#products',
        'industrial_hero_background_image' => '',
        
        // Stats Section
        'industrial_show_stats' => true,
        'industrial_stats' => array(
            'enabled' => array(
                array(
                    'stat_number' => '750+',
                    'stat_label' => 'مشروع ناجح',
                    'stat_icon' => 'dashicons-portfolio'
                ),
                array(
                    'stat_number' => '20+',
                    'stat_label' => 'عام من التميز',
                    'stat_icon' => 'dashicons-awards'
                ),
                array(
                    'stat_number' => '200+',
                    'stat_label' => 'عميل موثوق',
                    'stat_icon' => 'dashicons-groups'
                ),
                array(
                    'stat_number' => '99%',
                    'stat_label' => 'رضا العملاء',
                    'stat_icon' => 'dashicons-star-filled'
                )
            ),
            'disabled' => array()
        ),
        
        // Products Section
        'industrial_show_products' => true,
        'industrial_products_title' => 'حلولنا المتخصصة',
        'industrial_products_subtitle' => 'أنظمة صرف صحي مبتكرة مصممة لتلبية احتياجاتك الخاصة',
        'industrial_products_count' => 6,
        
        // Sectors Section
        'industrial_show_sectors' => true,
        'industrial_sectors_title' => 'قطاعاتنا',
        'industrial_sectors_subtitle' => 'نخدم مجموعة متنوعة من القطاعات الصناعية',
        
        // Testimonials Section
        'industrial_show_testimonials' => true,
        'industrial_testimonials_title' => 'آراء عملائنا',
        'industrial_testimonials_subtitle' => 'تجارب حقيقية من عملائنا المميزين',
        'industrial_testimonials_count' => 3,
        
        // About Section
        'industrial_show_about' => true,
        'industrial_about_title' => 'عن شركتنا',
        'industrial_about_subtitle' => 'خبراء في أنظمة الصرف الصحي المتقدمة',
        'industrial_about_content' => 'نحن شركة متخصصة في تصميم وتنفيذ أنظمة الصرف الصحي المتطورة وحلول معالجة المياه. نقدم حلولاً مبتكرة وموثوقة تلبي أعلى معايير الجودة والاستدامة.',
        
        // Risks Section
        'industrial_show_risks' => true,
        'industrial_risks_title' => 'إدارة المخاطر',
        'industrial_risks_subtitle' => 'حلول شاملة لإدارة المخاطر الصناعية',
        
        // Stainless Section
        'industrial_show_stainless' => true,
        'industrial_stainless_title' => 'الفولاذ المقاوم للصدأ',
        'industrial_stainless_subtitle' => 'جودة فائقة ومتانة طويلة الأمد',
        
        // Header Logo Settings
        'header_logo_width' => 150,
        'header_logo_height' => 60,
        'header_logo_show_title' => true,
        'header_logo_title' => '',
        'header_logo_show_subtitle' => true,
        'header_logo_subtitle' => '',
        
        // Header Colors
        'header_bg_color' => '#ffffff',
        'header_text_color' => '#333333',
        'header_link_color' => '#2c5530',
        'header_link_hover_color' => '#f97316',
        'header_border_color' => '#e5e5e5',
        
        // Footer Settings
        'footer_copyright_text' => '© ' . date('Y') . ' جميع الحقوق محفوظة',
        'footer_show_social' => true,
        
        // General Settings
        'company_name' => 'شركة الأنظمة الصحية المتقدمة',
        'company_tagline' => 'حلول صرف صحي ذكية ومستدامة',
        'company_description' => 'نحن شركة متخصصة في تصميم وتنفيذ أنظمة الصرف الصحي المتطورة وحلول معالجة المياه',
        
        // Contact Settings
        'contact_email' => 'info@advanced-sanitation.com',
        'contact_phone' => '+971 4 XXX XXXX',
        'contact_address' => 'دبي، الإمارات العربية المتحدة',
        
        // SEO Settings
        'site_description' => 'شركة متخصصة في أنظمة الصرف الصحي المتقدمة وحلول معالجة المياه الصناعية',
        'site_keywords' => 'أنظمة صرف صحي، معالجة مياه، حلول بيئية، أنظمة صحية متقدمة',
    );
}

/**
 * Apply Redux settings for Industrial preset
 * 
 * @param bool $overwrite Whether to overwrite existing settings
 * @return array Result array
 */
function omran_demo_apply_redux_settings($overwrite = false) {
    if (!class_exists('Redux')) {
        return array(
            'success' => false,
            'message' => __('Redux Framework غير متاح', 'alomran')
        );
    }
    
    $opt_name = 'alomran_options';
    $settings = omran_demo_get_redux_settings();
    
    // Get current options
    $current_options = get_option($opt_name, array());
    
    if (!$overwrite) {
        // Merge with existing options (don't overwrite user settings)
        $settings = array_merge($current_options, $settings);
    }
    
    // Ensure preset is set
    $settings['theme_preset'] = 'industrial';
    
    // Save options
    $result = update_option($opt_name, $settings);
    
    // Clear Redux cache
    if (class_exists('Redux')) {
        try {
            delete_transient('redux-' . $opt_name);
            delete_transient('redux-' . $opt_name . '-transients');
            
            // Don't use Redux::setOption() here as it can cause "Illegal offset type" errors
            // The options will be loaded from database automatically
            // Just trigger the save hook to refresh UI
            do_action('redux/options/' . $opt_name . '/saved', $settings);
        } catch (Exception $e) {
            // Ignore errors
        }
    }
    
    if ($result) {
        return array(
            'success' => true,
            'message' => __('تم تطبيق إعدادات Redux بنجاح', 'alomran')
        );
    } else {
        return array(
            'success' => false,
            'message' => __('فشل في تطبيق إعدادات Redux', 'alomran')
        );
    }
}

/**
 * Hook into Redux reset actions to auto-apply preset settings
 * This ensures that when user clicks "Reset Section" or "Reset All" in Redux,
 * the preset default settings are automatically applied
 * 
 * NOTE: ALL HOOKS TEMPORARILY DISABLED TO FIX "Illegal offset type" ERROR
 * Using JavaScript-based solution instead via AJAX
 */
// ALL HOOKS DISABLED - Using JavaScript/AJAX solution instead
// add_action('redux/options/alomran_options/reset', 'omran_auto_apply_preset_redux_on_reset', 99, 1);
// add_action('redux/options/alomran_options/section/reset', 'omran_auto_apply_preset_redux_on_section_reset', 99, 2);
// add_filter('redux/options/alomran_options/saved', 'omran_auto_apply_preset_redux_on_save', 99, 2);

/**
 * Handle full reset (Reset All)
 * Note: This is an action hook, not a filter, so we don't return anything
 */
function omran_auto_apply_preset_redux_on_reset($options) {
    // Get active preset
    $preset = AlOmran_Preset_Loader::get_active_preset();
    
    if (!$preset || !function_exists('omran_demo_get_redux_settings')) {
        return;
    }
    
    // Use admin_footer to apply settings after Redux finishes resetting
    add_action('admin_footer', function() use ($preset) {
        // Get fresh settings
        $settings = omran_demo_get_redux_settings();
        
        // Ensure settings is an array
        if (!is_array($settings)) {
            return;
        }
        
        // Ensure preset is set
        $settings['theme_preset'] = $preset;
        
        // Save immediately
        $opt_name = 'alomran_options';
        update_option($opt_name, $settings);
        
        // Clear cache
        if (class_exists('Redux')) {
            try {
                delete_transient('redux-' . $opt_name);
                delete_transient('redux-' . $opt_name . '-transients');
            } catch (Exception $e) {
                // Ignore errors
            }
        }
    }, 999);
}

/**
 * Handle section reset (Reset Section)
 * Note: This is an action hook, not a filter, so we don't return anything
 */
function omran_auto_apply_preset_redux_on_section_reset($options, $section_id) {
    // Get active preset
    $preset = AlOmran_Preset_Loader::get_active_preset();
    
    if (!$preset || !function_exists('omran_demo_get_redux_settings')) {
        return;
    }
    
    // Use admin_footer to apply settings after Redux finishes resetting
    add_action('admin_footer', function() use ($preset) {
        // Get preset defaults
        $defaults = omran_demo_get_redux_settings();
        
        // Ensure defaults is an array
        if (!is_array($defaults)) {
            return;
        }
        
        // Get current options
        $opt_name = 'alomran_options';
        $current = get_option($opt_name, array());
        
        // Ensure current is an array
        if (!is_array($current)) {
            $current = array();
        }
        
        // Merge: current options + section defaults from preset
        $merged = array_merge($current, $defaults);
        $merged['theme_preset'] = $preset;
        
        // Save
        update_option($opt_name, $merged);
        
        // Clear cache
        if (class_exists('Redux')) {
            try {
                delete_transient('redux-' . $opt_name);
                delete_transient('redux-' . $opt_name . '-transients');
            } catch (Exception $e) {
                // Ignore errors
            }
        }
    }, 999);
}

/**
 * Auto-apply preset settings when Redux options are saved
 * This ensures preset defaults are maintained after save
 */
function omran_auto_apply_preset_redux_on_save($options, $changed_values) {
    // Ensure theme_preset is always set
    if (is_array($options) && !isset($options['theme_preset'])) {
        $preset = AlOmran_Preset_Loader::get_active_preset();
        if ($preset) {
            $options['theme_preset'] = $preset;
            update_option('alomran_options', $options);
        }
    }
    
    return $options;
}

/**
 * Add JavaScript to auto-apply preset defaults after reset
 * This ensures Redux UI is updated immediately after reset
 */
add_action('admin_footer', 'omran_redux_reset_auto_save_script');
function omran_redux_reset_auto_save_script() {
    // Only on Redux options page
    $screen = get_current_screen();
    if (!$screen || strpos($screen->id, 'alomran-options') === false) {
        return;
    }
    
    $preset = AlOmran_Preset_Loader::get_active_preset();
    if (!$preset) {
        return;
    }
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Hook into Redux reset button clicks
        $(document).on('click', '.redux-reset-section, .redux-reset', function(e) {
            var $button = $(this);
            
            // After reset completes, apply preset defaults via AJAX
            setTimeout(function() {
                // Make AJAX call to apply preset defaults
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'omran_apply_preset_defaults',
                        preset: '<?php echo esc_js($preset); ?>',
                        nonce: '<?php echo wp_create_nonce('omran_apply_defaults'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Reload page to show new defaults
                            location.reload();
                        }
                    }
                });
            }, 1500);
        });
    });
    </script>
    <?php
}

/**
 * AJAX handler to apply preset defaults after reset
 */
add_action('wp_ajax_omran_apply_preset_defaults', 'omran_ajax_apply_preset_defaults');
function omran_ajax_apply_preset_defaults() {
    check_ajax_referer('omran_apply_defaults', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => __('غير مصرح', 'alomran')));
    }
    
    $preset = isset($_POST['preset']) ? sanitize_text_field($_POST['preset']) : '';
    
    if (empty($preset) || !function_exists('omran_demo_apply_redux_settings')) {
        wp_send_json_error(array('message' => __('خطأ في تطبيق الإعدادات', 'alomran')));
    }
    
    // Apply preset defaults
    $result = omran_demo_apply_redux_settings(true);
    
    if ($result['success']) {
        wp_send_json_success(array('message' => $result['message']));
    } else {
        wp_send_json_error(array('message' => $result['message']));
    }
}

