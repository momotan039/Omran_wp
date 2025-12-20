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
        
        // CRITICAL: Ensure CPTs and Taxonomies are registered FIRST before any import
        if (class_exists('AlOmran_Preset_Registry')) {
            AlOmran_Preset_Registry::register_preset_cpts();
            AlOmran_Preset_Registry::register_preset_taxonomies();
        }
        
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
        
        // Import taxonomies FIRST (before content) so terms are available when linking posts
        $taxonomies_result = self::import_taxonomies($preset);
        $results['taxonomies'] = $taxonomies_result;
        
        // Import media (before content) so images are available when setting featured images
        if ($options['import_media']) {
            $media_result = self::import_media($preset);
            $results['media'] = $media_result;
        }
        
        // Import content (after taxonomies and media so terms and featured images can be set)
        if ($options['import_content']) {
            $content_result = self::import_content($preset, $options['overwrite']);
            $results['content'] = $content_result;
        }
        
        // Import menus (after content so menu items can link to imported pages/posts)
        if ($options['import_menus']) {
            $menus_result = self::import_menus($preset);
            $results['menus'] = $menus_result;
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
        
        // Link media files to Redux settings (for media fields)
        $media_dir = $preset_dir . '/demo/media';
        if (is_dir($media_dir)) {
            // List of Redux media field keys that should link to media files
            $media_fields = array(
                'food_story_page_image',
                'food_story_image',
                'food_hero_background_image',
                'food_philosophy_image',
                'food_experience_background',
            );
            
            foreach ($media_fields as $field_key) {
                if (isset($settings[$field_key]) && !empty($settings[$field_key])) {
                    // If it's a filename (string), try to find the attachment
                    if (is_string($settings[$field_key]) && !is_numeric($settings[$field_key])) {
                        $filename = basename($settings[$field_key]);
                        $attachment = self::find_attachment_by_filename($filename);
                        if ($attachment) {
                            $settings[$field_key] = array(
                                'id' => $attachment->ID,
                                'url' => wp_get_attachment_image_url($attachment->ID, 'full'),
                                'thumbnail' => wp_get_attachment_image_url($attachment->ID, 'thumbnail'),
                            );
                        }
                    }
                }
            }
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
     * Find attachment by filename
     * 
     * @param string $filename Filename to search for
     * @return WP_Post|false
     */
    private static function find_attachment_by_filename($filename) {
        global $wpdb;
        
        $filename = sanitize_file_name($filename);
        
        // First try by _demo_original_filename meta
        $attachment_id = $wpdb->get_var($wpdb->prepare(
            "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_demo_original_filename' AND meta_value = %s LIMIT 1",
            $filename
        ));
        
        if ($attachment_id) {
            return get_post($attachment_id);
        }
        
        // Try by guid (URL contains filename)
        $attachment = $wpdb->get_var($wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND guid LIKE %s LIMIT 1",
            '%' . $wpdb->esc_like($filename) . '%'
        ));
        
        if ($attachment) {
            return get_post($attachment);
        }
        
        // Try by post_title (filename without extension)
        $name_without_ext = pathinfo($filename, PATHINFO_FILENAME);
        $attachment = $wpdb->get_var($wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_title = %s LIMIT 1",
            $name_without_ext
        ));
        
        if ($attachment) {
            return get_post($attachment);
        }
        
        return false;
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
                
                if (isset($item_data['type'])) {
                    if ($item_data['type'] === 'page' && isset($item_data['page_id'])) {
                        $item_args['menu-item-type'] = 'post_type';
                        $item_args['menu-item-object'] = 'page';
                        $item_args['menu-item-object-id'] = intval($item_data['page_id']);
                    } elseif ($item_data['type'] === 'post_type' && isset($item_data['post_type'])) {
                        // Handle custom post type archive links
                        $archive_url = get_post_type_archive_link($item_data['post_type']);
                        if ($archive_url) {
                            $item_args['menu-item-url'] = $archive_url;
                        }
                    }
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
     * Import taxonomies from preset
     * 
     * @param string $preset Preset name
     * @return array
     */
    private static function import_taxonomies($preset) {
        $preset_dir = AlOmran_Preset_Loader::get_preset_dir($preset);
        if (!$preset_dir) {
            return array('success' => false, 'message' => __('مجلد القالب غير موجود', 'alomran'));
        }
        
        $taxonomies_json = $preset_dir . '/demo/taxonomies.json';
        if (!file_exists($taxonomies_json)) {
            // Not an error, taxonomies.json is optional
            return array('success' => true, 'message' => __('لا يوجد ملف تصنيفات', 'alomran'), 'imported' => 0);
        }
        
        $json_content = file_get_contents($taxonomies_json);
        if (!$json_content) {
            return array('success' => false, 'message' => __('لا يمكن قراءة ملف التصنيفات', 'alomran'));
        }
        
        $taxonomies_data = json_decode($json_content, true);
        if (!$taxonomies_data || !is_array($taxonomies_data)) {
            return array('success' => false, 'message' => __('تنسيق التصنيفات غير صحيح', 'alomran'));
        }
        
        // Ensure taxonomies are registered before importing
        if (class_exists('AlOmran_Preset_Registry')) {
            AlOmran_Preset_Registry::register_preset_taxonomies();
        }
        
        $imported = 0;
        
        foreach ($taxonomies_data as $taxonomy_data) {
            if (!isset($taxonomy_data['taxonomy']) || !isset($taxonomy_data['terms'])) {
                continue;
            }
            
            $taxonomy = sanitize_key($taxonomy_data['taxonomy']);
            
            if (!taxonomy_exists($taxonomy)) {
                continue;
            }
            
            foreach ($taxonomy_data['terms'] as $term_data) {
                if (!isset($term_data['name']) || !isset($term_data['slug'])) {
                    continue;
                }
                
                $term_name = sanitize_text_field($term_data['name']);
                $term_slug = sanitize_title($term_data['slug']);
                $term_description = isset($term_data['description']) ? sanitize_textarea_field($term_data['description']) : '';
                
                // Check if term exists
                $existing_term = get_term_by('slug', $term_slug, $taxonomy);
                $term_id = null;
                
                if ($existing_term) {
                    // Update existing term
                    $update_result = wp_update_term($existing_term->term_id, $taxonomy, array(
                        'name' => $term_name,
                        'description' => $term_description,
                    ));
                    
                    if (!is_wp_error($update_result)) {
                        $term_id = $existing_term->term_id;
                    }
                } else {
                    // Create new term
                    $result = wp_insert_term($term_name, $taxonomy, array(
                        'slug' => $term_slug,
                        'description' => $term_description,
                    ));
                    
                    if (is_wp_error($result)) {
                        continue;
                    }
                    
                    $term_id = isset($result['term_id']) ? $result['term_id'] : null;
                }
                
                // Set preset meta for taxonomy term
                if ($term_id) {
                    update_term_meta($term_id, ALOMRAN_PRESET_META_KEY, $preset);
                    $imported++;
                }
            }
        }
        
        return array(
            'success' => true,
            'message' => sprintf(_n('تم استيراد %d تصنيف', 'تم استيراد %d تصنيف', $imported, 'alomran'), $imported),
            'imported' => $imported
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
            $post_name = isset($item['post_name']) ? sanitize_title($item['post_name']) : sanitize_title($post_title);
            
            // Check if post exists by post_name (slug) or title
            $existing = null;
            if (!empty($post_name)) {
                $existing = get_page_by_path($post_name, OBJECT, $post_type);
            }
            if (!$existing) {
                // Try to find by title for CPTs
                if ($post_type !== 'page') {
                    $existing_posts = get_posts(array(
                        'post_type' => $post_type,
                        'title' => $post_title,
                        'posts_per_page' => 1,
                        'post_status' => 'any',
                    ));
                    if (!empty($existing_posts)) {
                        $existing = $existing_posts[0];
                    }
                } else {
                    $existing = get_page_by_path(sanitize_title($post_title), OBJECT, $post_type);
                }
            }
            
            if ($existing && !$overwrite) {
                continue;
            }
            
            $post_data = array(
                'post_title' => $post_title,
                'post_name' => $post_name,
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
            
            // Set meta fields
            if (isset($item['meta']) && is_array($item['meta'])) {
                foreach ($item['meta'] as $key => $value) {
                    // Skip featured_image from meta, handle separately
                    if ($key === 'featured_image') {
                        continue;
                    }
                    
                    // Handle page template specially for pages
                    if ($key === '_wp_page_template' && $post_type === 'page') {
                        // Convert template filename to full preset path
                        // e.g., 'page-story.php' -> 'presets/food/templates/page-story.php'
                        $template_filename = sanitize_text_field($value);
                        
                        // Check if it's already a full path
                        if (strpos($template_filename, 'presets/') === 0) {
                            $template_value = $template_filename;
                        } else {
                            // Build full path: presets/{preset}/templates/{filename}
                            $template_value = 'presets/' . $preset . '/templates/' . $template_filename;
                        }
                        
                        update_post_meta($post_id, '_wp_page_template', $template_value);
                    } else {
                        update_post_meta($post_id, sanitize_key($key), $value);
                    }
                }
            }
            
            // Set taxonomies
            if (isset($item['taxonomies']) && is_array($item['taxonomies'])) {
                foreach ($item['taxonomies'] as $taxonomy => $terms) {
                    if (!taxonomy_exists($taxonomy) || !is_array($terms)) {
                        continue;
                    }
                    
                    // Convert term slugs to term IDs
                    $term_ids = array();
                    foreach ($terms as $term_slug) {
                        $term = get_term_by('slug', sanitize_title($term_slug), $taxonomy);
                        if ($term && !is_wp_error($term)) {
                            $term_ids[] = $term->term_id;
                        } else {
                            // Try to find by name as fallback
                            $term = get_term_by('name', $term_slug, $taxonomy);
                            if ($term && !is_wp_error($term)) {
                                $term_ids[] = $term->term_id;
                            }
                        }
                    }
                    
                    // Set terms if we found any
                    if (!empty($term_ids)) {
                        wp_set_post_terms($post_id, $term_ids, $taxonomy, false);
                    }
                }
            }
            
            // Set featured image if provided (from meta or direct field)
            $featured_image = isset($item['meta']['featured_image']) ? $item['meta']['featured_image'] : (isset($item['featured_image']) ? $item['featured_image'] : '');
            if (!empty($featured_image)) {
                self::set_featured_image_from_media($post_id, $featured_image, $preset);
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
            
            // Copy file to temporary location to prevent deletion of original
            $temp_file = wp_tempnam($file_name);
            if (!$temp_file) {
                continue;
            }
            
            $copied = copy($file_path, $temp_file);
            if (!$copied) {
                @unlink($temp_file);
                continue;
            }
            
            $file_array = array(
                'name' => $file_name,
                'tmp_name' => $temp_file
            );
            
            // Suppress EXIF warnings during upload
            $old_error_reporting = error_reporting();
            error_reporting($old_error_reporting & ~E_WARNING);
            
            $attachment_id = media_handle_sideload($file_array, 0);
            
            // Restore error reporting
            error_reporting($old_error_reporting);
            
            // Clean up temp file if it still exists (media_handle_sideload may have moved it)
            if (file_exists($temp_file)) {
                @unlink($temp_file);
            }
            
            if (!is_wp_error($attachment_id)) {
                // Store original filename in attachment meta for later lookup
                update_post_meta($attachment_id, '_demo_original_filename', $file_name);
                $imported++;
            }
        }
        
        return array(
            'success' => true,
            'message' => sprintf(_n('تم استيراد %d ملف وسائط', 'تم استيراد %d ملف وسائط', $imported, 'alomran'), $imported)
        );
    }
    
    /**
     * Set featured image for post from media file
     * 
     * @param int $post_id Post ID
     * @param string $image_filename Image filename (e.g., 'menu-truffle-hummus.jpg')
     * @param string $preset Preset name
     * @return bool Success status
     */
    private static function set_featured_image_from_media($post_id, $image_filename, $preset) {
        // Find attachment by original filename
        $attachments = get_posts(array(
            'post_type' => 'attachment',
            'post_status' => 'any',
            'meta_query' => array(
                array(
                    'key' => '_demo_original_filename',
                    'value' => $image_filename,
                    'compare' => '='
                )
            ),
            'posts_per_page' => 1
        ));
        
        if (!empty($attachments)) {
            set_post_thumbnail($post_id, $attachments[0]->ID);
            return true;
        }
        
        // Fallback: try to find by filename in attachment URL
        $attachments = get_posts(array(
            'post_type' => 'attachment',
            'post_status' => 'any',
            'meta_query' => array(
                array(
                    'key' => '_wp_attached_file',
                    'value' => $image_filename,
                    'compare' => 'LIKE'
                )
            ),
            'posts_per_page' => 1
        ));
        
        if (!empty($attachments)) {
            set_post_thumbnail($post_id, $attachments[0]->ID);
            return true;
        }
        
        return false;
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

