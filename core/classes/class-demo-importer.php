<?php
/**
 * Core Demo Importer
 * 
 * Handles importing demo content, media, and Redux settings for presets
 * 
 * @package AlOmran
 * @subpackage Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class AlOmran_Demo_Importer {
    
    /**
     * Initialize demo importer
     */
    public static function init() {
        // Register AJAX handlers
        add_action('wp_ajax_alomran_import_demo', array(__CLASS__, 'handle_ajax_import'));
        
        // Register import status check
        add_action('wp_ajax_alomran_check_import_status', array(__CLASS__, 'handle_check_status'));
    }
    
    /**
     * Import demo data for a preset
     * 
     * @param string $preset Preset name
     * @param array $options Import options
     * @return array Result array with success status and message
     */
    public static function import_demo($preset, $options = array()) {
        // Capability check
        if (!current_user_can('manage_options')) {
            return array(
                'success' => false,
                'message' => __('ليس لديك صلاحية لاستيراد المحتوى التجريبي.', 'alomran')
            );
        }
        
        // Validate preset
        if (!AlOmran_Preset_Loader::preset_exists($preset)) {
            return array(
                'success' => false,
                'message' => sprintf(__('القالب "%s" غير موجود.', 'alomran'), esc_html($preset))
            );
        }
        
        // Default options
        $defaults = array(
            'import_content' => true,
            'import_media' => true,
            'import_redux' => true,
            'import_menus' => true,
            'overwrite' => false,
            'delete_other_presets' => true, // Delete content from other presets
        );
        
        $options = wp_parse_args($options, $defaults);
        
        $results = array();
        
        // Delete content from other presets if requested
        if ($options['delete_other_presets']) {
            $available_presets = AlOmran_Preset_Loader::get_available_presets();
            foreach ($available_presets as $other_preset) {
                if ($other_preset !== $preset) {
                    $delete_result = alomran_delete_preset_content($other_preset);
                    $results['deleted_' . $other_preset] = $delete_result;
                }
            }
        }
        
        // Import Redux settings
        if ($options['import_redux']) {
            $redux_result = self::import_redux_settings($preset, $options['overwrite']);
            $results['redux'] = $redux_result;
        }
        
        // Import menus
        if ($options['import_menus']) {
            $menus_result = self::import_menus($preset);
            $results['menus'] = $menus_result;
        }
        
        // Import content
        if ($options['import_content']) {
            $content_result = self::import_content($preset, $options['overwrite']);
            $results['content'] = $content_result;
        }
        
        // Import media
        if ($options['import_media']) {
            $media_result = self::import_media($preset);
            $results['media'] = $media_result;
        }
        
        // Mark as imported
        update_option('alomran_demo_imported_' . $preset, time());
        update_option('alomran_demo_imported_preset', $preset);
        
        $preset_names = array(
            'industrial' => 'الصناعي',
            'food' => 'الطعام والمشروبات',
            'tech' => 'التكنولوجيا'
        );
        $preset_name = isset($preset_names[$preset]) ? $preset_names[$preset] : $preset;
        
        return array(
            'success' => true,
            'message' => sprintf(__('تم استيراد بيانات القالب "%s" بنجاح.', 'alomran'), esc_html($preset_name)),
            'results' => $results
        );
    }
    
    /**
     * Import Redux settings from preset
     * 
     * @param string $preset Preset name
     * @param bool $overwrite Whether to overwrite existing settings
     * @return array
     */
    private static function import_redux_settings($preset, $overwrite = false) {
        if (!class_exists('Redux')) {
            return array('success' => false, 'message' => __('Redux Framework غير متاح', 'alomran'));
        }
        
        $preset_dir = AlOmran_Preset_Loader::get_preset_dir($preset);
        if (!$preset_dir) {
            return array('success' => false, 'message' => __('مجلد القالب غير موجود', 'alomran'));
        }
        
        // Load Redux JSON
        $redux_json = $preset_dir . '/demo/redux-settings.json';
        if (!file_exists($redux_json)) {
            return array('success' => false, 'message' => __('ملف إعدادات Redux غير موجود', 'alomran'));
        }
        
        $json_content = file_get_contents($redux_json);
        if (!$json_content) {
            return array('success' => false, 'message' => __('لا يمكن قراءة ملف إعدادات Redux', 'alomran'));
        }
        
        $settings = json_decode($json_content, true);
        if (!$settings || !is_array($settings)) {
            return array('success' => false, 'message' => __('تنسيق إعدادات Redux غير صحيح', 'alomran'));
        }
        
        $opt_name = 'alomran_options';
        $current_options = get_option($opt_name, array());
        
        if (!$overwrite) {
            // Merge with existing options
            $settings = array_merge($current_options, $settings);
        }
        
        // Ensure preset is set
        $settings['theme_preset'] = $preset;
        
        // Save options
        update_option($opt_name, $settings);
        
        // Clear Redux cache if method exists
        if (class_exists('Redux')) {
            try {
                delete_transient('redux-' . $opt_name);
            } catch (Exception $e) {
                // Ignore errors
            }
        }
        
        return array('success' => true, 'message' => __('تم استيراد إعدادات Redux', 'alomran'));
    }
    
    /**
     * Import menus from preset
     * 
     * @param string $preset Preset name
     * @return array
     */
    private static function import_menus($preset) {
        $preset_dir = AlOmran_Preset_Loader::get_preset_dir($preset);
        if (!$preset_dir) {
            return array('success' => false, 'message' => __('مجلد القالب غير موجود', 'alomran'));
        }
        
        $menus_json = $preset_dir . '/demo/menus.json';
        if (!file_exists($menus_json)) {
            return array('success' => false, 'message' => __('ملف القوائم غير موجود', 'alomran'));
        }
        
        $json_content = file_get_contents($menus_json);
        if (!$json_content) {
            return array('success' => false, 'message' => __('لا يمكن قراءة ملف القوائم', 'alomran'));
        }
        
        $menus_data = json_decode($json_content, true);
        if (!$menus_data || !is_array($menus_data)) {
            return array('success' => false, 'message' => __('تنسيق القوائم غير صحيح', 'alomran'));
        }
        
        $imported = 0;
        
        foreach ($menus_data as $menu_data) {
            if (!isset($menu_data['name']) || !isset($menu_data['items'])) {
                continue;
            }
            
            $menu_name = sanitize_text_field($menu_data['name']);
            $menu_location = isset($menu_data['location']) ? sanitize_text_field($menu_data['location']) : '';
            
            // Check if menu exists
            $menu = wp_get_nav_menu_object($menu_name);
            
            if (!$menu) {
                // Create menu
                $menu_id = wp_create_nav_menu($menu_name);
            } else {
                $menu_id = $menu->term_id;
            }
            
            if (is_wp_error($menu_id)) {
                continue;
            }
            
            // Clear existing items
            $existing_items = wp_get_nav_menu_items($menu_id);
            if ($existing_items) {
                foreach ($existing_items as $item) {
                    wp_delete_post($item->ID, true);
                }
            }
            
            // Add menu items
            foreach ($menu_data['items'] as $item_data) {
                $item_args = array(
                    'menu-item-title' => isset($item_data['title']) ? sanitize_text_field($item_data['title']) : '',
                    'menu-item-url' => isset($item_data['url']) ? esc_url_raw($item_data['url']) : '',
                    'menu-item-status' => 'publish',
                );
                
                if (isset($item_data['type']) && $item_data['type'] === 'page' && isset($item_data['page_id'])) {
                    $item_args['menu-item-type'] = 'post_type';
                    $item_args['menu-item-object'] = 'page';
                    $item_args['menu-item-object-id'] = intval($item_data['page_id']);
                }
                
                wp_update_nav_menu_item($menu_id, 0, $item_args);
            }
            
            // Set preset meta for menu - CRITICAL for content isolation
            alomran_set_menu_preset($menu_id, $preset);
            
            // Assign to location
            if ($menu_location) {
                $locations = get_theme_mod('nav_menu_locations', array());
                $locations[$menu_location] = $menu_id;
                set_theme_mod('nav_menu_locations', $locations);
            }
            
            $imported++;
        }
        
        return array(
            'success' => true,
            'message' => sprintf(_n('تم استيراد %d قائمة', 'تم استيراد %d قائمة', $imported, 'alomran'), $imported)
        );
    }
    
    /**
     * Import content from preset
     * 
     * @param string $preset Preset name
     * @param bool $overwrite Whether to overwrite existing content
     * @return array
     */
    private static function import_content($preset, $overwrite = false) {
        $preset_dir = AlOmran_Preset_Loader::get_preset_dir($preset);
        if (!$preset_dir) {
            return array('success' => false, 'message' => __('مجلد القالب غير موجود', 'alomran'));
        }
        
        $content_json = $preset_dir . '/demo/content.json';
        if (!file_exists($content_json)) {
            return array('success' => false, 'message' => __('ملف المحتوى غير موجود', 'alomran'));
        }
        
        $json_content = file_get_contents($content_json);
        if (!$json_content) {
            return array('success' => false, 'message' => __('لا يمكن قراءة ملف المحتوى', 'alomran'));
        }
        
        $content_data = json_decode($json_content, true);
        if (!$content_data || !is_array($content_data)) {
            return array('success' => false, 'message' => __('تنسيق المحتوى غير صحيح', 'alomran'));
        }
        
        $imported = 0;
        
        foreach ($content_data as $item) {
            if (!isset($item['post_type']) || !isset($item['post_title'])) {
                continue;
            }
            
            $post_type = sanitize_key($item['post_type']);
            $post_title = sanitize_text_field($item['post_title']);
            
            // Check if post exists
            $existing = get_page_by_path(sanitize_title($post_title), OBJECT, $post_type);
            
            if ($existing && !$overwrite) {
                continue;
            }
            
            $post_data = array(
                'post_title' => $post_title,
                'post_content' => isset($item['post_content']) ? wp_kses_post($item['post_content']) : '',
                'post_excerpt' => isset($item['post_excerpt']) ? sanitize_text_field($item['post_excerpt']) : '',
                'post_status' => isset($item['post_status']) ? sanitize_key($item['post_status']) : 'publish',
                'post_type' => $post_type,
                'post_author' => get_current_user_id(),
            );
            
            if ($existing && $overwrite) {
                $post_data['ID'] = $existing->ID;
            }
            
            $post_id = wp_insert_post($post_data);
            
            if (is_wp_error($post_id)) {
                continue;
            }
            
            // Set preset meta - CRITICAL for content isolation
            alomran_set_post_preset($post_id, $preset);
            
            // Set featured image if provided
            if (isset($item['featured_image']) && !empty($item['featured_image'])) {
                // This will be handled by media import
            }
            
            // Set meta fields
            if (isset($item['meta']) && is_array($item['meta'])) {
                foreach ($item['meta'] as $key => $value) {
                    update_post_meta($post_id, sanitize_key($key), $value);
                }
            }
            
            $imported++;
        }
        
        return array(
            'success' => true,
            'message' => sprintf(_n('تم استيراد %d عنصر محتوى', 'تم استيراد %d عنصر محتوى', $imported, 'alomran'), $imported)
        );
    }
    
    /**
     * Import media from preset
     * 
     * @param string $preset Preset name
     * @return array
     */
    private static function import_media($preset) {
        $preset_dir = AlOmran_Preset_Loader::get_preset_dir($preset);
        if (!$preset_dir) {
            return array('success' => false, 'message' => __('مجلد القالب غير موجود', 'alomran'));
        }
        
        $media_dir = $preset_dir . '/demo/media';
        if (!file_exists($media_dir) || !is_dir($media_dir)) {
            return array('success' => false, 'message' => __('مجلد الوسائط غير موجود', 'alomran'));
        }
        
        $media_files = glob($media_dir . '/*.{jpg,jpeg,png,gif,svg,pdf}', GLOB_BRACE);
        if (empty($media_files)) {
            return array('success' => false, 'message' => __('لم يتم العثور على ملفات وسائط', 'alomran'));
        }
        
        $imported = 0;
        
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        
        foreach ($media_files as $file_path) {
            $file_name = basename($file_path);
            
            // Check if already imported
            $existing = get_posts(array(
                'post_type' => 'attachment',
                'post_status' => 'any',
                'meta_query' => array(
                    array(
                        'key' => '_wp_attached_file',
                        'value' => $file_name,
                        'compare' => 'LIKE'
                    )
                ),
                'posts_per_page' => 1
            ));
            
            if (!empty($existing)) {
                continue;
            }
            
            $file_array = array(
                'name' => $file_name,
                'tmp_name' => $file_path
            );
            
            $attachment_id = media_handle_sideload($file_array, 0);
            
            if (!is_wp_error($attachment_id)) {
                $imported++;
            }
        }
        
        return array(
            'success' => true,
            'message' => sprintf(_n('تم استيراد %d ملف وسائط', 'تم استيراد %d ملف وسائط', $imported, 'alomran'), $imported)
        );
    }
    
    /**
     * Handle AJAX import request
     */
    public static function handle_ajax_import() {
        check_ajax_referer('alomran_import_demo', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('غير مصرح', 'alomran')));
        }
        
        $preset = isset($_POST['preset']) ? sanitize_text_field($_POST['preset']) : '';
        if (empty($preset)) {
            wp_send_json_error(array('message' => __('لم يتم تحديد القالب', 'alomran')));
        }
        
        $options = array(
            'import_content' => isset($_POST['import_content']) ? (bool) $_POST['import_content'] : true,
            'import_media' => isset($_POST['import_media']) ? (bool) $_POST['import_media'] : true,
            'import_redux' => isset($_POST['import_redux']) ? (bool) $_POST['import_redux'] : true,
            'import_menus' => isset($_POST['import_menus']) ? (bool) $_POST['import_menus'] : true,
            'overwrite' => isset($_POST['overwrite']) ? (bool) $_POST['overwrite'] : false,
        );
        
        $result = self::import_demo($preset, $options);
        
        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result);
        }
    }
    
    /**
     * Handle import status check
     */
    public static function handle_check_status() {
        check_ajax_referer('alomran_check_status', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('غير مصرح', 'alomran')));
        }
        
        $preset = isset($_POST['preset']) ? sanitize_text_field($_POST['preset']) : '';
        
        $imported = get_option('alomran_demo_imported_' . $preset, false);
        $imported_preset = get_option('alomran_demo_imported_preset', '');
        
        wp_send_json_success(array(
            'imported' => (bool) $imported,
            'preset' => $imported_preset,
            'timestamp' => $imported
        ));
    }
    
    /**
     * Check if demo is imported for preset
     * 
     * @param string $preset Preset name
     * @return bool
     */
    public static function is_demo_imported($preset) {
        return (bool) get_option('alomran_demo_imported_' . $preset, false);
    }
}

