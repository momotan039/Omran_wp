<?php
/**
 * Enqueue theme assets.
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * COMPLETE Redux CSS Blocker - Prevent Redux from loading on frontend
 * Redux CSS should ONLY load in admin panel, never on client pages
 */
function alomran_prevent_redux_css() {
    // CRITICAL: Only block on frontend - allow everything in admin
    // Check multiple ways to detect admin
    $is_admin_page = is_admin() || 
                     is_admin_bar_showing() ||
                     (defined('WP_ADMIN') && WP_ADMIN) ||
                     (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/wp-admin/') !== false) ||
                     (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/wp-login.php') !== false);
    
    if ($is_admin_page) {
        return; // Never interfere with admin
    }
    
    // Layer 1: Block Redux filters - MAXIMUM PRIORITY
    add_filter('redux/options/alomran_options/output', '__return_false', 99999);
    add_filter('redux/options/alomran_options/output_tag', '__return_false', 99999);
    add_filter('redux/options/alomran_options/compiler', '__return_false', 99999);
    add_filter('redux/options/alomran_options/enqueue', '__return_false', 99999);
    add_filter('redux/enqueue', '__return_false', 99999);
    add_filter('redux/register', '__return_false', 99999);
    add_filter('redux/output', '__return_false', 99999);
    add_filter('redux/output_tag', '__return_false', 99999);
    add_filter('redux/compiler', '__return_false', 99999);
    add_filter('redux/output/enable', '__return_false', 99999);
    
    // Layer 2: Remove Redux actions at multiple priorities
    $priorities = array(1, 10, 50, 100, 150, 200, 999, 9999);
    foreach ($priorities as $priority) {
        remove_action('wp_head', 'redux_output_css', $priority);
        remove_action('wp_footer', 'redux_output_css', $priority);
        remove_action('wp_enqueue_scripts', 'redux_output_css', $priority);
        remove_action('wp_enqueue_scripts', 'redux_enqueue', $priority);
    }
    
    // Layer 3: Block Redux from enqueuing styles - run early and late
    add_action('wp_enqueue_scripts', function() {
        // All known Redux style handles
        $redux_handles = array(
            'redux-framework',
            'redux',
            'redux-css',
            'redux-framework-css',
            'redux-options-css',
            'redux-core-css',
            'redux-admin-css',
            'redux-elusive-icon',
            'redux-elusive-icon-ie7',
            'redux-field-css',
            'redux-google-font',
            'redux-extensions-css',
        );
        
        foreach ($redux_handles as $handle) {
            wp_dequeue_style($handle);
            wp_deregister_style($handle);
        }
        
        // Scan ALL registered styles for Redux
        global $wp_styles;
        if (isset($wp_styles->registered)) {
            foreach ($wp_styles->registered as $handle => $style) {
                $handle_lower = strtolower($handle);
                $src = isset($style->src) ? strtolower($style->src) : '';
                
                // NEVER touch admin styles
                if (strpos($src, 'wp-admin') !== false || 
                    strpos($src, 'admin-bar') !== false ||
                    strpos($handle_lower, 'admin-bar') !== false ||
                    strpos($handle_lower, 'wp-admin') !== false) {
                    continue;
                }
                
                // Remove ANY Redux styles
                if (strpos($handle_lower, 'redux') !== false || strpos($src, 'redux') !== false) {
                    wp_dequeue_style($handle);
                    wp_deregister_style($handle);
                }
            }
        }
    }, 1); // Run very early
    
    // Also run late to catch anything added after
    add_action('wp_enqueue_scripts', function() {
        global $wp_styles;
        if (isset($wp_styles->registered)) {
            foreach ($wp_styles->registered as $handle => $style) {
                $handle_lower = strtolower($handle);
                if (strpos($handle_lower, 'redux') !== false && 
                    strpos($handle_lower, 'admin') === false) {
                    wp_dequeue_style($handle);
                    wp_deregister_style($handle);
                }
            }
        }
    }, 99999); // Run very late
    
    // Layer 4: Filter style loader tag - remove Redux stylesheets from HTML
    add_filter('style_loader_tag', function($tag, $handle) {
        // NEVER block admin styles
        if (is_admin() || is_admin_bar_showing()) {
            return $tag;
        }
        
        $handle_lower = strtolower($handle);
        $tag_lower = strtolower($tag);
        
        // NEVER touch admin bar or WordPress admin styles
        if (strpos($tag_lower, 'admin-bar') !== false || 
            strpos($tag_lower, 'wp-admin') !== false ||
            strpos($handle_lower, 'admin-bar') !== false ||
            strpos($handle_lower, 'wp-admin') !== false) {
            return $tag;
        }
        
        // Remove ANY Redux stylesheets
        if (strpos($handle_lower, 'redux') !== false || 
            strpos($tag_lower, 'redux') !== false ||
            (strpos($tag_lower, 'href') !== false && strpos($tag_lower, 'redux') !== false)) {
            return ''; // Remove completely
        }
        
        return $tag;
    }, 99999, 2);
    
    // Layer 5: Block Redux from outputting inline CSS in wp_head
    add_action('wp_head', function() {
        // Remove Redux output actions at all priorities
        $priorities = array(1, 10, 50, 100, 150, 200, 999, 9999);
        foreach ($priorities as $priority) {
            remove_action('wp_head', 'redux_output_css', $priority);
            remove_action('wp_head', 'redux_compiler_output', $priority);
        }
        
        // Try to remove instance-specific actions
        if (class_exists('Redux')) {
            try {
                $redux_instance = call_user_func(array('Redux', 'instance'), 'alomran_options');
                if ($redux_instance && is_object($redux_instance)) {
                    foreach ($priorities as $priority) {
                        if (method_exists($redux_instance, 'output_css')) {
                            remove_action('wp_head', array($redux_instance, 'output_css'), $priority);
                        }
                        if (method_exists($redux_instance, 'compiler_output')) {
                            remove_action('wp_head', array($redux_instance, 'compiler_output'), $priority);
                        }
                    }
                }
            } catch (Exception $e) {
                // Redux not initialized - good for frontend
            }
        }
    }, 1);
    
    // Layer 6: Output buffering - ULTRA-AGGRESSIVE final cleanup
    add_action('template_redirect', function() {
        if (is_admin() || is_admin_bar_showing()) {
            return;
        }
        
        // Start output buffering early
        ob_start(function($html) {
            if (empty($html)) {
                return $html;
            }
            
            // Don't modify admin HTML
            if (strpos($html, 'wp-admin') !== false || strpos($html, 'admin-bar') !== false) {
                return $html;
            }
            
            // ULTRA-AGGRESSIVE: Remove Redux inline style tags (comprehensive patterns)
            $style_patterns = array(
                '/<style[^>]*>[\s\S]*?redux[\s\S]*?<\/style>/i',
                '/<style[^>]*id="[^"]*redux[^"]*"[^>]*>.*?<\/style>/is',
                '/<style[^>]*data-redux[^>]*>.*?<\/style>/is',
                '/<style[^>]*class="[^"]*redux[^"]*"[^>]*>.*?<\/style>/is',
                '/<style[^>]*>[\s\S]*?alomran_options[\s\S]*?<\/style>/i',
                '/<style[^>]*type="text\/css"[^>]*>[\s\S]*?redux[\s\S]*?<\/style>/is',
            );
            
            foreach ($style_patterns as $pattern) {
                $html = preg_replace($pattern, '', $html);
            }
            
            // ULTRA-AGGRESSIVE: Remove Redux CSS file links (comprehensive patterns)
            $link_patterns = array(
                '/<link[^>]*href="[^"]*redux[^"]*"[^>]*>/i',
                '/<link[^>]*id="[^"]*redux[^"]*"[^>]*>/i',
                '/<link[^>]*rel="stylesheet"[^>]*redux[^>]*>/i',
                '/<link[^>]*type="text\/css"[^>]*redux[^>]*>/i',
                '/<link[^>]*href="[^"]*redux[^"]*\.css[^"]*"[^>]*>/i',
                '/<link[^>]*class="[^"]*redux[^"]*"[^>]*>/i',
            );
            
            foreach ($link_patterns as $pattern) {
                $html = preg_replace($pattern, '', $html);
            }
            
            // Remove Redux JavaScript files
            $html = preg_replace('/<script[^>]*src="[^"]*redux[^"]*"[^>]*>.*?<\/script>/is', '', $html);
            $html = preg_replace('/<script[^>]*id="[^"]*redux[^"]*"[^>]*>.*?<\/script>/is', '', $html);
            
            return $html;
        });
    }, 1);
    
    // Layer 7: wp_footer cleanup - catch anything output in footer
    add_action('wp_footer', function() {
        // Remove any Redux output actions from footer
        $priorities = array(1, 10, 50, 100, 999, 9999);
        foreach ($priorities as $priority) {
            remove_action('wp_footer', 'redux_output_css', $priority);
        }
    }, 1);
    
    // Layer 7: Block Redux scripts as well
    add_action('wp_enqueue_scripts', function() {
        $redux_scripts = array(
            'redux-core',
            'redux',
            'redux-extensions',
            'redux-ajax',
            'redux-js',
            'redux-framework-js',
        );
        
        foreach ($redux_scripts as $handle) {
            wp_dequeue_script($handle);
            wp_deregister_script($handle);
        }
        
        // Scan all registered scripts
        global $wp_scripts;
        if (isset($wp_scripts->registered)) {
            foreach ($wp_scripts->registered as $handle => $script) {
                $handle_lower = strtolower($handle);
                $src = isset($script->src) ? strtolower($script->src) : '';
                
                if (strpos($handle_lower, 'redux') !== false && 
                    strpos($handle_lower, 'admin') === false &&
                    (strpos($src, 'redux') !== false && strpos($src, 'wp-admin') === false)) {
                    wp_dequeue_script($handle);
                    wp_deregister_script($handle);
                }
            }
        }
    }, 99999);
    
    // Layer 8: Filter script loader tag
    add_filter('script_loader_tag', function($tag, $handle) {
        if (is_admin() || is_admin_bar_showing()) {
            return $tag;
        }
        
        $handle_lower = strtolower($handle);
        $tag_lower = strtolower($tag);
        
        if (strpos($tag_lower, 'admin-bar') !== false || 
            strpos($tag_lower, 'wp-admin') !== false ||
            strpos($handle_lower, 'admin-bar') !== false ||
            strpos($handle_lower, 'wp-admin') !== false) {
            return $tag;
        }
        
        if (strpos($handle_lower, 'redux') !== false || 
            strpos($tag_lower, 'redux') !== false) {
            return ''; // Remove completely
        }
        
        return $tag;
    }, 99999, 2);
    
    // Layer 9: Shutdown hook - absolute final cleanup
    add_action('shutdown', function() {
        if (is_admin() || is_admin_bar_showing()) {
            return;
        }
        
        $output = ob_get_contents();
        if ($output && (stripos($output, 'redux') !== false)) {
            // Remove any remaining Redux content
            $patterns = array(
                '/<link[^>]*redux[^>]*>/i',
                '/<style[^>]*>[\s\S]*?redux[\s\S]*?<\/style>/i',
                '/<script[^>]*redux[^>]*>.*?<\/script>/is',
            );
            
            foreach ($patterns as $pattern) {
                $output = preg_replace($pattern, '', $output);
            }
            
            ob_end_clean();
            echo $output;
        }
    }, 99999);
}
// Run at multiple hooks for maximum coverage - EARLIEST POSSIBLE
// Run at the ABSOLUTE earliest hooks to catch Redux before it loads
add_action('muplugins_loaded', 'alomran_prevent_redux_css', 1); // Very early
add_action('plugins_loaded', 'alomran_prevent_redux_css', 1);
add_action('after_setup_theme', 'alomran_prevent_redux_css', 1);
add_action('init', 'alomran_prevent_redux_css', 1);
add_action('wp', 'alomran_prevent_redux_css', 1);
add_action('template_redirect', 'alomran_prevent_redux_css', 1); // Right before template loads

/**
 * Enqueue theme styles and scripts
 * Note: Redux CSS output is disabled in redux-config.php (output => false)
 * Additional protection via alomran_prevent_redux_css() above
 */
function alomran_enqueue_assets() {
    // Only enqueue on frontend
    if (is_admin()) {
        return;
    }
    
    $version = defined('ALOMRAN_THEME_VERSION') ? ALOMRAN_THEME_VERSION : wp_get_theme()->get('Version');
    $tailwind_path = get_template_directory() . '/assets/css/tailwind.css';
    $tailwind_uri = get_template_directory_uri() . '/assets/css/tailwind.css';

    // Enqueue styles - ensure proper order
    wp_enqueue_style('alomran-google-fonts', 'https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap', array(), null);
    
    // Register and enqueue Tailwind CSS explicitly - with highest priority
    $tailwind_version = file_exists($tailwind_path) ? filemtime($tailwind_path) : $version;
    wp_register_style('alomran-tailwind', $tailwind_uri, array(), $tailwind_version, 'all');
    
    // Dequeue and re-enqueue to ensure it loads last
    wp_dequeue_style('alomran-tailwind');
    wp_enqueue_style('alomran-tailwind');
    
    // Force Tailwind to load absolutely last - after all other stylesheets
    add_filter('style_loader_tag', function($tag, $handle) use ($tailwind_uri, $tailwind_version) {
        if ($handle === 'alomran-tailwind') {
            return '<link rel="stylesheet" id="alomran-tailwind-css" href="' . esc_url($tailwind_uri) . '?ver=' . esc_attr($tailwind_version) . '" type="text/css" media="all" data-theme="tailwind" data-protected="true" data-priority="99999" />' . "\n";
        }
        return $tag;
    }, 99999, 2);
    
    // Ensure Tailwind loads as the very last stylesheet in wp_head
    add_action('wp_head', function() use ($tailwind_uri, $tailwind_version) {
        // Final cleanup pass - remove any Redux styles that might have slipped through
        global $wp_styles;
        if (isset($wp_styles->queue)) {
            foreach ($wp_styles->queue as $handle) {
                if (strpos(strtolower($handle), 'redux') !== false) {
                    wp_dequeue_style($handle);
                }
            }
        }
        
        // Output Tailwind CSS as the absolute last stylesheet
        echo '<link rel="stylesheet" id="alomran-tailwind-css" href="' . esc_url($tailwind_uri) . '?ver=' . esc_attr($tailwind_version) . '" type="text/css" media="all" data-theme="tailwind" data-protected="true" data-priority="99999" />' . "\n";
    }, 99999);
    
    // Custom CSS depends on Tailwind
    $custom_css_path = get_template_directory() . '/assets/css/custom.css';
    $custom_css_version = file_exists($custom_css_path) ? filemtime($custom_css_path) : $version;
    wp_register_style('alomran-custom', get_template_directory_uri() . '/assets/css/custom.css', array('alomran-tailwind'), $custom_css_version, 'all');
    wp_enqueue_style('alomran-custom');

    // Ensure jQuery is loaded first and in header
    wp_deregister_script('jquery');
    wp_register_script('jquery', includes_url('js/jquery/jquery.min.js'), array(), '3.7.1', false);
    wp_enqueue_script('jquery');

    // Enqueue JavaScript modules in order with proper jQuery dependency
    wp_enqueue_script('alomran-loader', get_template_directory_uri() . '/assets/js/modules/loader.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-mobile-menu', get_template_directory_uri() . '/assets/js/modules/mobile-menu.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-faq', get_template_directory_uri() . '/assets/js/modules/faq.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-contact-form', get_template_directory_uri() . '/assets/js/modules/contact-form.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-animations', get_template_directory_uri() . '/assets/js/modules/animations.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-stats-counter', get_template_directory_uri() . '/assets/js/modules/stats-counter.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-product-gallery', get_template_directory_uri() . '/assets/js/modules/product-gallery.js', array('jquery'), $version, true);
    wp_enqueue_script('alomran-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'alomran-loader', 'alomran-mobile-menu', 'alomran-faq', 'alomran-contact-form', 'alomran-animations', 'alomran-stats-counter', 'alomran-product-gallery'), $version, true);
    wp_enqueue_script('alomran-chat-widget', get_template_directory_uri() . '/assets/js/chat-widget.js', array('jquery'), $version, true);

    // Localize scripts
    $localized_data = array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('alomran-nonce')
    );
    wp_localize_script('alomran-contact-form', 'alomranAjax', $localized_data);
    wp_localize_script('alomran-chat-widget', 'alomranAjax', $localized_data);
}
add_action('wp_enqueue_scripts', 'alomran_enqueue_assets', 5);

/**
 * Ensure jQuery loads in header before all other scripts
 */
function alomran_ensure_jquery_header() {
    global $wp_scripts;
    
    if (isset($wp_scripts->registered['jquery'])) {
        $wp_scripts->registered['jquery']->extra['group'] = 0;
    }
}
add_action('wp_enqueue_scripts', 'alomran_ensure_jquery_header', 20);
