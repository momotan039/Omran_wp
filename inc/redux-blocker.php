<?php
/**
 * ULTIMATE Redux Blocker
 * Prevents Redux Framework from loading ANYWHERE outside admin panel
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * GLOBAL Redux Blocker - Runs at the absolute earliest moment
 * This prevents Redux from loading on frontend completely
 */
function alomran_block_redux_globally() {
    // CRITICAL: Only allow Redux in admin - block everywhere else
    // Check multiple ways to detect admin
    $is_admin_page = is_admin() || 
                     (defined('WP_ADMIN') && WP_ADMIN) ||
                     (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/wp-admin/') !== false) ||
                     (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/wp-login.php') !== false);
    
    if ($is_admin_page) {
        return; // Allow Redux in admin
    }
    
    // Block ALL Redux filters - run at priority 1 (earliest) and 99999 (latest)
    $redux_filters = array(
        'redux/options/alomran_options/output',
        'redux/options/alomran_options/output_tag',
        'redux/options/alomran_options/compiler',
        'redux/options/alomran_options/enqueue',
        'redux/enqueue',
        'redux/register',
        'redux/output',
        'redux/output_tag',
        'redux/compiler',
        'redux/output/enable',
    );
    
    foreach ($redux_filters as $filter) {
        add_filter($filter, '__return_false', 1);
        add_filter($filter, '__return_false', 99999);
    }
    
    // Prevent Redux from hooking into frontend
    add_action('init', function() {
        $priorities = array(1, 10, 50, 100, 150, 200, 999, 9999);
        foreach ($priorities as $priority) {
            remove_action('wp_head', 'redux_output_css', $priority);
            remove_action('wp_footer', 'redux_output_css', $priority);
            remove_action('wp_enqueue_scripts', 'redux_output_css', $priority);
            remove_action('wp_enqueue_scripts', 'redux_enqueue', $priority);
        }
    }, 1);
    
    // Block Redux assets from being enqueued
    add_action('wp_enqueue_scripts', function() {
        // Dequeue all known Redux handles
        $redux_handles = array(
            'redux-framework', 'redux', 'redux-css', 'redux-framework-css',
            'redux-options-css', 'redux-core-css', 'redux-admin-css',
            'redux-elusive-icon', 'redux-elusive-icon-ie7', 'redux-field-css',
            'redux-google-font', 'redux-extensions-css',
            'redux-core', 'redux-extensions', 'redux-ajax', 'redux-js', 'redux-framework-js',
        );
        
        foreach ($redux_handles as $handle) {
            wp_dequeue_style($handle);
            wp_deregister_style($handle);
            wp_dequeue_script($handle);
            wp_deregister_script($handle);
        }
        
        // Scan all registered assets
        global $wp_styles, $wp_scripts;
        
        if (isset($wp_styles->registered)) {
            foreach ($wp_styles->registered as $handle => $style) {
                $handle_lower = strtolower($handle);
                $src = isset($style->src) ? strtolower($style->src) : '';
                if ((strpos($handle_lower, 'redux') !== false || strpos($src, 'redux') !== false) &&
                    strpos($handle_lower, 'admin') === false && strpos($src, 'wp-admin') === false) {
                    wp_dequeue_style($handle);
                    wp_deregister_style($handle);
                }
            }
        }
        
        if (isset($wp_scripts->registered)) {
            foreach ($wp_scripts->registered as $handle => $script) {
                $handle_lower = strtolower($handle);
                $src = isset($script->src) ? strtolower($script->src) : '';
                if ((strpos($handle_lower, 'redux') !== false || strpos($src, 'redux') !== false) &&
                    strpos($handle_lower, 'admin') === false && strpos($src, 'wp-admin') === false) {
                    wp_dequeue_script($handle);
                    wp_deregister_script($handle);
                }
            }
        }
    }, 1);
    
    add_action('wp_enqueue_scripts', function() {
        global $wp_styles, $wp_scripts;
        if (isset($wp_styles->registered)) {
            foreach ($wp_styles->registered as $handle => $style) {
                if (strpos(strtolower($handle), 'redux') !== false && 
                    strpos(strtolower($handle), 'admin') === false) {
                    wp_dequeue_style($handle);
                    wp_deregister_style($handle);
                }
            }
        }
        if (isset($wp_scripts->registered)) {
            foreach ($wp_scripts->registered as $handle => $script) {
                if (strpos(strtolower($handle), 'redux') !== false && 
                    strpos(strtolower($handle), 'admin') === false) {
                    wp_dequeue_script($handle);
                    wp_deregister_script($handle);
                }
            }
        }
    }, 99999);
    
    // Filter style and script tags
    add_filter('style_loader_tag', function($tag, $handle) {
        if (is_admin()) return $tag;
        $handle_lower = strtolower($handle);
        $tag_lower = strtolower($tag);
        if ((strpos($handle_lower, 'redux') !== false || strpos($tag_lower, 'redux') !== false) &&
            strpos($tag_lower, 'admin') === false) {
            return '';
        }
        return $tag;
    }, 99999, 2);
    
    add_filter('script_loader_tag', function($tag, $handle) {
        if (is_admin()) return $tag;
        $handle_lower = strtolower($handle);
        $tag_lower = strtolower($tag);
        if ((strpos($handle_lower, 'redux') !== false || strpos($tag_lower, 'redux') !== false) &&
            strpos($tag_lower, 'admin') === false) {
            return '';
        }
        return $tag;
    }, 99999, 2);
    
    // Block Redux plugin hooks directly
    add_action('plugins_loaded', function() {
        if (is_admin()) return;
        
        // Remove Redux plugin hooks
        global $wp_filter;
        if (isset($wp_filter['wp_head'])) {
            foreach ($wp_filter['wp_head']->callbacks as $priority => $callbacks) {
                foreach ($callbacks as $callback) {
                    if (is_array($callback['function']) && is_object($callback['function'][0])) {
                        $class = get_class($callback['function'][0]);
                        if (strpos($class, 'Redux') !== false) {
                            remove_action('wp_head', $callback['function'], $priority);
                        }
                    } elseif (is_string($callback['function']) && strpos($callback['function'], 'redux') !== false) {
                        remove_action('wp_head', $callback['function'], $priority);
                    }
                }
            }
        }
        
        if (isset($wp_filter['wp_footer'])) {
            foreach ($wp_filter['wp_footer']->callbacks as $priority => $callbacks) {
                foreach ($callbacks as $callback) {
                    if (is_array($callback['function']) && is_object($callback['function'][0])) {
                        $class = get_class($callback['function'][0]);
                        if (strpos($class, 'Redux') !== false) {
                            remove_action('wp_footer', $callback['function'], $priority);
                        }
                    } elseif (is_string($callback['function']) && strpos($callback['function'], 'redux') !== false) {
                        remove_action('wp_footer', $callback['function'], $priority);
                    }
                }
            }
        }
    }, 1);
    
    // Output buffering - final cleanup with comprehensive patterns
    add_action('template_redirect', function() {
        if (is_admin()) return;
        
        ob_start(function($html) {
            if (empty($html)) return $html;
            
            // Skip admin pages
            if (strpos($html, 'wp-admin') !== false || strpos($html, 'admin-bar') !== false) {
                return $html;
            }
            
            // Comprehensive Redux removal patterns
            $patterns = array(
                // Remove Redux CSS links
                '/<link[^>]*href=["\'][^"\']*redux[^"\']*["\'][^>]*>/i',
                // Remove Redux inline styles
                '/<style[^>]*>[\s\S]*?redux[\s\S]*?<\/style>/i',
                // Remove Redux scripts
                '/<script[^>]*src=["\'][^"\']*redux[^"\']*["\'][^>]*>.*?<\/script>/is',
                // Remove Redux inline scripts
                '/<script[^>]*>[\s\S]*?redux[\s\S]*?<\/script>/i',
                // Remove Redux meta tags
                '/<meta[^>]*redux[^>]*>/i',
                // Remove Redux data attributes
                '/data-redux[^=]*="[^"]*"/i',
            );
            
            foreach ($patterns as $pattern) {
                $html = preg_replace($pattern, '', $html);
            }
            
            return $html;
        });
    }, 1);
    
    // Shutdown hook - absolute final cleanup
    add_action('shutdown', function() {
        if (is_admin()) return;
        
        // Get final output from all buffer levels
        $levels = ob_get_level();
        for ($i = 0; $i < $levels; $i++) {
            $output = ob_get_contents();
            if ($output && (stripos($output, 'redux') !== false)) {
                // Remove any remaining Redux content with comprehensive patterns
                $patterns = array(
                    '/<link[^>]*redux[^>]*>/i',
                    '/<style[^>]*>[\s\S]*?redux[\s\S]*?<\/style>/i',
                    '/<script[^>]*redux[^>]*>.*?<\/script>/is',
                    '/<link[^>]*href=["\'][^"\']*redux[^"\']*["\'][^>]*>/i',
                );
                
                foreach ($patterns as $pattern) {
                    $output = preg_replace($pattern, '', $output);
                }
                
                ob_end_clean();
                echo $output;
                break;
            }
        }
    }, 99999);
}

// Run at the ABSOLUTE earliest hooks - BEFORE Redux can load
add_action('muplugins_loaded', 'alomran_block_redux_globally', 1);
add_action('plugins_loaded', 'alomran_block_redux_globally', 1);
add_action('after_setup_theme', 'alomran_block_redux_globally', 1);
add_action('init', 'alomran_block_redux_globally', 1);

// EXTRA: Block Redux plugin from enqueuing assets directly
add_action('wp_enqueue_scripts', function() {
    if (is_admin()) return;
    
    // Block Redux plugin hooks
    remove_all_actions('redux/enqueue');
    remove_all_actions('redux/output');
    remove_all_actions('redux/output_tag');
    
    // Block Redux from any plugin that might load it
    global $wp_filter;
    $hooks_to_check = array('wp_head', 'wp_footer', 'wp_enqueue_scripts');
    
    foreach ($hooks_to_check as $hook) {
        if (isset($wp_filter[$hook])) {
            foreach ($wp_filter[$hook]->callbacks as $priority => $callbacks) {
                foreach ($callbacks as $key => $callback) {
                    // Check if callback is Redux-related
                    if (is_array($callback['function'])) {
                        if (is_object($callback['function'][0])) {
                            $class = get_class($callback['function'][0]);
                            if (stripos($class, 'Redux') !== false) {
                                remove_action($hook, $callback['function'], $priority);
                            }
                        }
                    } elseif (is_string($callback['function'])) {
                        if (stripos($callback['function'], 'redux') !== false) {
                            remove_action($hook, $callback['function'], $priority);
                        }
                    }
                }
            }
        }
    }
}, 1);

