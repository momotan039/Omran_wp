<?php
/**
 * Tech Preset - Default Footer Template
 *
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Tech Preset - Footer Helper Functions
 */

// Get footer settings
$logo_text = alomran_get_option('tech_header_logo_text', 'إتقان');
$footer_description = alomran_get_option('tech_footer_description', 'المنصة التقنية الأولى في العالم العربي لإدارة الأعمال والمشاريع بكفاءة ذكاء اصطناعي متطور.');
$copyright = alomran_get_option('tech_footer_copyright', '© 2024 إتقان SaaS. جميع الحقوق محفوظة.');

// Get social links
$social_twitter = alomran_get_option('tech_social_twitter', '');
$social_linkedin = alomran_get_option('tech_social_linkedin', '');
$social_facebook = alomran_get_option('tech_social_facebook', '');
$social_instagram = alomran_get_option('tech_social_instagram', '');

// Get menu items for footer links
$menu_items = array();
$menu_locations = get_nav_menu_locations();

// Try to get footer menu
if (isset($menu_locations['footer']) && $menu_locations['footer'] > 0) {
    $menu = wp_get_nav_menu_object($menu_locations['footer']);
    if ($menu) {
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        // Process menu items to ensure correct URLs
        if ($menu_items && is_array($menu_items)) {
            foreach ($menu_items as $item) {
                // If it's a page link, get the permalink
                if ($item->type === 'post_type' && $item->object === 'page') {
                    $item->url = get_permalink($item->object_id);
                }
                // If it's a custom link starting with /, format it
                elseif ($item->type === 'custom' && !empty($item->url) && strpos($item->url, '/') === 0) {
                    $item->url = alomran_format_url($item->url);
                }
            }
        }
    }
}

