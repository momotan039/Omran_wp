<?php
/**
 * Fix Page Templates
 * 
 * This script fixes page templates for existing pages
 * Run this once to update all pages with correct templates
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Fix page templates for existing pages
 * Maps page slugs to their templates
 */
function omran_fix_page_templates() {
    $page_template_map = array(
        'about' => 'page-about.php',
        'services' => 'page-services.php',
        'projects' => 'page-projects.php',
        'contact' => 'page-contact.php',
        'faq' => 'page-faq.php',
        'testimonials' => 'page-testimonials.php',
        'privacy-policy' => 'page-privacy-policy.php',
        'terms' => 'page-terms.php',
    );
    
    $fixed = 0;
    $errors = array();
    
    foreach ($page_template_map as $slug => $template) {
        $page = get_page_by_path($slug, OBJECT, 'page');
        
        if (!$page) {
            continue;
        }
        
        $current_template = get_post_meta($page->ID, '_wp_page_template', true);
        
        // Only update if template is not set or is default
        if (empty($current_template) || $current_template === 'default') {
            $result = update_post_meta($page->ID, '_wp_page_template', $template);
            
            if ($result) {
                $fixed++;
            } else {
                $errors[] = sprintf('Failed to update template for page "%s" (ID: %d)', $slug, $page->ID);
            }
        }
    }
    
    return array(
        'fixed' => $fixed,
        'errors' => $errors,
    );
}

// Auto-run on admin init (always check and fix)
add_action('admin_init', function() {
    // Always check and fix templates (not just once)
    $result = omran_fix_page_templates();
    
    if (defined('WP_DEBUG') && WP_DEBUG && $result['fixed'] > 0) {
        error_log(sprintf('Fixed %d page templates. Errors: %s', $result['fixed'], count($result['errors'])));
    }
}, 1);

// Also run on frontend page load to ensure templates are set
add_action('template_redirect', function() {
    if (is_page()) {
        global $post;
        if (is_a($post, 'WP_Post')) {
            $current_template = get_post_meta($post->ID, '_wp_page_template', true);
            $page_slug = $post->post_name;
            
            // If no template set, try to set it based on slug
            if (empty($current_template) || $current_template === 'default') {
                $page_template_map = array(
                    'about' => 'page-about.php',
                    'services' => 'page-services.php',
                    'projects' => 'page-projects.php',
                    'contact' => 'page-contact.php',
                    'faq' => 'page-faq.php',
                    'testimonials' => 'page-testimonials.php',
                    'privacy-policy' => 'page-privacy-policy.php',
                    'terms' => 'page-terms.php',
                );
                
                if (!empty($page_slug) && isset($page_template_map[$page_slug])) {
                    $preset_dir = AlOmran_Preset_Loader::get_preset_dir('industrial');
                    if ($preset_dir) {
                        $template_path = trailingslashit($preset_dir) . 'templates/' . $page_template_map[$page_slug];
                        if (file_exists($template_path)) {
                            update_post_meta($post->ID, '_wp_page_template', $page_template_map[$page_slug]);
                        }
                    }
                }
            }
        }
    }
}, 1);

