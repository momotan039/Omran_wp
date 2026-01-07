<?php
/**
 * Contact Page Helpers
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render contact info card
 *
 * @param array $args {
 *     @type string $icon_bg    Background color class for icon.
 *     @type string $icon_color Icon color class.
 *     @type string $icon_svg   SVG path for icon.
 *     @type string $title      Card title.
 *     @type string $subtitle   Card subtitle.
 *     @type string $content    Card content (link or text).
 *     @type string $link_url   URL if content is a link.
 *     @type string $link_type  Link type: 'tel', 'mailto', or 'text'.
 *     @type string $delay      Animation delay class.
 * }
 * @return string HTML output.
 */
function alomran_render_contact_card($args) {
    $defaults = array(
        'icon_bg'    => 'bg-gray-100',
        'icon_color' => 'text-gray-700',
        'icon_svg'   => '',
        'title'      => '',
        'subtitle'   => '',
        'content'    => '',
        'link_url'   => '',
        'link_type'  => 'text',
        'delay'      => 'delay-100',
    );
    
    $args = wp_parse_args($args, $defaults);
    
    // Build content HTML
    $content_html = '';
    if (!empty($args['link_url'])) {
        $href = '';
        $classes = 'font-bold text-primary';
        
        switch ($args['link_type']) {
            case 'tel':
                $href = 'tel:' . esc_attr(str_replace(' ', '', $args['link_url']));
                $classes .= ' dir-ltr text-right';
                break;
            case 'mailto':
                $href = 'mailto:' . esc_attr($args['link_url']);
                break;
            default:
                $href = esc_url($args['link_url']);
        }
        
        $content_html = sprintf(
            '<a href="%s" class="%s">%s</a>',
            $href,
            $classes,
            esc_html($args['content'])
        );
    } else {
        $content_html = '<p class="text-gray-600 text-sm leading-relaxed">' . esc_html($args['content']) . '</p>';
    }
    
    return sprintf(
        '<div class="bg-white p-8 rounded-xl shadow-sm flex items-start gap-4 animate-slide-in-right %s hover:shadow-md transition">
            <div class="%s p-3 rounded-lg %s">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    %s
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-lg mb-1">%s</h3>
                <p class="text-gray-500 text-sm mb-2">%s</p>
                %s
            </div>
        </div>',
        esc_attr($args['delay']),
        esc_attr($args['icon_bg']),
        esc_attr($args['icon_color']),
        $args['icon_svg'],
        esc_html($args['title']),
        esc_html($args['subtitle']),
        $content_html
    );
}