// Fallback: If no footer menu, try to get primary menu
if (empty($menu_items) && isset($menu_locations['primary']) && $menu_locations['primary'] > 0) {
    $menu = wp_get_nav_menu_object($menu_locations['primary']);
    if ($menu) {
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        // Process menu items
        if ($menu_items && is_array($menu_items)) {
            foreach ($menu_items as $item) {
                if ($item->type === 'post_type' && $item->object === 'page') {
                    $item->url = get_permalink($item->object_id);
                } elseif ($item->type === 'custom' && !empty($item->url) && strpos($item->url, '/') === 0) {
                    $item->url = alomran_format_url($item->url);
                }
            }
        }
    }
}
?>
<footer class="bg-slate-900 text-slate-300 pt-20 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-2 lg:col-span-1">
                <?php
                // Get first character of logo text
                $logo_first_char = !empty($logo_text) ? mb_substr(trim($logo_text), 0, 1, 'UTF-8') : 'إ';
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg"><?php echo esc_html($logo_first_char); ?></div>
                    <span class="text-2xl font-bold text-white"><?php echo esc_html($logo_text); ?></span>
                </a>
                <p class="text-slate-400 mb-8 max-w-xs">
                    <?php echo esc_html($footer_description); ?>
                </p>
                <div class="flex gap-4">
                    <?php if ($social_twitter) : ?>
                        <a href="<?php echo esc_url($social_twitter); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                            <span class="sr-only">تويتر</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if ($social_linkedin) : ?>
                        <a href="<?php echo esc_url($social_linkedin); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                            <span class="sr-only">لينكد إن</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if ($social_facebook) : ?>
                        <a href="<?php echo esc_url($social_facebook); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                            <span class="sr-only">فيسبوك</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12S0 5.446 0 12.073c0 6.015 4.388 11.01 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if ($social_instagram) : ?>
                        <a href="<?php echo esc_url($social_instagram); ?>" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                            <span class="sr-only">إنستغرام</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.98-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.98-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Links -->
            <?php
            // Get footer menu structure
            $footer_columns = array();
            
            if ($menu_items && is_array($menu_items) && !empty($menu_items)) {
                // Group menu items by parent
                $parent_items = array();
                $child_items = array();
                
                foreach ($menu_items as $item) {
                    // Format URL
                    $menu_url = '';
                    if ($item->type === 'post_type' && $item->object === 'page') {
                        $menu_url = get_permalink($item->object_id);
                    } elseif ($item->type === 'custom') {
                        if (strpos($item->url, '/') === 0) {
                            $menu_url = alomran_format_url($item->url);
                        } elseif (!empty($item->url) && $item->url !== '#') {
                            $menu_url = $item->url;
                        } else {
                            $menu_url = '';
                        }
                    } else {
                        $menu_url = !empty($item->url) ? $item->url : '';
                    }
                    $item->formatted_url = $menu_url;
                    $item->has_valid_url = !empty($menu_url) && $menu_url !== '#';
                    
                    if ($item->menu_item_parent == 0) {
                        $parent_items[] = $item;
                    } else {
                        if (!isset($child_items[$item->menu_item_parent])) {
                            $child_items[$item->menu_item_parent] = array();
                        }
                        $child_items[$item->menu_item_parent][] = $item;
                    }
                }
                
                // Build footer columns from menu (up to 3 columns)
                if (!empty($parent_items)) {
                    $columns = array_slice($parent_items, 0, 3);
                    foreach ($columns as $col_item) {
                        $has_children = isset($child_items[$col_item->ID]) && !empty($child_items[$col_item->ID]);
                        $footer_columns[] = array(
                            'title' => $col_item->title,
                            'url' => $col_item->has_valid_url ? $col_item->formatted_url : '',
                            'children' => $has_children ? $child_items[$col_item->ID] : array(),
                        );
                    }
                }
            }
            
            // Filter out empty columns - Footer is now fully dynamic from WordPress menu
            $footer_columns = array_filter($footer_columns, function($column) {
                return !empty($column['title']) || !empty($column['children']);
            });
            
            // Display footer columns (up to 3 columns as in React app)
            $display_columns = array_slice($footer_columns, 0, 3);
            
            if (!empty($display_columns)) :
                foreach ($display_columns as $column) :
                    $column_title = isset($column['title']) ? $column['title'] : '';
                    $column_url = isset($column['url']) ? $column['url'] : '';
                    $column_children = isset($column['children']) ? $column['children'] : array();
                    
                    // Skip empty columns
                    if (empty($column_title) && empty($column_children)) {
                        continue;
                    }
            ?>
                <div>
                    <?php if (!empty($column_title)) : ?>
                        <h4 class="text-white font-bold mb-6">
                            <?php if (!empty($column_url) && $column_url !== '#') : ?>
                                <a href="<?php echo esc_url($column_url); ?>" class="hover:text-blue-400 transition-colors">
                                    <?php echo esc_html($column_title); ?>
                                </a>
                            <?php else : ?>
                                <?php echo esc_html($column_title); ?>
                            <?php endif; ?>
                        </h4>
                    <?php endif; ?>
                    <?php if (!empty($column_children)) : ?>
                        <ul class="space-y-4">
                            <?php foreach ($column_children as $child) : 
                                $child_title = is_object($child) ? $child->title : (isset($child['title']) ? $child['title'] : '');
                                $child_url = '';
                                
                                if (is_object($child)) {
                                    $child_url = isset($child->formatted_url) ? $child->formatted_url : (isset($child->url) ? $child->url : '');
                                } else {
                                    $child_url_raw = isset($child['url']) ? $child['url'] : '#';
                                    $child_type = isset($child['type']) ? $child['type'] : 'custom';
                                    
                                    if ($child_type === 'page' && !empty($child_url_raw) && $child_url_raw !== '#') {
                                        $child_page_slug = ltrim($child_url_raw, '/');
                                        $child_page = get_page_by_path($child_page_slug);
                                        if ($child_page) {
                                            $child_url = get_permalink($child_page->ID);
                                        } else {
                                            $child_url = alomran_format_url($child_url_raw);
                                        }
                                    } elseif ($child_type === 'custom' && !empty($child_url_raw) && $child_url_raw !== '#') {
                                        if (strpos($child_url_raw, '/') === 0) {
                                            $child_url = alomran_format_url($child_url_raw);
                                        } else {
                                            $child_url = $child_url_raw;
                                        }
                                    } else {
                                        $child_url = $child_url_raw;
                                    }
                                }
                                
                                $child_has_url = !empty($child_url) && $child_url !== '#';
                            ?>
                                <li>
                                    <?php if ($child_has_url) : ?>
                                        <a href="<?php echo esc_url($child_url); ?>" class="text-slate-400 hover:text-blue-400 transition-colors">
                                            <?php echo esc_html($child_title); ?>
                                        </a>
                                    <?php else : ?>
                                        <span class="text-slate-400"><?php echo esc_html($child_title); ?></span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php 
                endforeach;
            endif; // End if !empty($display_columns)
            ?>
        </div>

        <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500">
            <p><?php echo esc_html($copyright); ?></p>
            <p>صنع بكل حب في العالم العربي 🇸🇦 🇦🇪 🇪🇬</p>
        </div>
    </div>
</footer>


