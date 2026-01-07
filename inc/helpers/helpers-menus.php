<?php
/**
 * Menu Import Helper Functions
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Import menus from JSON file for a preset
 * 
 * @param string $preset Preset name (tech, food, industrial)
 * @param bool $force_update Force update even if menu has items (default: false - only import if menu is empty)
 * @return array Result with success status and message
 */
function alomran_import_preset_menus($preset = 'tech', $force_update = false) {
    if (!current_user_can('manage_options')) {
        return array('success' => false, 'message' => 'غير مصرح');
    }
    
    // Get preset directory
    $preset_dir = get_template_directory() . '/presets/' . $preset;
    $menus_file = $preset_dir . '/demo/menus.json';
    
    if (!file_exists($menus_file)) {
        return array('success' => false, 'message' => 'ملف القوائم غير موجود: ' . $menus_file);
    }
    
    $menus_json = file_get_contents($menus_file);
    $menus_data = json_decode($menus_json, true);
    
    if (!$menus_data || !is_array($menus_data)) {
        return array('success' => false, 'message' => 'خطأ في قراءة ملف القوائم');
    }
    
    $results = array(
        'menus_created' => 0,
        'menus_updated' => 0,
        'items_created' => 0,
    );
    
    foreach ($menus_data as $menu_data) {
        if (!isset($menu_data['name']) || !isset($menu_data['location'])) {
            continue;
        }
        
        $menu_name = $menu_data['name'];
        $menu_location = $menu_data['location'];
        $menu_items = isset($menu_data['items']) ? $menu_data['items'] : array();
        
        // Check if menu exists
        $menu = wp_get_nav_menu_object($menu_name);
        
        if (!$menu) {
            // Create new menu
            $menu_id = wp_create_nav_menu($menu_name);
            if (is_wp_error($menu_id)) {
                continue;
            }
            $menu = wp_get_nav_menu_object($menu_id);
            $results['menus_created']++;
        } else {
            // Check if menu has existing items
            $existing_items = wp_get_nav_menu_items($menu->term_id);
            
            // Only clear and update if menu is empty OR force_update is true
            if (empty($existing_items) || $force_update) {
                if ($existing_items) {
                    foreach ($existing_items as $item) {
                        wp_delete_post($item->ID, true);
                    }
                }
                $results['menus_updated']++;
            } else {
                // Menu has items and force_update is false - skip this menu to preserve user edits
                continue;
            }
        }
        
        if (!$menu) {
            continue;
        }
        
        // Add menu items
        $parent_item_ids = array();
        
        foreach ($menu_items as $item_data) {
            $item_title = isset($item_data['title']) ? $item_data['title'] : '';
            $item_url = isset($item_data['url']) ? $item_data['url'] : '#';
            $item_type = isset($item_data['type']) ? $item_data['type'] : 'custom';
            $item_children = isset($item_data['children']) ? $item_data['children'] : array();
            
            if (empty($item_title)) {
                continue;
            }
            
            // Determine menu item type and URL
            $menu_item_type = 'custom';
            $menu_item_url = $item_url;
            $menu_item_object_id = 0;
            
            if ($item_type === 'page' && !empty($item_url)) {
                // Remove leading slash
                $page_slug = ltrim($item_url, '/');
                
                // Try to find page by slug
                $page = get_page_by_path($page_slug);
                if ($page) {
                    $menu_item_type = 'post_type';
                    $menu_item_object = 'page';
                    $menu_item_object_id = $page->ID;
                    $menu_item_url = get_permalink($page->ID);
                } else {
                    // If page not found, use custom link
                    $menu_item_url = alomran_format_url($item_url);
                }
            } elseif ($item_type === 'custom' && !empty($item_url) && $item_url !== '#') {
                // Format custom URL
                if (strpos($item_url, '/') === 0) {
                    $menu_item_url = alomran_format_url($item_url);
                } else {
                    $menu_item_url = $item_url;
                }
            } else {
                // Empty URL or hash link
                $menu_item_url = $item_url;
            }
            
            // Create parent menu item
            $parent_item_id = wp_update_nav_menu_item($menu->term_id, 0, array(
                'menu-item-title' => $item_title,
                'menu-item-type' => $menu_item_type,
                'menu-item-object' => isset($menu_item_object) ? $menu_item_object : '',
                'menu-item-object-id' => $menu_item_object_id,
                'menu-item-url' => $menu_item_url,
                'menu-item-status' => 'publish',
            ));
            
            if (is_wp_error($parent_item_id)) {
                continue;
            }
            
            $parent_item_ids[] = $parent_item_id;
            $results['items_created']++;
            
            // Add children items
            if (!empty($item_children) && is_array($item_children)) {
                foreach ($item_children as $child_data) {
                    $child_title = isset($child_data['title']) ? $child_data['title'] : '';
                    $child_url = isset($child_data['url']) ? $child_data['url'] : '#';
                    $child_type = isset($child_data['type']) ? $child_data['type'] : 'custom';
                    
                    if (empty($child_title)) {
                        continue;
                    }
                    
                    // Determine child menu item type and URL
                    $child_menu_item_type = 'custom';
                    $child_menu_item_url = $child_url;
                    $child_menu_item_object_id = 0;
                    
                    if ($child_type === 'page' && !empty($child_url)) {
                        $child_page_slug = ltrim($child_url, '/');
                        $child_page = get_page_by_path($child_page_slug);
                        if ($child_page) {
                            $child_menu_item_type = 'post_type';
                            $child_menu_item_object = 'page';
                            $child_menu_item_object_id = $child_page->ID;
                            $child_menu_item_url = get_permalink($child_page->ID);
                        } else {
                            $child_menu_item_url = alomran_format_url($child_url);
                        }
                    } elseif ($child_type === 'custom' && !empty($child_url) && $child_url !== '#') {
                        if (strpos($child_url, '/') === 0) {
                            $child_menu_item_url = alomran_format_url($child_url);
                        } else {
                            $child_menu_item_url = $child_url;
                        }
                    } else {
                        $child_menu_item_url = $child_url;
                    }
                    
                    // Create child menu item
                    wp_update_nav_menu_item($menu->term_id, 0, array(
                        'menu-item-title' => $child_title,
                        'menu-item-type' => $child_menu_item_type,
                        'menu-item-object' => isset($child_menu_item_object) ? $child_menu_item_object : '',
                        'menu-item-object-id' => $child_menu_item_object_id,
                        'menu-item-url' => $child_menu_item_url,
                        'menu-item-parent-id' => $parent_item_id,
                        'menu-item-status' => 'publish',
                    ));
                    
                    $results['items_created']++;
                }
            }
        }
        
        // Set preset meta for menu - CRITICAL for content isolation
        if (function_exists('alomran_set_menu_preset')) {
            alomran_set_menu_preset($menu->term_id, $preset);
        }
        
        // Assign menu to location
        $locations = get_theme_mod('nav_menu_locations', array());
        $locations[$menu_location] = $menu->term_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
    
    return array(
        'success' => true,
        'message' => sprintf(
            'تم استيراد القوائم بنجاح: %d قائمة جديدة، %d قائمة محدثة، %d عنصر',
            $results['menus_created'],
            $results['menus_updated'],
            $results['items_created']
        ),
        'results' => $results,
    );
}

/**
 * Get import summary for a preset
 * Analyzes content.json and menus.json to show what will be imported
 * 
 * @param string $preset Preset name (tech, food, industrial)
 * @return array Summary of what will be imported
 */
function alomran_get_preset_import_summary($preset = 'tech') {
    $preset_dir = get_template_directory() . '/presets/' . $preset;
    $content_file = $preset_dir . '/demo/content.json';
    $menus_file = $preset_dir . '/demo/menus.json';
    
    $summary = array(
        'pages' => 0,
        'products' => 0,
        'news' => 0,
        'menu_items' => 0,
        'blog_posts' => 0,
        'branches' => 0,
        'testimonials' => 0,
        'faqs' => 0,
        'menus' => 0,
        'other' => array(),
    );
    
    // Count content from content.json
    if (file_exists($content_file)) {
        $content_json = file_get_contents($content_file);
        $content_data = json_decode($content_json, true);
        
        if ($content_data && is_array($content_data)) {
            foreach ($content_data as $item) {
                $post_type = isset($item['post_type']) ? $item['post_type'] : '';
                
                switch ($post_type) {
                    case 'page':
                        $summary['pages']++;
                        break;
                    case 'product':
                        $summary['products']++;
                        break;
                    case 'news':
                        $summary['news']++;
                        break;
                    case 'menu_item':
                        $summary['menu_items']++;
                        break;
                    case 'blog_post':
                        $summary['blog_posts']++;
                        break;
                    case 'branch':
                        $summary['branches']++;
                        break;
                    case 'testimonial':
                        $summary['testimonials']++;
                        break;
                    case 'faq':
                        $summary['faqs']++;
                        break;
                    default:
                        if (!empty($post_type)) {
                            if (!isset($summary['other'][$post_type])) {
                                $summary['other'][$post_type] = 0;
                            }
                            $summary['other'][$post_type]++;
                        }
                        break;
                }
            }
        }
    }
    
    // Count menus from menus.json
    if (file_exists($menus_file)) {
        $menus_json = file_get_contents($menus_file);
        $menus_data = json_decode($menus_json, true);
        
        if ($menus_data && is_array($menus_data)) {
            $summary['menus'] = count($menus_data);
        }
    }
    
    return $summary;
}

